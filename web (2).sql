-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2024 at 04:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `nomor_pesanan` int NOT NULL,
  `user_id` int NOT NULL,
  `item` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `informasi` varchar(255) NOT NULL,
  `Catatan` varchar(255) NOT NULL DEFAULT 'Tidak ada',
  `pembayaran` varchar(255) NOT NULL,
  `tanggal_pesanan` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('proses','berhasil','gagal') DEFAULT 'proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`nomor_pesanan`, `user_id`, `item`, `harga`, `informasi`, `Catatan`, `pembayaran`, `tanggal_pesanan`, `status`) VALUES
(109, 1, 'Manipulasi Foto Tingkat Lanjut', 61000, 'Nomor Telepon: 234234324\nWaktu Pengerjaan: 8 Jam\nCatatan: ', 'Tidak ada', 'QRIS', '2024-12-01 10:26:42', 'proses'),
(110, 1, 'Retouch Foto', 16000, 'Nomor Telepon: 085852935747\nWaktu Pengerjaan: 8 Jam\nCatatan: ', 'Tidak ada', 'QRIS', '2024-12-01 10:38:38', 'proses'),
(111, 1, 'Restorasi Foto Lama', 36000, 'Nomor Telepon: 085852935747\nWaktu Pengerjaan: 1 Hari\nCatatan: ', 'Tidak ada', 'QRIS', '2024-12-01 10:40:20', 'proses'),
(112, 1, 'Hapus Object', 26000, 'Nomor Telepon: 085852935747\nWaktu Pengerjaan: 1 Hari\nCatatan: ', 'Tidak ada', 'QRIS', '2024-12-01 10:40:53', 'proses'),
(113, 1, 'Edit Manipulasi Produk', 21000, 'Nomor Telepon: 085852935747\nWaktu Pengerjaan: 1 Hari\nCatatan: ', 'Tidak ada', 'QRIS', '2024-12-01 10:41:21', 'proses'),
(114, 1, 'Manipulasi Foto Tingkat Lanjut', 56000, 'Nomor Telepon: 085852935747\nWaktu Pengerjaan: 1 Hari\nCatatan: 0', 'Tidak ada', 'QRIS', '2024-12-01 10:42:33', 'proses'),
(115, 1, 'Manipulasi Foto Tingkat Lanjut', 56000, 'Nomor Telepon: 085745735072\nWaktu Pengerjaan: 1 Hari\nCatatan: 0', 'Tidak ada', 'QRIS', '2024-12-01 10:43:37', 'proses'),
(116, 1, 'Restorasi Foto Lama', 36000, 'Nomor Telepon: 085745735072\nWaktu Pengerjaan: 1 Hari\nCatatan: Tidak Ada', 'Tidak ada', 'QRIS', '2024-12-01 10:46:16', 'proses'),
(117, 1, 'Color Grading', 41000, 'Nomor Telepon: 085745735072\nWaktu Pengerjaan: Reguler<br>(3-5 hari)\nFormat Keluaran: JPG\nCatatan: Tidak Ada.', 'Tidak ada', 'QRIS', '2024-12-01 10:58:59', 'proses'),
(118, 1, 'Add Text/Title', 11000, 'Nomor Telepon: 085745735072\nWaktu Pengerjaan: \nFormat Keluaran: PNG\nCatatan: Tidak Ada.', 'Tidak ada', 'QRIS', '2024-12-01 10:59:50', 'proses'),
(119, 1, 'Perbaikan Struktur', 22500, 'Nomor Telepon: 4224234\nWaktu Pengerjaan: Reguler<br>(3-5 hari)\nFormat Keluaran: PDF\nCatatan: Tidak Ada.', 'Tidak ada', 'QRIS', '2024-12-01 11:31:33', 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `date`, `last_login`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', '2024-11-23 06:12:32', '2024-11-27 20:15:50'),
(2, 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'user', '2024-11-23 06:12:44', '2024-11-27 20:15:50'),
(3, 'lendra', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'user', '2024-11-23 06:33:19', '2024-11-27 20:15:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`nomor_pesanan`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `nomor_pesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
