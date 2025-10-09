<?php

namespace App\Http\Controllers;
use App\Models\Machine;
use App\Models\Session;
use App\Models\TeamMachine;
use Carbon\Carbon;
// use DB;
use Illuminate\Support\Facades\Log;
use App\Models\SoalQR;
use App\Models\MysteryEnvelope;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class R2Controller extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        // Ambil sesi aktif
        $activeSession = DB::table('tsession')->where('jenis_sesi', 1)->first();
        $currentDemand = $activeSession ? $activeSession->demand : 0;

        // Ambil semua mesin
        $allMachines = Machine::all();

        // Ambil mesin yang dimiliki tim
        $ownedMachines = TeamMachine::where('team_id', $team->id)->get()->keyBy('tmachine_id');



        $factories = $allMachines->map(function ($machine) use ($ownedMachines) {
            $owned = $ownedMachines->has($machine->id);
            $ownedData = $ownedMachines->get($machine->id);

            $level = $owned ? $ownedData->level : 1;
            $upgradeConfig = config("machine_upgrade.{$machine->jenis}", [
                'upgrade_prices' => [],
                'capacity_per_level' => [],
                'time_per_level' => [],
                'sell_prices' => [],
            ]);

            $connections = [];

            if ($owned) {
                $myId = $ownedData->id;


                $connections = DB::table('tconnectmachine')
                    ->where(function ($q) use ($myId) {
                        $q->where('source_team_machine_id', $myId)
                            ->orWhere('target_team_machine_id', $myId);
                    })
                    ->get()
                    ->map(function ($conn) {
                        return [
                            'from' => $conn->source_team_machine_id,
                            'to' => $conn->target_team_machine_id,
                        ];
                    })
                    ->toArray();
            }

            return [
                'machine_id' => $machine->id,
                'name' => $machine->name,
                'jenis' => $machine->jenis,
                'harga_dasar' => $machine->harga_dasar,
                'kapasitas_dasar' => $upgradeConfig['capacity_per_level'][$level] ?? $machine->kapasitas_dasar,
                'base_time' => $upgradeConfig['time_per_level'][$level] ?? $machine->base_time,
                'biaya_maintenance' => $machine->biaya_maintenance,
                'owned' => $owned,
                'owned_id' => $owned ? $ownedData->id : null,
                'level' => $level,
                'operator_hired' => $owned ? $ownedData->operator_hired : null,

                'upgrade_prices' => $upgradeConfig['upgrade_prices'],
                'capacity_per_level' => $upgradeConfig['capacity_per_level'],
                'time_per_level' => $upgradeConfig['time_per_level'],
                'sell_prices' => $upgradeConfig['sell_prices'],
                'connections' => $connections,

            ];
        });


        $gameData = [
            'timer' => '00:00',
            'elapsed_seconds' => session('rally2_timer', 0),
            'demand' => $currentDemand,
            'capital' => $team->total_uang_babak2,
            'factories_locked' => !$team->unlocked_babak2,
            'unlock_cost' => $team->harga_unlock,
            "machine" => $allMachines,
            'factories' => $factories,
            "owned" => $ownedMachines,

        ];

        return view('peserta.rally-2.index', compact('gameData', "team"));
    }


    public function unlockFactory(Request $request)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $unlockCost = $team->harga_unlock;

        if ($team->unlocked_babak2) {
            return response()->json(['message' => 'Factory already unlocked.'], 400);
        }

        if ($team->total_uang_babak2 < $unlockCost) {
            return response()->json(['message' => 'Not enough capital to unlock factory.'], 400);
        }

        $team->unlocked_babak2 = true;
        $team->total_uang_babak2 -= $unlockCost;
        $team->save();

        session(['rally2_timer' => 0]); // Optional reset timer
        session(['rally2_unlocked' => true]);

        return response()->json([
            'message' => 'Factory unlocked successfully.',
            'capital' => $team->total_uang_babak2
        ]);
    }

    public function scanner()
    {
        return view('peserta.rally-2.scanner');
    }

    public function events()
    {
        // Ambil sesi aktif
        $activeSession = DB::table('tsession')->where('jenis_sesi', 1)->first();

        // Ambil event jika ada
        $event = $activeSession ? $activeSession->event : null;

        return view('peserta.rally-2.events', compact('event'));
    }

    public function inventory()
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();
        $inventory = $team->inventory_babak_2;
        return view('peserta.rally-2.inventory', compact("inventory"));
    }
    public function sellItem(Request $request)
    {
        // Debug 1: Log semua data yang diterima
        \Log::info('Sell Item Request:', [
            'all_data' => $request->all(),
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'No user'
        ]);

        try {
            $user = Auth::user();

            // Debug 2: Cek user
            if (!$user) {
                \Log::error('No authenticated user found');
                return response()->json(['message' => 'User tidak terautentikasi'], 401);
            }

            \Log::info('User found:', ['user_name' => $user->name]);

            // Debug 3: Cek team
            $team = Team::where('nama_tim', $user->name)->first();

            if (!$team) {
                \Log::error('Team not found for user:', ['user_name' => $user->name]);
                return response()->json(['message' => 'Tim tidak ditemukan'], 404);
            }

            \Log::info('Team found:', [
                'team_id' => $team->id,
                'team_name' => $team->nama_tim,
                'current_inventory' => $team->inventory_babak_2,
                'current_money' => $team->total_uang_babak2
            ]);

            // Debug 4: Validasi input
            $quantity = (int) $request->quantity;
            $totalPrice = (int) $request->total_price;

            if ($quantity <= 0) {
                return response()->json(['message' => 'Quantity harus lebih dari 0'], 422);
            }

            if ($totalPrice <= 0) {
                return response()->json(['message' => 'Total price harus lebih dari 0'], 422);
            }

            // Debug 5: Validasi stok
            if ($quantity > $team->inventory_babak_2) {
                \Log::warning('Insufficient stock:', [
                    'requested' => $quantity,
                    'available' => $team->inventory_babak_2
                ]);
                return response()->json(['message' => 'Jumlah melebihi stok yang tersedia!'], 422);
            }

            // Debug 6: Data sebelum update
            $oldInventory = $team->inventory_babak_2;
            $oldMoney = $team->total_uang_babak2;

            \Log::info('Before update:', [
                'old_inventory' => $oldInventory,
                'old_money' => $oldMoney
            ]);

            // Update dengan tracking perubahan
            $team->inventory_babak_2 = $oldInventory - $quantity;
            $team->total_uang_babak2 = $oldMoney + $totalPrice;

            // Debug 7: Cek apakah model dirty (ada perubahan)
            \Log::info('Model changes:', [
                'is_dirty' => $team->isDirty(),
                'dirty_attributes' => $team->getDirty(),
                'new_inventory' => $team->inventory_babak_2,
                'new_money' => $team->total_uang_babak2
            ]);

            // Save dengan error handling
            $saved = $team->save();

            \Log::info('Save result:', [
                'saved' => $saved,
                'final_inventory' => $team->fresh()->inventory_babak_2,
                'final_money' => $team->fresh()->total_uang_babak2
            ]);

            if (!$saved) {
                \Log::error('Failed to save team data');
                return response()->json(['message' => 'Gagal menyimpan data'], 500);
            }

            // Refresh data dari database
            $team->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menjual item!',
                'inventory' => $team->inventory_babak_2,
                'uang' => $team->total_uang_babak2,
                'debug' => [
                    'quantity_sold' => $quantity,
                    'price_earned' => $totalPrice,
                    'old_inventory' => $oldInventory,
                    'old_money' => $oldMoney
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Exception in sellItem:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function infoDemand()
    {

        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();
        $sessions = Session::whereIn('id', [1, 2, 3, 4])->orderBy('id')->get(['id', 'demand']);

        $map = $sessions->map(fn($s) => [
            'id' => $s->id,
            'demand' => (int) ($s->demand ?? 0),
            'produced' => match ($s->id) {
                1 => (int) ($team->sepeda_sesi1 ?? 0),
                2 => (int) ($team->sepeda_sesi2 ?? 0),
                3 => (int) ($team->sepeda_sesi3 ?? 0),
                4 => (int) ($team->sepeda_sesi4 ?? 0),
            },
        ])->all();

        return view('peserta.rally-2.infodemand', ['sessions' => $map]);
    }
    public function question()
    {
        return view('peserta.rally-2.question');
    }

    //SOAL QR
    public function showQR($id)
    {
        // Cegah akses tanpa QR
        if (!session()->get("akses_soal_$id")) {
            abort(403, "Akses soal hanya bisa dilakukan melalui QR Scan.");
        }

        // CEK BARU: Jika soal sudah diselesaikan, redirect
        if (session()->get("soal_selesai_$id")) {
            return redirect()->route('peserta.rally-2.scanner')
                ->with('error', 'Soal ini sudah diselesaikan sebelumnya.');
        }

        $soal = SoalQR::findOrFail($id);

        // Cek apakah peserta sudah pernah membuka soal ini sebelumnya
        $pernahAkses = session()->get("pernah_akses_$id", false);

        // Tandai bahwa soal sudah pernah diakses
        session()->put("pernah_akses_$id", true);

        return view('peserta.rally-2.question', compact('soal', 'pernahAkses'));
    }

    public function submitQR(Request $request, $id)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        // CEK BARU: Jika soal sudah diselesaikan, tolak submission
        if (session()->get("soal_selesai_$id")) {
            return response()->json([
                'status' => 'error',
                'message' => 'Soal ini sudah diselesaikan sebelumnya.'
            ], 403);
        }

        Log::info("ID Soal : " . $id);
        $soal = SoalQR::findOrFail($id);

        // Fungsi normalisasi jawaban
        $normalize = function ($str) {
            $str = trim(strtolower($str));
            $str = preg_replace('/^\$+|\$+$/', '', $str); // hilangkan tanda $
            $str = str_replace(['\mathrm{', '\mathrm', '{', '}', '_'], '', $str); // hilangkan LaTeX formatting
            $str = preg_replace('/\^\{(.+?)\}/', '$1', $str); // ubah ^{3-} jadi 3-
            $str = str_replace(['^', '−', '–'], ['', '-', '-'], $str); // hilangkan ^, ubah minus unicode ke ASCII
            return $str;
        };

        // Normalisasi input user dan jawaban benar
        $jawabanUser = $normalize($request->input('jawaban'));
        $jawabanBenar = $normalize($soal->jawaban_benar);

        // Logging untuk debug
        Log::info("JAWABAN USER: " . $jawabanUser);
        Log::info("JAWABAN BENAR: " . $jawabanBenar);

        // Perbandingan
        $status = $jawabanUser === $jawabanBenar ? 'benar' : 'salah';

        if ($status === 'benar') {
            $team->total_uang_babak2 += $soal->reward_amount;
            $team->save();

            // TANDAI SOAL SUDAH SELESAI - HANYA JIKA BENAR
            session()->put("soal_selesai_$id", true);
        }

        return response()->json([
            'status' => $status,
            'reward' => $status === 'benar' ? $soal->reward_amount : null
        ]);
    }

    // MYSTERY ENVELOPE
    public function claim($id)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        // Batasi hanya lewat scan (opsional, seperti soal)
        if (!session()->get("akses_envelope_$id")) {
            abort(403, "Akses hanya bisa dilakukan melalui QR Scan.");
        }

        $envelope = MysteryEnvelope::where('id', $id)->first();

        if (!$envelope) {
            abort(404, "Envelope tidak ditemukan.");
        }

        // Cek apakah tim sudah klaim sebelumnya (opsional)
        if ($envelope->team_id) {
            return redirect()
                ->route('peserta.rally-2.scanner') // ganti ini dengan rute tempat peserta diarahkan kembali
                ->with('error', 'Envelope ini sudah diklaim oleh tim lain.');
        } else {
            $envelope->team_id = $team->id;
            $envelope->save();

            $team->total_uang_babak2 += $envelope->reward_amount;
            $team->save();
        }

        // Kirim tampilan reward
        return view('peserta.rally-2.claim-envelope', compact('envelope'));
    }



    //============= MAIN RALLY 2 ====================//
    public function buyMachine(Request $request)
    {
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $machineId = $request->input('machine_id');
        $machine = Machine::findOrFail($machineId);

        $alreadyOwned = TeamMachine::where('team_id', $team->id)
            ->where('tmachine_id', $machineId)
            ->exists();

        if ($alreadyOwned) {
            return response()->json(['error' => 'Mesin sudah dimiliki.'], 400);
        }

        if ($team->total_uang_babak2 < $machine->harga_dasar) {
            return response()->json(['error' => 'Uang tidak mencukupi.'], 400);
        }

        // Kurangi uang tim
        $team->total_uang_babak2 -= $machine->harga_dasar;
        $team->save();

        // Simpan ke t_team_machines
        try {
            TeamMachine::create([
                'team_id' => $team->id,
                'tmachine_id' => $machineId,
                'level' => 1,
                'operator_hired' => false,
                "base_time" => $machine->base_time,
                "biaya_jual" => $machine->biaya_jual,
                "kapasitas_dasar" => $machine->kapasitas_dasar,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal menyimpan TeamMachine: " . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan mesin.'], 500);
        }

        return response()->json([
            'message' => 'Pembelian berhasil!',
            'capital' => $team->total_uang_babak2,
            'machine_id' => $machineId,
        ]);
    }
    public function upgradeMachine(Request $request)
    {
        Log::info('[upgradeMachine] HIT', $request->all());

        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        $ownedId = $request->input('owned');
        $nextLevel = $request->input('next_level');
        $price = $request->input('price');
        $newCapacity = $request->input('new_capacity');
        $newTime = $request->input('new_time');
        $newSell = $request->input('sell');
        $teamMachine = TeamMachine::where('id', $ownedId)
            ->where('team_id', $team->id)
            ->first();

        if (!$teamMachine) {
            return response()->json(['error' => 'Mesin belum dimiliki.'], 400);
        }

        if ($teamMachine->level >= 3) {
            return response()->json(['error' => 'Mesin sudah pada level maksimum.'], 400);
        }
        Log::error($teamMachine->level);
        if ($teamMachine->level + 1 !== $nextLevel) {
            return response()->json(['error' => 'Level upgrade tidak valid.'], 400);
        }

        if ($team->total_uang_babak2 < $price) {
            return response()->json(['error' => 'Uang tidak mencukupi untuk upgrade mesin ini.'], 400);
        }

        // Potong uang
        $team->total_uang_babak2 -= $price;
        $team->save();

        // Update level
        $teamMachine->level = $nextLevel;

        // (Opsional) simpan kapasitas dan waktu baru jika ada kolomnya
        $teamMachine->kapasitas_dasar = $newCapacity;
        $teamMachine->base_time = $newTime;
        $teamMachine->biaya_jual = $newSell;

        $teamMachine->save();

        return response()->json([
            'message' => 'Mesin berhasil diupgrade ke level ' . $nextLevel,
            'capital' => $team->total_uang_babak2,
            'level' => $nextLevel,
            'kapasitas_dasar' => $newCapacity,
            'base_time' => $newTime,
        ]);
    }
    public function sell(Request $request)
    {
        $request->validate([
            'owned' => 'required|integer',
            'price' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        // Cek mesin milik tim
        $teamMachine = TeamMachine::where('id', $request->owned)
            ->where('team_id', $team->id)
            ->first();

        if (!$teamMachine) {
            return response()->json(['error' => 'Mesin tidak ditemukan atau bukan milik tim.'], 403);
        }

        // Hapus mesin
        $teamMachine->delete();

        // Tambahkan saldo tim
        $team->total_uang_babak2 += $request->price;
        $team->save();

        return response()->json([
            'message' => 'Mesin berhasil dijual!',
            'capital' => $team->total_uang_babak2
        ]);
    }


    public function storeConnection(Request $request)
    {
        Log::info('🔧 storeConnection dipanggil', $request->all());

        $validated = $request->validate([
            'source_team_machine_id' => 'required|exists:tteammachine,id',
            'target_team_machine_id' => 'required|exists:tteammachine,id',
        ]);
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();
        try {
            DB::table('tconnectmachine')->insert([
                'team_id' => $team->id,
                'source_team_machine_id' => $validated['source_team_machine_id'],
                'target_team_machine_id' => $validated['target_team_machine_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Gagal insert koneksi: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan koneksi'], 500);
        }

        Log::info('✅ Koneksi disimpan:', $validated);

        return response()->json(['message' => 'Koneksi berhasil disimpan']);
    }
    public function hireWorker(Request $request)
    {
        Log::info('🔧 [hireWorker] Request diterima', $request->all());

        // Ubah validasi agar tidak pakai backtick, cukup string nama tabel
        $request->validate([
            'owned_id' => 'required|exists:tteammachine,id',
        ]);

        // Pastikan model mengarah ke tteammachine
        $teamMachine = TeamMachine::findOrFail($request->owned_id);
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();
        Log::info('🧾 [hireWorker] Ditemukan mesin dan tim', [
            'team_machine_id' => $teamMachine->id,
            'team_id' => $team->id,
            'machine_team_id' => $teamMachine->team_id,
            'capital_sekarang' => $team->total_uang_babak2,
            'harga' => $request->price,
        ]);

        if ($teamMachine->team_id != $team->id) {
            Log::warning('❌ [hireWorker] Unauthorized: Mesin bukan milik tim.');
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        if ($team->total_uang_babak2 < $request->price) {
            Log::warning('❌ [hireWorker] Uang tidak cukup untuk sewa pekerja.');
            return response()->json(['error' => 'Uang tidak mencukupi untuk menyewa pekerja.']);
        }

        $team->total_uang_babak2 -= 700;
        $team->save();

        $teamMachine->operator_hired = true;
        $teamMachine->save();

        Log::info('✅ [hireWorker] Berhasil menyewa pekerja.', [
            'sisa_capital' => $team->total_uang_babak2,
            'operator_hired' => $teamMachine->operator_hired,
        ]);

        return response()->json([
            'message' => 'Berhasil menyewa pekerja!',
            'capital' => $team->total_uang_babak2
        ]);
    }

    public function upgradeQuality(Request $request, Team $team)
    {
        // Harga & batas level (source of truth di server)
        $UPGRADE_PRICES = [ // current -> next
            1 => 8500, // 1->2
            2 => 10000, // 2->3
        ];
        $MAX_LEVEL = 3;

        $validated = $request->validate([
            'from_level' => 'required|integer|min:1|max:' . $MAX_LEVEL,
            'to_level' => 'required|integer|min:1|max:' . $MAX_LEVEL,
        ]);

        $currentLevel = (int) ($team->level_mesin_quality ?? 1);
        $fromLevel = (int) $validated['from_level'];
        $toLevel = (int) $validated['to_level'];

        if ($currentLevel !== $fromLevel) {
            return back()->with('error', 'Level berubah. Muat ulang halaman dan coba lagi.');
        }
        if ($currentLevel >= $MAX_LEVEL) {
            return back()->with('error', 'Level sudah maksimal.');
        }
        if ($toLevel !== $currentLevel + 1) {
            return back()->with('error', 'Target level tidak valid.');
        }

        $cost = $UPGRADE_PRICES[$currentLevel] ?? null;
        if (!$cost) {
            return back()->with('error', 'Biaya upgrade tidak ditemukan.');
        }

        try {
            DB::transaction(function () use ($team, $cost, $toLevel) {
                // kunci baris untuk hindari race condition
                $fresh = Team::lockForUpdate()->findOrFail($team->id);

                $currLevel = (int) ($fresh->level_mesin_quality ?? 1);
                if ($toLevel !== $currLevel + 1) {
                    abort(409, 'State berubah. Coba lagi.');
                }

                $capital = (int) ($fresh->total_uang_babak2 ?? 0);
                if ($capital < $cost) {
                    abort(409, 'Total uang babak 2 tidak mencukupi.');
                }

                $fresh->total_uang_babak2 = $capital - $cost;
                $fresh->level_mesin_quality = $toLevel;
                $fresh->save();
            });
        } catch (\Throwable $e) {
            $msg = $e->getCode() === 409 ? $e->getMessage() : 'Terjadi kesalahan saat upgrade.';
            return back()->with('error', $msg);
        }

        return back()->with('success', "Quality Control naik ke level {$toLevel}. Biaya: $" . number_format($cost));
    }

    public function layoffWorker(Request $request)
    {
        $request->validate([
            'owned_id' => 'required|exists:tteammachine,id',
        ]);

        $teamMachine = TeamMachine::findOrFail($request->owned_id);
        $user = Auth::user();
        $team = Team::where('nama_tim', $user->name)->firstOrFail();

        if ($teamMachine->team_id !== $team->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $layoffCost = 1000;

        if ($team->total_uang_babak2 < $layoffCost) {
            return response()->json(['error' => 'Uang tidak cukup untuk biaya kompensasi'], 400);
        }

        $team->total_uang_babak2 -= $layoffCost;
        $team->save();

        $teamMachine->operator_hired = false;
        $teamMachine->save();

        return response()->json([
            'message' => 'Berhasil memecat pekerja. Dikenakan biaya kompensasi!',
            'capital' => $team->total_uang_babak2
        ]);
    }

}
