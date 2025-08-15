@extends("layouts.app")

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
@section("content")
  <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 56px; /* Sesuaikan dengan tinggi header fixed */
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2d3748;
        }
        ::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
<body class="bg-[#14191A] text-white">

   

    <!-- Account Section -->
   <section class="relative py-16 px-4 flex flex-col items-center justify-center min-h-screen font-poppins" style="background-image: url('{{ asset('images/Background_Industrial_Games.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-10"></div> <!-- Overlay -->
        
        <div class="relative z-10 w-full max-w-2xl bg-gray-800 p-8 rounded-lg shadow-xl text-center">
            <h2 class="text-3xl font-bold mb-8 text-yellow-400">Data Tim Anda</h2>
            
            <div class="space-y-6 text-left">
                <!-- Nama Tim -->
                <div class="bg-gray-700 p-4 rounded-md shadow-inner">
                    <p class="text-gray-300 text-lg">Nama Tim:</p>
                    {{-- Mengambil nama tim dari variabel $teamData --}}
                    <p class="text-white text-2xl font-semibold">{{ $team->nama_tim ?? 'Nama Tim Belum Tersedia' }}</p>
                </div>

                <!-- Data Peserta -->
                <div class="bg-gray-700 p-4 rounded-md shadow-inner">
                    <p class="text-gray-300 text-lg mb-2">Nama Peserta:</p>
                    <ul class="list-disc list-inside text-white text-xl ml-4 space-y-1">
                        {{-- Melakukan loop untuk setiap peserta --}}
                       @forelse ($team?->members ?? [] as $anggota)
                            <li>{{ $anggota->nama_lengkap }}</li>
                        @empty
                            <li>Data Peserta Belum Tersedia</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Status Pembayaran -->
                <div class="bg-gray-700 p-4 rounded-md shadow-inner">
                    <p class="text-gray-300 text-lg">Status Pembayaran:</p>
                 {{-- Menyesuaikan warna teks berdasarkan status pembayaran --}}
                @if ($team && $team->ver_bukti_bayar)
                    <p class="text-green-400 text-2xl font-bold">Verified</p>
                @else
                    <p class="text-yellow-400 text-2xl font-bold">Unverified</p>
                @endif
                </div>
            </div>

            <div class="mt-10">
                 <a href="{{ url('/') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition duration-300 shadow-lg hover:shadow-xl">
                    Kembali ke Home
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mt-4">
                    Logout
                </button>
            </form>
        </div>
    </section>
</body>
@endsection
  