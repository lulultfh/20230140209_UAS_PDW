-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jul 2025 pada 17.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_praktikum`
--

CREATE TABLE `daftar_praktikum` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `praktikum_id` int(11) NOT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_praktikum`
--

INSERT INTO `daftar_praktikum` (`id`, `mahasiswa_id`, `praktikum_id`, `tanggal_daftar`) VALUES
(1, 3, 2, '2025-07-06 21:24:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  `file_laporan` varchar(255) NOT NULL,
  `status` enum('Terkumpul','Dinilai') DEFAULT 'Terkumpul',
  `nilai` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `mahasiswa_id`, `modul_id`, `file_laporan`, `status`, `nilai`, `feedback`, `submitted_at`, `updated_at`) VALUES
(1, 3, 1, 'Praktikum 2 Pengembangan Desain Web.pdf', '', 100, 'done', '2025-07-06 21:30:32', '2025-07-06 22:04:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id` int(11) NOT NULL,
  `praktikum_id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id`, `praktikum_id`, `judul`, `file`, `created_at`) VALUES
(1, 2, '1. Introduction to HTTP', '1751805514_Panduan Praktikum PDW 6.pdf', '2025-07-06 19:38:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `praktikum`
--

CREATE TABLE `praktikum` (
  `id` int(11) NOT NULL,
  `semester` int(1) NOT NULL,
  `dosenPengampu` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `namaPrak` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `praktikum`
--

INSERT INTO `praktikum` (`id`, `semester`, `dosenPengampu`, `created_at`, `namaPrak`, `deskripsi`) VALUES
(2, 4, 'Asroni', '2025-07-06 19:27:29', 'Praktikum Pengembangan Desain Web', 'Belajar membuat website dengan tampilan yang menarik dan interaktif.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'uls', 'uls12@gmail.com', '$2y$10$08b6azTN8ANvK1fittyNs.w6Oqs2e/.ktbp18km6ZjIGZVtTypBiK', 'mahasiswa', '2025-07-04 13:56:34'),
(6, 'ulul', 'ulul@gmail.com', '$2y$10$0K3yxK5G.LQQ8kUligppke.rNzcphKM5iq5oUsKKZqNZcmwA9nQwy', 'asisten', '2025-07-05 07:46:56');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_praktikum`
--
ALTER TABLE `daftar_praktikum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`),
  ADD KEY `praktikum_id` (`praktikum_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_laporan_mahasiswa` (`mahasiswa_id`),
  ADD KEY `fk_laporan_modul` (`modul_id`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `praktikum_id` (`praktikum_id`);

--
-- Indeks untuk tabel `praktikum`
--
ALTER TABLE `praktikum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_praktikum`
--
ALTER TABLE `daftar_praktikum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `praktikum`
--
ALTER TABLE `praktikum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_praktikum`
--
ALTER TABLE `daftar_praktikum`
  ADD CONSTRAINT `daftar_praktikum_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `daftar_praktikum_ibfk_2` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`);

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_laporan_modul` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
