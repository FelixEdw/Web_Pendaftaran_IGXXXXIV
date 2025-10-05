@extends('layouts.rally-2')

@section('title', 'INFO DEMAND - Rally 2')

@section('content')
    {{-- Header --}}
    <div class="flex justify-between items-center p-4 bg-[#ECE6E2]">
        <a href="{{ route('peserta.rally-2.index') }}" class="text-[#6B4D28]">
            <x-ri-arrow-left-s-line class="w-10 h-10 text-[#6B4D28]" />
        </a>
        <div class="text-xl font-bold text-[#6B4D28]">INFO DEMAND</div>
        <button onclick="toggleSideMenu()">
            <x-radix-text-align-justify class="w-10 h-10 text-[#6B4D28]" />
        </button>
    </div>

    @php
        // rekap & best session
        $withPct = collect($sessions)->map(function ($s) {
            $p = (int)($s['produced'] ?? 0);
            $d = (int)($s['demand'] ?? 0);
            $pct = $d > 0 ? round(($p / $d) * 100) : 0;
            return $s + ['percent' => min(100, max(0, $pct))];
        });
        $best = optional($withPct->sortByDesc('percent')->first());
        $totalProduced = $withPct->sum('produced');
        $totalDemand   = $withPct->sum('demand');
        $totalSurplus  = $totalProduced - $totalDemand;
    @endphp

    {{-- BG --}}
    <div class="px-6 py-8 min-h-[calc(100vh-64px)] bg-cover bg-center"
         style="background-image:url('{{ asset('icons/motif_gear.svg') }}')">

        <div class="max-w-6xl mx-auto space-y-6">
            {{-- Tip bar --}}
            <div class="rounded-2xl border border-white/30 bg-white/40 backdrop-blur px-4 py-3 text-sm text-[#2F2F2F] shadow-sm">
                <span class="font-semibold">Keterangan:</span> Hijau = memenuhi/lebih, Merah = kurang dari demand. Kartu dengan badge
                <span class="px-2 py-0.5 rounded-full text-xs bg-amber-100 text-amber-800 font-semibold">BEST</span>
                adalah sesi dengan capaian tertinggi.
            </div>

            {{-- Cards 4 sesi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($withPct as $s)
                    @php
                        $produced = (int) $s['produced'];
                        $demand   = (int) $s['demand'];
                        $percent  = (int) $s['percent'];
                        $surplus  = $produced - $demand;

                        $isBest   = $best && $best['id'] == $s['id'] && $best['percent'] > 0;

                        $pillText = $surplus >= 0 ? 'SURPLUS ' . $surplus : 'DEFICIT ' . abs($surplus);
                        $pillCls  = $surplus >= 0 ? 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300' :
                                                     'bg-rose-100 text-rose-800 ring-1 ring-rose-300';

                        // progress color: <80 red, 80-99 amber, >=100 green
                        $barCls = $percent >= 100 ? 'bg-emerald-500' : ($percent >= 80 ? 'bg-amber-500' : 'bg-rose-500');

                        // card style
                        $cardBase = 'rounded-3xl p-5 shadow-xl border border-white/20 bg-gradient-to-br from-[#5E7486]/80 to-[#2F3C46]/80 backdrop-blur';
                    @endphp

                    <div class="{{ $cardBase }} relative text-white">
                        {{-- Ribbon BEST --}}
                        @if($isBest)
                            <div class="absolute -top-3 right-4 px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold shadow">
                                BEST
                            </div>
                        @endif

                        {{-- Header --}}
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm tracking-wider text-white/90">SESI</div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $pillCls }}">{{ $pillText }}</span>
                        </div>
                        <div class="text-2xl font-extrabold leading-none">#{{ $s['id'] }}</div>

                        {{-- Icon --}}
                        <div class="flex justify-center my-3">
                            <img src="{{ asset('icons/contoh_sepeda.svg') }}" alt="Bicycle" class="h-14 opacity-90">
                        </div>

                        {{-- Numbers --}}
                        <div class="grid grid-cols-2 gap-3 mb-3 text-[13px]">
                            <div class="bg-white/10 rounded-xl p-3 border border-white/10">
                                <div class="text-white/80">Produced</div>
                                <div class="text-lg font-bold">{{ $produced }}</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-3 border border-white/10">
                                <div class="text-white/80">Demand</div>
                                <div class="text-lg font-bold">{{ $demand }}</div>
                            </div>
                        </div>

                        {{-- Progress --}}
                        <div class="space-y-1.5">
                            <div class="h-2.5 bg-white/20 rounded-full overflow-hidden">
                                <div class="h-2.5 {{ $barCls }} rounded-full transition-all duration-500"
                                     style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="text-right text-xs text-white/80">{{ $percent }}% of demand</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Rekap total --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3
                        rounded-3xl border border-white/40 bg-white/60 backdrop-blur px-5 py-4 shadow">
                <div class="text-[#2F2F2F]">
                    <span class="font-semibold">Total Produced:</span> {{ $totalProduced }}
                </div>
                <div class="text-[#2F2F2F]">
                    <span class="font-semibold">Total Demand:</span> {{ $totalDemand }}
                </div>
                <div class="text-[#2F2F2F]">
                    <span class="font-semibold">Overall:</span>
                    <span class="{{ $totalSurplus >= 0 ? 'text-emerald-700' : 'text-rose-700' }} font-semibold">
                        {{ $totalSurplus >= 0 ? 'Surplus ' . $totalSurplus : 'Deficit ' . abs($totalSurplus) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <x-rally-2-sidebar />
@endsection
