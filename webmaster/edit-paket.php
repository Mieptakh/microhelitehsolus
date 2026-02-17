<?php
$host = 'sql212.infinityfree.com';
$db   = 'if0_38147269_mhteamsweb';
$user = 'if0_38147269';
$pass = 'Qmj1impTzafs';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

function slugify($text) {
    return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $text), '-'));
}

$notif = "";

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM packages WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) $notif = "Data berhasil dihapus!";
    else $notif = "Gagal menghapus data.";
    header("Location: edit-paket.php?notif=" . urlencode($notif));
    exit;
}

// Insert / Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = $_POST['id'] ?? '';
    $name        = trim($_POST['name']);
    $slug        = $_POST['slug'] ?: slugify($name);
    $price       = intval($_POST['price']);
    $features    = trim($_POST['features']);
    $desc        = trim($_POST['description']);
    $preview_url = trim($_POST['preview_url']);
    $screenshots = '';

    if (!empty($_FILES['screenshots']['name'][0])) {
        $uploaded = [];
        foreach ($_FILES['screenshots']['tmp_name'] as $key => $tmp_name) {
            $ext = strtolower(pathinfo($_FILES['screenshots']['name'][$key], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $_FILES['screenshots']['name'][$key]);
                move_uploaded_file($tmp_name, "uploads/$filename");
                $uploaded[] = $filename;
            }
        }
        $screenshots = implode(",", $uploaded);
    }

    if ($id) {
        $sql = "UPDATE packages SET name=?, slug=?, price=?, features=?, description=?, preview_url=?";
        if ($screenshots) $sql .= ", screenshots=?";
        $sql .= " WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($screenshots) {
            $stmt->bind_param("ssissssi", $name, $slug, $price, $features, $desc, $preview_url, $screenshots, $id);
        } else {
            $stmt->bind_param("ssisssi", $name, $slug, $price, $features, $desc, $preview_url, $id);
        }
        $notif = "Paket berhasil diperbarui!";
    } else {
        $stmt = $conn->prepare("INSERT INTO packages (name, slug, price, features, description, preview_url, screenshots)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $name, $slug, $price, $features, $desc, $preview_url, $screenshots);
        $notif = "Paket baru berhasil ditambahkan!";
    }

    if (!$stmt->execute()) $notif = "Terjadi kesalahan saat menyimpan data.";
    header("Location: edit-paket.php?notif=" . urlencode($notif));
    exit;
}

