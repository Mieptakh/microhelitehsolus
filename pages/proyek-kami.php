<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php';
?>

<!-- Projects Section - Custom dengan prefix mht-projects untuk konsistensi -->
<section id="mht-projects-section" class="mht-projects-section">
    <!-- Background Pattern - Full coverage -->
    <div class="mht-projects-bg-pattern"></div>
    
    <div class="mht-projects-container">
        <!-- Section Header -->
        <div class="mht-projects-header-wrapper">
            <span class="mht-projects-badge">PORTOFOLIO KAMI</span>
            <h1 class="mht-projects-title">Semua <span>Proyek Kami</span></h1>
            <p class="mht-projects-subtitle">Inilah seluruh proyek inovatif yang telah kami kembangkan untuk berbagai klien dari berbagai industri</p>
        </div>

        <div class="mht-projects-grid">
            <?php
            try {
                $query = "SELECT * FROM projects ORDER BY date_added DESC";
                $stmt = $pdo->query($query);

                if ($stmt->rowCount() === 0) {
                    echo "<div class='mht-projects-empty'>";
                    echo "<i class='fa-regular fa-folder-open'></i>";
                    echo "<span>Tidak ada proyek yang tersedia saat ini.</span>";
                    echo "</div>";
                } else {
                    while ($project = $stmt->fetch(PDO::FETCH_ASSOC)):
                        $projectSlug = htmlspecialchars($project['slug']);
                        $projectName = htmlspecialchars($project['name']);
                        $projectDesc = htmlspecialchars($project['description']);
                        $projectIcon = htmlspecialchars($project['icon']);
                        $projectImage = htmlspecialchars($project['image']);
                        $projectUrl = !empty($project['url']) ? htmlspecialchars($project['url']) : '';
                        
                        // Format description - tidak terpotong ambigu
                        $cleanDesc = strip_tags($projectDesc);
                        if (strlen($cleanDesc) > 120) {
                            // Cari titik terakhir dalam 120 karakter pertama
                            $lastPeriod = strrpos(substr($cleanDesc, 0, 120), '.');
                            if ($lastPeriod !== false) {
                                $displayDesc = substr($cleanDesc, 0, $lastPeriod + 1);
                            } else {
                                // Jika tidak ada titik, cari spasi terakhir
                                $lastSpace = strrpos(substr($cleanDesc, 0, 117), ' ');
                                if ($lastSpace !== false) {
                                    $displayDesc = substr($cleanDesc, 0, $lastSpace) . '...';
                                } else {
                                    $displayDesc = substr($cleanDesc, 0, 117) . '...';
                                }
                            }
                        } else {
                            $displayDesc = $cleanDesc;
                        }
            ?>
            <div class="mht-projects-card">
                <div class="mht-projects-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $projectImage; ?>" 
                         alt="<?php echo $projectName; ?>" 
                         loading="lazy" 
                         class="mht-projects-image" />
                    <div class="mht-projects-image-overlay">
                        <i class="fa-solid fa-<?php echo $projectIcon; ?>"></i>
                    </div>
                </div>
                
                <div class="mht-projects-info">
                    <h3 class="mht-projects-name">
                        <i class="fa-solid fa-<?php echo $projectIcon; ?>"></i> 
                        <?php echo $projectName; ?>
                    </h3>
                    
                    <p class="mht-projects-description">
                        <?php echo $displayDesc; ?>
                    </p>
                    
                    <div class="mht-projects-actions">
                        <a href="detail-proyek?slug=<?php echo urlencode($projectSlug); ?>" 
                           class="mht-projects-btn-detail" 
                           aria-label="Detail proyek <?php echo $projectName; ?>">
                            <i class="fa-regular fa-eye"></i>
                            <span>Detail Proyek</span>
                        </a>
                        
                        <?php if ($projectUrl): ?>
                        <a href="<?php echo $projectUrl; ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="mht-projects-btn-visit" 
                           aria-label="Kunjungi proyek <?php echo $projectName; ?>">
                            <i class="fa-regular fa-arrow-up-right-from-square"></i>
                            <span>Kunjungi</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                }
            } catch (PDOException $e) {
                echo "<div class='mht-projects-error'>";
                echo "<i class='fa-solid fa-circle-exclamation'></i>";
                echo "<span>Gagal memuat data proyek: " . htmlspecialchars($e->getMessage()) . "</span>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>

<style>
/* ===== MHT PROJECTS STYLES - NO WHITE SPACE ===== */
/* Import Font Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* Reset total untuk menghilangkan area putih */
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

/* CSS Variables - Sinkron dengan header dan FAQ */
:root {
    --mht-projects-primary: #9C27B0;
    --mht-projects-primary-dark: #7B1FA2;
    --mht-projects-primary-light: rgba(156, 39, 176, 0.1);
    --mht-projects-text-dark: #121212;
    --mht-projects-text-body: #333333;
    --mht-projects-text-muted: #666666;
    --mht-projects-bg-light: #f8f8fc;
    --mht-projects-bg-white: #ffffff;
    --mht-projects-border: rgba(0, 0, 0, 0.05);
    --mht-projects-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-projects-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-projects-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-projects-radius: 20px;
}

/* Main Section - Full coverage */
.mht-projects-section {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    width: 100%;
    background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    position: relative;
    overflow-x: hidden;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 30px 0 80px 0;
    margin: 0;
}

/* Background Pattern - Full coverage */
.mht-projects-bg-pattern {
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
.mht-projects-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Header Section - Sinkron dengan FAQ */
.mht-projects-header-wrapper {
    text-align: center;
    margin-bottom: 40px;
}

.mht-projects-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--mht-projects-primary-light), rgba(156, 39, 176, 0.05));
    color: var(--mht-projects-primary);
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

