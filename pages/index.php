<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include __DIR__ . '/../webmaster/includes/db.php'; ?>


<!-- 🎭 Hero Section with Typewriter Animation -->
<section class="mht-parallax" data-aos="fade-in">
    <div class="mht-parallax-content">
        <h2 class="mht-typewriter">Welcome To MHTeams Site</h2>
        <p class="mht-hero-subtitle">Menjalankan ide dan kreativitas menjadi solusi nyata.</p>
        <a href="#explore" class="mht-btn-explore mht-pulse">Jelajahi Sekarang <i class="fa-solid fa-arrow-down"></i></a>
    </div>
</section>    

<!-- 📌 About Section -->
<section id="mht-about" class="mht-about-section" data-aos="fade-up">
    <div class="mht-about-container">
        <h1 class="mht-section-title"><i class="fa-solid fa-rocket"></i> Selamat Datang di <span class="mht-brand">MHTeams</span></h1>
        <p class="mht-about-description">
            MHTeams adalah ruang inovasi digital yang berfokus pada pengembangan proyek-proyek teknologi berkualitas tinggi. 
            Kami percaya bahwa kreativitas dan teknologi dapat membawa perubahan besar bagi dunia.
        </p>
        <p class="mht-about-history">
            Berdiri sejak <strong>Desember 2024</strong>, MHTeams hadir untuk menjadi wadah bagi ide-ide inovatif dan kolaborasi 
            yang mendorong perkembangan teknologi secara berkelanjutan.
        </p>
        <div class="mht-about-stats">
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="15">0</span>+
                <span class="mht-stat-label">Proyek Selesai</span>
            </div>
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="8">0</span>+
                <span class="mht-stat-label">Klien Puas</span>
            </div>
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="3">0</span>+
                <span class="mht-stat-label">Kolaborasi</span>
            </div>
        </div>
        <a href="/tentang-kami" class="mht-btn-learn-more">
            <i class="fa-solid fa-circle-info"></i> Tentang Kami
        </a>
    </div>
</section>


