<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengajuan Faktur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
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

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 50vh;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            text-align: center;
            padding: 0 20px;
            position: relative;
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
            margin-top: 100px;
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

        .image-on-border {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            /* Adjust width as needed */
            height: auto;
            /* Maintain aspect ratio */
        }

        .modal {
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
        }

        .modal h1 {
            margin-bottom: 20px;
        }

        .modal input[type="text"],
        .modal input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal button {
            background-color: #4facfe;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal button:hover {
            background-color: #00f2fe;
        }

        .modal .error {
            color: red;
            margin-bottom: 10px;
        }

        .modal .success {
            color: green;
            margin-bottom: 10px;
        }

        .modal a {
            display: block;
            margin-top: 10px;
            color: #4facfe;
            text-decoration: none;
        }

        .modal a:hover {
            text-decoration: underline;
        }

        .modal-card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container is-fluid">
        <section class="hero is-medium">
            <div class="hero-body">
                <p class="title has-text-light">Selamat datang di Aplikasi Pengajuan Faktur</p>
                <p class="subtitle has-text-light">Ajukan penagihan fakturmu dengan cepat dan efisien. Sederhanakan proses penagihan Anda dan dapatkan pembayaran lebih cepat.</p>
                <div class="button-container">
                    <button class="button has-background-light has-text-info is-outlined js-modal-trigger" data-target="login-modal">Masuk</button>
                </div>
            </div>
            <img src="assets/images/onlinepayment.png" alt="Transparent Image" class="image-on-border">
        </section>

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

    <div id="login-modal" class="modal is-outlined is-info">
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Login</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <?php if (isset($error)) : ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
                <form id="loginForm">
                    <?= csrf_field() ?>
                    <input type="text" id="email" name="email" placeholder="Alamat Email" required>
                    <input type="password" id="password" name="password" placeholder="Sandi" required>
                    <button type="submit">Login</button>
                </form>
            </section>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Functions to open and close a modal
        function openModal($el) {
            $el.classList.add('is-active');
        }

        function closeModal($el) {
            $el.classList.remove('is-active');
        }

        function closeAllModals() {
            (document.querySelectorAll('.modal') || []).forEach(($modal) => {
                closeModal($modal);
            });
        }

        // Add a click event on buttons to open a specific modal
        (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });

        // Add a click event on various child elements to close the parent modal
        (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
            const $target = $close.closest('.modal');

            $close.addEventListener('click', () => {
                closeModal($target);
            });
        });

        // Add a keyboard event to close all modals
        document.addEventListener('keydown', (event) => {
            if (event.key === "Escape") {
                closeAllModals();
            }
        });
    });

    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Login Sedang Diproses.',
                html: 'Mohon Tunggu. Jangan keluar dari halaman.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
            $.ajax({
                url: '/api/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: $('#email').val(),
                    password: $('#password').val()
                }),
                success: function(response) {
                    Swal.fire(
                        'Login Berhasil!',
                        '',
                        'success'
                    ).then(() => {
                        window.location.href = '/dashboard';
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Login Gagal!',
                        xhr.responseText,
                        'error'
                    );
                    // alert('Failed to login: ' + xhr.responseText);
                }
            });
        });
    });
</script>

</html>