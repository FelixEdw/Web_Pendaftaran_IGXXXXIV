@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-cover bg-center font-poppins relative" style="background-image: url('{{ asset('images/Background_Industrial_Games.svg') }}');">
    <div class=" bg-[#2D333B] bg-opacity-5 flex flex-col justify-center items-center p-4 mx-12">

        {{-- Arrow icon di pojok kiri atas --}}
        <a href="{{ route('peserta.rally-1.index') }}" class="absolute top-8 left-8 text-white z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>

       {{-- Judul Halaman sebagai Gambar --}}
        <img src="{{ asset('images/Gambar_Components.svg') }}" alt="Components Title" class="w-2/3 sm:w-1/2 md:w-1/3 h-auto max-w-sm mt-20 mb-8">

        {{-- Kontainer komponen dengan efek glassmorphism --}}
        <div class="w-full max-w-4xl bg-white/20 backdrop-blur-lg rounded-2xl p-6 sm:p-8">
            <h3 class="text-white text-2xl font-semibold mb-6 text-center">Inventory {{ $tim }}</h3>

            @if ($komponen)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

                    {{-- Pedal --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Gambar_Pedal_dan_Brake.png') }}" alt="Pedal Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Brake and Pedal</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->brake_and_pedal }}</span>
                    </div>

                    {{-- Chain & Gear --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Gambar_Chain_And_Gear.png') }}" alt="Chain & Gear Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Chain & Gear</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->chain_and_gear }}</span>
                    </div>
                    
                    {{-- Brake --}


                    {{-- Wheel --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Gambar_Roda_27.png') }}" alt="Wheel Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Wheel</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->wheel }}</span>
                    </div>

                    {{-- Tambahkan item lain di sini sesuai data Anda --}}
                    {{-- City Frame --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/City_Frame_Icon.png') }}" alt="City Frame Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">City Frame</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->city_frame }}</span>
                    </div>
                    
                    {{-- Folding Frame --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Folding_Frame_Icon.png') }}" alt="Folding Frame Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Folding Frame</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->folding_frame }}</span>
                    </div>
                    
                    {{-- Mountain Frame --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Mountain_Frame_Icon.png') }}" alt="Mountain Frame Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Mountain Frame</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->mountain_frame }}</span>
                    </div>
                    
                    {{-- Unicycle Frame --}}
                    <div class="bg-white/20 rounded-xl p-4 flex flex-col items-center text-white text-center">
                        <img src="{{ asset('images/Unicycle_Frame_Icon.png') }}" alt="Unicycle Frame Icon" class="w-16 h-16 mb-2">
                        <span class="font-medium">Unicycle Frame</span>
                        <span class="mt-2 text-3xl font-bold">{{ $komponen->unicycle_frame }}</span>
                    </div>
                </div>
            @else
                <p class="text-white text-center text-xl mt-8">❌ Belum ada data komponen untuk tim ini.</p>
            @endif
        </div>
    </div>
</section>
@endsection