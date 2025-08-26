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

    // private function getTim()
    // {
    //     return session('namaTim') ?? 'TimDemo';
    //  }

    private function getSesiAktif()
    {
        $start = Carbon::parse('2025-07-29 10:00:00');
        $now = Carbon::now();

        if ($now->lessThan($start)) {
            return 1;
        }

        $minutes = $start->diffInMinutes($now);
        $sesi = floor($minutes / 30) + 1;

        return min($sesi, 4);
    }



    public function showPos($id)
    {
        $komponen = DB::table('pos_stok')
            ->where('pos_id', $id)
            ->where('jumlah', '>', 0)
            ->get();

        return view('pos_peserta', compact('id', 'komponen'));
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

        if (!isset($resep[$jenis])) return back()->with('error', 'Jenis tidak ditemukan');

        foreach ($resep[$jenis] as $key => $jumlah) {
            if (($komponen->$key ?? 0) < $jumlah) {
                return back()->with('error', 'Komponen tidak cukup untuk merakit ' . $jenis);
            }
        }

        foreach ($resep[$jenis] as $key => $jumlah) {
            DB::table('komponen')->where('team_id', $team->id)->decrement($key, $jumlah);
        }

        DB::table('sepeda')->updateOrInsert(
            ['team_id' => $team->id],
            [$jenis => DB::raw("$jenis + 1")]
        );

        return back()->with('success', "Berhasil merakit sepeda $jenis");
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

        $lastVisited = DB::table('riwayat_pos')
            ->where('peserta_namaTim', $tim)
            ->orderByDesc('waktu')
            ->limit(3)
            ->pluck('pos_id')
            ->toArray();

        if (in_array($id, $lastVisited)) {
            return back()->with('error', 'Tidak boleh mengunjungi pos yang sama sebelum mengunjungi 3 pos lain.');
        }

        $uang = DB::table('teams')->where('nama_tim', $tim)->value('uang');
        if ($uang < 3) {
            return back()->with('error', 'Uang tidak cukup.');
        }
        DB::table('teams')->where('nama_tim', $tim)->decrement('uang', 3);

        DB::table('riwayat_pos')->insert([
            'peserta_namaTim' => $tim,
            'pos_id' => $id,
            'waktu' => now()
        ]);

        $pos = DB::table('pos')->where('id', $id)->first();
        if ($pos->tipe === 'single') {
            DB::table('pos')->where('id', $id)->update(['status' => 'terisi']);
        } else if ($pos->tipe === 'battle') {
            $existingCount = DB::table('riwayat_pos')
                ->where('pos_id', $id)
                ->whereDate('waktu', today())
                ->count();

            if ($existingCount == 1) {
                DB::table('pos')->where('id', $id)->update(['status' => 'butuh_grup']);
            } else if ($existingCount >= 2) {
                DB::table('pos')->where('id', $id)->update(['status' => 'terisi']);
            }
        }

        return back()->with('success', "Berhasil mengunjungi Pos $id");
    }

    public function jualSepeda(Request $r)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $sesi = $this->getSesiAktif();
        $harga = $this->sesiHarga[$sesi];

        $total = 0;
        foreach ($harga as $jenis => $h) {
            $jumlah = (int) $r->input($jenis, 0);

            if ($jumlah > 0) {
                DB::table('sepeda')
                    ->where('team_id', $team->id)
                    ->decrement($jenis, $jumlah);

                $total += $jumlah * $h;
            }
        }

        DB::table('teams')->where('id', $team->id)->increment('uang', $total);

        return back()->with('success', "Berhasil menjual. Pemasukan: $$total");
    }
}
