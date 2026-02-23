<?php
include 'includes/head.php';
include 'includes/header.php';
require_once __DIR__ . '/../webmaster/includes/db.php'; // Koneksi MySQL dengan PDO

// ==========================
// Proses form submit
// ==========================
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $instansi = trim($_POST['instansi'] ?? '');
    $tanggal = $_POST['tanggal'] ?? '';
    $waktu = $_POST['waktu'] ?? '';
    $mode = $_POST['mode'] ?? '';
    $kontak = trim($_POST['kontak'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    $kota = trim($_POST['kota'] ?? ''); // Ubah dari lokasi ke kota

    // Validasi input
    if (empty($nama) || empty($tanggal) || empty($waktu) || empty($mode) || empty($kontak)) {
        $error = "Lengkapi semua field yang wajib diisi.";
    } elseif ($mode === 'offline' && empty($kota)) {
        $error = "Pilih kota untuk pertemuan offline.";
    } else {
        try {
            // Gunakan PDO prepared statement untuk keamanan
            $sql = "INSERT INTO jadwal_temu (nama, instansi, tanggal, waktu, mode, kontak, keterangan, kota) 
                    VALUES (:nama, :instansi, :tanggal, :waktu, :mode, :kontak, :keterangan, :kota)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nama' => $nama,
                ':instansi' => $instansi,
                ':tanggal' => $tanggal,
                ':waktu' => $waktu,
                ':mode' => $mode,
                ':kontak' => $kontak,
                ':keterangan' => $keterangan,
                ':kota' => $kota
            ]);
            
            $success = "Jadwal temu berhasil ditambahkan! Tim kami akan segera menghubungi Anda.";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
            error_log("Error inserting jadwal temu: " . $e->getMessage());
        }
    }
}

