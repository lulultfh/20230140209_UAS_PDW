<?php
require_once __DIR__ . '/../../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM praktikum WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: praktikum.php");
    exit;
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='praktikum.php';</script>";
}
?>