<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_uri = $_SERVER['REQUEST_URI'];
include 'includes/head.php';
include 'includes/header.php';
include __DIR__ . '/../webmaster/includes/db.php';
?>

<!-- FAQ Section - Custom dengan prefix mht-faq untuk menghindari konflik -->
<section id="mht-faq-section" class="mht-faq-section">
    <!-- Background Pattern -->
    <div class="mht-faq-bg-pattern"></div>
    
    <div class="mht-faq-container">
        <!-- Section Header -->
        <div class="mht-faq-header-wrapper">
            <span class="mht-faq-badge">INFORMASI LENGKAP</span>
            <h1 class="mht-faq-title">Frequently Asked <span>Questions</span></h1>
            <p class="mht-faq-subtitle">Pertanyaan yang sering diajukan seputar layanan dan informasi <strong>PT MicroHelix Tech Solutions</strong></p>
        </div>

        <div class="mht-faq-grid">
            <!-- Item 1: Tentang Perusahaan -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-1">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-building"></i>
                        <span>Apa itu PT MicroHelix Tech Solutions?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-1">
                    <div class="mht-faq-answer-inner">
                        <p><strong>PT MicroHelix Tech Solutions</strong> adalah perusahaan teknologi yang didirikan pada tanggal <strong>5 Januari 2026</strong> dan berfokus pada pengembangan solusi digital inovatif. Kami berkomitmen untuk membantu bisnis dan individu dalam mengembangkan serta mengelola website profesional dengan layanan yang berkualitas dan terjangkau.</p>
                        <div class="mht-faq-info-card">
                            <i class="fa-solid fa-calendar-check"></i>
                            <div>
                                <strong>Tanggal Pendirian:</strong> 5 Januari 2026<br>
                                <span class="mht-faq-text-muted">Perusahaan baru dengan perspektif fresh dan teknologi terkini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2: Lokasi Kantor -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-2">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Dimana lokasi kantor PT MicroHelix?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-2">
                    <div class="mht-faq-answer-inner">
                        <p>Kantor kami berlokasi di:</p>
                        <div class="mht-faq-address-card">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <strong>Desa Ngampelsari, Kecamatan Candi</strong><br>
                                Kabupaten Sidoarjo 61271<br>
                                Jawa Timur, Indonesia
                            </div>
                        </div>
                        <p class="mht-faq-mt-3">Kami siap melayani klien dari berbagai wilayah, baik lokal Sidoarjo, Surabaya, maupun seluruh Indonesia secara online maupun offline (dengan perjanjian).</p>
                    </div>
                </div>
            </div>

            <!-- Item 3: Layanan Utama -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-3">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-cogs"></i>
                        <span>Apa saja layanan utama yang ditawarkan?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-3">
                    <div class="mht-faq-answer-inner">
                        <p>Sebagai perusahaan teknologi yang baru berdiri, kami fokus pada layanan berikut:</p>
                        
                        <div class="mht-faq-services-wrapper">
                            <div class="mht-faq-service-block">
                                <div class="mht-faq-service-icon">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <div class="mht-faq-service-info">
                                    <h4>Pengembangan Website</h4>
                                    <p>Company profile, toko online (e-commerce), landing page, sistem informasi, dan website custom.</p>
                                </div>
                            </div>
                            
                            <div class="mht-faq-service-block">
                                <div class="mht-faq-service-icon">
                                    <i class="fa-solid fa-server"></i>
                                </div>
                                <div class="mht-faq-service-info">
                                    <h4>Maintenance Website</h4>
                                    <p>Update konten, backup data, monitoring keamanan, perbaikan bug, dan optimasi performa.</p>
                                </div>
                            </div>
                            
                            <div class="mht-faq-service-block">
                                <div class="mht-faq-service-icon">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div class="mht-faq-service-info">
                                    <h4>Domain & Hosting</h4>
                                    <p>Penyediaan domain (.com, .id, .co.id, dll) dan hosting berkualitas dengan SSL gratis.</p>
                                </div>
                            </div>
                            
                            <div class="mht-faq-service-block">
                                <div class="mht-faq-service-icon">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <div class="mht-faq-service-info">
                                    <h4>Pengelolaan Website</h4>
                                    <p>Manajemen konten, optimasi SEO, dan pelaporan performa website secara berkala.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mht-faq-note-card">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Semua layanan dapat disesuaikan dengan kebutuhan spesifik bisnis Anda.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 4: Keunggulan Perusahaan -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-4">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-medal"></i>
                        <span>Apa keunggulan PT MicroHelix?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-4">
                    <div class="mht-faq-answer-inner">
                        <div class="mht-faq-advantages-wrapper">
                            <div class="mht-faq-advantage-block">
                                <i class="fa-solid fa-check-circle"></i>
                                <span><strong>Baru & Inovatif:</strong> Perspektif fresh dengan teknologi terkini.</span>
                            </div>
                            <div class="mht-faq-advantage-block">
                                <i class="fa-solid fa-check-circle"></i>
                                <span><strong>Harga Kompetitif:</strong> Biaya terjangkau dengan kualitas terbaik.</span>
                            </div>
                            <div class="mht-faq-advantage-block">
                                <i class="fa-solid fa-check-circle"></i>
                                <span><strong>Tim Profesional:</strong> Tenaga ahli berpengalaman di bidang web development.</span>
                            </div>
                            <div class="mht-faq-advantage-block">
                                <i class="fa-solid fa-check-circle"></i>
                                <span><strong>Lokal & Mudah Dijangkau:</strong> Berbasis di Sidoarjo, siap melayani offline.</span>
                            </div>
                            <div class="mht-faq-advantage-block">
                                <i class="fa-solid fa-check-circle"></i>
                                <span><strong>Dukungan Penuh:</strong> Pendampingan dari awal hingga website live.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 5: Custom Project -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-5">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Apakah bisa request website custom?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-5">
                    <div class="mht-faq-answer-inner">
                        <p><strong>Ya, kami menerima permintaan website dengan spesifikasi khusus.</strong> Prosesnya:</p>
                        <ol class="mht-faq-steps-wrapper">
                            <li><span class="mht-faq-step-number">1</span> Konsultasi kebutuhan website</li>
                            <li><span class="mht-faq-step-number">2</span> Analisis dan perancangan konsep</li>
                            <li><span class="mht-faq-step-number">3</span> Pembuatan desain dan development</li>
                            <li><span class="mht-faq-step-number">4</span> Uji coba dan revisi</li>
                            <li><span class="mht-faq-step-number">5</span> Launching dan maintenance</li>
                        </ol>
                        <div class="mht-faq-highlight-card">
                            <i class="fa-solid fa-rocket"></i>
                            <span>Wujudkan website impian Anda dengan teknologi terkini!</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 6: Domain & Hosting -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-6">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-cloud"></i>
                        <span>Layanan domain dan hosting seperti apa?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-6">
                    <div class="mht-faq-answer-inner">
                        <p>Kami menyediakan paket lengkap domain dan hosting:</p>
                        
                        <div class="mht-faq-specs-card">
                            <h4 class="mht-faq-specs-title">
                                <i class="fa-solid fa-check-circle"></i> Domain
                            </h4>
                            <ul class="mht-faq-specs-list">
                                <li>.com, .id, .co.id, .net, .org</li>
                                <li>Gratis SSL Certificate</li>
                                <li>Manajemen DNS mudah</li>
                                <li>Email hosting tersedia</li>
                            </ul>
                            
                            <h4 class="mht-faq-specs-title mht-faq-mt-4">
                                <i class="fa-solid fa-check-circle"></i> Hosting
                            </h4>
                            <ul class="mht-faq-specs-list">
                                <li>SSD Storage untuk kecepatan maksimal</li>
                                <li>Uptime 99.9% terjamin</li>
                                <li>Backup data rutin</li>
                                <li>Support PHP, MySQL, dan teknologi terbaru</li>
                                <li>CPanel untuk manajemen mudah</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 7: Maintenance -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-7">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-headset"></i>
                        <span>Apakah ada layanan maintenance?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-7">
                    <div class="mht-faq-answer-inner">
                        <p><strong>Ya, tersedia paket maintenance bulanan/tahunan</strong> yang mencakup:</p>
                        
                        <div class="mht-faq-maintenance-wrapper">
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-rotate"></i>
                                <span>Update konten website</span>
                            </div>
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-shield"></i>
                                <span>Monitoring keamanan</span>
                            </div>
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-database"></i>
                                <span>Backup data rutin</span>
                            </div>
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>Optimasi performa</span>
                            </div>
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-bug"></i>
                                <span>Perbaikan bug</span>
                            </div>
                            <div class="mht-faq-maintenance-block">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span>Laporan performa</span>
                            </div>
                        </div>
                        
                        <p class="mht-faq-footnote">* Paket dapat disesuaikan dengan kebutuhan dan budget Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Item 8: Cara Mendapatkan Penawaran -->
            <div class="mht-faq-card">
                <button class="mht-faq-question" id="faq-question-8">
                    <div class="mht-faq-question-left">
                        <i class="fa-solid fa-tag"></i>
                        <span>Bagaimana cara mendapatkan penawaran?</span>
                    </div>
                    <i class="mht-faq-toggle-icon fa-solid fa-plus"></i>
                </button>
                <div class="mht-faq-answer" id="faq-answer-8">
                    <div class="mht-faq-answer-inner">
                        <p>Untuk mendapatkan penawaran harga, hubungi kami melalui:</p>
                        
                        <div class="mht-faq-contact-wrapper">
                            <div class="mht-faq-contact-block">
                                <i class="fa-solid fa-envelope"></i>
                                <div>
                                    <strong>Email:</strong>
                                    <a href="mailto:info@microhelix.tech">info@microhelix.tech</a>
                                </div>
                            </div>
                            
                            <div class="mht-faq-contact-block">
                                <i class="fa-solid fa-phone"></i>
                                <div>
                                    <strong>Telepon/WA:</strong>
                                    <a href="tel:+6281234567890">+62 812-3456-7890</a>
                                </div>
                            </div>
                            
                            <div class="mht-faq-contact-block">
                                <i class="fa-solid fa-location-dot"></i>
                                <div>
                                    <strong>Kantor:</strong>
                                    <span>Desa Ngampelsari, Candi, Sidoarjo</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mht-faq-response-note">
                            <i class="fa-regular fa-clock"></i>
                            Tim kami akan merespon maksimal 1x24 jam dengan konsultasi gratis.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== MHT FAQ STYLES - POPPINS ALL & ADJUSTED SPACING ===== */
