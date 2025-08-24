<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\R1AdminController;
use App\Http\Controllers\R1Controller;
use App\Http\Controllers\R1PesertaController;
use App\Http\Controllers\R2Controller;
use App\Http\Controllers\RallyGames;
use App\Http\Controllers\SoalQRController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BundleRegistrationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ini adalah file rute final Anda.
|
*/

Route::get('/AdminRegis', [AdminController::class, 'registrationDashboard'])->name('admin.regis.dashboard');
Route::post('/AdminRegis/verify/{team}', [AdminController::class, 'verifyPayment'])->name('admin.regis.verify');
Route::post('/AdminRegis/unverify/{team}', [AdminController::class, 'unverifyPayment'])->name('admin.regis.unverify');

// --- RUTE HALAMAN UTAMA & STATIS ---
Route::get('/', function () {
    return view('welcome');
})->name('qhome');


Route::get('/faq', function () {
    return view('peserta.faq');
})->name('faq');

Route::get('/aboutus', function () {
    return view('peserta.aboutus');
})->name('aboutus');




// --- RUTE OTENTIKASI BAWAAN LARAVEL ---
// Ini akan secara otomatis membuat rute seperti:
// GET /register -> Menampilkan halaman pilihan (karena akan kita override)
// POST /register -> Memproses form registrasi single
// GET /login, POST /login, dll.
Auth::routes();
// --- RUTE KUSTOM UNTUK MENAMPILKAN FORMULIR ---

// Rute ini HANYA untuk MENAMPILKAN formulir isian single team.
Route::get('/register/single-form', function () {
    return view('auth.register_single_form');
})->name('register.single.form');

// Rute untuk MENAMPILKAN formulir isian bundle.
Route::get('/register/bundle-form', [BundleRegistrationController::class, 'create'])->name('register.bundle.form');

// Rute untuk MEMPROSES formulir isian bundle.
Route::post('/register/bundle-form', [BundleRegistrationController::class, 'store'])->name('register.bundle.store');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

//=====================ADMIN====================//
Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/rally1', [AdminController::class, 'rally1'])->name('rally-1.index');
    //======================RALLY 1====================//
    Route::get('/rally1/pos', [R1AdminController::class, 'overview'])->name('overview');
    Route::get('/rally1/pos/{id}', [R1AdminController::class, 'index'])->name('pos');
    Route::post('/rally1/pos/{id}/beri', [R1AdminController::class, 'beriKomponen'])->name('beri');
    Route::post('/rally1/pos/{id}/status', [R1AdminController::class, 'updateStatus'])->name('status');
    Route::post('/rally1/pos/{id}/menang/{tim}', [R1AdminController::class, 'beriMenang'])->name('menang');
    Route::post('/rally1/pos/{id}/kalah/{tim}', [R1AdminController::class, 'beriKalah'])->name('kalah');
    Route::post('/rally1/pos/{id}/gagal', [R1AdminController::class, 'beriGagal'])->name('gagal');

    Route::post('/admin/pos/{id}/aksi', [R1AdminController::class, 'aksi'])->name('aksi');

    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.rally-1.index');
        })->name('home');
    });
    Route::post('/admin/rally1/pos/{id}/battle', [R1AdminController::class, 'simpanBattle'])
        ->name('battle.hasil');



    //=============================RALLY 2 =============//
    Route::get('/rally2', action: [AdminController::class, 'rally2'])->name('rally-2.index');
    Route::post('/gantisesi', [AdminController::class, 'gantisesi'])->name('rally-2.gantisesigame');
});


//==================PESERTA====================//
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group([
    'middleware' => ['auth', 'role:peserta', 'cek.routing.peserta'],
    'prefix' => 'peserta',
    'as' => 'peserta.'
], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/accountdetail', [HomeController::class, 'account'])->name('account-detail');
    Route::get('/rally', [RallyGames::class, 'index'])->name('rally');

    // =================== RALLY 2 ===================
    Route::get('/rally2', [R2Controller::class, 'index'])->name('rally-2.index');
    Route::post('/rally2/unlock', [R2Controller::class, 'unlockFactory'])->name('rally2.unlock');

    //==================SIDEBAR======================
    Route::get('/rally2/scanner', [R2Controller::class, 'scanner'])->name('rally-2.scanner');
    Route::get('/rally2/events', [R2Controller::class, 'events'])->name('rally-2.events');
    Route::get('/rally2/inventory', [R2Controller::class, 'inventory'])->name('rally-2.inventory');
    Route::post('/rally2/sellsepeda', [R2Controller::class, 'sellItem'])->name('rally-2.sellsepeda');


    //==================SCANNER==========================
    Route::get('/rally2/question/{id}', [R2Controller::class, 'showQR'])
        ->middleware('cek.soal.qr')->name('rally-2.question');

    Route::post('/rally2/question/{id}/submit', [R2Controller::class, 'submitQR'])
        ->name('question.submit');

    Route::get('/rally2/claim-envelope/{id}', [R2Controller::class, 'claim'])
        ->middleware('cek.claim.envelope')->name('rally-2.claim-envelope');

    Route::get('/rally2/qr-redirect/{id}', function ($id) {
        session()->put("akses_soal_$id", true);
        return redirect()->route('peserta.rally-2.question', $id);
    });

    Route::get('/rally2/envelope-redirect/{id}', function ($id) {
        session()->put("akses_envelope_$id", true);
        return redirect()->route('peserta.rally-2.claim-envelope', $id);
    });

    //================MAIN RALLY 2=======================
    Route::post('/rally2/buy', [R2Controller::class, 'buyMachine'])->name('rally2.buy');
    Route::post('/rally2/upgrade', [R2Controller::class, 'upgradeMachine'])->name('rally2.upgrade');
    Route::post('/rally2/sell', [R2Controller::class, 'sell'])->name('rally2.sell');
    Route::post('/rally2/connect-machine', [R2Controller::class, 'storeConnection'])->name('rally2.connect');;
    Route::post('/rally2/hire-worker', [R2Controller::class, 'hireWorker'])->name('rally2.hire');

    // =================== RALLY 1===================
    Route::get('/rally1', [R1Controller::class, 'index'])->name('rally-1.index');

    Route::get('/rally1/komponen', [R1PesertaController::class, 'lihatKomponen'])->name('komponen');


    Route::get('/rally1/pos/{id}', [R1PesertaController::class, 'showPos'])->name('pos.show');
    Route::get('/rally1/peserta/pos', [R1PesertaController::class, 'daftarPos'])->name('pos');
    Route::post('/rally1/peserta/pos/{id}/pergi', [R1PesertaController::class, 'pergiKePos'])->name('pos.pergi');

    Route::get('/rally1/produksi', [R1PesertaController::class, 'showProduksi'])->name('produksi');
    Route::post('/rally1/produksi/{jenis}', [R1PesertaController::class, 'produksiSepeda'])->name('produksi.sepeda');

    Route::get('/rally1/jual', [R1PesertaController::class, 'showJual'])->name('jual');
    Route::post('/rally1/jual', [R1PesertaController::class, 'jualSepeda'])->name('jual.sepeda');
});


Route::get('peserta/rally2/{id}', function ($id) {
    if (is_numeric($id)) {
        return redirect("peserta/rally2/qr-redirect/$id");
    }

    abort(404);
});




Route::get('/mystery-envelope/{id}', function ($id) {
    if (is_numeric($id)) {
        return redirect("peserta/rally2/envelope-redirect/$id");
    }

    abort(404);
});
