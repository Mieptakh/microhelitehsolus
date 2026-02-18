<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include __DIR__ . '/../webmaster/includes/db.php'; ?>

<style>
/* ===== MHT ABOUT STYLES - FULLY CUSTOMIZED & NO WHITE SPACE ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
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
    scroll-behavior: smooth;
}

/* CSS Variables - Konsisten dengan halaman lain (hanya ungu) */
:root {
    --mht-about-primary: #9C27B0;
    --mht-about-primary-dark: #7B1FA2;
    --mht-about-primary-light: rgba(156, 39, 176, 0.1);
    --mht-about-text-dark: #121212;
    --mht-about-text-body: #333333;
    --mht-about-text-muted: #666666;
    --mht-about-bg-light: #f8f8fc;
    --mht-about-bg-white: #ffffff;
    --mht-about-border: rgba(0, 0, 0, 0.05);
    --mht-about-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-about-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-about-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-about-radius: 20px;
}

/* Container */
.mht-about-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Section styling */
.mht-about-section {
    font-family: 'Poppins', sans-serif;
    width: 100%;
    background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    position: relative;
    overflow-x: hidden;
    padding: 0;
    margin: 0;
}

/* Background Pattern */
.mht-about-bg-pattern {
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

/* ===== HERO SECTION ===== */
.mht-about-hero {
    padding: 100px 0 60px 0;
    position: relative;
    width: 100%;
    min-height: 50vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(156, 39, 176, 0.03), rgba(156, 39, 176, 0.01));
}

.mht-about-hero .mht-about-container {
    text-align: center;
}

.mht-about-hero-badge {
    display: inline-block;
    background: var(--mht-about-primary-light);
    color: var(--mht-about-primary);
    padding: 8px 24px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 2px;
    margin-bottom: 25px;
    border: 1px solid rgba(156, 39, 176, 0.2);
    text-transform: uppercase;
    backdrop-filter: blur(10px);
    animation: mhtAboutFadeIn 1s ease;
}

.mht-about-hero h1 {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    color: var(--mht-about-text-dark);
    margin-bottom: 20px;
    line-height: 1.2;
    animation: mhtAboutFadeInUp 1s ease 0.2s both;
}

.mht-about-hero .mht-about-highlight {
    color: var(--mht-about-primary);
    position: relative;
}

.mht-about-hero p {
    font-size: 1.1rem;
    color: var(--mht-about-text-muted);
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
    animation: mhtAboutFadeInUp 1s ease 0.4s both;
}

/* ===== SEJARAH SECTION ===== */
.mht-about-history {
    padding: 80px 0;
    background: var(--mht-about-bg-white);
    position: relative;
    width: 100%;
}

.mht-about-history-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
}

.mht-about-history-content {
    animation: mhtAboutFadeInLeft 1s ease;
}

.mht-about-section-badge {
    display: inline-block;
    background: var(--mht-about-primary-light);
    color: var(--mht-about-primary);
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.mht-about-history-content h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--mht-about-text-dark);
    margin-bottom: 25px;
    line-height: 1.3;
}

.mht-about-history-content h2 span {
    color: var(--mht-about-primary);
}

.mht-about-history-content p {
    font-size: 1rem;
    color: var(--mht-about-text-body);
    line-height: 1.8;
    margin-bottom: 20px;
}

.mht-about-history-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 30px;
}

.mht-about-stat-item {
    text-align: center;
    padding: 15px;
    background: var(--mht-about-bg-light);
    border-radius: 12px;
    transition: var(--mht-about-transition);
}

.mht-about-stat-item:hover {
    transform: translateY(-5px);
    background: var(--mht-about-primary-light);
}

.mht-about-stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--mht-about-primary);
    margin-bottom: 5px;
}

.mht-about-stat-label {
    font-size: 0.8rem;
    color: var(--mht-about-text-muted);
    font-weight: 500;
}

.mht-about-history-image {
    position: relative;
    animation: mhtAboutFadeInRight 1s ease;
}

.mht-about-history-image img {
    width: 100%;
    border-radius: var(--mht-about-radius);
    box-shadow: var(--mht-about-shadow-hover);
}

.mht-about-history-image::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: 10px;
    bottom: 10px;
    border: 2px solid var(--mht-about-primary);
    border-radius: var(--mht-about-radius);
    z-index: -1;
    opacity: 0.3;
}