/* Import Font Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

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
}

/* CSS Variables */
:root {
    --mht-faq-primary: #9C27B0;
    --mht-faq-primary-dark: #7B1FA2;
    --mht-faq-primary-light: rgba(156, 39, 176, 0.1);
    --mht-faq-text-dark: #121212;
    --mht-faq-text-body: #333333;
    --mht-faq-text-muted: #666666;
    --mht-faq-bg-light: #f8f8fc;
    --mht-faq-bg-white: #ffffff;
    --mht-faq-border: rgba(0, 0, 0, 0.05);
    --mht-faq-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-faq-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.12);
    --mht-faq-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-faq-radius: 16px;
}

/* Main Section */
.mht-faq-section {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    width: 100%;
    background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    position: relative;
    overflow-x: hidden;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 30px 0 60px 0; /* Reduced top padding from 100px to 30px */
    margin: 0;
}

/* Background Pattern */
.mht-faq-bg-pattern {
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
.mht-faq-container {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Header Section - Adjusted spacing */
.mht-faq-header-wrapper {
    text-align: center;
    margin-bottom: 40px; /* Reduced from 50px */
}

.mht-faq-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--mht-faq-primary-light), rgba(156, 39, 176, 0.05));
    color: var(--mht-faq-primary);
    padding: 6px 20px; /* Reduced padding */
    border-radius: 50px;
    font-size: 0.8rem; /* Slightly smaller */
    font-weight: 600;
    letter-spacing: 1.5px;
    margin-bottom: 15px; /* Reduced from 20px */
    border: 1px solid rgba(156, 39, 176, 0.2);
    text-transform: uppercase;
    backdrop-filter: blur(5px);
    font-family: 'Poppins', sans-serif;
}

