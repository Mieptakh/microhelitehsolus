<?php
include 'includes/head.php';
include 'includes/header.php';
// ==========================
// Konfigurasi database
// ==========================
$host = "sql212.infinityfree.com"; // ganti sesuai hosting
$username = "if0_38147269";        // ganti sesuai database
$password = "Qmj1impTzafs";          // ganti sesuai database
$database = "if0_38147269_mhteamsweb";               // ganti sesuai database

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

// ==========================
// Proses form submit
// ==========================
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $instansi = $mysqli->real_escape_string($_POST['instansi']);
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $mode = $_POST['mode'];
    $kontak = $mysqli->real_escape_string($_POST['kontak']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $sql = "INSERT INTO jadwal_temu (nama, instansi, tanggal, waktu, mode, kontak, keterangan) 
            VALUES ('$nama', '$instansi', '$tanggal', '$waktu', '$mode', '$kontak', '$keterangan')";

    if ($mysqli->query($sql)) {
        $success = "Jadwal temu berhasil ditambahkan!";
    } else {
        $error = "Error: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jadwalkan Temu - MH Teams</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
            color: #2D3748;
        }

        .header-section h1 {
            margin-top: 20px;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: linear-gradient(to right, #9C27B0, #7B1FA2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .header-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            color: #718096;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(156, 39, 176, 0.15);
            border: 1px solid rgba(156, 39, 176, 0.1);
            transition: all 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(156, 39, 176, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2D3748;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: #9C27B0;
            width: 18px;
            text-align: center;
        }

        .required {
            color: #E53E3E;
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fff;
            color: #2D3748;
        }

        .form-control:focus {
            outline: none;
            border-color: #9C27B0;
            box-shadow: 0 0 0 3px rgba(156, 39, 176, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: #CBD5E0;
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .btn-primary {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
            transition: left 0.7s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(156, 39, 176, 0.4);
            background: linear-gradient(135deg, #7B1FA2 0%, #9C27B0 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: linear-gradient(135deg, #48BB78, #38A169);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .alert-error {
            background: linear-gradient(135deg, #F56565, #E53E3E);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .mode-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 8px;
        }

        .mode-option {
            position: relative;
        }

        .mode-option input[type="radio"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }

        .mode-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
            font-weight: 500;
            margin: 0;
            color: #718096;
        }

        .mode-option input[type="radio"]:checked + label {
            border-color: #9C27B0;
            background: linear-gradient(135deg, rgba(156, 39, 176, 0.1), rgba(123, 31, 162, 0.1));
            color: #9C27B0;
            box-shadow: 0 0 15px rgba(156, 39, 176, 0.1);
        }

        .mode-option label:hover {
            border-color: #9C27B0;
            transform: translateY(-1px);
        }

        .footer-info {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 20px;
            color: #718096;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .form-container {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .header-section h1 {
                font-size: 2rem;
            }

            .input-group {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .mode-selector {
                grid-template-columns: 1fr;
            }
        }

        /* Animation for form appearance */
        .form-container {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading state for button */
        .btn-primary.loading {
            position: relative;
            color: transparent;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        /* Gold accent elements */
        .gold-accent {
            color: #D4AF37;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #D4AF37, transparent);
            margin: 25px 0;
        }
        /* // FOOTER SECTION STYLING */
/* 🌌 Global Footer Base */
.site-footer {
  background: linear-gradient(135deg, #1E1E1E 0%, #9C27B0 100%);
  color: #f2f2f2;
  padding: 60px 20px 20px;
  font-family: 'Poppins', sans-serif;
  position: relative;
  z-index: 10;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

/* 🌟 Footer Columns */
.footer-col h4 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
  color: #ffffff;
  position: relative;
}

.footer-col h4::after {
  content: '';
  display: block;
  width: 40px;
  height: 3px;
  background: #ffffff;
  margin-top: 8px;
  border-radius: 3px;
}

/* 🔗 Navigation Links */
.footer-nav ul,
.footer-nav li {
  list-style: none;
  margin: 0;
  padding: 0;
}

.footer-nav a {
  display: block;
  padding: 0.4rem 0;
  color: #ddd;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-nav a:hover {
  color: #fff;
  transform: translateX(5px);
}

/* 📍 Contact Info */
.footer-contact p {
  margin: 0.4rem 0;
  display: flex;
  align-items: center;
  gap: 8px;
  color: #ddd;
  font-size: 0.95rem;
}

.footer-contact i {
  color: #ffffff;
  min-width: 20px;
}

/* Buat link dalam kontak supaya warna & hover sesuai */
.footer-contact a {
  color: #ddd;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-contact a:hover {
  color: #fff;
  text-decoration: none;
}

/* 📌 Map Embed */
.footer-map iframe {
  width: 100%;
  border-radius: 8px;
  border: none;
  filter: brightness(0.9) contrast(1.1);
}

/* 💬 About & Logo */
.footer-about img {
  width: 150px;
  margin-bottom: 1rem;
}

.footer-about p {
  font-size: 0.95rem;
  color: #e0e0e0;
  margin-bottom: 1rem;
}

/* 🌐 Social Icons */
.footer-socials {
  display: flex;
  gap: 10px;
}

.footer-socials a {
  width: 36px;
  height: 36px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  color: #fff;
  display: flex;
  align-items: center;
  text-decoration: none;
  justify-content: center;
  transition: all 0.3s ease;
}

.footer-socials a:hover {
  background: #fff;
  color: #9C27B0;
  transform: scale(1.1) rotate(8deg);
}

/* 🔻 Bottom Text */
.footer-bottom {
  text-align: center;
  padding: 20px 10px 0;
  font-size: 0.85rem;
  color: #cccccc;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin-top: 2rem;
}

/* 🔝 Back to Top Button */
.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: #9C27B0;
  color: #fff;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 100;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.back-to-top:hover {
  background: #fff;
  color: #9C27B0;
  transform: scale(1.1) rotate(10deg);
}

.back-to-top.show {
  display: flex;
}

/* 📱 Responsive Adjustments */
@media (max-width: 768px) {
  .site-footer {
    padding: 40px 15px 15px;
  }

  .footer-col h4 {
    font-size: 1.1rem;
  }

  .footer-contact p {
    font-size: 0.9rem;
  }

  .footer-about img {
    width: 120px;
  }
}

    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <h1><i class="fas fa-calendar-check"></i> Jadwalkan Temu</h1>
        <p>Atur pertemuan Anda dengan mudah dan profesional</p>
    </div>

    <div class="form-container">
        <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $success; ?>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form method="post" action="" id="meetingForm">
            <div class="form-group">
                <label for="nama">
                    <i class="fas fa-user"></i>
                    Nama Lengkap <span class="required">*</span>
                </label>
                <input type="text" name="nama" id="nama" class="form-control" required 
                       placeholder="Masukkan nama lengkap Anda">
            </div>

            <div class="form-group">
                <label for="instansi">
                    <i class="fas fa-building"></i>
                    Instansi / Organisasi
                </label>
                <input type="text" name="instansi" id="instansi" class="form-control" 
                       placeholder="Nama instansi atau organisasi">
            </div>

            <div class="input-group">
                <div class="form-group">
                    <label for="tanggal">
                        <i class="fas fa-calendar"></i>
                        Tanggal <span class="required">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="waktu">
                        <i class="fas fa-clock"></i>
                        Waktu <span class="required">*</span>
                    </label>
                    <input type="time" name="waktu" id="waktu" class="form-control" required>
                </div>
            </div>

           <div class="form-group">
                <label>
                    <i class="fas fa-video"></i>
                    Mode Pertemuan <span class="required">*</span>
                </label>
                <div class="mode-selector">
                    <!-- Online aktif -->
                    <div class="mode-option">
                        <input type="radio" name="mode" value="online" id="online" required>
                        <label for="online">
                            <i class="fas fa-laptop"></i>
                            Online (Google Meet, Whatsapp)
                        </label>
                    </div>
                    <!-- Offline disabled -->
                    <div class="mode-option">
                        <input type="radio" name="mode" value="offline" id="offline" disabled>
                        <label for="offline" style="opacity:0.5; cursor:not-allowed;">
                            <i class="fas fa-handshake"></i>
                            Offline (Saat ini tidak tersedia)
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="kontak">
                    <i class="fas fa-phone"></i>
                    Kontak <span class="required">*</span>
                </label>
                <input type="text" name="kontak" id="kontak" class="form-control" required 
                       placeholder="Nomor WhatsApp / Email">
            </div>

            <div class="form-group">
                <label for="keterangan">
                    <i class="fas fa-comment-alt"></i>
                    Keterangan Tambahan
                </label>
                <textarea name="keterangan" id="keterangan" class="form-control" 
                          placeholder="Jelaskan agenda atau topik yang akan dibahas..."></textarea>
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-paper-plane"></i> Jadwalkan Temu
            </button>
        </form>
    </div>

    <div class="footer-info">
        <p><i class="fas fa-shield-alt"></i> Data Anda akan dijaga kerahasiaannya</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('meetingForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').min = today;
    
    // Form submission with loading state
    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });
    
    // Auto-format phone number
    const kontakInput = document.getElementById('kontak');
    kontakInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('62') && !value.startsWith('08')) {
            if (value.startsWith('8')) {
                value = '62' + value;
            }
        }
        // Don't auto-format if it looks like an email
        if (!e.target.value.includes('@')) {
            e.target.value = value;
        }
    });
    
    // Smooth scroll to alerts
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>

</body>

</html>
<?php include 'includes/footer.php'; ?>