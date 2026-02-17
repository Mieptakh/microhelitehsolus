<?php
require_once __DIR__ . '/includes/auth.php';

if (!isLoggedIn()) {
    header('Location: /webmaster/index.php');
    exit;
}

$title = "Dashboard Webmaster";
include __DIR__ . '/include/head.php';
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    :root {
        --primary: #9C27B0;
        --hover: #7B1FA2;
        --background: #F9F9F9;
        --text-dark: #121212;
        --danger: #e53935;
    }

    body {
        background-color: var(--background);
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .dashboard-container h1 {
        font-size: 28px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 24px;
    }

    .list-group {
        list-style: none;
        padding: 0;
    }

    .list-group-item {
        border: none;
        padding: 16px 20px;
        font-size: 16px;
        transition: background-color 0.25s ease;
        border-bottom: 1px solid #eee;
    }

    .list-group-item a {
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .list-group-item:hover {
        background-color: #f3e8ff;
    }

    .btn-danger {
        background-color: var(--danger);
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        color: #fff;
        margin-top: 20px;
    }

    .btn-danger:hover {
        background-color: #c62828;
    }

    @media (max-width: 600px) {
        .dashboard-container {
            padding: 20px;
        }

        .list-group-item {
            padding: 12px 16px;
        }

        .btn-danger {
            width: 100%;
        }
    }
</style>

<div class="dashboard-container">
    <h1><i class="fa-brands fa-microsoft"></i> Selamat datang, Admin!</h1>
    <ul class="list-group mb-4">
        <li class="list-group-item"><a href="/webmaster/edit-paket"><i class="fa-brands fa-dropbox"></i> Edit Paket</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-proyek"><i class="fa-brands fa-github-alt"></i> Edit Proyek</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-kolaborasi"><i class="fa-brands fa-slack"></i> Edit Kolaborasi</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-testimoni"><i class="fa-brands fa-discord"></i> Edit Testimoni</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-kontak"><i class="fa-brands fa-telegram"></i> Lihat Kontak</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-jadwal-temu"><i class="fa-brands fa-google-calendar"></i> Lihat Jadwal Temu</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-pengajuan-kolaborasi"><i class="fa-brands fa-hive"></i> Lihat Kolaborasi</a></li>
    </ul>

    <form method="post" action="/webmaster/logout.php">
        <button type="submit" class="btn btn-danger">
            <i class="fa-brands fa-xing"></i> Logout
        </button>
    </form>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>
