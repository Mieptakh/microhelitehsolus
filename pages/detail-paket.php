<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php'; // sesuaikan path sesuai struktur kamu

if (!isset($_GET['slug'])) {
    // Redirect ke halaman paket jika slug tidak ditemukan
    header('Location: paket-kami');
    exit;
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE slug = ?");
    $stmt->execute([$slug]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        // Redirect ke halaman paket jika paket tidak tersedia
        header('Location: paket-kami');
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
        <a href="paket-kami" class="mht-package-detail-back">
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
                        <?php foreach ($screenshots as $index => $img): 
                            $img = trim($img);
                            if (!empty($img)):
                        ?>
                            <div class="mht-package-detail-gallery-item" data-index="<?php echo $index; ?>">
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

            <!-- Sidebar - Payment Methods dengan Logo Lokal (Tanpa Teks) -->
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
                                <div class="mht-package-detail-payment-item" title="SeaBank">
                                    <img src="/uploads/seabank-logo.png" 
                                         alt="SeaBank" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/5/5c/SeaBank_Indonesia_logo.svg';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="Bank Jago">
                                    <img src="/uploads/jago-logo.png" 
                                         alt="Bank Jago" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/1/14/Bank_Jago_logo.svg';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="BCA">
                                    <img src="/uploads/bca-logo.png" 
                                         alt="BCA" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia_logo.svg';">
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
                                <div class="mht-package-detail-payment-item" title="OVO">
                                    <img src="/uploads/ovo-logo.png" 
                                         alt="OVO" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/c/c4/OVO_logo.svg';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="DANA">
                                    <img src="/uploads/dana-logo.png" 
                                         alt="DANA" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/7/72/DANA_logo.svg';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="GoPay">
                                    <img src="/uploads/gopay-logo.png" 
                                         alt="GoPay" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/0/00/Logo_Gopay.svg';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="ShopeePay">
                                    <img src="/uploads/shopeepay-logo.png" 
                                         alt="ShopeePay" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/5/51/ShopeePay_logo.svg';">
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
                                <div class="mht-package-detail-payment-item" title="QRIS">
                                    <img src="/uploads/qris-logo.png" 
                                         alt="QRIS" 
                                         class="mht-package-detail-payment-logo"
                                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/QRIS_logo.svg/1200px-QRIS_logo.svg.png';">
                                </div>
                                <div class="mht-package-detail-payment-item" title="Cash (Offline)">
                                    <!-- Cash tetap pakai icon -->
                                    <i class="fas fa-money-bill-wave"></i>
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

<!-- IMAGE MODAL - Enhanced Version -->
<div id="mht-image-modal" class="mht-image-modal">
    <div class="mht-modal-overlay"></div>
    <div class="mht-modal-container">
        <button class="mht-modal-close" id="mht-modal-close">
            <i class="fas fa-times"></i>
        </button>
        
        <button class="mht-modal-nav mht-modal-prev" id="mht-modal-prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <button class="mht-modal-nav mht-modal-next" id="mht-modal-next">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <div class="mht-modal-content">
            <img src="" alt="Full Screen Screenshot" id="mht-modal-image">
            
            <div class="mht-modal-caption" id="mht-modal-caption">
                <div class="mht-modal-title"></div>
                <div class="mht-modal-counter"></div>
            </div>
            
            <div class="mht-modal-loader" id="mht-modal-loader">
                <div class="mht-loader-spinner"></div>
            </div>
        </div>
        
        <div class="mht-modal-thumbnails" id="mht-modal-thumbnails"></div>
    </div>
</div>

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
    --bg-light: #F9F9F9;
    --mht-modal-overlay: rgba(0, 0, 0, 0.95);
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

/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden;
}

/* ===== CUSTOM SCROLLBAR ===== */
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mht-package-detail-gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.2);
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

/* Payment Methods - Enhanced dengan Logo (Tanpa Teks) */
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
    justify-content: center;
    padding: 12px;
    background: var(--mht-package-bg-light);
    border-radius: 12px;
    border: 1px solid var(--mht-package-border);
    transition: var(--mht-package-transition);
    min-height: 60px;
    cursor: default;
}

.mht-package-detail-payment-item:hover {
    background: var(--mht-package-primary-light);
    transform: translateY(-2px);
    border-color: var(--mht-package-primary);
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.1);
}

