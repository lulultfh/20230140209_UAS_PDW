<?php
require_once __DIR__ . '/../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $namaPrak = $_POST['namaPrak'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $dosenPengampu = $_POST['dosenPengampu'] ?? '';

    if ($id && $namaPrak && $semester && $dosenPengampu) {
        $stmt = $conn->prepare("UPDATE praktikum SET namaPrak = ?, semester = ?, dosenPengampu = ? WHERE id = ?");
        $stmt->bind_param("sisi", $namaPrak, $semester, $dosenPengampu, $id);
        $stmt->execute();
        header("Location: praktikum.php");
        exit;
    } else {
        echo "<script>alert('Semua field harus diisi.'); window.location.href='praktikum.php';</script>";
    }
} else {
    header("Location: praktikum.php");
    exit;
}
?>