<?php
// =========================================
// KONFIGURASI DASAR
// =========================================
session_start();

define('BASE_URL', '/web_7/');  // ← UBAH INI
define('USERS_FILE', __DIR__ . '/data/users.json');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Load helper functions
require_once __DIR__ . '/includes/functions.php';