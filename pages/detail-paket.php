<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php'; // sesuaikan path sesuai struktur kamu

if (!isset($_GET['slug'])) {
    // Redirect ke halaman paket jika slug tidak ditemukan
    header('Location: paket-kami.php');
    exit;
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE slug = ?");
    $stmt->execute([$slug]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        // Redirect ke halaman paket jika paket tidak tersedia
        header('Location: paket-kami.php');
        exit;
    }

    // Hitung harga termasuk PPN 11%
    $ppn = 0.11;
    $priceWithoutPpn = $package['price'];
    $priceWithPpn = $priceWithoutPpn + ($priceWithoutPpn * $ppn);

} catch (PDOException $e) {
    die("Kesalahan database: " . htmlspecialchars($e->getMessage()));
}
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<!-- Package Detail Section -->
<section id="mht-package-detail" class="mht-package-detail-section">
    <!-- Background Pattern -->
    <div class="mht-package-detail-bg-pattern"></div>
    
    <div class="mht-package-detail-container">
        <!-- Back Button -->
        <a href="paket-kami.php" class="mht-package-detail-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Semua Paket</span>
        </a>

        <div class="mht-package-detail-wrapper">
            <!-- Main Content -->
            <div class="mht-package-detail-main">
                <div class="mht-package-detail-header">
                    <span class="mht-package-detail-badge">DETAIL PAKET</span>
                    <h1 class="mht-package-detail-title"><?php echo htmlspecialchars($package['name']); ?></h1>
                </div>

                <!-- Price Card -->
                <div class="mht-package-detail-price-card">
                    <div class="mht-package-detail-price-wrapper">
                        <div class="mht-package-detail-price-label">Harga Paket</div>
                        <div class="mht-package-detail-price-amount">
                            <span class="mht-package-detail-price-currency">Rp</span>
                            <span class="mht-package-detail-price-number"><?php echo number_format($priceWithoutPpn, 0, ',', '.'); ?></span>
                        </div>
                        <div class="mht-package-detail-price-note">*Belum termasuk PPN 11%</div>
                    </div>
                    <div class="mht-package-detail-price-total">
                        <div class="mht-package-detail-total-label">Total dengan PPN 11%:</div>
                        <div class="mht-package-detail-total-amount">Rp <?php echo number_format($priceWithPpn, 0, ',', '.'); ?></div>
                    </div>
                </div>

                <!-- Features -->
                <div class="mht-package-detail-features">
                    <h2 class="mht-package-detail-subtitle">
                        <i class="fas fa-list-check"></i>
                        Fitur yang Didapatkan
                    </h2>
                    <ul class="mht-package-detail-features-list">
                        <?php
                        $features = explode(',', $package['features']);
                        foreach ($features as $feature): 
                            $feature = trim($feature);
                            if (!empty($feature)):
                        ?>
                            <li>
                                <i class="fas fa-circle-check mht-package-detail-feature-icon"></i>
                                <span><?php echo htmlspecialchars($feature); ?></span>
                            </li>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </ul>
                </div>

                <!-- Screenshots Gallery -->
                <?php if (!empty($package['screenshots'])): 
                    $screenshots = explode(',', $package['screenshots']);
                ?>
                <div class="mht-package-detail-gallery">
                    <h2 class="mht-package-detail-subtitle">
                        <i class="fas fa-images"></i>
                        Contoh Tampilan
                    </h2>
                    <div class="mht-package-detail-gallery-grid">
                        <?php foreach ($screenshots as $img): 
                            $img = trim($img);
                            if (!empty($img)):
                        ?>
                            <div class="mht-package-detail-gallery-item">
                                <img src="/uploads/<?php echo htmlspecialchars($img); ?>" 
                                     alt="Screenshot <?php echo htmlspecialchars($package['name']); ?>"
                                     loading="lazy">
                                <div class="mht-package-detail-gallery-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="mht-package-detail-actions">
                    <?php if (!empty($package['preview_url'])): ?>
                        <a href="<?php echo htmlspecialchars($package['preview_url']); ?>" 
                           class="mht-package-detail-btn-preview" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="far fa-eye"></i>
                            <span>Live Preview</span>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="https://wa.me/6285183241229?text=Halo%20saya%20tertarik%20dengan%20paket%20<?php echo urlencode($package['name']); ?>" 
                       class="mht-package-detail-btn-wa" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Sidebar - Payment Methods -->
            <div class="mht-package-detail-sidebar">
                <div class="mht-package-detail-payment">
                    <h3 class="mht-package-detail-payment-title">
                        <i class="far fa-credit-card"></i>
                        Metode Pembayaran
                    </h3>
                    
                    <div class="mht-package-detail-payment-methods">
                        <!-- Bank Transfer -->
                        <div class="mht-package-detail-payment-group">
                            <h4 class="mht-package-detail-payment-group-title">
                                <i class="fas fa-university"></i>
                                Bank Transfer
                            </h4>
                            <div class="mht-package-detail-payment-items">
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/SeaBank_Indonesia_logo.svg" 
                                         alt="SeaBank" 
                                         class="mht-package-detail-payment-logo">
                                    <span>SeaBank</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/14/Bank_Jago_logo.svg" 
                                         alt="Bank Jago" 
                                         class="mht-package-detail-payment-logo">
                                    <span>Bank Jago</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia_logo.svg" 
                                         alt="BCA" 
                                         class="mht-package-detail-payment-logo">
                                    <span>Bank BCA</span>
                                </div>
                            </div>
                        </div>

                        <!-- E-Wallet -->
                        <div class="mht-package-detail-payment-group">
                            <h4 class="mht-package-detail-payment-group-title">
                                <i class="fas fa-mobile-alt"></i>
                                E-Wallet
                            </h4>
                            <div class="mht-package-detail-payment-items">
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c4/OVO_logo.svg" 
                                         alt="OVO" 
                                         class="mht-package-detail-payment-logo">
                                    <span>OVO</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/DANA_logo.svg" 
                                         alt="DANA" 
                                         class="mht-package-detail-payment-logo">
                                    <span>DANA</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/Logo_Gopay.svg" 
                                         alt="GoPay" 
                                         class="mht-package-detail-payment-logo">
                                    <span>GoPay</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/ShopeePay_logo.svg" 
                                         alt="ShopeePay" 
                                         class="mht-package-detail-payment-logo">
                                    <span>ShopeePay</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pembayaran Lainnya -->
                        <div class="mht-package-detail-payment-group">
                            <h4 class="mht-package-detail-payment-group-title">
                                <i class="fas fa-qrcode"></i>
                                Pembayaran Lainnya
                            </h4>
                            <div class="mht-package-detail-payment-items">
                                <div class="mht-package-detail-payment-item">
                                    <i class="fas fa-qrcode"></i>
                                    <span>QRIS</span>
                                </div>
                                <div class="mht-package-detail-payment-item">
                                    <i class="fas fa-money-bill"></i>
                                    <span>Cash (Offline)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mht-package-detail-payment-note">
                        <i class="fas fa-info-circle"></i>
                        <p>Detail nomor rekening atau e-wallet akan diberikan setelah Anda menghubungi kami melalui WhatsApp. Kami akan membalas dengan informasi pembayaran lengkap.</p>
                    </div>

                    <div class="mht-package-detail-payment-security">
                        <i class="fas fa-shield-alt"></i>
                        <span>Pembayaran 100% Aman & Terpercaya</span>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mht-package-detail-contact">
                    <h3 class="mht-package-detail-contact-title">
                        <i class="fas fa-headset"></i>
                        Butuh Bantuan?
                    </h3>
                    <p class="mht-package-detail-contact-text">
                        Tim kami siap membantu Anda memilih paket yang tepat dan menjawab pertanyaan seputar pembayaran.
                    </p>
                    <a href="https://wa.me/6285183241229" class="mht-package-detail-contact-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        <span>Chat via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== MHT PACKAGE DETAIL STYLES - WITH CUSTOM SCROLLBAR ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

