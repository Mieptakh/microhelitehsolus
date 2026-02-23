<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php';

// Pagination configuration
$items_per_page = 9;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Filter by category
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

// Search query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    // Build query with filters
    $count_sql = "SELECT COUNT(*) as total FROM news WHERE status = 'published'";
    $sql = "SELECT * FROM news WHERE status = 'published'";
    
    $params = [];
    
    // Add category filter
    if (!empty($selected_category)) {
        $sql .= " AND category = :category";
        $count_sql .= " AND category = :category";
        $params[':category'] = $selected_category;
    }
    
    // Add search filter
    if (!empty($search)) {
        $sql .= " AND (title LIKE :search OR excerpt LIKE :search OR content LIKE :search)";
        $count_sql .= " AND (title LIKE :search OR excerpt LIKE :search OR content LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    // Get total count for pagination
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute($params);
    $total_items = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_items / $items_per_page);
    
    // Get news with pagination
    $sql .= " ORDER BY date_published DESC LIMIT :offset, :items_per_page";
    
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    $news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all categories for filter
    $cat_stmt = $pdo->query("SELECT DISTINCT category FROM news WHERE status = 'published' ORDER BY category");
    $categories = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);
    
} catch (PDOException $e) {
    $error = "Kesalahan database: " . $e->getMessage();
    error_log("Error fetching news: " . $e->getMessage());
}
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<style>
/* ===== MHT NEWS PAGE STYLES - WITH CUSTOM SCROLLBAR ===== */
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
    --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.15);
    --radius-md: 8px;
    --radius-lg: 16px;
    --radius-xl: 24px;
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

/* Main Section */
.mht-news-page {
    padding: 30px 0 80px 0;
    min-height: 100vh;
    position: relative;
}

.mht-news-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header Section */
.mht-news-header {
    text-align: center;
    margin-bottom: 40px;
}

.mht-news-badge {
    display: inline-block;
    background: var(--primary-light);
    color: var(--primary);
    padding: 6px 20px;
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    margin-bottom: 15px;
    border: 1px solid rgba(156, 39, 176, 0.2);
    text-transform: uppercase;
    animation: fadeIn 1s ease;
}

.mht-news-title {
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 12px;
    line-height: 1.2;
    animation: fadeInUp 1s ease 0.2s both;
}

.mht-news-title span {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.mht-news-subtitle {
    font-size: 1rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 1s ease 0.4s both;
}

/* Filter & Search Section */
.mht-news-filter {
    background: white;
    border-radius: var(--radius-lg);
    padding: 25px;
    margin-bottom: 40px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
    justify-content: space-between;
}

.mht-filter-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    flex: 1;
}

.mht-filter-btn {
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-muted);
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-block;
}

.mht-filter-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
}

.mht-filter-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border-color: transparent;
}

.mht-search-form {
    display: flex;
    gap: 10px;
    min-width: 300px;
}

.mht-search-input {
    flex: 1;
    padding: 10px 16px;
    border: 1px solid var(--border-color);
    border-radius: 30px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    transition: var(--transition);
}

.mht-search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.mht-search-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.mht-search-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
}

/* News Grid */
.mht-news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

/* News Card */
.mht-news-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    border: 1px solid var(--border-color);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease forwards;
}

.mht-news-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary);
}

.mht-news-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 0;
    background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    transition: height 0.3s ease;
    z-index: 2;
}

.mht-news-card:hover::before {
    height: 100%;
}

/* Card Image */
.mht-news-card-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.mht-news-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.mht-news-card:hover .mht-news-card-image img {
    transform: scale(1.1);
}

.mht-news-category {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.mht-news-date-badge {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    color: white;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 5px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.mht-news-date-badge i {
    color: var(--primary);
}

/* Card Content */
.mht-news-card-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.mht-news-card-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
    line-height: 1.4;
    transition: var(--transition);
}

.mht-news-card:hover .mht-news-card-title {
    color: var(--primary);
}

.mht-news-card-excerpt {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 20px;
    flex: 1;
}

/* Card Meta */
.mht-news-card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
    margin-bottom: 15px;
}

.mht-news-author {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.mht-news-author i {
    color: var(--primary);
}

.mht-news-read-time {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.mht-news-read-time i {
    color: var(--primary);
}

/* Read More Button */
.mht-news-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: var(--transition);
    padding: 8px 0;
    position: relative;
    width: fit-content;
}

.mht-news-read-more::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    transition: width 0.3s ease;
}