.mht-projects-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--mht-projects-text-dark);
    margin-bottom: 12px;
    line-height: 1.2;
    font-family: 'Poppins', sans-serif;
}

.mht-projects-title span {
    background: linear-gradient(135deg, var(--mht-projects-primary), var(--mht-projects-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    font-family: 'Poppins', sans-serif;
}

.mht-projects-subtitle {
    font-size: 1rem;
    color: var(--mht-projects-text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

/* Projects Grid - No gaps */
.mht-projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    width: 100%;
}

/* Project Card */
.mht-projects-card {
    background: var(--mht-projects-bg-white);
    border-radius: var(--mht-projects-radius);
    overflow: hidden;
    box-shadow: var(--mht-projects-shadow-sm);
    transition: var(--mht-projects-transition);
    border: 1px solid var(--mht-projects-border);
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

.mht-projects-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 0;
    background: linear-gradient(to bottom, var(--mht-projects-primary), var(--mht-projects-primary-dark));
    transition: height 0.3s ease;
    z-index: 2;
}

.mht-projects-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--mht-projects-shadow-hover);
}

.mht-projects-card:hover::before {
    height: 100%;
}

/* Image Wrapper */
.mht-projects-image-wrapper {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
}

.mht-projects-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.mht-projects-card:hover .mht-projects-image {
    transform: scale(1.05);
}

.mht-projects-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mht-projects-card:hover .mht-projects-image-overlay {
    opacity: 1;
}

.mht-projects-image-overlay i {
    color: white;
    font-size: 2rem;
    background: rgba(156, 39, 176, 0.3);
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Info Section */
.mht-projects-info {
    padding: 20px 18px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.mht-projects-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--mht-projects-text-dark);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Poppins', sans-serif;
}

.mht-projects-name i {
    color: var(--mht-projects-primary);
    font-size: 1.1rem;
    width: 22px;
}

.mht-projects-description {
    font-size: 0.9rem;
    color: var(--mht-projects-text-muted);
    line-height: 1.6;
    margin-bottom: 18px;
    flex: 1;
    font-family: 'Poppins', sans-serif;
}

/* Actions */
.mht-projects-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: auto;
}

