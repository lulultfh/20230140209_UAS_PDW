<?php
$pageTitle = 'Penilaian Laporan';
$activePage = 'laporan';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

$id = $_GET['id'] ?? 0;
$laporan = mysqli_query($conn, "
    SELECT laporan.*, modul.judul AS judul_modul, praktikum.namaPrak, users.nama AS nama_mahasiswa
    FROM laporan
    JOIN modul ON laporan.modul_id = modul.id
    JOIN praktikum ON modul.praktikum_id = praktikum.id
    JOIN users ON laporan.mahasiswa_id = users.id
    WHERE laporan.id = $id
");

$data = mysqli_fetch_assoc($laporan);
if (!$data) {
    echo "<p class='text-red-500 text-center mt-10'>Data laporan tidak ditemukan.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = $_POST['nilai'];
    $feedback = $_POST['feedback'];

    mysqli_query($conn, "
        UPDATE laporan
        SET nilai = '$nilai', feedback = '$feedback', status = 'Sudah Dinilai'
        WHERE id = $id
    ");

    header('Location: laporan_masuk.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            inter: ['Inter', 'sans-serif']
          },
          colors: {
            darkblue: '#213448',
            midblue: '#547792',
            lightblue: '#94B4C1',
            soft: '#ECEFCA',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-soft font-inter">
  <div class="max-w-3xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-darkblue mb-6">Penilaian Laporan</h1>

    <div class="mb-6 space-y-2">
      <p><span class="font-semibold text-darkblue">Mahasiswa:</span> <?= htmlspecialchars($data['nama_mahasiswa']) ?></p>
      <p><span class="font-semibold text-darkblue">Praktikum:</span> <?= htmlspecialchars($data['namaPrak']) ?></p>
      <p><span class="font-semibold text-darkblue">Modul:</span> <?= htmlspecialchars($data['judul_modul']) ?></p>
      <p><span class="font-semibold text-darkblue">File:</span> <a href="uploads/<?= $data['file'] ?>" target="_blank" class="text-blue-600 hover:underline">Lihat File</a></p>
    </div>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block mb-1 font-medium text-darkblue">Nilai (0 - 100):</label>
        <input type="number" name="nilai" min="0" max="100" required value="<?= htmlspecialchars($data['nilai'] ?? '') ?>"
          class="w-full px-4 py-2 border rounded bg-soft text-darkblue">
      </div>

      <div>
        <label class="block mb-1 font-medium text-darkblue">Feedback:</label>
        <textarea name="feedback" rows="4" class="w-full px-4 py-2 border rounded bg-soft text-darkblue" required><?= htmlspecialchars($data['feedback'] ?? '') ?></textarea>
      </div>

      <div class="text-right">
        <button type="submit" class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">Simpan Penilaian</button>
      </div>
    </form>
  </div>
</body>

</html>
