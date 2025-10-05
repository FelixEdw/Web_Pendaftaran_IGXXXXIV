<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Team;
use App\Models\TeamMachine;
use Illuminate\Support\Facades\Storage; 


use App\Models\ConnectMachine;
use DB;
use Illuminate\Http\Request;
use Log;

class AdminController extends Controller
{
    public function rally1()
    {
        return view('admin.rally-1.index');
    }
    public function rally2()
    {
        $teams = Team::orderByDesc('poin_total_babak2')->get();
        $activeSession = DB::table('tsession')
            ->where('jenis_sesi', 1)
            ->latest('id')
            ->first();

        // Ambil semua sesi untuk select box
        $allSessions = DB::table('tsession')->get();

        return view('admin.rally-2.index', compact('teams', 'activeSession', 'allSessions'));
        
    }
public function gantisesi(Request $request)
{
    $validated = $request->validate([
        'session_id' => 'required|exists:tsession,id',
    ]);
    $newId = (int) $validated['session_id'];

    // Sesi aktif sebelum diubah
    $prevActive = Session::where('jenis_sesi', 1)->first();

    // Update status sesi dalam transaksi
    DB::transaction(function () use ($newId) {
        Session::where('jenis_sesi', 1)->update(['jenis_sesi' => 0]);
        Session::where('id', $newId)->update(['jenis_sesi' => 1]);
    });

    // Jika berpindah DARI 5 ke sesi lain → SKIP perhitungan poin
    if ($prevActive && (int) $prevActive->id == 5 && $newId != 5) {
        return redirect()
            ->route('admin.rally-2.index')
            ->with('success', "Sesi diubah dari BERHENTI ke sesi {$newId}. Perhitungan poin dilewati.");
    }

    // --- Perhitungan poin normal (untuk kasus selain di atas) ---
    $sesiBaru = Session::find($newId);
    if (!$sesiBaru) {
        return redirect()
            ->route('admin.rally-2.index')
            ->with('error', 'Sesi baru tidak ditemukan.');
    }

    Log::info("Ganti ke sesi {$sesiBaru->id} | durasi={$sesiBaru->durasi} | demand={$sesiBaru->demand}");

    $durasiSesi = $sesiBaru->durasi ?? 35;
    $demand     = $sesiBaru->demand ?? 30;

    $teams = Team::all();
    foreach ($teams as $team) {
        // Reset unlock + hitung maintenance
        $teamMachines = TeamMachine::where('team_id', $team->id)->get();
        $maintenanceCost        = 2500;
        $totalHargaMaintenance  = $teamMachines->count() * $maintenanceCost;

        $team->unlocked_babak2 = 0;
        if ((int) $sesiBaru->id == 3) {
            $team->harga_unlock = $totalHargaMaintenance * 1.5;
        } else {
            $team->harga_unlock = $totalHargaMaintenance;
        }

        // Ambil koneksi mesin sesuai tim (bukan hardcode 1)
        $connmachine = DB::table('tconnectmachine as cm')
            ->join('tteammachine as src', 'cm.source_team_machine_id', '=', 'src.id')
            ->join('tteammachine as tgt', 'cm.target_team_machine_id', '=', 'tgt.id')
            ->join('tmachine as tm_src', 'src.tmachine_id', '=', 'tm_src.id')
            ->join('tmachine as tm_tgt', 'tgt.tmachine_id', '=', 'tm_tgt.id')
            ->where('cm.team_id', $team->id)
            ->select([
                'cm.id',
                'src.tmachine_id as source_tmachine_id',
                'tm_src.jenis as source_jenis',
                'tgt.tmachine_id as target_tmachine_id',
                'tm_tgt.jenis as target_jenis',
            ])
            ->orderBy('cm.id')
            ->get();

        if ($connmachine->isNotEmpty() && $teamMachines->isNotEmpty()) {
            $productionResult = $this->calculateProductionFlow($connmachine, $teamMachines, $durasiSesi);

            // Akumulasi produksi valid
            $totalProduk = 0;
            foreach ($productionResult as $result) {
                if (!empty($result['status'])) {
                    $totalProduk += (int) ($result['jumlah_produksi'] ?? 0);
                }
            }

            // Terapkan penalti kualitas SEKALI (bukan di dalam loop)
            $levelQC   = (int) ($team->level_mesin_quality ?? 1);
            $penaltyMap = [1 => 0.20, 2 => 0.10, 3 => 0.00];
            $penalty    = $penaltyMap[$levelQC] ?? 0.20;
            $totalProduk = (int) floor($totalProduk * (1 - $penalty));

            $sepedaCol = match ((int) $prevActive->id) {
                    1 => 'sepeda_sesi1',
                    2 => 'sepeda_sesi2',
                    3 => 'sepeda_sesi3',
                    4 => 'sepeda_sesi4',
                    default => null,
                };

                if ($sepedaCol) {
                    // Opsi A (overwrite hasil sesi ini):
                    $team->$sepedaCol = $totalProduk;

                }
            $uang = (int) ($team->total_uang_babak2 ?? 0);
            $poin = (int) floor($uang / 10000);

            if ($totalProduk > $demand) {
                $sisa = $totalProduk - $demand;
                $team->inventory_babak_2 = $sisa;
                $base = $demand + $poin;
            } else {
                $team->inventory_babak_2 = 0;
                $base = $totalProduk + $poin;
            }

            // Bonus khusus sesi id=2
            if ((int) $sesiBaru->id == 2) {
                $team->poin_total_babak2 += $base * 1.5;
            } else {
                $team->poin_total_babak2 += $base;
            }

            $team->save();
        }
    }

    return redirect()->route('admin.rally-2.index')
        ->with('success', 'Sesi berhasil diperbarui dan poin dihitung ulang!');
}
private function calculateProductionFlow($connmachine, $teamMachines, $durasiSesi)
{
    $hasilProduksi = [];

    foreach ($teamMachines as $tm) {
        $produksi = floor($durasiSesi / $tm->base_time) * $tm->kapasitas_dasar;

        if (!isset($hasilProduksi[$tm->tmachine_id])) {
            $hasilProduksi[$tm->tmachine_id] = 0;
        }

        $hasilProduksi[$tm->tmachine_id] += $produksi;
    }

    // Daftar tmachine_id yang ingin disimpan
    $filteredIds = [4, 8, 12, 16];

    $output = [];
    foreach ($hasilProduksi as $tmachine_id => $jumlah) {
        if (in_array($tmachine_id, $filteredIds)) {
            $output[] = [
                'tmachine_id' => $tmachine_id,
                'jumlah_produksi' => $jumlah,
                "status" =>false
            ];
        }
    }
    
    foreach ($output as $index => $out) {
        $mesin_3 = [];
        $mesin_2 = [];
        $mesin_1 = [];

        foreach ($connmachine as $conn) {
            if ($conn->target_tmachine_id == $out['tmachine_id']) {
                $mesin_3[] = $conn->source_tmachine_id;
            }
        }

        foreach ($connmachine as $conn) {
            if (in_array($conn->target_tmachine_id, $mesin_3)) {
                $mesin_2[] = $conn->source_tmachine_id;
            }
        }

        foreach ($connmachine as $conn) {
            if (in_array($conn->target_tmachine_id, $mesin_2)) {
                $mesin_1[] = $conn->source_tmachine_id;
                $output[$index]['status'] = true;
                break;
            }
        }

        // Optional log/debug
        Log::info("=== TMID: {$out['tmachine_id']} ===");
        Log::info("Mesin 3: " . implode(", ", $mesin_3));
        Log::info("Mesin 2: " . implode(", ", $mesin_2));
        Log::info("Mesin 1: " . implode(", ", $mesin_1));
        Log::info("Status: " . ($output[$index]['status'] ? '✅' : '❌'));
    }

    return $output;
}

public function registrationDashboard()
{
    // Ambil semua tim beserta data anggotanya, urutkan dari yang terbaru
    $teams = Team::with('members')->orderBy('created_at', 'desc')->get();
    
    // Tampilkan view baru dengan membawa data tim
    return view('admin.registration_dashboard', compact('teams'));
}

public function verifyPayment(Team $team)
{
    // Ubah status verifikasi menjadi true (terverifikasi)
    $team->update(['ver_bukti_bayar' => true]);
    
    return redirect()->route('admin.regis.dashboard')->with('success', 'Tim ' . $team->nama_tim . ' berhasil diverifikasi.');
}

public function unverifyPayment(Team $team)
{
    // Ubah status verifikasi menjadi false (belum terverifikasi)
    $team->update(['ver_bukti_bayar' => false]);

    return redirect()->route('admin.regis.dashboard')->with('success', 'Status verifikasi tim ' . $team->nama_tim . ' berhasil diubah menjadi Unverified.');
}

}
