<?php
require_once 'config.php';

// Hapus semua session (Requirement 8)
session_unset();
session_destroy();

// Hapus cookie "Remember Me" jika ada
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/');
}

// Redirect
header('Location: login.php');
exit;