<?php
$pageTitle = 'Edit Modul';
$activePage = 'modul';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

// Validasi ID
if (!isset($_GET['id'])) {
    header('Location: modul.php');
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM modul WHERE id = $id");
$modul = mysqli_fetch_assoc($result);

if (!$modul) {
    header('Location: modul.php');
    exit;
}

// Ambil daftar praktikum
$praktikums = mysqli_query($conn, "SELECT * FROM praktikum");

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $praktikum_id = intval($_POST['praktikum_id']);

    // Cek apakah ada file baru
    if ($_FILES['file']['name']) {
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $uniqueName = time() . '_' . basename($fileName);
        $targetPath = 'uploads/' . $uniqueName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            // Hapus file lama
            if (file_exists('uploads/' . $modul['file'])) {
                unlink('uploads/' . $modul['file']);
            }
            $query = "UPDATE modul SET judul='$judul', file='$uniqueName', praktikum_id=$praktikum_id WHERE id=$id";
        } else {
            $error = "Gagal mengunggah file baru.";
        }
    } else {
        $query = "UPDATE modul SET judul='$judul', praktikum_id=$praktikum_id WHERE id=$id";
    }

    if (isset($query) && mysqli_query($conn, $query)) {
        header('Location: modul.php');
        exit;
    }
}
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
    <h1 class="text-2xl font-bold text-darkblue mb-6">Edit Modul Praktikum</h1>

    <?php if (!empty($error)): ?>
      <p class="text-red-600 mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="text" name="judul" value="<?= htmlspecialchars($modul['judul']) ?>" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue" />

      <select name="praktikum_id" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue">
        <?php foreach ($praktikums as $p): ?>
          <option value="<?= $p['id'] ?>" <?= ($p['id'] == $modul['praktikum_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['namaPrak']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <div>
        <label class="block text-sm text-darkblue mb-1">Ganti File (opsional)</label>
        <input type="file" name="file" accept=".pdf,.docx"
          class="w-full px-4 py-2 border rounded bg-soft text-darkblue" />
        <p class="text-sm text-gray-500 mt-1">File saat ini: <strong><?= $modul['file'] ?></strong></p>
      </div>

      <div class="flex justify-end space-x-3">
        <a href="modul.php"
          class="bg-gray-300 hover:bg-gray-400 text-darkblue px-4 py-2 rounded">Batal</a>
        <button type="submit"
          class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>
</html>
