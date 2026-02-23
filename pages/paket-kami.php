<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php'; // Koneksi MySQL

// Ambil semua data paket
$packages = [];
$error_message = '';

try {
    $stmt = $pdo->query("SELECT * FROM packages ORDER BY price ASC");
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Gagal memuat paket: " . htmlspecialchars($e->getMessage());
    error_log("Error fetching packages: " . $e->getMessage());
}
?>

<!-- Packages Section - Custom dengan prefix mht-packages untuk konsistensi -->
<section id="mht-packages-section" class="mht-packages-section">
    <!-- Background Pattern - Full coverage -->
    <div class="mht-packages-bg-pattern"></div>
    
    <div class="mht-packages-container">
        <!-- Section Header -->
        <div class="mht-packages-header-wrapper">
            <span class="mht-packages-badge">PAKET KAMI</span>
            <h1 class="mht-packages-title">Semua <span>Paket Website</span></h1>
            <p class="mht-packages-subtitle">Temukan paket yang sesuai dengan kebutuhan dan anggaran Anda untuk membangun website profesional</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="mht-packages-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <?php if (empty($packages) && empty($error_message)): ?>
            <div class="mht-packages-empty">
                <i class="far fa-box-open"></i>
                <span>Belum ada paket yang tersedia saat ini.</span>
            </div>
        <?php else: ?>
            <div class="mht-packages-grid">
                <?php foreach ($packages as $package): 
                    $name = htmlspecialchars($package['name']);
                    $slug = htmlspecialchars($package['slug']);
                    $price = (int)$package['price'];
                    $features = explode(',', $package['features']);
                    
                    // Tentukan apakah ini paket populer (contoh: paket kedua atau dengan harga tertentu)
                    $isPopular = ($price >= 1500000 && $price <= 3000000) ? true : false;
                ?>
                <div class="mht-packages-card <?php echo $isPopular ? 'mht-packages-card-popular' : ''; ?>">
                    <?php if ($isPopular): ?>
                        <div class="mht-packages-popular-badge">
                            <i class="fas fa-crown"></i>
                            <span>Paling Populer</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mht-packages-card-inner">
                        <div class="mht-packages-header">
                            <h3 class="mht-packages-name"><?php echo $name; ?></h3>
                            <div class="mht-packages-price-wrapper">
                                <div class="mht-packages-price">Rp <?php echo number_format($price, 0, ',', '.'); ?></div>
                                <div class="mht-packages-price-note">*Belum termasuk PPN 11%</div>
                            </div>
                        </div>

                        <div class="mht-packages-features">
                            <h4 class="mht-packages-features-title">Fitur yang didapatkan:</h4>
                            <ul class="mht-packages-features-list">
                                <?php foreach ($features as $feature): 
                                    $feature = trim($feature);
                                    if (!empty($feature)):
                                ?>
                                    <li>
                                        <i class="fas fa-check mht-packages-feature-icon"></i>
                                        <span><?php echo htmlspecialchars($feature); ?></span>
                                    </li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        </div>

                        <div class="mht-packages-actions">
                            <a href="detail-paket?slug=<?php echo urlencode($slug); ?>" class="mht-packages-btn-detail">
                                <i class="far fa-eye"></i>
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right mht-packages-btn-icon"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* ===== MHT PACKAGES STYLES - WITH CUSTOM SCROLLBAR ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
@import url('https://use.fontawesome.com/releases/v6.0.0/css/all.css');

/* CSS Variables - Konsisten dengan halaman lain */
:root {
    --mht-packages-primary: #9C27B0;
    --mht-packages-primary-dark: #7B1FA2;
    --mht-packages-primary-light: rgba(156, 39, 176, 0.1);
    --mht-packages-text-dark: #121212;
    --mht-packages-text-body: #333333;
    --mht-packages-text-muted: #666666;
    --mht-packages-bg-light: #f8f8fc;
    --mht-packages-bg-white: #ffffff;
    --mht-packages-border: rgba(0, 0, 0, 0.05);
    --mht-packages-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-packages-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-packages-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-packages-radius: 20px;
    --bg-light: #F9F9F9; /* Untuk konsistensi dengan home page */
}

/* Reset total */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    overflow-x: hidden;
    background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    font-family: 'Poppins', sans-serif;
    scroll-behavior: smooth;
}

/* ===== CUSTOM SCROLLBAR - SAMA PERSIS DENGAN HOME DAN FAQ ===== */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: var(--bg-light);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--mht-packages-primary), var(--mht-packages-primary-dark));
    border-radius: 6px;
    border: 3px solid var(--bg-light);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--mht-packages-primary-dark);
}

