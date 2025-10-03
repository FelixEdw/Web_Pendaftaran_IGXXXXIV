@extends('layouts.app')

<style>
    /* 1. Latar Belakang & Font */
    body {
        background-color: #602c10 !important; 
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
    
    /* Tombol Aksen Kuning/Emas (untuk Ubah Sesi) */
    .btn-gold-accent {
        background-color: #FBC02D;
        color: #14191A;
        font-weight: bold;
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-gold-accent:hover {
        background-color: #FFC74B;
        transform: translateY(-1px);
    }
    
    /* Latar Belakang Card (Dark Brown - sama seperti Card Peserta) */
    .card-dark-ig {
        background-color: #602c00; 
        border: 2px solid #956238; /* Border Bronze */
    }

    /* 3. Style Baru: Border Berisi untuk Judul */
    /* Warna: Bright Gold */
    .text-outline-gold {
        color: transparent; /* Membuat teks asli transparan */
        -webkit-text-stroke: 2px #FBC02D; /* Border Emas */
        text-stroke: 2px #FBC02D;
        position: relative;
    }
    /* Shadow untuk memberi kesan kedalaman (opsional) */
    .text-outline-gold::before {
        content: attr(data-text); 
        position: absolute;
        top: 0;
        left: 0;
        color: #FBC02D; /* Fill color Emas */
        text-shadow: 0 0 10px rgba(251, 192, 45, 0.4); 
        z-index: -1;
        -webkit-text-stroke: 0; /* Hapus stroke pada fill */
        opacity: 0.1;
    }

    /* 4. Style Baru: Tombol Pos dengan Border Bronze Khas IG */
    .btn-pos-ig {
        background-color: #391E1E; /* Dark Red/Brown Tint */
        color: #FFDA89; /* Light Gold/Yellow Text */
        border: 2px solid #956238; /* Border Bronze */
        transition: background-color 0.2s, transform 0.1s, border-color 0.2s;
    }
    .btn-pos-ig:hover {
        background-color: #4C2929;
        transform: scale(1.01);
        border-color: #FFDA89; /* Border menyala saat di-hover */
    }

</style>

@section('content')
<div class="max-w-xl mx-auto p-6">
    {{-- Judul: Menggunakan style baru text-outline-gold --}}
    <h1 class="text-3xl font-extrabold text-center mb-8" 
        data-text="👋 Selamat Datang, Admin" 
        class="text-3xl font-extrabold text-center mb-8 text-outline-gold">
        👋 Selamat Datang, Admin
    </h1>
    
    {{-- Header dengan Tombol Ubah Sesi --}}
    <div class="flex justify-between items-center mb-6 pb-3">
        {{-- Sub Judul: White/Gray --}}
        <h3 class="text-xl font-bold text-gray-200">Rally 1 - Daftar Pos</h3>
        
        {{-- Tombol Ubah Sesi: Gold Accent --}}
        <a href="{{ route('admin.sesi') }}" class="btn-gold-accent px-4 py-2 rounded-lg shadow-md">
            ⚙️ Ubah Sesi
        </a>
    </div>

    {{-- Daftar Pos Card --}}
    <div class="card-dark-ig rounded-2xl p-6 shadow-2xl text-white">
        <p class="text-lg mb-6 font-semibold text-gray-200">Silahkan pilih pos yang ingin kamu kelola:</p>

        {{-- Daftar Pos: Menggunakan class kustom btn-pos-ig dengan border Bronze --}}
        <ul class="space-y-4">
            <li>
                <a href="{{ route('admin.pos', ['id' => 1]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Scrambled
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 2]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Code 24
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 3]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Line Trap
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 4]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Signal Override
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 5]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Blind Retrieval
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 6]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Tic Tac Think
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 7]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Mission Escape
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 8]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Flag Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 9]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Command Trigger
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 10]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Ball Relay Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 11]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Throw Zone
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 12]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Quiz Blits
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 13]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Flip & Think
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 14]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Memory Minefield
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 15]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Sketch Relay
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 16]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Number Game, Open Up!
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 17]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Word Assembly Race
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 18]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Rubber Pass
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 19]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Knowledge Bid
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 20]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Mystery Match
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 21]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Tower Tangle
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 22]) }}"
                    class="block px-5 py-3 btn-pos-ig rounded-xl shadow font-semibold transition">
                    📍 Connected Pipes
                </a>
            </li>
        </ul>
    </div>
</div>
@endsection