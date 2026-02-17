<?php
include 'includes/head.php';
include 'includes/header.php';

// Konfigurasi dasar
error_reporting(E_ALL);
ini_set('display_errors', 1); // Diaktifkan untuk debugging

// Buat dan koneksi ke database SQLite
$database_path = __DIR__ . '/testimonials.db';

try {
    $db = new PDO('sqlite:' . $database_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buat tabel jika belum ada
    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        role TEXT NOT NULL,
        message TEXT NOT NULL,
        avatar TEXT DEFAULT 'default-avatar.jpg',
        rating INTEGER DEFAULT 5,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Cek apakah tabel kosong, lalu tambahkan data contoh
    $stmt = $db->query("SELECT COUNT(*) as count FROM testimonials");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Data contoh
        $sample_data = [
            ['Ahmad Rizki', 'CEO TechStartup', 'MHTeams membantu perusahaan kami dalam transformasi digital dengan hasil yang luar biasa. Tim mereka profesional dan responsif.', 'ahmad.jpg', 5],
            ['Sari Dewi', 'Manajer Marketing', 'Layanan MHTeams sangat memuaskan. Projek kami selesai tepat waktu dengan kualitas terbaik yang tidak terduga.', 'sari.jpg', 5],
            ['Budi Santoso', 'Freelancer Developer', 'Sebagai freelancer, tools dari MHTeams sangat membantu meningkatkan produktivitas saya sehari-hari.', 'budi.jpg', 4],
            ['Diana Putri', 'Pemilik Bisnis Online', 'Sejak menggunakan jasa MHTeams, penjualan online saya meningkat drastis. Terima kasih atas dukungannya!', 'diana.jpg', 5],
            ['Rizky Pratama', 'UI/UX Designer', 'Platform MHTeams sangat designer-friendly. Sangat mudah untuk berkolaborasi dengan tim development.', 'rizky.jpg', 4]
        ];
        
        $insert_stmt = $db->prepare("INSERT INTO testimonials (name, role, message, avatar, rating) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($sample_data as $data) {
            $insert_stmt->execute($data);
        }
    }
    
    $database_error = false;
} catch (PDOException $e) {
    $database_error = true;
    error_log("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial - MHTeams</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/css/lucide.min.css">
 <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body { 
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
    color: #333;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Judul */
.testimonial-title {
    text-align: center;
    font-size: 2.8rem;
    font-weight: 700;
    background: linear-gradient(45deg, #9C27B0, #FFD700);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 50px 0 20px;
}

.testimonial-subtitle {
    text-align: center;
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 60px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Grid */
.testimonial-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

/* Card */
.testimonial-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    padding: 30px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
}

.testimonial-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 18px 45px rgba(0,0,0,0.15);
}

.testimonial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(45deg, #9C27B0, #FFD700);
    border-top-left-radius: 18px;
    border-top-right-radius: 18px;
}

/* Header */
.testimonial-header {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 18px;
}

.testimonial-avatar {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: linear-gradient(135deg, #9C27B0, #FFD700);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: bold;
    font-size: 1.6rem;
    border: 3px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover .testimonial-avatar {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.testimonial-header-text h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
}

.testimonial-header-text small {
    color: #888;
    font-size: 0.9rem;
    display: block;
}

/* Message */
.testimonial-message {
    font-size: 1rem;
    color: #444;
    line-height: 1.7;
    margin-bottom: 22px;
    font-style: italic;
    position: relative;
}

.testimonial-message::before {
    content: "“";
    position: absolute;
    top: -10px;
    left: -5px;
    font-size: 3rem;
    color: #9C27B0;
    opacity: 0.2;
}

/* Footer */
.testimonial-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.stars {
    display: flex;
    gap: 3px;
}

.star {
    color: #FFD700;
    font-size: 1rem;
}

.star-off {
    color: #ddd;
}

.date {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #9C27B0;
    font-size: 0.9rem;
    font-weight: 500;
}

/* No data & Error states */
.no-data-container,
.error-container {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
}

.no-data,
.error-message {
    font-size: 1.1rem;
    color: #666;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.08);
    max-width: 500px;
    margin: 0 auto;
}

.error-message {
    color: #e74c3c;
    border-left: 4px solid #e74c3c;
}

/* Responsive */
@media (max-width: 768px) {
    .testimonial-title {
        font-size: 2.2rem;
    }
    
    .testimonial-subtitle {
        font-size: 1rem;
    }
    
    .testimonial-card {
        padding: 22px;
    }
    
    .testimonial-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .testimonial-title {
        font-size: 1.8rem;
    }
    
    .testimonial-header {
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    
    .testimonial-avatar {
        width: 55px;
        height: 55px;
        font-size: 1.3rem;
    }
}
</style>

</head>
<body>

<div class="container">
    <h1 class="testimonial-title">Apa Kata Mereka?</h1>
    <p class="testimonial-subtitle">Cerita nyata dari klien & partner bersama <b>MHTeams</b>.</p>

    <div class="testimonial-grid">
        <?php
        if (!$database_error):
            try {
                // Query untuk mendapatkan testimonial
                $stmt = $db->query("SELECT id, name, role, message, avatar, rating, date_added FROM testimonials ORDER BY date_added DESC");
                $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($testimonials) > 0):
                    foreach ($testimonials as $row):
                        // Sanitasi dan validasi data
                        $name = !empty($row['name']) ? htmlspecialchars(trim($row['name']), ENT_QUOTES, 'UTF-8') : 'Anonymous';
                        $role = !empty($row['role']) ? htmlspecialchars(trim($row['role']), ENT_QUOTES, 'UTF-8') : 'Client';
                        $message = !empty($row['message']) ? nl2br(htmlspecialchars(trim($row['message']), ENT_QUOTES, 'UTF-8')) : 'No message provided';
                        $rating = isset($row['rating']) && is_numeric($row['rating']) ? max(1, min(5, intval($row['rating']))) : 5;
                        $date_added = !empty($row['date_added']) ? $row['date_added'] : date('Y-m-d H:i:s');
                        
                        // Ambil inisial untuk avatar
                        $initials = '';
                        $nameParts = explode(' ', $name);
                        if (count($nameParts) > 0) {
                            $initials = strtoupper(substr($nameParts[0], 0, 1));
                            if (count($nameParts) > 1) {
                                $initials .= strtoupper(substr($nameParts[1], 0, 1));
                            }
                        }
        ?>

    <div class="testimonial-card">
        <div class="testimonial-header">
            <div class="testimonial-avatar">
                <?php echo $initials; ?>
            </div>
            <div class="testimonial-header-text">
                <h3><?php echo $name; ?></h3>
                <small><?php echo $role; ?></small>
            </div>
        </div>

        <p class="testimonial-message">
            "<?php echo $message; ?>"
        </p>

        <div class="testimonial-footer">
            <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($i <= $rating): ?>
                        <i class="fa-solid fa-star" style="color:#FFD700;"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-star" style="color:#ddd;"></i>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <div class="date">
                <i class="fa-regular fa-calendar" style="color:#9C27B0;"></i>
                <span>
                    <?php 
                        try {
                            echo date("d M Y", strtotime($date_added));
                        } catch (Exception $e) {
                            echo date("d M Y");
                        }
                    ?>
                </span>
            </div>
        </div>
    </div>

        <?php 
                    endforeach; 
                else: 
        ?>
            <div class="no-data-container">
                <p class="no-data">Belum ada testimoni yang tersedia.</p>
            </div>
        <?php 
                endif;
            } catch (Exception $e) {
                error_log("Database query error: " . $e->getMessage());
        ?>
            <div class="error-container">
                <p class="error-message">Terjadi kesalahan saat memuat testimoni. Silakan coba lagi nanti.</p>
            </div>
        <?php
            }
        else:
        ?>
            <div class="error-container">
                <p class="error-message">Tidak dapat terhubung ke database. Silakan coba lagi nanti.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animasi untuk card
    const cards = document.querySelectorAll('.testimonial-card');
    cards.forEach(function(card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(function() {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
});
</script>

</body>

</html>