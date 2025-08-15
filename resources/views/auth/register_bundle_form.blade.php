@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');

    body {
        background-color: #0c0c0c;
        color: white;
        background-image: url('{{ asset('images/Background_BundleRegistration.png') }}');
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
        background-color: rgba(255, 255, 255, 0.35);
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: white;
        width: 100%;
    }
    .form-input::placeholder { color: rgba(255, 255, 255, 0.7); }
    .form-input:focus {
        outline: none;
        border: 1px solid white;
        background-color: rgba(255, 255, 255, 0.3);
    }
    .form-label { font-weight: 600; margin-bottom: 0.5rem; }
    .btn-primary {
        background-color: rgba(255, 255, 255, 0.1);
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
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    .section-title { font-family: 'Pirata One', cursive; font-size: 3rem; margin-bottom: 1rem; }
    .font-pirata { font-family: 'Pirata One', cursive; }
    .font-firlest { font-family: 'Firlest', serif; }
    @media (max-width: 768px) {
        .form-container { padding: 1rem; }
        .section-title { font-size: 2rem; }
    }
</style>

<div class="bg-[#0c0c0c] bg-opacity-0 min-h-screen flex flex-col items-center justify-start py-10 px-4">
    <img src="{{ asset('images/Registration_Tulisan.png') }}" alt="Registration Title" class="section-title w-full max-w-lg object-contain mt-[175px]">

    <form action="{{ route('register.bundle.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-4xl space-y-12">
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

        <div id="step-1" class="form-step">
            <div class="form-container mb-12">
                <h2 class="text-4xl font-pirata text-white text-center mb-4">ASAL SEKOLAH</h2>
                <input type="text" name="asal_sekolah" placeholder="Asal Sekolah" value="{{ old('asal_sekolah') }}" class="form-input" required>
            </div>
            <div class="form-container">
                <h2 class="text-3xl font-bold text-white mb-4 text-center font-pirata">DATA TIM 1</h2>
                {{-- Memanggil partial form untuk tim pertama (index 0) --}}
                @include('auth.partials.team_form', ['team_index' => 0])
            </div>
        </div>

        <div id="step-2" class="form-step hidden">
            <div class="form-container">
                <h2 class="text-3xl font-bold text-white mb-4 text-center font-pirata">DATA TIM 2</h2>
                {{-- Memanggil partial form untuk tim kedua (index 1) --}}
                @include('auth.partials.team_form', ['team_index' => 1])
            </div>
        </div>

        <div id="step-3" class="form-step hidden">
            <div class="form-container">
                <h2 class="text-3xl font-bold text-white mb-4 text-center font-pirata">DATA TIM 3</h2>
                {{-- Memanggil partial form untuk tim ketiga (index 2) --}}
                @include('auth.partials.team_form', ['team_index' => 2])
            </div>

            <div class="form-container mt-12">
                <h2 class="text-4xl font-pirata text-white text-center mb-4">UPLOAD BUKTI PEMBAYARAN</h2>
                <p class="text-sm text-gray-300 mt-1 mb-2">
                Pembayaran paket bundle EarlyBird: 495.000.<br> Transfer ke 003455403312 / BLU (BCAD) atas nama Kimberly Callista Mindarto.
                </p>
                <input type="file" name="foto_bukti_pembayaran" class="form-input" required>
            </div>
        </div>


        <div class="mt-8 flex justify-between">
            <button type="button" id="prev-btn" class="btn-primary hidden">Previous</button>
            <button type="button" id="next-btn" class="btn-primary ml-auto">Next</button>
            <button type="submit" id="submit-btn" class="btn-primary hidden ml-auto">Daftarkan Semua Tim</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.form-step');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        let currentStep = 0;

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== stepIndex);
            });

            prevBtn.classList.toggle('hidden', stepIndex === 0);
            nextBtn.classList.toggle('hidden', stepIndex === steps.length - 1);
            submitBtn.classList.toggle('hidden', stepIndex !== steps.length - 1);
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Initialize the form
        showStep(currentStep);
    });
</script>
@endsection