// Data edit
$edit = ['id'=>'', 'name'=>'', 'slug'=>'', 'price'=>'', 'features'=>'', 'description'=>'', 'preview_url'=>'', 'screenshots'=>''];
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM packages WHERE id=$id")->fetch_assoc();
    if ($res) $edit = $res;
}
$notif = $_GET['notif'] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>CRUD Paket - MHTeams</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f5f5f9;
  margin: 0; padding: 40px;
  max-width: 1100px; margin: auto;
  color: #2d2d2d; line-height: 1.6;
}
h2 {
  font-weight: 700; color: #7B1FA2;
  margin: 30px 0 20px; font-size: 1.8rem;
}
form {
  background: #fff; padding: 28px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  margin-bottom: 40px;
}
label { font-weight: 600; display: block; margin-top: 12px; color: #555; }
input, textarea {
  width: 100%; padding: 12px;
  border: 1.5px solid #ddd;
  border-radius: 10px; margin: 6px 0 18px;
  transition: .3s; background: #fafafa;
}
input:focus, textarea:focus {
  border-color: #9C27B0; background: #fff;
  box-shadow: 0 0 6px rgba(156,39,176,0.2);
}
button, .btn {
  display: inline-block; padding: 10px 18px;
  font-weight: 600; font-size: 14px;
  border-radius: 10px; cursor: pointer;
  border: none; transition: .3s;
  text-decoration: none;
}
button { background: linear-gradient(90deg,#9C27B0,#7B1FA2); color: #fff; }
button:hover { transform: translateY(-2px); }
.btn-secondary { background: #f1f1f1; color: #444; }
.btn-warning { background: #FFA000; color: #fff; }
.btn-danger { background: #E53935; color: #fff; }
table {
  width: 100%; border-collapse: collapse;
  margin-top: 30px; background: #fff;
  border-radius: 14px; overflow: hidden;
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
  font-size: 0.95rem;
}
thead { background: linear-gradient(90deg, #9C27B0, #FFD700); color: #fff; }
th, td { padding: 14px 16px; text-align: left; }
tbody tr:nth-child(odd){ background: #fafafa; }
tbody tr:hover { background: rgba(156,39,176,0.07); }
img {
  width: 80px; margin: 4px; border-radius: 8px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.12);
}
.toast {
  position: fixed; top: 20px; right: 20px;
  background: #7B1FA2; color: #fff;
  padding: 14px 20px; border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  animation: fadeInOut 4s forwards;
}
@keyframes fadeInOut {
  0% {opacity: 0; transform: translateY(-20px);}
  10% {opacity: 1; transform: translateY(0);}
  90% {opacity: 1;}
  100% {opacity: 0; transform: translateY(-20px);}
}
.modal-bg {
  display: none; position: fixed; top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.4); align-items: center; justify-content: center;
}
.modal {
  background: #fff; padding: 20px 30px; border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2); text-align: center;
}
</style>
<script>
function previewPPN(){
  let price = document.querySelector("input[name=price]").value;
  let ppn = document.getElementById("ppnPreview");
  if(price){
    let total = Math.round(price * 1.11);
    ppn.textContent = "Harga + PPN 11% = Rp " + total.toLocaleString("id-ID");
  } else { ppn.textContent = ""; }
}
function previewImages(event){
  let files = event.target.files;
  let preview = document.getElementById("imgPreview");
  preview.innerHTML = "";
  for(let f of files){
    let reader = new FileReader();
    reader.onload = e => {
      let img = document.createElement("img");
      img.src = e.target.result;
      preview.appendChild(img);
    };
    reader.readAsDataURL(f);
  }
}
function confirmDelete(url){
  document.getElementById("modalBg").style.display="flex";
  document.getElementById("deleteYes").onclick = ()=>window.location=url;
}
function closeModal(){ document.getElementById("modalBg").style.display="none"; }
</script>
</head>
<body>

<?php if($notif): ?>
<div class="toast"><?= htmlspecialchars($notif) ?></div>
<?php endif; ?>

<h2><?= $edit['id'] ? 'Edit Paket' : 'Tambah Paket' ?></h2>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $edit['id'] ?>">

  <label>Nama Paket:</label>
  <input name="name" value="<?= htmlspecialchars($edit['name']) ?>" required>

  <label>Slug:</label>
  <input name="slug" value="<?= htmlspecialchars($edit['slug']) ?>">

  <label>Harga (Rp):</label>
  <input name="price" type="number" value="<?= $edit['price'] ?>" required oninput="previewPPN()">
  <small id="ppnPreview" style="color:#7B1FA2;font-weight:600;"></small>

  <label>Fitur:</label>
  <textarea name="features"><?= htmlspecialchars($edit['features']) ?></textarea>

  <label>Deskripsi:</label>
  <textarea name="description"><?= htmlspecialchars($edit['description']) ?></textarea>

  <label>URL Preview:</label>
  <input name="preview_url" value="<?= htmlspecialchars($edit['preview_url']) ?>">

  <label>Screenshots:</label>
  <input type="file" name="screenshots[]" multiple onchange="previewImages(event)">
  <div id="imgPreview"></div>

  <?php if ($edit['screenshots']): ?>
  <p>Sudah ada screenshot:</p>
  <div>
    <?php foreach (explode(",", $edit['screenshots']) as $s): ?>
      <img src="uploads/<?= trim($s) ?>">
    <?php endforeach ?>
  </div>
  <?php endif ?>

  <button type="submit"><?= $edit['id'] ? 'Update' : 'Simpan' ?></button>
  <?php if ($edit['id']): ?>
    <a href="edit-paket.php" class="btn btn-secondary">Batal</a>
  <?php endif ?>
</form>

<h2>Daftar Paket</h2>
<?php
$data = $conn->query("SELECT * FROM packages ORDER BY id DESC");
if ($data->num_rows == 0): 
    echo "<p>Belum ada data.</p>";
else:
?>
<table>
  <thead>
    <tr>
      <th>Nama</th>
      <th>Harga</th>
      <th>Fitur</th>
      <th>Screenshot</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($p = $data->fetch_assoc()): 
        $priceWithPpn = $p['price'] * 1.11;
    ?>
    <tr>
      <td><?= htmlspecialchars($p['name']) ?><br><small><?= $p['slug'] ?></small></td>
      <td>
        Rp <?= number_format($p['price'],0,',','.') ?><br>
        <small>(+PPN 11% = Rp <?= number_format($priceWithPpn,0,',','.') ?>)</small>
      </td>
      <td>
        <ul>
        <?php foreach (explode(",", $p['features']) as $f): ?>
          <li><?= htmlspecialchars(trim($f)) ?></li>
        <?php endforeach ?>
        </ul>
      </td>
      <td>
        <?php foreach (explode(",", $p['screenshots']) as $s): ?>
          <img src="uploads/<?= trim($s) ?>">
        <?php endforeach ?>
      </td>
      <td>
        <a class="btn btn-warning" href="?edit=<?= $p['id'] ?>">Edit</a>
        <a class="btn btn-danger" href="javascript:void(0)" onclick="confirmDelete('?delete=<?= $p['id'] ?>')">Hapus</a>
      </td>
    </tr>
    <?php endwhile ?>
  </tbody>
</table>
<?php endif; ?>

<!-- Modal Konfirmasi -->
<div class="modal-bg" id="modalBg">
  <div class="modal">
    <p>Yakin mau menghapus data ini?</p>
    <button id="deleteYes" class="btn btn-danger">Ya, Hapus</button>
    <button onclick="closeModal()" class="btn btn-secondary">Batal</button>
  </div>
</div>

</body>
</html>
