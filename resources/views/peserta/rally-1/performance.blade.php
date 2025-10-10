@extends('layouts.app')
{{-- Tidak perlu lagi link Bootstrap jika kita ingin mengubah ke styling custom --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

{{-- Sertakan Tailwind CSS CDN untuk kemudahan styling kustom --}}
<script src="https://cdn.tailwindcss.com"></script>

{{-- Tambahkan style kustom di sini untuk background dan card --}}
<style>
    body {
        background-image: url("{{ asset('images/Background_Industrial_Games.svg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: #EAEAEA; /* Warna teks default untuk body */
    }

    /* Style untuk kontainer utama */
    #performance-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 80px); /* Kurangi tinggi navbar jika ada di layouts.app */
        padding-top: 20px;
        padding-bottom: 20px;
    }

    /* Style untuk card performance (mengganti .card Bootstrap) */
    .custom-card {
        background-color: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem; /* rounded-lg Tailwind */
        padding: 2.5rem; /* p-10 Tailwind */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl Tailwind */
        width: 100%;
        max-width: 400px; /* Lebar maksimal agar tidak terlalu lebar di desktop */
    }

    /* Style untuk progress bar, menimpa Bootstrap jika masih ada */
    .progress {
        background-color: #333; /* Latar belakang progress bar yang lebih gelap */
        border-radius: 0.5rem;
        padding-left: 10px;
    }
    .progress-bar-custom-success {
        background-color: #28a745; /* Tetap hijau untuk success, bisa diubah */
    }
    .progress-bar-custom-info {
        background-color: #17a2b8; /* Tetap biru untuk info, bisa diubah */
    }
    .progress-bar-custom-warning {
        background-color: #ffc107; /* Tetap kuning untuk warning */
        color: #333; /* Teks gelap di progress bar warning */
    }

    h2, h5, h6 {
        color: #EAEAEA; /* Warna teks judul seperti bronze */
    }
    strong {
        color: #FFDA89; /* Warna teks angka hasil */
    }
</style>

@section('content')
<div class="container mx-auto" id="performance-container"> {{-- Gunakan mx-auto untuk memusatkan container --}}
    <div class="custom-card"> {{-- Mengganti .card Bootstrap dengan .custom-card --}}

        <h5 class="mb-3 text-center">Team: <span style="color: #FFDA89;">{{ Auth::user()->name }}</span></h5> {{-- Menambahkan span untuk warna spesifik --}}

        <div class="mb-3">
            <h6>Production Efficiency: <strong>{{ number_format($data->production_efficiency, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar progress-bar-custom-success" {{-- Mengganti bg-success dengan custom class --}}
                    role="progressbar"
                    style="width: {{ $data->production_efficiency }}%;"
                    aria-valuenow="{{ $data->production_efficiency }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($data->production_efficiency, 2) }}%
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h6>Time Productivity: <strong>{{ number_format($data->time_productivity, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar progress-bar-custom-info" {{-- Mengganti bg-info dengan custom class --}}
                    role="progressbar"
                    style="width: {{ $data->time_productivity }}%;"
                    aria-valuenow="{{ $data->time_productivity }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($data->time_productivity, 2) }}%
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h6>Overall Performance: <strong>{{ number_format($data->performance, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar progress-bar-custom-warning" {{-- Mengganti bg-warning dengan custom class --}}
                    role="progressbar"
                    style="width: {{ $data->performance }}%;"
                    aria-valuenow="{{ $data->performance }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($data->performance, 2) }}%
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <h5>Total Points: 🏅 <strong>{{ number_format($data->poin_total, 2) }}</strong></h5>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    setInterval(() => {
        fetch("{{ route('peserta.peserta.performance') }}")
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                // Pastikan target ID ada di newDoc juga
                const newContainer = newDoc.querySelector('#performance-container');
                if (newContainer) {
                    document.querySelector('#performance-container').innerHTML = newContainer.innerHTML;
                } else {
                    console.error("Target #performance-container not found in fetched HTML.");
                }
            })
            .catch(error => console.error("Error fetching performance data:", error));
    }, 5000);
</script>
@endpush