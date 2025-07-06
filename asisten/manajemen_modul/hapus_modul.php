<?php
require_once __DIR__ . '/../../config.php';

// Validasi dan ambil ID
if (!isset($_GET['id'])) {
    header('Location: modul.php');
    exit;
}

$id = intval($_GET['id']);

// Ambil data file-nya dulu
$result = mysqli_query($conn, "SELECT file FROM modul WHERE id = $id");
$modul = mysqli_fetch_assoc($result);

// Hapus file dari server
if ($modul && file_exists('uploads/' . $modul['file'])) {
    unlink('uploads/' . $modul['file']);
}

// Hapus data dari database
mysqli_query($conn, "DELETE FROM modul WHERE id = $id");

// Redirect balik ke halaman modul
header('Location: modul.php');
exit;
