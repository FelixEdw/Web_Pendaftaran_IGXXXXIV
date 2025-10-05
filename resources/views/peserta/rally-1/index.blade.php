@extends('layouts.rally-1')
<script src="//unpkg.com/alpinejs" defer></script>

@push('head')
<!-- Alpine.js buat handle drawer -->
@endpush

<style>
    /* 1. Latar Belakang Body Disesuaikan dengan Tema Gelap IG */
    body {
        background-color: #14191A !important; 
        font-family: 'Inter', sans-serif;
    }

    /* 2. Custom Class untuk Tombol Utama & Aksen Bronze/Emas Tua */
    .btn-bronze {
        background-color: #956238; /* Bronze */
        color: #FFFFFF;
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-bronze:hover {
        background-color: #A57248;
        transform: translateY(-1px);
    }
    .btn-bronze:disabled {
        background-color: #5A402D; /* Darker bronze for disabled state */
        cursor: not-allowed;
    }

    /* 3. Custom Class untuk Pos Status agar tetap gelap */
    /* Pos Kosong: Dark Green/Bronze Tint */
    .status-kosong {
        background-color: #602c00; 
        color: #FFDA89;
        border-color: #602c10;
    }
    /* Pos Butuh Grup: Dark Yellow/Olive Tint */
    .status-butuh-grup {
        background-color: #4C4C2D; 
        color: #FFDA89;
        border-color: #73734C;
    }
    /* Pos Terisi: Dark Red/Maroon Tint */
    .status-terisi {
        background-color: #5C2D2D; 
        color: #FFB8B8;
        border-color: #854D4D;
    }
    /* Pos Default */
    .status-default {
        background-color: #2C2C3A; 
        color: #CFCFCF;
        border-color: #4A4A63;
    }

    /* 4. Notifikasi Toast Disesuaikan */
    .toast-success {
        background-color: #1E3929;
        color: #B8E6B8;
        border-color: #4C734C;
    }
    .toast-error {
        background-color: #391E1E;
        color: #FFB8B8;
        border-color: #734C4C;
    }
</style>

{{-- Pesan Sesi: Menggunakan custom class toast-success/error --}}
@if (session('success'))
<div class="max-w-2xl mx-auto p-3 rounded-xl toast-success font-semibold flex items-center gap-2 mb-4 shadow-md mt-4 border">
    ✅ {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="max-w-2xl mx-auto p-3 rounded-xl toast-error font-semibold flex items-center gap-2 mb-4 shadow-md mt-4 border">
    ❌ {{ session('error') }}
</div>
@endif

@section("content")
<div x-data="{ open: false }" class="p-6 max-w-4xl mx-auto space-y-6 relative">

    {{-- Floating Action Button (FAB) --}}
    <button
        @click="open = true"
        style="position: fixed; bottom: 1.5rem; left: 1.5rem; z-index: 9999;"
        class="text-white text-xl btn-bronze p-4 rounded-full shadow-xl transition transform hover:scale-110 focus:outline-none">
        ⚙️
    </button>


    <!-- Drawer Menu -->
    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-70 flex justify-end z-40">
        {{-- Drawer Background: Dark IG Navy/Charcoal --}}
        <div @click.away="open = false"
            style="background-color: #602c00;"
            class="w-72 h-full p-6 shadow-2xl transform transition-all duration-300x"
            x-transition:enter="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="translate-x-0"
            x-transition:leave-end="translate-x-full">

            <div class="flex justify-between items-center mb-6 pb-3">
                {{-- Judul Menu: Bright Gold --}}
                <h4 class="text-xl font-bold text-white">Menu Utama</h4>
                <button @click="open = false" class="text-gray-400 hover:text-red-500 text-3xl transition">&times;</button>
            </div>

            <ul class="space-y-4">
                {{-- Rakit Sepeda: Bronze Button --}}
                <li>
                    <a href="{{ route("peserta.produksi") }}" class="block px-4 py-3 btn-bronze rounded-lg shadow-lg hover:shadow-xl transition font-medium">
                        🔧 Rakit Sepeda
                    </a>
                </li>
                {{-- Jual Sepeda: Dark Gold Button --}}
                <li>
                    <a href="{{ route("peserta.jual") }}" class="block px-4 py-3 btn-bronze text-white rounded-lg shadow-lg hover:shadow-xl transition font-medium">
                        💵 Jual Sepeda
                    </a>
                </li>
                {{-- Inventory: Darker Accent Color --}}
                <li>
                    <a href="{{ route('peserta.komponen') }}" class ="block px-4 py-3 btn-bronze text-white rounded-lg shadow-lg hover:shadow-xl transition font-medium">
                        📦 Inventory
                    </a>
                </li>
                {{-- Performance: Bronze Button --}}
                <li>
                    <a href="{{ route('peserta.peserta.performance') }}"
                        class="block px-4 py-3 btn-bronze text-white rounded-lg shadow-lg hover:shadow-xl transition font-medium">
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

    {{-- Judul Halaman --}}
    <h1 class="text-4xl font-extrabold mb-6 text-white text-center drop-shadow-md">
        Selamat Datang di <span style="color: #FBC02D;" class="drop-shadow-lg">IGBike</span>
    </h1>

    {{-- Card Status Uang --}}
    {{-- Background: Dark IG Navy/Charcoal, Border: Bronze --}}
    <div style="background-color: #602c00; border-color: #956238;" class="rounded-2xl p-6 shadow-2xl border-2">
        <h3 class="text-xl font-bold mb-2 text-white">Halo, {{ $tim }} 👋</h3>
        <p class="text-lg text-gray-300">
            <span class="font-medium">💰 Uang saat ini:</span>
            {{-- Text: Bright Gold --}}
            <span style="color: #FBC02D;" class="font-extrabold text-2xl drop-shadow-md">${{ $uang }}</span>
        </p>
    </div>

    {{-- Card Status Sesi & Harga --}}
    {{-- Background: Dark IG Navy/Charcoal, Border: Bronze --}}
    <div style="background-color: #602c00; border-color: #956238;" class="rounded-2xl p-6 shadow-2xl border-2">
        <div class="flex items-center justify-between pb-3 mb-3">
            <div class="text-gray-200 font-bold">
                <span class="text-lg">Sesi saat ini:</span> 
                {{-- Text: Bright Gold --}}
                <span style="color: #FBC02D;" class="text-2xl font-extrabold">{{ $sesi }}</span>
            </div>
            <div class="text-sm text-yellow-400 italic">⚡ Tren berubah setiap sesi</div>
        </div>

        <div class="mt-4">
            <strong class="text-gray-100 block mb-3">Sepeda tersedia & harga:</strong>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach(($harga ?? []) as $jenis => $h)
                {{-- Background: Dark Navy, Border: Bronze, Text: Bright Gold --}}
                <span style="background-color: #391E1E; border-color: #956238;" class="px-4 py-2 border rounded-xl text-gray-100 text-sm font-semibold shadow hover:scale-[1.02] transition duration-200 ease-in-out">
                    {{ ucfirst($jenis) }} — <span style="color: #FBC02D;" class="font-bold">${{ $h }}</span>
                </span>
                @endforeach
            </div>
        </div>

        @if(isset($sesi) && $sesi >= 3)
        <p style="color: #FBC02D;" class="mt-3 italic">✅ Unicycle siap untuk diproduksi!</p>
        @else
        <p class="mt-3 text-yellow-400 italic">⏳ Unicycle akan muncul di Sesi 3.</p>
        @endif
    </div>

    <hr class="border-brown-700 mt-8 mb-6">

    {{-- Subjudul: Bright Gold --}}
    <h3 class="text-2xl font-bold mb-4" style="color: #FFFFFF;">📍 Status Seluruh Pos</h3>

    {{-- Daftar Status Pos --}}
    <div class="space-y-4">
        @foreach ($posList as $pos)
        @php
        $sudahDikunjungiBaruBaruIni = in_array($pos->id, $riwayat);
        
        $statusClass = match($pos->status) {
            'kosong' => 'status-kosong',
            'butuh_grup' => 'status-butuh-grup',
            'terisi' => 'status-terisi',
            default => 'status-default'
        };
        $statusText = match($pos->status) {
            'kosong' => 'POS KOSONG',
            'butuh_grup' => 'MENUNGGU REKAN',
            'terisi' => 'SEDANG DIGUNAKAN',
            default => 'STATUS TIDAK DIKETAHUI'
        };
        @endphp
        
        {{-- Menggunakan Custom Class untuk Card Status Pos --}}
        <div class="rounded-xl shadow-lg p-5 border-2 {{ $statusClass }} transition hover:shadow-xl hover:-translate-y-1 duration-200 ease-in-out">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                <div class="mb-3 sm:mb-0">
                    <h4 class="text-xl font-extrabold mb-1">{{ $pos->nama }}</h4>
                    <p class="text-sm font-semibold italic">{{ $statusText }}</p>
                </div>
                
                <form action="{{ route('peserta.pos.pergi', $pos->id) }}" method="POST">
                    @csrf
                    {{-- Tombol "Pergi ke Pos": Bronze Button --}}
                    <button type="submit" class="px-5 py-2 btn-bronze rounded-lg font-bold text-white transition shadow-md"
                        {{ $sudahDikunjungiBaruBaruIni ? 'disabled' : '' }}>
                        Pergi ke Pos
                    </button>
                </form>
            </div>
            
            {{-- Pesan Peringatan --}}
            @if ($sudahDikunjungiBaruBaruIni)
            <p class="text-sm italic mt-2 opacity-80">
                ⚠️ Sudah dikunjungi baru-baru ini. Kunjungi 3 pos lain terlebih dahulu.
            </p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
