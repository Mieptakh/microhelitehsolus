<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    // Redirect ke halaman proyek jika slug tidak valid
    header('Location: proyek-kami.php');
    exit;
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE slug = ?");
    $stmt->execute([$slug]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        // Redirect ke halaman proyek jika proyek tidak ditemukan
        header('Location: proyek-kami.php');
        exit;
    }
} catch (PDOException $e) {
    die("Kesalahan database: " . htmlspecialchars($e->getMessage()));
}

// Sanitasi data
$projectName = htmlspecialchars($project['name']);
$projectDesc = htmlspecialchars($project['description']);
$projectIcon = htmlspecialchars($project['icon']);
$projectImage = htmlspecialchars($project['image']);
$projectUrl = !empty($project['url']) ? htmlspecialchars($project['url']) : '';
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<!-- Project Detail Section -->
<section id="mht-project-detail" class="mht-project-detail-section">
    <!-- Background Pattern -->
    <div class="mht-project-detail-bg-pattern"></div>
    
    <div class="mht-project-detail-container">
        <!-- Back Button -->
        <a href="proyek-kami.php" class="mht-project-detail-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Semua Proyek</span>
        </a>

        <div class="mht-project-detail-wrapper">
            <!-- Main Content -->
            <div class="mht-project-detail-main">
                <div class="mht-project-detail-header">
                    <span class="mht-project-detail-badge">DETAIL PROYEK</span>
                    <h1 class="mht-project-detail-title">
                        <i class="fas fa-<?php echo $projectIcon; ?>"></i>
                        <?php echo $projectName; ?>
                    </h1>
                </div>

                <!-- Image Gallery -->
                <div class="mht-project-detail-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $projectImage; ?>" 
                         alt="<?php echo $projectName; ?>" 
                         loading="lazy" 
                         class="mht-project-detail-image" />
                    <div class="mht-project-detail-image-overlay">
                        <i class="fas fa-<?php echo $projectIcon; ?>"></i>
                    </div>
                </div>

                <!-- Description -->
                <div class="mht-project-detail-description-wrapper">
                    <h2 class="mht-project-detail-subtitle">
                        <i class="far fa-file-lines"></i>
                        Tentang Proyek
                    </h2>
                    <div class="mht-project-detail-description">
                        <?php echo nl2br($projectDesc); ?>
                    </div>
                </div>

                <!-- Project Info Cards -->
                <div class="mht-project-detail-info-grid">
                    <div class="mht-project-detail-info-card">
                        <i class="far fa-calendar"></i>
                        <div>
                            <span class="mht-project-detail-info-label">Tanggal Rilis</span>
                            <span class="mht-project-detail-info-value">
                                <?php 
                                if (!empty($project['date_added'])) {
                                    echo date('d F Y', strtotime($project['date_added']));
                                } else {
                                    echo 'Tidak tersedia';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mht-project-detail-info-card">
                        <i class="far fa-folder-open"></i>
                        <div>
                            <span class="mht-project-detail-info-label">Kategori</span>
                            <span class="mht-project-detail-info-value">
                                <?php 
                                // Tentukan kategori berdasarkan icon atau nama
                                if (strpos($projectIcon, 'code') !== false || strpos($projectName, 'Web') !== false) {
                                    echo 'Website Development';
                                } elseif (strpos($projectIcon, 'mobile') !== false || strpos($projectName, 'App') !== false) {
                                    echo 'Mobile Application';
                                } elseif (strpos($projectIcon, 'database') !== false || strpos($projectName, 'Panel') !== false) {
                                    echo 'Web Application';
                                } else {
                                    echo 'Digital Project';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mht-project-detail-info-card">
                        <i class="far fa-circle-check"></i>
                        <div>
                            <span class="mht-project-detail-info-label">Status</span>
                            <span class="mht-project-detail-info-value status-active">Selesai & Live</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mht-project-detail-actions">
                    <?php if (!empty($projectUrl)): ?>
                        <a href="<?php echo $projectUrl; ?>" 
                           class="mht-project-detail-btn-visit" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Kunjungi Proyek</span>
                            <i class="fas fa-arrow-right mht-project-detail-btn-icon"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="mht-project-detail-sidebar">
                <!-- Tech Stack -->
                <div class="mht-project-detail-card">
                    <h3 class="mht-project-detail-card-title">
                        <i class="fas fa-code"></i>
                        Tech Stack
                    </h3>
                    <div class="mht-project-detail-tech-stack">
                        <?php
                        // Generate tech stack based on icon or project name
                        $techs = [];
                        if (strpos($projectIcon, 'code') !== false || strpos($projectName, 'Web') !== false) {
                            $techs = ['HTML5', 'CSS3', 'JavaScript', 'PHP', 'MySQL'];
                        } elseif (strpos($projectIcon, 'mobile') !== false || strpos($projectName, 'App') !== false) {
                            $techs = ['React Native', 'Firebase', 'Node.js', 'Express'];
                        } elseif (strpos($projectIcon, 'database') !== false || strpos($projectName, 'Panel') !== false) {
                            $techs = ['Vue.js', 'Laravel', 'MySQL', 'Tailwind CSS'];
                        } else {
                            $techs = ['HTML5', 'CSS3', 'JavaScript', 'Bootstrap'];
                        }
                        
                        foreach ($techs as $tech):
                        ?>
                            <span class="mht-project-detail-tech-badge"><?php echo $tech; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Key Features -->
                <div class="mht-project-detail-card">
                    <h3 class="mht-project-detail-card-title">
                        <i class="far fa-star"></i>
                        Fitur Utama
                    </h3>
                    <ul class="mht-project-detail-features-list">
                        <li><i class="far fa-circle-check"></i> Responsive Design</li>
                        <li><i class="far fa-circle-check"></i> Modern UI/UX</li>
                        <li><i class="far fa-circle-check"></i> Optimized Performance</li>
                        <li><i class="far fa-circle-check"></i> Cross-browser Compatible</li>
                        <li><i class="far fa-circle-check"></i> SEO Friendly</li>
                    </ul>
                </div>

                <!-- Share -->
                <div class="mht-project-detail-card">
                    <h3 class="mht-project-detail-card-title">
                        <i class="fas fa-share-alt"></i>
                        Bagikan Proyek
                    </h3>
                    <div class="mht-project-detail-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                           target="_blank" 
                           class="mht-project-detail-share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($projectName); ?>" 
                           target="_blank" 
                           class="mht-project-detail-share-btn twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                           target="_blank" 
                           class="mht-project-detail-share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode($projectName . ' - ' . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                           target="_blank" 
                           class="mht-project-detail-share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== MHT PROJECT DETAIL STYLES - WITH CUSTOM SCROLLBAR ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

/* CSS Variables */
:root {
    --mht-project-primary: #9C27B0;
    --mht-project-primary-dark: #7B1FA2;
    --mht-project-primary-light: rgba(156, 39, 176, 0.1);
    --mht-project-text-dark: #121212;
    --mht-project-text-body: #333333;
    --mht-project-text-muted: #666666;
    --mht-project-bg-light: #f8f8fc;
    --mht-project-bg-white: #ffffff;
    --mht-project-border: rgba(0, 0, 0, 0.05);
    --mht-project-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-project-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-project-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-project-radius: 20px;
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
    background: linear-gradient(135deg, var(--mht-project-primary), var(--mht-project-primary-dark));
    border-radius: 6px;
    border: 3px solid var(--bg-light);
    transition: var(--mht-project-transition);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--mht-project-primary-dark);
}

/* Firefox scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--mht-project-primary) var(--bg-light);
}

/* Main Section */
.mht-project-detail-section {
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
.mht-project-detail-bg-pattern {
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
.mht-project-detail-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Back Button */
.mht-project-detail-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: var(--mht-project-bg-white);
    color: var(--mht-project-primary);
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 30px;
    border: 1px solid var(--mht-project-border);
    transition: var(--mht-project-transition);
}

.mht-project-detail-back:hover {
    background: var(--mht-project-primary-light);
    transform: translateX(-5px);
}

/* Main Wrapper */
.mht-project-detail-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
    width: 100%;
}

/* Main Content */
.mht-project-detail-main {
    background: var(--mht-project-bg-white);
    border-radius: var(--mht-project-radius);
    padding: 35px;
    box-shadow: var(--mht-project-shadow-sm);
    border: 1px solid var(--mht-project-border);
    position: relative;
    overflow: hidden;
}

.mht-project-detail-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--mht-project-primary), var(--mht-project-primary-dark));
}

