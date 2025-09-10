@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');

    @font-face {
    font-family: 'Firlest';
    src: url('/fonts/Firlest.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

    body {
        background-color: #0c0c0c;
        color: white;
        background-image: url('{{ asset('images/Background_SingleRegistration.png') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
    }

    .form-container {
        background-color: rgba(255, 255, 255, 0.35);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .form-input {
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: white;
        width: 100%;
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-input:focus {
        outline: none;
        border: 1px solid white;
        background-color: rgba(255, 255, 255, 0.3);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background-color: #A8814F;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.25);
        border-radius: 9999px;
        padding: 0.75rem 2.5rem;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #c1812eff;
        transform: translateY(-2px);
    }

    .section-title {
    font-family: 'Pirata One', cursive;
    font-size: 3rem;
    margin-bottom: 1rem;
}

.font-pirata {
    font-family: 'Pirata One', cursive;
}

.font-firlest {
    font-family: 'Firlest', serif;
}

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>

<div class="bg-[#0c0c0c] bg-opacity-10 min-h-screen flex flex-col items-center justify-start py-10 px-4">
    <img src="{{ asset('images/Registration_Tulisan.png') }}" alt="Registration Title" class="section-title w-full max-w-lg object-contain mt-64">

    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl space-y-12">
        @csrf

        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded-lg">
                <strong class="block mb-2">Registrasi Gagal! Harap periksa kembali data Anda:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
           <h2 class="text-4xl font-pirata text-white text-center mb-4">NAMA TEAM</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="nama_tim" placeholder="Nama Tim" class="form-input" required>
                <input type="password" name="password" placeholder="Password Tim" class="form-input" required>
                <input type="text" name="asal_sekolah" placeholder="Asal Sekolah" class="form-input md:col-span-2" required>
            </div>
        </div>

        @for ($i = 0; $i < 3; $i++)
            <div class="form-container">
                <h2 class="text-lg font-bold text-white mb-4">Data Anggota {{ $i + 1 }}{{ $i === 0 ? ' (Ketua)' : '' }}</h2>
                @include('auth.partials.team_form_single', ['index' => $i])
            </div>
        @endfor

        <div class="form-container">
            <h2 class="text-4xl font-pirata text-white text-center mb-4">UPLOAD BUKTI PEMBAYARAN</h2>
            <p class="text-sm text-gray-300 mt-1 mb-2">
             Pembayaran paket single EarlyBird: 175.000.<br>Transfer ke 003455403312 / BLU (BCAD) atas nama Kimberly Callista Mindarto.
            </p>
            <input type="file" name="foto_bukti_pembayaran" class="form-input" required>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="btn-primary">Daftarkan Tim</button>
        </div>
    </form>
</div>
@endsection
