<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
require_once __DIR__ . '/../webmaster/includes/db.php'; // sesuaikan path jika kamu taruh di subfolder

// Ambil semua data paket
try {
    $stmt = $pdo->query("SELECT * FROM packages ORDER BY price ASC");
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Gagal memuat paket: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Paket Website - MHTeams</title>
    <link rel="stylesheet" href="styles.css"> <!-- sesuaikan jika pakai CSS eksternal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- pastikan FA tersedia -->
</head>
<body>
    <style>
        /* MHTeams - Styled Ratecard Section */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F9F9F9;
        color: #121212;
        margin: 0;
        padding: 0;
    }

    /* Section Layout */
    .ratecard-section {
        padding: 80px 20px;
        background-color: #F9F9F9;
    }

    .ratecard-section h2 {
        text-align: center;
        font-size: 36px;
        color: #9C27B0; /* Purple Pulse */
        margin-bottom: 10px;
    }

    .section-subtitle {
        text-align: center;
        font-size: 16px;
        color: #B0B0B0; /* Ash Grey */
        margin-bottom: 50px;
    }

    /* Grid */
    .ratecard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    /* Card */
    .ratecard-card {
        background-color: white;
        border-radius: 16px;
        padding: 30px 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
    }

    .ratecard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(156, 39, 176, 0.1);
        border-color: #7B1FA2; /* Deep Plum */
    }

    /* Header & Price */
    .ratecard-header h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #121212;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #7B1FA2; /* Deep Plum */
    }

    /* Feature List */
    .features {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
    }

    .features li {
        font-size: 14px;
        color: #333;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .features li i {
        color: #9C27B0;
        margin-right: 10px;
    }

    /* CTA Button */
    .btn-ratecard {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        background: linear-gradient(to right, #9C27B0, #7B1FA2); /* Gradient Purple */
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-ratecard:hover {
        background: #7B1FA2;
        transform: scale(1.03);
    }

    /* Fallback if no packages */
    .no-data {
        background-color: #FFE5EC;
        color: #9C27B0;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .ratecard-section h2 {
            font-size: 28px;
        }
    }
    </style>

<section class="ratecard-section" data-aos="fade-up">
    <div class="container">
        <h2><i class="fa-solid fa-boxes-stacked"></i> Semua Paket Website</h2>
        <p class="section-subtitle">Temukan paket yang sesuai dengan kebutuhan dan anggaran Anda.</p>

        <?php if (count($packages) > 0): ?>
        <div class="ratecard-grid">
            <?php foreach ($packages as $package): ?>
            <div class="ratecard-card">
                <div class="ratecard-header">
                    <h3><?php echo htmlspecialchars($package['name']); ?></h3>
                    <!-- Harga asli tanpa PPN -->
                    <div class="price">Rp <?php echo number_format($package['price'], 0, ',', '.'); ?></div>
                    <small class="text-muted">*Belum termasuk PPN 11%</small>
                </div>
                <ul class="features">
                    <?php 
                    $features = explode(',', $package['features']);
                    foreach ($features as $feature): 
                    ?>
                    <li><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars(trim($feature)); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="detail-paket?slug=<?php echo urlencode($package['slug']); ?>" class="btn-ratecard">
                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="no-data">Belum ada paket yang tersedia saat ini.</div>
        <?php endif; ?>
    </div>
</section>

</body>
<?php include 'includes/footer.php'; ?>
</html>
