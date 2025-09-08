<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<footer class="bg-[#1C110A] text-[#FDF6E3] px-6 py-10 font-poppins">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">

        <!-- Social Media -->
        <div>
            <h3 class="text-xl sm:text-2xl font-bold mb-4">OUR SOCIAL MEDIA</h3>
            <ul class="space-y-4">
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Instagram.png') }}" alt="Instagram" class="w-6 h-6"> @ig_ubaya
                </li>
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Tiktok.png') }}" alt="Tiktok" class="w-6 h-6"> @ig_ubayaa
                </li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h3 class="text-xl sm:text-2xl font-bold mb-4">CONTACT US</h3>
            <ul class="space-y-4">
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Line.png') }}" alt="Line" class="w-6 h-6"> @257saktt (admin)
                </li>
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6"> 085103929088 (Philander)
                </li>
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Whatsapp.png') }}" alt="WhatsApp" class="w-6 h-6"> 081330286135 (Rachel)
                </li>
                <li class="flex items-center gap-3">
                    <img src="{{ asset('icons/Gmail.png') }}" alt="Email" class="w-6 h-6"> industrialgames.ubaya@gmail.com
                </li>
            </ul>
        </div>

        <!-- Sponsored -->
        <div class="col-span-full mt-12">
            <h3 class="text-xl sm:text-2xl font-bold mb-4">SPONSORED BY :</h3>
            <div class="flex flex-wrap gap-4">
                {{-- Tambahkan logo sponsor di sini --}}
                {{-- <img src="{{ asset('sponsors/logo1.png') }}" class="h-10" alt="Sponsor 1"> --}}
            </div>
        </div>
    </div>

    <div class="text-center mt-16 text-sm border-t border-[#FDF6E3]/20 pt-6">
        © {{ date('Y') }} Industrial Games UBAYA. All rights reserved.
    </div>
</footer>
