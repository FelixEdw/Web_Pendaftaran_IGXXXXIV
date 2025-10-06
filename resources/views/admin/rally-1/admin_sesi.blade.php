<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sesi Game</title>
    <style>
        /* Palet Warna Industrial Games (IG) */
        :root {
            --color-bg-dark: #602c10; /* Cokelat Gelap / Base */
            --color-card-dark: #391E1E; /* Dark Reddish Brown untuk Card/Input */
            --color-bronze: #956238; /* Bronze Border */
            --color-gold-accent: #FBC02D; /* Bright Gold Accent */
            --color-text-light: #FFDA89; /* Light Gold/Yellow Text */
            --color-text-white: #FFFFFF;
            --color-text-dark: #14191A;
            --color-button-secondary: #774320; /* Warna Cokelat Gelap untuk Link/Tombol Sekunder */
        }

        /* 1. Latar Belakang & Font */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg-dark); 
            color: var(--color-text-light);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* 2. Kontainer Card */
        .container {
            max-width: 600px;
            background: var(--color-card-dark); /* Menggunakan warna card dark IG */
            margin: 20px; /* Adjust margin for mobile */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
            border: 2px solid var(--color-bronze);
            width: 90%;
        }

        /* Judul dan Teks */
        h3 {
            text-align: center;
            color: var(--color-gold-accent);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 5px rgba(251, 192, 45, 0.2);
        }

        p {
            text-align: center;
            font-size: 1rem;
            color: var(--color-text-light); /* Mengubah teks sesi aktif menjadi light gold */
            margin-bottom: 2rem;
        }
        p strong {
            color: var(--color-gold-accent);
            font-weight: 700;
        }

        /* Label */
        label {
            font-weight: 600;
            margin-top: 15px;
            /* Penambahan jarak di bawah label untuk memisahkannya dari select box */
            margin-bottom: 8px; 
            display: block;
            color: var(--color-text-light);
        }

        /* Select Input */
        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--color-bronze);
            font-size: 1rem;
            background-color: #2e1818; /* Sedikit lebih terang dari card dark untuk kontras */
            color: var(--color-text-white);
            appearance: none; /* Hide default arrow */
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23FFDA89%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
        }

        select option {
            background-color: var(--color-card-dark); 
            color: var(--color-text-white);
        }
        
        /* Button Update - Menggunakan Gold Accent */
        .primary-button {
            background-color: var(--color-gold-accent);
            color: var(--color-text-dark);
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 25px;
            display: block;
            width: 100%;
            transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .primary-button:hover {
            background-color: #FFC74B;
            transform: translateY(-1px);
        }

        /* Link Kembali - Menggunakan Bronze/Secondary Button Style untuk kontras */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: var(--color-text-light); /* Warna teks kembali diubah */
            font-weight: 600;
            font-size: 1rem;
        }

        .back-link:hover {
            color: var(--color-gold-accent);
            text-decoration: underline;
        }
        
        /* Responsive adjustments */
        @media (min-width: 600px) {
            .container {
                width: auto;
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <h3>⚙️ Ubah Sesi Game</h3>
        <p>Sesi aktif sekarang: <strong>{{ $sesiAktif }}</strong></p>

        <form method="POST" action="{{ route('admin.sesi.update') }}">
            @csrf
            <label for="sesi_aktif">Pilih Sesi</label>
            <select name="sesi_aktif" id="sesi_aktif">
                <option value="1" {{ $sesiAktif == 1 ? 'selected' : '' }}>Sesi 1</option>
                <option value="2" {{ $sesiAktif == 2 ? 'selected' : '' }}>Sesi 2</option>
                <option value="3" {{ $sesiAktif == 3 ? 'selected' : '' }}>Sesi 3</option>
                <option value="4" {{ $sesiAktif == 4 ? 'selected' : '' }}>Sesi 4</option>
            </select>

            <button type="submit" class="primary-button">Update Sesi</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Dashboard</a>
    </div>
    <div class="container-2">
        <h3>Leaderboard Peserta</h3>
    </div>
</body>

</html>