.mht-faq-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--mht-faq-text-dark);
    margin-bottom: 12px; /* Reduced from 15px */
    line-height: 1.2;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-title span {
    background: linear-gradient(135deg, var(--mht-faq-primary), var(--mht-faq-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-subtitle {
    font-size: 1rem;
    color: var(--mht-faq-text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-subtitle strong {
    color: var(--mht-faq-primary);
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
}

/* FAQ Grid */
.mht-faq-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}

/* FAQ Card */
.mht-faq-card {
    background: var(--mht-faq-bg-white);
    border-radius: var(--mht-faq-radius);
    overflow: hidden;
    box-shadow: var(--mht-faq-shadow-sm);
    transition: var(--mht-faq-transition);
    border: 1px solid var(--mht-faq-border);
    width: 100%;
    position: relative;
}

.mht-faq-card:last-child {
    margin-bottom: 0;
}

/* FAQ Question */
.mht-faq-question {
    width: 100%;
    background: var(--mht-faq-bg-white);
    border: none;
    outline: none;
    text-align: left;
    font-size: 1rem;
    font-weight: 500;
    padding: 18px 22px;
    cursor: pointer;
    color: var(--mht-faq-text-body);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--mht-faq-transition);
    border-bottom: 1px solid transparent;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-question:hover {
    background: var(--mht-faq-primary-light);
}

.mht-faq-question-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
}

.mht-faq-question-left i:first-child {
    color: var(--mht-faq-primary);
    font-size: 1.2rem;
    width: 28px;
    text-align: center;
}

.mht-faq-question-left span {
    flex: 1;
    color: var(--mht-faq-text-body);
    font-family: 'Poppins', sans-serif;
}

/* Toggle Icon */
.mht-faq-toggle-icon {
    color: var(--mht-faq-primary);
    font-size: 1rem;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--mht-faq-primary-light);
    transition: var(--mht-faq-transition);
}

.mht-faq-question:hover .mht-faq-toggle-icon {
    transform: rotate(90deg);
    background: var(--mht-faq-primary);
    color: white;
}

/* FAQ Answer */
.mht-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    background: #fafafa;
}

.mht-faq-answer.active {
    max-height: 2000px;
}

.mht-faq-answer-inner {
    padding: 0 22px 22px 22px;
    border-top: 1px solid rgba(156, 39, 176, 0.1);
}

.mht-faq-answer p {
    color: var(--mht-faq-text-muted);
    line-height: 1.7;
    margin-bottom: 15px;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-answer p:last-child {
    margin-bottom: 0;
}

/* Info Card */
.mht-faq-info-card {
    background: var(--mht-faq-primary-light);
    padding: 15px 18px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-left: 3px solid var(--mht-faq-primary);
    margin-top: 15px;
}

.mht-faq-info-card i {
    color: var(--mht-faq-primary);
    font-size: 1.4rem;
}

.mht-faq-info-card div {
    color: var(--mht-faq-text-body);
    line-height: 1.5;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-text-muted {
    color: var(--mht-faq-text-muted);
    font-size: 0.9rem;
    display: block;
    margin-top: 3px;
    font-family: 'Poppins', sans-serif;
}

/* Address Card */
.mht-faq-address-card {
    background: var(--mht-faq-bg-light);
    padding: 15px 18px;
    border-radius: 10px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    border: 1px solid rgba(156, 39, 176, 0.1);
    margin: 15px 0;
}

.mht-faq-address-card i {
    color: var(--mht-faq-primary);
    font-size: 1.4rem;
}

.mht-faq-address-card div {
    color: var(--mht-faq-text-body);
    line-height: 1.6;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
}

/* Services Wrapper */
.mht-faq-services-wrapper {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin: 15px 0;
}

.mht-faq-service-block {
    background: var(--mht-faq-bg-light);
    padding: 15px;
    border-radius: 10px;
    transition: var(--mht-faq-transition);
}

.mht-faq-service-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--mht-faq-primary), var(--mht-faq-primary-dark));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    margin-bottom: 12px;
}