/* Firefox scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--mht-packages-primary) var(--bg-light);
}

/* Main Section */
.mht-packages-section {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    width: 100%;
    background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    position: relative;
    overflow-x: hidden;
    padding: 30px 0 80px 0;
    margin: 0;
}

/* Background Pattern */
.mht-packages-bg-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 10% 20%, rgba(156, 39, 176, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(156, 39, 176, 0.03) 0%, transparent 50%);
    pointer-events: none;
    z-index: 1;
}

/* Container */
.mht-packages-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Header Section - Sinkron dengan halaman lain */
.mht-packages-header-wrapper {
    text-align: center;
    margin-bottom: 40px;
}

.mht-packages-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--mht-packages-primary-light), rgba(156, 39, 176, 0.05));
    color: var(--mht-packages-primary);
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    margin-bottom: 15px;
    border: 1px solid rgba(156, 39, 176, 0.2);
    text-transform: uppercase;
    backdrop-filter: blur(5px);
    font-family: 'Poppins', sans-serif;
}

.mht-packages-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--mht-packages-text-dark);
    margin-bottom: 12px;
    line-height: 1.2;
    font-family: 'Poppins', sans-serif;
}

.mht-packages-title span {
    background: linear-gradient(135deg, var(--mht-packages-primary), var(--mht-packages-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    font-family: 'Poppins', sans-serif;
}

.mht-packages-subtitle {
    font-size: 1rem;
    color: var(--mht-packages-text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

/* Packages Grid */
.mht-packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
    width: 100%;
}

/* Package Card */
.mht-packages-card {
    background: var(--mht-packages-bg-white);
    border-radius: var(--mht-packages-radius);
    overflow: hidden;
    box-shadow: var(--mht-packages-shadow-sm);
    transition: var(--mht-packages-transition);
    border: 1px solid var(--mht-packages-border);
    position: relative;
    height: 100%;
    width: 100%;
    opacity: 0;
    transform: translateY(20px);
    animation: mhtPackagesSlideIn 0.5s ease forwards;
}

.mht-packages-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 0;
    background: linear-gradient(to bottom, var(--mht-packages-primary), var(--mht-packages-primary-dark));
    transition: height 0.3s ease;
    z-index: 2;
}

.mht-packages-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--mht-packages-shadow-hover);
}

.mht-packages-card:hover::before {
    height: 100%;
}

/* Popular Package */
.mht-packages-card-popular {
    border: 2px solid var(--mht-packages-primary);
    transform: scale(1.02);
    position: relative;
    z-index: 3;
}

.mht-packages-card-popular:hover {
    transform: scale(1.02) translateY(-8px);
}

.mht-packages-popular-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--mht-packages-primary), var(--mht-packages-primary-dark));
    color: white;
    padding: 6px 15px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    z-index: 4;
    box-shadow: 0 4px 10px rgba(156, 39, 176, 0.3);
}

.mht-packages-popular-badge i {
    font-size: 0.8rem;
}

.mht-packages-card-inner {
    padding: 30px 25px 25px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Header */
.mht-packages-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--mht-packages-border);
}

.mht-packages-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--mht-packages-text-dark);
    margin-bottom: 15px;
    font-family: 'Poppins', sans-serif;
    transition: var(--mht-packages-transition);
}

.mht-packages-card:hover .mht-packages-name {
    color: var(--mht-packages-primary);
}

.mht-packages-price-wrapper {
    margin-bottom: 5px;
}

.mht-packages-price {
    font-size: 2rem;
    font-weight: 800;
    color: var(--mht-packages-primary);
    line-height: 1.2;
    font-family: 'Poppins', sans-serif;
}

.mht-packages-price-note {
    font-size: 0.75rem;
    color: var(--mht-packages-text-muted);
    font-family: 'Poppins', sans-serif;
}

/* Features */
.mht-packages-features {
    flex: 1;
    margin-bottom: 25px;
}

.mht-packages-features-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--mht-packages-text-dark);
    margin-bottom: 15px;
    font-family: 'Poppins', sans-serif;
}

.mht-packages-features-list {
    list-style: none;
}

.mht-packages-features-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    color: var(--mht-packages-text-body);
    font-size: 0.9rem;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
    border-bottom: 1px dashed var(--mht-packages-border);
}

.mht-packages-features-list li:last-child {
    border-bottom: none;
}

.mht-packages-feature-icon {
    color: var(--mht-packages-primary);
    font-size: 0.9rem;
    margin-top: 3px;
    flex-shrink: 0;
}

/* Actions */
.mht-packages-actions {
    margin-top: auto;
}

.mht-packages-btn-detail {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, var(--mht-packages-primary), var(--mht-packages-primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    transition: var(--mht-packages-transition);
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    position: relative;
    overflow: hidden;
}

.mht-packages-btn-detail::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.mht-packages-btn-detail:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.4);
}

