<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengajuan Faktur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            position: relative;
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

        .title {
            text-align: center;
        }

        .subtitle {
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container is-fluid">
        <section class="hero is-medium is-primary ">
            <div class="hero-body">
                <p class="title has-text-light">Selamat datang di Aplikasi Pengajuan Faktur</p>
                <p class="subtitle has-text-light">Ajukan penagihan fakturmu dengan cepat dan efisien. Sederhanakan proses penagihan Anda dan dapatkan pembayaran lebih cepat.</p>
                <div class="button-container">
                    <button class="button is-light has-shadow has-text-primary" onclick="window.location.href='<?= site_url('login') ?>'">Masuk</button>
                </div>
            </div>
        </section>

        <figure class="image is-16by9">
            <img src="\assets\images\onlinepayment.png" alt="Transparent Image">
        </figure>


        <div class="features">
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
    </div>
</body>

</html>