/* ===== TEAM SECTION ===== */
.mht-about-team {
    padding: 80px 0;
    background: linear-gradient(135deg, rgba(156, 39, 176, 0.02), rgba(156, 39, 176, 0.01));
    width: 100%;
}

.mht-about-team-header {
    text-align: center;
    margin-bottom: 50px;
}

.mht-about-team-header h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--mht-about-text-dark);
    margin-bottom: 15px;
}

.mht-about-team-header h2 span {
    color: var(--mht-about-primary);
}

.mht-about-team-header p {
    color: var(--mht-about-text-muted);
    font-size: 1rem;
    max-width: 600px;
    margin: 0 auto;
}

.mht-about-team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.mht-about-team-card {
    background: var(--mht-about-bg-white);
    border-radius: var(--mht-about-radius);
    padding: 30px;
    box-shadow: var(--mht-about-shadow-sm);
    transition: var(--mht-about-transition);
    border: 1px solid var(--mht-about-border);
    position: relative;
    overflow: hidden;
}

.mht-about-team-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--mht-about-primary);
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.mht-about-team-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--mht-about-shadow-hover);
}

.mht-about-team-card:hover::before {
    transform: translateX(0);
}

/* Team Avatar dengan Gambar */
.mht-about-team-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 20px;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
}

.mht-about-team-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.mht-about-team-card:hover .mht-about-team-avatar img {
    transform: scale(1.1);
}

.mht-about-team-card h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--mht-about-text-dark);
    margin-bottom: 5px;
    text-align: center;
}

.mht-about-team-role {
    color: var(--mht-about-primary);
    font-size: 0.9rem;
    font-weight: 500;
    text-align: center;
    margin-bottom: 15px;
}

.mht-about-team-bio {
    font-size: 0.9rem;
    color: var(--mht-about-text-muted);
    line-height: 1.6;
    text-align: center;
    margin-bottom: 20px;
}

.mht-about-team-social {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.mht-about-team-social a {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: var(--mht-about-bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--mht-about-primary);
    text-decoration: none;
    transition: var(--mht-about-transition);
}

.mht-about-team-social a:hover {
    background: var(--mht-about-primary);
    color: white;
    transform: translateY(-3px);
}

/* ===== CONTRIBUTOR SECTION ===== */
.mht-about-contributor {
    padding: 60px 0;
    background: linear-gradient(135deg, var(--mht-about-primary), var(--mht-about-primary-dark));
    width: 100%;
    position: relative;
    overflow: hidden;
}

.mht-about-contributor::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    animation: mhtAboutRotate 20s linear infinite;
}

.mht-about-contributor-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.mht-about-contributor-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    padding: 40px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 40px;
    align-items: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

/* Contributor Avatar dengan Gambar */
.mht-about-contributor-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: mhtAboutPulse 2s infinite;
}

.mht-about-contributor-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mht-about-contributor-content {
    color: white;
}

.mht-about-contributor-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.mht-about-contributor-content h2 {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.mht-about-contributor-content h3 {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 20px;
    opacity: 0.9;
}

.mht-about-contributor-content p {
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 25px;
    opacity: 0.9;
}

.mht-about-contributor-stats {
    display: flex;
    gap: 30px;
}

.mht-about-contributor-stat {
    text-align: center;
}

.mht-about-contributor-stat .number {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    display: block;
}

.mht-about-contributor-stat .label {
    font-size: 0.8rem;
    opacity: 0.8;
}

/* ===== VISI MISI SECTION ===== */
.mht-about-vision {
    padding: 80px 0;
    background: var(--mht-about-bg-white);
    width: 100%;
}

.mht-about-vision-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
}

.mht-about-vision-card {
    background: linear-gradient(135deg, var(--mht-about-bg-light), white);
    padding: 40px;
    border-radius: var(--mht-about-radius);
    box-shadow: var(--mht-about-shadow-sm);
    transition: var(--mht-about-transition);
    border: 1px solid var(--mht-about-border);
}

.mht-about-vision-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--mht-about-shadow-hover);
}

.mht-about-vision-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--mht-about-primary), var(--mht-about-primary-dark));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 25px;
}

.mht-about-vision-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--mht-about-text-dark);
    margin-bottom: 15px;
}

.mht-about-vision-card p {
    color: var(--mht-about-text-body);
    line-height: 1.8;
    margin-bottom: 20px;
}

.mht-about-vision-list {
    list-style: none;
}

.mht-about-vision-list li {
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
    color: var(--mht-about-text-muted);
    border-bottom: 1px dashed var(--mht-about-border);
}

