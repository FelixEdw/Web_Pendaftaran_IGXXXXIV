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
    $request->validate([
        'session_id' => 'required|exists:tsession,id'
    ]);

    $sesi = Session::where('jenis_sesi', 1)->first();

    // 1. Nonaktifkan semua sesi
    Session::where('jenis_sesi', 1)->update(['jenis_sesi' => 0]);

    // 2. Aktifkan sesi yang dipilih
    Session::where('id', $request->session_id)->update(['jenis_sesi' => 1]);

    // 3. Ambil durasi sesi yang dipilih (dalam menit)
    Log::info(" sesi = " . $sesi);
    $durasiSesi = $sesi->durasi ?? 35;
    $demand = $sesi->demand ?? 30;

    // 4. Proses semua tim
    $teams = Team::all();
    foreach ($teams as $team) {
        // Reset unlock dan hitung harga maintenance
        $teamMachines = TeamMachine::where('team_id', $team->id)->get();
        $maintenanceCost = 2500;
        $totalHargaMaintenance = count($teamMachines) * $maintenanceCost;

        $team->unlocked_babak2 = 0;
        if( $sesi->id == "3"){
            $team->harga_unlock = $totalHargaMaintenance * 1.5;
        }
        else{
            $team->harga_unlock = $totalHargaMaintenance;
        }
        
        

        // Ambil koneksi mesin dan data mesin
        $connmachine = DB::table('tconnectmachine as cm')
            ->join('tteammachine as src', 'cm.source_team_machine_id', '=', 'src.id')
            ->join('tteammachine as src2', 'cm.target_team_machine_id', '=', 'src2.id')
            ->join('tmachine as tm_tgt', 'src.tmachine_id', '=', 'tm_tgt.id')
            ->join('tmachine as tm_tgt2', 'src2.tmachine_id', '=', 'tm_tgt2.id')
            ->where('cm.team_id', 1)
            ->select([
                'cm.id',
                'src.tmachine_id as source_tmachine_id',
                'tm_tgt.jenis as source_jenis',
                'src2.tmachine_id as target_tmachine_id',
                'tm_tgt2.jenis as target_jenis',
            ])
            ->orderBy('cm.id')
            ->get();

        if ($connmachine->isNotEmpty() && $teamMachines->isNotEmpty()) {
            $productionResult = $this->calculateProductionFlow($connmachine, $teamMachines, $durasiSesi);
            $totalProduk = 0;
            foreach ($productionResult as $result) {
                if ($result['status'] === true) {
                    $totalProduk += $result['jumlah_produksi'];
                }
            }
        

            if($totalProduk > $demand){
                $totalProduk -= $demand;
                $team->inventory_babak_2 = $totalProduk;
                $uang = $team->total_uang_babak2;
                $poin = floor($uang / 10000);
                if($sesi->id == "2"){
                    $team->poin_total_babak2 += ($demand + $poin) * 1.5;
                }
                else{
                    $team->poin_total_babak2 += $demand + $poin;
                }
                
            }
            else{
                $uang = $team->total_uang_babak2;
                $poin = floor($uang / 10000);
                
                if( $sesi->id == "2"){
                    $team->poin_total_babak2 += ($totalProduk + $poin) * 1.5;
                    Log::info($poin . "   ". $uang .  "   "    . $sesi . "  "  .  $totalProduk );
                }
                else{
                   $team->poin_total_babak2 += $totalProduk + $poin;
                }
                
            }
            $team->save();

        }
    }

    return redirect()->route('admin.rally-2.index') // Ganti dengan route tujuan
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
