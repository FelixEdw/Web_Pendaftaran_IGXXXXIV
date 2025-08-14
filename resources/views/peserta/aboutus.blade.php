@extends("layouts.app")

@section("content")
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        padding-top: 56px;
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

    .carousel-container {
        position: relative;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        background-color: white;
    }

    .carousel-slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel-slide {
        min-width: 100%;
        box-sizing: border-box;
    }

    .carousel-slide img {
        width: 100%;
        height: auto;
        display: block;
    }

    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 1.5rem;
        border-radius: 5px;
        z-index: 10;
    }

    .carousel-button.left {
        left: 10px;
    }

    .carousel-button.right {
        right: 10px;
    }
</style>

<!-- What is IG Section -->
<section class="relative py-16 px-4 min-h-screen flex items-center justify-center font-poppins" style="background-image: url('{{ asset('images/Background_WhatIsIg.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>

    <div class="relative z-10 w-full max-w-5xl text-center px-4">
        <img src="{{ asset('images/WhatIsIg_Tulisan.png') }}" alt="What is IG" class="mx-auto h-14 sm:h-20 md:h-28 lg:h-32 mb-6">

        <div class="carousel-container mb-8 mx-auto w-full lg:max-w-3xl">
            <div class="carousel-slides" id="carouselSlides">
                <div class="carousel-slide"><img src="images/DOKUM_1.jpg" alt="Carousel Image 1"></div>
                <div class="carousel-slide"><img src="images/DOKUM_2.jpg" alt="Carousel Image 2"></div>
                <div class="carousel-slide"><img src="images/DOKUM_3.jpg" alt="Carousel Image 3"></div>
                <div class="carousel-slide"><img src="images/DOKUM_4.jpg" alt="Carousel Image 4"></div>
                <div class="carousel-slide"><img src="images/DOKUM_5.jpg" alt="Carousel Image 5"></div>
                <div class="carousel-slide"><img src="images/DOKUM_6.jpg" alt="Carousel Image 6"></div>
                <div class="carousel-slide"><img src="images/DOKUM_7.jpg" alt="Carousel Image 7"></div>
                <div class="carousel-slide"><img src="images/DOKUM_8.jpg" alt="Carousel Image 8"></div>
                <div class="carousel-slide"><img src="images/DOKUM_9.jpg" alt="Carousel Image 9"></div>
                <div class="carousel-slide"><img src="images/DOKUM_10.jpg" alt="Carousel Image 10"></div>
                <div class="carousel-slide"><img src="images/DOKUM_11.jpg" alt="Carousel Image 11"></div>
                <div class="carousel-slide"><img src="images/DOKUM_12.jpg" alt="Carousel Image 12"></div>
                <div class="carousel-slide"><img src="images/DOKUM_13.jpg" alt="Carousel Image 13"></div>
            </div>
            <button class="carousel-button left" onclick="moveSlide(-1)">&#10094;</button>
            <button class="carousel-button right" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <p class="text-base sm:text-lg md:text-xl font-semibold leading-relaxed border border-[#602C00] px-4 py-2 rounded-md bg-[#602C00] text-white mt-12 text-justify">
            IG (Industrial Games) adalah lomba bidang Teknik Industri yang berbentuk permainan/games 
            untuk siswa-siswi SMA/SMK sederajat di seluruh Indonesia yang diselenggarakan oleh 
            Teknik Industri Universitas Surabaya.        
        </p>
    </div>
</section>

<!-- Join Now Section -->
<section class="relative py-16 px-4 min-h-screen flex items-center justify-center" style="background-image: url('{{ asset('images/Background_JoinNow.png') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>

    <div class="relative z-10 w-full max-w-5xl text-center px-4">
        <img src="{{ asset('images/JoinNow_Tulisan.png') }}" alt="Join Now" class="mx-auto h-14 sm:h-20 md:h-28 lg:h-32 mb-3 sm:mb-4 md:mb-6 lg:mb-6">

        <img src="{{ asset('images/JoinNow_Images.png') }}" alt="Industrial Games Overview" class="mx-auto w-full h-auto object-cover border-8 border-[#D4A373] rounded-lg">
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.getElementById('carouselSlides');
    const totalSlides = slides ? slides.children.length : 0;

    function moveSlide(direction) {
        currentSlide += direction;
        if (currentSlide < 0) currentSlide = totalSlides - 1;
        else if (currentSlide >= totalSlides) currentSlide = 0;
        slides.style.transform = `translateX(${-currentSlide * 100}%)`;
    }

    // Optional auto-slide
    // setInterval(() => moveSlide(1), 5000);
</script>
@endsection
