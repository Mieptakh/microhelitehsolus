<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

logoutAdmin();

// Redirect ke halaman login
header('Location: /webmaster/login');
exit;
?>