.mht-package-detail-payment-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: 8px;
    background: white;
    padding: 4px;
}

.mht-package-detail-payment-item i {
    font-size: 2rem;
    color: var(--mht-package-primary);
}

/* Style khusus untuk icon cash */
.mht-package-detail-payment-item .fa-money-bill-wave {
    color: #2e7d32;
    font-size: 2rem;
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
    padding: 12px;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 30px;
    font-size: 0.9rem;
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

/* Tooltip untuk nama metode pembayaran */
.mht-package-detail-payment-item {
    position: relative;
}

.mht-package-detail-payment-item:hover::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 5px 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    font-size: 0.75rem;
    border-radius: 4px;
    white-space: nowrap;
    pointer-events: none;
    margin-bottom: 5px;
    z-index: 10;
}

/* ===== IMAGE MODAL STYLES - Enhanced ===== */
.mht-image-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    font-family: 'Poppins', sans-serif;
}

.mht-image-modal.active {
    display: block;
}

.mht-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--mht-modal-overlay);
    backdrop-filter: blur(10px);
    animation: mhtModalFadeIn 0.3s ease;
}

.mht-modal-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.mht-modal-close {
    position: absolute;
    top: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
    backdrop-filter: blur(5px);
}

.mht-modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
    border-color: rgba(255, 255, 255, 0.4);
}

.mht-modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 1.8rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
    backdrop-filter: blur(5px);
}

.mht-modal-nav:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.mht-modal-prev {
    left: 30px;
}

.mht-modal-prev:hover {
    transform: translateY(-50%) translateX(-5px);
}

.mht-modal-next {
    right: 30px;
}

.mht-modal-next:hover {
    transform: translateY(-50%) translateX(5px);
}

.mht-modal-content {
    position: relative;
    max-width: 90%;
    max-height: 80vh;
    margin: 0 auto;
    text-align: center;
}

#mht-modal-image {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    opacity: 0;
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.mht-image-modal.active #mht-modal-image {
    opacity: 1;
    transform: scale(1);
}

.mht-modal-caption {
    margin-top: 20px;
    color: white;
    text-align: center;
}

.mht-modal-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.mht-modal-counter {
    font-size: 0.9rem;
    opacity: 0.7;
}

.mht-modal-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
}

.mht-modal-loader.active {
    display: block;
}

.mht-loader-spinner {
    width: 50px;
    height: 50px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--mht-package-primary);
    animation: mhtModalSpin 1s ease-in-out infinite;
}

.mht-modal-thumbnails {
    position: absolute;
    bottom: 30px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 20px;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--mht-package-primary) rgba(255, 255, 255, 0.1);
}

.mht-modal-thumbnails::-webkit-scrollbar {
    height: 4px;
}

.mht-modal-thumbnails::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.mht-modal-thumbnails::-webkit-scrollbar-thumb {
    background: var(--mht-package-primary);
    border-radius: 4px;
}

.mht-modal-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.mht-modal-thumb.active {
    opacity: 1;
    border-color: var(--mht-package-primary);
    transform: scale(1.1);
}

.mht-modal-thumb:hover {
    opacity: 1;
}

