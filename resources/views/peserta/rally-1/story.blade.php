<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>

    <style>
        /* ====== Tema Utama (Dari Referensi IG Dark Mode & Bronze Aksen) ====== */
        body {
            font-family: 'Inter', sans-serif;
            color: #EAEAEA;
            margin: 0;
            padding: 0;
            /* Tambahkan properti background-size, background-position, dll. di sini */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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
            background-color: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            max-width: 300px;
            width: 90%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .event-title {
            font-size: 1.2rem;
            color: #FFDA89;
            margin-bottom: 50px;
        }

        p {
            color: #FFFFFF;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        /* Kelas divider ini sekarang tidak digunakan lagi di HTML */
        /* .divider {
            width: 60%;
            height: 2px;
            background-color: #956238;
            margin: 16px auto;
            border-radius: 2px;
        } */

        .btn-bronze {
            background-color: rgba(255, 255, 255, 0.5);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 50px;
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

<body style="background-image: url('{{ asset('images/Background_FAQ.svg') }}');">
    <div class="container">
        <div class="event-box">
            <p>Event saat ini</p>
            {{-- Karena nilai $event di gambar adalah "Tidak ada event pada sesi ini", saya asumsikan itu adalah string biasa --}}
            {{-- Jika $event adalah variabel Blade, pastikan tidak null atau gunakan default --}}
            <h4 class="event-title">{{ $event ?? 'Tidak ada event pada sesi ini' }}</h4>
            
            {{-- Garis divider telah dihapus dari sini --}}
            
            <a href="{{ route('peserta.rally-1.index') }}"class="btn-bronze">Kembali</a>
        </div>
    </div>
</body>

</html>