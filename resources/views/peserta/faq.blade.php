@extends("layouts.app")
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
@section("content")
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 64px; /* Adjust based on fixed header height */
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
        /* Style for accordion */
        .accordion-content {
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.5s ease;
        background-color: #602C00;
        padding: 0 1.5rem;
    }

    .accordion-content.open {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .accordion-header {
        background-color: #845729;
        cursor: pointer;
        padding: 1.5rem;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .arrow-icon {
        transition: transform 0.3s ease;
    }

    .accordion-header.active .arrow-icon {
        transform: rotate(180deg);
    }

    .accordion-item {
        border-radius: 10px;
        overflow: hidden;
    }
    </style>

    

    <!-- FAQ Section -->
    <section class="relative py-16 px-4 flex flex-col items-center justify-center min-h-screen" style="background-image: url('{{ asset('images/Background_FAQ.svg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 bg-black bg-opacity-0"></div> <!-- Overlay -->
        
        <div class="relative z-10 w-full max-w-4xl h-auto text-center">
            
            <!-- PERUBAHAN DI SINI: Memberikan z-index pada gambar FAQ Tulisan -->
            <img src="{{ asset('images/FAQ_Tulisan.png') }}" alt="Frequently Asked Questions Title" class="mx-auto w-[340px] sm:w-[420px] md:w-[500px] lg:w-[560px] h-auto mb-8 mt-36">

           <div class="space-y-6 mx-auto w-full max-w-[700px] px-4 font-poppins">
    <!-- FAQ Item 1 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Apa itu IG?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>IG (Industrial Games) adalah lomba yang diselenggarakan oleh Teknik Industri Universitas Surabaya di bidang Teknik Industri dalam bentuk permainan/games yang seru dan menantang, serta dikemas dengan konsep yang menarik. Perlombaan ini dikemas dalam bentuk games yang seru, menantang, dan mendidik.</p>
        </div>
    </div>

    <!-- FAQ Item 2 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Apakah IG XXXIII akan diadakan secara online atau offline?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>Industrial Games XXXIII akan diadakan secara offline selama 2 hari di Universitas Surabaya (Ubaya), Kampus Tenggilis. Peserta akan mengikuti rangkaian permainan yang seru dan menantang untuk mendapatkan pengalaman yang lebih interaktif dan mendalam.</p>
        </div>
    </div>

    <!-- FAQ Item 3 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Apa saja tahap dalam IG XXXIII?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>Industrial Games XXXIII terdiri dari tiga tahapan utama, yaitu Babak Game Besar, Semifinal, dan Babak Final. Ketiga tahapan ini dirancang untuk mengasah kemampuan analisis, strategi, dan kreativitas peserta dalam memecahkan studi kasus nyata.</p>
        </div>
    </div>

    <!-- FAQ Item 4 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Apa tema yang diangkat IG XXXIII?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>"Integrated System through Quality and Performance Management for Industrial Growth"</p>
        </div>
    </div>

    <!-- FAQ Item 5 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Apa saja materi yang dipersiapkan untuk mengikuti IG XXXIII?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>Materi seputar teknik industri meliputi MIPA dan Pengetahuan Umum</p>
        </div>
    </div>

    <!-- FAQ Item 6 -->
    <div class="accordion-item">
        <div class="accordion-header text-left font-semibold text-base sm:text-lg md:text-xl px-3 py-2 sm:px-4 sm:py-3 rounded-md bg-[#A8753C] text-white">
            <span>Dimana kita bisa mendapatkan info-info mengenai IG XXXIII?</span>
            <span class="arrow-icon">&#9660;</span>
        </div>
        <div class="accordion-content text-left text-sm sm:text-base md:text-lg font-medium sm:font-semibold px-3 py-2">
            <p>Teman-teman bisa nih pantengin terus akun media sosial Industrial Games di :</p>
            <p>• Instagram : @ig_ubaya</p>
            <p>• Line : @257saktt</p>
            <p>• WhatsApp : 085103929088 (Philander)</p>
            <p>• Email : industrialgames.ubaya@gmail.com</p>
        </div>
    </div>
</div>

            </div>
        </div>
    </section>

   

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const headers = document.querySelectorAll('.accordion-header');

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const isOpen = content.classList.contains('open');

                // Tutup semua konten yang terbuka
                document.querySelectorAll('.accordion-content').forEach(c => {
                    c.style.maxHeight = null;
                    c.classList.remove('open');
                    c.previousElementSibling.classList.remove('active');
                });

                // Kalau belum terbuka, buka
                if (!isOpen) {
                    content.classList.add('open');
                    header.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });
    });
</script>

@endsection