/* Header */
.mht-project-detail-header {
    margin-bottom: 25px;
}

.mht-project-detail-badge {
    display: inline-block;
    background: var(--mht-project-primary-light);
    color: var(--mht-project-primary);
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.mht-project-detail-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--mht-project-text-dark);
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 12px;
}

.mht-project-detail-title i {
    color: var(--mht-project-primary);
    font-size: 1.8rem;
}

/* Image */
.mht-project-detail-image-wrapper {
    position: relative;
    width: 100%;
    height: 400px;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: var(--mht-project-shadow-hover);
}

.mht-project-detail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.mht-project-detail-image-wrapper:hover .mht-project-detail-image {
    transform: scale(1.05);
}

.mht-project-detail-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 30px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mht-project-detail-image-wrapper:hover .mht-project-detail-image-overlay {
    opacity: 1;
}

.mht-project-detail-image-overlay i {
    color: white;
    font-size: 3rem;
    background: rgba(156, 39, 176, 0.3);
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

/* Description */
.mht-project-detail-description-wrapper {
    margin-bottom: 30px;
}

.mht-project-detail-subtitle {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--mht-project-text-dark);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-project-detail-subtitle i {
    color: var(--mht-project-primary);
}

.mht-project-detail-description {
    font-size: 1rem;
    color: var(--mht-project-text-body);
    line-height: 1.8;
    background: var(--mht-project-bg-light);
    padding: 25px;
    border-radius: 12px;
    border: 1px solid var(--mht-project-border);
}

/* Info Grid */
.mht-project-detail-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.mht-project-detail-info-card {
    background: var(--mht-project-bg-light);
    padding: 20px 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid var(--mht-project-border);
    transition: var(--mht-project-transition);
}

.mht-project-detail-info-card:hover {
    background: var(--mht-project-primary-light);
    transform: translateY(-3px);
}

.mht-project-detail-info-card i {
    color: var(--mht-project-primary);
    font-size: 1.5rem;
    width: 35px;
}

.mht-project-detail-info-label {
    display: block;
    font-size: 0.75rem;
    color: var(--mht-project-text-muted);
    margin-bottom: 3px;
}

.mht-project-detail-info-value {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--mht-project-text-dark);
}

