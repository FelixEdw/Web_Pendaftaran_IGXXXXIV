@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-yellow-400 mb-6">👋 Selamat Datang, Admin</h1>

    <div class="bg-gray-800 rounded-lg p-6 shadow-lg text-white">
        <p class="text-lg mb-4">Silahkan pilih pos yang ingin kamu kelola:</p>

        <ul class="space-y-3">
            <li>
                <a href="{{ route('admin.pos', ['id' => 1]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Scrambled 
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 2]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Code 24
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 3]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Line Trap
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 4]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Signal Override 
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 5]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Blind Retrieval
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 6]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Tic Tac Think
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 7]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Mission Escape
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 8]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Flag Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 9]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Command Trigger
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 10]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Ball Relay Rush
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 11]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Throw Zone
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 12]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Quiz Blits
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 13]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Flip & Think
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 14]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Memory Minefield
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 15]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Sketch Relay
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 16]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Number Game, Open Up!
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 17]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Word Assembly Race
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 18]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Rubber Pass
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 19]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Knowledge Bid
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 20]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Mystery Match
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 21]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Tower Tangle
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 22]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Connected Pipes
                </a>
            </li>
        </ul>
    </div>
</div>
@endsection
