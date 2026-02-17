<?php 
include 'includes/head.php'; 
include 'includes/header.php'; 

require_once __DIR__ . '/../webmaster/includes/db.php'; // sesuaikan path-nya

?>

<style>
/* === MHTeams Projects Section Styling === */
/* Color Palette:
   - Primary: #9C27B0 (Purple Pulse)
   - Hover Shade: #7B1FA2 (Deep Plum)
   - Background: #F9F9F9 (Snow White)
   - Text: #121212 (Carbon Black)
   - Neutral: #B0B0B0 (Ash Grey)
*/

.projects-section {
    padding: 80px 20px;
    background-color: #F9F9F9;
}

.projects-section h2 {
    font-size: 36px;
    color: #9C27B0;
    text-align: center;
    margin-bottom: 10px;
}

.projects-section .section-subtitle {
    font-size: 16px;
    text-align: center;
    color: #B0B0B0;
    margin-bottom: 40px;
}

/* Grid Container */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

/* Project Card */
.project-card {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.project-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(156, 39, 176, 0.15);
}

.project-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

/* Info Section */
.project-info {
    padding: 20px;
    flex: 1;
}

.project-info h3 {
    font-size: 20px;
    margin: 0 0 12px;
    color: #121212;
    display: flex;
    align-items: center;
    gap: 8px;
}

.project-info p {
    font-size: 14px;
    color: #4B5563;
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Button Group */
.project-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-project,
.btn-project-detail {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Detail Button */
.btn-project-detail {
    background-color: #EDE7F6;
    color: #7B1FA2;
}

.btn-project-detail:hover {
    background-color: #D1C4E9;
    transform: translateY(-1px);
}

/* Visit Button */
.btn-project {
    background: linear-gradient(to right, #9C27B0, #7B1FA2);
    color: white;
}

.btn-project:hover {
    background: #7B1FA2;
    transform: translateY(-1px);
}

/* Error Message */
.error {
    background-color: #FEE2E2;
    color: #B91C1C;
    padding: 14px 20px;
    border-radius: 8px;
    margin-top: 30px;
    text-align: center;
    font-weight: 500;
}

</style>

<section id="all-projects" class="projects-section" data-aos="fade-up">
    <div class="container">
        <h2><i class="fa-solid fa-laptop-code"></i> Semua Proyek Kami</h2>
        <p class="section-subtitle">Inilah seluruh proyek inovatif yang telah kami kembangkan.</p>

        <div class="projects-grid">
            <?php
            try {
                $query = "SELECT * FROM projects ORDER BY date_added DESC";
                $stmt = $pdo->query($query);

                if ($stmt->rowCount() === 0) {
                    echo "<p>Tidak ada proyek yang tersedia saat ini.</p>";
                } else {
                    while ($project = $stmt->fetch(PDO::FETCH_ASSOC)):
                        $projectSlug = htmlspecialchars($project['slug']);
                        $projectName = htmlspecialchars($project['name']);
                        $projectDesc = htmlspecialchars($project['description']);
                        $projectIcon = htmlspecialchars($project['icon']);
                        $projectImage = htmlspecialchars($project['image']);
                        $projectUrl = !empty($project['url']) ? htmlspecialchars($project['url']) : '';
            ?>
            <div class="project-card" data-aos="zoom-in">
                <img src="uploads/<?php echo $projectImage; ?>" alt="<?php echo $projectName; ?>" loading="lazy" />
                <div class="project-info">
                    <h3><i class="fa-solid fa-<?php echo $projectIcon; ?>"></i> <?php echo $projectName; ?></h3>
                    <p><?php echo strlen($projectDesc) > 150 ? substr(strip_tags($projectDesc), 0, 150) . '...' : strip_tags($projectDesc); ?></p>
                    <div class="project-actions">
                        <a href="detail-proyek?slug=<?php echo urlencode($projectSlug); ?>" class="btn-project-detail" aria-label="Detail proyek <?php echo $projectName; ?>">
                            <i class="fa-solid fa-info-circle"></i> Detail
                        </a>
                        <?php if ($projectUrl): ?>
                        <a href="<?php echo $projectUrl; ?>" target="_blank" rel="noopener noreferrer" class="btn-project" aria-label="Kunjungi proyek <?php echo $projectName; ?>">
                            <i class="fa-solid fa-arrow-right"></i> Kunjungi
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                }
            } catch (PDOException $e) {
                echo "<div class='error'>Gagal memuat data proyek: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
