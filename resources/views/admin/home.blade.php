@extends('layouts.app')



@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    /* Palet Warna Industrial Games (IG) */
    :root {
        --color-bg-dark: #602c10; /* Cokelat Gelap / Base */
        --color-card-dark: #391E1E; /* Dark Reddish Brown untuk Card/Input */
        --color-bronze: #956238; /* Bronze Border */
        --color-gold-accent: #FBC02D; /* Bright Gold Accent */
        --color-text-light: #FFDA89; /* Light Gold/Yellow Text */
        --color-text-white: #FFFFFF;
        --color-text-dark: #14191A;
        --color-button-secondary: #774320; /* Warna Cokelat Gelap untuk Link/Tombol Sekunder */
    }

    /* Override Tailwind classes untuk tema IG */

    /* Latar Belakang */
    .bg-dark-ig {
        background-color: var(--color-bg-dark);
    }
    
    /* Kartu Dashboard */
    .card-ig {
        background-color: var(--color-card-dark);
        border: 2px solid var(--color-bronze);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    /* Teks Emas */
    .text-gold-ig {
        color: var(--color-gold-accent);
    }
    
    /* Teks Light Gold */
    .text-light-ig {
        color: var(--color-text-light);
    }

    /* Tombol Utama (Emas) - Untuk Rally-1 & Rally-2 */
    .btn-primary-ig {
        background-color: var(--color-gold-accent);
        color: var(--color-text-dark); /* Teks gelap di atas latar emas */
        font-weight: 700;
        transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .btn-primary-ig:hover {
        background-color: #FFC74B; /* Emas sedikit lebih terang saat hover */
        transform: translateY(-2px);
    }

    /* Tombol Logout */
    .btn-logout-ig {
        background-color: #A31E1E; /* Merah Marun gelap */
        transition: all 0.2s;
    }
    .btn-logout-ig:hover {
        background-color: #C23737;
    }
</style>


@if (session('error'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 4000)" 
        class="fixed top-5 right-5 z-50 bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg transition-opacity"
    >
        {{ session('error') }}
    </div>
@endif

<div class="flex items-center justify-center min-h-screen bg-dark-ig">
    <div class="card-ig rounded-lg p-10 w-full max-w-md text-center">
        <!-- Judul Dashboard -->
        <h2 class="text-3xl font-bold text-gold-ig mb-3">Dashboard</h2>
        <p class="text-light-ig mb-8">Selamat datang, Anda berhasil masuk!</p>

        <div class="flex flex-col gap-5">
            <!-- Tombol Rally-1 (Emas) -->
            <a href="{{ route('admin.rally-1.index') }}" class="btn-primary-ig font-semibold py-4 rounded-xl">
                🚩 Rally-1
            </a>
            
            <!-- Tombol Rally-2 (Emas) -->
            <a href="{{ route('admin.rally-2.index') }}" class="btn-primary-ig font-semibold py-4 rounded-xl">
                🏁 Rally-2
            </a>
        </div>

        <!-- Tombol Logout (Merah Marun) -->
        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="btn-logout-ig w-full text-white py-3 rounded-lg hover:bg-red-700 transition duration-200">
                🔓 Logout
            </button>
        </form>
    </div>
</div>
@endsection
