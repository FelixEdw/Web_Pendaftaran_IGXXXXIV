@extends("layouts.app")
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
@section("content")
<section class="relative min-h-screen bg-cover bg-center font-poppins" style="background-image: url('{{ asset('images/Background_Industrial_Games.svg') }}');">
  <div class="absolute inset-0 bg-black bg-opacity-5 flex flex-col justify-start items-center text-center pt-20 px-4 sm:px-6 md:px-8">
     <img src="{{ asset('images/Industrial_Games_Tulisan.png') }}" 
     alt="Industrial Games Title" 
     class="w-[90%] sm:w-full max-w-[700px] h-auto mb-4 mt-10">

      <p class="text-lg sm:text-2xl md:text-3xl font-semibold mb-10 leading-relaxed">
        Integrated System through Quality & Performance<br>
        Management for Industrial Growth
      </p>

      {{-- TOMBOL REGISTER DIBUAT LEBIH MENONJOL --}}
      <a href="{{ url('/register') }}" 
         class="bg-[#9F7041] text-white text-xl sm:text-2xl px-8 py-4 sm:px-10 sm:py-5 rounded-full font-bold shadow-xl mb-20 transform hover:scale-105 transition-transform duration-300">
         REGISTER NOW
      </a>

      <p class="text-3xl sm:text-3xl md:text-4xl font-bold text-white text-center mt-10">
        WIN A TOTAL OF<br>
        100++ MILLIONS
      </p>
  </div>
</section>

<section class="bg-[#14191A] py-16 flex justify-center items-center relative" style="background-image: url('{{ asset('images/Background_Poster.svg') }}'); background-size: cover; background-position: center;">
    <div class="w-full max-w-md px-4 text-center">
        <img src="{{ asset('images/POSTER_IG.png') }}" alt="Industrial Games XXXIV Poster" class="mx-auto w-full h-auto shadow-lg rounded-lg">
    </div>
</section>

<section class="bg-[#14191A] py-16 relative" style="background-image: url('{{ asset('images/Background_Timeline.png') }}'); background-size: cover; background-position: center;">
    <div class="text-center px-4">
        <img src="{{ asset('images/Timeline_Tulisan.png') }}" alt="Timeline" class="mx-auto h-16 sm:h-24 md:h-32 mb-10">
        <img src="{{ asset('images/Timeline.png') }}" alt="Timeline Content" class="mx-auto w-full max-w-5xl h-auto">
    </div>
</section>

<section 
    class="bg-[#14191A] pt-16 pb-0 flex flex-col justify-center items-center text-center px-4" 
    style="background-image: url('{{ asset('images/Background_Prizes.png') }}'); background-size: cover; background-position: center;"
>
    <img 
        src="{{ asset('images/Prizes_Tulisan.png') }}" 
        alt="Prizes" 
        class="mx-auto h-16 sm:h-24 md:h-32 mb-10"
    >
    
    <div class="w-screen overflow-x-auto whitespace-nowrap">
        <img 
            src="{{ asset('images/Prizes.png') }}" 
            alt="Prizes Content" 
            class="h-auto inline-block min-w-full"
        >
    </div>
</section>
@endsection