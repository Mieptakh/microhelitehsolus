<?php
require_once __DIR__ . '/../webmaster/includes/db.php';
include 'includes/head.php';
include 'includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_instansi = $_POST['nama_instansi'] ?? '';
    $kontak = $_POST['kontak'] ?? '';
    $barter_value = $_POST['barter_value'] ?? '';

    // Proses upload file (hanya 1 file untuk contoh ini)
    $lampiran = null;
    if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = basename($_FILES['lampiran']['name']);
        $targetFile = $uploadDir . time() . '_' . $filename;
        if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $targetFile)) {
            $lampiran = basename($targetFile);
        } else {
            echo "Gagal mengupload file.";
        }
    }

    // Simpan ke database
    if ($nama_instansi && $kontak && $barter_value) {
        $stmt = $pdo->prepare("INSERT INTO pengajuan_kolaborasi (nama_instansi, kontak, barter_value, lampiran) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_instansi, $kontak, $barter_value, $lampiran]);
        echo "Pengajuan kolaborasi berhasil dikirim.";
    } else {
        echo "Lengkapi semua data.";
    }
}
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
}

h2 {
    text-align: center;
    color: #4a4a4a;
    font-size: 2.2rem;
    margin-top: 40px;
    margin-bottom: 40px;
}

/* Form card */
form {
    max-width: 650px;
    margin: 0 auto;
    margin-bottom:40px;
    padding: 35px 40px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

form:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 45px rgba(0,0,0,0.12);
}

/* Labels */
label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 1rem;
}

/* Inputs & textarea */
input[type="text"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 12px 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background: #fafafa;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    box-sizing: border-box;
}

input[type="text"]:focus,
textarea:focus,
input[type="file"]:focus {
    border-color: #9c27b0;
    box-shadow: 0 0 6px rgba(156,39,176,0.3);
    outline: none;
}

/* Textarea resize */
textarea {
    resize: vertical;
    min-height: 100px;
}

/* File input custom style */
input[type="file"] {
    padding: 8px 12px;
    cursor: pointer;
    color: #555;
    font-family:poppins;
}

input[type="file"]::-webkit-file-upload-button {
    padding: 8px 16px;
    background: #9c27b0;
    font-family:poppins;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
}

input[type="file"]::-webkit-file-upload-button:hover {
    background: #7b1fa2;
}

/* Submit button */
button {
    background: linear-gradient(135deg, #9c27b0, #ffb74d);
    color: #fff;
    padding: 14px 0;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    font-family:poppins;
    cursor: pointer;
    width: 100%;
    transition: all 0.3s ease;
}

button:hover {
    background: linear-gradient(135deg, #7b1fa2, #ffa726);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}

/* Responsive */
@media (max-width: 768px) {
    form {
        padding: 30px 25px;
    }

    h2 {
        font-size: 1.9rem;
    }
}

@media (max-width: 480px) {
    form {
        padding: 25px 20px;
    }

    h2 {
        font-size: 1.7rem;
    }
}
</style>

<h2>Form Pengajuan Kolaborasi</h2>
<form method="post" enctype="multipart/form-data">
    <label>Nama/Instansi yang diwakili:</label><br>
    <input type="text" name="nama_instansi" required><br><br>

    <label>Kontak yang dapat dihubungi:</label><br>
    <input type="text" name="kontak" required><br><br>

    <label>Barter Value (jelaskan keuntungan/barter yang diinginkan):</label><br>
    <textarea name="barter_value" rows="4" required></textarea><br><br>

    <label>Upload Lampiran (file pendukung seperti bukti followers, sosial media, dll):</label><br>
    <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"><br><br>

    <button type="submit">Kirim Pengajuan</button>
</form>
<?php include 'includes/footer.php'; ?>
