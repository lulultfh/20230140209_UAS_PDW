<?php
$pageTitle = 'Tambah Modul';
$activePage = 'modul';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $praktikum_id = intval($_POST['praktikum_id']);

    // Proses upload file
    $fileName = $_FILES['file']['name'];
    $tmpName = $_FILES['file']['tmp_name'];
    $targetDir = 'uploads/';
    $uniqueName = time() . '_' . basename($fileName);
    $targetPath = $targetDir . $uniqueName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        mysqli_query($conn, "INSERT INTO modul (judul, file, praktikum_id) VALUES ('$judul', '$uniqueName', $praktikum_id)");
        header('Location: modul.php');
        exit;
    } else {
        $error = "Gagal mengunggah file.";
    }
}

// Ambil daftar praktikum
$praktikums = mysqli_query($conn, "SELECT * FROM praktikum");
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
  <div class="max-w-3xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-darkblue mb-6">Tambah Modul Praktikum</h1>

    <?php if (!empty($error)): ?>
      <p class="text-red-600 mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="text" name="judul" required placeholder="Judul Modul"
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue" />

      <select name="praktikum_id" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue">
        <option value="" disabled selected>Pilih Praktikum</option>
        <?php foreach ($praktikums as $p): ?>
          <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['namaPrak']) ?></option>
        <?php endforeach; ?>
      </select>

      <input type="file" name="file" accept=".pdf,.docx" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue" />

      <div class="flex justify-end space-x-3">
        <a href="modul.php"
          class="bg-gray-300 hover:bg-gray-400 text-darkblue px-4 py-2 rounded">Batal</a>
        <button type="submit"
          class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">Simpan</button>
      </div>
    </form>
  </div>
</body>
</html>
