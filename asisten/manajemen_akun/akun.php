<?php
$pageTitle = 'Manajemen Akun Pengguna';
$activePage = 'akun';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
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
  <div class="max-w-5xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-darkblue">Manajemen Akun Pengguna</h1>
      <a href="tambah_akun.php" class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">+ Tambah Akun</a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-midblue text-white">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($users as $u): ?>
            <tr class="border-b hover:bg-lightblue/30">
              <td class="px-4 py-2"><?= $i++ ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($u['nama']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($u['email']) ?></td>
              <td class="px-4 py-2 capitalize"><?= htmlspecialchars($u['role']) ?></td>
              <td class="px-4 py-2 space-x-2">
                <a href="edit_akun.php?id=<?= $u['id'] ?>" class="bg-lightblue text-darkblue px-3 py-1 rounded hover:bg-midblue hover:text-white">Edit</a>
                <a href="hapus_akun.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin ingin menghapus akun ini?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
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