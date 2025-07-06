<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Mahasiswa - <?= $pageTitle ?? 'Dashboard'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#B82132',
                        secondary: '#D2665A',
                        accent: '#F2B28C',
                        light: '#F6DED8'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-light font-sans">

<nav class="bg-primary shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center space-x-10">
        <span class="text-white text-2xl font-bold">SIMPRAK</span>
        <div class="hidden md:flex space-x-4">
          <?php 
            $activeClass = 'bg-secondary text-white';
            $inactiveClass = 'text-light hover:bg-secondary hover:text-white';
          ?>
          <a href="/SistemPengumpulanTugas/mahasiswa/dashboard.php" class="<?= ($activePage == 'dashboard') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
          
          <a href="/SistemPengumpulanTugas/mahasiswa/praktikum/my_courses.php" class="<?= ($activePage == 'my_courses') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Praktikum Saya</a>
          
          <a href="/SistemPengumpulanTugas/index.php" class="<?= ($activePage == 'katalog') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Katalog Praktikum</a>
        </div>
      </div>

      <!-- Search Praktikum -->
      <form action="/SistemPengumpulanTugas/mahasiswa/search.php" method="get" class="hidden md:flex items-center">
        <input 
          type="text" 
          name="keyword" 
          placeholder="Cari Praktikum..." 
          class="px-3 py-2 rounded-md text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-accent"
        />
      </form>

      <!-- Tombol Logout -->
      <div class="hidden md:block">
        <a href="/SistemPengumpulanTugas/logout.php" class="ml-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
          Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="container mx-auto p-6 lg:p-8">