.mht-faq-service-info h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--mht-faq-text-body);
    margin-bottom: 5px;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-service-info p {
    font-size: 0.85rem;
    color: var(--mht-faq-text-muted);
    line-height: 1.5;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

/* Note Card */
.mht-faq-note-card {
    background: rgba(156, 39, 176, 0.08);
    padding: 12px 16px;
    border-radius: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
    font-size: 0.9rem;
    color: var(--mht-faq-text-body);
    font-family: 'Poppins', sans-serif;
}

.mht-faq-note-card i {
    color: var(--mht-faq-primary);
    font-size: 1rem;
}

/* Advantages Wrapper */
.mht-faq-advantages-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
}

.mht-faq-advantage-block {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px;
    background: var(--mht-faq-bg-light);
    border-radius: 8px;
    transition: var(--mht-faq-transition);
}

.mht-faq-advantage-block i {
    color: var(--mht-faq-primary);
    font-size: 1.1rem;
    width: 22px;
}

.mht-faq-advantage-block span {
    color: var(--mht-faq-text-body);
    font-size: 0.9rem;
    font-family: 'Poppins', sans-serif;
}

/* Steps Wrapper */
.mht-faq-steps-wrapper {
    list-style: none;
    padding: 0;
    margin: 15px 0;
}

.mht-faq-steps-wrapper li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-step-number {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, var(--mht-faq-primary), var(--mht-faq-primary-dark));
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
    font-family: 'Poppins', sans-serif;
}

