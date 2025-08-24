<!DOCTYPE html>
<html>

<head>
  <title>Admin Pos {{ $pos->nama }}</title>
  <style>
    .status {
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <h1>Admin Pos - {{ $pos->nama }}</h1>

  {{-- Notifikasi sukses / error --}}
  @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif
  @if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
  @endif

  <p class="status">Status Pos: {{ ucfirst(str_replace('_', ' ', $pos->status)) }}</p>
  <p class="status">Tipe Pos: {{ ucfirst($pos->tipe) }}</p>

  {{-- Tombol kembali --}}
  <form action="{{ route('admin.home') }}" method="GET" style="margin-bottom:10px;">
    <button type="submit">⬅️ Kembali ke Halaman Utama Admin</button>
  </form>

  {{-- Kalau belum ada tim --}}
  @if (count($timHariIni) === 0)
    <p><em>Belum ada tim yang datang hari ini.</em></p>
  @else
    {{-- Kalau pos tipe battle --}}
    @if ($pos->tipe === 'battle' && count($timHariIni) === 2)
      <h3>Battle antara:</h3>
      <form action="{{ route('battle.hasil', $pos->id) }}" method="POST">
        @csrf

        <div>
          <label>
            <input type="radio" name="winner" value="{{ $timHariIni[0] }}" required>
            {{ $timHariIni[0] }}
          </label>
          <span> vs </span>
          <label>
            <input type="radio" name="winner" value="{{ $timHariIni[1] }}" required>
            {{ $timHariIni[1] }}
          </label>
        </div>

        <br>
        <button type="submit">Simpan Hasil Battle</button>
      </form>

    {{-- Kalau pos tipe single --}}
    @elseif ($pos->tipe === 'single' && count($timHariIni) === 1)
      <h3>Tim yang sedang di pos:</h3>
      <p><strong>{{ $timHariIni[0] }}</strong></p>

      <form method="POST" action="{{ route('admin.aksi', $pos->id) }}">
        @csrf
        <input type="hidden" name="nama_tim" value="{{ $timHariIni[0] }}">

        <div style="margin-top: 10px;">
          <button name="action" value="menang" type="submit">🏆 Menang</button>
          <button name="action" value="kalah" type="submit">😞 Kalah</button>
          <button name="action" value="gagal" type="submit"
            onclick="return confirm('Yakin menyatakan tim gagal dan mengosongkan pos?')">❌ Gagal</button>
        </div>
      </form>
    @endif
  @endif
</body>

</html>
