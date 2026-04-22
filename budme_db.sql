-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 06:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budme_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lapangan_id` int(11) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_biaya` decimal(10,2) NOT NULL,
  `status_booking` enum('Menunggu Pembayaran','Aktif','Selesai','Dibatalkan') DEFAULT 'Menunggu Pembayaran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `lapangan_id`, `tanggal_booking`, `jam_mulai`, `jam_selesai`, `total_biaya`, `status_booking`) VALUES
(1, 1, 1, '2026-04-03', '13:00:00', '16:00:00', 150000.00, 'Selesai'),
(2, 2, 1, '2026-04-02', '08:00:00', '09:00:00', 50000.00, 'Selesai'),
(3, 2, 1, '2026-03-30', '12:00:00', '13:00:00', 50000.00, 'Selesai'),
(4, 1, 5, '2026-03-30', '08:00:00', '11:00:00', 150000.00, 'Selesai'),
(5, 1, 5, '2026-03-30', '08:00:00', '09:00:00', 50000.00, 'Selesai'),
(6, 1, 4, '2026-04-08', '15:00:00', '18:00:00', 165000.00, 'Aktif'),
(7, 1, 3, '2026-04-07', '11:00:00', '14:00:00', 165000.00, 'Aktif'),
(8, 1, 3, '2026-04-07', '11:00:00', '13:00:00', 110000.00, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id` int(11) NOT NULL,
  `nama_cabang` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id`, `nama_cabang`, `alamat`, `kontak`, `jam_buka`, `jam_tutup`) VALUES
(1, 'GOR BUD.ME Mawlang Kota', 'Jl. Soekarno Hatta No. 12, Malang', '0812-3456-7890', '08:00:00', '23:00:00'),
(2, 'GOR BUD.ME Lowokwaru', 'Jl. Veteran No.45, Lowokwaru, Malang', '0857-1234-5678', '08:00:00', '22:00:00'),
(3, 'GOR BUD.ME Kepanjen', 'Jl. Ahmad Yani No.8, Kepanjen, Malang', '0813-9876-5432', '08:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_lantai`
--

CREATE TABLE `jenis_lantai` (
  `id` int(11) NOT NULL,
  `nama_jenis` varchar(50) NOT NULL,
  `harga_weekday` decimal(10,2) NOT NULL,
  `harga_weekend` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_lantai`
--

INSERT INTO `jenis_lantai` (`id`, `nama_jenis`, `harga_weekday`, `harga_weekend`) VALUES
(1, 'Vinyl', 50000.00, 60000.00),
(2, 'Karpet', 55000.00, 65000.00);

-- --------------------------------------------------------

--
-- Table structure for table `lapangan`
--

CREATE TABLE `lapangan` (
  `id` int(11) NOT NULL,
  `cabang_id` int(11) NOT NULL,
  `jenis_lantai_id` int(11) NOT NULL,
  `nama_lapangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapangan`
--

INSERT INTO `lapangan` (`id`, `cabang_id`, `jenis_lantai_id`, `nama_lapangan`) VALUES
(1, 1, 1, 'Lapangan 1'),
(2, 1, 1, 'Lapangan 2'),
(3, 1, 2, 'Lapangan 3'),
(4, 1, 2, 'Lapangan 4'),
(5, 2, 1, 'Lapangan A'),
(6, 2, 2, 'Lapangan B'),
(7, 3, 1, 'Lapangan Utama');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `waktu_pembayaran` datetime DEFAULT current_timestamp(),
  `status_pembayaran` enum('Pending','Berhasil','Gagal') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `booking_id`, `metode_pembayaran`, `waktu_pembayaran`, `status_pembayaran`) VALUES
(1, 1, 'QRIS', '2026-03-30 13:55:51', 'Berhasil'),
(2, 2, 'QRIS', '2026-03-30 14:24:43', 'Berhasil'),
(3, 3, 'Transfer Bank BCA', '2026-03-30 14:26:03', 'Berhasil'),
(4, 4, 'QRIS', '2026-03-30 16:38:24', 'Berhasil'),
(5, 5, 'E-Wallet', '2026-03-30 16:43:03', 'Berhasil'),
(6, 6, 'E-Wallet', '2026-04-06 21:16:51', 'Berhasil'),
(7, 7, 'Transfer Bank', '2026-04-06 22:54:43', 'Berhasil'),
(8, 8, 'E-Wallet', '2026-04-06 23:04:05', 'Berhasil');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  `status_akun` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `foto` varchar(255) DEFAULT 'default_profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `nomor_hp`, `tanggal_bergabung`, `status_akun`, `foto`) VALUES
(1, 'Daniel Dian Saputra', 'daniel.dian.2303126@students.um.ac.id', '$2y$10$f7DGdvWHSPjUivqbUTDyu.IvSkQESuVHfDSrLSFz22uiNfB0qAhn2', '08234567890', '2026-03-30', 'AKTIF', '1_1774853397.png'),
(2, 'Muhammad Aflah Masdarul Makarim', 'muhammad.aflah.2303126@students.um.ac.id', '$2y$10$HSaCmYgsX8jqWkZzlKyBv.WlK7uu94yWhI8ubtHFAq4fEjGAaVkje', '0812345678', '2026-03-30', 'AKTIF', '2_1774855538.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lapangan_id` (`lapangan_id`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_lantai`
--
ALTER TABLE `jenis_lantai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cabang_id` (`cabang_id`),
  ADD KEY `jenis_lantai_id` (`jenis_lantai_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_lantai`
--
ALTER TABLE `jenis_lantai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lapangan`
--
ALTER TABLE `lapangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lapangan`
--
ALTER TABLE `lapangan`
  ADD CONSTRAINT `lapangan_ibfk_1` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lapangan_ibfk_2` FOREIGN KEY (`jenis_lantai_id`) REFERENCES `jenis_lantai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
