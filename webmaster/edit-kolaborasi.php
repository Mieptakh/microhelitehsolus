<?php
// ==================== KONEKSI DATABASE ====================
$host = 'sql212.infinityfree.com';
$db   = 'if0_38147269_mhteamsweb';
$user = 'if0_38147269';
$pass = 'Qmj1impTzafs';
$charset = 'utf8mb4';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// ==================== HANDLE DELETE ====================
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $old = $conn->query("SELECT logo FROM collaborations WHERE id=$id")->fetch_assoc();
    if ($old && file_exists("uploads/" . $old['logo'])) {
        unlink("uploads/" . $old['logo']);
    }
    $conn->query("DELETE FROM collaborations WHERE id=$id");
    header("Location: edit-kolaborasi.php");
    exit;
}

// ==================== HANDLE SUBMIT ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'] ?? '';
    $name       = $_POST['name'];
    $slug       = $_POST['slug'];
    $desc       = $_POST['description'];
    $tags       = $_POST['tags'];
    $website    = $_POST['website'];
    $logo       = $_FILES['logo']['name'] ?? '';
    $tmp        = $_FILES['logo']['tmp_name'] ?? '';

    if ($logo) {
        $ext      = pathinfo($logo, PATHINFO_EXTENSION);
        $newLogo  = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($tmp, "uploads/$newLogo");
    }

    if ($id) {
        // Edit
        if ($logo) {
            $old = $conn->query("SELECT logo FROM collaborations WHERE id=$id")->fetch_assoc();
            if ($old && file_exists("uploads/" . $old['logo'])) unlink("uploads/" . $old['logo']);
            $conn->query("UPDATE collaborations SET name='$name', slug='$slug', logo='$newLogo', description='$desc', tags='$tags', website='$website' WHERE id=$id");
        } else {
            $conn->query("UPDATE collaborations SET name='$name', slug='$slug', description='$desc', tags='$tags', website='$website' WHERE id=$id");
        }
    } else {
        // Tambah
        $conn->query("INSERT INTO collaborations (name, slug, logo, description, tags, website) 
                      VALUES ('$name', '$slug', '$newLogo', '$desc', '$tags', '$website')");
    }

    header("Location: edit-kolaborasi.php");
    exit;
}

// ==================== AMBIL DATA UNTUK EDIT ====================
$editData = [
    'id' => '', 'name' => '', 'slug' => '', 'description' => '',
    'tags' => '', 'website' => '', 'logo' => ''
];

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $row = $conn->query("SELECT * FROM collaborations WHERE id=$id")->fetch_assoc();
    if ($row) $editData = $row;
}

// ==================== TAMPILAN HTML ====================
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Kolaborasi</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            margin: 40px auto;
            max-width: 1000px;
            color: #333;
        }

        h1, h2 {
            color: #2c3e50;
        }

        form {
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        input[type="text"],
        input[type="url"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 16px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn {
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            display: inline-block;
            font-size: 14px;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-warning {
            background-color: #f39c12;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #d68910;
        }

        .btn + .btn {
            margin-left: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f4f6f9;
        }

        img {
            max-width: 60px;
            border-radius: 6px;
        }

        p img {
            max-width: 120px;
            border: 1px solid #ddd;
            padding: 4px;
            border-radius: 8px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            margin: 40px 0;
            border: none;
            border-top: 1px solid #e0e0e0;
        }

        @media (max-width: 768px) {
            body {
                margin: 20px;
            }

            table, form {
                font-size: 14px;
            }

            img {
                max-width: 40px;
            }

            form {
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <h1><?= $editData['id'] ? 'Edit Kolaborasi' : 'Tambah Kolaborasi' ?></h1>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <input type="text" name="name" placeholder="Nama" value="<?= htmlspecialchars($editData['name']) ?>" required>
        <input type="text" name="slug" placeholder="Slug" value="<?= htmlspecialchars($editData['slug']) ?>" required>
        <?php if ($editData['logo']): ?>
            <p><img src="uploads/<?= $editData['logo'] ?>" alt="logo"> (logo lama)</p>
        <?php endif ?>
        <input type="file" name="logo" <?= $editData['id'] ? '' : 'required' ?>>
        <textarea name="description" placeholder="Deskripsi" required><?= htmlspecialchars($editData['description']) ?></textarea>
        <input type="text" name="tags" placeholder="Tag" value="<?= htmlspecialchars($editData['tags']) ?>">
        <input type="url" name="website" placeholder="Website" value="<?= htmlspecialchars($editData['website']) ?>">
        <button type="submit"><?= $editData['id'] ? 'Update' : 'Simpan' ?></button>
        <?php if ($editData['id']): ?>
            <a href="edit-kolaborasi.php" class="btn">Batal</a>
        <?php endif ?>
    </form>

    <hr>
    <h2>Daftar Kolaborasi</h2>

    <?php
    $result = $conn->query("SELECT * FROM collaborations ORDER BY id DESC");
    if ($result->num_rows === 0): ?>
        <p>Belum ada data.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nama</th><th>Slug</th><th>Logo</th><th>Deskripsi</th><th>Tags</th><th>Website</th><th>Dibuat</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($c = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= $c['slug'] ?></td>
                        <td><img src="/uploads/<?= $c['logo'] ?>"></td>
                        <td><?= nl2br(htmlspecialchars($c['description'])) ?></td>
                        <td><?= $c['tags'] ?></td>
                        <td><a href="<?= $c['website'] ?>" target="_blank">Link</a></td>
                        <td><?= $c['created_at'] ?></td>
                        <td>
                            <a class="btn btn-warning" href="?edit=<?= $c['id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="?delete=<?= $c['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>
