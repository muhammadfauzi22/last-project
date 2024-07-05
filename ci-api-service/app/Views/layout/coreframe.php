<!DOCTYPE html>
<html lang="en" has-navbar-fixed-top>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
</head>

<body>
    <?= $this->include('layout\navbar') ?>
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>
</body>

</html>