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

  @if (session('success'))
  <p style="color: green;">{{ session('success') }}</p>
  @endif
  @if (session('error'))
  <p style="color: red;">{{ session('error') }}</p>
  @endif

  <p class="status">Status Pos: {{ ucfirst(str_replace('_', ' ', $pos->status)) }}</p>
  <p class="status">Tipe Pos: {{ ucfirst($pos->tipe) }}</p>

  <form action="{{ route('admin.home') }}" method="GET">
    <button type="submit">⬅️ Kembali ke Halaman Utama Admin</button>
  </form>

  @if ($timHariIni->count() === 0)
  <p><em>Belum ada tim yang datang hari ini.</em></p>
  @else
  {{-- Pos Battle --}}
  @if ($pos->tipe === 'battle' && $timHariIni->count() === 2)
  <h3>Battle antara:</h3>
  <form action="{{ route('admin.battle.hasil', $pos->id) }}" method="POST">
    @csrf
    <table border="1" cellpadding="8">
      <tr>
        <th>Tim</th>
        <th>Menang</th>
        <th>Kalah</th>
        <th>Gagal</th>
      </tr>

      @foreach ($timHariIni as $index => $tim)
      <tr>
        <td><strong>{{ $tim->peserta_namaTim }}</strong></td>
        <td>
          <input type="radio" name="hasil[{{ $tim->id }}]" value="menang"
            onclick="syncBattle({{ $index }}, 'menang')">
        </td>
        <td>
          <input type="radio" name="hasil[{{ $tim->id }}]" value="kalah"
            onclick="syncBattle({{ $index }}, 'kalah')">
        </td>
        <td>
          <input type="radio" name="hasil[{{ $tim->id }}]" value="gagal"
            onclick="syncBattle({{ $index }}, 'gagal')">
        </td>
      </tr>
      @endforeach
    </table>

    <br>
    <button type="submit">✅ Simpan Hasil Battle</button>
  </form>

  <script>
    function syncBattle(selectedIndex, result) {
      const rows = document.querySelectorAll("table tr");
      const otherIndex = selectedIndex === 0 ? 1 : 0;

      if (result === "menang") {
        // lawan otomatis kalah
        rows[otherIndex + 1].querySelector("input[value='kalah']").checked = true;
      }
      if (result === "kalah") {
        // lawan otomatis menang
        rows[otherIndex + 1].querySelector("input[value='menang']").checked = true;
      }
      // kalau gagal → lawan bebas dipilih manual
    }
  </script>

  {{-- Pos Single --}}
  @elseif ($pos->tipe === 'single' && $timHariIni->count() === 1)
  <h3>Tim yang sedang di pos:</h3>
  <p><strong>{{ $timHariIni[0]->peserta_namaTim }}</strong></p>

  <form method="POST" action="{{ route('admin.aksi', $pos->id) }}">
    @csrf
    <input type="hidden" name="tim_id" value="{{ $timHariIni[0]->id }}">
    <button name="action" value="menang" type="submit">🏆 Menang</button>
    <button name="action" value="kalah" type="submit">😞 Kalah</button>
    <button name="action" value="gagal" type="submit"
      onclick="return confirm('Yakin menyatakan tim gagal dan mengosongkan pos?')">❌ Gagal</button>
  </form>
  @endif
  @endif
</body>

</html>