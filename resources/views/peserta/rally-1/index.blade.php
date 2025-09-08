@extends('layouts.rally-1')

@if (session('success'))
<div style="color: green; font-weight: bold;">
    ✅ {{ session('success') }}
</div>
@endif

@if (session('error'))
<div style="color: red; font-weight: bold;">
    ❌ {{ session('error') }}
</div>
@endif


@section("content")
<div class="p-4">
    <h1 class="text-3xl font-bold mb-4 text-white text-center">Selamat Datang di <span class="text-yellow-300">IGBike</span></h1>

    @php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    // Ambil nama tim dari user yang login
    $tim = Auth::user()->name;

    // Ambil saldo uang tim
    $uang = DB::table('teams')->where('nama_tim', $tim)->value('uang') ?? 0;

    // Ambil daftar pos
    $posList = DB::table('pos')->get();

    // Ambil 3 riwayat pos terakhir dari tim ini
    $riwayat = DB::table('riwayat_pos')
    ->where('peserta_namaTim', $tim)
    ->orderByDesc('waktu')
    ->limit(3)
    ->pluck('pos_id')
    ->toArray();
    @endphp

    <div class="bg-gray-800 rounded-xl p-4 mb-6 shadow">
        <h3 class="text-xl font-semibold mb-2">Halo, {{ $tim }} 👋</h3>
        <p class="text-lg">💰 <span class="font-medium">Uang saat ini:</span> <span class="text-green-400 font-bold">${{ $uang }}</span></p>
    </div>

    <div class="mb-6">
        <h4 class="text-lg font-semibold mb-2">📂 Pilih Halaman:</h4>
        <ul class="space-y-2">
            <li><a href="{{ route("peserta.produksi") }}" class="block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">🔧 Rakit Sepeda</a></li>
            <li><a href="{{ route("peserta.jual") }}" class="block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow">💵 Jual Sepeda</a></li>
            <li><a href="{{ route('peserta.komponen') }}" class="block px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded shadow">📦 Inventory</a></li>
        </ul>
    </div>

    <hr class="border-gray-600 mb-6">

    <h3 class="text-xl font-semibold mb-4">📍 Status Seluruh Pos</h3>

    <div class="space-y-4">
        @foreach ($posList as $pos)
        @php
        $sudahDikunjungiBaruBaruIni = in_array($pos->id, $riwayat);
        $statusColor = match($pos->status) {
        'kosong' => 'bg-green-200 text-green-900',
        'butuh_grup' => 'bg-yellow-100 text-yellow-900',
        'terisi' => 'bg-red-200 text-red-900',
        default => 'bg-gray-100 text-gray-800'
        };
        @endphp
        <div class="rounded-xl shadow p-4 {{ $statusColor }}">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h4 class="text-lg font-bold">{{ $pos->nama }}</h4>
                    <p class="text-sm">{{ ucfirst(str_replace('_', ' ', $pos->status)) }}</p>
                </div>
                <form action="{{ route('peserta.pos.pergi', $pos->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $sudahDikunjungiBaruBaruIni ? 'disabled' : '' }}>
                        Pergi ke Pos
                    </button>
                </form>
            </div>
            @if ($sudahDikunjungiBaruBaruIni)
            <p class="text-sm italic text-gray-600">Sudah dikunjungi baru-baru ini. Kunjungi 3 pos lain terlebih dahulu.</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection