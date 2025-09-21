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

  {{-- Flash messages --}}
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

  {{-- STEP 1: Waiting list --}}
  @if ($waitingList->count() > 0)
  <form action="{{ route('admin.pos.pilihTim', $pos->id) }}" method="POST">
    @csrf
    <h3>Waiting List</h3>
    @foreach ($waitingList as $tim)
    <div>
      <input type="checkbox" name="tim[]" value="{{ $tim->id }}" id="tim-{{ $tim->id }}">
      <label for="tim-{{ $tim->id }}">{{ $tim->peserta_namaTim }}</label>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Pilih Tim</button>
  </form>

  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" style="margin-top:10px;">
    @csrf
    <button type="submit" class="btn btn-danger"
      onclick="return confirm('Yakin reset waiting list dan refund uang tim?')">
      Reset Waiting List
    </button>
  </form>
  @else
  <p><em>Tidak ada tim di waiting list.</em></p>
  @endif

  <hr>

  {{-- STEP 2: Jika sudah ada tim yang dipilih --}}
  {{-- Pos Battle --}}
  @if ($pos->tipe === 'battle')
  @if ($timHariIni && $timHariIni->count() > 0)
  <h3>Battle antara:</h3>
  @if ($timHariIni->count() < 2)
  <p style="color:red;"><em>⚠️ Tim belum lengkap (baru {{ $timHariIni->count() }}). Tunggu tim lain.</em></p>
  @endif

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
        <td><input type="radio" name="hasil[{{ $tim->id }}]" value="menang"
            onclick="syncBattle({{ $index }}, 'menang')"></td>
        <td><input type="radio" name="hasil[{{ $tim->id }}]" value="kalah"
            onclick="syncBattle({{ $index }}, 'kalah')"></td>
        <td><input type="radio" name="hasil[{{ $tim->id }}]" value="gagal"></td>
      </tr>
      @endforeach
    </table>
    <br>
    <button type="submit"
      @if($timHariIni->count() < 2) disabled @endif
      onclick="return confirm('Simpan hasil battle ini?')">
      🥊 Simpan Hasil Battle
    </button>
  </form>

  {{-- Tambahan tombol reset --}}
  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" style="margin-top:10px;">
    @csrf
    <button type="submit" class="btn btn-danger"
      onclick="return confirm('Yakin reset pos ini? Uang tim akan dikembalikan.')">
      🔄 Reset Pos
    </button>
  </form>

  <script>
    function syncBattle(selectedIndex, result) {
      const rows = document.querySelectorAll("table tr");
      const otherIndex = selectedIndex === 0 ? 1 : 0;
      if (result === "menang") {
        rows[otherIndex + 1].querySelector("input[value='kalah']").checked = true;
      }
      if (result === "kalah") {
        rows[otherIndex + 1].querySelector("input[value='menang']").checked = true;
      }
    }
  </script>
  @endif

  {{-- Pos Single --}}
  @elseif ($pos->tipe === 'single')
  @if ($timHariIni)
  <h3>Tim yang sedang di pos:</h3>
  <p><strong>{{ $timHariIni->peserta_namaTim }}</strong></p>
  <form method="POST" action="{{ route('admin.aksi', $pos->id) }}">
    @csrf
    <input type="hidden" name="nama_tim" value="{{ $timHariIni->peserta_namaTim }}">
    <button name="action" value="menang" type="submit">🏆 Menang</button>
    <button name="action" value="kalah" type="submit">😞 Kalah</button>
    <button name="action" value="gagal" type="submit"
      onclick="return confirm('Yakin menyatakan tim gagal dan mengosongkan pos?')">❌ Gagal</button>
  </form>

  {{-- Tambahan tombol reset --}}
  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" style="margin-top:10px;">
    @csrf
    <button type="submit" class="btn btn-danger"
      onclick="return confirm('Yakin reset pos ini? Uang tim akan dikembalikan.')">
      🔄 Reset Pos
    </button>
  </form>
  @endif
  @endif

</body>

</html>
