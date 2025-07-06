<?php
session_start();
require_once 'config.php';

// Cek apakah user sudah login dan apakah dia mahasiswa
$isLoggedIn = isset($_SESSION['user_id']);
$isMahasiswa = isset($_SESSION['role']) && $_SESSION['role'] === 'mahasiswa';

// Ambil data praktikum dari database
$query = "SELECT id, namaPrak, deskripsi FROM praktikum ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPRAK</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#B82132',
                        secondary: '#D2665A',
                        peach: '#F2B28C',
                        light: '#F6DED8',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light font-inter">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="" class="text-xl font-bold text-primary">SIMPRAK</a>
                <nav class="hidden md:flex items-center space-x-4">
                    <?php if ($isLoggedIn): ?>
                        <a href="mahasiswa/dashboard.php" class="text-sm text-primary hover:underline">Dashboard</a>
                        <a href="logout.php" class="text-sm text-red-600 hover:underline">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="bg-primary text-white px-4 py-2 rounded text-sm">Login</a>
                        <a href="register.php" class="bg-peach text-primary px-4 py-2 rounded text-sm">Register</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-20 bg-gradient-to-br from-primary via-secondary to-light text-white">
        <h1 class="text-4xl font-bold mb-4">
            <span id="static-text">Selamat Datang di </span>
            <span id="typed-text" class="typing"></span>
        </h1>
        <p class="max-w-xl mx-auto font-medium">
            SIMPRAK (Sistem Informasi Manajemen Praktikum) adalah platform untuk mempermudah pengelolaan praktikum di kampus Anda.
        </p>
    </section>

    <!-- Katalog Praktikum -->
    <section class="py-12 px-6 max-w-screen-xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-primary">Katalog Praktikum</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php while ($prak = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-primary mb-2"><?= htmlspecialchars($prak['namaPrak']) ?></h3>
                    <p class="text-secondary mb-4">
                        <?= $prak['deskripsi'] ? htmlspecialchars($prak['deskripsi']) : 'Deskripsi belum tersedia.' ?>
                    </p>

                    <?php if ($isLoggedIn && $isMahasiswa): ?>
                        <a href="mahasiswa/praktikum/daftar_praktikum.php?id=<?= $prak['id'] ?>"
                           class="inline-block bg-primary text-white px-4 py-2 rounded text-sm hover:bg-secondary transition">
                           Daftar Praktikum
                        </a>
                    <?php else: ?>
                        <a href="login.php"
                           class="inline-block bg-primary text-white px-4 py-2 rounded text-sm hover:bg-secondary transition">
                           Login untuk Mendaftar
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>

        </div>
    </section>

    <script src="assets/js/typing.js"></script>
</body>
</html>
