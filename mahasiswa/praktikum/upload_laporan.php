<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_laporan']) && isset($_POST['modul_id'])) {
    $modul_id = intval($_POST['modul_id']);
    $upload_dir = '../../laporan_mahasiswa/';

    // Buat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = basename($_FILES['file_laporan']['name']);
    $target_file = $upload_dir . $file_name;

    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($_FILES['file_laporan']['tmp_name'], $target_file)) {
        // Cek apakah laporan untuk modul ini sudah pernah dikumpulkan
        $check = mysqli_prepare($conn, "SELECT id FROM laporan WHERE mahasiswa_id = ? AND modul_id = ?");
        mysqli_stmt_bind_param($check, "ii", $mahasiswa_id, $modul_id);
        mysqli_stmt_execute($check);
        $check_result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($check_result) > 0) {
            // Jika sudah ada, update file dan waktu
            $update = mysqli_prepare($conn, "UPDATE laporan SET file_laporan = ?, updated_at = NOW(), status = 'Terkumpul' WHERE mahasiswa_id = ? AND modul_id = ?");
            mysqli_stmt_bind_param($update, "sii", $file_name, $mahasiswa_id, $modul_id);
            mysqli_stmt_execute($update);
        } else {
            // Jika belum ada, insert laporan baru
            $insert = mysqli_prepare($conn, "INSERT INTO laporan (mahasiswa_id, modul_id, file_laporan, status, submitted_at) VALUES (?, ?, ?, 'Terkumpul', NOW())");
            mysqli_stmt_bind_param($insert, "iis", $mahasiswa_id, $modul_id, $file_name);
            mysqli_stmt_execute($insert);
        }

        // Redirect kembali ke halaman detail
        header("Location: detail_praktikum.php?id=" . $_GET['praktikum_id']);
        exit();
    } else {
        echo "Gagal mengunggah file.";
    }
} else {
    echo "Permintaan tidak valid.";
}
