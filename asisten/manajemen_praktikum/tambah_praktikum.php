<?php
require_once __DIR__ . '/../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaPrak = $_POST['namaPrak'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $dosenPengampu = $_POST['dosenPengampu'] ?? '';

    if ($namaPrak && $semester && $dosenPengampu) {
        $stmt = $conn->prepare("INSERT INTO praktikum (namaPrak, semester, dosenPengampu) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $namaPrak, $semester, $dosenPengampu);
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