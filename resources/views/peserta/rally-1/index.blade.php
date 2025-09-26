@extends('layouts.rally-1')
<script src="//unpkg.com/alpinejs" defer></script>

@push('head')
<!-- Alpine.js buat handle drawer -->
@endpush

@if (session('success'))
<div class="max-w-2xl mx-auto p-3 rounded-xl bg-green-100 border border-green-300 text-green-800 font-semibold flex items-center gap-2 mb-4 shadow-sm">
    ✅ {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="max-w-2xl mx-auto p-3 rounded-xl bg-red-100 border border-red-300 text-red-800 font-semibold flex items-center gap-2 mb-4 shadow-sm">
    ❌ {{ session('error') }}
</div>
@endif

@section("content")
<div x-data="{ open: false }" class="p-6 max-w-4xl mx-auto space-y-6 relative">

    <button
        @click="open = true"
        style="position: fixed; bottom: 1.5rem; left: 1.5rem; z-index: 9999;"
        class="text-white text-lg bg-gray-700 hover:bg-gray-800 p-3 rounded-full shadow-lg transition transform hover:scale-110 focus:outline-none">
        🔧
    </button>


    <!-- Drawer Menu -->
    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex justify-end z-40">
        <div @click.away="open = false"
            class="w-72 h-full bg-gray-900 p-6 shadow-2xl transform transition-all duration-300"
            x-transition:enter="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-white">Menu</h4>
                <button @click="open = false" class="text-white hover:text-red-400 text-2xl">&times;</button>
            </div>

            <ul class="space-y-3">
                <li>
                    <a href="{{ route("peserta.produksi") }}" class="block px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md transition">
                        🔧 Rakit Sepeda
                    </a>
                </li>
                <li>
                    <a href="{{ route("peserta.jual") }}" class="block px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-md transition">
                        💵 Jual Sepeda
                    </a>
                </li>
                <li>
                    <a href="{{ route('peserta.komponen') }}" class="block px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl shadow-md transition">
                        📦 Inventory
                    </a>
                </li>
                <li>
                    <a href="{{ route('peserta.peserta.performance') }}"
                        class="block px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl shadow-md transition">
                        📊 Performance
                    </a>
                </li>

            </ul>
        </div>
    </div>

    @php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $tim = Auth::user()->name;
    $uang = DB::table('teams')->where('nama_tim', $tim)->value('uang') ?? 0;
    $posList = DB::table('pos')->get();
    $riwayat = DB::table('riwayat_pos')
    ->where('peserta_namaTim', $tim)
    ->orderByDesc('waktu')
    ->limit(3)
    ->pluck('pos_id')
    ->toArray();

    $sesi = DB::table('sesi_rally1')->value('sesi_aktif') ?? 1;
    $sesiHarga = [
    1 => ['city' => 40, 'folding' => 75, 'mountain' => 60],
    2 => ['city' => 45, 'folding' => 80, 'mountain' => 65],
    3 => ['city' => 40, 'folding' => 75, 'mountain' => 60, 'unicycle' => 30],
    4 => ['city' => 30, 'folding' => 55, 'mountain' => 45, 'unicycle' => 20],
    ];
    $harga = $sesiHarga[$sesi] ?? [];
    @endphp

    <h1 class="text-4xl font-extrabold mb-6 text-white text-center drop-shadow-lg">
        Selamat Datang di <span class="text-yellow-400">IGBike</span>
    </h1>

    <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700">
        <h3 class="text-xl font-semibold mb-2 text-white">Halo, {{ $tim }} 👋</h3>
        <p class="text-lg text-gray-300">
            💰 <span class="font-medium">Uang saat ini:</span>
            <span class="text-green-400 font-bold">${{ $uang }}</span>
        </p>
    </div>

    <div class="bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-gray-200 font-semibold">
                <strong>Sesi saat ini:</strong> <span class="text-blue-400">{{ $sesi }}</span>
            </div>
            <div class="text-sm text-yellow-400 italic">⚡ Tren berubah setiap sesi</div>
        </div>

        <div class="mt-4">
            <strong class="text-gray-100">Sepeda tersedia & harga:</strong>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach(($harga ?? []) as $jenis => $h)
                <span class="px-3 py-1 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 text-sm shadow hover:scale-105 transition">
                    {{ ucfirst($jenis) }} — ${{ $h }}
                </span>
                @endforeach
            </div>
        </div>

        @if(isset($sesi) && $sesi >= 3)
        <p class="mt-3 text-green-400 italic">✅ Unicycle siap untuk diproduksi!</p>
        @else
        <p class="mt-3 text-orange-400 italic">⏳ Unicycle akan muncul di Sesi 3.</p>
        @endif
    </div>

    <hr class="border-gray-600">

    <h3 class="text-xl font-semibold mb-4 text-gray-200">📍 Status Seluruh Pos</h3>

    <div class="space-y-4">
        @foreach ($posList as $pos)
        @php
        $sudahDikunjungiBaruBaruIni = in_array($pos->id, $riwayat);
        $statusColor = match($pos->status) {
        'kosong' => 'bg-green-100 text-green-900 border-green-300',
        'butuh_grup' => 'bg-yellow-100 text-yellow-900 border-yellow-300',
        'terisi' => 'bg-red-100 text-red-900 border-red-300',
        default => 'bg-gray-100 text-gray-800 border-gray-300'
        };
        @endphp
        <div class="rounded-xl shadow-md p-4 border {{ $statusColor }} transition hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h4 class="text-lg font-bold">{{ $pos->nama }}</h4>
                    <p class="text-sm">{{ ucfirst(str_replace('_', ' ', $pos->status)) }}</p>
                </div>
                <form action="{{ route('peserta.pos.pergi', $pos->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed transition"
                        {{ $sudahDikunjungiBaruBaruIni ? 'disabled' : '' }}>
                        Pergi ke Pos
                    </button>
                </form>
            </div>
            @if ($sudahDikunjungiBaruBaruIni)
            <p class="text-sm italic text-gray-600">⚠️ Sudah dikunjungi baru-baru ini. Kunjungi 3 pos lain terlebih dahulu.</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection