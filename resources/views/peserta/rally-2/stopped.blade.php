@extends('layouts.rally-2')

@section('title', 'Rally 2 — Sesi Berhenti')

@section('content')
  {{-- Top bar mengikuti gaya Rally 2 --}}
  <div class="flex justify-between items-center p-2" style="background:#ECE6E2;">
    <div class="text-2xl font-bold text-[#6B4D28]">RALLY 2</div>
  </div>

  <div class="max-w-3xl mx-auto px-4 py-8">
    {{-- Flash message --}}
    @if (session('error'))
      <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700">
        {{ session('error') }}
      </div>
    @endif
    @if (session('success'))
      <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
        {{ session('success') }}
      </div>
    @endif

    {{-- Hero Card: Sesi Berhenti --}}
    <div class="rounded-2xl overflow-hidden shadow-sm"
         style="background:linear-gradient(180deg,#f7f2ee,#ece6e2)">
      <div class="p-6 md:p-8">
        <div class="flex items-start gap-4">
          {{-- Icon stop / pause --}}
          <div class="relative">
            <div class="w-12 h-12 rounded-2xl grid place-content-center bg-[#6B4D28]/10">
              {{-- Stop icon (square) --}}
              <svg viewBox="0 0 24 24" class="w-7 h-7 text-[#6B4D28]" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="6" y="6" width="12" height="12" rx="2"></rect>
              </svg>
            </div>
            {{-- Ping indicator --}}
            <span class="absolute -right-1 -top-1 inline-flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-60"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
          </div>

          <div class="flex-1">
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#6B4D28] tracking-tight">
              Sesi Berhenti
            </h1>
            <p class="mt-2 text-sm md:text-base text-[#6B4D28]/80 leading-relaxed">
              Sesi permainan Rally 2 sedang <span class="font-semibold">dihentikan sementara</span> oleh panitia.
              Silakan tetap berada di halaman ini. Sistem akan memeriksa status secara otomatis
              setiap <span class="font-semibold">15 detik</span>.
            </p>

            {{-- Detail opsional dari server jika ada --}}
            @isset($activeSession)
              <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                <div class="rounded-xl bg-white/70 border border-[#6B4D28]/10 p-3">
                  <div class="text-[#6B4D28]/60">Sesi</div>
                  <div class="font-semibold text-[#6B4D28]">
                    {{ $activeSession->id ?? '—' }} (BERHENTI)
                  </div>
                </div>
                <div class="rounded-xl bg-white/70 border border-[#6B4D28]/10 p-3">
                  <div class="text-[#6B4D28]/60">Event</div>
                  <div class="font-semibold text-[#6B4D28]">
                    {{ $activeSession->event ?? '—' }}
                  </div>
                </div>
                <div class="rounded-xl bg-white/70 border border-[#6B4D28]/10 p-3">
                  <div class="text-[#6B4D28]/60">Info</div>
                  <div class="font-semibold text-[#6B4D28]">
                    Menunggu instruksi panitia
                  </div>
                </div>
              </div>
            @endisset

            {{-- Actions --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
              <button
                type="button"
                onclick="location.reload()"
                class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 font-semibold
                       text-white bg-[#6B4D28] hover:bg-[#5d4425] transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                  <path d="M21 3v6h-6" />
                </svg>
                Cek Status Sekarang
              </button>

              <a href="{{ url('/') }}"
                 class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 font-semibold
                        text-[#6B4D28] bg-white border border-[#6B4D28]/20 hover:bg-white/80 transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M15 18l-6-6 6-6" />
                </svg>
                Kembali ke Halaman Peserta
              </a>
            </div>

            {{-- Tips singkat --}}
            <div class="mt-6 rounded-xl bg-white/70 border border-[#6B4D28]/10 p-4">
              <h3 class="font-semibold text-[#6B4D28] mb-2">Sambil menunggu:</h3>
              <ul class="list-disc pl-5 text-sm text-[#6B4D28]/80 space-y-1">
                <li>Pastikan koneksi internet stabil.</li>
                <li>Siapkan strategi tim untuk sesi berikutnya.</li>
                <li>Tetap pantau pengumuman dari panitia.</li>
              </ul>
            </div>

            {{-- Auto refresh notice --}}
            <p class="mt-4 text-xs text-[#6B4D28]/60">
              Halaman ini akan refresh otomatis. Jika sesi dilanjutkan, Anda akan kembali ke halaman permainan.
            </p>
          </div>
        </div>
      </div>
    </div>

    {{-- Footer kecil --}}
    <div class="text-center text-xs text-[#6B4D28]/60 mt-6">
      © {{ date('Y') }} Industrial Games — Rally 2
    </div>
  </div>

  {{-- Auto-refresh setiap 15 detik --}}
  <script>
    setInterval(function () {
      // Biarkan middleware/route logic kamu yang mengarahkan kembali ke index saat sesi sudah tidak 5
      window.location.reload();
    }, 15000);
  </script>
@endsection
