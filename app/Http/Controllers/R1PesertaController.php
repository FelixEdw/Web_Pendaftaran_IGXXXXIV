<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


class R1PesertaController extends Controller
{
    private $sesiHarga = [
        1 => ['city' => 40, 'folding' => 75, 'mountain' => 60],
        2 => ['city' => 45, 'folding' => 80, 'mountain' => 65],
        3 => ['city' => 40, 'folding' => 75, 'mountain' => 60, 'unicycle' => 30],
        4 => ['city' => 30, 'folding' => 55, 'mountain' => 45, 'unicycle' => 20],
    ];

    private $posKomponen = [
        1 => ['wheel_26' => 1],
        2 => ['city_frame' => 1],
        3 => ['basket' => 1],
        4 => ['wheel_16' => 1],
        5 => ['folding_frame' => 1],
        6 => ['hinge' => 1],
        7 => ['mountain_frame' => 1],
        8 => ['mountain_suspension' => 1],
        9 => ['unicycle_frame' => 1],
        10 => ['brake' => 1],
        11 => ['pedal' => 1],
        12 => ['chain_and_gear' => 1],
    ];

    public function updateProductionRally($teamId)
    {
        // pastikan ada row production
        $production = DB::table('production_rally1')->where('team_id', $teamId)->first();
        if (!$production) {
            DB::table('production_rally1')->insert([
                'team_id' => $teamId,
                'total_komponen_diperoleh' => 0,
                'total_komponen_terpakai' => 0,
                'output_aktual' => 0,
                'revenue' => 0,
                'production_efficiency' => 0,
                'time_productivity' => 0,
                'performance' => 0,
                'poin_total' => 0
            ]);
            $production = DB::table('production_rally1')->where('team_id', $teamId)->first();
        }

        $komponen = DB::table('komponen')->where('team_id', $teamId)->first();
        $sepeda = DB::table('sepeda')->where('team_id', $teamId)->first();

        $komponenArray = $komponen ? (array) $komponen : [];

        $currentStockSum = array_sum(array_map('intval', $komponenArray));

        $totalTerpakai = (int) ($production->total_komponen_terpakai ?? 0);

        $totalKomponenDiperoleh = $production->total_komponen_diperoleh;

        $outputAktual = (int) ($production->output_aktual ?? 0);

        $revenue = (float) ($production->revenue ?? 0);

        $outputIdeal = 120;

        $production_efficiency = $totalKomponenDiperoleh > 0
            ? ($totalTerpakai / $totalKomponenDiperoleh) * 100
            : 0;

        $time_productivity = $outputIdeal > 0
            ? ($outputAktual / $outputIdeal) * 100
            : 0;

        $performance = (0.6 * $production_efficiency) + (0.4 * $time_productivity);

        $poin_revenue = $revenue / 5;

        $poin_total = round(($poin_revenue * 0.7) + ($performance * 0.3), 2);

        DB::table('production_rally1')->where('team_id', $teamId)->update([
            'total_komponen_diperoleh' => $totalKomponenDiperoleh,
            'total_komponen_terpakai' => $totalTerpakai,
            'output_aktual' => $outputAktual,
            'revenue' => $revenue,
            'production_efficiency' => round($production_efficiency, 4),
            'time_productivity' => round($time_productivity, 4),
            'performance' => round($performance, 4),
            'poin_total' => $poin_total,
        ]);
    }



    public function showPerformance()
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $data = DB::table('production_rally1')
            ->where('team_id', $team->id)
            ->first();

        if (!$data) {
            return back()->with('error', 'Data produksi belum tersedia.');
        }

