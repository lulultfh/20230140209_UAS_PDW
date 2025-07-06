<?php
session_start();
require_once '../../config.php';

// Pastikan mahasiswa sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_SESSION['user_id'];

// Ambil daftar praktikum yang diikuti mahasiswa
$query = "
    SELECT p.id, p.namaPrak, p.deskripsi 
    FROM praktikum p
    JOIN daftar_praktikum dp ON dp.praktikum_id = p.id
    WHERE dp.mahasiswa_id = ?
";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $mahasiswa_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<?php
$pageTitle = 'Praktikum Saya';
$activePage = 'my_courses';
require_once '../templates/header_mahasiswa.php';
?>

<div class="max-w-screen-xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-primary mb-6">Daftar Praktikum yang Diikuti</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($prak = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-primary mb-2"><?= htmlspecialchars($prak['namaPrak']) ?></h3>
                    <p class="text-secondary mb-4"><?= htmlspecialchars($prak['deskripsi']) ?></p>
                    <a href="detail_praktikum.php?id=<?= $prak['id'] ?>" class="inline-block bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition">
                        Lihat Detail
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600">Kamu belum mendaftar ke praktikum manapun.</p>
    <?php endif; ?>
</div>

<?php require_once '../templates/footer_mahasiswa.php'; ?>