.mht-news-read-more:hover {
    gap: 12px;
}

.mht-news-read-more:hover::after {
    width: 100%;
}

/* Pagination */
.mht-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 50px;
}

.mht-pagination-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    border: 1px solid var(--border-color);
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: var(--transition);
    font-weight: 500;
}

.mht-pagination-btn:hover {
    background: var(--primary-light);
    border-color: var(--primary);
    color: var(--primary);
    transform: scale(1.1);
}

.mht-pagination-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border-color: transparent;
}

.mht-pagination-prev,
.mht-pagination-next {
    width: auto;
    padding: 0 20px;
    border-radius: 30px;
    gap: 8px;
}

.mht-pagination-dots {
    color: var(--text-muted);
    padding: 0 5px;
}

/* Empty State */
.mht-news-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 2px dashed var(--primary-light);
}

.mht-news-empty-icon {
    font-size: 4rem;
    color: var(--primary-light);
    margin-bottom: 20px;
}

.mht-news-empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 10px;
}

.mht-news-empty-text {
    color: var(--text-muted);
    margin-bottom: 25px;
}

.mht-news-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 30px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 500;
    transition: var(--transition);
}

.mht-news-empty-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.3);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Staggered animation for cards */
.mht-news-card:nth-child(1) { animation-delay: 0.1s; }
.mht-news-card:nth-child(2) { animation-delay: 0.15s; }
.mht-news-card:nth-child(3) { animation-delay: 0.2s; }
.mht-news-card:nth-child(4) { animation-delay: 0.25s; }
.mht-news-card:nth-child(5) { animation-delay: 0.3s; }
.mht-news-card:nth-child(6) { animation-delay: 0.35s; }
.mht-news-card:nth-child(7) { animation-delay: 0.4s; }
.mht-news-card:nth-child(8) { animation-delay: 0.45s; }
.mht-news-card:nth-child(9) { animation-delay: 0.5s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .mht-news-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-news-filter {
        flex-direction: column;
        align-items: stretch;
    }
    
    .mht-search-form {
        width: 100%;
    }
    
    .mht-news-grid {
        grid-template-columns: 1fr;
        max-width: 450px;
        margin: 0 auto 40px;
    }
    
    .mht-pagination {
        flex-wrap: wrap;
    }
}

@media (max-width: 576px) {
    .mht-news-header h1 {
        font-size: 2rem;
    }
    
    .mht-filter-categories {
        justify-content: center;
    }
    
    .mht-pagination-prev span,
    .mht-pagination-next span {
        display: none;
    }
    
    .mht-pagination-prev,
    .mht-pagination-next {
        width: 45px;
        padding: 0;
        justify-content: center;
    }
}
</style>

