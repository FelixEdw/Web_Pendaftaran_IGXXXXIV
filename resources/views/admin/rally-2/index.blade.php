@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-6">
    <div class="max-w-3xl mx-auto">
        <!-- Bagian 1: Ganti Sesi -->
        <div class="bg-gradient-to-r from-purple-100 to-indigo-100 shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-indigo-700 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v2a2 2 0 102 0v-2m-6-2a6 6 0 1112 0v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2z" />
                </svg>
                Ganti Sesi
            </h2>

            {{-- Tampilkan sesi aktif --}}
            {{-- Tampilkan sesi aktif --}}
            @if($activeSession)
                @if((int) $activeSession->id === 5)
                    <p class="mb-2 text-sm text-gray-700">
                        <strong class="text-indigo-700">Sesi Aktif:</strong> SESI BERHENTI
                    </p>
                @else
                    <p class="mb-2 text-sm text-gray-700">
                        <strong class="text-indigo-700">Sesi Aktif:</strong> Sesi {{ $activeSession->id }} — 
                        Durasi: {{ $activeSession->durasi }} menit — 
                        Demand: {{ $activeSession->demand }} —
                        Event: {{ $activeSession->event ?? 'Tidak ada event' }}
                    </p>
                @endif
            @endif

            {{-- Form Ganti Sesi --}}
            <form method="POST" action="{{ route('admin.rally-2.gantisesigame') }}" class="flex flex-col md:flex-row gap-4 mt-3">
                @csrf
                <select name="session_id" required
                    class="flex-1 px-4 py-2 border border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-white text-gray-700">
                    <option value="">-- Pilih Sesi --</option>
                    @foreach ($allSessions as $session)
                        @php $isStop = (int) $session->id === 5; @endphp
                        <option value="{{ $session->id }}">
                            @if($isStop)
                                SESI BERHENTI
                            @else
                                Sesi {{ $session->id }} — Durasi: {{ $session->durasi }} — Demand: {{ $session->demand }}
                                @if(!empty($session->event)) — Event: {{ $session->event }} @endif
                            @endif
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Ubah
                </button>
            </form>
        </div>



        <!-- Bagian 2: Tabel Poin -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 shadow rounded-lg p-6 mt-8 color-black">
            <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 11V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-8z" />
                </svg>
                Poin Tim
            </h2>

            <div class="overflow-x-auto rounded-lg shadow-sm">
                <table class="min-w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-blue-200 text-blue-900">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Nama Tim</th>
                            <th scope="col" class="px-6 py-3">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-100">
                        @forelse ($teams as $index => $team)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $team->nama_tim }}</td>
                                <td class="px-6 py-4 font-semibold text-indigo-600">{{ $team->poin_total_babak2 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data poin tim.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
@endsection
