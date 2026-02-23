<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    // Redirect ke halaman berita jika slug tidak valid
    header('Location: berita');
    exit;
}

$slug = $_GET['slug'];

try {
    // Ambil data berita berdasarkan slug
    $stmt = $pdo->prepare("SELECT * FROM news WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news) {
        // Redirect ke halaman berita jika berita tidak ditemukan
        header('Location: berita');
        exit;
    }

    // Update views count
    $updateViews = $pdo->prepare("UPDATE news SET views = views + 1 WHERE id = ?");
    $updateViews->execute([$news['id']]);

    // Ambil berita terkait (berdasarkan kategori yang sama)
    $relatedStmt = $pdo->prepare("SELECT * FROM news WHERE category = ? AND id != ? AND status = 'published' ORDER BY date_published DESC LIMIT 3");
    $relatedStmt->execute([$news['category'], $news['id']]);
    $relatedNews = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Ambil komentar (jika ada tabel comments)
    $comments = [];
    try {
        $commentStmt = $pdo->prepare("SELECT * FROM comments WHERE news_id = ? AND status = 'approved' ORDER BY created_at DESC");
        $commentStmt->execute([$news['id']]);
        $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Table comments mungkin belum ada, abaikan
    }

} catch (PDOException $e) {
    die("Kesalahan database: " . htmlspecialchars($e->getMessage()));
}

// Sanitasi data
$title = htmlspecialchars($news['title']);
$content = $news['content']; // Jangan di-escape karena mengandung HTML
$excerpt = htmlspecialchars($news['excerpt']);
$category = htmlspecialchars($news['category']);
$author = htmlspecialchars($news['author']);
$image = htmlspecialchars($news['image']);
$read_time = (int)$news['read_time'];
$views = (int)$news['views'];
$date_published = date('d F Y', strtotime($news['date_published']));
$date_updated = !empty($news['date_updated']) ? date('d F Y', strtotime($news['date_updated'])) : null;

// Meta tags untuk SEO
$meta_description = $excerpt ?: substr(strip_tags($content), 0, 160);
$meta_keywords = $category . ', MicroHelix, berita, artikel, teknologi';
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<!-- Meta Tags for SEO -->
<meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
<meta property="og:title" content="<?php echo $title; ?> - MicroHelix News">
<meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
<meta property="og:image" content="/webmaster/uploads/<?php echo $image; ?>">
<meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:card" content="summary_large_image">

<style>
/* ===== MHT NEWS DETAIL STYLES - WITH CUSTOM SCROLLBAR ===== */
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
.mht-news-detail {
    padding: 30px 0 80px 0;
    min-height: 100vh;
    position: relative;
}

.mht-news-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Back Button */
.mht-news-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: white;
    color: var(--primary);
    text-decoration: none;
    border-radius: var(--radius-full);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 30px;
    border: 1px solid var(--border-color);
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.mht-news-back:hover {
    background: var(--primary-light);
    transform: translateX(-5px);
}

/* Main Content Wrapper */
.mht-news-wrapper {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 30px;
}

/* Main Content */
.mht-news-main {
    background: white;
    border-radius: var(--radius-lg);
    padding: 35px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease 0.1s forwards;
}

.mht-news-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
}

/* Header */
.mht-news-header {
    margin-bottom: 25px;
}

.mht-news-category {
    display: inline-block;
    background: var(--primary-light);
    color: var(--primary);
    padding: 5px 15px;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.mht-news-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.3;
    margin-bottom: 20px;
}

/* Meta Info */
.mht-news-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 15px 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 25px;
}

.mht-news-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.mht-news-meta-item i {
    color: var(--primary);
    font-size: 1rem;
}

.mht-news-meta-item strong {
    color: var(--text-dark);
    font-weight: 600;
    margin-right: 3px;
}

/* Featured Image */
.mht-news-image-wrapper {
    position: relative;
    width: 100%;
    height: 400px;
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: var(--shadow-lg);
}

.mht-news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.mht-news-image-wrapper:hover .mht-news-image {
    transform: scale(1.05);
}

