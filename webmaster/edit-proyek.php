<?php
/**
 * edit-proyek.php
 * Single-file improved CRUD Projects (secure + interactive UI)
 * - Requires PHP 7.2+
 * - Ensure uploads/ writable
 * - Optional: GD extension for thumbnails
 *
 * Author: assistant for Miftakhul Huda (MHTeams)
 * Last update: 2025-09-21
 */

// Pastikan session dimulai dengan pengaturan yang aman
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// ---------- CONFIG ----------
$config = (object)[
    'db_host' => 'sql212.infinityfree.com',
    'db_user' => 'if0_38147269',
    'db_pass' => 'Qmj1impTzafs',
    'db_name' => 'if0_38147269_mhteamsweb',
    'uploads_dir' => __DIR__ . '/uploads',
    'uploads_url' => 'uploads', // relative
    'allowed_ext' => ['jpg','jpeg','png','gif','webp'],
    'allowed_mime' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    'max_file_size' => 3 * 1024 * 1024, // 3MB
    'thumb_prefix' => 'thumb_',
    'thumb_w' => 320,
    'thumb_h' => 240,
    'activity_log' => __DIR__ . '/activity.log',
    'max_desc_length' => 1000,
    'max_name_length' => 255,
    'max_slug_length' => 255,
    'max_url_length' => 512,
];

// ---------- UTIL ----------
function flash($type, $msg){
    $_SESSION['flash'][] = ['type'=>$type,'msg'=>$msg];
}

function get_flashes(){
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

function actlog($text){
    global $config;
    $line = date('Y-m-d H:i:s') . " | " . $text . PHP_EOL;
    @file_put_contents($config->activity_log, $line, FILE_APPEND | LOCK_EX);
}

function h($s){ 
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); 
}

function safe_filename($name){
    $name = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $name);
    $name = preg_replace('/_{2,}/', '_', $name);
    $name = trim($name, '_');
    return $name;
}

function slugify($text){
    $text = trim(mb_strtolower($text));
    $text = preg_replace('/[^\p{L}\p{N}]+/u','-', $text);
    $text = trim($text, '-');
    if ($text === '') return 'item-' . time();
    return $text;
}

function create_thumbnail($src, $dest, $w, $h){
    if (!extension_loaded('gd')) return false;
    
    $info = @getimagesize($src);
    if (!$info) return false;
    
    list($orig_w, $orig_h, $type) = $info;
    
    // Validasi tipe gambar
    if (!in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP])) {
        return false;
    }
    
    $ratio = min($w/$orig_w, $h/$orig_h, 1);
    $nw = max(1, (int)($orig_w*$ratio));
    $nh = max(1, (int)($orig_h*$ratio));
    
    $dst = imagecreatetruecolor($nw, $nh);
    
    // Preserve transparency for PNG and GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }
    
    switch ($type){
        case IMAGETYPE_JPEG: 
            $src_img = imagecreatefromjpeg($src); 
            break;
        case IMAGETYPE_PNG: 
            $src_img = imagecreatefrompng($src); 
            break;
        case IMAGETYPE_GIF: 
            $src_img = imagecreatefromgif($src); 
            break;
        case IMAGETYPE_WEBP:
            $src_img = imagecreatefromwebp($src);
            break;
        default: 
            return false;
    }
    
    if (!$src_img) return false;
    
    imagecopyresampled($dst, $src_img, 0, 0, 0, 0, $nw, $nh, $orig_w, $orig_h);
    
    switch ($type){
        case IMAGETYPE_JPEG: 
            $result = imagejpeg($dst, $dest, 86); 
            break;
        case IMAGETYPE_PNG: 
            $result = imagepng($dst, $dest, 8); 
            break;
        case IMAGETYPE_GIF: 
            $result = imagegif($dst, $dest); 
            break;
        case IMAGETYPE_WEBP:
            $result = imagewebp($dst, $dest, 86);
            break;
        default: 
            $result = false;
    }
    
    imagedestroy($dst); 
    imagedestroy($src_img);
    
    return $result;
}

function validate_image($file) {
    global $config;
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading file: " . $file['error'];
    }
    
    // Check file size
    if ($file['size'] > $config->max_file_size) {
        return "File terlalu besar (max 3MB).";
    }
    
    // Check file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $config->allowed_ext)) {
        return "Format gambar tidak diizinkan.";
    }
    
    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime, $config->allowed_mime)) {
        return "Tipe file tidak diizinkan.";
    }
    
    // Additional image validation
    $image_info = @getimagesize($file['tmp_name']);
    if (!$image_info) {
        return "File bukan gambar yang valid.";
    }
    
    return true;
}

