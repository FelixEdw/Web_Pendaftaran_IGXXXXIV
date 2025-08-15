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

    <!-- Footer (Konsisten dengan halaman lain) -->
        <!-- PERUBAHAN DI SINI: Mengubah grid-cols-1 md:grid-cols-3 menjadi grid-cols-1 md:grid-cols-2 dan menambahkan grid-rows-2 -->
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-4">
            <!-- Social Media -->
            <div>
                <h3 class="text-3xl font-bold mb-4 mt-12">OUR SOCIAL MEDIA</h3>
                <ul>
                    <li class="mb-2"><a href="https://www.instagram.com/ig_ubaya" target="_blank" class="flex items-center hover:text-gray-300"><img src="{{ asset('icons/Instagram.png') }}" alt="Instagram" class="w-6 h-6 mr-2">@ig_ubaya</a></li>
                    <li class="mb-2"><a href="https://www.tiktok.com/@ig_ubaya?is_from_webapp=1&sender_device=pc" target="_blank" class="flex items-center hover:text-gray-300"><img src="{{ asset('icons/Tiktok.png') }}" alt="Tiktok" class="w-6 h-6 mr-2">@ig_ubaya</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div>
                <h3 class="text-3xl font-bold mb-4 mt-12">CONTACT US</h3>
                <ul>
                    <li class="mb-2 flex items-center"><img src="{{ asset('icons/Line.png') }}" alt="Line" class="w-6 h-6 mr-2">257saktt (admin)</li>
                    <li class="mb-2 flex items-center"><img src="{{ asset('icons/Whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6 mr-2">085103929088 (Philander)</li>
                    <li class="mb-2 flex items-center"><img src="{{ asset('icons/Whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6 mr-2">081330286135 (Rachel)</li>
                    <li class="mb-2 flex items-center"><img src="{{ asset('icons/Gmail.png') }}" alt="Email" class="w-6 h-6 mr-2">industrialgames.ubaya@gmail.com</li>
                </ul>
            </div>

            <!-- Sponsored By -->
            <!-- PERUBAHAN DI SINI: Menambahkan col-span-full untuk menempati lebar penuh di baris baru -->
            <div class="col-span-full mt-8"> <!-- Menambahkan margin-top untuk jeda dari bagian atas -->
                <h3 class="text-3xl font-bold mb-[200px]">SPONSORED BY:</h3>
                <div class="flex flex-wrap gap-4">
                    <!-- Placeholder for sponsor logos if any -->
                </div>
            </div>
        </div>
    </footer>

</body>
@endsection
  