.mht-news-image-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    color: white;
    padding: 15px 20px;
    font-size: 0.85rem;
    font-style: italic;
}

/* Content */
.mht-news-content {
    font-size: 1rem;
    line-height: 1.8;
    color: var(--text-body);
    margin-bottom: 40px;
}

.mht-news-content h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 30px 0 15px;
}

.mht-news-content h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 25px 0 10px;
}

.mht-news-content p {
    margin-bottom: 20px;
}

.mht-news-content ul, 
.mht-news-content ol {
    margin-bottom: 20px;
    padding-left: 25px;
}

.mht-news-content li {
    margin-bottom: 8px;
}

.mht-news-content blockquote {
    background: var(--primary-light);
    border-left: 4px solid var(--primary);
    padding: 20px;
    margin: 25px 0;
    font-style: italic;
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
}

.mht-news-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    margin: 20px 0;
}

.mht-news-content a {
    color: var(--primary);
    text-decoration: underline;
    transition: var(--transition);
}

.mht-news-content a:hover {
    color: var(--primary-dark);
}

/* Tags */
.mht-news-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.mht-news-tag {
    padding: 5px 15px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 500;
    transition: var(--transition);
}

.mht-news-tag:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

/* Share Buttons */
.mht-news-share {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: var(--radius-lg);
    align-items: center;
}

.mht-news-share-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-right: 10px;
}

.mht-news-share-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: var(--transition);
}

.mht-news-share-btn.facebook {
    background: #1877f2;
}

.mht-news-share-btn.twitter {
    background: #000000;
}

.mht-news-share-btn.linkedin {
    background: #0077b5;
}

.mht-news-share-btn.whatsapp {
    background: #25D366;
}

.mht-news-share-btn.telegram {
    background: #0088cc;
}

.mht-news-share-btn:hover {
    transform: translateY(-5px) scale(1.1);
}

/* Author Box */
.mht-news-author-box {
    display: flex;
    gap: 20px;
    padding: 25px;
    background: var(--bg-light);
    border-radius: var(--radius-lg);
    margin-bottom: 40px;
    border: 1px solid var(--border-color);
}

.mht-news-author-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 600;
    flex-shrink: 0;
}

.mht-news-author-info h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.mht-news-author-bio {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 10px;
}

.mht-news-author-social {
    display: flex;
    gap: 10px;
}

.mht-news-author-social a {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.mht-news-author-social a:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

/* Comments Section */
.mht-news-comments {
    background: white;
    border-radius: var(--radius-lg);
    padding: 30px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    margin-top: 30px;
}

.mht-news-comments-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-news-comments-title i {
    color: var(--primary);
}

.mht-comment {
    display: flex;
    gap: 15px;
    padding: 20px 0;
    border-bottom: 1px solid var(--border-color);
}

.mht-comment:last-child {
    border-bottom: none;
}

.mht-comment-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.mht-comment-content {
    flex: 1;
}

.mht-comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.mht-comment-name {
    font-weight: 600;
    color: var(--text-dark);
}

.mht-comment-date {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.mht-comment-text {
    font-size: 0.95rem;
    color: var(--text-body);
    line-height: 1.7;
}

.mht-comment-reply {
    margin-top: 10px;
    color: var(--primary);
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Comment Form */
.mht-comment-form {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid var(--border-color);
}

.mht-comment-form-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 20px;
}

.mht-form-group {
    margin-bottom: 20px;
}

.mht-form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-dark);
    font-size: 0.9rem;
}

.mht-form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-family: 'Poppins', sans-serif;
    font-size: 0.95rem;
    transition: var(--transition);
}

.mht-form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-light);
}

.mht-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.mht-form-btn {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: var(--radius-full);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.mht-form-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.3);
}

/* Sidebar */
.mht-news-sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.mht-sidebar-widget {
    background: white;
    border-radius: var(--radius-lg);
    padding: 25px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease 0.2s forwards;
}

.mht-sidebar-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-color);
}

.mht-sidebar-title i {
    color: var(--primary);
}

