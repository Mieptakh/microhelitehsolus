<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php'; // Koneksi MySQL

// Ambil data testimonial dari database MySQL
$testimonials = [];
$error_message = '';

try {
    // Cek apakah tabel testimonials ada
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'testimonials'");
    if ($tableCheck->rowCount() == 0) {
        // Tabel tidak ada, tampilkan pesan error yang lebih friendly
        $error_message = 'Tabel testimonials belum tersedia. Silakan import file testimonials.sql terlebih dahulu.';
    } else {
        // Ambil data testimonial
        $query = "SELECT id, name, role, message, rating, DATE_FORMAT(date_added, '%d %M %Y') as formatted_date 
                  FROM testimonials 
                  ORDER BY date_added DESC";
        $stmt = $pdo->query($query);
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
    error_log("Error fetching testimonials: " . $e->getMessage());
}
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<!-- Testimonials Section -->
<section id="mht-testimonials-section" class="mht-testimonials-section">
    <!-- Background Pattern -->
    <div class="mht-testimonials-bg-pattern"></div>
    
    <div class="mht-testimonials-container">
        <!-- Section Header -->
        <div class="mht-testimonials-header-wrapper">
            <span class="mht-testimonials-badge">TESTIMONIALS</span>
            <h1 class="mht-testimonials-title">Apa Kata <span>Mereka?</span></h1>
            <p class="mht-testimonials-subtitle">Cerita nyata dari klien & partner bersama <strong>PT MicroHelix Tech Solutions</strong> yang telah merasakan manfaat layanan kami</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="mht-testimonials-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <div class="mht-testimonials-grid">
            <?php if (empty($testimonials) && empty($error_message)): ?>
                <div class="mht-testimonials-empty">
                    <i class="far fa-comment-dots"></i>
                    <span>Belum ada testimoni yang tersedia.</span>
                </div>
            <?php else: ?>
                <?php foreach ($testimonials as $testimonial): 
                    $name = htmlspecialchars($testimonial['name']);
                    $role = htmlspecialchars($testimonial['role']);
                    $message = htmlspecialchars($testimonial['message']);
                    $rating = (int)$testimonial['rating'];
                    $date = htmlspecialchars($testimonial['formatted_date']);
                    
                    // Format message - jika terlalu panjang, potong dengan rapi
                    $displayMessage = $message;
                    if (strlen($message) > 150) {
                        $lastPeriod = strrpos(substr($message, 0, 150), '.');
                        if ($lastPeriod !== false) {
                            $displayMessage = substr($message, 0, $lastPeriod + 1);
                        } else {
                            $lastSpace = strrpos(substr($message, 0, 147), ' ');
                            if ($lastSpace !== false) {
                                $displayMessage = substr($message, 0, $lastSpace) . '...';
                            } else {
                                $displayMessage = substr($message, 0, 147) . '...';
                            }
                        }
                    }
                    
                    // Ambil inisial untuk avatar
                    $initials = '';
                    $nameParts = explode(' ', $name);
                    if (count($nameParts) > 0) {
                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                        if (count($nameParts) > 1) {
                            $initials .= strtoupper(substr($nameParts[1], 0, 1));
                        }
                    }
                    
                    // Batasi inisial maksimal 2 huruf
                    if (strlen($initials) > 2) {
                        $initials = substr($initials, 0, 2);
                    }
                ?>
                <div class="mht-testimonials-card">
                    <div class="mht-testimonials-card-inner">
                        <!-- Quote Icon -->
                        <div class="mht-testimonials-quote-icon">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        
                        <div class="mht-testimonials-header">
                            <div class="mht-testimonials-avatar-wrapper">
                                <div class="mht-testimonials-avatar">
                                    <?php echo $initials ?: 'U'; ?>
                                </div>
                            </div>
                            <div class="mht-testimonials-header-text">
                                <h3 class="mht-testimonials-name"><?php echo $name; ?></h3>
                                <p class="mht-testimonials-role"><?php echo $role; ?></p>
                            </div>
                        </div>

                        <div class="mht-testimonials-message-wrapper">
                            <p class="mht-testimonials-message">
                                "<?php echo $displayMessage; ?>"
                            </p>
                        </div>

                        <div class="mht-testimonials-footer">
                            <div class="mht-testimonials-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $rating): ?>
                                        <i class="fas fa-star mht-testimonials-star-active"></i>
                                    <?php else: ?>
                                        <i class="far fa-star mht-testimonials-star-inactive"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="mht-testimonials-date">
                                <i class="far fa-calendar"></i>
                                <span><?php echo $date; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
/* ===== MHT TESTIMONIALS STYLES - WITH CUSTOM SCROLLBAR ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

/* CSS Variables - Konsisten dengan halaman lain */
:root {
    --mht-testimonials-primary: #9C27B0;
    --mht-testimonials-primary-dark: #7B1FA2;
    --mht-testimonials-primary-light: rgba(156, 39, 176, 0.1);
    --mht-testimonials-accent: #FFD700;
    --mht-testimonials-text-dark: #121212;
    --mht-testimonials-text-body: #333333;
    --mht-testimonials-text-muted: #666666;
    --mht-testimonials-bg-light: #f8f8fc;
    --mht-testimonials-bg-white: #ffffff;
    --mht-testimonials-border: rgba(0, 0, 0, 0.05);
    --mht-testimonials-shadow-sm: 0 5px 20px rgba(0, 0, 0, 0.05);
    --mht-testimonials-shadow-hover: 0 15px 35px rgba(156, 39, 176, 0.15);
    --mht-testimonials-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --mht-testimonials-radius: 20px;
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

/* ===== CUSTOM SCROLLBAR - SAMA PERSIS DENGAN HALAMAN LAIN ===== */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: var(--bg-light);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--mht-testimonials-primary), var(--mht-testimonials-primary-dark));
    border-radius: 6px;
    border: 3px solid var(--bg-light);
    transition: var(--mht-testimonials-transition);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--mht-testimonials-primary-dark);
}

