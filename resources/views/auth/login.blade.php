@extends('layouts.app')
@section("content")

<section class="relative min-h-screen bg-cover bg-center font-poppins" style="background-image: url('{{ asset('images/Background_Industrial_Games.png') }}');">
    {{-- Container utama, fleksibel, terpusat, dengan padding responsif --}}
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        {{-- Kontainer card login, max-w lebih kecil di mobile, overflow-hidden --}}
        <div class="w-full max-w-sm sm:max-w-xl md:max-w-5xl rounded-xl shadow-2xl overflow-hidden bg-white/40 backdrop-blur-lg flex flex-col md:flex-row">
            
            {{-- Bagian Kiri: Gambar Jam (Sembunyikan di Mobile) --}}
            <div class="hidden md:flex w-full md:w-1/2 items-center justify-center">
                <img src="{{ asset('images/Login_Image.png') }}" alt="Industrial Games Login Visual" class="w-full h-auto object-contain">
            </div>

            {{-- Bagian Kanan: Form Login (Glassmorphism) --}}
            <div class="w-full p-6 sm:p-8 md:w-1/2 md:p-12 flex flex-col justify-center">
                <div class="text-center mb-6">
                    <h2 class="text-3xl sm:text-4xl font-poppins text-[#FFFFFF] font-bold">
                        LOGIN
                    </h2>
                    <p class="mt-2 text-sm text-gray-300">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-[#d6b05b] hover:underline">Daftar di sini</a>
                    </p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1 font-poppins">Nama Tim</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="username" required
                            class="w-full px-4 py-2 rounded-md border bg-white/80 text-gray-500 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#d6b05b] focus:border-[#d6b05b] @error('name') border-red-500 @else border-gray-500 @enderror"
                            placeholder="Masukkan Nama Tim">
                        @error('name')
                            <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-2 rounded-md border bg-white/80 text-gray-500 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#d6b05b] focus:border-[#d6b05b] @error('password') border-red-500 @else border-gray-500 @enderror"
                            placeholder="Masukkan Password">
                        @error('password')
                            <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                                class="w-full py-2 px-4 bg-[#d6b05b] hover:bg-[#b99743] text-black font-semibold rounded-md shadow-md transition duration-200">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection