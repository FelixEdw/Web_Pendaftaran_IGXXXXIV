<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sesi Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: white;
            margin: 50px auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #444;
        }

        p {
            text-align: center;
            font-size: 16px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Ubah Sesi Game</h3>
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

            <button type="submit">Update Sesi</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Dashboard</a>
    </div>
</body>

</html>