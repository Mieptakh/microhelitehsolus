<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (!isLoggedIn()) {
    header('Location: /webmaster');
    exit;
}

$stmt = $pdo->query("SELECT * FROM jadwal_temu ORDER BY tanggal, waktu");
$jadwal = $stmt->fetchAll();

$title = "Jadwal Temu"; // Judul halaman
include __DIR__ . '/include/head.php';
?>

<div class="container my-4">
    <h1 class="mb-4">Jadwal Temu Terjadwal</h1>

    <?php if (count($jadwal) === 0): ?>
        <p>Belum ada jadwal temu yang tercatat.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Mode</th>
                    <th>Kontak</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal as $i => $data): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($data['nama']) ?></td>
                        <td><?= htmlspecialchars($data['instansi'] ?: '-') ?></td>
                        <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                        <td><?= date('H:i', strtotime($data['waktu'])) ?></td>
                        <td><?= ucfirst($data['mode']) ?></td>
                        <td><?= htmlspecialchars($data['kontak']) ?></td>
                        <td><?= nl2br(htmlspecialchars($data['keterangan'])) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

    <p><a href="/webmaster/dashboard" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a></p>
</div>

<?php include __DIR__ . '/include/footer.php'; // footer.php berisi closing body & html tag ?>
