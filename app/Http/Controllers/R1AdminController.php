<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class R1AdminController extends Controller
{
    private $rewardList = [
        1 => [
            'menang' => ['unicycle_frame' => 1, 'wheel' => 2],
            'kalah' => ['wheel' => 1],
        ],
        2 => [
            'menang' => ['folding_frame' => 1, 'chain_and_gear' => 2],
            'kalah' => ['chain_and_gear' => 1],
        ],
        3 => [
            'menang' => ['city_frame' => 1, 'wheel' => 1, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['brake' => 1, 'pedal' => 1],
        ],
        4 => [
            'menang' => ['mountain_frame' => 1, 'chain_and_gear' => 1, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['chain_and_gear' => 1],
        ],
        5 => [
            'menang' => ['wheel' => 2, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['wheel' => 1],
        ],
        6 => [
            'menang' => ['folding_frame' => 1, 'wheel' => 1, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['brake' => 1, 'pedal' => 1],
        ],
        7 => [
            'menang' => ['unicycle_frame' => 1, 'chain_and_gear' => 1, 'wheel' => 1],
            'kalah' => ['chain_and_gear' => 1],
        ],
        8 => [
            'menang' => ['mountain_frame' => 1, 'wheel' => 2],
            'kalah' => ['wheel' => 1],
        ],
        9 => [
            'menang' => ['city_frame' => 1, 'chain_and_gear' => 2],
            'kalah' => ['chain_and_gear' => 1],
        ],
        10 => [
            'menang' => ['folding_frame' => 1, 'wheel' => 2],
            'kalah' => ['wheel' => 1],
        ],
        11 => [
            'menang' => ['brake' => 2, 'pedal' => 2, 'chain_and_gear' => 1],
            'kalah' => ['brake' => 1, 'pedal' => 1],
        ],
        12 => [
            'menang' => ['mountain_frame' => 1, 'chain_and_gear' => 2],
            'kalah' => ['chain_and_gear' => 1],
        ],
        13 => [
            'menang' => ['wheel' => 2, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['wheel' => 1],
        ],
        14 => [
            'menang' => ['city_frame' => 1, 'chain_and_gear' => 1, 'pedal' => 1, 'brake' => 1],
            'kalah' => ['pedal' => 1, 'brake' => 1],
        ],
        15 => [
            'menang' => ['unicycle_frame' => 1, 'wheel' => 1, 'pedal' => 1, 'brake' => 1],
            'kalah' => ['pedal' => 1, 'brake' => 1],
        ],
        16 => [
            'menang' => ['folding_frame' => 1, 'chain_and_gear' => 1, 'wheel' => 1],
            'kalah' => ['wheel' => 1],
        ],
        17 => [
            'menang' => ['chain_and_gear' => 1, 'wheel' => 2],
            'kalah' => ['wheel' => 1],
        ],
        18 => [
            'menang' => ['mountain_frame' => 1, 'brake' => 2, 'pedal' => 2],
            'kalah' => ['brake' => 1, 'pedal' => 1],
        ],
        19 => [
            'menang' => ['chain_and_gear' => 2, 'wheel' => 1],
            'kalah' => ['chain_and_gear' => 1],
        ],
        20 => [
            'menang' => ['unicycle_frame' => 1, 'wheel' => 2],
            'kalah' => ['wheel' => 1],
        ],
        21 => [
            'menang' => ['city_frame' => 1, 'wheel' => 1, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['wheel' => 1],
        ],
        22 => [
            'menang' => ['folding_frame' => 1, 'brake' => 2, 'pedal' => 2],
            'kalah' => ['brake' => 1, 'pedal' => 1],
        ],
        23 => [
            'menang' => ['chain_and_gear' => 2, 'brake' => 1, 'pedal' => 1],
            'kalah' => ['chain_and_gear' => 1],
        ],
        24 => [
            'menang' => ['mountain_frame' => 1, 'wheel' => 1, 'chain_and_gear' => 1],
            'kalah' => ['wheel' => 1],
        ],
        25 => [
            'menang' => ['mountain_frame' => 1, 'chain_and_gear' => 1, 'wheel' => 1],
            'kalah' => ['chain_and_gear' => 1],
        ],
    ];

    public function index($id)
    {
        $pos = DB::table('pos')->where('id', $id)->first();

        $timHariIni = DB::table('riwayat_pos')
            ->where('pos_id', $id)
            ->whereDate('waktu', today())
            ->pluck('peserta_namaTim')
            ->toArray();

        return view('admin.rally-1.admin_pos', compact('pos', 'timHariIni'));
    }

    public function simpanBattle(Request $request, $id)
    {
        $winnerId = $request->winner;

        $tim = DB::table('riwayat_pos')
            ->join('teams', 'riwayat_pos.peserta_namaTim', '=', 'teams.nama_tim')
            ->where('riwayat_pos.pos_id', $id)
            ->whereDate('riwayat_pos.waktu', today())
            ->select('teams.id', 'teams.nama_tim')
            ->get();

        foreach ($tim as $t) {
            if ($t->id == $winnerId) {
                $this->beriMenang($id, $t->id);
            } else {
                $this->beriKalah($id, $t->id);
            }
        }

        return redirect()->route('overview')->with('success', 'Hasil battle berhasil disimpan!');
    }



    public function beriReward($id, $namaTim, $tipe)
    {
        $reward = $this->rewardList[$id][$tipe] ?? null;
        if (!$reward) {
            return back()->with('error', 'Data reward tidak ditemukan.');
        }

        foreach ($reward as $komponen => $jumlah) {
            if (Schema::hasColumn('komponen', $komponen)) {
                DB::table('komponen')->updateOrInsert(
                    ['team_id' => $namaTim],
                    [$komponen => DB::raw("$komponen + $jumlah")]
                );
            }
        }

        DB::table('pos')->where('id', $id)->update(['status' => 'kosong']);

        return back()->with('success', "$tipe: $namaTim menerima reward dari Pos $id.");
    }

    public function overview()
    {
        $posList = DB::table('pos')->get();
        return view('admin.rally-1.admin_overview', compact('posList'));
    }

    public function beriMenang($id, $tim)
    {
        return $this->beriKomponenByResult($id, $tim, 'menang');
    }

    public function beriKalah($id, $tim)
    {
        return $this->beriKomponenByResult($id, $tim, 'kalah');
    }

    public function beriGagal($id)
    {
        DB::table('pos')->where('id', $id)->update(['status' => 'kosong']);
        return back()->with('success', 'Pos berhasil direset menjadi kosong (tim gagal).');
    }

    private function beriKomponenByResult($posId, $tim, $result)
    {
        if (!isset($this->rewardList[$posId][$result])) {
            return back()->with('error', "Tidak ada data komponen untuk Pos $posId saat $result.");
        }

        $komponenList = $this->rewardList[$posId][$result];

        foreach ($komponenList as $komponen => $jumlah) {
            $teamId = DB::table('teams')->where('nama_tim', $tim)->value('id');

            if (Schema::hasColumn('komponen', $komponen)) {
                DB::table('komponen')->updateOrInsert(
                    ['team_id' => $teamId],
                    [$komponen => DB::raw("$komponen + $jumlah")]
                );
            }
        }

        DB::table('pos')->where('id', $posId)->update(['status' => 'kosong']);

        return back()->with('success', "Tim $tim mendapatkan komponen karena $result.");
    }



    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');

        DB::table('pos')->where('id', $id)->update([
            'status' => $status
        ]);

        return back()->with('success', "Status Pos $id diperbarui ke $status");
    }

    public function gagal($id)
    {
        DB::table('pos')->where('id', $id)->update(['status' => 'kosong']);
        return back()->with('success', "Tim dinyatakan gagal. Status Pos $id direset.");
    }

    public function beriKomponen(Request $r, $id)
    {
        $tim = $r->input('tim');
        $komponen = $r->input('komponen');
        $jumlah = (int) $r->input('jumlah');

        if (!$tim || !$komponen || $jumlah <= 0) {
            return back()->with('error', 'Data tidak valid');
        }

        $fieldExists = Schema::hasColumn('komponen', $komponen);
        if (!$fieldExists) {
            return back()->with('error', 'Kolom komponen tidak ditemukan di tabel komponen');
        }

        DB::table('komponen')->updateOrInsert(
            ['team_id' => $tim],
            [$komponen => DB::raw("$komponen + $jumlah")]
        );

        $tipePos = DB::table('pos')->where('id', $id)->value('tipe');
        if ($tipePos === 'single' || $tipePos === 'battle') {
            DB::table('pos')->where('id', $id)->update(['status' => 'kosong']);
        }

        return back()->with('success', "Berhasil memberikan $jumlah $komponen ke tim $tim");
    }




    public function aksi(Request $request, $id)
    {
        $namaTim = $request->input('nama_tim');
        $aksi = $request->input('action');

        if (!$namaTim && $aksi !== 'gagal') {
            return back()->with('error', 'Pilih tim terlebih dahulu.');
        }

        switch ($aksi) {
            case 'menang':
                return $this->beriMenang($id, $namaTim);

            case 'kalah':
                return $this->beriKalah($id, $namaTim);

            case 'gagal':
                return $this->gagal($id); // tidak butuh nama tim

            default:
                return back()->with('error', 'Aksi tidak dikenali.');
        }
    }
}
