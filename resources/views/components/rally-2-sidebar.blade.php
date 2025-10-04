@props(['isOpen' => false])

<div class="fixed top-0 right-0 h-full w-1/2 bg-[#4D2B08] transform {{ $isOpen ? '' : 'translate-x-full' }} transition-transform duration-300 z-50"
    id="sideMenu">
    <div class="flex justify-end p-4">
        <button onclick="closeSideMenu()" class="text-[#B28142] text-2xl hover:text-red-500 transition">
            ✕
        </button>
    </div>

    <h1 class="text-center font-extrabold text-5xl mb-5">MENU</h1>

    <div class="space-y-3">
        <a href="{{ route('peserta.rally-2.scanner') }}"
            class="block w-full bg-[#B17445] text-white py-3 px-4 font-bold text-center">
            QR SCANNER
        </a>
        <a href="{{ route('peserta.rally-2.events') }}"
            class="block w-full bg-[#B17445] text-white py-3 px-4 font-bold text-center">
            EVENT
        </a>
        <a href="{{ route('peserta.rally-2.inventory') }}"
            class="block w-full bg-[#B17445] text-white py-3 px-4 font-bold text-center">
            INVENTORY
        </a>
        <a class="block w-full bg-[#B17445] text-white py-3 px-4 font-bold text-center">
            DEMAND TERCAPAI
        </a>
    </div>
</div>

<div class="fixed inset-0 bg-black bg-opacity-50 {{ $isOpen ? '' : 'hidden' }} z-40" id="sideMenuOverlay"
    onclick="closeSideMenu()"></div>

<script>
    function toggleSideMenu() {
        const menu = document.getElementById('sideMenu');
        const overlay = document.getElementById('sideMenuOverlay');

        menu.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    }

    function closeSideMenu() {
        const menu = document.getElementById('sideMenu');
        const overlay = document.getElementById('sideMenuOverlay');

        menu.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    }

    function openSideMenu() {
        const menu = document.getElementById('sideMenu');
        const overlay = document.getElementById('sideMenuOverlay');

        menu.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
    }
</script>