.mht-projects-btn-detail,
.mht-projects-btn-visit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: var(--mht-projects-transition);
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    flex: 1;
    min-width: 100px;
}

.mht-projects-btn-detail {
    background: var(--mht-projects-primary-light);
    color: var(--mht-projects-primary-dark);
    border: 1px solid rgba(156, 39, 176, 0.2);
}

.mht-projects-btn-detail:hover {
    background: var(--mht-projects-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
}

.mht-projects-btn-detail:hover i {
    color: white;
}

.mht-projects-btn-visit {
    background: linear-gradient(135deg, var(--mht-projects-primary), var(--mht-projects-primary-dark));
    color: white;
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
}

.mht-projects-btn-visit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(156, 39, 176, 0.4);
}

.mht-projects-btn-detail i,
.mht-projects-btn-visit i {
    font-size: 0.85rem;
    transition: var(--mht-projects-transition);
}

.mht-projects-btn-detail:hover i {
    transform: translateX(-2px);
}

.mht-projects-btn-visit:hover i {
    transform: translate(2px, -2px);
}

/* Empty State - Full width */
.mht-projects-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: var(--mht-projects-bg-white);
    border-radius: var(--mht-projects-radius);
    color: var(--mht-projects-text-muted);
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
    border: 2px dashed rgba(156, 39, 176, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.mht-projects-empty i {
    font-size: 3rem;
    color: var(--mht-projects-primary);
    opacity: 0.5;
}

/* Error Message - Full width */
.mht-projects-error {
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
}

.mht-projects-error i {
    font-size: 1.3rem;
    color: #B91C1C;
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 992px) {
    .mht-projects-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .mht-projects-section {
        padding: 20px 0 60px 0;
    }
    
    .mht-projects-container {
        padding: 0 15px;
    }
    
    .mht-projects-header-wrapper {
        margin-bottom: 30px;
    }
    
    .mht-projects-badge {
        margin-bottom: 10px;
        padding: 5px 16px;
        font-size: 0.75rem;
    }
    
    .mht-projects-title {
        font-size: 1.8rem;
    }
    
    .mht-projects-subtitle {
        font-size: 0.95rem;
    }
    
    .mht-projects-grid {
        grid-template-columns: 1fr;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .mht-projects-image-wrapper {
        height: 180px;
    }
    
    .mht-projects-info {
        padding: 18px 15px 15px;
    }
    
    .mht-projects-name {
        font-size: 1rem;
    }
    
    .mht-projects-actions {
        flex-direction: column;
    }
    
    .mht-projects-btn-detail,
    .mht-projects-btn-visit {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .mht-projects-section {
        padding: 15px 0 50px 0;
    }
    
    .mht-projects-title {
        font-size: 1.5rem;
    }
    
    .mht-projects-badge {
        font-size: 0.7rem;
        padding: 4px 14px;
    }
    
    .mht-projects-image-wrapper {
        height: 160px;
    }
}

/* Animation on Scroll */
.mht-projects-card {
    opacity: 0;
    transform: translateY(20px);
    animation: mhtProjectsSlideIn 0.5s ease forwards;
}

.mht-projects-card:nth-child(1) { animation-delay: 0.1s; }
.mht-projects-card:nth-child(2) { animation-delay: 0.15s; }
.mht-projects-card:nth-child(3) { animation-delay: 0.2s; }
.mht-projects-card:nth-child(4) { animation-delay: 0.25s; }
.mht-projects-card:nth-child(5) { animation-delay: 0.3s; }
.mht-projects-card:nth-child(6) { animation-delay: 0.35s; }
.mht-projects-card:nth-child(7) { animation-delay: 0.4s; }
.mht-projects-card:nth-child(8) { animation-delay: 0.45s; }

@keyframes mhtProjectsSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect tambahan */
.mht-projects-card:hover .mht-projects-name i {
    animation: mhtProjectsIconBounce 0.5s ease;
}

@keyframes mhtProjectsIconBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}
</style>

<?php include 'includes/footer.php'; ?>