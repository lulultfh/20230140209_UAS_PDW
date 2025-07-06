<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_mahasiswa.php';
?>

<!-- Hero Section -->
<div class="bg-gradient-to-r from-secondary to-accent text-white p-8 rounded-xl shadow-lg mb-8">
    <h1 class="text-3xl font-bold typing-text">Selamat Datang Kembali, <?= htmlspecialchars($_SESSION['nama']); ?>!</h1>
    <p class="mt-2 opacity-90">Terus semangat dalam menyelesaikan semua modul praktikummu.</p>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-primary">3</div>
        <div class="mt-2 text-lg text-gray-600">Praktikum Diikuti</div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-green-500">8</div>
        <div class="mt-2 text-lg text-gray-600">Tugas Selesai</div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center justify-center">
        <div class="text-5xl font-extrabold text-yellow-500">4</div>
        <div class="mt-2 text-lg text-gray-600">Tugas Menunggu</div>
    </div>
</div>

<!-- Notifikasi -->
<div class="bg-white p-6 rounded-xl shadow-md">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Notifikasi Terbaru</h3>
    <ul class="space-y-4">
        <li class="flex items-start p-3 border-b border-gray-100 last:border-b-0">
            <span class="text-xl mr-4">🔔</span>
            <div>
                Nilai untuk <a href="#" class="font-semibold text-primary hover:underline">Modul 1: HTML & CSS</a> telah
                diberikan.
            </div>
        </li>

        <li class="flex items-start p-3 border-b border-gray-100 last:border-b-0">
            <span class="text-xl mr-4">⏳</span>
            <div>
                Batas waktu pengumpulan laporan untuk <a href="#"
                    class="font-semibold text-primary hover:underline">Modul 2: PHP Native</a> adalah besok!
            </div>
        </li>

        <li class="flex items-start p-3">
            <span class="text-xl mr-4">✅</span>
            <div>
                Anda berhasil mendaftar pada mata praktikum <a href="#"
                    class="font-semibold text-primary hover:underline">Jaringan Komputer</a>.
            </div>
        </li>
    </ul>
</div>

<!-- Footer -->
<?php require_once 'templates/footer_mahasiswa.php'; ?>

<!-- Typing Animation -->
<style>
    .typing-text {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        border-right: .15em solid white;
        animation: typing 3s steps(40, end), blink .75s step-end infinite;
        max-width: 100%;
        width: 38ch;
    }

    @keyframes typing {
        from {
            width: 0
        }

        to {
            width: 100%
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent
        }
    }
</style>