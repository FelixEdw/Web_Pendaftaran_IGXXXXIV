<!DOCTYPE html>
<html>
<head>
    <title>Komponen Tim {{ $tim }}</title>
</head>
<body>
    <h2>Inventory - {{ $tim }}</h2>

    <a href="{{ route("peserta.rally-1.index") }}">⬅ Kembali ke Home</a>

    @if ($komponen)
        <table border="1" cellpadding="8" cellspacing="0">
            <tr><th>Nama Komponen</th><th>Jumlah</th></tr>
            <tr><td>Wheel</td><td>{{ $komponen->wheel }}</td></tr>
            <tr><td>Brake</td><td>{{ $komponen->brake }}</td></tr>
            <tr><td>Pedal</td><td>{{ $komponen->pedal }}</td></tr>
            <tr><td>Chain & Gear</td><td>{{ $komponen->chain_and_gear }}</td></tr>
            <tr><td>City Frame</td><td>{{ $komponen->city_frame }}</td></tr>
            <tr><td>Folding Frame</td><td>{{ $komponen->folding_frame }}</td></tr>
            <tr><td>Mountain Frame</td><td>{{ $komponen->mountain_frame }}</td></tr>
            <tr><td>Unicycle Frame</td><td>{{ $komponen->unicycle_frame }}</td></tr>
        </table>
    @else
        <p>❌ Belum ada data komponen untuk tim ini.</p>
    @endif
</body>
</html>
