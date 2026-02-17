<?php 
include 'includes/head.php';
include 'includes/header.php';

require_once __DIR__ . '/../webmaster/includes/db.php'; // sesuaikan path sesuai struktur kamu

if (!isset($_GET['slug'])) {
    die("Slug paket tidak ditemukan.");
}

$slug = $_GET['slug'];

try {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE slug = ?");
    $stmt->execute([$slug]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        die("Paket tidak tersedia.");
    }

    // Hitung harga termasuk PPN 11%
    $ppn = 0.11;
    $priceWithPpn = $package['price'] + ($package['price'] * $ppn);

} catch (PDOException $e) {
    die("Kesalahan database: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($package['name']); ?> - Detail Paket</title>
    <link rel="stylesheet" href="styles.css" />
    <!-- Link fontawesome jika belum ada -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary: #9C27B0;
            --hover: #7B1FA2;
            --background: #F9F9F9;
            --text-dark: #121212;
            --text-muted: #B0B0B0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        .package-detail {
            max-width: 960px;
            margin: 40px auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .package-detail h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .price {
            font-size: 1.4rem;
            color: var(--hover);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        h3 {
            margin-top: 2rem;
            color: var(--text-dark);
        }

        ul.features {
            list-style: none;
            padding: 0;
            margin-top: 1rem;
        }

        ul.features li {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
            font-size: 1rem;
        }

        ul.features li i {
            color: var(--primary);
            margin-right: 10px;
        }

        .btn-contact, .btn-preview {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 15px 0 0;
            font-weight: 600;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--hover));
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-contact:hover, .btn-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(156, 39, 176, 0.3);
        }

        .screenshot-gallery {
            margin-top: 3rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 1rem;
        }

        .gallery-grid img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .gallery-grid img:hover {
            transform: scale(1.03);
        }

        @media (max-width: 600px) {
            .package-detail {
                padding: 1.5rem;
            }

            .btn-contact, .btn-preview {
                width: 100%;
                margin-bottom: 10px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
<section class="package-detail">
    <div class="container">
        <h1><?php echo htmlspecialchars($package['name']); ?></h1>
        <p class="price">
            Harga: Rp <?php echo number_format($priceWithPpn, 0, ',', '.'); ?> 
            <small>(sudah termasuk PPN 11%)</small>
        </p>

        <h3>Fitur:</h3>
        <ul class="features">
            <?php
            $features = explode(',', $package['features']);
            foreach ($features as $feature): ?>
                <li><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars(trim($feature)); ?></li>
            <?php endforeach; ?>
        </ul>

        <?php if (!empty($package['preview_url'])): ?>
            <a href="<?php echo htmlspecialchars($package['preview_url']); ?>" class="btn-preview" target="_blank" rel="noopener noreferrer">
                <i class="fa-solid fa-eye"></i> Live Preview
            </a>
        <?php endif; ?>

        <?php if (!empty($package['screenshots'])): ?>
            <div class="screenshot-gallery">
                <h3>Contoh Tampilan:</h3>
                <div class="gallery-grid">
                    <?php
                    $screenshots = explode(',', $package['screenshots']);
                    foreach ($screenshots as $img):
                        $img = trim($img);
                    ?>
                        <img src="/uploads/<?php echo htmlspecialchars($img); ?>" alt="Screenshot <?php echo htmlspecialchars($package['name']); ?>" />
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <a href="https://wa.me/6285183241229?text=Halo%20saya%20tertarik%20dengan%20paket%20<?php echo urlencode($package['name']); ?>" 
            class="btn-contact" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands fa-whatsapp"></i> Hubungi Kami 
        </a>

       <!-- 🔥 Opsi Pembayaran -->
<div class="payment-options">
  <h3>Metode Pembayaran:</h3>
  <ul class="payment-list">
    <li>
      <img src="https://bloguna.com/wp-content/uploads/2025/06/Logo-ShopeePay-PNG-CDR-SVG-EPS-Kualitas-HD-1536x860.png" alt="ShopeePay Logo" />
      ShopeePay
    </li>
    <li>
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/Logo_Gopay.svg" alt="GoPay Logo" />
      GoPay
    </li>
    <li>
      <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/SeaBank.svg" alt="SeaBank Logo" />
      SeaBank
    </li>
    <li>
      <img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg" alt="BNI Logo" />
      BNI
    </li>
  </ul>
  <p class="payment-note">
    Detail nomor rekening atau e-wallet akan diberikan setelah menghubungi kami.
  </p>
</div>

<style>
.payment-options {
  margin-top: 2rem;
  padding: 1.8rem;
  border-radius: 16px;
  background: linear-gradient(135deg, #ffffff, #f9f9f9);
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: background 0.3s ease;
}

.payment-options:hover {
  background: linear-gradient(135deg, #ffffff, #f3f3f3);
}

.payment-options h3 {
  margin-bottom: 1.2rem;
  font-size: 1.4rem;
  font-weight: 700;
  color: #222;
  letter-spacing: 0.3px;
}

.payment-list {
  list-style: none;
  padding: 0;
  display: flex;
  gap: 18px;
  flex-wrap: wrap;
}

.payment-list li {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1rem;
  background: #fff;
  padding: 12px 18px;
  border-radius: 12px;
  transition: all 0.35s ease;
  cursor: pointer;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
  min-width: 140px;
  justify-content: center;
}

.payment-list li:hover {
  transform: translateY(-5px) scale(1.03);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.payment-list img {
  width: 36px;
  height: auto;
  object-fit: contain;
  transition: transform 0.3s ease;
}

.payment-list li:hover img {
  transform: scale(1.1);
}

.payment-note {
  margin-top: 1rem;
  font-size: 0.95rem;
  color: #444;
  font-style: italic;
  text-align: center;
}

</style>


</section>


<?php include 'includes/footer.php'; ?>
</body>
</html>
