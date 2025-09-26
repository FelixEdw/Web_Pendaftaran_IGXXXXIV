<!DOCTYPE html>
<html>

<head>
  <title>Admin Pos {{ $pos->nama }}</title>
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      background-color: #f9fafb;
      color: #1f2937;
      margin: 0;
      padding: 20px;
    }

    h1 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      text-align: center;
    }

    .status {
      font-weight: 600;
      margin: 0.5rem 0;
      padding: 0.5rem;
      background-color: #e5e7eb;
      border-radius: 8px;
      display: inline-block;
    }

    form {
      margin: 1rem 0;
    }

    button {
      background-color: #2563eb;
      color: white;
      border: none;
      padding: 0.6rem 1rem;
      margin-top: 0.3rem;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.2s ease, transform 0.1s ease;
    }

    button:hover {
      background-color: #1d4ed8;
      transform: scale(1.02);
    }

    button.btn-danger {
      background-color: #dc2626;
    }

    button.btn-danger:hover {
      background-color: #b91c1c;
    }

    hr {
      border: none;
      border-top: 2px solid #e5e7eb;
      margin: 1.5rem 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    th {
      background-color: #f3f4f6;
      text-align: left;
      padding: 0.8rem;
      font-weight: 600;
      border-bottom: 2px solid #e5e7eb;
    }

    td {
      padding: 0.8rem;
      border-bottom: 1px solid #e5e7eb;
    }

    input[type="checkbox"],
    input[type="radio"] {
      transform: scale(1.3);
      margin-right: 0.5rem;
    }

    h3 {
      margin-top: 1rem;
      margin-bottom: 0.5rem;
      font-size: 1.25rem;
      font-weight: 700;
      color: #111827;
    }

    p {
      margin: 0.4rem 0;
    }

    p em {
      color: #6b7280;
    }

    .alert-success {
      color: #065f46;
      background-color: #d1fae5;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      margin-bottom: 1rem;
    }

    .alert-error {
      color: #991b1b;
      background-color: #fee2e2;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <h1>Admin Pos - {{ $pos->nama }}</h1>

  {{-- Flash messages --}}
  @if (session('success'))
  <p class="alert-success">✅ {{ session('success') }}</p>
  @endif
  @if (session('error'))
  <p class="alert-error">❌ {{ session('error') }}</p>
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
    <div style="margin-bottom: 0.3rem;">
      <input type="checkbox" name="tim[]" value="{{ $tim->id }}" id="tim-{{ $tim->id }}">
      <label for="tim-{{ $tim->id }}">{{ $tim->peserta_namaTim }}</label>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Pilih Tim</button>
  </form>

  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger"
      onclick="return confirm('Yakin reset waiting list dan refund uang tim?')">
      🔄 Reset Waiting List
    </button>
  </form>
  @else
  <p><em>Tidak ada tim di waiting list.</em></p>
  @endif

  <hr>

  {{-- STEP 2: Battle --}}
  @if ($pos->tipe === 'battle')
  @if ($timHariIni && $timHariIni->count() > 0)
  <h3>Battle antara:</h3>
  @if ($timHariIni->count() < 2)
  <p style="color:red;"><em>⚠️ Tim belum lengkap (baru {{ $timHariIni->count() }}). Tunggu tim lain.</em></p>
  @endif

  <form action="{{ route('admin.battle.hasil', $pos->id) }}" method="POST">
    @csrf
    <table>
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

  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST">
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

  <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST">
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
