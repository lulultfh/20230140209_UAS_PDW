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
    <title>Panel Mahasiswa - <?php echo $pageTitle ?? 'Dashboard'; ?></title>
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
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <span class="text-white text-2xl font-bold">SIMPRAK</span>
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <?php 
              $activeClass = 'bg-secondary text-white';
              $inactiveClass = 'text-light hover:bg-secondary hover:text-white';
            ?>
            <a href="dashboard.php" class="<?= ($activePage == 'dashboard') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
            <a href="my_courses.php" class="<?= ($activePage == 'my_courses') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Praktikum Saya</a>
            <a href="courses.php" class="<?= ($activePage == 'courses') ? $activeClass : $inactiveClass ?> px-3 py-2 rounded-md text-sm font-medium">Cari Praktikum</a>
          </div>
        </div>
      </div>
      <div class="hidden md:block">
        <div class="ml-4 flex items-center md:ml-6">
          <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
            Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="container mx-auto p-6 lg:p-8">
