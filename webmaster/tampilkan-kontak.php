<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (!isLoggedIn()) {
    header('Location: /webmaster');
    exit;
}

$stmt = $pdo->query("SELECT * FROM kontak ORDER BY tanggal_kirim DESC");
$kontak = $stmt->fetchAll();

$title = "Data Kontak Pengunjung";
include __DIR__ . '/include/head.php';
?>

<div class="container my-4">
    <h1>Pesan Masuk</h1>

    <?php if (count($kontak) === 0): ?>
        <p>Tidak ada pesan yang masuk.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Pesan</th>
                    <th>Tanggal Kirim</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kontak as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kontak']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_kirim'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="/webmaster/dashboard" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a></p>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>
