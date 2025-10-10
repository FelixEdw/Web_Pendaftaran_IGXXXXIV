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
    $traceId = 'GS-' . now()->format('Ymd-His-v') . '-' . bin2hex(random_bytes(3));
    Log::info("[$traceId] === MULAI gantisesi ===");

    $validated = $request->validate([
        'session_id' => 'required|exists:tsession,id',
    ]);
    $newId = (int) $validated['session_id'];

    // Sesi aktif sebelum diubah
    $prevActive = Session::where('jenis_sesi', 1)->first();
    $prevActiveId = $prevActive ? (int)$prevActive->id : null;
    Log::info("[$traceId] PrevActiveID=" . ($prevActiveId ?? 'NULL') . " -> NewID={$newId}");

    // Update status sesi dalam transaksi
    DB::transaction(function () use ($newId) {
        Session::where('jenis_sesi', 1)->update(['jenis_sesi' => 0]);
        Session::where('id', $newId)->update(['jenis_sesi' => 1]);
    });

    // Jika berpindah DARI 5 ke sesi lain → SKIP perhitungan poin
    if ($prevActiveId == 5 || $newId == 5) {
        Log::info("[$traceId] Pindah dari 5 ke {$newId} -> SKIP perhitungan poin");
        return redirect()
            ->route('admin.rally-2.index')
            ->with('success', "Sesi diubah dari BERHENTI ke sesi {$newId}. Perhitungan poin dilewati.");
    }

    // --- Perhitungan poin normal (untuk kasus selain di atas) ---
    $sesiBaru = Session::find($newId);
    if (!$sesiBaru) {
        Log::warning("[$traceId] Sesi baru {$newId} tidak ditemukan");
        return redirect()
            ->route('admin.rally-2.index')
            ->with('error', 'Sesi baru tidak ditemukan.');
    }

    Log::info("[$traceId] Ganti ke sesi {$sesiBaru->id} | durasi={$sesiBaru->durasi} | demand={$sesiBaru->demand}");

    $durasiSesi = $sesiBaru->durasi ?? 35;
    $demand     = $sesiBaru->demand ?? 30;

    $teams = Team::all();
    foreach ($teams as $team) {
        try {
            $startTeam = microtime(true);
            Log::info("[$traceId] --- TIM {$team->id} ({$team->nama}) ---");

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
            $team->save();

            Log::debug("[$traceId] TIM {$team->id} | mesin_count={$teamMachines->count()} | harga_unlock={$team->harga_unlock}");

            // Ambil koneksi mesin sesuai tim
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

            Log::debug("[$traceId] TIM {$team->id} | conn_count={$connmachine->count()}");

            if ($connmachine->isNotEmpty() && $teamMachines->isNotEmpty()) {
                $productionResult = $this->calculateProductionFlow($connmachine, $teamMachines, $durasiSesi, $traceId, $team->id);

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
                $totalProdukSetelahQC = (int) floor($totalProduk * (1 - $penalty));

                Log::info("[$traceId] TIM {$team->id} | totalProdukRaw={$totalProduk} | QClevel={$levelQC} | penalty={$penalty} => totalProdukAfterQC={$totalProdukSetelahQC}");

                // Kolom sepeda berdasarkan sesi sebelumnya (defensive)
                $sepedaCol = null;
                if ($prevActiveId !== null) {
                    $sepedaCol = match ((int) $prevActiveId) {
                        1 => 'sepeda_sesi1',
                        2 => 'sepeda_sesi2',
                        3 => 'sepeda_sesi3',
                        4 => 'sepeda_sesi4',
                        default => null,
                    };
                }
                if ($sepedaCol) {
                    $team->$sepedaCol = $totalProdukSetelahQC;
                    Log::debug("[$traceId] TIM {$team->id} | set {$sepedaCol}={$totalProdukSetelahQC}");
                }

                $uangSebelum = (int) ($team->total_uang_babak2 ?? 0);
                $poinDariUang = (int) floor($uangSebelum / 10000);

                $waktuTerhubung = $this->hitungWaktuTotalTerhubung($connmachine, $teamMachines, $productionResult, $traceId, $team->id);
                // --- HITUNG LAJU PER MENIT MESIN TERAKHIR (END NODE) YANG VALID ---
                $validEndNodeIds = [];
                foreach ($productionResult as $r) {
                    if (!empty($r['status'])) {            // end node dengan jalur 1-2-3-4 valid
                        $validEndNodeIds[] = (int)$r['tmachine_id'];
                    }
                }
                $validEndNodeIds = array_values(array_unique($validEndNodeIds));

                // ∑ (kapasitas_dasar / base_time) untuk setiap end node valid yang dimiliki tim
                $endRatePerMinute = 0.0;
                if (!empty($validEndNodeIds)) {
                    foreach ($teamMachines as $tm) {
                        if (in_array((int)$tm->tmachine_id, $validEndNodeIds, true)) {
                            $bt = max(1, (int)$tm->base_time); // aman dari div-by-zero
                            $cap = (int)$tm->kapasitas_dasar;
                            $endRatePerMinute += ($cap / $bt); // unit per menit
                        }
                    }
                }
                Log::info("[$traceId] TIM {$team->id} | endNodesValid=" . json_encode($validEndNodeIds) . " | endRatePerMinute=" . number_format($endRatePerMinute, 4));

                $base = 0; $baseFloat = 0.0;
                if ($waktuTerhubung > 0 && $endRatePerMinute > 0) {
                    // Rumus final:
                    // baseFloat = TOTAL_DURASI / ( (WAKTU_TERHUBUNG / 4) * (TOTAL LAJU PER MENIT MESIN TERAKHIR) )
                    $baseFloat = $durasiSesi / ( ($waktuTerhubung / 4.0) * $endRatePerMinute );
                    $base = (int) floor($baseFloat);
                }
                // Inventory
                $inventoryBaru = 0;
                if ($totalProdukSetelahQC > $demand) {
                    $inventoryBaru = $totalProdukSetelahQC - $demand;
                }
                $team->inventory_babak_2 = $inventoryBaru;

                // Bonus khusus sesi id=2
                $deltaPoin = ($base + $poinDariUang);
                if ((int) $sesiBaru->id == 2) {
                    $deltaPoin = (int) floor($base * 1.5) + $poinDariUang;
                }

                $poinSebelum = (int) ($team->poin_total_babak2 ?? 0);
                $team->poin_total_babak2 = $poinSebelum + $deltaPoin;
                $team->save();

                    Log::info("[$traceId] TIM {$team->id} => durasiSesi={$durasiSesi}, demand={$demand}, waktuTerhubung={$waktuTerhubung}, baseFloat=" . number_format($baseFloat, 4) . ", base={$base}, poinDariUang={$poinDariUang}, deltaPoin={$deltaPoin}, poinTotal: {$poinSebelum} -> {$team->poin_total_babak2}, inventory={$inventoryBaru}");
            } else {
                Log::warning("[$traceId] TIM {$team->id} | SKIP hitung: conn/mesin kosong (conn={$connmachine->count()}, mesin={$teamMachines->count()})");
            }

            $elapsed = number_format((microtime(true) - $startTeam) * 1000, 2);
            Log::debug("[$traceId] --- END TIM {$team->id} ({$elapsed} ms) ---");

        } catch (\Throwable $e) {
            Log::error("[$traceId] ERROR TIM {$team->id}: {$e->getMessage()} at {$e->getFile()}:{$e->getLine()}");
        }
    }

    Log::info("[$traceId] === SELESAI gantisesi ===");

    return redirect()->route('admin.rally-2.index')
        ->with('success', 'Sesi berhasil diperbarui dan poin dihitung ulang!');
}

