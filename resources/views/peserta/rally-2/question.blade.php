@extends('layouts.rally-2')

@section('title', 'Question - Rally 2')

@section('content')
    <div class="flex items-center justify-center min-h-screen px-6 py-8 mb-8 bg-cover bg-center"
        style="background-image: url('{{ asset('icons/motif_gear.svg') }}');">
        <div class="bg-gradient-to-br from-gray-400 via-gray-500 to-gray-700 rounded-2xl p-8 w-full max-w-md mx-auto shadow-2xl">
            @if ($pernahAkses)
                <div class="flex items-center gap-2">
                    <a href="{{ route('peserta.rally-2.index') }}" class="text-[#6B4D28] text-2xl">
                        <x-ri-arrow-left-s-line class="w-10 h-10 text-[#6B4D28]" />
                    </a>
                    <div
                        class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg text-center font-semibold">
                        ⚠️ Kamu sudah pernah mengakses soal ini sebelumnya.
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.getElementById('submitBtn').disabled = true;

                        // Sekalian disable semua tombol opsi
                        document.querySelectorAll('.option-btn').forEach(btn => {
                            btn.disabled = true;
                        });

                        // Jika ada input manual, disable juga
                        document.getElementById('jawabanInput')?.setAttribute('disabled', true);
                    });
                </script>
            @endif

            <div class="text-left mb-6">
                <span class="text-4xl font-bold text-green-400">${{ $soal->reward_amount }}</span>
            </div>

            <div class="flex flex-wrap items-start justify-start">
                <p class="text-xl font-bold text-white break-words">
                    {{ $soal->pertanyaan }}
                </p>
                @if ($soal->gambar_soal)
                    <div class="my-4">
                        <img src="{{ asset('storage/' . $soal->gambar_soal) }}" alt="Gambar Soal"
                            class="max-w-full h-auto mx-auto rounded-lg border">
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-4 mt-4">
                @if ($soal->option_1)
                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">{{ $soal->option_1 }}</span>
                    </button>

                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">{{ $soal->option_2 }}</span>
                    </button>

                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">{{ $soal->option_3 }}</span>
                    </button>

                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">{{ $soal->option_4 }}</span>
                    </button>
                @elseif ($soal->jawaban_benar === 'TRUE' || $soal->jawaban_benar === 'FALSE')
                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">TRUE</span>
                    </button>

                    <button class="option-btn w-full p-4 text-left bg-gray-100 rounded-lg border-2"
                        onclick="selectOption(this);">
                        <span class="text-lg font-medium text-black">FALSE</span>
                    </button>
                @else
                    <label for="jawaban" class="block text-lg font-semibold mb-2">Masukkan jawaban kamu:</label>

                    <input type="text" name="jawaban" id="jawabanInput"
                        class="w-full p-3 border-2 rounded-lg text-black" placeholder="Contoh: -3.5 atau +5"
                        inputmode="decimal" required oninput="enableSubmitIfValid();">
                @endif
            </div>

            <input type="hidden" name="jawaban" id="selectedAnswer">

            <button type="submit" id="submitBtn"
                class="w-full bg-[#A8814F] mt-4 text-white font-bold py-4 px-6 rounded-full text-lg cursor-pointer"
                onclick="submitAnswer();">
                SUBMIT
            </button>
        </div>
    </div>

    <!-- Modal Jawaban Benar -->
    <div id="correctModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50">
        <div class="bg-amber-100 border-4 border-amber-500 rounded-2xl p-8 max-w-sm mx-4 text-center">
            <div class="flex items-center justify-center mb-4">
                <x-clarity-success-standard-solid class="w-24 h-24 text-green-500" />
            </div>
            <h2 class="text-2xl font-bold text-green-700 mb-2">Jawaban Benarr!!!</h2>
            <div class="flex items-center justify-center mb-4">
                <x-eva-plus-outline class="w-6 h-6 text-green-600" />
                <p class="text-2xl text-green-600 font-semibold">$1000</p>
            </div>
            <button
                class="bg-orange-300 hover:bg-orange-400 text-black font-bold py-3 px-8 rounded-lg transition-colors duration-300"
                onclick="closeModal()">
                LANJUT
            </button>
        </div>
    </div>

    <!-- Modal Jawaban Salah -->
    <div id="wrongModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50">
        <div class="bg-red-50 border-4 border-red-500 rounded-2xl p-8 max-w-sm mx-4 text-center">
            <div class="text-6xl mb-4 text-red-500">✕</div>
            <h2 class="text-2xl font-bold text-red-700 mb-4">Jawaban Salahh!!!</h2>
            <button
                class="bg-orange-300 hover:bg-orange-400 text-black font-bold py-3 px-8 rounded-lg transition-colors duration-300"
                onclick="closeModal()">
                Lanjut
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    {{--
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script> --}}
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <script>
        let selectedOption = null;
        let jawabanSudahDikirim = false;

        function selectOption(button) {
            console.log("MASUK");
            document.querySelectorAll('button[onclick*="selectOption"]').forEach(btn => {
                btn.style.backgroundColor = '';
                btn.style.color = '';
                btn.querySelector('span').style.color = '';
            });

            button.style.backgroundColor = '#218E00';
            button.style.color = 'white';
            button.querySelector('span').style.color = 'white';

            selectedOption = button;

            const answer = button.querySelector('span').textContent.trim();
            document.getElementById('selectedAnswer').value = answer;

            document.getElementById('submitBtn').disabled = false;
        }


        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('jawabanInput');

            if (input) {
                input.addEventListener('input', function () {
                    input.value = input.value.replace(',', '.');
                });
            }

            window.addEventListener('beforeunload', function (e) {
                if (!jawabanSudahDikirim) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        }); // ✅ Sudah ditutup dengan benar


        /* Fungsi dibawah sebenernya mau dipake tapi tabrakan sama input desimal :(
        function formatRibuan(input) {
            let raw = input.value;

            // Simpan tanda "+" atau "-"
            let prefix = '';
            if (raw.startsWith('+') || raw.startsWith('-')) {
                prefix = raw.charAt(0);
                raw = raw.slice(1);
            }

            // Hapus titik
            let angka = raw.replace(/\./g, '');

            // Boleh kosong saat sedang diketik
            if (angka === '') {
                input.value = prefix;
                document.getElementById('selectedAnswer').value = '';
                return;
            }

            // Cegah input jika bukan angka
            if (!/^\d+$/.test(angka)) {
                input.value = '';
                document.getElementById('selectedAnswer').value = '';
                return;
            }

            // Tambahkan titik ribuan
            let formatted = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = prefix + formatted;

            // Simpan versi tanpa titik ke hidden input
            document.getElementById('selectedAnswer').value = prefix + angka;
        }*/

        function enableSubmitIfValid() {
            const input = document.getElementById('jawabanInput');
            const nilai = input.value.trim();
            const isValid = /^[-+]?[0-9]*\.?[0-9]+$/.test(nilai);  // validasi desimal
            document.getElementById('submitBtn').disabled = !isValid;

            if (isValid) {
                document.getElementById('selectedAnswer').value = nilai;
            } else {
                document.getElementById('selectedAnswer').value = '';
            }
        }


        async function submitAnswer() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;

            const jawaban = document.getElementById('selectedAnswer')?.value || document.getElementById('jawabanInput')?.value;

            if (!jawaban) {
                alert("Silakan pilih atau isi jawaban terlebih dahulu.");
                submitBtn.disabled = false;
                return;
            }

            try {
                const response = await fetch("{{ route('peserta.question.submit', $soal->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ jawaban: jawaban })
                });

                const data = await response.json();

                window.lastAnswerCorrect = (data.status === "benar");

                if (window.lastAnswerCorrect) {
                    // Update reward jika tersedia
                    if (data.reward) {
                        document.querySelector('#correctModal p').textContent = `$${data.reward}`;
                    }
                    showModal('correctModal');
                } else {
                    showModal('wrongModal');
                }

                jawabanSudahDikirim = true;

            } catch (error) {
                console.error("Error saat submit:", error);
                alert("Terjadi kesalahan.");
            }

            submitBtn.disabled = false;
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex', 'items-center', 'justify-center');
        }

        function closeModal() {
            ['correctModal', 'wrongModal'].forEach(id => {
                const modal = document.getElementById(id);
                modal.classList.add('hidden');
                modal.classList.remove('flex', 'items-center', 'justify-center');
            });

            if (window.lastAnswerCorrect === false) {
                document.querySelectorAll('button[onclick*="selectOption"]').forEach(btn => {
                    btn.style.backgroundColor = '';
                    btn.style.color = '';
                    btn.querySelector('span').style.color = '';
                });

                const input = document.getElementById('jawabanInput');
                if (input) input.value = '';

                const hidden = document.getElementById('selectedAnswer');
                if (hidden) hidden.value = '';

                selectedOption = null;
                document.getElementById('submitBtn').disabled = true;
            }

            window.location.href = '/peserta/rally2/scanner';
        }

        window.onclick = function (event) {
            if (event.target === document.getElementById('correctModal') || event.target === document.getElementById('wrongModal')) {
                closeModal();
            }
        };

        document.getElementById('jawabanInput')?.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitAnswer();
            }
        });
    </script>
@endpush