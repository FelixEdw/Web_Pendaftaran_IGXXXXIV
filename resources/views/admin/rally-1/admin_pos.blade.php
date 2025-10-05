<!DOCTYPE html>
<html>

<head>
    <title>Admin Pos {{ $pos->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Palet Warna Industrial Games (IG) */
        :root {
            --color-bg-dark: #602c10;
            --color-card-dark: #602c00;
            --color-bronze: #956238;
            --color-gold-accent: #FBC02D;
            --color-text-light: #FFDA89;
            --color-text-white: #FFFFFF;
            --color-danger: #D64545;
            --color-danger-hover: #B73D3D;
            --color-success: #66BB6A;
            --color-success-hover: #4CAF50;
        }

        /* Umum dan Body */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg-dark);
            color: var(--color-text-white);
            margin: 0;
            padding: 20px 10px;
            min-height: 100vh;
        }

        /* Kontainer Utama - Wajib Tengah & Maksimal Lebar */
        .container {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            padding: 0 10px;
        }

        /* Judul Halaman */
        h1 {
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2rem;
            color: var(--color-gold-accent);
            text-shadow: 0 0 8px rgba(251, 192, 45, 0.2);
            line-height: 1.2;
        }

        /* Sub-Judul - DITENGAHKAN */
        h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-text-light);
            border-bottom: none; 
            padding-bottom: 5px;
            text-align: center;
        }
        
        /* Status Pos (Bordered Pill) - DITENGAHKAN */
        .status-pill-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
            justify-content: center;
        }
        .status-pill {
            font-weight: 600;
            padding: 0.5rem 1rem;
            background-color: var(--color-card-dark);
            border: 2px solid var(--color-bronze);
            border-radius: 9999px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
            font-size: 0.9rem;
        }

        /* Button Styling */
        button,
        .btn-link {
            border: none;
            padding: 0.7rem 1.2rem;
            margin-top: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: auto;
            min-width: 150px;
            text-align: center;
        }
        
        /* Container untuk TOMBOL TUNGGAL (agar di tengah) */
        .center-form {
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 1rem 0;
        }

        /* Grup Tombol Aksi Single Pos (Menang/Kalah/Gagal) */
        .action-button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 1.5rem 0;
            justify-content: center;
        }
        .action-button-group button {
            flex-grow: 1; 
            min-width: 120px;
        }
        /* Override untuk form yang berisi grup tombol (untuk Single Pos) */
        form[method="POST"] > .action-button-group {
            margin-left: auto;
            margin-right: auto;
            max-width: 450px;
        }
        
        /* Primary/Action Button (Pilih Tim, Kembali) */
        button[type="submit"],
        .btn-primary {
            background-color: var(--color-bronze);
            color: var(--color-text-white);
        }

        button[type="submit"]:hover,
        .btn-primary:hover {
            background-color: #A57248;
            transform: translateY(-1px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.5);
        }
        
        /* Danger Button (Reset) */
        button.btn-danger {
            background-color: var(--color-danger);
            color: var(--color-text-white);
        }

        button.btn-danger:hover {
            background-color: var(--color-danger-hover);
            transform: translateY(-1px);
        }

        /* Success Button (Menang) - Aksen Emas */
        button[name="action"][value="menang"] {
            background-color: var(--color-gold-accent);
            color: var(--color-bg-dark);
        }
        button[name="action"][value="menang"]:hover {
            background-color: #FFC74B;
        }
        
        /* Kalah/Gagal Button (Darker Bronze/Reddish) */
        button[name="action"][value="kalah"],
        button[name="action"][value="gagal"] {
            background-color: #391E1E; 
            color: var(--color-text-light);
        }
        button[name="action"][value="kalah"]:hover,
        button[name="action"][value="gagal"]:hover {
            background-color: #4C2929;
        }
        
        /* Divider - Hanya beri jarak */
        hr {
            border: none;
            height: 0;
            margin: 2.5rem 0;
        }

        /* Tabel (Battle/Tim di Pos) */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1.5rem;
            background-color: #391E1E;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            border: 2px solid var(--color-bronze);
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }
        
        /* Membuat tabel lebih mudah dilihat di layar kecil */
        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr { 
                display: block; 
            }
            thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr { 
                border-bottom: 2px solid var(--color-bronze);
                margin-bottom: 10px;
                background-color: #2D1717;
            }
            td { 
                border: none;
                position: relative;
                padding-left: 50%; 
                text-align: right;
            }
            td::before { 
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-left: 10px;
                font-weight: bold;
                text-align: left;
                color: var(--color-gold-accent);
            }
            /* Hilangkan garis bawah untuk baris terakhir */
            tr:last-child {
                border-bottom: none;
            }
        }

        /* Checkbox dan Radio Button */
        input[type="checkbox"],
        input[type="radio"] {
            transform: scale(1.4);
            accent-color: var(--color-gold-accent);
            margin-right: 0.5rem;
        }

        label {
            color: var(--color-text-white);
            font-weight: 500;
            display: inline-block;
            margin-left: 5px;
        }
        
        /* Kontainer Waiting List */
        .waiting-list-box {
            background-color: rgba(0,0,0,0.3);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--color-bronze);
            
            /* Menengahkan konten (nama tim) */
            display: flex;
            flex-direction: column;
            align-items: center; /* Rata tengah horizontal */
            text-align: center; 
        }
        
        /* Pastikan elemen di dalam box tetap fleksibel */
        .waiting-list-box > div {
            width: fit-content;
        }


        /* Alert Messages */
        .alert-success, .alert-error {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .alert-success {
            color: var(--color-bg-dark);
            background-color: var(--color-success);
        }
        .alert-error {
            color: var(--color-text-white);
            background-color: var(--color-danger);
        }

        p[style*="color:red;"] {
            color: var(--color-danger) !important;
            background-color: #391E1E;
            padding: 10px;
            border-radius: 6px;
            border: 1px dashed var(--color-danger);
            display: block;
            margin-bottom: 1rem !important;
        }

        /* Styling Khusus untuk Pesan "Tidak ada tim di waiting list." */
        .no-waiting-list-message {
            text-align: center; /* PENTING: Menengahkan teks */
            font-style: italic;
            color: var(--color-text-light);
            margin: 2rem 0;
            display: block; /* Agar bisa rata tengah */
        }

        p em {
            color: #ccc;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Admin Pos - {{ $pos->nama }}</h1>

        {{-- Flash messages --}}
        @if (session('success'))
        <p class="alert-success">✅ {{ session('success') }}</p>
        @endif
        @if (session('error'))
        <p class="alert-error">❌ {{ session('error') }}</p>
        @endif

        {{-- Status Pos & Tipe Pos --}}
        <div class="status-pill-group">
            <span class="status-pill">Status Pos: {{ ucfirst(str_replace('_', ' ', $pos->status)) }}</span>
            <span class="status-pill">Tipe Pos: {{ ucfirst($pos->tipe) }}</span>
        </div>

        {{-- Button Kembali --}}
        <form action="{{ route('admin.home') }}" method="GET" class="center-form">
            <button type="submit" class="btn-link">⬅️ Kembali ke Halaman Utama Admin</button>
        </form>

        <hr>

        {{-- STEP 1: Waiting list --}}
        @if ($waitingList->count() > 0)
        <form action="{{ route('admin.pos.pilihTim', $pos->id) }}" method="POST" class="mb-6">
            @csrf
            <h3>Daftar Tunggu (Waiting List)</h3>
            <div class="waiting-list-box">
                @foreach ($waitingList as $tim)
                <div style="margin-bottom: 0.5rem;">
                    <input type="checkbox" name="tim[]" value="{{ $tim->id }}" id="tim-{{ $tim->id }}">
                    <label for="tim-{{ $tim->id }}">{{ $tim->peserta_namaTim }}</label>
                </div>
                @endforeach
            </div>
            <div class="center-form">
                <button type="submit" class="btn-primary mt-4">Pilih Tim</button>
            </div>
        </form>

        {{-- Tombol Reset Waiting List --}}
        <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" class="mb-6 center-form">
            @csrf
            <button type="submit" class="btn-danger"
                onclick="return confirm('Yakin reset waiting list dan refund uang tim?')">
                🔄 Reset Waiting List & Refund
            </button>
        </form>
        @else
        {{-- Pesan Waiting List Kosong - Ditambahkan class untuk styling tengah --}}
        <p class="no-waiting-list-message"><em>Tidak ada tim di waiting list.</em></p>
        @endif

        <hr>

        {{-- STEP 2: Battle --}}
        @if ($pos->tipe === 'battle')
        @if ($timHariIni && $timHariIni->count() > 0)
        <h3>Kelola Battle</h3>
        @if ($timHariIni->count() < 2)
        <p style="color:red; margin-bottom: 1rem;"><em>⚠️ Tim belum lengkap (baru {{ $timHariIni->count() }}). Tunggu tim
                lain.</em></p>
        @endif

        <form action="{{ route('admin.battle.hasil', $pos->id) }}" method="POST" class="mb-6">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Tim</th>
                        <th>Menang</th>
                        <th>Kalah</th>
                        <th>Gagal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timHariIni as $index => $tim)
                    <tr>
                        <td data-label="Tim"><strong>{{ $tim->peserta_namaTim }}</strong></td>
                        <td data-label="Menang"><input type="radio" name="hasil[{{ $tim->id }}]" value="menang"
                                onclick="syncBattle({{ $index }}, 'menang')"></td>
                        <td data-label="Kalah"><input type="radio" name="hasil[{{ $tim->id }}]" value="kalah"
                                onclick="syncBattle({{ $index }}, 'kalah')"></td>
                        <td data-label="Gagal"><input type="radio" name="hasil[{{ $tim->id }}]" value="gagal"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Tombol Simpan Hasil Battle --}}
            <div class="center-form">
                 <button type="submit"
                    @if($timHariIni->count() < 2) disabled @endif
                    onclick="return confirm('Simpan hasil battle ini?')">
                    🥊 Simpan Hasil Battle
                </button>
            </div>
        </form>

        {{-- Tombol Reset Pos & Refund Battle --}}
        <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" class="center-form">
            @csrf
            <button type="submit" class="btn-danger"
                onclick="return confirm('Yakin reset pos ini? Uang tim akan dikembalikan.')">
                🔄 Reset Pos & Refund
            </button>
        </form>

        <script>
            function syncBattle(selectedIndex, result) {
                // Logika syncBattle tidak diubah
                const rows = document.querySelectorAll("table tbody tr");
                const otherIndex = selectedIndex === 0 ? 1 : 0;
                if (otherIndex >= rows.length) return; 
                
                if (result === "menang") {
                    rows[otherIndex].querySelector("input[value='kalah']").checked = true;
                }
                if (result === "kalah") {
                    rows[otherIndex].querySelector("input[value='menang']").checked = true;
                }
            }
        </script>
        @endif

        {{-- STEP 2: Pos Single --}}
        @elseif ($pos->tipe === 'single')
        @if ($timHariIni)
        <h3>Tim yang sedang bermain:</h3>
        <p class="text-xl font-bold mb-4">Tim: <span
                style="color: var(--color-gold-accent);">{{ $timHariIni->peserta_namaTim }}</span></p>
        
        {{-- Tombol Aksi Single Pos --}}
        <form method="POST" action="{{ route('admin.aksi', $pos->id) }}" style="width: 100%;">
            @csrf
            <input type="hidden" name="nama_tim" value="{{ $timHariIni->peserta_namaTim }}">
            <div class="action-button-group">
                <button name="action" value="menang" type="submit">🏆 Menang</button>
                <button name="action" value="kalah" type="submit">😞 Kalah</button>
                <button name="action" value="gagal" type="submit"
                    onclick="return confirm('Yakin menyatakan tim gagal dan mengosongkan pos?')"
                    class="btn-danger">❌ Gagal</button>
            </div>
        </form>

        <hr>
        {{-- Tombol Reset Pos & Refund Single --}}
        <form action="{{ route('admin.clearWaitingList', $pos->id) }}" method="POST" class="center-form">
            @csrf
            <button type="submit" class="btn-danger"
                onclick="return confirm('Yakin reset pos ini? Uang tim akan dikembalikan.')">
                🔄 Reset Pos & Refund
            </button>
        </form>
        @else
        <h3>Tim yang sedang bermain:</h3>
        <p><em>Tidak ada tim yang sedang bermain di pos ini. Pilih tim dari Waiting List di atas.</em></p>
        @endif
        @endif

    </div>
</body>

</html>