.mht-about-vision-list li:last-child {
    border-bottom: none;
}

.mht-about-vision-list li::before {
    content: "✓";
    color: var(--mht-about-primary);
    position: absolute;
    left: 0;
    top: 10px;
    font-weight: bold;
    font-size: 1.1rem;
}

/* ===== WHY CHOOSE US SECTION ===== */
.mht-about-why {
    padding: 80px 0;
    background: linear-gradient(135deg, rgba(156, 39, 176, 0.02), rgba(156, 39, 176, 0.01));
    width: 100%;
}

.mht-about-why-header {
    text-align: center;
    margin-bottom: 50px;
}

.mht-about-why-header h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--mht-about-text-dark);
    margin-bottom: 15px;
}

.mht-about-why-header h2 span {
    color: var(--mht-about-primary);
}

.mht-about-why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.mht-about-why-card {
    background: var(--mht-about-bg-white);
    padding: 30px;
    border-radius: var(--mht-about-radius);
    text-align: center;
    box-shadow: var(--mht-about-shadow-sm);
    transition: var(--mht-about-transition);
    border: 1px solid var(--mht-about-border);
}

.mht-about-why-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--mht-about-shadow-hover);
    border-color: var(--mht-about-primary);
}

.mht-about-why-icon {
    width: 70px;
    height: 70px;
    background: var(--mht-about-primary-light);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 1.8rem;
    color: var(--mht-about-primary);
    transition: var(--mht-about-transition);
}

.mht-about-why-card:hover .mht-about-why-icon {
    background: var(--mht-about-primary);
    color: white;
    transform: scale(1.1) rotate(5deg);
}

.mht-about-why-card h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--mht-about-text-dark);
    margin-bottom: 12px;
}

.mht-about-why-card p {
    font-size: 0.9rem;
    color: var(--mht-about-text-muted);
    line-height: 1.7;
}

