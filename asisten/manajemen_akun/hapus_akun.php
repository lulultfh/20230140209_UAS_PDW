<?php
require_once __DIR__ . '/../../config.php';

// Ambil ID dari query string
$id = $_GET['id'] ?? null;

// Jika ada ID, lakukan penghapusan
if ($id) {
  $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
}

// Redirect kembali ke halaman daftar akun
header("Location: akun.php");
exit;
