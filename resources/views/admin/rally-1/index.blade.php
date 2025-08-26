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
                    📍 Admin POS 1
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 2]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 2
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 3]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 3
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 4]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 4
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 5]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 5
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 6]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 6
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 7]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 7
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 8]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 8
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 9]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 9
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 10]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 10
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 11]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 11
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 12]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 12
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 13]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 13
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 14]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 14
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 15]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 15
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 16]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 16
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 17]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 17
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 18]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 18
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 19]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 19
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 20]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 20
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 21]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 21
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 22]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 22
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 23]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 23
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 24]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 24
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pos', ['id' => 25]) }}"
                   class="block px-5 py-3 bg-green-600 hover:bg-green-700 rounded-md shadow text-white font-medium transition">
                    📍 Admin POS 25
                </a>
            </li>
        </ul>
    </div>
</div>
@endsection
