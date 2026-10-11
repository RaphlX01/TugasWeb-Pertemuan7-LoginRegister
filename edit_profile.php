<?php
require_once 'config.php';
require_login();

$error = '';
$success = '';

$user = find_user_by_email($_SESSION['user_email']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_baru = sanitize($_POST['nama'] ?? '');
    $password_baru = $_POST['password'] ?? '';
    $konfirm = $_POST['konfirmasi'] ?? '';

    if (empty($nama_baru)) {
        $error = 'Nama tidak boleh kosong!';
    } elseif (strlen($nama_baru) < 3) {
        $error = 'Nama minimal 3 karakter!';
    } else {
        $update = ['nama' => $nama_baru];

        // Kalau password diisi, update password
        if (!empty($password_baru)) {
            if (strlen($password_baru) < 6) {
                $error = 'Password minimal 6 karakter!';
            } elseif ($password_baru !== $konfirm) {
                $error = 'Konfirmasi password tidak cocok!';
            } else {
                $update['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
            }
        }

        if (empty($error)) {
            update_user($_SESSION['user_email'], $update);
            $_SESSION['user_nama'] = $nama_baru;

            set_flash('success', 'Profil berhasil diperbarui!');
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil — Tugas Rutin 7</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Profil</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Email (tidak bisa diubah)</label>
            <input type="email" value="<?= sanitize($user['email']) ?>" disabled>

            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= sanitize($user['nama']) ?>" required>

            <label>Password Baru (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" placeholder="Password baru">

            <label>Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi" placeholder="Ulangi password baru">

            <button type="submit">Simpan Perubahan</button>
        </form>

        <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
    </div>
</body>
</html>