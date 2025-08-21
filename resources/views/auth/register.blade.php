@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2d3748; /* bg-gray-800 */
        }
        ::-webkit-scrollbar-thumb {
            background: #4a5568; /* bg-gray-700 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0; /* bg-gray-400 */
        }
    </style>
<body class="bg-[#14191A] text-white">

   

    <!-- Main Content - Initial Registration Form -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 relative min-h-screen" style="background-image: url('{{ asset('images/Background_Registration.svg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay untuk background agar konten lebih menonjol -->
        <div class="absolute inset-0 bg-black bg-opacity-0"></div>

        <!-- PERUBAHAN DI SINI: Mengubah max-w-md menjadi max-w-4xl -->
        <div class="relative z-10 w-full max-w-4xl flex flex-col items-center">
            <!-- Tulisan "REGISTRATION" sebagai gambar -->
            <img src="{{ asset('images/Registration_Tulisan.png') }}" alt="Registration" class="mx-auto w-auto h-24 md:h-32 mb-6 mt-28">

            <form action="#" method="POST" class="space-y-8 w-full">

                <!-- Tombol Single Package dan Bundling Package -->
                <!-- PERUBAHAN DI SINI: Menghapus mb-64 -->
                <div class="flex flex-row space-x-4 justify-center w-full mt-4 mb-32">
                    <!-- PERUBAHAN DI SINI: Menambahkan href -->
                  <!-- TOMBOL SINGLE PACKAGE (FINAL) -->
                <a href="{{ route('register.single.form') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-4 px-8 md:px-32 rounded-full text-xl transition duration-300 shadow-lg hover:shadow-xl text-center">
                    Single Package
                </a>
                
                <!-- TOMBOL BUNDLING PACKAGE (FINAL) -->
                <a href="{{ route('register.bundle.form') }}" class="bg-[#956238] hover:bg-[#A57248] text-white font-bold py-4 px-8 md:px-32 rounded-full text-xl transition duration-300 shadow-lg hover:shadow-xl text-center">
                    Bundling Package
                </a>
                </div>
            </form>
        </div>
    </main>



</body>
@endsection