/* Animations */
@keyframes mhtAboutFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes mhtAboutFadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes mhtAboutFadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes mhtAboutFadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes mhtAboutPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes mhtAboutRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 992px) {
    .mht-about-history-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .mht-about-history-image {
        order: -1;
    }
    
    .mht-about-vision-grid {
        grid-template-columns: 1fr;
    }
    
    .mht-about-contributor-card {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 20px;
    }
    
    .mht-about-contributor-avatar {
        margin: 0 auto;
    }
    
    .mht-about-contributor-stats {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .mht-about-hero {
        padding: 80px 0 50px 0;
    }
    
    .mht-about-history {
        padding: 60px 0;
    }
    
    .mht-about-team {
        padding: 60px 0;
    }
    
    .mht-about-vision {
        padding: 60px 0;
    }
    
    .mht-about-why {
        padding: 60px 0;
    }
    
    .mht-about-history-stats {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .mht-about-contributor-card {
        padding: 30px;
    }
    
    .mht-about-contributor-stats {
        flex-direction: column;
        gap: 15px;
    }
}

@media (max-width: 576px) {
    .mht-about-hero h1 {
        font-size: 2rem;
    }
    
    .mht-about-hero p {
        font-size: 1rem;
    }
    
    .mht-about-history-content h2 {
        font-size: 1.8rem;
    }
    
    .mht-about-team-header h2 {
        font-size: 1.8rem;
    }
    
    .mht-about-vision-card {
        padding: 25px;
    }
    
    .mht-about-why-card {
        padding: 20px;
    }
}
</style>

<!-- About Section -->
<section class="mht-about-section">
    <!-- Background Pattern -->
    <div class="mht-about-bg-pattern"></div>
    
    <!-- Hero Section -->
    <div class="mht-about-hero">
        <div class="mht-about-container">
            <span class="mht-about-hero-badge">ABOUT US</span>
            <h1>
                Tentang <span class="mht-about-highlight">PT MicroHelix Tech Solutions</span>
            </h1>
            <p>
                Kami adalah perusahaan teknologi yang fokus pada pengembangan, maintenance, dan restyle website 
                untuk membantu bisnis Anda tampil profesional dan kompetitif di era digital. Didirikan oleh 
                tiga siswa SMA yang memiliki passion di dunia teknologi.
            </p>
        </div>
    </div>
    
    <!-- Sejarah Section -->
    <div class="mht-about-history">
        <div class="mht-about-container">
            <div class="mht-about-history-grid">
                <div class="mht-about-history-content">
                    <span class="mht-about-section-badge">SEJARAH KAMI</span>
                    <h2>Perjalanan <span>PT MicroHelix</span></h2>
                    <p>
                        <strong>PT MicroHelix Tech Solutions</strong> didirikan pada tanggal <strong>5 Januari 2026</strong> oleh 
                        <strong>Ach. Miftakhul Huda (Kelas 12)</strong> sebagai Founder & Direktur, bersama dua rekannya yang juga 
                        masih duduk di bangku SMA kelas 12: <strong>M. Ihsan</strong> sebagai Graphic Designer dan 
                        <strong>M. Imron Rosyadi</strong> sebagai Administrasi & Quality Assurance.
                    </p>
                    <p>
                        Berawal dari project-project kecil untuk UMKM lokal dan tugas sekolah, kami berkembang menjadi 
                        mitra strategis bagi berbagai usaha kecil dalam mengembangkan dan merawat website mereka. 
                        Meskipun masih berstatus pelajar, kami telah menyelesaikan lebih dari 25 proyek website 
                        dengan kualitas yang tidak kalah dengan developer profesional.
                    </p>
                    <p>
                        Fokus utama kami adalah memberikan layanan pengembangan website, maintenance rutin, 
                        dan restyle website agar selalu up-to-date dengan teknologi terbaru. Semua ini kami lakukan 
                        sambil tetap menjalankan kewajiban sebagai siswa SMA.
                    </p>
                    
                    <div class="mht-about-history-stats">
                        <div class="mht-about-stat-item">
                            <div class="mht-about-stat-number">2026</div>
                            <div class="mht-about-stat-label">Tahun Berdiri</div>
                        </div>
                        <div class="mht-about-stat-item">
                            <div class="mht-about-stat-number">25+</div>
                            <div class="mht-about-stat-label">Proyek Selesai</div>
                        </div>
                        <div class="mht-about-stat-item">
                            <div class="mht-about-stat-number">15+</div>
                            <div class="mht-about-stat-label">Klien Puas</div>
                        </div>
                    </div>
                </div>
                <div class="mht-about-history-image">
                    <img src="logo/2025.png" alt="MicroHelix Team" onerror="this.src='assets/images/default-office.jpg'">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Team Section -->
    <div class="mht-about-team">
        <div class="mht-about-container">
            <div class="mht-about-team-header">
                <h2>Tim <span>Inti</span></h2>
                <p>Tiga siswa SMA kelas 12 di balik layanan website MicroHelix</p>
            </div>
            
            <div class="mht-about-team-grid">
                <div class="mht-about-team-card">
                    <div class="mht-about-team-avatar">
                        <img src="assets/images/personal/huda.png" alt="Ach. Miftakhul Huda" onerror="this.src='assets/images/personal/default-avatar.jpg'">
                    </div>
                    <h3>Ach. Miftakhul Huda</h3>
                    <div class="mht-about-team-role">Founder, Direktur & Full Stack Programmer</div>
                    <p class="mht-about-team-bio">Siswa kelas 12 yang memiliki passion di dunia programming sejak SMP. Menguasai berbagai bahasa pemrograman dan framework untuk pengembangan website.</p>
                    <div class="mht-about-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                
                <div class="mht-about-team-card">
                    <div class="mht-about-team-avatar">
                        <img src="assets/images/personal/ihsan.png" alt="M. Ihsan" onerror="this.src='assets/images/personal/default-avatar.jpg'">
                    </div>
                    <h3>M. Ihsan</h3>
                    <div class="mht-about-team-role">Graphic Designer</div>
                    <p class="mht-about-team-bio">Siswa kelas 12 dengan bakat luar biasa di bidang desain grafis. Bertanggung jawab atas tampilan visual website yang menarik dan user-friendly.</p>
                    <div class="mht-about-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-behance"></i></a>
                    </div>
                </div>
                
                <div class="mht-about-team-card">
                    <div class="mht-about-team-avatar">
                        <img src="assets/images/personal/imron.png" alt="M. Imron Rosyadi" onerror="this.src='assets/images/personal/default-avatar.jpg'">
                    </div>
                    <h3>M. Imron Rosyadi</h3>
                    <div class="mht-about-team-role">Administrasi & Quality Assurance</div>
                    <p class="mht-about-team-bio">Siswa kelas 12 yang bertanggung jawab atas administrasi, komunikasi dengan klien, dan quality control untuk memastikan setiap website bebas bug.</p>
                    <div class="mht-about-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contributor Section - M. Ferdiansyah -->
    <div class="mht-about-contributor">
        <div class="mht-about-contributor-container">
            <div class="mht-about-contributor-card">
                <div class="mht-about-contributor-avatar">
                    <img src="assets/images/personal/image.png" alt="M. Ferdiansyah" onerror="this.src='assets/images/personal/default-avatar.jpg'">
                </div>
                <div class="mht-about-contributor-content">
                    <span class="mht-about-contributor-badge">FINANCIAL SUPPORTER</span>
                    <h2>M. Ferdiansyah</h2>
                    <h3>Strategic Financial Partner</h3>
                    <p>
                        M. Ferdiansyah merupakan salah satu koneksi strategis yang berperan dalam mendukung 
                        keberlangsungan berbagai project open source maupun private yang dikembangkan oleh 
                        MicroHelix. Dukungan finansial yang diberikan membantu menjaga stabilitas operasional 
                        tim, mempercepat pengembangan produk, serta memastikan setiap inisiatif dapat berjalan 
                        secara berkelanjutan.
                    </p>
                    <p>
                        Kolaborasi ini berjalan secara profesional dengan timbal balik yang telah disepakati 
                        bersama, mencerminkan hubungan kemitraan yang saling menguntungkan dan berorientasi 
                        pada pertumbuhan jangka panjang.
                    </p>

                    <div class="mht-about-contributor-stats">
                        <div class="mht-about-contributor-stat">
                            <span class="number">2026</span>
                            <span class="label">Start Support</span>
                        </div>
                        <div class="mht-about-contributor-stat">
                            <span class="number">Active</span>
                            <span class="label">Status</span>
                        </div>
                        <div class="mht-about-contributor-stat">
                            <span class="number">Financial</span>
                            <span class="label">Role</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Visi & Misi Section -->
    <div class="mht-about-vision">
        <div class="mht-about-container">
            <div class="mht-about-vision-grid">
                <div class="mht-about-vision-card">
                    <div class="mht-about-vision-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Visi</h3>
                    <p>Menjadi mitra terdepan dalam layanan pengembangan, maintenance, dan restyle website yang inovatif dan berkualitas di Indonesia, yang digerakkan oleh generasi muda berbakat.</p>
                </div>
                
                <div class="mht-about-vision-card">
                    <div class="mht-about-vision-icon">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3>Misi</h3>
                    <ul class="mht-about-vision-list">
                        <li>Mengembangkan website berkualitas tinggi dengan teknologi terkini.</li>
                        <li>Menyediakan layanan maintenance rutin untuk menjaga performa website.</li>
                        <li>Melakukan restyle website agar selalu modern dan sesuai tren.</li>
                        <li>Memberikan pendampingan penuh dari awal hingga website live dan setelahnya.</li>
                        <li>Membangun hubungan jangka panjang dengan klien melalui layanan terbaik.</li>
                        <li>Membuktikan bahwa usia muda bukan halangan untuk berkarya di dunia teknologi.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Us Section -->
    <div class="mht-about-why">
        <div class="mht-about-container">
            <div class="mht-about-why-header">
                <h2>Mengapa <span>Memilih Kami?</span></h2>
                <p>Keunggulan yang membuat PT MicroHelix berbeda dari yang lain</p>
            </div>
            
            <div class="mht-about-why-grid">
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <h4>Pengembangan Website</h4>
                    <p>Website custom sesuai kebutuhan bisnis Anda dengan teknologi modern dan responsive.</p>
                </div>
                
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <h4>Maintenance Rutin</h4>
                    <p>Update konten, backup data, monitoring keamanan, dan perbaikan bug secara berkala.</p>
                </div>
                
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-paint-roller"></i>
                    </div>
                    <h4>Restyle Website</h4>
                    <p>Perbarui tampilan website Anda agar lebih modern, fresh, dan sesuai dengan brand terkini.</p>
                </div>
                
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4>Dukungan 24/7</h4>
                    <p>Tim support siap membantu Anda kapan pun dibutuhkan dengan response cepat.</p>
                </div>
                
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h4>Anak Muda Berbakat</h4>
                    <p>Tim muda dengan energi tinggi, kreativitas tanpa batas, dan harga yang bersahabat.</p>
                </div>
                
                <div class="mht-about-why-card">
                    <div class="mht-about-why-icon">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <h4>Harga Terjangkau</h4>
                    <p>Kualitas profesional dengan harga yang ramah di kantong, cocok untuk UMKM dan bisnis kecil.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>