// Cek apakah tabel jadwal_temu ada, jika tidak buat tabel
try {
    $pdo->query("SELECT 1 FROM jadwal_temu LIMIT 1");
} catch (PDOException $e) {
    // Tabel tidak ada, buat tabel dengan kolom kota
    $createTable = "
    CREATE TABLE IF NOT EXISTS jadwal_temu (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(255) NOT NULL,
        instansi VARCHAR(255),
        tanggal DATE NOT NULL,
        waktu TIME NOT NULL,
        mode ENUM('online', 'offline') NOT NULL,
        kontak VARCHAR(255) NOT NULL,
        keterangan TEXT,
        kota VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($createTable);
}

// Daftar kota yang tersedia untuk offline meeting
$availableCities = [
    'Sidoarjo' => 'Sidoarjo',
    'Surabaya' => 'Surabaya',
    'Malang' => 'Malang',
    'Pasuruan' => 'Pasuruan',
    'Mojokerto' => 'Mojokerto'
];
?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<style>
    /* ===== MHT JADWAL TEMU STYLES - WITH CUSTOM SCROLLBAR ===== */
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
        background: linear-gradient(135deg, #f5f5f7 0%, #f0f0f8 100%);
    }

    body {
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

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    .header-section {
        text-align: center;
        margin-bottom: 40px;
        animation: mhtFadeIn 1s ease;
    }

    .header-section h1 {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        margin-bottom: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .header-section h1 i {
        color: var(--primary);
        font-size: 2rem;
    }

    .header-section p {
        font-size: 1.1rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    .header-section .location-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary-light);
        color: var(--primary);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-size: 0.9rem;
        margin-top: 15px;
        border: 1px solid rgba(156, 39, 176, 0.2);
        flex-wrap: wrap;
        justify-content: center;
    }

    .header-section .location-badge i {
        color: var(--primary);
    }

    .header-section .location-badge span {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .header-section .location-badge .city-tag {
        background: white;
        color: var(--primary);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(156, 39, 176, 0.1);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        animation: mhtSlideUp 0.6s ease-out;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .form-container:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .form-group label i {
        color: var(--primary);
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
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 15px;
        transition: var(--transition);
        background: #fff;
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        transform: translateY(-1px);
    }

    .form-control:hover {
        border-color: #CBD5E0;
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239C27B0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
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
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        cursor: pointer;
        z-index: 2;
    }

    .mode-option label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        background: #fff;
        font-weight: 500;
        margin: 0;
        color: var(--text-muted);
        position: relative;
        z-index: 1;
    }

    .mode-option input[type="radio"]:checked + label {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
        box-shadow: 0 0 15px rgba(156, 39, 176, 0.1);
    }

    .mode-option label:hover {
        border-color: var(--primary);
        transform: translateY(-1px);
    }

    /* Kota selector - muncul hanya jika offline dipilih */
    .kota-group {
        display: none;
        animation: mhtSlideDown 0.3s ease;
    }

    .kota-group.show {
        display: block;
    }

    .city-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--primary-light);
        color: var(--primary);
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        margin: 5px 5px 0 0;
    }

    .city-badge i {
        font-size: 0.7rem;
    }

    .time-note {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .time-note i {
        color: var(--primary);
    }

    .btn-primary {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: var(--radius-md);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3);
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
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
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary.loading {
        position: relative;
        color: transparent;
        pointer-events: none;
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

    .alert {
        padding: 16px 20px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: mhtSlideIn 0.3s ease;
    }

    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid #2e7d32;
    }

    .alert-success i {
        color: #2e7d32;
        font-size: 1.3rem;
    }

    .alert-error {
        background: #ffebee;
        color: #c62828;
        border-left: 4px solid #c62828;
    }

    .alert-error i {
        color: #c62828;
        font-size: 1.3rem;
    }

    .footer-info {
        text-align: center;
        margin-top: 20px;
        color: var(--text-muted);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .footer-info i {
        color: var(--primary);
    }

    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--primary), transparent);
        margin: 25px 0;
    }

    /* Animations */
    @keyframes mhtFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes mhtSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    @keyframes mhtSlideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        ::-webkit-scrollbar {
            width: 8px;
        }

        .container {
            padding: 20px 15px 40px;
        }

        .form-container {
            padding: 25px 20px;
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

        .header-section .location-badge {
            padding: 8px 15px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .form-container {
            padding: 20px 15px;
        }

        .btn-primary {
            padding: 14px 20px;
            font-size: 0.95rem;
        }

        .header-section h1 {
            font-size: 1.8rem;
        }

        .header-section h1 i {
            font-size: 1.6rem;
        }

        .header-section .location-badge .city-tag {
            font-size: 0.7rem;
            padding: 2px 8px;
        }
    }
</style>

<div class="container">
    <div class="header-section">
        <h1><i class="fas fa-calendar-check"></i> Jadwalkan Temu</h1>
        <p>Atur pertemuan Anda dengan mudah dan profesional</p>
        <div class="location-badge">
            <i class="fas fa-map-marker-alt"></i>
            <span>
                Tersedia di: 
                <span class="city-tag">Sidoarjo</span>
                <span class="city-tag">Surabaya</span>
                <span class="city-tag">Malang</span>
                <span class="city-tag">Pasuruan</span>
                <span class="city-tag">Mojokerto</span>
            </span>
        </div>
    </div>

    <div class="form-container">
        <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
        <?php endif; ?>

        <form method="post" action="" id="meetingForm">
            <div class="form-group">
                <label for="nama">
                    <i class="fas fa-user"></i>
                    Nama Lengkap <span class="required">*</span>
                </label>
                <input type="text" name="nama" id="nama" class="form-control" required 
                       placeholder="Masukkan nama lengkap Anda" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="instansi">
                    <i class="fas fa-building"></i>
                    Instansi / Organisasi
                </label>
                <input type="text" name="instansi" id="instansi" class="form-control" 
                       placeholder="Nama instansi atau organisasi" value="<?php echo isset($_POST['instansi']) ? htmlspecialchars($_POST['instansi']) : ''; ?>">
            </div>

            <div class="input-group">
                <div class="form-group">
                    <label for="tanggal">
                        <i class="fas fa-calendar-alt"></i>
                        Tanggal <span class="required">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required
                           value="<?php echo isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="waktu">
                        <i class="fas fa-clock"></i>
                        Waktu <span class="required">*</span>
                    </label>
                    <input type="time" name="waktu" id="waktu" class="form-control" required
                           value="<?php echo isset($_POST['waktu']) ? htmlspecialchars($_POST['waktu']) : ''; ?>">
                    <div class="time-note">
                        <i class="fas fa-info-circle"></i>
                        <span>Pilih waktu yang Anda inginkan (24 jam)</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-video"></i>
                    Mode Pertemuan <span class="required">*</span>
                </label>
                <div class="mode-selector">
                    <div class="mode-option">
                        <input type="radio" name="mode" value="online" id="online" required 
                               <?php echo (!isset($_POST['mode']) || (isset($_POST['mode']) && $_POST['mode'] === 'online')) ? 'checked' : ''; ?>>
                        <label for="online">
                            <i class="fas fa-laptop"></i>
                            Online (Google Meet, WhatsApp)
                        </label>
                    </div>
                    <div class="mode-option">
                        <input type="radio" name="mode" value="offline" id="offline"
                               <?php echo (isset($_POST['mode']) && $_POST['mode'] === 'offline') ? 'checked' : ''; ?>>
                        <label for="offline">
                            <i class="fas fa-handshake"></i>
                            Offline (Bertemu Langsung)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Kota Meeting (hanya untuk offline) -->
            <div class="form-group kota-group <?php echo (isset($_POST['mode']) && $_POST['mode'] === 'offline') ? 'show' : ''; ?>" id="kotaGroup">
                <label for="kota">
                    <i class="fas fa-map-marker-alt"></i>
                    Pilih Kota <span class="required">*</span>
                </label>
                <select name="kota" id="kota" class="form-control">
                    <option value="">Pilih kota pertemuan</option>
                    <?php foreach ($availableCities as $value => $label): 
                        $selected = (isset($_POST['kota']) && $_POST['kota'] === $value) ? 'selected' : '';
                    ?>
                    <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="time-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Kami akan mengonfirmasi lokasi pertemuan setelah pengajuan disetujui</span>
                </div>
            </div>

            <div class="form-group">
                <label for="kontak">
                    <i class="fas fa-phone-alt"></i>
                    Kontak <span class="required">*</span>
                </label>
                <input type="text" name="kontak" id="kontak" class="form-control" required 
                       placeholder="Nomor WhatsApp / Email" value="<?php echo isset($_POST['kontak']) ? htmlspecialchars($_POST['kontak']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="keterangan">
                    <i class="fas fa-comment-alt"></i>
                    Keterangan Tambahan
                </label>
                <textarea name="keterangan" id="keterangan" class="form-control" 
                          placeholder="Jelaskan agenda atau topik yang akan dibahas..."><?php echo isset($_POST['keterangan']) ? htmlspecialchars($_POST['keterangan']) : ''; ?></textarea>
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-paper-plane"></i> Jadwalkan Temu
            </button>
        </form>
    </div>

    <div class="footer-info">
        <i class="fas fa-shield-alt"></i>
        <span>Data Anda akan dijaga kerahasiaannya</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('meetingForm');
    const submitBtn = document.getElementById('submitBtn');
    const modeOnline = document.getElementById('online');
    const modeOffline = document.getElementById('offline');
    const kotaGroup = document.getElementById('kotaGroup');
    const kotaSelect = document.getElementById('kota');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').min = today;
    
    // Toggle kota group berdasarkan mode
    function toggleKotaGroup() {
        if (modeOffline.checked) {
            kotaGroup.classList.add('show');
            kotaSelect.setAttribute('required', 'required');
        } else {
            kotaGroup.classList.remove('show');
            kotaSelect.removeAttribute('required');
        }
    }
    
    // Event listeners
    modeOnline.addEventListener('change', toggleKotaGroup);
    modeOffline.addEventListener('change', toggleKotaGroup);
    
    // Initial state
    toggleKotaGroup();
    
    // Form submission with loading state
    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });
    
    // Auto-format phone number
    const kontakInput = document.getElementById('kontak');
    kontakInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('62') && !value.startsWith('08') && !e.target.value.includes('@')) {
            if (value.startsWith('8')) {
                value = '62' + value;
            }
            e.target.value = value;
        }
    });
    
    // Smooth scroll to alerts
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

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