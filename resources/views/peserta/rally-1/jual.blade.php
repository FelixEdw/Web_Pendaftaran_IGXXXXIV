<h2>Jual Sepeda Sesi {{ $sesi }}</h2>
<a href="{{ route("peserta.rally-1.index") }}">⬅ Kembali ke Home</a>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    @foreach ($harga as $jenis => $h)
        @php
            $stokSepeda = $stok->$jenis ?? 0;
        @endphp

        <div style="border: 1px solid #ccc; border-radius: 10px; padding: 15px; width: 250px;">
            <h3>{{ ucfirst($jenis) }}</h3>
            <p><strong>Stok:</strong> {{ $stokSepeda }}</p>
            <p><strong>Harga:</strong> ${{ $h }}</p>

            <form action="{{ route('peserta.jual.sepeda') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menjual sepeda {{ ucfirst($jenis) }} seharga ${{ $h }} per unit?');">
                @csrf
                <label for="jumlah">Jumlah Jual:</label><br>
                <input type="number" name="jumlah" value="0" min="0" max="{{ $stokSepeda }}">
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <br><br>
                <button type="submit" style="padding: 5px 15px;">Jual</button>
            </form>
        </div>
    @endforeach
</div>