.mht-packages-btn-detail:hover::before {
    left: 100%;
}

.mht-packages-btn-detail:hover .mht-packages-btn-icon {
    transform: translateX(5px);
}

.mht-packages-btn-icon {
    transition: transform 0.3s ease;
}

/* Empty State */
.mht-packages-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: var(--mht-packages-bg-white);
    border-radius: var(--mht-packages-radius);
    color: var(--mht-packages-text-muted);
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
    border: 2px dashed rgba(156, 39, 176, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.mht-packages-empty i {
    font-size: 3rem;
    color: var(--mht-packages-primary);
    opacity: 0.5;
}

/* Error State */
.mht-packages-error {
    grid-column: 1 / -1;
    background: #FEE2E2;
    color: #B91C1C;
    padding: 16px 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    border-left: 4px solid #B91C1C;
    margin-bottom: 30px;
}

.mht-packages-error i {
    font-size: 1.3rem;
    color: #B91C1C;
}

/* Animations */
@keyframes mhtPackagesSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Staggered Animation */
.mht-packages-card:nth-child(1) { animation-delay: 0.1s; }
.mht-packages-card:nth-child(2) { animation-delay: 0.15s; }
.mht-packages-card:nth-child(3) { animation-delay: 0.2s; }
.mht-packages-card:nth-child(4) { animation-delay: 0.25s; }
.mht-packages-card:nth-child(5) { animation-delay: 0.3s; }
.mht-packages-card:nth-child(6) { animation-delay: 0.35s; }

/* Pulse Animation untuk Popular Badge */
@keyframes mhtPulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.mht-packages-card-popular .mht-packages-popular-badge {
    animation: mhtPulse 2s infinite;
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 992px) {
    .mht-packages-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .mht-packages-section {
        padding: 20px 0 60px 0;
    }
    
    .mht-packages-container {
        padding: 0 15px;
    }
    
    .mht-packages-header-wrapper {
        margin-bottom: 30px;
    }
    
    .mht-packages-badge {
        margin-bottom: 10px;
        padding: 5px 16px;
        font-size: 0.75rem;
    }
    
    .mht-packages-title {
        font-size: 1.8rem;
    }
    
    .mht-packages-subtitle {
        font-size: 0.95rem;
    }
    
    .mht-packages-grid {
        grid-template-columns: 1fr;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .mht-packages-card-inner {
        padding: 25px 20px 20px;
    }
    
    .mht-packages-name {
        font-size: 1.2rem;
    }
    
    .mht-packages-price {
        font-size: 1.8rem;
    }
    
    .mht-packages-card-popular {
        transform: scale(1);
    }
    
    .mht-packages-card-popular:hover {
        transform: translateY(-8px);
    }
    
    /* Scrollbar tetap sama di mobile */
    ::-webkit-scrollbar {
        width: 8px;
    }
}

@media (max-width: 576px) {
    .mht-packages-section {
        padding: 15px 0 50px 0;
    }
    
    .mht-packages-title {
        font-size: 1.5rem;
    }
    
    .mht-packages-badge {
        font-size: 0.7rem;
        padding: 4px 14px;
    }
    
    .mht-packages-popular-badge {
        top: 10px;
        right: 10px;
        padding: 4px 12px;
        font-size: 0.7rem;
    }
}

/* Hover effect tambahan */
.mht-packages-card:hover .mht-packages-feature-icon {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}

/* Smooth scrolling untuk anchor links */
html {
    scroll-padding-top: 80px;
}

/* Fallback jika Font Awesome lambat load */
.fa, .fas, .far, .fab, .fal, .fad {
    font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands', sans-serif;
}
</style>

<!-- Font Awesome dengan fallback CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Backup CDN -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<script>
// Optional: Tambahkan smooth scroll untuk anchor links
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk semua anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Fallback check untuk Font Awesome
    function checkFontAwesome() {
        var testElement = document.createElement('span');
        testElement.className = 'fas';
        testElement.style.display = 'none';
        document.body.appendChild(testElement);
        
        // Get computed style
        var computedStyle = window.getComputedStyle(testElement);
        var fontFamily = computedStyle.getPropertyValue('font-family');
        
        // Check if Font Awesome is loaded
        if (!fontFamily.includes('Font Awesome')) {
            console.log('Font Awesome not loaded, loading fallback...');
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://use.fontawesome.com/releases/v6.0.0/css/all.css';
            document.head.appendChild(link);
        }
        
        document.body.removeChild(testElement);
    }
    
    // Run check after a short delay
    setTimeout(checkFontAwesome, 100);
});
</script>

<!-- Fallback font display -->
<noscript>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>