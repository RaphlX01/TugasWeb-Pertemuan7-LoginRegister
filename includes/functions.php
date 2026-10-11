<?php

// Baca data user dari JSON
function get_users() {
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, '[]');
        return [];
    }
    $data = file_get_contents(USERS_FILE);
    return json_decode($data, true) ?: [];
}

// Simpan data user ke JSON
function save_users($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT), LOCK_EX);
}

// Sanitasi input
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Cek apakah user udah login
function is_logged_in() {
    return isset($_SESSION['user_email']);
}

// Redirect jika belum login
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// Cari user berdasarkan email
function find_user_by_email($email) {
    $users = get_users();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}

// Update data user
function update_user($email, $new_data) {
    $users = get_users();
    foreach ($users as $i => $user) {
        if ($user['email'] === $email) {
            $users[$i] = array_merge($user, $new_data);
            save_users($users);
            return true;
        }
    }
    return false;
}

// Flash message helper
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}