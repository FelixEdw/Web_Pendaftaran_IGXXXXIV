@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<div class="container mt-5" id="performance-container">
    <h2 class="mb-4 text-center">📊 Production Performance</h2>

    <div class="card p-4 shadow-sm">
        <h5 class="mb-3 text-center">Team: {{ Auth::user()->name }}</h5>

        <!-- Efficiency Bar -->
        <div class="mb-3">
            <h6>Production Efficiency: <strong>{{ number_format($data->production_efficiency, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $data->production_efficiency }}%;"
                    aria-valuenow="{{ $data->production_efficiency }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($data->production_efficiency, 2) }}%
                </div>
            </div>
        </div>

        <!-- Time Productivity Bar -->
        <div class="mb-3">
            <h6>Time Productivity: <strong>{{ number_format($data->time_productivity, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-info"
                    role="progressbar"
                    style="width: {{ $data->time_productivity }}%;"
                    aria-valuenow="{{ $data->time_productivity }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($data->time_productivity, 2) }}%
                </div>
            </div>
        </div>

        <!-- Performance -->
        <div class="mb-3">
            <h6>Overall Performance: <strong>{{ number_format($data->performance, 2) }}%</strong></h6>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-warning text-dark"
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
                document.querySelector('#performance-container').innerHTML =
                    newDoc.querySelector('#performance-container').innerHTML;
            });
    }, 5000);
</script>
@endpush