<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php';

$success_message = '';
$error_message = '';

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kontak = trim($_POST['kontak'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');
    
    // Validasi
    if (empty($nama) || empty($kontak) || empty($pesan)) {
        $error_message = 'Semua field harus diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO kontak (nama, kontak, pesan) VALUES (?, ?, ?)");
            $stmt->execute([$nama, $kontak, $pesan]);
            $success_message = 'Terima kasih telah menghubungi PT Micro Helix Tech Solutions. Tim kami akan segera merespons pesan Anda.';
        } catch (PDOException $e) {
            $error_message = 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi kami langsung via WhatsApp.';
        }
    }
}
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<!-- Google Fonts Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* ===== MHT CONTACT STYLES - SAMA PERSIS DENGAN JADWAL TEMU ===== */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #9C27B0;
        --primary-dark: #7B1FA2;
        --primary-light: rgba(156, 39, 176, 0.1);
        --bg-light: #F9F9F9;
        --text-dark: #121212;
        --text-body: #333333;
        --text-muted: #666666;
        --border-color: rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 15px 35px rgba(156, 39, 176, 0.15);
        --radius-md: 8px;
        --radius-lg: 16px;
        --radius-full: 9999px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
        font-family: 'Poppins', sans-serif;
        scroll-behavior: smooth;
        background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    }

    body {
        color: var(--text-body);
        line-height: 1.6;
        min-height: 100vh;
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
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 6px;
        border: 3px solid var(--bg-light);
        transition: var(--transition);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-dark);
    }

    /* Firefox scrollbar */
    * {
        scrollbar-width: thin;
        scrollbar-color: var(--primary) var(--bg-light);
    }

    /* ===== MAIN CONTAINER ===== */
    .mht-contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px 60px;
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER SECTION ===== */
    .mht-contact-header {
        text-align: center;
        margin-bottom: 40px;
        animation: mhtFadeIn 1s ease;
    }

    .mht-contact-header h1 {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        margin-bottom: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .mht-contact-header h1 i {
        color: var(--primary);
        font-size: 2rem;
    }

    .mht-contact-header p {
        font-size: 1.1rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    .mht-contact-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary-light);
        color: var(--primary);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        margin-top: 15px;
        border: 1px solid rgba(156, 39, 176, 0.2);
        flex-wrap: wrap;
        justify-content: center;
    }

    .mht-contact-badge i {
        color: var(--primary);
    }

    .mht-contact-badge span {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    /* ===== CONTACT WRAPPER ===== */
    .mht-contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    /* ===== CONTACT INFO CARDS ===== */
    .mht-contact-info {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .mht-info-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(156, 39, 176, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        animation: mhtSlideUp 0.6s ease-out;
        animation-fill-mode: both;
    }

    .mht-info-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .mht-info-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .mht-info-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .mht-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .mht-info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .mht-info-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .mht-info-icon i {
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .mht-info-card h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .mht-info-card p {
        color: var(--text-body);
        margin-bottom: 5px;
        font-size: 1rem;
        line-height: 1.6;
    }

    .mht-info-highlight {
        font-size: 1.1rem !important;
        color: var(--primary) !important;
        font-weight: 600 !important;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .mht-info-highlight i {
        color: var(--primary);
        font-size: 1rem;
    }

    .mht-info-social {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mht-social-link {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.1rem;
    }

    .mht-social-link:hover {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    /* Office Hours Card */
    .mht-hours-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(156,39,176,0.05));
    }

    .mht-hours-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed rgba(156, 39, 176, 0.2);
    }

    .mht-hours-item:last-child {
        border-bottom: none;
    }

    .mht-hours-day {
        font-weight: 600;
        color: var(--text-dark);
    }

    .mht-hours-time {
        color: var(--primary);
        font-weight: 500;
    }

    .mht-hours-note {
        margin-top: 15px;
        padding: 10px;
        background: var(--primary-light);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        color: var(--text-body);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mht-hours-note i {
        color: var(--primary);
    }

    /* ===== CONTACT FORM ===== */
    .mht-contact-form-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(156, 39, 176, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        animation: mhtSlideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .mht-contact-form-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .mht-contact-form-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .mht-form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .mht-form-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .mht-form-header p {
        color: var(--text-muted);
    }

    /* Alert Messages */
    .mht-alert {
        padding: 16px 20px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: mhtSlideIn 0.3s ease;
    }

    .mht-alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid #2e7d32;
    }

    .mht-alert-success i {
        color: #2e7d32;
        font-size: 1.3rem;
    }

    .mht-alert-error {
        background: #ffebee;
        color: #c62828;
        border-left: 4px solid #c62828;
    }

    .mht-alert-error i {
        color: #c62828;
        font-size: 1.3rem;
    }

    /* Form Groups */
    .mht-form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .mht-form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .mht-form-group label i {
        color: var(--primary);
        width: 18px;
        text-align: center;
    }

    .mht-required {
        color: #E53E3E;
        margin-left: 4px;
    }

    .mht-form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 15px;
        transition: var(--transition);
        background: #fff;
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
    }

    .mht-form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        transform: translateY(-1px);
    }

    .mht-form-control:hover {
        border-color: #CBD5E0;
    }

    textarea.mht-form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Character Count */
    .mht-char-count {
        text-align: right;
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 5px;
    }

    .mht-char-count span {
        color: var(--primary);
        font-weight: 600;
    }

    /* Submit Button */
    .mht-btn-primary {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: var(--radius-md);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3);
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .mht-btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .mht-btn-primary:hover::before {
        left: 100%;
    }

    .mht-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(156, 39, 176, 0.4);
    }

    .mht-btn-primary:active {
        transform: translateY(0);
    }

    .mht-btn-primary.mht-loading {
        position: relative;
        color: transparent;
        pointer-events: none;
    }

    .mht-btn-primary.mht-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: mht-spin 1s linear infinite;
    }

    @keyframes mht-spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Form Footer */
    .mht-form-footer {
        margin-top: 20px;
        text-align: center;
        font-size: 0.9rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .mht-form-footer i {
        color: var(--primary);
    }

    /* Company Stats Bar */
    .mht-company-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 30px;
        animation: mhtSlideUp 0.6s ease-out 0.3s forwards;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .mht-stat-item {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 25px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(156, 39, 176, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .mht-stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
    }

    .mht-stat-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .mht-stat-item i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 15px;
    }

    .mht-stat-item h4 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .mht-stat-item p {
        color: var(--text-muted);
        font-size: 1rem;
        font-weight: 500;
    }

    /* Divider */
    .mht-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--primary), transparent);
        margin: 40px 0 20px;
    }

    /* Footer Info */
    .mht-footer-info {
        text-align: center;
        margin-top: 40px;
        color: var(--text-muted);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        animation: mhtFadeIn 1s ease 0.4s forwards;
        opacity: 0;
        animation-fill-mode: forwards;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .mht-footer-info i {
        color: var(--primary);
    }

    /* Animations */
    @keyframes mhtFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes mhtSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes mhtSlideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .mht-contact-wrapper {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .mht-company-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
    }

    @media (max-width: 768px) {
        ::-webkit-scrollbar {
            width: 8px;
        }

        .mht-contact-container {
            padding: 20px 15px 40px;
        }

        .mht-contact-form-wrapper {
            padding: 25px 20px;
        }

        .mht-contact-header h1 {
            font-size: 2rem;
        }

        .mht-info-card {
            padding: 25px;
        }

        .mht-company-stats {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .mht-stat-item h4 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .mht-contact-form-wrapper {
            padding: 20px 15px;
        }

        .mht-btn-primary {
            padding: 14px 20px;
            font-size: 0.95rem;
        }

        .mht-contact-header h1 {
            font-size: 1.8rem;
        }

        .mht-contact-header h1 i {
            font-size: 1.6rem;
        }

        .mht-hours-item {
            flex-direction: column;
            gap: 5px;
        }

        .mht-stat-item {
            padding: 20px;
        }

        .mht-stat-item h4 {
            font-size: 1.6rem;
        }
    }

    /* Print styles */
    @media print {
        .mht-contact-form-wrapper,
        .mht-btn-primary,
        .mht-social-link {
            display: none;
        }
    }
</style>

<!-- MAIN CONTENT -->
<div class="mht-contact-container">
    <!-- Header Section -->
    <div class="mht-contact-header">
        <h1><i class="fas fa-headset"></i> Hubungi Kami</h1>
        <p>PT Micro Helix Tech Solutions - Solusi Teknologi Terpercaya</p>
        <div class="mht-contact-badge">
            <i class="fas fa-phone-alt"></i>
            <span>+62 21 5082 8888 | +62 851-8324-1229</span>
        </div>
    </div>

    <!-- Contact Wrapper -->
    <div class="mht-contact-wrapper">
        <!-- Left Column - Contact Info -->
        <div class="mht-contact-info">
            <!-- Alamat Card -->
            <div class="mht-info-card" id="mht-alamat-card">
                <div class="mht-info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Kantor Pusat</h3>
                <p>Menara BTPN, Lantai 28</p>
                <p>Jl. Dr. Ide Anak Agung Gde Agung Kav. 5.5-5.6</p>
                <p>Kuningan Timur, Setiabudi, Jakarta Selatan 12950</p>
                <div class="mht-info-social">
                    <a href="#" class="mht-social-link" target="_blank" id="mht-location-link">
                        <i class="fas fa-location-dot"></i>
                    </a>
                    <a href="#" class="mht-social-link" target="_blank" id="mht-directions-link">
                        <i class="fas fa-directions"></i>
                    </a>
                </div>
            </div>
            
            <!-- Kontak Card -->
            <div class="mht-info-card" id="mht-kontak-card">
                <div class="mht-info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Kontak Langsung</h3>
                <div class="mht-info-highlight" id="mht-phone">
                    <i class="fas fa-phone"></i>
                    +62 21 5082 8888
                </div>
                <div class="mht-info-highlight" id="mht-email">
                    <i class="fas fa-envelope"></i>
                    info@microhelix.co.id
                </div>
                <div class="mht-info-highlight" id="mht-wa">
                    <i class="fab fa-whatsapp"></i>
                    +62 851-8324-1229
                </div>
                <div class="mht-info-social" id="mht-social-links">
                    <a href="https://wa.me/6285183241229" class="mht-social-link" target="_blank" id="mht-wa-link">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:info@microhelix.co.id" class="mht-social-link" id="mht-email-link">
                        <i class="far fa-envelope"></i>
                    </a>
                    <a href="tel:+622150828888" class="mht-social-link" id="mht-phone-link">
                        <i class="fas fa-phone"></i>
                    </a>
                    <a href="#" class="mht-social-link" target="_blank" id="mht-linkedin-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            
            <!-- Jam Operasional Card -->
            <div class="mht-info-card mht-hours-card" id="mht-hours-card">
                <div class="mht-info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Jam Operasional</h3>
                <div class="mht-hours-item" id="mht-hours-weekday">
                    <span class="mht-hours-day">Senin - Jumat</span>
                    <span class="mht-hours-time">09:00 - 18:00 WIB</span>
                </div>
                <div class="mht-hours-item" id="mht-hours-saturday">
                    <span class="mht-hours-day">Sabtu</span>
                    <span class="mht-hours-time">09:00 - 14:00 WIB</span>
                </div>
                <div class="mht-hours-item" id="mht-hours-sunday">
                    <span class="mht-hours-day">Minggu & Libur</span>
                    <span class="mht-hours-time">Tutup</span>
                </div>
                <div class="mht-hours-note" id="mht-hours-note">
                    <i class="fas fa-headset"></i>
                    Layanan Technical Support 24/7 via WhatsApp
                </div>
            </div>
        </div>
        
        <!-- Right Column - Contact Form -->
        <div class="mht-contact-form-wrapper" id="mht-contact-form">
            <div class="mht-form-header">
                <h2>Kirim Pesan</h2>
                <p>Isi form di bawah untuk konsultasi atau pertanyaan</p>
            </div>
            
            <!-- Alert Messages -->
            <?php if ($success_message): ?>
                <div class="mht-alert mht-alert-success" id="mht-success-alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="mht-alert mht-alert-error" id="mht-error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <!-- Contact Form -->
            <form id="mht-contact-form" method="POST" action="">
                <div class="mht-form-group" id="mht-form-group-nama">
                    <label for="mht-nama">
                        <i class="fas fa-user"></i>
                        Nama Lengkap <span class="mht-required">*</span>
                    </label>
                    <input type="text" 
                           class="mht-form-control" 
                           name="nama" 
                           id="mht-nama"
                           placeholder="Masukkan nama lengkap Anda"
                           value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                           required
                           autocomplete="name">
                </div>
                
                <div class="mht-form-group" id="mht-form-group-kontak">
                    <label for="mht-kontak">
                        <i class="fas fa-address-book"></i>
                        Email / No. HP <span class="mht-required">*</span>
                    </label>
                    <input type="text" 
                           class="mht-form-control" 
                           name="kontak" 
                           id="mht-kontak"
                           placeholder="contoh@email.com / 081234567890"
                           value="<?php echo isset($_POST['kontak']) ? htmlspecialchars($_POST['kontak']) : ''; ?>"
                           required
                           autocomplete="off">
                </div>
                
                <div class="mht-form-group" id="mht-form-group-pesan">
                    <label for="mht-pesan">
                        <i class="fas fa-comment-dots"></i>
                        Pesan <span class="mht-required">*</span>
                    </label>
                    <textarea class="mht-form-control" 
                              name="pesan" 
                              id="mht-pesan"
                              placeholder="Jelaskan kebutuhan atau pertanyaan Anda..."
                              maxlength="500"
                              required><?php echo isset($_POST['pesan']) ? htmlspecialchars($_POST['pesan']) : ''; ?></textarea>
                    <div class="mht-char-count" id="mht-char-counter">
                        <span id="mht-char-count">0</span>/500 karakter
                    </div>
                </div>
                
                <button type="submit" class="mht-btn-primary" id="mht-submit-btn">
                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                </button>
                
                <div class="mht-form-footer" id="mht-form-footer">
                    <i class="fas fa-shield-alt"></i>
                    Data Anda aman dan terenkripsi
                </div>
            </form>
        </div>
    </div>
    
    <!-- Company Stats - Updated dengan data baru -->
    <div class="mht-company-stats" id="mht-company-stats">
        <div class="mht-stat-item" id="mht-stat-tahun">
            <i class="fas fa-calendar-alt"></i>
            <h4>1 Tahun</h4>
            <p>Pengalaman di industri teknologi</p>
        </div>
        <div class="mht-stat-item" id="mht-stat-staff">
            <i class="fas fa-users"></i>
            <h4>3 Staff</h4>
            <p>Tenaga ahli profesional</p>
        </div>
        <div class="mht-stat-item" id="mht-stat-proyek">
            <i class="fas fa-project-diagram"></i>
            <h4>30 Proyek</h4>
            <p>Telah diselesaikan dengan sukses</p>
        </div>
    </div>
    
    <!-- Divider -->
    <div class="mht-divider" id="mht-divider"></div>
    
    <!-- Footer Info -->
    <div class="mht-footer-info" id="mht-footer-info">
        <i class="fas fa-shield-alt"></i>
        <span>PT Micro Helix Tech Solutions © 2024 - All Rights Reserved</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== ELEMENT SELECTIONS =====
    const form = document.getElementById('mht-contact-form');
    const submitBtn = document.getElementById('mht-submit-btn');
    const textarea = document.getElementById('mht-pesan');
    const charCount = document.getElementById('mht-char-count');
    const namaInput = document.getElementById('mht-nama');
    const kontakInput = document.getElementById('mht-kontak');
    
    // ===== CHARACTER COUNTER =====
    if (textarea && charCount) {
        function updateCharCount() {
            const count = textarea.value.length;
            charCount.textContent = count;
            
            // Change color based on remaining characters
            if (count > 450) {
                charCount.style.color = '#E53E3E';
                charCount.style.fontWeight = '700';
            } else if (count > 400) {
                charCount.style.color = '#DD6B20';
                charCount.style.fontWeight = '600';
            } else {
                charCount.style.color = '#9C27B0';
                charCount.style.fontWeight = '600';
            }
        }
        
        textarea.addEventListener('input', updateCharCount);
        
        // Trigger initial count
        updateCharCount();
    }
    
    // ===== FORM SUBMISSION LOADING STATE =====
    if (form) {
        form.addEventListener('submit', function(e) {
            // Client-side validation
            const nama = namaInput.value.trim();
            const kontak = kontakInput.value.trim();
            const pesan = textarea.value.trim();
            
            if (!nama || !kontak || !pesan) {
                e.preventDefault();
                showCustomAlert('Semua field harus diisi!', 'error');
                return false;
            }
            
            // Add loading state
            submitBtn.classList.add('mht-loading');
            submitBtn.disabled = true;
        });
    }
    
    // ===== CUSTOM ALERT FUNCTION =====
    function showCustomAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `mht-alert mht-alert-${type}`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
        `;
        
        const formWrapper = document.querySelector('.mht-contact-form-wrapper');
        const formHeader = document.querySelector('.mht-form-header');
        
        formWrapper.insertBefore(alertDiv, formHeader.nextSibling);
        
        setTimeout(() => {
            alertDiv.style.transition = 'opacity 0.5s ease';
            alertDiv.style.opacity = '0';
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 500);
        }, 5000);
    }
    
    // ===== AUTO-FORMAT & VALIDATION FOR CONTACT FIELD =====
    if (kontakInput) {
        kontakInput.addEventListener('input', function() {
            this.style.borderColor = '';
        });
        
        kontakInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value) {
                const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                const isPhone = /^[0-9+\-\s]{10,15}$/.test(value.replace(/\s/g, ''));
                
                if (!isEmail && !isPhone) {
                    this.style.borderColor = '#E53E3E';
                    this.style.backgroundColor = '#FFF5F5';
                    
                    // Show tooltip
                    const tooltip = document.createElement('div');
                    tooltip.className = 'mht-validation-tooltip';
                    tooltip.style.cssText = `
                        position: absolute;
                        bottom: -20px;
                        left: 0;
                        font-size: 12px;
                        color: #E53E3E;
                        display: flex;
                        align-items: center;
                        gap: 4px;
                    `;
                    tooltip.innerHTML = '<i class="fas fa-exclamation-circle"></i> Format email atau nomor HP tidak valid';
                    
                    const existingTooltip = this.parentNode.querySelector('.mht-validation-tooltip');
                    if (existingTooltip) {
                        existingTooltip.remove();
                    }
                    
                    this.parentNode.style.position = 'relative';
                    this.parentNode.appendChild(tooltip);
                    
                    setTimeout(() => {
                        if (tooltip.parentNode) {
                            tooltip.remove();
                        }
                    }, 3000);
                } else {
                    this.style.borderColor = '#4CAF50';
                    this.style.backgroundColor = '#F1F8E9';
                }
            } else {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            }
        });
    }
    
    // ===== AUTO-HIDE ALERTS =====
    const alerts = document.querySelectorAll('.mht-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 500);
        }, 5000);
    });
    
    // ===== SMOOTH SCROLL TO ALERTS =====
    if (alerts.length > 0) {
        alerts[0].scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    }
    
    // ===== FONT AWESOME FALLBACK CHECK =====
    function checkFontAwesome() {
        const testElement = document.createElement('span');
        testElement.className = 'fas';
        testElement.style.display = 'none';
        testElement.style.fontFamily = 'Font Awesome 6 Free';
        document.body.appendChild(testElement);
        
        const computedStyle = window.getComputedStyle(testElement);
        const fontFamily = computedStyle.getPropertyValue('font-family');
        
        if (!fontFamily.includes('Font Awesome')) {
            console.log('Font Awesome not loaded, loading fallback...');
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://use.fontawesome.com/releases/v6.0.0/css/all.css';
            document.head.appendChild(link);
        }
        
        document.body.removeChild(testElement);
    }
    
    setTimeout(checkFontAwesome, 100);
    
    // ===== INPUT FOCUS EFFECTS =====
    const inputs = document.querySelectorAll('.mht-form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('mht-focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('mht-focused');
        });
    });
    
    // ===== PREVENT DOUBLE SUBMIT =====
    let formSubmitted = false;
    if (form) {
        form.addEventListener('submit', function() {
            if (formSubmitted) {
                e.preventDefault();
                return false;
            }
            formSubmitted = true;
        });
    }
    
    // ===== RESPONSIVE ADJUSTMENTS =====
    function handleResponsive() {
        const width = window.innerWidth;
        const stats = document.getElementById('mht-company-stats');
        
        if (width <= 576) {
            if (stats) {
                stats.style.gap = '10px';
            }
        } else if (width <= 768) {
            if (stats) {
                stats.style.gap = '15px';
            }
        } else {
            if (stats) {
                stats.style.gap = '25px';
            }
        }
    }
    
    window.addEventListener('resize', handleResponsive);
    handleResponsive();
    
    // ===== ADD FOCUS STYLES =====
    const style = document.createElement('style');
    style.textContent = `
        .mht-form-group.mht-focused .mht-form-control {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
        }
        
        .mht-form-group {
            transition: all 0.3s ease;
        }
        
        .mht-validation-tooltip {
            animation: mhtSlideIn 0.3s ease;
        }
        
        @keyframes mhtSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
});

// ===== EXPOSE FUNCTIONS GLOBALLY FOR DEBUGGING =====
window.mhtContact = {
    validateForm: function() {
        const form = document.getElementById('mht-contact-form');
        if (form) {
            return form.reportValidity();
        }
        return false;
    },
    resetForm: function() {
        const form = document.getElementById('mht-contact-form');
        if (form) {
            form.reset();
            const charCount = document.getElementById('mht-char-count');
            if (charCount) {
                charCount.textContent = '0';
                charCount.style.color = '#9C27B0';
            }
        }
    }
};
</script>

<!-- Fallback untuk browser tanpa JavaScript -->
<noscript>
    <style>
        .mht-btn-primary {
            pointer-events: auto !important;
            opacity: 1 !important;
        }
        
        .mht-alert {
            display: block !important;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>