/* CSS Variables */
:root {
    --mht-package-primary: #9C27B0;
    --mht-package-primary-dark: #7B1FA2;
    --mht-package-primary-light: rgba(156, 39, 176, 0.1);
    --mht-package-text-dark: #121212;
    --mht-package-text-body: #333333;
    --mht-package-text-muted: #666666;
    --mht-package-bg-light: #f8f8fc;
    --mht-package-bg-white: #ffffff;
    --mht-package-border: rgba(0, 0, 0, 0.05);
    --mht-package-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-package-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-package-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-package-radius: 20px;
    --bg-light: #F9F9F9; /* Untuk konsistensi dengan halaman lain */
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

/* ===== CUSTOM SCROLLBAR - SAMA PERSIS DENGAN HALAMAN LAIN ===== */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: var(--bg-light);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--mht-package-primary), var(--mht-package-primary-dark));
    border-radius: 6px;
    border: 3px solid var(--bg-light);
    transition: var(--mht-package-transition);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--mht-package-primary-dark);
}

/* Firefox scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--mht-package-primary) var(--bg-light);
}

/* Main Section */
.mht-package-detail-section {
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
.mht-package-detail-bg-pattern {
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
.mht-package-detail-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Back Button */
.mht-package-detail-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: var(--mht-package-bg-white);
    color: var(--mht-package-primary);
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 30px;
    border: 1px solid var(--mht-package-border);
    transition: var(--mht-package-transition);
}

.mht-package-detail-back:hover {
    background: var(--mht-package-primary-light);
    transform: translateX(-5px);
}

/* Main Wrapper */
.mht-package-detail-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
    width: 100%;
}

