<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$results = [];

if ($keyword !== '') {
    $search = '%' . $keyword . '%';
    $stmt = mysqli_prepare($conn, "SELECT id, namaPrak, deskripsi FROM praktikum WHERE namaPrak LIKE ? OR deskripsi LIKE ?");
    mysqli_stmt_bind_param($stmt, "ss", $search, $search);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($query)) {
        $results[] = $row;
    }
}

$pageTitle = "Cari Praktikum";
$activePage = "search";

require_once 'templates/header_mahasiswa.php';
?>

<h1 class="text-2xl font-bold text-primary mb-6">Hasil Pencarian untuk: <em><?= htmlspecialchars($keyword) ?></em></h1>

<?php if ($keyword === ''): ?>
    <p class="text-gray-700">Silakan ketikkan nama atau deskripsi praktikum untuk mencari.</p>
<?php elseif (empty($results)): ?>
    <p class="text-red-600">❌ Tidak ada praktikum yang cocok dengan kata kunci tersebut.</p>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($results as $prak): ?>
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-bold text-primary mb-2"><?= htmlspecialchars($prak['namaPrak']) ?></h2>
                <p class="text-gray-700 mb-4"><?= $prak['deskripsi'] ? htmlspecialchars($prak['deskripsi']) : 'Deskripsi belum tersedia.' ?></p>
                <a href="praktikum/detail_praktikum.php?id=<?= $prak['id'] ?>" class="text-sm text-white bg-primary px-4 py-2 rounded hover:bg-secondary transition">Lihat Detail</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'templates/footer_mahasiswa.php'; ?>
