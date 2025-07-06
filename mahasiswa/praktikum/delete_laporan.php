<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modul_id']) && isset($_POST['praktikum_id'])) {
    $modul_id = intval($_POST['modul_id']);
    $praktikum_id = intval($_POST['praktikum_id']);

    // Ambil nama file yang akan dihapus
    $check = mysqli_prepare($conn, "SELECT file_laporan FROM laporan WHERE mahasiswa_id = ? AND modul_id = ?");
    mysqli_stmt_bind_param($check, "ii", $mahasiswa_id, $modul_id);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    $laporan = mysqli_fetch_assoc($result);

    if ($laporan) {
        $file_path = '../../laporan_mahasiswa/' . $laporan['file_laporan'];

        // Hapus file dari direktori
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data dari database
        $delete = mysqli_prepare($conn, "DELETE FROM laporan WHERE mahasiswa_id = ? AND modul_id = ?");
        mysqli_stmt_bind_param($delete, "ii", $mahasiswa_id, $modul_id);
        mysqli_stmt_execute($delete);

        // Redirect kembali ke detail praktikum
        header("Location: detail_praktikum.php?id=$praktikum_id");
        exit();
    } else {
        echo "❌ Laporan tidak ditemukan.";
    }
} else {
    echo "❌ Permintaan tidak valid.";
}