/* Related News */
.mht-related-item {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px dashed var(--border-color);
}

.mht-related-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.mht-related-image {
    width: 70px;
    height: 70px;
    border-radius: var(--radius-md);
    object-fit: cover;
    flex-shrink: 0;
}

.mht-related-content {
    flex: 1;
}

.mht-related-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
    line-height: 1.4;
    transition: var(--transition);
    display: block;
    text-decoration: none;
}

.mht-related-title:hover {
    color: var(--primary);
}

.mht-related-date {
    font-size: 0.75rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}

.mht-related-date i {
    color: var(--primary);
}

/* Categories */
.mht-category-list {
    list-style: none;
}

.mht-category-item {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px dashed var(--border-color);
}

.mht-category-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.mht-category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--text-body);
    text-decoration: none;
    transition: var(--transition);
}

.mht-category-link:hover {
    color: var(--primary);
    transform: translateX(5px);
}

.mht-category-count {
    background: var(--primary-light);
    color: var(--primary);
    padding: 2px 8px;
    border-radius: var(--radius-full);
    font-size: 0.7rem;
}

/* Popular Posts */
.mht-popular-item {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px dashed var(--border-color);
}

.mht-popular-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.mht-popular-number {
    width: 25px;
    height: 25px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
    flex-shrink: 0;
}

.mht-popular-content {
    flex: 1;
}

.mht-popular-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 3px;
    line-height: 1.4;
    display: block;
    text-decoration: none;
}

.mht-popular-title:hover {
    color: var(--primary);
}

.mht-popular-meta {
    font-size: 0.7rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-popular-meta i {
    color: var(--primary);
}

/* Newsletter */
.mht-newsletter-text {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 20px;
    line-height: 1.6;
}

.mht-newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.mht-newsletter-input {
    padding: 12px 16px;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-family: 'Poppins', sans-serif;
    transition: var(--transition);
}

.mht-newsletter-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px var(--primary-light);
}

.mht-newsletter-btn {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 12px;
    border-radius: var(--radius-md);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.mht-newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(156, 39, 176, 0.3);
}

/* Animations */
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

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .mht-news-wrapper {
        grid-template-columns: 1fr;
    }
    
    .mht-news-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-news-detail {
        padding: 20px 0 60px 0;
    }
    
    .mht-news-main {
        padding: 25px;
    }
    
    .mht-news-title {
        font-size: 1.8rem;
    }
    
    .mht-news-image-wrapper {
        height: 300px;
    }
    
    .mht-news-meta {
        gap: 15px;
    }
    
    .mht-news-author-box {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .mht-news-author-social {
        justify-content: center;
    }
    
    .mht-comment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}