/**
 * Hitung total waktu (base_time) semua mesin yang terhubung ke mesin terakhir (end node).
 * Mengumpulkan mesin_1, mesin_2, mesin_3 + end node, lalu menjumlah base_time dari tteammachine tim tsb.
 */
private function hitungWaktuTotalTerhubung($connmachine, $teamMachines, $productionResult, string $traceId, int $teamId)
{
    // Kumpulkan tmachine_id end node yang valid (status=true)
    $endNodes = [];
    foreach ($productionResult as $r) {
        if (!empty($r['status'])) {
            $endNodes[] = $r['tmachine_id'];
        }
    }
    $endNodes = array_values(array_unique($endNodes));
    Log::debug("[$traceId] TIM {$teamId} | endNodes=" . json_encode($endNodes));
    if (empty($endNodes)) return 0;

    // Build set semua node yang terlibat (mesin_1,2,3 dan end node)
    $involved = [];
    foreach ($endNodes as $endId) {
        $mesin_3 = [];
        $mesin_2 = [];
        $mesin_1 = [];

        foreach ($connmachine as $c) {
            if ($c->target_tmachine_id == $endId) {
                $mesin_3[] = $c->source_tmachine_id;
            }
        }
        foreach ($connmachine as $c) {
            if (in_array($c->target_tmachine_id, $mesin_3)) {
                $mesin_2[] = $c->source_tmachine_id;
            }
        }
        foreach ($connmachine as $c) {
            if (in_array($c->target_tmachine_id, $mesin_2)) {
                $mesin_1[] = $c->source_tmachine_id;
            }
        }

        $involved = array_merge($involved, [$endId], $mesin_3, $mesin_2, $mesin_1);
    }

    $involved = array_values(array_unique($involved));
    Log::debug("[$traceId] TIM {$teamId} | involvedNodes=" . json_encode($involved));
    if (empty($involved)) return 0;

    // Peta base_time per tmachine_id dari koleksi tteammachine milik tim
    $sum = 0;
    foreach ($teamMachines as $tm) {
        if (in_array($tm->tmachine_id, $involved)) {
            $sum += (int)($tm->base_time ?? 0);
        }
    }
    
    Log::debug("[$traceId] TIM {$teamId} | waktuTerhubung(sum base_time involved)={$sum}");
    return $sum;
}

private function calculateProductionFlow($connmachine, $teamMachines, $durasiSesi, string $traceId, int $teamId)
{
    $hasilProduksi = [];

    foreach ($teamMachines as $tm) {
        $baseTime = max(1, (int)$tm->base_time); // hindari div-by-zero
        $kapasitas = (int)$tm->kapasitas_dasar;
        $produksi = (int) floor($durasiSesi / $baseTime) * $kapasitas;

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
                'jumlah_produksi' => (int)$jumlah,
                "status" => false
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

        Log::debug("[$traceId] TIM {$teamId} | TMID: {$out['tmachine_id']} | jml={$out['jumlah_produksi']} | M3=" . json_encode($mesin_3) . " | M2=" . json_encode($mesin_2) . " | M1=" . json_encode($mesin_1) . " | status=" . ($output[$index]['status'] ? '1' : '0'));
    }

    // Rekap kecil
    $rekap = [];
    foreach ($output as $o) {
        $rekap[] = [
            'id' => $o['tmachine_id'],
            'qty' => $o['jumlah_produksi'],
            'ok' => (int)!empty($o['status'])
        ];
    }
    Log::info("[$traceId] TIM {$teamId} | produksi_endnodes=" . json_encode($rekap));

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
