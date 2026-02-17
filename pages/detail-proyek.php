<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    die("Slug proyek tidak valid.");
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE slug = ?");
    $stmt->execute([$slug]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        die("Proyek tidak ditemukan.");
    }
} catch (PDOException $e) {
    die("Kesalahan database: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($project['name']); ?> - Detail Proyek</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        :root {
            --primary: #9C27B0;
            --hover: #7B1FA2;
            --background: #F9F9F9;
            --text-dark: #121212;
            --text-muted: #B0B0B0;
        }

        body {
            background-color: var(--background);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        .project-detail {
            max-width: 960px;
            margin: 60px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .project-detail h1 {
            font-size: 32px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .project-detail img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .project-info {
            margin-top: 24px;
        }

        .project-description {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-dark);
            margin-bottom: 30px;
        }

        .btn-visit,
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-visit {
            background-color: var(--primary);
            color: #fff;
            margin-right: 12px;
        }

        .btn-visit:hover {
            background-color: var(--hover);
        }

        .btn-back {
            background-color: #eee;
            color: var(--text-dark);
        }

        .btn-back:hover {
            background-color: #ddd;
        }

        @media (max-width: 768px) {
            .project-detail {
                margin: 30px 15px;
            }

            .project-detail h1 {
                font-size: 24px;
            }

            .btn-visit, .btn-back {
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <section class="project-detail">
        <h1><i class="fa-solid fa-<?php echo htmlspecialchars($project['icon']); ?>"></i> <?php echo htmlspecialchars($project['name']); ?></h1>
        <img src="/uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['name']); ?>" />
        
        <div class="project-info">
            <p class="project-description"><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>

            <?php if (!empty($project['url'])): ?>
                <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" rel="noopener noreferrer" class="btn-visit">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Kunjungi Proyek
                </a>
            <?php endif; ?>

            <a href="/proyek-kami" class="btn-back">
                <i class="fa-solid fa-chevron-left"></i> Kembali ke Daftar Proyek
            </a>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
