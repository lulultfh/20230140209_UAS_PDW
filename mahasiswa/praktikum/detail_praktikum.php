<?php
session_start();
require_once __DIR__ . '/../templates/header_mahasiswa.php';
require_once '../../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_SESSION['user_id'];
$praktikum_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Info praktikum
$prakQuery = mysqli_prepare($conn, "SELECT namaPrak, deskripsi FROM praktikum WHERE id = ?");
mysqli_stmt_bind_param($prakQuery, "i", $praktikum_id);
mysqli_stmt_execute($prakQuery);
$prakResult = mysqli_stmt_get_result($prakQuery);
$praktikum = mysqli_fetch_assoc($prakResult);

// Modul
$query = "SELECT id, judul, file FROM modul WHERE praktikum_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $praktikum_id);
mysqli_stmt_execute($stmt);
$modul_result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Detail Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#B82132',
                        secondary: '#D2665A',
                        peach: '#F2B28C',
                        light: '#F6DED8',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light font-sans">
    <div class="max-w-5xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-2xl font-bold text-primary mb-2">Detail Praktikum</h1>
            <h2 class="text-lg font-semibold text-secondary mb-1"><?= htmlspecialchars($praktikum['namaPrak']) ?></h2>
            <p class="text-gray-700"><?= nl2br(htmlspecialchars($praktikum['deskripsi'])) ?></p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold text-primary mb-4">Modul Tersedia:</h3>
            <table class="w-full text-sm text-left border border-gray-300">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="px-4 py-2">Judul Modul</th>
                        <th class="px-4 py-2">File</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Nilai</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php while ($modul = mysqli_fetch_assoc($modul_result)): ?>
                        <?php
                        $check = mysqli_prepare($conn, "SELECT * FROM laporan WHERE mahasiswa_id = ? AND modul_id = ?");
                        mysqli_stmt_bind_param($check, "ii", $mahasiswa_id, $modul['id']);
                        mysqli_stmt_execute($check);
                        $laporan_result = mysqli_stmt_get_result($check);
                        $laporan = mysqli_fetch_assoc($laporan_result);
                        ?>
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-2"><?= htmlspecialchars($modul['judul']) ?></td>
                            <td class="px-4 py-2">
                                <a href="../../asisten/manajemen_modul/uploads/<?= htmlspecialchars($modul['file']) ?>"
                                    class="text-blue-600 hover:underline" target="_blank">Download</a>
                            </td>
                            <td class="px-4 py-2">
                                <?= $laporan ? htmlspecialchars($laporan['status']) : '<span class="text-gray-500">Belum Mengumpulkan</span>' ?>
                            </td>
                            <td class="px-4 py-2">
                                <?= $laporan && $laporan['nilai'] !== null ? htmlspecialchars($laporan['nilai']) : '-' ?>
                            </td>
                            <td class="px-4 py-2">
                                <?php if (!$laporan): ?>
                                    <!-- Kumpulkan -->
                                    <form action="upload_mahasiswa.php" method="post" enctype="multipart/form-data"
                                        class="flex flex-col gap-2 sm:flex-row">
                                        <input type="hidden" name="modul_id" value="<?= $modul['id'] ?>">
                                        <input type="hidden" name="praktikum_id" value="<?= $praktikum_id ?>">
                                        <input type="file" name="file_laporan" required class="text-sm">
                                        <button type="submit" class="text-green-600 hover:underline">Kumpulkan</button>
                                    </form>
                                <?php else: ?>
                                    <!-- Update dan Hapus -->
                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center">
                                        <!-- Update -->
                                        <form action="update_laporan.php" method="post" enctype="multipart/form-data"
                                            class="flex gap-2 items-center">
                                            <input type="hidden" name="modul_id" value="<?= $modul['id'] ?>">
                                            <input type="hidden" name="praktikum_id" value="<?= $praktikum_id ?>">
                                            <input type="file" name="file_laporan" required class="text-sm">
                                            <button type="submit" class="text-yellow-600 hover:underline">Update</button>
                                        </form>

                                        <!-- Hapus -->
                                        <form action="delete_laporan.php" method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            <input type="hidden" name="modul_id" value="<?= $modul['id'] ?>">
                                            <input type="hidden" name="praktikum_id" value="<?= $praktikum_id ?>">
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
// 3. Panggil Footer
require_once '../templates/footer_mahasiswa.php';
?>