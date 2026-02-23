<?php
require_once __DIR__ . '/../webmaster/includes/db.php';
include 'includes/head.php';
include 'includes/header.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_instansi = trim($_POST['nama_instansi'] ?? '');
    $kontak = trim($_POST['kontak'] ?? '');
    $barter_value = trim($_POST['barter_value'] ?? '');

    // Validasi input
    if (empty($nama_instansi) || empty($kontak) || empty($barter_value)) {
        $message = "Lengkapi semua data yang wajib diisi.";
        $messageType = "error";
    } else {
        // Proses upload file
        $lampiran = null;
        if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/kolaborasi/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileInfo = pathinfo($_FILES['lampiran']['name']);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            
            if (in_array($extension, $allowedExtensions)) {
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $targetFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $targetFile)) {
                    $lampiran = $filename;
                } else {
                    $message = "Gagal mengupload file. Silakan coba lagi.";
                    $messageType = "error";
                }
            } else {
                $message = "Tipe file tidak diizinkan. Gunakan JPG, PNG, PDF, DOC, atau DOCX.";
                $messageType = "error";
            }
        }

        // Simpan ke database jika tidak ada error
        if (empty($message)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO pengajuan_kolaborasi (nama_instansi, kontak, barter_value, lampiran, status, tanggal_pengajuan) VALUES (?, ?, ?, ?, 'pending', NOW())");
                $stmt->execute([$nama_instansi, $kontak, $barter_value, $lampiran]);
                
                $message = "Pengajuan kolaborasi berhasil dikirim. Tim kami akan segera menghubungi Anda.";
                $messageType = "success";
            } catch (PDOException $e) {
                $message = "Terjadi kesalahan database: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }
}
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<style>
    /* ===== MHT COLLAB FORM STYLES - WITH CUSTOM SCROLLBAR ===== */
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
        --radius-md: 8px;
        --radius-lg: 16px;
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
        font-family: 'Poppins', sans-serif;
        scroll-behavior: smooth;
    }

    body {
        background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
        color: var(--text-body);
        line-height: 1.6;
        min-height: 100vh;
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

    /* Container */
    .mht-collab-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    /* Header Section */
    .mht-collab-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .mht-collab-badge {
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
        backdrop-filter: blur(5px);
        animation: mhtFadeIn 1s ease;
    }

    .mht-collab-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
        line-height: 1.2;
        animation: mhtFadeInUp 1s ease 0.2s both;
    }

    .mht-collab-title span {
        color: var(--primary);
        position: relative;
    }

    .mht-collab-subtitle {
        font-size: 1rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        animation: mhtFadeInUp 1s ease 0.4s both;
    }

    /* Message Alert */
    .mht-alert {
        padding: 16px 24px;
        border-radius: var(--radius-lg);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        border-left: 4px solid transparent;
        animation: mhtSlideIn 0.3s ease;
    }

    .mht-alert.success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left-color: #2e7d32;
    }

    .mht-alert.success i {
        color: #2e7d32;
    }

    .mht-alert.error {
        background: #ffebee;
        color: #c62828;
        border-left-color: #c62828;
    }

    .mht-alert.error i {
        color: #c62828;
    }

    .mht-alert i {
        font-size: 1.3rem;
    }

    @keyframes mhtSlideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes mhtFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes mhtFadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Card */
    .mht-collab-form {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(156, 39, 176, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        opacity: 0;
        transform: translateY(20px);
        animation: mhtFadeInUp 0.5s ease 0.6s forwards;
    }

    .mht-collab-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .mht-collab-form:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-5px);
    }

    /* Form Group */
    .mht-form-group {
        margin-bottom: 25px;
    }

    .mht-form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .mht-form-label i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .mht-form-label span {
        color: #ff4d4f;
        margin-left: 4px;
    }

    /* Input Fields */
    .mht-form-input,
    .mht-form-textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        background: #fafafa;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .mht-form-input:focus,
    .mht-form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        outline: none;
        background: #fff;
    }

    .mht-form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* File Input */
    .mht-file-input {
        position: relative;
        margin-bottom: 10px;
    }

    .mht-file-input input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 2px dashed var(--primary-light);
        border-radius: var(--radius-md);
        background: var(--primary-light);
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        color: var(--text-muted);
    }

    .mht-file-input input[type="file"]::-webkit-file-upload-button {
        padding: 8px 20px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 15px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    .mht-file-input input[type="file"]::-webkit-file-upload-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
    }

    .mht-file-note {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .mht-file-note i {
        color: var(--primary);
    }

    /* Submit Button */
    .mht-btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 16px 30px;
        border: none;
        border-radius: var(--radius-full);
        font-size: 1.1rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .mht-btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .mht-btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(156, 39, 176, 0.4);
    }

    .mht-btn-submit:hover::before {
        left: 100%;
    }

    .mht-btn-submit:active {
        transform: translateY(-1px);
    }

    .mht-btn-submit i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .mht-btn-submit:hover i {
        transform: translateX(5px);
    }

    /* Info Note */
    .mht-form-note {
        margin-top: 20px;
        padding: 15px;
        background: var(--primary-light);
        border-radius: var(--radius-md);
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.9rem;
        color: var(--text-muted);
        border-left: 3px solid var(--primary);
        transition: var(--transition);
    }

    .mht-form-note:hover {
        background: rgba(156, 39, 176, 0.15);
    }

    .mht-form-note i {
        color: var(--primary);
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .mht-form-note p {
        flex: 1;
        line-height: 1.6;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        .mht-collab-form {
            padding: 30px 25px;
        }

        .mht-collab-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .mht-collab-form {
            padding: 25px 20px;
        }

        .mht-collab-title {
            font-size: 1.5rem;
        }

        .mht-btn-submit {
            padding: 14px 20px;
            font-size: 1rem;
        }

        .mht-file-input input[type="file"] {
            padding: 8px;
        }

        .mht-file-input input[type="file"]::-webkit-file-upload-button {
            padding: 6px 12px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="mht-collab-container">
    <!-- Header -->
    <div class="mht-collab-header">
        <span class="mht-collab-badge">KOLABORASI</span>
        <h1 class="mht-collab-title">Ajukan <span>Kerjasama</span></h1>
        <p class="mht-collab-subtitle">Isi formulir di bawah ini untuk memulai kolaborasi dengan PT MicroHelix Tech Solutions</p>
    </div>

    <!-- Alert Message -->
    <?php if (!empty($message)): ?>
        <div class="mht-alert <?php echo $messageType; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-circle-check' : 'fa-exclamation-circle'; ?>"></i>
            <span><?php echo htmlspecialchars($message); ?></span>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="post" enctype="multipart/form-data" class="mht-collab-form">
        <!-- Nama/Instansi -->
        <div class="mht-form-group">
            <label class="mht-form-label">
                <i class="far fa-building"></i>
                Nama / Instansi <span>*</span>
            </label>
            <input type="text" name="nama_instansi" class="mht-form-input" placeholder="Masukkan nama atau instansi Anda" required>
        </div>

        <!-- Kontak -->
        <div class="mht-form-group">
            <label class="mht-form-label">
                <i class="far fa-phone-alt"></i>
                Kontak yang dapat dihubungi <span>*</span>
            </label>
            <input type="text" name="kontak" class="mht-form-input" placeholder="Email / No. WhatsApp / Telepon" required>
        </div>

        <!-- Barter Value -->
        <div class="mht-form-group">
            <label class="mht-form-label">
                <i class="far fa-handshake"></i>
                Barter Value / Keuntungan yang diinginkan <span>*</span>
            </label>
            <textarea name="barter_value" class="mht-form-textarea" placeholder="Jelaskan keuntungan atau barter yang Anda inginkan dari kerjasama ini" required></textarea>
        </div>

        <!-- File Upload -->
        <div class="mht-form-group">
            <label class="mht-form-label">
                <i class="far fa-file"></i>
                Upload Lampiran
            </label>
            <div class="mht-file-input">
                <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
            </div>
            <div class="mht-file-note">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="mht-btn-submit">
            <span>Kirim Pengajuan</span>
            <i class="far fa-paper-plane"></i>
        </button>

        <!-- Info Note -->
        <div class="mht-form-note">
            <i class="fas fa-shield-alt"></i>
            <p>Data Anda akan kami jaga kerahasiaannya. Tim kami akan merespon maksimal 2x24 jam setelah pengajuan diterima.</p>
        </div>
    </form>
</div>

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