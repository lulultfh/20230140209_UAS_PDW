<?php
$pageTitle = 'Laporan Masuk';
$activePage = 'laporan';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

// Ambil daftar praktikum dan mahasiswa untuk filter
$praktikums = mysqli_query($conn, "SELECT * FROM praktikum");
$mahasiswas = mysqli_query($conn, "SELECT id, nama FROM users WHERE role = 'mahasiswa'");

// Ambil filter dari GET
$filter_modul = $_GET['modul'] ?? '';
$filter_mahasiswa = $_GET['mahasiswa'] ?? '';
$filter_status = $_GET['status'] ?? '';

// Query dasar dengan JOIN
$query = "SELECT laporan.*, users.nama AS nama_mahasiswa, praktikum.namaPrak AS nama_praktikum
          FROM laporan 
          JOIN users ON laporan.mahasiswa_id = users.id
          JOIN modul ON laporan.modul_id = modul.id
          JOIN praktikum ON modul.praktikum_id = praktikum.id
          WHERE users.role = 'mahasiswa'";

if ($filter_modul) {
  $query .= " AND praktikum.id = " . intval($filter_modul);
}
if ($filter_mahasiswa) {
  $query .= " AND users.id = " . intval($filter_mahasiswa);
}
if ($filter_status !== '') {
  $query .= " AND laporan.status = '" . mysqli_real_escape_string($conn, $filter_status) . "'";
}

$query .= " ORDER BY laporan.id DESC";
$laporans = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
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
  <div class="max-w-6xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-darkblue mb-6">Laporan Masuk</h1>

    <!-- Filter -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <select name="modul" class="px-4 py-2 border rounded bg-soft text-darkblue">
        <option value="">Filter Modul</option>
        <?php foreach ($praktikums as $p): ?>
          <option value="<?= $p['id'] ?>" <?= $filter_modul == $p['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['namaPrak']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="mahasiswa" class="px-4 py-2 border rounded bg-soft text-darkblue">
        <option value="">Filter Mahasiswa</option>
        <?php foreach ($mahasiswas as $m): ?>
          <option value="<?= $m['id'] ?>" <?= $filter_mahasiswa == $m['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($m['nama']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="status" class="px-4 py-2 border rounded bg-soft text-darkblue">
        <option value="">Filter Status</option>
        <option value="Belum Dinilai" <?= $filter_status == 'Belum Dinilai' ? 'selected' : '' ?>>Belum Dinilai</option>
        <option value="Sudah Dinilai" <?= $filter_status == 'Sudah Dinilai' ? 'selected' : '' ?>>Sudah Dinilai</option>
      </select>

      <div class="md:col-span-3 text-right">
        <button type="submit" class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">Terapkan Filter</button>
      </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-midblue text-white">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Mahasiswa</th>
            <th class="px-4 py-2">Modul</th>
            <th class="px-4 py-2">File</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          foreach ($laporans as $lap): ?>
            <tr class="border-b hover:bg-lightblue/30">
              <td class="px-4 py-2"><?= $i++ ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($lap['nama_mahasiswa']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($lap['nama_praktikum']) ?></td>
              <td class="px-4 py-2">
                <a href="../../laporan_mahasiswa/<?= $lap['file_laporan'] ?>" class="text-blue-600 hover:underline"
                  target="_blank">Lihat</a>
              </td>
              <td class="px-4 py-2"><?= htmlspecialchars($lap['status']) ?></td>
              <td class="px-4 py-2">
                <a href="nilai_laporan.php?id=<?= $lap['id'] ?>"
                  class="bg-lightblue text-darkblue px-3 py-1 rounded hover:bg-midblue hover:text-white">Nilai</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
<?php
// 3. Panggil Footer
require_once '../templates/footer.php';
?>