// ensure uploads dir
if (!is_dir($config->uploads_dir)) {
    if (!@mkdir($config->uploads_dir, 0755, true)) {
        die("Gagal membuat direktori uploads. Pastikan direktori dapat ditulis.");
    }
}

// Generate CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// ---------- DB ----------
try {
    $mysqli = new mysqli($config->db_host, $config->db_user, $config->db_pass, $config->db_name);
    
    if ($mysqli->connect_errno) {
        throw new Exception("DB connect error: " . $mysqli->connect_error);
    }
    
    $mysqli->set_charset('utf8mb4');
    
    // ensure table exists
    $create_sql = "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        description TEXT,
        icon VARCHAR(64) DEFAULT 'code',
        image VARCHAR(255),
        url VARCHAR(512),
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    
    if (!$mysqli->query($create_sql)) {
        throw new Exception("Gagal membuat tabel: " . $mysqli->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    die("Database error: " . h($e->getMessage()));
}

// ---------- HANDLE ACTIONS ----------
// POST add/update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] === 'save')) {
    // CSRF validation
    if (empty($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        flash('error','Token invalid (CSRF).');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // Regenerate CSRF token after use
    $_SESSION['csrf'] = bin2hex(random_bytes(32));

    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '') ?: slugify($name);
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? 'code');
    $url = trim($_POST['url'] ?? '');

    // validation
    if ($name === '') {
        flash('error','Nama project wajib diisi.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if (mb_strlen($name) > $config->max_name_length) {
        flash('error','Nama project terlalu panjang.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if (mb_strlen($slug) > $config->max_slug_length) {
        flash('error','Slug terlalu panjang.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if (mb_strlen($description) > $config->max_desc_length) {
        flash('error','Deskripsi terlalu panjang.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if (mb_strlen($url) > $config->max_url_length) {
        flash('error','URL terlalu panjang.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
        flash('error', 'URL tidak valid.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Check if slug already exists (for new entries or when slug changes)
    if ($id === 0 || $slug !== $_POST['original_slug']) {
        $stmt = $mysqli->prepare("SELECT id FROM projects WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $stmt->close();
            flash('error', 'Slug sudah digunakan. Gunakan slug yang unik.');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        $stmt->close();
    }

    // handle file upload if any
    $uploaded_filename = null;
    if (!empty($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $validation_result = validate_image($_FILES['image']);
        
        if ($validation_result !== true) {
            flash('error', $validation_result);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        $f = $_FILES['image'];
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $safe = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $dest = $config->uploads_dir . '/' . $safe;
        
        if (!move_uploaded_file($f['tmp_name'], $dest)) {
            flash('error','Gagal menyimpan file.');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        // Set proper permissions
        chmod($dest, 0644);
        
        // create thumbnail if GD present
        $thumbDest = $config->uploads_dir . '/' . $config->thumb_prefix . $safe;
        if (create_thumbnail($dest, $thumbDest, $config->thumb_w, $config->thumb_h)) {
            chmod($thumbDest, 0644);
        }
        
        $uploaded_filename = $safe;
    }

    if ($id > 0) {
        // update
        // fetch old image to delete if replaced
        $old_image = null;
        $stmt = $mysqli->prepare("SELECT image FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $old = $result->fetch_assoc();
            $old_image = $old['image'];
        }
        $stmt->close();

        if ($uploaded_filename) {
            // delete old files
            if (!empty($old_image)) {
                @unlink($config->uploads_dir . '/' . $old_image);
                @unlink($config->uploads_dir . '/' . $config->thumb_prefix . $old_image);
            }
            
            $stmt = $mysqli->prepare("UPDATE projects SET name=?, slug=?, description=?, icon=?, image=?, url=? WHERE id=?");
            $stmt->bind_param("ssssssi", $name, $slug, $description, $icon, $uploaded_filename, $url, $id);
        } else {
            $stmt = $mysqli->prepare("UPDATE projects SET name=?, slug=?, description=?, icon=?, url=? WHERE id=?");
            $stmt->bind_param("sssssi", $name, $slug, $description, $icon, $url, $id);
        }
        
        if ($stmt->execute()) {
            flash('success','Project berhasil diperbarui.');
            actlog("UPDATE project id={$id} name={$name}");
        } else {
            flash('error','Gagal update: ' . $mysqli->error);
        }
        $stmt->close();
    } else {
        // insert
        if (!$uploaded_filename) {
            flash('error','Gambar wajib diunggah untuk project baru.');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        $stmt = $mysqli->prepare("INSERT INTO projects (name, slug, description, icon, image, url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $slug, $description, $icon, $uploaded_filename, $url);
        
        if ($stmt->execute()) {
            $new_id = $stmt->insert_id;
            flash('success','Project berhasil disimpan.');
            actlog("INSERT project id={$new_id} name={$name}");
        } else {
            // Delete uploaded file if DB insert failed
            @unlink($config->uploads_dir . '/' . $uploaded_filename);
            @unlink($config->uploads_dir . '/' . $config->thumb_prefix . $uploaded_filename);
            
            flash('error','Gagal simpan: ' . $mysqli->error);
        }
        $stmt->close();
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// POST delete (use POST for safety)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    // CSRF validation
    if (empty($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        flash('error','Token invalid (CSRF).');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // Regenerate CSRF token after use
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
    
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        flash('error','ID tidak valid.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // get image names
    $stmt = $mysqli->prepare("SELECT image FROM projects WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $mysqli->prepare("DELETE FROM projects WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // delete files
        if (!empty($res['image'])) {
            @unlink($config->uploads_dir . '/' . $res['image']);
            @unlink($config->uploads_dir . '/' . $config->thumb_prefix . $res['image']);
        }
        flash('success','Project dihapus.');
        actlog("DELETE project id={$id}");
    } else {
        flash('error','Gagal menghapus: ' . $mysqli->error);
    }
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ---------- LOAD EDIT DATA IF REQUESTED ----------
$edit = ['id'=>'','name'=>'','slug'=>'','description'=>'','icon'=>'code','image'=>'','url'=>''];
$original_slug = '';

if (isset($_GET['edit'])) {
    $eid = intval($_GET['edit']);
    if ($eid > 0) {
        $stmt = $mysqli->prepare("SELECT * FROM projects WHERE id=?");
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $edit = $result->fetch_assoc();
            $original_slug = $edit['slug'];
        }
        $stmt->close();
    }
}

// ---------- FETCH ALL PROJECTS ----------
$projects = [];
$res = $mysqli->query("SELECT * FROM projects ORDER BY id DESC");

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $projects[] = $row;
    }
}

// get flash messages
$flashes = get_flashes();

// Handle download log request
if (isset($_GET['download_log']) && file_exists($config->activity_log)) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="activity-'.date('Y-m-d').'.log"');
    readfile($config->activity_log);
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>CRUD Projects — MHTeams</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>
:root{
  --bg:#f5f6fa; --card:#fff; --accent1:#9C27B0; --accent2:#7B1FA2; --muted:#6b7280;
}
*{box-sizing:border-box}
body{font-family:Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Poppins', Arial; margin:0; background:var(--bg); color:#111; padding:28px;}
.container{max-width:1200px;margin:0 auto}
.header{display:flex;align-items:center;justify-content:space-between}
.brand{display:flex;align-items:center;gap:12px}
.logo{width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--accent1),var(--accent2));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
.title{font-weight:700}
.card{background:var(--card);border-radius:12px;padding:18px;box-shadow:0 8px 28px rgba(2,6,23,0.06);margin-top:18px}
.grid{display:grid;grid-template-columns:1fr 380px;gap:18px;margin-top:18px}
@media(max-width:980px){ .grid{grid-template-columns:1fr} .side {order:2} .main{order:1} }
.form-row{display:flex;gap:8px}
.input, textarea, select{width:100%;padding:10px;border-radius:10px;border:1px solid #e6e9ef;background:#fbfdff}
.input:focus,textarea:focus{outline:none;box-shadow:0 0 0 6px rgba(156,39,176,0.08);border-color:var(--accent2)}
.label{font-weight:600;color:var(--muted);margin-bottom:8px;display:block}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 12px;border-radius:10px;border:none;cursor:pointer}
.btn-primary{background:linear-gradient(90deg,var(--accent2),var(--accent1));color:#fff}
.btn-ghost{background:transparent;border:1px solid #eef2ff;color:#111;padding:8px 10px}
.btn-danger{background:#ef4444;color:#fff}
.preview-img{width:92px;height:64px;object-fit:cover;border-radius:8px;border:1px solid #eef2ff}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table th{background:linear-gradient(90deg,var(--accent2),#f59e0b);color:#fff;padding:12px;text-align:left}
.table td{padding:12px;border-bottom:1px solid #f3f4f6;vertical-align:top}
.small{font-size:0.85rem;color:var(--muted)}
.toast-wrap{position:fixed;right:20px;top:20px;z-index:999}
.toast{background:#111827;color:#fff;padding:12px 14px;border-radius:10px;margin-bottom:8px;box-shadow:0 10px 40px rgba(2,6,23,0.3)}
.toast-success{background:#10b981}
.toast-error{background:#ef4444}
.modal{position:fixed;left:0;top:0;right:0;bottom:0;background:rgba(0,0,0,0.45);display:none;align-items:center;justify-content:center;z-index:9999}
.modal .box{background:#fff;padding:18px;border-radius:10px;min-width:320px;box-shadow:0 8px 30px rgba(2,6,23,0.2)}
.actions{display:flex;flex-direction:column;gap:8px}
.kv{display:flex;gap:8px;align-items:center}
.footer{margin-top:28px;color:var(--muted);font-size:0.9rem}
.debug{background:#111827;color:white;padding:12px;border-radius:8px;font-family:monospace;white-space:pre-wrap}
.char-count{font-size:0.8rem;color:var(--muted);text-align:right;margin-top:4px}
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <div class="brand">
      <div class="logo">MH</div>
      <div>
        <div class="title">MHTeams — Project Manager</div>
        <div class="small">Manage projects: add, edit, delete — secure & elegant</div>
      </div>
    </div>
    <div class="small">Server time: <?= date('Y-m-d H:i:s') ?></div>
  </div>

  <!-- TOASTS -->
  <div class="toast-wrap" id="toastWrap">
    <?php foreach ($flashes as $f): ?>
      <div class="toast toast-<?= h($f['type']) ?>" data-type="<?= h($f['type']) ?>"><?= h($f['msg']) ?></div>
    <?php endforeach; ?>
  </div>

  <div class="grid">
    <div class="main">
      <div class="card">
        <h3 style="margin:0"><?= $edit['id'] ? 'Edit Project' : 'Tambah Project' ?></h3>
        <p class="small" style="margin:6px 0 12px">Auto-slug saat mengetik nama. Upload gambar maksimal 3MB.</p>

        <form method="post" enctype="multipart/form-data" id="formSave">
          <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="id" value="<?= h($edit['id']) ?>">
          <input type="hidden" name="original_slug" value="<?= h($original_slug) ?>">

          <label class="label">Nama Project <span class="small">(max <?= $config->max_name_length ?> karakter)</span></label>
          <input class="input" type="text" name="name" id="name" value="<?= h($edit['name']) ?>" required 
                 maxlength="<?= $config->max_name_length ?>" oninput="autoSlug();updateCharCount('name', 'nameCount', <?= $config->max_name_length ?>)">
          <div id="nameCount" class="char-count">0/<?= $config->max_name_length ?></div>

          <label class="label">Slug <span class="small">(max <?= $config->max_slug_length ?> karakter)</span></label>
          <input class="input" type="text" name="slug" id="slug" value="<?= h($edit['slug']) ?>" 
                 maxlength="<?= $config->max_slug_length ?>" oninput="updateCharCount('slug', 'slugCount', <?= $config->max_slug_length ?>)">
          <div id="slugCount" class="char-count">0/<?= $config->max_slug_length ?></div>

          <label class="label">Deskripsi <span class="small">(max <?= $config->max_desc_length ?> karakter)</span></label>
          <textarea class="input" name="description" id="description" rows="4" required 
                    maxlength="<?= $config->max_desc_length ?>" oninput="updateCharCount('description', 'descCount', <?= $config->max_desc_length ?>)"><?= h($edit['description']) ?></textarea>
          <div id="descCount" class="char-count">0/<?= $config->max_desc_length ?></div>

          <label class="label">Icon (ex: code, user, tasks)</label>
          <input class="input" type="text" name="icon" value="<?= h($edit['icon']) ?>">

          <label class="label">Gambar <?= $edit['id'] ? '(kosong = tidak berubah)' : '' ?></label>
          <?php if ($edit['image']): 
              $imgThumb = file_exists($config->uploads_dir . '/' . $config->thumb_prefix . $edit['image']) ? 
                          ($config->uploads_url . '/' . $config->thumb_prefix . $edit['image']) : 
                          ($config->uploads_url . '/' . $edit['image']);
          ?>
            <div style="display:flex;gap:8px;align-items:center;margin-bottom:8px">
              <img src="<?= h($imgThumb) ?>" class="preview-img" id="currentImage">
              <div class="small">Gambar lama</div>
            </div>
          <?php endif; ?>
          <input class="input" type="file" name="image" id="imageInput" accept="image/*">
          <div id="previewNew" style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px"></div>

          <label class="label">URL Project <span class="small">(max <?= $config->max_url_length ?> karakter)</span></label>
          <input class="input" type="url" name="url" value="<?= h($edit['url']) ?>" 
                 maxlength="<?= $config->max_url_length ?>" oninput="updateCharCount('url', 'urlCount', <?= $config->max_url_length ?>)">
          <div id="urlCount" class="char-count">0/<?= $config->max_url_length ?></div>

          <div style="margin-top:12px;display:flex;gap:8px;align-items:center">
            <button class="btn btn-primary" type="submit"> <?= $edit['id'] ? 'Update' : 'Simpan' ?> </button>
            <a class="btn btn-ghost" href="<?= $_SERVER['PHP_SELF'] ?>">Bersihkan</a>
            <?php if ($edit['id']): ?>
              <button type="button" class="btn btn-danger" onclick="openDeleteModal(<?= intval($edit['id']) ?>)">Hapus Project</button>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <div class="card" style="margin-top:18px">
        <h3 style="margin:0">Daftar Projects</h3>
        <p class="small" style="margin:6px 0 12px">Total: <?= count($projects) ?></p>

        <table class="table" aria-describedby="list">
          <thead>
            <tr>
              <th>ID</th><th>Nama</th><th>Gambar</th><th>Deskripsi</th><th>URL</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($projects)): ?>
              <tr><td colspan="6">Belum ada data.</td></tr>
            <?php endif; ?>
            <?php foreach ($projects as $p): 
                $thumb = file_exists($config->uploads_dir . '/' . $config->thumb_prefix . $p['image']) ? 
                         ($config->uploads_url . '/' . $config->thumb_prefix . $p['image']) : 
                         ($p['image'] ? $config->uploads_url . '/' . $p['image'] : '');
            ?>
              <tr>
                <td><?= intval($p['id']) ?></td>
                <td>
                  <div style="font-weight:700"><?= h($p['name']) ?></div>
                  <div class="small"><?= h($p['slug']) ?></div>
                  <div class="small">Icon: <?= h($p['icon']) ?></div>
                </td>
                <td><?php if ($thumb): ?><img src="<?= h($thumb) ?>" class="preview-img"><?php else: ?>-<?php endif; ?></td>
                <td><?= nl2br(h(mb_strlen($p['description']) > 100 ? mb_substr($p['description'], 0, 100) . '...' : $p['description'])) ?></td>
                <td><?php if ($p['url']): ?><a href="<?= h($p['url']) ?>" target="_blank" rel="noopener">Lihat</a><?php else: ?>-<?php endif; ?></td>
                <td style="white-space:nowrap">
                  <a class="btn btn-ghost" href="?edit=<?= intval($p['id']) ?>">Edit</a>
                  <!-- delete form -->
                  <form method="post" style="display:inline" onsubmit="return confirm('Yakin hapus project ini?')">
                    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= intval($p['id']) ?>">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>

    <aside class="side">
      <div class="card">
        <h4 style="margin:0">Quick Tools</h4>
        <div class="small" style="margin-top:8px">Activity log dan environment</div>
        <div style="margin-top:12px" class="actions">
          <button class="btn btn-ghost" onclick="document.location='<?= $_SERVER['PHP_SELF'] ?>?debug=1'">Env Check</button>
          <button class="btn btn-ghost" onclick="document.location='<?= $_SERVER['PHP_SELF'] ?>?download_log=1'">Download Log</button>
          <button class="btn btn-ghost" onclick="clearLog()">Clear Log</button>
        </div>
      </div>

      <div class="card" style="margin-top:12px">
        <h4 style="margin:0">Activity Log (recent)</h4>
        <div style="margin-top:8px;max-height:220px;overflow:auto;background:#fbfdff;padding:8px;border-radius:8px">
          <?php
            if (file_exists($config->activity_log)) {
              $lines = array_slice(array_reverse(file($config->activity_log)), 0, 50);
              echo '<pre class="small" style="margin:0">'.h(implode('', $lines)).'</pre>';
            } else {
              echo '<div class="small">Log kosong.</div>';
            }
          ?>
        </div>
      </div>
    </aside>
  </div>

  <div class="footer">Made for <strong>Miftakhul Huda</strong> • MHTeams — <?= date('Y') ?></div>
</div>

<!-- Modal (hidden) -->
<div class="modal" id="modalDelete">
  <div class="box">
    <h4>Hapus Project</h4>
    <p class="small">Tindakan ini tidak dapat dibatalkan. Semua file terkait juga akan dihapus.</p>
    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
      <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
      <form id="deleteForm" method="post" style="display:inline">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="deleteId" value="">
        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
      </form>
    </div>
  </div>
</div>

<script>
// Initialize character counters on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCharCount('name', 'nameCount', <?= $config->max_name_length ?>);
    updateCharCount('slug', 'slugCount', <?= $config->max_slug_length ?>);
    updateCharCount('description', 'descCount', <?= $config->max_desc_length ?>);
    updateCharCount('url', 'urlCount', <?= $config->max_url_length ?>);
    
    // toast fadeout
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach((t,i)=> setTimeout(()=> {
        t.style.transition = 'opacity 0.5s';
        t.style.opacity = '0';
        setTimeout(() => t.remove(), 500);
    }, 3500 + i*200));
});

// auto-slug
function autoSlug(){
    const name = document.getElementById('name').value;
    let s = name.trim().toLowerCase();
    s = s.normalize('NFKD').replace(/[^\w\- ]+/g,'').replace(/\s+/g,'-').replace(/\-+/g,'-');
    document.getElementById('slug').value = s;
    updateCharCount('slug', 'slugCount', <?= $config->max_slug_length ?>);
}

// character counter
function updateCharCount(inputId, counterId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    if (input && counter) {
        const length = input.value.length;
        counter.textContent = `${length}/${maxLength}`;
        
        // Change color if approaching limit
        if (length > maxLength * 0.9) {
            counter.style.color = '#ef4444';
        } else {
            counter.style.color = 'var(--muted)';
        }
    }
}

// preview new image
document.getElementById('imageInput').addEventListener('change', function(e){
    const wrap = document.getElementById('previewNew');
    wrap.innerHTML = '';
    const files = e.target.files;
    if (!files || !files.length) return;
    
    Array.from(files).forEach(file=>{
        if (!file.type.startsWith('image/')) {
            alert('Hanya file gambar yang diizinkan.');
            e.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(ev){
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.className = 'preview-img';
            wrap.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// delete modal
function openDeleteModal(id){
    document.getElementById('deleteId').value = id;
    document.getElementById('modalDelete').style.display = 'flex';
}

function closeModal(){
    document.getElementById('modalDelete').style.display = 'none';
}

// clear log
function clearLog() {
    if (confirm('Yakin ingin menghapus semua log?')) {
        fetch('<?= $_SERVER['PHP_SELF'] ?>?clear_log=1')
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal menghapus log.');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
    }
}

// debug / download log
<?php if (isset($_GET['debug'])): ?>
    // show debug box
    (function(){
        const box = document.createElement('div');
        box.style.position='fixed'; box.style.right='20px'; box.style.bottom='20px';
        box.style.maxWidth='420px'; box.style.zIndex=9999; box.innerHTML = `
        <div class="card" style="padding:12px">
            <div style="font-weight:700">DEBUG</div>
            <div class="small" style="margin-top:8px">
            PHP: <?= phpversion() ?><br>
            GD: <?= extension_loaded('gd') ? 'yes' : 'no' ?><br>
            Uploads dir: <?= h($config->uploads_dir) ?><br>
            Uploads writable: <?= is_writable($config->uploads_dir) ? 'yes' : 'no' ?><br>
            Total projects: <?= count($projects) ?>
            </div>
            <button style="margin-top:8px" onclick="this.parentElement.parentElement.remove()">Tutup</button>
        </div>`;
        document.body.appendChild(box);
    })();
<?php endif; ?>

// Handle clear log request
<?php
if (isset($_GET['clear_log']) && file_exists($config->activity_log)) {
    if (file_put_contents($config->activity_log, '') !== false) {
        actlog("LOG CLEARED by user");
        echo "location.href = '" . $_SERVER['PHP_SELF'] . "';";
    } else {
        echo "alert('Gagal menghapus log.');";
    }
    exit;
}
?>
</script>

</body>
</html>