<?php
session_start(); // Penting: session_start() harus di paling atas

require_once __DIR__ . '/includes/auth.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    // Redirect ke halaman login, BUKAN index.php
    header('Location: /webmaster/login.php');
    exit;
}

$title = "Dashboard Webmaster";

// Perhatikan: folder include (tanpa 's') - sesuaikan dengan struktur Anda
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
        --success: #4CAF50;
    }

    body {
        background-color: var(--background);
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 20px;
    }

    .dashboard-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-container h1 {
        font-size: 28px;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 24px;
        border-bottom: 2px solid var(--primary);
        padding-bottom: 15px;
    }

    .dashboard-container h1 i {
        margin-right: 10px;
    }

    .list-group {
        list-style: none;
        padding: 0;
    }

    .list-group-item {
        border: none;
        padding: 16px 20px;
        font-size: 16px;
        transition: all 0.25s ease;
        border-bottom: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 5px;
    }

    .list-group-item a {
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .list-group-item a i {
        width: 25px;
        color: var(--primary);
        font-size: 1.2rem;
    }

    .list-group-item:hover {
        background-color: #f3e8ff;
        transform: translateX(5px);
        border-left: 3px solid var(--primary);
    }

    .btn-logout {
        background: linear-gradient(135deg, var(--danger), #c62828);
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        color: #fff;
        margin-top: 20px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
    }

    .btn-logout:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(229, 57, 53, 0.4);
    }

    .btn-logout:active {
        transform: translateY(0);
    }

    .stats-card {
        background: linear-gradient(135deg, var(--primary), var(--hover));
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stats-card i {
        font-size: 3rem;
        opacity: 0.8;
    }

    .stats-card .stats-text h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .stats-card .stats-text p {
        margin: 0;
        opacity: 0.9;
    }

    @media (max-width: 600px) {
        .dashboard-container {
            padding: 20px;
        }

        .list-group-item {
            padding: 12px 16px;
        }

        .btn-logout {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="dashboard-container">
    <h1><i class="fas fa-crown"></i> Selamat datang, Admin!</h1>
    
    <!-- Stats Card -->
    <div class="stats-card">
        <i class="fas fa-chart-line"></i>
        <div class="stats-text">
            <h3>Webmaster Panel</h3>
            <p>Anda memiliki akses penuh untuk mengelola konten website</p>
        </div>
    </div>
    
    <ul class="list-group mb-4">
        <li class="list-group-item"><a href="/webmaster/edit-paket.php"><i class="fas fa-box"></i> Edit Paket</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-proyek.php"><i class="fas fa-code"></i> Edit Proyek</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-kolaborasi.php"><i class="fas fa-handshake"></i> Edit Kolaborasi</a></li>
        <li class="list-group-item"><a href="/webmaster/edit-testimoni.php"><i class="fas fa-star"></i> Edit Testimoni</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-kontak.php"><i class="fas fa-envelope"></i> Lihat Kontak</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-jadwal-temu.php"><i class="fas fa-calendar-alt"></i> Lihat Jadwal Temu</a></li>
        <li class="list-group-item"><a href="/webmaster/tampilkan-pengajuan-kolaborasi.php"><i class="fas fa-file-signature"></i> Lihat Pengajuan Kolaborasi</a></li>
    </ul>

    <form method="post" action="/webmaster/logout.php" id="logoutForm">
        <button type="submit" class="btn-logout" id="logoutBtn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutForm = document.getElementById('logoutForm');
    const logoutBtn = document.getElementById('logoutBtn');
    
    logoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin logout?')) {
            logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging out...';
            logoutBtn.disabled = true;
            this.submit();
        }
    });
});
</script>

<?php include __DIR__ . '/include/footer.php'; ?>