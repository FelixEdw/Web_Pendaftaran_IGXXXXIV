<h2>Produksi Sepeda</h2>
<a href="{{ route("peserta.rally-1.index") }}">⬅ Kembali ke Home</a>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

@foreach ($resep as $jenis => $syarat)
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
        <h3>{{ ucfirst($jenis) }} Bike</h3>

        <ul>
            @php $cukup = true; @endphp
            @foreach ($syarat as $komponen => $jumlah)
                @php
                    $punya = $data->$komponen ?? 0;
                    $status = $punya >= $jumlah ? '✅' : '❌';
                    if ($punya < $jumlah) $cukup = false;
                @endphp
                <li>
                    {{ $komponen }} × {{ $jumlah }}
                    <span style="margin-left: 10px;">(You Have: {{ $punya }})</span>
                    <strong>{{ $status }}</strong>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('peserta.produksi.sepeda', $jenis) }}" method="POST">
            @csrf
            <button type="submit" {{ $cukup ? '' : 'disabled' }}>
                🚲 Rakit {{ ucfirst($jenis) }}
            </button>
        </form>
    </div>
@endforeach