/* Highlight Card */
.mht-faq-highlight-card {
    background: linear-gradient(135deg, var(--mht-faq-primary), var(--mht-faq-primary-dark));
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 15px;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-highlight-card i {
    font-size: 1.4rem;
}

/* Specs Card */
.mht-faq-specs-card {
    background: var(--mht-faq-bg-light);
    padding: 18px;
    border-radius: 10px;
    margin: 15px 0;
}

.mht-faq-specs-title {
    color: var(--mht-faq-primary);
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-specs-title i {
    color: var(--mht-faq-primary);
    font-size: 1rem;
}

.mht-faq-specs-list {
    list-style: none;
    padding: 0;
    margin: 0 0 15px 0;
}

.mht-faq-specs-list:last-child {
    margin-bottom: 0;
}

.mht-faq-specs-list li {
    padding: 6px 0 6px 25px;
    position: relative;
    color: var(--mht-faq-text-body);
    font-size: 0.9rem;
    font-family: 'Poppins', sans-serif;
}

.mht-faq-specs-list li::before {
    content: '✓';
    color: var(--mht-faq-primary);
    position: absolute;
    left: 0;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
}

/* Maintenance Wrapper */
.mht-faq-maintenance-wrapper {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin: 15px 0;
}

.mht-faq-maintenance-block {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: var(--mht-faq-bg-light);
    border-radius: 8px;
    transition: var(--mht-faq-transition);
    font-size: 0.9rem;
}

.mht-faq-maintenance-block i {
    color: var(--mht-faq-primary);
    font-size: 1rem;
    width: 20px;
}

.mht-faq-maintenance-block span {
    color: var(--mht-faq-text-body);
    font-family: 'Poppins', sans-serif;
}

.mht-faq-footnote {
    font-size: 0.8rem;
    color: #999;
    font-style: italic;
    margin-top: 10px;
    text-align: right;
    font-family: 'Poppins', sans-serif;
}

/* Contact Wrapper */
.mht-faq-contact-wrapper {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin: 15px 0;
}

.mht-faq-contact-block {
    background: var(--mht-faq-bg-light);
    padding: 15px 10px;
    border-radius: 10px;
    text-align: center;
    transition: var(--mht-faq-transition);
    border: 1px solid transparent;
}

.mht-faq-contact-block i {
    color: var(--mht-faq-primary);
    font-size: 1.5rem;
    margin-bottom: 8px;
}

.mht-faq-contact-block strong {
    display: block;
    margin-bottom: 5px;
    font-size: 0.85rem;
    color: var(--mht-faq-text-dark);
    font-family: 'Poppins', sans-serif;
}

.mht-faq-contact-block a,
.mht-faq-contact-block span {
    color: var(--mht-faq-text-muted);
    text-decoration: none;
    font-size: 0.8rem;
    display: block;
    line-height: 1.4;
    word-break: break-word;
    font-family: 'Poppins', sans-serif;
}

/* Response Note */
.mht-faq-response-note {
    background: rgba(156, 39, 176, 0.05);
    padding: 12px 16px;
    border-radius: 30px;
    color: var(--mht-faq-text-body);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
    border: 1px solid rgba(156, 39, 176, 0.15);
    font-family: 'Poppins', sans-serif;
}

.mht-faq-response-note i {
    color: var(--mht-faq-primary);
    font-size: 1rem;
}

/* Utilities */
.mht-faq-mt-3 {
    margin-top: 15px;
}

.mht-faq-mt-4 {
    margin-top: 20px;
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 768px) {
    .mht-faq-section {
        padding: 20px 0 50px 0; /* Even smaller top padding on mobile */
    }
    
    .mht-faq-container {
        padding: 0 15px;
    }
    
    .mht-faq-header-wrapper {
        margin-bottom: 30px;
    }
    
    .mht-faq-badge {
        margin-bottom: 10px;
        padding: 5px 16px;
        font-size: 0.75rem;
    }
    
    .mht-faq-title {
        font-size: 1.8rem;
        margin-bottom: 8px;
    }
    
    .mht-faq-subtitle {
        font-size: 0.95rem;
    }
    
    .mht-faq-question {
        padding: 15px 18px;
        font-size: 0.95rem;
    }
    
    .mht-faq-services-wrapper {
        grid-template-columns: 1fr;
    }
    
    .mht-faq-maintenance-wrapper {
        grid-template-columns: 1fr;
    }
    
    .mht-faq-contact-wrapper {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .mht-faq-section {
        padding: 15px 0 40px 0;
    }
    
    .mht-faq-title {
        font-size: 1.5rem;
    }
    
    .mht-faq-badge {
        font-size: 0.7rem;
        padding: 4px 14px;
    }
}
</style>

<script>
// MHT FAQ JavaScript
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    const faqQuestions = document.querySelectorAll('.mht-faq-question');
    
    function closeAllFAQs(except = null) {
        document.querySelectorAll('.mht-faq-answer').forEach(answer => {
            if (answer !== except) {
                answer.classList.remove('active');
                const toggleIcon = answer.previousElementSibling.querySelector('.mht-faq-toggle-icon');
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-minus');
                    toggleIcon.classList.add('fa-plus');
                }
            }
        });
    }
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function(e) {
            e.preventDefault();
            
            const answer = this.nextElementSibling;
            const toggleIcon = this.querySelector('.mht-faq-toggle-icon');
            const isActive = answer.classList.contains('active');
            
            closeAllFAQs(isActive ? null : answer);
            
            if (!isActive) {
                answer.classList.add('active');
                toggleIcon.classList.remove('fa-plus');
                toggleIcon.classList.add('fa-minus');
            } else {
                answer.classList.remove('active');
                toggleIcon.classList.remove('fa-minus');
                toggleIcon.classList.add('fa-plus');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>