@extends('layouts.app')
@section('content')

<section class="min-h-screen bg-cover bg-center font-poppins relative" style="background-image: url('{{ asset('images/Background_Industrial_Games.png') }}');">
    <div class="absolute inset-0 bg-[#2D333B] bg-opacity-70 flex flex-col items-center p-4">

        {{-- Arrow icon di pojok kiri atas --}}
        <a href="{{ route('peserta.rally-1.index') }}" class="absolute top-8 left-8 text-white z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>

        {{-- Judul Halaman --}}
        <h2 class="text-white text-3xl sm:text-4xl font-bold mt-16 mb-8 text-center uppercase tracking-widest">
            Produksi Sepeda
        </h2>

        {{-- Container untuk pesan sukses atau error --}}
        @if (session('success'))
            <div class="bg-green-500 text-white py-2 px-4 rounded-lg mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white py-2 px-4 rounded-lg mb-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Kontainer utama dengan efek glassmorphism --}}
        <div class="w-full max-w-4xl bg-white/20 backdrop-blur-lg rounded-2xl p-6 sm:p-8 grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

            @foreach ($resep as $jenis => $syarat)
                <div class="bg-white/10 rounded-xl p-6 flex flex-col items-center text-white text-center shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">{{ ucfirst($jenis) }} Bike</h3>
                    
                    {{-- Ikon Sepeda --}}
                    @php
                        $icon = '';
                        switch($jenis) {
                            case 'city':
                                $icon = 'City_Bike_Icon.png';
                                break;
                            case 'folding':
                                $icon = 'Folding_Bike_Icon.png';
                                break;
                            case 'mountain':
                                $icon = 'Mountain_Bike_Icon.png';
                                break;
                            case 'unicycle':
                                $icon = 'Unicycle_Icon.png';
                                break;
                            default:
                                $icon = 'default_bike.png';
                        }
                    @endphp
                    <img src="{{ asset('images/' . $icon) }}" alt="{{ ucfirst($jenis) }} Bike Icon" class="w-24 h-24 mb-4">

                    <p class="text-sm text-gray-200 mb-2 font-semibold">Bahan yang dibutuhkan:</p>
                    <ul class="text-left w-full space-y-2 mb-6">
                        @php $cukup = true; @endphp
                        @foreach ($syarat as $komponen => $jumlah)
                            @php
                                $punya = $data->$komponen ?? 0;
                                $status = $punya >= $jumlah ? '✅' : '❌';
                                if ($punya < $jumlah) $cukup = false;
                            @endphp
                            <li class="flex justify-between items-center text-sm">
                                <span>{{ ucwords(str_replace('_', ' ', $komponen)) }} ({{ $jumlah }})</span>
                                <span class="flex items-center">
                                    <span class="mr-2">{{ $punya }}</span> <strong>{{ $status }}</strong>
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('peserta.produksi.sepeda', $jenis) }}" method="POST" class="w-full mt-auto">
                        @csrf
                        <button type="submit" 
                            class="w-full py-3 px-6 rounded-full font-bold transition-all duration-300
                            {{ $cukup ? 'bg-[#D6B05B] text-black hover:bg-[#b99743] shadow-md' : 'bg-gray-500 text-gray-300 cursor-not-allowed' }}"
                            {{ $cukup ? '' : 'disabled' }}>
                            🚲 Rakit {{ ucfirst($jenis) }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection