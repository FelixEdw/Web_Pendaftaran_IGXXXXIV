@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-yellow-400 mb-6">👋 Selamat Datang, Admin</h1>

    <div class="bg-gray-800 rounded-lg p-6 shadow-lg text-white">
        <p class="text-lg mb-4">Silakan pilih POS yang ingin kamu kelola:</p>

        <ul class="space-y-3">
            <li>
                <a href="{{ route('admin.pos', ['id' => 1]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Scrambled 
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 2]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Code 24
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 3]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Line Trap
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 4]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Signal Override 
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 5]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Blind Retrieval
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 7]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Tic Tac Think
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 8]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Mission Escape
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 9]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Flag Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 10]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Command Trigger
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 11]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Ball Relay Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 12]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Throw Zone
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 13]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Quiz Blitz
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 14]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Bottle Brain Battle
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 15]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Memory Minefield
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 17]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Sketch Relay
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 18]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos It's Number Game, Open Up!
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 19]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Word Assembly
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 21]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Rubber Pass
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 22]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Knowledge Bid
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 23]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Mystery Match
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 24]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Tower Tangle
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 25]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Pos Connected Pipes
                </a>
            </li>
        </ul>
    </div>
</div>
@endsection
