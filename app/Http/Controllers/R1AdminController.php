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

        // Ambil waiting list untuk pos ini
        $waitingList = DB::table('waiting_list_pos')
            ->where('pos_id', $id)
            ->get();

        if ($pos->tipe === 'battle') {
            $timHariIni = DB::table('riwayat_pos')
                ->where('pos_id', $id)
                ->whereDate('waktu', today())
                ->where('status', 'playing') 
                ->get(['id', 'peserta_namaTim']); // Collection untuk battle
        } else {
            $timHariIni = DB::table('riwayat_pos')
                ->where('pos_id', $id)
                ->whereDate('waktu', today())
                ->where('status', 'playing') 
                ->first(['id', 'peserta_namaTim']); // Object tunggal untuk single
        }

        return view('admin.rally-1.admin_pos', compact('pos', 'timHariIni', 'waitingList'));
    }

    public function pilihTim(Request $request, $posId)
    {
        $selectedTeams = $request->input('tim', []);

        if (empty($selectedTeams)) {
            return back()->with('error', 'Pilih minimal 1 tim dari waiting list.');
        }

        // Ambil data pos
        $pos = DB::table('pos')->where('id', $posId)->first();
        if (!$pos) {
            return back()->with('error', 'Pos tidak ditemukan.');
        }

        // Validasi jumlah tim sesuai tipe pos
        if ($pos->tipe === 'single' && count($selectedTeams) !== 1) {
            return back()->with('error', 'Pos single hanya boleh 1 tim.');
        }
        if ($pos->tipe === 'battle' && count($selectedTeams) !== 2) {
            return back()->with('error', 'Pos battle harus 2 tim.');
        }

        foreach ($selectedTeams as $waitingId) {
            $tim = DB::table('waiting_list_pos')->where('id', $waitingId)->first();
            if (!$tim) continue;

            // Masukkan ke riwayat_pos (mulai bermain)
            DB::table('riwayat_pos')->insert([
                'pos_id' => $posId,
                'peserta_namaTim' => $tim->peserta_namaTim,
                'waktu' => now(),
                'status' => 'playing',
            ]);

            // Potong uang baru disini (ketika dipilih untuk main)
            DB::table('teams')->where('nama_tim', $tim->peserta_namaTim)->decrement('uang', 3);

            // Hapus dari waiting list
            DB::table('waiting_list_pos')->where('id', $waitingId)->delete();
        }

        // Update status pos sesuai kondisi
        if ($pos->tipe === 'single') {
            DB::table('pos')->where('id', $posId)->update(['status' => 'terisi']);
        } elseif ($pos->tipe === 'battle') {
            DB::table('pos')->where('id', $posId)->update(['status' => 'terisi']);
        }

        return back()->with('success', 'Tim berhasil dipilih dan mulai bermain.');
    }

    public function clearWaitingList($posId)
    {
        DB::table('waiting_list_pos')->where('pos_id', $posId)->delete();
        DB::table('pos')->where('id', $posId)->update(['status' => 'kosong']);

        return back()->with('success', "Waiting list untuk Pos $posId sudah direset.");
    }

    public function simpanBattle(Request $request, $id)
    {
        $hasilArray = $request->input('hasil', []);

        if (count($hasilArray) < 2) {
            return back()->with('error', 'Silakan pilih hasil untuk kedua tim.');
        }

        foreach ($hasilArray as $timId => $hasil) {
            $tim = DB::table('riwayat_pos')->where('id', $timId)->first();
            if (!$tim) continue;

            if ($hasil === 'menang') {
                $this->beriMenang($id, $tim->peserta_namaTim);
            } elseif ($hasil === 'kalah') {
                $this->beriKalah($id, $tim->peserta_namaTim);
            } elseif ($hasil === 'gagal') {
                $this->beriGagal($id, $tim->peserta_namaTim);
            }
        }

        // setelah diproses, kosongkan pos
        DB::table('pos')->where('id', $id)->update(['status' => 'kosong']);

        DB::table('waiting_list_pos')->where('pos_id', $id)->delete();

        DB::table('riwayat_pos')
            ->where('pos_id', $id)
            ->where('peserta_namaTim', $tim)
            ;

        return back()->with('success', 'Hasil battle berhasil diproses!');
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
        return back()->with('success', "Tim dinyatakan gagal. Status Pos $id direset.");
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

        // Kosongkan pos
        DB::table('pos')->where('id', $posId)->update(['status' => 'kosong']);

        DB::table('waiting_list_pos')->where('pos_id', $posId)->delete();

        DB::table('riwayat_pos')
            ->where('pos_id', $posId)
            ->where('peserta_namaTim', $tim)
            ->update(['status' => 'done']);

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
                $this->beriMenang($id, $namaTim);
                break;

            case 'kalah':
                $this->beriKalah($id, $namaTim);
                break;

            case 'gagal':
                $this->gagal($id);
                break;

            default:
                return back()->with('error', 'Aksi tidak dikenali.');
        }

        // Redirect ke halaman pos supaya data terbaru diambil
        return redirect()->route('admin.pos', $id)
            ->with('success', "Hasil aksi '$aksi' untuk tim $namaTim berhasil diproses.");
    }
}
