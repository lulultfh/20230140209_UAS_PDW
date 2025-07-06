<?php
$pageTitle = 'Edit Akun Pengguna';
$activePage = 'akun';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: akun.php");
  exit;
}

// Ambil data akun berdasarkan ID
$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
  header("Location: akun.php");
  exit;
}

// Handle update akun
if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $updateQuery = "UPDATE users SET nama = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $password, $role, $id);
  } else {
    $updateQuery = "UPDATE users SET nama = ?, email = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $role, $id);
  }

  mysqli_stmt_execute($stmt);
  header("Location: akun.php");
  exit;
}
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
  <div class="max-w-xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
    <h1 class="text-2xl font-bold text-darkblue mb-6">Edit Akun Pengguna</h1>

    <form method="POST" class="space-y-4">
      <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" placeholder="Nama Lengkap" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue">

      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue">

      <input type="password" name="password" placeholder="Password"
        class="w-full px-4 py-2 border rounded bg-soft text-darkblue">

      <select name="role" required class="w-full px-4 py-2 border rounded bg-soft text-darkblue">
        <option value="">Pilih Role</option>
        <option value="mahasiswa" <?= $user['role'] == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
        <option value="asisten" <?= $user['role'] == 'asisten' ? 'selected' : '' ?>>Asisten</option>
      </select>

      <div class="text-right">
        <button type="submit" name="submit"
          class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>

</html>