.mht-project-detail-info-value.status-active {
    color: #2e7d32;
}

/* Actions */
.mht-project-detail-actions {
    margin-top: 30px;
}

.mht-project-detail-btn-visit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 32px;
    background: linear-gradient(135deg, var(--mht-project-primary), var(--mht-project-primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    transition: var(--mht-project-transition);
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 100%;
}

.mht-project-detail-btn-visit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.mht-project-detail-btn-visit:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.4);
}

.mht-project-detail-btn-visit:hover::before {
    left: 100%;
}

.mht-project-detail-btn-visit:hover .mht-project-detail-btn-icon {
    transform: translateX(5px);
}

.mht-project-detail-btn-icon {
    transition: transform 0.3s ease;
}

/* Sidebar */
.mht-project-detail-sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.mht-project-detail-card {
    background: var(--mht-project-bg-white);
    border-radius: var(--mht-project-radius);
    padding: 25px;
    box-shadow: var(--mht-project-shadow-sm);
    border: 1px solid var(--mht-project-border);
}

.mht-project-detail-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--mht-project-text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--mht-project-border);
}

.mht-project-detail-card-title i {
    color: var(--mht-project-primary);
}

/* Tech Stack */
.mht-project-detail-tech-stack {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.mht-project-detail-tech-badge {
    background: var(--mht-project-primary-light);
    color: var(--mht-project-primary-dark);
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(156, 39, 176, 0.2);
    transition: var(--mht-project-transition);
}

.mht-project-detail-tech-badge:hover {
    background: var(--mht-project-primary);
    color: white;
    transform: translateY(-2px);
}

/* Features List */
.mht-project-detail-features-list {
    list-style: none;
}

.mht-project-detail-features-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    color: var(--mht-project-text-body);
    font-size: 0.9rem;
    border-bottom: 1px dashed var(--mht-project-border);
}

.mht-project-detail-features-list li:last-child {
    border-bottom: none;
}

.mht-project-detail-features-list li i {
    color: var(--mht-project-primary);
    font-size: 1rem;
}

/* Share */
.mht-project-detail-share {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.mht-project-detail-share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    border-radius: 10px;
    color: white;
    text-decoration: none;
    transition: var(--mht-project-transition);
}

.mht-project-detail-share-btn.facebook {
    background: #1877f2;
}

.mht-project-detail-share-btn.twitter {
    background: #000000;
}

.mht-project-detail-share-btn.linkedin {
    background: #0077b5;
}

.mht-project-detail-share-btn.whatsapp {
    background: #25D366;
}

.mht-project-detail-share-btn:hover {
    transform: translateY(-3px);
    filter: brightness(1.1);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .mht-project-detail-wrapper {
        grid-template-columns: 1fr;
    }
    
    .mht-project-detail-info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-project-detail-section {
        padding: 20px 0 60px 0;
    }
    
    .mht-project-detail-main {
        padding: 25px;
    }
    
    .mht-project-detail-title {
        font-size: 1.5rem;
    }
    
    .mht-project-detail-image-wrapper {
        height: 300px;
    }
    
    .mht-project-detail-info-grid {
        grid-template-columns: 1fr;
    }
    
    .mht-project-detail-share {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .mht-project-detail-section {
        padding: 15px 0 50px 0;
    }
    
    .mht-project-detail-main {
        padding: 20px;
    }
    
    .mht-project-detail-title {
        font-size: 1.3rem;
        flex-direction: column;
        text-align: center;
    }
    
    .mht-project-detail-image-wrapper {
        height: 250px;
    }
}

/* Animation */
.mht-project-detail-main,
.mht-project-detail-sidebar {
    opacity: 0;
    transform: translateY(20px);
    animation: mhtProjectDetailSlideIn 0.5s ease forwards;
}

.mht-project-detail-main {
    animation-delay: 0.1s;
}

.mht-project-detail-sidebar {
    animation-delay: 0.2s;
}

@keyframes mhtProjectDetailSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
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