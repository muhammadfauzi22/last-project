<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengajuan Faktur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3em;
            margin: 0;
        }

        .hero p {
            font-size: 1.2em;
            margin: 20px 0;
        }

        .hero button {
            background-color: #fff;
            color: #4facfe;
            border: none;
            padding: 15px 30px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .hero button:hover {
            background-color: #4facfe;
            color: white;
        }

        .features {
            padding: 50px 20px;
            background: #f7f7f7;
            text-align: center;
        }

        .features h2 {
            margin-bottom: 40px;
            font-size: 2.5em;
        }

        .feature-item {
            margin: 20px;
            display: inline-block;
            width: 300px;
        }

        .feature-item i {
            font-size: 3em;
            color: #4facfe;
        }

        .feature-item h3 {
            margin-top: 20px;
            font-size: 1.5em;
        }

        .feature-item p {
            margin-top: 10px;
            font-size: 1em;
        }
    </style>
</head>

<body>
    <div class="hero">
        <h1>Selamat datang di Aplikasi Pengajuan Faktur</h1>
        <p>Ajukan penagihan fakturmu dengan cepat dan efisien. Sederhanakan proses penagihan Anda dan dapatkan pembayaran lebih cepat.</p>
        <button onclick="window.location.href='<?= site_url('login') ?>'">Masuk</button>
    </div>

    <div class="features">
        <h2>Features</h2>
        <div class="feature-item">
            <i class="fas fa-paper-plane"></i>
            <h3>Mudah</h3>
            <p>Ajukan faktur dengan beberapa klik dan lacak statusnya secara real-time.</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-lock"></i>
            <h3>Aman</h3>
            <p>Data Anda dilindungi dengan langkah-langkah keamanan standar industri.</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-chart-line"></i>
            <h3>Informatif</h3>
            <p>Dapatkan laporan ringkas informatif tentang pengiriman dan pembayaran faktur Anda.</p>
        </div>
    </div>
</body>

</html>