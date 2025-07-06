<?php
$pageTitle = 'Manajemen Modul';
$activePage = 'modul';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

// Ambil data modul & praktikum
$moduls = mysqli_query($conn, "
    SELECT modul.id, modul.judul, modul.file, praktikum.namaPrak
    FROM modul 
    JOIN praktikum ON modul.praktikum_id = praktikum.id
    ORDER BY modul.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
  <div class="max-w-5xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-darkblue">Manajemen Modul Praktikum</h1>
      <a href="tambah_modul.php" class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">+ Tambah Modul</a>
    </div>

    <!-- Tabel Modul -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-midblue text-white">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Judul Modul</th>
            <th class="px-4 py-2">Praktikum</th>
            <th class="px-4 py-2">File</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($moduls as $m): ?>
            <tr class="border-b hover:bg-lightblue/30">
              <td class="px-4 py-2"><?= $i++ ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($m['judul']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($m['namaPrak']) ?></td>
              <td class="px-4 py-2">
                <a href="uploads/<?= $m['file'] ?>" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
              </td>
              <td class="px-4 py-2 space-x-2">
                <a href="edit_modul.php?id=<?= $m['id'] ?>"
                  class="bg-lightblue text-darkblue px-3 py-1 rounded hover:bg-midblue hover:text-white">Edit</a>
                <a href="hapus_modul.php?id=<?= $m['id'] ?>" onclick="return confirm('Yakin ingin menghapus modul ini?')"
                  class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