        return view('peserta.rally-1.performance', compact('data'));
    }


    private function getSesiAktif()
    {
        return DB::table('sesi_rally1')->value('sesi_aktif') ?? 1;
    }



    public function showPos($id)
    {
        $komponen = DB::table('pos_stok')
            ->where('pos_id', $id)
            ->where('jumlah', '>', 0)
            ->get();

        $sesi = $this->getSesiAktif();
        $harga = $this->sesiHarga[$sesi] ?? [];

        return view('pos_peserta', compact('id', 'komponen', 'sesi', 'harga'));
    }

    public function showAllPos()
    {
        return view('pos', ['posKomponen' => $this->posKomponen]);
    }

    public function showProduksi()
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $data = DB::table('komponen')->where('team_id', $team->id)->first();

        $resep = [
            'city' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'city_frame' => 1],
            'folding' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'folding_frame' => 1],
            'mountain' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'mountain_frame' => 1],
            'unicycle' => ['wheel' => 1, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'unicycle_frame' => 1]
        ];

        return view('peserta.rally-1.produksi', compact('data', 'resep'));
    }

    public function produksiSepeda($jenis)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();
        $komponen = DB::table('komponen')->where('team_id', $team->id)->first();

        $resep = [
            'city' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'city_frame' => 1],
            'folding' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'folding_frame' => 1],
            'mountain' => ['wheel' => 2, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'mountain_frame' => 1],
            'unicycle' => ['wheel' => 1, 'brake' => 2, 'pedal' => 2, 'chain_and_gear' => 2, 'unicycle_frame' => 1]
        ];

        if (!isset($resep[$jenis])) {
            return back()->with('error', 'Jenis tidak ditemukan');
        }

        foreach ($resep[$jenis] as $key => $jumlah) {
            if (($komponen->$key ?? 0) < $jumlah) {
                return back()->with('error', "Komponen tidak cukup untuk merakit $jenis");
            }
        }

        foreach ($resep[$jenis] as $key => $jumlah) {
            DB::table('komponen')->where('team_id', $team->id)->decrement($key, $jumlah);
        }

        DB::table('sepeda')->updateOrInsert(
            ['team_id' => $team->id],
            [$jenis => DB::raw("$jenis + 1")]
        );

        $usedCount = array_sum($resep[$jenis]);

        DB::table('production_rally1')->updateOrInsert(
            ['team_id' => $team->id],
            [
                'total_komponen_terpakai' => DB::raw("COALESCE(total_komponen_terpakai, 0) + $usedCount"),
                'total_komponen_diperoleh' => DB::raw("COALESCE(total_komponen_diperoleh, 0)") // pastikan kolom ada
            ]
        );

        DB::table('production_rally1')
            ->where('team_id', $team->id)
            ->update(['output_aktual' => DB::raw('COALESCE(output_aktual, 0) + 1')]);

        $this->updateProductionRally($team->id);

        return back()->with('success', "✅ Berhasil merakit sepeda $jenis");
    }


    public function showJual()
    {
        $timId = Auth::user()->id;
        $stok = DB::table('sepeda')->where('team_id', $timId)->first();

        $sesi = $this->getSesiAktif();
        $harga = $this->sesiHarga[$sesi];

        return view('peserta.rally-1.jual', compact('stok', 'sesi', 'harga'));
    }




    public function daftarPos()
    {
        $tim = Auth::user()->name;


        $posList = DB::table('pos')->get();
        $riwayat = DB::table('riwayat_pos')
            ->where('peserta_namaTim', $tim)
            ->orderByDesc('waktu')
            ->limit(3)
            ->pluck('pos_id')
            ->toArray();

        return view('peserta_pos', compact('posList', 'riwayat', 'tim'));
    }

    public function lihatKomponen()
    {
        $user = Auth::user();
        $timId = $user->id;

        $komponen = DB::table('komponen')
            ->where('team_id', $timId)
            ->first();

        return view('peserta.rally-1.peserta_komponen', [
            'tim' => $user->name,
            'komponen' => $komponen
        ]);
    }




    public function pergiKePos($id)
    {
        $tim = Auth::user()->name;

        // Cek pos ada atau tidak
        $pos = DB::table('pos')->where('id', $id)->first();
        if (!$pos) {
            return back()->with('error', 'Pos tidak ditemukan.');
        }

        // 🚨 Cek apakah tim sedang bermain di pos lain (status = playing hari ini)
        $sedangMain = DB::table('riwayat_pos')
            ->where('peserta_namaTim', $tim)
            ->where('status', 'playing')
            ->whereDate('waktu', today())
            ->exists();

        if ($sedangMain) {
            return back()->with('error', 'Kamu sedang bermain di pos lain. Selesaikan dulu sebelum masuk ke pos baru.');
        }

        // Ambil 3 kunjungan terakhir (kecuali reset)
        $lastVisited = DB::table('riwayat_pos')
            ->where('peserta_namaTim', $tim)
            ->whereNotIn('status', ['reset']) // ⬅️ abaikan reset
            ->orderByDesc('waktu')
            ->limit(3)
            ->pluck('pos_id')
            ->toArray();

        // Kalau pos target masih ada di 3 kunjungan terakhir → tolak
        if (in_array($id, $lastVisited)) {
            return back()->with('error', 'Tidak boleh mengunjungi pos yang sama sebelum mengunjungi 3 pos lain.');
        }

        // Cek apakah tim sudah ada di waiting list pos manapun
        $alreadyWaiting = DB::table('waiting_list_pos')
            ->where('peserta_namaTim', $tim)
            ->exists();

        if ($alreadyWaiting) {
            return back()->with('error', 'Kamu sudah berada di waiting list pos lain. Selesaikan dulu sebelum masuk ke pos baru.');
        }

        // Cek apakah tim sudah ada di waiting list pos ini
        $alreadyInThisPos = DB::table('waiting_list_pos')
            ->where('peserta_namaTim', $tim)
            ->where('pos_id', $id)
            ->exists();

        if ($alreadyInThisPos) {
            return back()->with('error', "Tim $tim sudah ada di waiting list Pos $id.");
        }

        // Cek uang (belum dipotong, hanya validasi)
        $uang = DB::table('teams')->where('nama_Tim', $tim)->value('uang');
        if ($uang < 3) {
            return back()->with('error', 'Uang tidak cukup untuk mengikuti pos.');
        }

        // Masukkan ke waiting list (tanpa potong uang dulu)
        DB::table('waiting_list_pos')->insert([
            'peserta_namaTim' => $tim,
            'pos_id' => $id
        ]);

        return back()->with('success', "Tim $tim berhasil masuk ke waiting list Pos $id. Tunggu admin memilih tim yang akan bermain.");
    }





    public function jualSepeda(Request $r)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $sesi = $this->getSesiAktif();
        $harga = $this->sesiHarga[$sesi];

        $jenis = $r->input('jenis');   // hanya satu jenis yg dikirim dari form
        $jumlah = (int) $r->input('jumlah', 0);

        if (!isset($harga[$jenis])) {
            return back()->with('error', 'Jenis sepeda tidak valid.');
        }

        if ($jumlah <= 0) {
            return back()->with('error', 'Jumlah jual harus lebih dari 0.');
        }

        // cek stok
        $stokSepeda = DB::table('sepeda')->where('team_id', $team->id)->value($jenis);
        if ($stokSepeda < $jumlah) {
            return back()->with('error', "Stok sepeda $jenis tidak mencukupi.");
        }

        $pemasukan = $jumlah * $harga[$jenis];

        DB::table('sepeda')->where('team_id', $team->id)->decrement($jenis, $jumlah);

        DB::table('teams')->where('id', $team->id)->increment('uang', $pemasukan);

        DB::table('production_rally1')->where('team_id', $team->id)->increment('revenue', $pemasukan);

        $this->updateProductionRally($team->id);

        return back()->with('success', "✅ Berhasil menjual $jumlah unit sepeda $jenis. Pemasukan: $$pemasukan");
    }
}
