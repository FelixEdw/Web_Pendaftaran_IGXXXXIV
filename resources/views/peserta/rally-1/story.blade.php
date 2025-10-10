<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>

    <style>
        /* ====== Tema Utama (Dari Referensi IG Dark Mode & Bronze Aksen) ====== */
        body {
            background-color: #14191A !important;
            font-family: 'Inter', sans-serif;
            color: #EAEAEA;
            margin: 0;
            padding: 0;
        }

        /* ====== Container Utama ====== */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* ====== Card Detail Event ====== */
        .event-box {
            background-color: #1C1F21;
            border: 1px solid #4A4A63;
            border-radius: 16px;
            padding: 32px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .event-title {
            font-size: 1.2rem;
            color: #FFDA89;
            margin-bottom: 8px;
        }

        p {
            color: #FFFFFF;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .divider {
            width: 60%;
            height: 2px;
            background-color: #956238;
            margin: 16px auto;
            border-radius: 2px;
        }

        .btn-bronze {
            background-color: #956238;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-bronze:hover {
            background-color: #A57248;
            transform: translateY(-1px);
        }

        .btn-bronze:disabled {
            background-color: #5A402D;
            cursor: not-allowed;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="event-box">
            <p>Event saat ini</p>
            <h4 class="event-title">{{ $event }}</h4>
            <div class="divider"></div>
            <a href="{{ route('peserta.rally-1.index') }}" class="btn-bronze">Kembali</a>
        </div>
    </div>
</body>

</html>