/* Main Content */
.mht-package-detail-main {
    background: var(--mht-package-bg-white);
    border-radius: var(--mht-package-radius);
    padding: 35px;
    box-shadow: var(--mht-package-shadow-sm);
    border: 1px solid var(--mht-package-border);
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px);
    animation: mhtPackageDetailSlideIn 0.5s ease 0.1s forwards;
}

.mht-package-detail-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--mht-package-primary), var(--mht-package-primary-dark));
}

/* Header */
.mht-package-detail-header {
    margin-bottom: 25px;
}

.mht-package-detail-badge {
    display: inline-block;
    background: var(--mht-package-primary-light);
    color: var(--mht-package-primary);
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.mht-package-detail-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--mht-package-text-dark);
    line-height: 1.3;
}

/* Price Card */
.mht-package-detail-price-card {
    background: linear-gradient(135deg, var(--mht-package-primary-light), rgba(156, 39, 176, 0.05));
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    border: 1px solid rgba(156, 39, 176, 0.1);
}

.mht-package-detail-price-wrapper {
    margin-bottom: 20px;
}

.mht-package-detail-price-label {
    font-size: 0.9rem;
    color: var(--mht-package-text-muted);
    margin-bottom: 5px;
}

.mht-package-detail-price-amount {
    display: flex;
    align-items: baseline;
    gap: 5px;
    margin-bottom: 5px;
}

.mht-package-detail-price-currency {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--mht-package-text-muted);
}

.mht-package-detail-price-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--mht-package-primary);
    line-height: 1;
}

.mht-package-detail-price-note {
    font-size: 0.8rem;
    color: var(--mht-package-text-muted);
    font-style: italic;
}

.mht-package-detail-price-total {
    padding-top: 20px;
    border-top: 1px dashed rgba(156, 39, 176, 0.3);
}

.mht-package-detail-total-label {
    font-size: 0.95rem;
    color: var(--mht-package-text-body);
    margin-bottom: 5px;
}

.mht-package-detail-total-amount {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--mht-package-primary-dark);
}

/* Subtitle */
.mht-package-detail-subtitle {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--mht-package-text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.mht-package-detail-subtitle i {
    color: var(--mht-package-primary);
    font-size: 1.2rem;
}

/* Features */
.mht-package-detail-features {
    margin-bottom: 35px;
}

.mht-package-detail-features-list {
    list-style: none;
}

.mht-package-detail-features-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed var(--mht-package-border);
    color: var(--mht-package-text-body);
    font-size: 0.95rem;
    line-height: 1.6;
}

.mht-package-detail-features-list li:last-child {
    border-bottom: none;
}

.mht-package-detail-feature-icon {
    color: var(--mht-package-primary);
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
}

/* Gallery */
.mht-package-detail-gallery {
    margin-bottom: 35px;
}

.mht-package-detail-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.mht-package-detail-gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 16/9;
    cursor: pointer;
}

.mht-package-detail-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.mht-package-detail-gallery-item:hover img {
    transform: scale(1.1);
}

.mht-package-detail-gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(156, 39, 176, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(2px);
}

.mht-package-detail-gallery-item:hover .mht-package-detail-gallery-overlay {
    opacity: 1;
}

.mht-package-detail-gallery-overlay i {
    color: white;
    font-size: 1.5rem;
    background: rgba(0, 0, 0, 0.3);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Action Buttons */
.mht-package-detail-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.mht-package-detail-btn-preview,
.mht-package-detail-btn-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 24px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--mht-package-transition);
    flex: 1;
    min-width: 200px;
    position: relative;
    overflow: hidden;
}

