<?php
require_once 'config.php';
require_login();

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Tugas Rutin 7</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container container-wide">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <div class="header-actions">
                <a href="edit_profile.php" class="btn-edit">Edit Profil</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['message'] ?></div>
        <?php endif; ?>

        <div class="alert alert-success">
            Selamat datang, <strong><?= sanitize($_SESSION['user_nama']) ?></strong>!
        </div>

        <div class="info-box">
            <p><strong>Email:</strong> <?= sanitize($_SESSION['user_email']) ?></p>
            <p><strong>Status:</strong> Sudah login ✅</p>
            <p><strong>Waktu Login:</strong> <?= date('d M Y, H:i:s') ?></p>
        </div>

        <p class="note">Halaman ini dilindungi. Kalau lo akses tanpa login, otomatis redirect ke login.</p>
    </div>
</body>
</html>