<!-- News Page Section -->
<section class="mht-news-page">
    <div class="mht-news-container">
        <!-- Header -->
        <div class="mht-news-header">
            <span class="mht-news-badge">BERITA & ARTIKEL</span>
            <h1 class="mht-news-title">Berita <span>Terbaru</span></h1>
            <p class="mht-news-subtitle">Ikuti perkembangan dan informasi terbaru dari PT MicroHelix Tech Solutions</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="mht-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter & Search -->
        <div class="mht-news-filter">
            <div class="mht-filter-categories">
                <a href="berita" class="mht-filter-btn <?php echo empty($selected_category) ? 'active' : ''; ?>">
                    Semua
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="berita?category=<?php echo urlencode($category); ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                       class="mht-filter-btn <?php echo $selected_category === $category ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <form action="berita" method="GET" class="mht-search-form">
                <?php if (!empty($selected_category)): ?>
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($selected_category); ?>">
                <?php endif; ?>
                <input type="text" name="search" class="mht-search-input" 
                       placeholder="Cari berita..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="mht-search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- News Grid -->
        <?php if (empty($news_list) && empty($error)): ?>
            <div class="mht-news-empty">
                <div class="mht-news-empty-icon">
                    <i class="far fa-newspaper"></i>
                </div>
                <h3 class="mht-news-empty-title">Belum Ada Berita</h3>
                <p class="mht-news-empty-text">
                    <?php if (!empty($search) || !empty($selected_category)): ?>
                        Tidak ditemukan berita dengan kriteria pencarian Anda.
                    <?php else: ?>
                        Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.
                    <?php endif; ?>
                </p>
                <?php if (!empty($search) || !empty($selected_category)): ?>
                    <a href="berita" class="mht-news-empty-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Semua Berita</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php elseif (!empty($news_list)): ?>
            <div class="mht-news-grid">
                <?php foreach ($news_list as $news): 
                    $title = htmlspecialchars($news['title']);
                    $slug = htmlspecialchars($news['slug']);
                    $excerpt = htmlspecialchars($news['excerpt'] ?: substr(strip_tags($news['content']), 0, 150) . '...');
                    $category = htmlspecialchars($news['category']);
                    $author = htmlspecialchars($news['author']);
                    $image = htmlspecialchars($news['image']);
                    $read_time = (int)$news['read_time'];
                    $date = date('d M Y', strtotime($news['date_published']));
                ?>
                <div class="mht-news-card">
                    <div class="mht-news-card-image">
                        <img src="/webmaster/uploads/<?php echo $image; ?>" 
                             alt="<?php echo $title; ?>" 
                             onerror="this.src='/webmaster/uploads/default-news.jpg'">
                        <span class="mht-news-category"><?php echo $category; ?></span>
                        <span class="mht-news-date-badge">
                            <i class="far fa-calendar"></i>
                            <?php echo $date; ?>
                        </span>
                    </div>
                    <div class="mht-news-card-content">
                        <h3 class="mht-news-card-title"><?php echo $title; ?></h3>
                        <p class="mht-news-card-excerpt"><?php echo $excerpt; ?></p>
                        
                        <div class="mht-news-card-meta">
                            <span class="mht-news-author">
                                <i class="far fa-user"></i>
                                <?php echo $author; ?>
                            </span>
                            <span class="mht-news-read-time">
                                <i class="far fa-clock"></i>
                                <?php echo $read_time; ?> menit
                            </span>
                        </div>
                        
                        <!-- Link ke halaman detail berita dengan format mydomain.com/detail-berita?slug=nama-berita -->
                        <a href="detail-berita?slug=<?php echo urlencode($slug); ?>" class="mht-news-read-more">
                            <span>Baca Selengkapnya</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mht-pagination">
                    <?php if ($current_page > 1): ?>
                        <a href="berita?page=<?php echo $current_page - 1; ?><?php echo !empty($selected_category) ? '&category=' . urlencode($selected_category) : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="mht-pagination-btn mht-pagination-prev">
                            <i class="fas fa-chevron-left"></i>
                            <span>Sebelumnya</span>
                        </a>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);
                    
                    if ($start_page > 1) {
                        echo '<a href="berita?page=1' . (!empty($selected_category) ? '&category=' . urlencode($selected_category) : '') . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="mht-pagination-btn">1</a>';
                        if ($start_page > 2) {
                            echo '<span class="mht-pagination-dots">...</span>';
                        }
                    }
                    
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $active_class = $i == $current_page ? 'active' : '';
                        echo '<a href="berita?page=' . $i . (!empty($selected_category) ? '&category=' . urlencode($selected_category) : '') . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="mht-pagination-btn ' . $active_class . '">' . $i . '</a>';
                    }
                    
                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<span class="mht-pagination-dots">...</span>';
                        }
                        echo '<a href="berita?page=' . $total_pages . (!empty($selected_category) ? '&category=' . urlencode($selected_category) : '') . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="mht-pagination-btn">' . $total_pages . '</a>';
                    }
                    ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="berita?page=<?php echo $current_page + 1; ?><?php echo !empty($selected_category) ? '&category=' . urlencode($selected_category) : ''; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="mht-pagination-btn mht-pagination-next">
                            <span>Selanjutnya</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk anchor links
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

    // Font Awesome fallback check
    function checkFontAwesome() {
        var testElement = document.createElement('span');
        testElement.className = 'fas';
        testElement.style.display = 'none';
        document.body.appendChild(testElement);
        
        var computedStyle = window.getComputedStyle(testElement);
        var fontFamily = computedStyle.getPropertyValue('font-family');
        
        if (!fontFamily.includes('Font Awesome')) {
            console.log('Font Awesome not loaded, loading fallback...');
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://use.fontawesome.com/releases/v6.0.0/css/all.css';
            document.head.appendChild(link);
        }
        
        document.body.removeChild(testElement);
    }
    
    setTimeout(checkFontAwesome, 100);
});
</script>

<!-- Fallback untuk browser tanpa JavaScript -->
<noscript>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>