.mht-package-detail-btn-preview {
    background: var(--mht-package-primary-light);
    color: var(--mht-package-primary-dark);
    border: 1px solid rgba(156, 39, 176, 0.2);
}

.mht-package-detail-btn-preview:hover {
    background: var(--mht-package-primary);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.3);
}

.mht-package-detail-btn-wa {
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: white;
}

.mht-package-detail-btn-wa:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
}

/* Sidebar */
.mht-package-detail-sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
    opacity: 0;
    transform: translateY(20px);
    animation: mhtPackageDetailSlideIn 0.5s ease 0.2s forwards;
}

/* Payment Methods */
.mht-package-detail-payment {
    background: var(--mht-package-bg-white);
    border-radius: var(--mht-package-radius);
    padding: 25px;
    box-shadow: var(--mht-package-shadow-sm);
    border: 1px solid var(--mht-package-border);
}

.mht-package-detail-payment-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--mht-package-text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-package-detail-payment-title i {
    color: var(--mht-package-primary);
}

.mht-package-detail-payment-group {
    margin-bottom: 20px;
}

.mht-package-detail-payment-group:last-child {
    margin-bottom: 0;
}

.mht-package-detail-payment-group-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--mht-package-text-muted);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.mht-package-detail-payment-group-title i {
    color: var(--mht-package-primary);
    font-size: 0.9rem;
}

.mht-package-detail-payment-items {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.mht-package-detail-payment-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px;
    background: var(--mht-package-bg-light);
    border-radius: 10px;
    font-size: 0.85rem;
    color: var(--mht-package-text-body);
    border: 1px solid var(--mht-package-border);
    transition: var(--mht-package-transition);
}

.mht-package-detail-payment-item:hover {
    background: var(--mht-package-primary-light);
    transform: translateY(-2px);
}

.mht-package-detail-payment-logo {
    width: 20px;
    height: 20px;
    object-fit: contain;
}

.mht-package-detail-payment-note {
    margin-top: 20px;
    padding: 15px;
    background: var(--mht-package-primary-light);
    border-radius: 12px;
    display: flex;
    gap: 12px;
    font-size: 0.9rem;
    color: var(--mht-package-text-body);
    border-left: 3px solid var(--mht-package-primary);
}

.mht-package-detail-payment-note i {
    color: var(--mht-package-primary);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.mht-package-detail-payment-security {
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 500;
}

.mht-package-detail-payment-security i {
    color: #2e7d32;
}

/* Contact Info */
.mht-package-detail-contact {
    background: linear-gradient(135deg, var(--mht-package-primary), var(--mht-package-primary-dark));
    border-radius: var(--mht-package-radius);
    padding: 25px;
    color: white;
}

.mht-package-detail-contact-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-package-detail-contact-text {
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 20px;
    opacity: 0.9;
}

.mht-package-detail-contact-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    transition: var(--mht-package-transition);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.mht-package-detail-contact-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
}

/* Animations */
@keyframes mhtPackageDetailSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .mht-package-detail-wrapper {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-package-detail-section {
        padding: 20px 0 60px 0;
    }
    
    .mht-package-detail-main {
        padding: 25px;
    }
    
    .mht-package-detail-title {
        font-size: 1.8rem;
    }
    
    .mht-package-detail-price-number {
        font-size: 2rem;
    }
    
    .mht-package-detail-total-amount {
        font-size: 1.5rem;
    }
    
    .mht-package-detail-actions {
        flex-direction: column;
    }
    
    .mht-package-detail-btn-preview,
    .mht-package-detail-btn-wa {
        width: 100%;
    }
    
    .mht-package-detail-payment-items {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .mht-package-detail-section {
        padding: 15px 0 50px 0;
    }
    
    .mht-package-detail-main {
        padding: 20px;
    }
    
    .mht-package-detail-title {
        font-size: 1.5rem;
    }
    
    .mht-package-detail-price-number {
        font-size: 1.8rem;
    }
    
    .mht-package-detail-gallery-grid {
        grid-template-columns: 1fr;
    }
}

/* Smooth scrolling untuk anchor links */
html {
    scroll-padding-top: 80px;
}
</style>

<script>
// Font Awesome fallback check
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

<!-- Fallback untuk browser tanpa JavaScript -->
<noscript>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>