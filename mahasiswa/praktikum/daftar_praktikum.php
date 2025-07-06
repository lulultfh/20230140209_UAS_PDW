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

// Cek apakah sudah pernah mendaftar
$check = mysqli_prepare($conn, "SELECT * FROM daftar_praktikum WHERE mahasiswa_id = ? AND praktikum_id = ?");
mysqli_stmt_bind_param($check, "ii", $mahasiswa_id, $praktikum_id);
mysqli_stmt_execute($check);
$check_result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($check_result) > 0) {
    $message = "Kamu sudah mendaftar ke praktikum ini.";
} else {
    // Lakukan pendaftaran
    $insert = mysqli_prepare($conn, "INSERT INTO daftar_praktikum (mahasiswa_id, praktikum_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert, "ii", $mahasiswa_id, $praktikum_id);

    if (mysqli_stmt_execute($insert)) {
        $message = "Pendaftaran berhasil!";
    } else {
        $message = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#B82132',
              secondary: '#D2665A',
              peach: '#F2B28C',
              light: '#F6DED8'
            }
          }
        }
      }
    </script>
</head>
<body class="bg-light font-sans">
    <div class="max-w-xl mx-auto mt-20 bg-white shadow-md rounded p-6 text-center">
        <h1 class="text-xl font-bold text-primary mb-4">Status Pendaftaran Praktikum</h1>
        <p class="text-secondary text-lg mb-6"><?php echo $message; ?></p>
        <a href="../dashboard.php" class="inline-block bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition">Kembali ke Dashboard</a>
    </div>
</body>
</html>
<?php
// 3. Panggil Footer
require_once '../templates/footer_mahasiswa.php';
?>