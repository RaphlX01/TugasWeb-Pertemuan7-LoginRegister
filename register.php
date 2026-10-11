<?php
require_once 'config.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = sanitize($_POST['nama'] ?? '');
    $email    = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirm  = $_POST['konfirmasi'] ?? '';

    // Validasi
    if (empty($nama) || empty($email) || empty($password) || empty($konfirm)) {
        $error = 'Semua field wajib diisi!';
    } elseif (strlen($nama) < 3) {
        $error = 'Nama minimal 3 karakter!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } elseif ($password !== $konfirm) {
        $error = 'Konfirmasi password tidak cocok!';
    } elseif (find_user_by_email($email) !== null) {
        $error = 'Email sudah terdaftar! Silakan login.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $users = get_users();
        $users[] = [
            'nama'     => $nama,
            'email'    => $email,
            'password' => $hashed,
            'created'  => date('Y-m-d H:i:s')
        ];
        save_users($users);

        set_flash('success', 'Registrasi berhasil! Silakan login.');
        header('Location: login.php');
        exit;
    }
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Tugas Rutin 7</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Akun</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['message'] ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama" 
                   value="<?= $_POST['nama'] ?? '' ?>" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="contoh@email.com" 
                   value="<?= $_POST['email'] ?? '' ?>" required>

            <label>Password (min 6 karakter)</label>
            <input type="password" name="password" placeholder="Password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="konfirmasi" placeholder="Ulangi password" required>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>