.mht-modal-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Animations */
@keyframes mhtPackageDetailSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes mhtModalFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes mhtModalSpin {
    to {
        transform: rotate(360deg);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .mht-package-detail-wrapper {
        grid-template-columns: 1fr;
    }
    
    .mht-modal-nav {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
    
    .mht-modal-prev {
        left: 15px;
    }
    
    .mht-modal-next {
        right: 15px;
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
        grid-template-columns: repeat(2, 1fr);
    }
    
    .mht-package-detail-payment-logo {
        width: 35px;
        height: 35px;
    }
    
    .mht-package-detail-payment-item i {
        font-size: 1.8rem;
    }
    
    .mht-modal-container {
        padding: 20px;
    }
    
    .mht-modal-close {
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .mht-modal-thumb {
        width: 50px;
        height: 50px;
    }
    
    .mht-modal-thumbnails {
        padding: 15px;
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
    
    .mht-package-detail-payment-items {
        grid-template-columns: 1fr;
    }
    
    .mht-package-detail-payment-logo {
        width: 40px;
        height: 40px;
    }
    
    .mht-modal-nav {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .mht-modal-thumb {
        width: 40px;
        height: 40px;
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
    
    // Initialize Image Modal
    initImageModal();
});

// Image Modal Functionality
function initImageModal() {
    const modal = document.getElementById('mht-image-modal');
    const modalImage = document.getElementById('mht-modal-image');
    const modalTitle = document.querySelector('.mht-modal-title');
    const modalCounter = document.querySelector('.mht-modal-counter');
    const closeBtn = document.getElementById('mht-modal-close');
    const prevBtn = document.getElementById('mht-modal-prev');
    const nextBtn = document.getElementById('mht-modal-next');
    const loader = document.getElementById('mht-modal-loader');
    const thumbnailsContainer = document.getElementById('mht-modal-thumbnails');
    
    const galleryItems = document.querySelectorAll('.mht-package-detail-gallery-item');
    let currentIndex = 0;
    let images = [];
    
    // Collect all images from gallery
    galleryItems.forEach((item, index) => {
        const img = item.querySelector('img');
        if (img) {
            images.push({
                src: img.src,
                alt: img.alt,
                index: index
            });
        }
        
        // Add click event to gallery items
        item.addEventListener('click', function(e) {
            e.preventDefault();
            currentIndex = parseInt(this.dataset.index) || index;
            openModal(currentIndex);
        });
    });
    
    // Open modal
    function openModal(index) {
        currentIndex = index;
        updateModalImage();
        updateThumbnails();
        modal.classList.add('active');
        document.body.classList.add('modal-open');
        
        // Add keyboard event listeners
        document.addEventListener('keydown', handleKeyDown);
    }
    
    // Close modal
    function closeModal() {
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
        document.removeEventListener('keydown', handleKeyDown);
    }
    
    // Update modal image
    function updateModalImage() {
        if (images.length === 0) return;
        
        const image = images[currentIndex];
        
        // Show loader
        loader.classList.add('active');
        
        // Preload image
        const img = new Image();
        img.onload = function() {
            modalImage.src = image.src;
            modalImage.alt = image.alt;
            modalTitle.textContent = image.alt || 'Screenshot';
            modalCounter.textContent = `${currentIndex + 1} / ${images.length}`;
            loader.classList.remove('active');
            
            // Update active thumbnail
            document.querySelectorAll('.mht-modal-thumb').forEach((thumb, i) => {
                if (i === currentIndex) {
                    thumb.classList.add('active');
                    // Scroll thumbnail into view
                    thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    thumb.classList.remove('active');
                }
            });
        };
        img.src = image.src;
    }
    
    // Update thumbnails
    function updateThumbnails() {
        let html = '';
        images.forEach((image, index) => {
            html += `
                <div class="mht-modal-thumb ${index === currentIndex ? 'active' : ''}" data-thumb-index="${index}">
                    <img src="${image.src}" alt="${image.alt}" loading="lazy">
                </div>
            `;
        });
        
        thumbnailsContainer.innerHTML = html;
        
        // Add click events to thumbnails
        document.querySelectorAll('.mht-modal-thumb').forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.dataset.thumbIndex);
                if (!isNaN(index)) {
                    currentIndex = index;
                    updateModalImage();
                }
            });
        });
    }
    
    // Navigate to previous image
    function prevImage() {
        if (images.length === 0) return;
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateModalImage();
    }
    
    // Navigate to next image
    function nextImage() {
        if (images.length === 0) return;
        currentIndex = (currentIndex + 1) % images.length;
        updateModalImage();
    }
    
    // Handle keyboard events
    function handleKeyDown(e) {
        switch(e.key) {
            case 'Escape':
                closeModal();
                break;
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    }
    
    // Event listeners
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (prevBtn) prevBtn.addEventListener('click', prevImage);
    if (nextBtn) nextBtn.addEventListener('click', nextImage);
    
    // Close modal when clicking overlay
    if (modal) {
        modal.querySelector('.mht-modal-overlay').addEventListener('click', closeModal);
    }
    
    // Prevent click on modal container from closing
    const modalContainer = document.querySelector('.mht-modal-container');
    if (modalContainer) {
        modalContainer.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Touch events for mobile swipe
    let touchStartX = 0;
    let touchEndX = 0;
    
    modalContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    modalContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchEndX - touchStartX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe right
                prevImage();
            } else {
                // Swipe left
                nextImage();
            }
        }
    }
}
</script>

<!-- Fallback untuk browser tanpa JavaScript -->
<noscript>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>