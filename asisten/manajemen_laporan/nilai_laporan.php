<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
    header("Location: ../login.php");
    exit();
}

// Tangani POST lebih awal sebelum ada output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nilai = $_POST['nilai'];
    $feedback = $_POST['feedback'];

    $update = mysqli_prepare($conn, "UPDATE laporan SET nilai = ?, feedback = ?, status = 'Sudah Dinilai' WHERE id = ?");
    mysqli_stmt_bind_param($update, "ssi", $nilai, $feedback, $id);
    mysqli_stmt_execute($update);

    // Redirect balik ke laporan_masuk (pastikan tidak ada output sebelum ini!)
    header("Location: laporan_masuk.php");
    exit();
}

// Ambil data laporan
$laporan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_prepare($conn, "SELECT laporan.*, users.nama AS nama_mahasiswa, modul.judul AS judul_modul 
                                FROM laporan 
                                JOIN users ON laporan.mahasiswa_id = users.id 
                                JOIN modul ON laporan.modul_id = modul.id 
                                WHERE laporan.id = ?");
mysqli_stmt_bind_param($query, "i", $laporan_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$laporan = mysqli_fetch_assoc($result);

if (!$laporan) {
    die("Laporan tidak ditemukan.");
}

$pageTitle = 'Nilai Laporan';
$activePage = 'laporan';
require_once '../templates/header.php';
?>

<div class="max-w-2xl mx-auto my-10 bg-white shadow-md rounded px-8 py-6">
    <h2 class="text-xl font-bold text-darkblue mb-4">Form Penilaian</h2>

    <p class="mb-2"><strong>Mahasiswa:</strong> <?= htmlspecialchars($laporan['nama_mahasiswa']) ?></p>
    <p class="mb-2"><strong>Modul:</strong> <?= htmlspecialchars($laporan['judul_modul']) ?></p>
    <p class="mb-4">
        <strong>File Laporan:</strong> 
        <a href="uploads/<?= htmlspecialchars($laporan['file_laporan']) ?>" target="_blank" class="text-blue-600 underline">Lihat Laporan</a>
    </p>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $laporan['id'] ?>">

        <label class="block mb-2 font-medium">Nilai:</label>
        <input type="number" name="nilai" value="<?= htmlspecialchars($laporan['nilai']) ?>" class="w-full border border-gray-300 px-4 py-2 rounded mb-4" required>

        <label class="block mb-2 font-medium">Feedback:</label>
        <textarea name="feedback" rows="4" class="w-full border border-gray-300 px-4 py-2 rounded mb-4"><?= htmlspecialchars($laporan['feedback']) ?></textarea>

        <button type="submit" class="bg-darkblue text-white px-6 py-2 rounded hover:bg-midblue">Simpan Penilaian</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
