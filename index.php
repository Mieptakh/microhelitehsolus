<?php
session_start(); // Untuk autentikasi

// Ambil URI path dan trim slash depan-belakang
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// ==========================
// ROUTING HALAMAN PUBLIK
// ==========================
$routes = [
    '' => 'pages/index.php',
    'tentang-kami' => 'pages/tentang-kami.php',
    'proyek-kami' => 'pages/proyek-kami.php',
    'detail-proyek' => 'pages/detail-proyek.php',
    'paket-kami' => 'pages/paket-kami.php',
    'detail-paket' => 'pages/detail-paket.php',
    'jadwal-temu' => 'pages/jadwal-temu.php',
    'pengajuan-kolaborasi' => 'pages/pengajuan-kolaborasi.php',
    'kontak' => 'pages/kontak.php',
    'testimoni' => 'pages/testimoni.php',
    'frequently-asked-question' => 'pages/frequently-asked-question.php',
    'berita' => 'pages/berita.php',
    'detail-berita' => 'pages/detail-berita.php',
];

// ==========================
// ROUTING HALAMAN WEBMASTER
// ==========================
$adminRoutes = [
    'webmaster' => 'webmaster/index.php',
    'webmaster/dashboard' => 'webmaster/dashboard.php',
    'webmaster/edit-paket' => 'webmaster/edit-paket.php',
    'webmaster/edit-proyek' => 'webmaster/edit-proyek.php',
    'webmaster/edit-kolaborasi' => 'webmaster/edit-kolaborasi.php',
    'webmaster/edit-testimoni' => 'webmaster/edit-testimoni.php',
    'webmaster/tampilkan-jadwal-temu' => 'webmaster/tampilkan-jadwal-temu.php',
    'webmaster/tampilkan-kontak' => 'webmaster/tampilkan-kontak.php',
    'webmaster/tampilkan-pengajuan-kolaborasi' => 'webmaster/tampilkan-pengajuan-kolaborasi.php',
];

// Gabungkan semua routing
$allRoutes = array_merge($routes, $adminRoutes);

// ==========================
// MIDDLEWARE: CEK LOGIN JIKA MASUK HALAMAN ADMIN
// ==========================
if (str_starts_with($uri, 'webmaster')) {
    $authFile = __DIR__ . '/webmaster/includes/auth.php';
    if (file_exists($authFile)) {
        require_once $authFile;
        if (!isLoggedIn()) {
            // Redirect jika belum login
            header('Location: /403');
            exit;
        }
    } else {
        // Jika file auth tidak ditemukan
        showErrorPage(500, 'Auth middleware not found.');
    }
}

// ==========================
// FUNGSI HALAMAN ERROR
// ==========================
function showErrorPage(int $code = 404, string $message = ''): void {
    http_response_code($code);
    $defaultMessage = match ($code) {
        403 => 'Akses ditolak. Anda tidak memiliki izin.',
        404 => 'Halaman yang Anda cari tidak ditemukan.',
        500 => 'Terjadi kesalahan server.',
        default => 'Terjadi kesalahan tidak diketahui.',
    };

    $fullMessage = $message ?: $defaultMessage;

    echo "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'>";
    echo "<title>Error $code</title></head><body>";
    echo "<h1>Error $code</h1><p>$fullMessage</p><a href='/'>Kembali ke Beranda</a>";
    echo "</body></html>";
    exit;
}

// ==========================
// PROSES ROUTING
// ==========================
if (array_key_exists($uri, $allRoutes)) {
    $filePath = __DIR__ . '/' . $allRoutes[$uri];
    if (file_exists($filePath)) {
        include $filePath;
    } else {
        showErrorPage(500, 'File tidak ditemukan.');
    }
} else {
    showErrorPage(404);
}