<!-- 📢 Ratecard Section -->
<section id="mht-ratecard" class="mht-ratecard-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fa-solid fa-tags"></i> Paket Pembuatan Website</h2>
        <p class="mht-section-subtitle">Solusi tepat untuk kebutuhan digital Anda</p>
        
        <div class="mht-ratecard-grid">
            <?php
            try {
                $query = "SELECT * FROM packages ORDER BY price ASC LIMIT 3";
                $stmt = $pdo->query($query);
                
                while ($package = $stmt->fetch()):
            ?>
            <div class="mht-ratecard-card">
                <div class="mht-ratecard-header">
                    <h3 class="mht-package-name"><?php echo htmlspecialchars($package['name']); ?></h3>
                    <div class="mht-package-price">
                        Rp <?php echo number_format($package['price'], 0, ',', '.'); ?>
                    </div>
                    <small class="mht-ppn-note">*Belum termasuk PPN 11%</small>
                </div>
                <ul class="mht-package-features">
                    <?php 
                    $features = explode(',', $package['features']);
                    foreach ($features as $feature): 
                    ?>
                    <li class="mht-feature-item">
                        <i class="fa-solid fa-check"></i> <?php echo htmlspecialchars(trim($feature)); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="/detail-paket?slug=<?php echo urlencode($package['slug']); ?>" class="mht-btn-ratecard">
                    Pilih Paket <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <?php 
                endwhile;
            } catch (PDOException $e) {
                echo "<div class='mht-error'>Gagal memuat data paket: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>
        
        <div class="mht-text-center">
            <a href="/paket-kami" class="mht-btn-view-all">
                Lihat Semua Paket <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>


<!-- 📌 Projects Section -->
<section id="mht-projects" class="mht-projects-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fa-solid fa-laptop-code"></i> Proyek Terbaru</h2>
        <p class="mht-section-subtitle">
            Beberapa proyek inovatif yang telah kami kembangkan dengan kualitas terbaik.
        </p>

        <div class="mht-projects-grid">
            <?php
            try {
                $projectQuery = "SELECT * FROM projects ORDER BY date_added DESC LIMIT 3";
                $projectStmt = $pdo->query($projectQuery);

                while ($project = $projectStmt->fetch(PDO::FETCH_ASSOC)):
                    // Amankan data output dengan htmlspecialchars
                    $projectSlug = htmlspecialchars($project['slug']);
                    $projectName = htmlspecialchars($project['name']);
                    $projectDesc = htmlspecialchars($project['description']);
                    $projectIcon = htmlspecialchars($project['icon']);
                    $projectImage = htmlspecialchars($project['image']);
                    $projectUrl = !empty($project['url']) ? htmlspecialchars($project['url']) : '';
            ?>
            <div class="mht-project-card" data-aos="zoom-in">
                <img src="/uploads/<?php echo $projectImage; ?>" alt="<?php echo $projectName; ?>" class="mht-project-image" loading="lazy" />
                <div class="mht-project-info">
                    <h3 class="mht-project-title"><i class="fa-solid fa-<?php echo $projectIcon; ?>"></i> <?php echo $projectName; ?></h3>
                    <p class="mht-project-description">
                        <?php echo strlen($projectDesc) > 150 ? substr(strip_tags($projectDesc), 0, 150) . '...' : $projectDesc; ?>
                    </p>
                    <div class="mht-project-actions">
                        <a href="/detail-proyek?slug=<?php echo urlencode($projectSlug); ?>" class="mht-btn-project-detail" aria-label="Detail proyek <?php echo $projectName; ?>">
                            <i class="fa-solid fa-info-circle"></i> Detail
                        </a>
                        <?php if ($projectUrl): ?>
                        <a href="<?php echo $projectUrl; ?>" target="_blank" rel="noopener noreferrer" class="mht-btn-project" aria-label="Kunjungi proyek <?php echo $projectName; ?>">
                            <i class="fa-solid fa-arrow-right"></i> Kunjungi
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
            } catch (PDOException $e) {
                echo "<div class='mht-error'>Gagal memuat data proyek: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>

        <div class="mht-text-center" style="margin-top: 2rem;">
            <a href="/proyek-kami" class="mht-btn-view-all" aria-label="Lihat semua proyek">
                Lihat Semua Proyek <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- 🚀 Collaboration Carousel -->
<section id="mht-collaboration" class="mht-collab-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fa-solid fa-handshake"></i> Kolaborasi Kami</h2>
        <p class="mht-section-subtitle">Berkolaborasi dengan talenta terbaik untuk hasil maksimal</p>
        
        <div class="mht-collab-carousel">
            <?php
            try {
                $collabQuery = "SELECT * FROM collaborations ORDER BY RAND() LIMIT 5";
                $collabStmt = $pdo->query($collabQuery);
                
                while($collab = $collabStmt->fetch()):
            ?>
            <div class="mht-collab-card">
                <img src="uploads/<?php echo htmlspecialchars($collab['logo']); ?>" alt="<?php echo htmlspecialchars($collab['name']); ?>" class="mht-collab-logo">
                <h4 class="mht-collab-name"><?php echo htmlspecialchars($collab['name']); ?></h4>
                <p class="mht-collab-description"><?php echo htmlspecialchars($collab['description']); ?></p>
                <div class="mht-collab-tags">
                    <?php 
                    $tags = explode(',', $collab['tags']);
                    foreach($tags as $tag): 
                    ?>
                    <span class="mht-collab-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php 
                endwhile;
            } catch (PDOException $e) {
                echo "<div class='mht-error'>Gagal memuat data kolaborasi: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>
        
        <div class="mht-collab-cta">
            <h3 class="mht-collab-cta-title">Ingin berkolaborasi dengan kami?</h3>
            <p class="mht-collab-cta-text">Kami selalu terbuka untuk kerjasama dan proyek-proyek menarik</p>
            <a href="/pengajuan-kolaborasi" class="mht-btn-collab">
                <i class="fa-solid fa-handshake"></i> Ayo Kolaborasi
            </a>
        </div>
    </div>
</section>

<script>
    // Animated Counter for Stats
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.mht-stat-number');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if(count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target;
            }
            
            function updateCount() {
                const current = +counter.innerText;
                if(current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>