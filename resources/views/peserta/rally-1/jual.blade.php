@extends('layouts.app')
@section('content')

<section class="min-h-screen bg-cover bg-center font-poppins relative" style="background-image: url('{{ asset('images/Background_Industrial_Games.svg') }}');">
    <div class="bg-[#2D333B] bg-opacity-0 flex flex-col items-center p-4">

        {{-- Arrow icon di pojok kiri atas --}}
        <a href="{{ route('peserta.rally-1.index') }}" class="absolute top-8 left-8 text-white z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>

        {{-- Judul Halaman --}}
        <h2 class="text-white text-3xl sm:text-4xl font-bold mt-24 mb-8 text-center uppercase tracking-widest">
            Jual Sepeda Sesi {{ $sesi }}
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
        <
 @foreach ($harga as $jenis => $h)
                @php
                    $stokSepeda = $stok->$jenis ?? 0;
                    $icon = '';
                    switch($jenis) {
                        case 'city':
                            $icon = 'City_Bike.png';
                            break;
                        case 'folding':
                            $icon = 'Folding_Bike.png';
                            break;
                        case 'mountain':
                            $icon = 'Mountain_Bike.png';
                            break;
                        case 'unicycle':
                            $icon = 'Unicycle.png';
                            break;
                        default:
                            $icon = 'default_bike.png';
                    }
                @endphp

                <div class="bg-white/40 rounded-xl p-20 flex flex-col items-center text-white text-center shadow-lg mb-10">
                    <h3 class="text-xl font-semibold mb-4">{{ ucwords(str_replace('_', ' ', $jenis)) }}</h3>
                    
                    {{-- Ikon Sepeda --}}
                    <img src="{{ asset('images/' . $icon) }}" alt="{{ ucwords(str_replace('_', ' ', $jenis)) }} Icon" class="w-24 h-24 mb-4">

           
                    
                    <p class="font-medium">Stock: <span class="text-2xl font-bold">{{ $stokSepeda }}</span></p>
                    <p class="font-bold text-lg mb-4">Price: <span class="text-green-400">${{ number_format($h, 0, ',', '.') }}</span></p>

                    <form action="{{ route('peserta.jual.sepeda') }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menjual sepeda {{ ucwords(str_replace('_', ' ', $jenis)) }} seharga ${{ $h }} per unit?');"
                          class="w-full mt-auto">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ $jenis }}">
                        
                        <div class="w-full flex items-center justify-center mb-4">
                            <input type="number" name="jumlah" value="0" min="0" max="{{ $stokSepeda }}"
                                class="w-20 mx-2 text-center text-black bg-white rounded-md">
                        </div>
                        
                        <button type="submit" 
                            class="w-full py-3 px-6 rounded-full font-bold transition-all duration-300
                            {{ $stokSepeda > 0 ? 'bg-[#D6B05B] text-black hover:bg-[#b99743] shadow-md' : 'bg-gray-500 text-gray-300 cursor-not-allowed' }}"
                            {{ $stokSepeda > 0 ? '' : 'disabled' }}>
                            Sell
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection