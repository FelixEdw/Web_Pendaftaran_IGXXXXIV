<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sesi Game</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #602c10;
            color: #FFDA89;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #391E1E;
            border: 2px solid #956238;
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }

        h3 {
            text-align: center;
            color: #FBC02D;
        }

        select,
        input[type=password] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #956238;
            background: #2e1818;
            color: #fff;
            font-size: 1rem;
        }

        button {
            background-color: #FBC02D;
            color: #14191A;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #FFC74B;
        }

        .hidden {
            display: none;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #FFDA89;
            text-decoration: none;
        }

        .back-link:hover {
            color: #FBC02D;
        }

        /* 🎨 CSS untuk tabel leaderboard */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #2e1818;
            border-radius: 8px;
            overflow: hidden;
        }

        table th,
        table td {
            padding: 10px 12px;
            text-align: center;
            border-bottom: 1px solid #956238;
        }

        table th {
            background-color: #FBC02D;
            color: #14191A;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #3E2020;
        }

        table tr:nth-child(odd) {
            background-color: #2e1818;
        }

        table tr:hover {
            background-color: #5a2d2d;
            transition: 0.2s ease;
        }

        table td {
            color: #FFDA89;
        }

        h2 {
            text-align: center;
            color: #FBC02D;
            margin-bottom: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>⚙️ Ubah Sesi Game</h3>
        <p>Sesi aktif sekarang: <strong>{{ $sesiAktif }}</strong></p>

        {{-- Form Input PIN --}}
        <div id="pinSection">
            <label for="pin">Masukkan PIN Admin</label>
            <input type="password" id="pin" placeholder="Masukkan PIN">
            <button type="button" id="verifyPin">Verifikasi PIN</button>
            <p id="pinError" style="color:#ff9999; display:none; text-align:center;">PIN salah, coba lagi!</p>
        </div>

        {{-- Form Ubah Sesi --}}
        <form method="POST" action="{{ route('admin.sesi.update') }}" id="sesiForm" class="hidden">
            @csrf
            <label for="sesi_aktif">Pilih Sesi</label>
            <select name="sesi_aktif" id="sesi_aktif">
                <option value="1" {{ $sesiAktif == 1 ? 'selected' : '' }}>Sesi 1</option>
                <option value="2" {{ $sesiAktif == 2 ? 'selected' : '' }}>Sesi 2</option>
                <option value="3" {{ $sesiAktif == 3 ? 'selected' : '' }}>Sesi 3</option>
                <option value="4" {{ $sesiAktif == 4 ? 'selected' : '' }}>Sesi 4</option>
            </select>

            {{-- Hidden input untuk kirim PIN ke backend --}}
            <input type="hidden" name="pin_real" id="pin_real">

            <button type="submit">Update Sesi</button>
        </form>

        <br>

        <div>
            <h2>Leaderboard</h2>
            <table border="1" cellpadding="6">
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Tim</th>
                    <th>Poin Total</th>
                </tr>
                @foreach($leaderboard as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_tim }}</td>
                    <td>{{ $item->poin_total }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Dashboard</a>
    </div>

    <script>
        const correctPin = "yangsisiaja";
        const pinInput = document.getElementById('pin');
        const verifyBtn = document.getElementById('verifyPin');
        const pinError = document.getElementById('pinError');
        const sesiForm = document.getElementById('sesiForm');
        const pinSection = document.getElementById('pinSection');
        const pinReal = document.getElementById('pin_real');

        verifyBtn.addEventListener('click', () => {
            if (pinInput.value === correctPin) {
                pinSection.classList.add('hidden');
                sesiForm.classList.remove('hidden');
                pinReal.value = pinInput.value;
            } else {
                pinError.style.display = 'block';
            }
        });
    </script>
</body>

</html>