@media (max-width: 576px) {
    .mht-news-detail {
        padding: 15px 0 50px 0;
    }
    
    .mht-news-main {
        padding: 20px;
    }
    
    .mht-news-title {
        font-size: 1.5rem;
    }
    
    .mht-news-image-wrapper {
        height: 250px;
    }
    
    .mht-news-share {
        justify-content: center;
    }
    
    .mht-news-meta {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<!-- News Detail Section -->
<section class="mht-news-detail">
    <div class="mht-news-container">
        <!-- Back Button -->
        <a href="berita" class="mht-news-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Semua Berita</span>
        </a>

        <div class="mht-news-wrapper">
            <!-- Main Content -->
            <div class="mht-news-main">
                <!-- Header -->
                <div class="mht-news-header">
                    <span class="mht-news-category"><?php echo $category; ?></span>
                    <h1 class="mht-news-title"><?php echo $title; ?></h1>
                </div>

                <!-- Meta Info -->
                <div class="mht-news-meta">
                    <div class="mht-news-meta-item">
                        <i class="far fa-user"></i>
                        <span><strong>Penulis:</strong> <?php echo $author; ?></span>
                    </div>
                    <div class="mht-news-meta-item">
                        <i class="far fa-calendar"></i>
                        <span><strong>Dipublikasikan:</strong> <?php echo $date_published; ?></span>
                    </div>
                    <?php if ($date_updated): ?>
                    <div class="mht-news-meta-item">
                        <i class="far fa-pen-to-square"></i>
                        <span><strong>Diperbarui:</strong> <?php echo $date_updated; ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="mht-news-meta-item">
                        <i class="far fa-clock"></i>
                        <span><strong>Waktu Baca:</strong> <?php echo $read_time; ?> menit</span>
                    </div>
                    <div class="mht-news-meta-item">
                        <i class="far fa-eye"></i>
                        <span><strong>Dilihat:</strong> <?php echo number_format($views); ?> kali</span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mht-news-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $image; ?>" 
                         alt="<?php echo $title; ?>" 
                         class="mht-news-image"
                         onerror="this.src='/webmaster/uploads/default-news.jpg'">
                    <div class="mht-news-image-caption">
                        Ilustrasi: <?php echo $title; ?>
                    </div>
                </div>

                <!-- Content -->
                <div class="mht-news-content">
                    <?php echo $content; ?>
                </div>

                <!-- Tags -->
                <div class="mht-news-tags">
                    <?php 
                    $tags = explode(',', $category);
                    foreach ($tags as $tag): 
                    ?>
                        <span class="mht-news-tag">#<?php echo trim(htmlspecialchars($tag)); ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Share Buttons -->
                <div class="mht-news-share">
                    <span class="mht-news-share-label">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" 
                       class="mht-news-share-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($title); ?>" 
                       target="_blank" 
                       class="mht-news-share-btn twitter">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" 
                       class="mht-news-share-btn linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://wa.me/?text=<?php echo urlencode($title . ' - ' . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" 
                       class="mht-news-share-btn whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://t.me/share/url?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($title); ?>" 
                       target="_blank" 
                       class="mht-news-share-btn telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </div>

                <!-- Author Box -->
                <div class="mht-news-author-box">
                    <div class="mht-news-author-avatar">
                        <?php echo strtoupper(substr($author, 0, 1)); ?>
                    </div>
                    <div class="mht-news-author-info">
                        <h4><?php echo $author; ?></h4>
                        <p class="mht-news-author-bio">
                            Penulis dan kontributor di PT MicroHelix Tech Solutions. 
                            Berpengalaman dalam menulis artikel seputar teknologi, 
                            pengembangan website, dan inovasi digital.
                        </p>
                        <div class="mht-news-author-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-medium"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="mht-news-comments">
                    <h3 class="mht-news-comments-title">
                        <i class="far fa-comments"></i>
                        Komentar (<?php echo count($comments); ?>)
                    </h3>

                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                        <div class="mht-comment">
                            <div class="mht-comment-avatar">
                                <?php echo strtoupper(substr($comment['name'], 0, 1)); ?>
                            </div>
                            <div class="mht-comment-content">
                                <div class="mht-comment-header">
                                    <span class="mht-comment-name"><?php echo htmlspecialchars($comment['name']); ?></span>
                                    <span class="mht-comment-date"><?php echo date('d M Y', strtotime($comment['created_at'])); ?></span>
                                </div>
                                <p class="mht-comment-text"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                <span class="mht-comment-reply">
                                    <i class="far fa-reply"></i>
                                    Balas
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: var(--text-muted); text-align: center; padding: 20px;">
                            Belum ada komentar. Jadilah yang pertama berkomentar!
                        </p>
                    <?php endif; ?>

                    <!-- Comment Form -->
                    <div class="mht-comment-form">
                        <h4 class="mht-comment-form-title">Tinggalkan Komentar</h4>
                        <form action="" method="POST">
                            <div class="mht-form-group">
                                <label class="mht-form-label">Nama Lengkap *</label>
                                <input type="text" class="mht-form-control" required>
                            </div>
                            <div class="mht-form-group">
                                <label class="mht-form-label">Email *</label>
                                <input type="email" class="mht-form-control" required>
                            </div>
                            <div class="mht-form-group">
                                <label class="mht-form-label">Website</label>
                                <input type="url" class="mht-form-control">
                            </div>
                            <div class="mht-form-group">
                                <label class="mht-form-label">Komentar *</label>
                                <textarea class="mht-form-control mht-form-textarea" required></textarea>
                            </div>
                            <button type="submit" class="mht-form-btn">
                                <i class="far fa-paper-plane"></i>
                                Kirim Komentar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="mht-news-sidebar">
                <!-- Related News -->
                <?php if (!empty($relatedNews)): ?>
                <div class="mht-sidebar-widget">
                    <h3 class="mht-sidebar-title">
                        <i class="fas fa-newspaper"></i>
                        Berita Terkait
                    </h3>
                    <?php foreach ($relatedNews as $related): ?>
                    <div class="mht-related-item">
                        <img src="/webmaster/uploads/<?php echo htmlspecialchars($related['image']); ?>" 
                             alt="<?php echo htmlspecialchars($related['title']); ?>"
                             class="mht-related-image"
                             onerror="this.src='/webmaster/uploads/default-news.jpg'">
                        <div class="mht-related-content">
                            <a href="berita-<?php echo htmlspecialchars($related['slug']); ?>.php" class="mht-related-title">
                                <?php echo htmlspecialchars($related['title']); ?>
                            </a>
                            <span class="mht-related-date">
                                <i class="far fa-calendar"></i>
                                <?php echo date('d M Y', strtotime($related['date_published'])); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Categories -->
                <div class="mht-sidebar-widget">
                    <h3 class="mht-sidebar-title">
                        <i class="fas fa-folder"></i>
                        Kategori
                    </h3>
                    <ul class="mht-category-list">
                        <?php
                        try {
                            $catStats = $pdo->query("SELECT category, COUNT(*) as count FROM news WHERE status = 'published' GROUP BY category ORDER BY category");
                            while ($cat = $catStats->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <li class="mht-category-item">
                            <a href="berita?category=<?php echo urlencode($cat['category']); ?>" class="mht-category-link">
                                <span><?php echo htmlspecialchars($cat['category']); ?></span>
                                <span class="mht-category-count"><?php echo $cat['count']; ?></span>
                            </a>
                        </li>
                        <?php 
                            endwhile;
                        } catch (PDOException $e) {
                            // Silent catch
                        }
                        ?>
                    </ul>
                </div>

                <!-- Popular Posts -->
                <div class="mht-sidebar-widget">
                    <h3 class="mht-sidebar-title">
                        <i class="fas fa-fire"></i>
                        Populer Minggu Ini
                    </h3>
                    <?php
                    try {
                        $popularStmt = $pdo->query("SELECT title, slug, views, date_published FROM news WHERE status = 'published' ORDER BY views DESC LIMIT 5");
                        $i = 1;
                        while ($popular = $popularStmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <div class="mht-popular-item">
                        <span class="mht-popular-number"><?php echo $i++; ?></span>
                        <div class="mht-popular-content">
                            <a href="berita-<?php echo htmlspecialchars($popular['slug']); ?>.php" class="mht-popular-title">
                                <?php echo htmlspecialchars($popular['title']); ?>
                            </a>
                            <div class="mht-popular-meta">
                                <span><i class="far fa-eye"></i> <?php echo number_format($popular['views']); ?></span>
                                <span><i class="far fa-calendar"></i> <?php echo date('d M', strtotime($popular['date_published'])); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                    } catch (PDOException $e) {
                        // Silent catch
                    }
                    ?>
                </div>

                <!-- Newsletter -->
                <div class="mht-sidebar-widget">
                    <h3 class="mht-sidebar-title">
                        <i class="far fa-envelope"></i>
                        Newsletter
                    </h3>
                    <p class="mht-newsletter-text">
                        Dapatkan update berita terbaru langsung di email Anda.
                    </p>
                    <form class="mht-newsletter-form">
                        <input type="email" class="mht-newsletter-input" placeholder="Email Anda" required>
                        <button type="submit" class="mht-newsletter-btn">
                            <i class="far fa-paper-plane"></i>
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
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