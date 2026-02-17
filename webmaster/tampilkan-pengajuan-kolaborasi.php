<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (!isLoggedIn()) {
    header('Location: /webmaster');
    exit;
}

$stmt = $pdo->query("SELECT * FROM pengajuan_kolaborasi ORDER BY tanggal_pengajuan DESC");
$kolaborasiList = $stmt->fetchAll();

$title = "Daftar Pengajuan Kolaborasi";
include __DIR__ . '/include/head.php';
?>

<div class="container my-4">
    <h1>Pengajuan Kolaborasi</h1>

    <?php if (count($kolaborasiList) === 0): ?>
        <p>Belum ada pengajuan kolaborasi.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama/Instansi</th>
                    <th>Kontak</th>
                    <th>Barter Value</th>
                    <th>Lampiran</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kolaborasiList as $index => $kolaborasi): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($kolaborasi['nama_instansi']) ?></td>
                        <td><?= htmlspecialchars($kolaborasi['kontak']) ?></td>
                        <td><?= nl2br(htmlspecialchars($kolaborasi['barter_value'])) ?></td>
                        <td>
                            <?php if ($kolaborasi['lampiran']): ?>
                                <a href="/uploads/<?= rawurlencode($kolaborasi['lampiran']) ?>" target="_blank" rel="noopener noreferrer">Lihat Lampiran</a>
                            <?php else: ?>
                                Tidak ada
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($kolaborasi['tanggal_pengajuan'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="/webmaster/dashboard" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a></p>
</div>

<?php include __DIR__ . '/include/footer.php'; ?>