/* Firefox scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--mht-testimonials-primary) var(--bg-light);
}

/* Main Section */
.mht-testimonials-section {
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
.mht-testimonials-bg-pattern {
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
.mht-testimonials-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

/* Header Section */
.mht-testimonials-header-wrapper {
    text-align: center;
    margin-bottom: 40px;
}

.mht-testimonials-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--mht-testimonials-primary-light), rgba(156, 39, 176, 0.05));
    color: var(--mht-testimonials-primary);
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

.mht-testimonials-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--mht-testimonials-text-dark);
    margin-bottom: 12px;
    line-height: 1.2;
    font-family: 'Poppins', sans-serif;
}

.mht-testimonials-title span {
    background: linear-gradient(135deg, var(--mht-testimonials-primary), var(--mht-testimonials-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    font-family: 'Poppins', sans-serif;
}

.mht-testimonials-subtitle {
    font-size: 1rem;
    color: var(--mht-testimonials-text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    font-family: 'Poppins', sans-serif;
}

.mht-testimonials-subtitle strong {
    color: var(--mht-testimonials-primary);
    font-weight: 600;
}

/* Testimonials Grid */
.mht-testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
    width: 100%;
}

/* Testimonial Card */
.mht-testimonials-card {
    background: var(--mht-testimonials-bg-white);
    border-radius: var(--mht-testimonials-radius);
    overflow: hidden;
    box-shadow: var(--mht-testimonials-shadow-sm);
    transition: var(--mht-testimonials-transition);
    border: 1px solid var(--mht-testimonials-border);
    position: relative;
    height: 100%;
    width: 100%;
    opacity: 0;
    transform: translateY(20px);
    animation: mhtTestimonialsSlideIn 0.5s ease forwards;
}

.mht-testimonials-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 0;
    background: linear-gradient(to bottom, var(--mht-testimonials-primary), var(--mht-testimonials-primary-dark));
    transition: height 0.3s ease;
    z-index: 2;
}

.mht-testimonials-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--mht-testimonials-shadow-hover);
}

.mht-testimonials-card:hover::before {
    height: 100%;
}

.mht-testimonials-card-inner {
    padding: 25px 20px 20px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Quote Icon */
.mht-testimonials-quote-icon {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 3rem;
    color: var(--mht-testimonials-primary);
    opacity: 0.1;
    transition: var(--mht-testimonials-transition);
}

.mht-testimonials-card:hover .mht-testimonials-quote-icon {
    opacity: 0.2;
    transform: scale(1.1);
}

/* Header */
.mht-testimonials-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 18px;
    position: relative;
    z-index: 3;
}

.mht-testimonials-avatar-wrapper {
    flex-shrink: 0;
}

.mht-testimonials-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--mht-testimonials-primary), var(--mht-testimonials-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.4rem;
    border: 3px solid white;
    box-shadow: 0 4px 10px rgba(156, 39, 176, 0.2);
    transition: var(--mht-testimonials-transition);
}

