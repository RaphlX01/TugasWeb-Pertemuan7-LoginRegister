<?php
require_once 'config.php';

// Redirect otomatis
if (is_logged_in()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;