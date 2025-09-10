@extends('layouts.rally-2')

@section('title', 'Events - Rally 2')

@section('content')
    <div class="flex justify-between items-center p-4 bg-[#ECE6E2]">
        <a href="{{ route('peserta.rally-2.index') }}" class="text-[#6B4D28] text-2xl">
            <x-ri-arrow-left-s-line class="w-10 h-10 text-[#6B4D28]" />
        </a>
        <div class="text-xl font-bold text-[#6B4D28]">EVENTS</div>
        <button onclick="toggleSideMenu()">
            <x-radix-text-align-justify class="w-10 h-10 text-[#6B4D28]" />
        </button>
    </div>
    <div class="min-h-[calc(100vh-64px)] bg-cover bg-center"
        style="background-image: url('{{ asset('icons/motif_gear.svg') }}');">
        <div class="max-w-2xl  mt-10 bg-gradient-to-r from-yellow-100 to-pink-100 shadow-lg rounded-lg p-6 mx-4">
            <h2 class="text-2xl font-bold text-pink-700 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Event Sesi Aktif
            </h2>

            @if ($event)
                <p class="text-lg text-gray-800">
                    <strong class="text-pink-600">Event:</strong> {{ $event }}
                </p>
            @else
                <p class="text-gray-600">Tidak ada event aktif saat ini.</p>
            @endif
        </div>
    </div>

    <x-rally-2-sidebar />
@endsection