.mht-testimonials-card:hover .mht-testimonials-avatar {
    transform: scale(1.05) rotate(5deg);
    box-shadow: 0 8px 20px rgba(156, 39, 176, 0.3);
}

.mht-testimonials-header-text {
    flex: 1;
}

.mht-testimonials-name {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--mht-testimonials-text-dark);
    margin-bottom: 4px;
    font-family: 'Poppins', sans-serif;
    transition: var(--mht-testimonials-transition);
}

.mht-testimonials-card:hover .mht-testimonials-name {
    color: var(--mht-testimonials-primary);
}

.mht-testimonials-role {
    font-size: 0.85rem;
    color: var(--mht-testimonials-text-muted);
    font-family: 'Poppins', sans-serif;
}

/* Message */
.mht-testimonials-message-wrapper {
    flex: 1;
    margin-bottom: 20px;
}

.mht-testimonials-message {
    font-size: 0.95rem;
    color: var(--mht-testimonials-text-body);
    line-height: 1.7;
    font-style: italic;
    font-family: 'Poppins', sans-serif;
}

/* Footer */
.mht-testimonials-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 15px;
    border-top: 1px solid var(--mht-testimonials-border);
}

.mht-testimonials-rating {
    display: flex;
    gap: 3px;
}

.mht-testimonials-star-active {
    color: var(--mht-testimonials-accent);
    font-size: 0.9rem;
}

.mht-testimonials-star-inactive {
    color: #ddd;
    font-size: 0.9rem;
}

.mht-testimonials-date {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--mht-testimonials-primary);
    font-size: 0.8rem;
    font-family: 'Poppins', sans-serif;
}

.mht-testimonials-date i {
    font-size: 0.8rem;
}

/* Empty State */
.mht-testimonials-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: var(--mht-testimonials-bg-white);
    border-radius: var(--mht-testimonials-radius);
    color: var(--mht-testimonials-text-muted);
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
    border: 2px dashed rgba(156, 39, 176, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.mht-testimonials-empty i {
    font-size: 3rem;
    color: var(--mht-testimonials-primary);
    opacity: 0.5;
}

/* Error State */
.mht-testimonials-error {
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

.mht-testimonials-error i {
    font-size: 1.3rem;
    color: #B91C1C;
}

/* Animations */
@keyframes mhtTestimonialsSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Staggered Animation */
.mht-testimonials-card:nth-child(1) { animation-delay: 0.1s; }
.mht-testimonials-card:nth-child(2) { animation-delay: 0.15s; }
.mht-testimonials-card:nth-child(3) { animation-delay: 0.2s; }
.mht-testimonials-card:nth-child(4) { animation-delay: 0.25s; }
.mht-testimonials-card:nth-child(5) { animation-delay: 0.3s; }
.mht-testimonials-card:nth-child(6) { animation-delay: 0.35s; }
.mht-testimonials-card:nth-child(7) { animation-delay: 0.4s; }
.mht-testimonials-card:nth-child(8) { animation-delay: 0.45s; }
.mht-testimonials-card:nth-child(9) { animation-delay: 0.5s; }
.mht-testimonials-card:nth-child(10) { animation-delay: 0.55s; }

/* Hover effect for stars */
.mht-testimonials-card:hover .mht-testimonials-star-active {
    animation: mhtTestimonialsStarPulse 0.5s ease;
}

@keyframes mhtTestimonialsStarPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 992px) {
    .mht-testimonials-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-testimonials-section {
        padding: 20px 0 60px 0;
    }
    
    .mht-testimonials-container {
        padding: 0 15px;
    }
    
    .mht-testimonials-header-wrapper {
        margin-bottom: 30px;
    }
    
    .mht-testimonials-badge {
        margin-bottom: 10px;
        padding: 5px 16px;
        font-size: 0.75rem;
    }
    
    .mht-testimonials-title {
        font-size: 1.8rem;
    }
    
    .mht-testimonials-subtitle {
        font-size: 0.95rem;
    }
    
    .mht-testimonials-grid {
        grid-template-columns: 1fr;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .mht-testimonials-card-inner {
        padding: 20px 18px 18px;
    }
    
    .mht-testimonials-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .mht-testimonials-section {
        padding: 15px 0 50px 0;
    }
    
    .mht-testimonials-title {
        font-size: 1.5rem;
    }
    
    .mht-testimonials-badge {
        font-size: 0.7rem;
        padding: 4px 14px;
    }
    
    .mht-testimonials-header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .mht-testimonials-avatar {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .mht-testimonials-message {
        text-align: center;
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