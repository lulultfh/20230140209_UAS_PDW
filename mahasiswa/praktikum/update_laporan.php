<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$mahasiswa_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_laporan']) && isset($_POST['modul_id']) && isset($_POST['praktikum_id'])) {
    $modul_id = intval($_POST['modul_id']);
    $praktikum_id = intval($_POST['praktikum_id']);
    $upload_dir = '../uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = uniqid() . '_' . basename($_FILES['file_laporan']['name']);
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file_laporan']['tmp_name'], $target_file)) {
        // Update laporan
        $update = mysqli_prepare($conn, "UPDATE laporan SET file_laporan = ?, updated_at = NOW(), status = 'Terkumpul' WHERE mahasiswa_id = ? AND modul_id = ?");
        mysqli_stmt_bind_param($update, "sii", $file_name, $mahasiswa_id, $modul_id);
        mysqli_stmt_execute($update);

        // Redirect kembali ke halaman detail praktikum
        header("Location: detail_praktikum.php?id=$praktikum_id");
        exit();
    } else {
        echo "❌ Gagal mengunggah file.";
    }
} else {
    echo "❌ Permintaan tidak valid.";
}
