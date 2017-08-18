-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 18, 2017 at 11:01 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-2+ubuntu16.04.1+deb.sury.org+4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pt2l`
--

-- --------------------------------------------------------

--
-- Table structure for table `daya`
--

DROP TABLE IF EXISTS `daya`;
CREATE TABLE `daya` (
  `kd_daya` int(11) UNSIGNED NOT NULL,
  `kd_tarif` varchar(15) DEFAULT NULL,
  `daya` varchar(30) DEFAULT NULL,
  `rp_per_kwh` float DEFAULT NULL,
  `rp_per_kva` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daya`
--

INSERT INTO `daya` (`kd_daya`, `kd_tarif`, `daya`, `rp_per_kwh`, `rp_per_kva`, `created_at`, `updated_at`) VALUES
(2, 'S2', '1300', 708, NULL, '2017-08-16 22:37:44', '2017-08-16 22:37:44'),
(3, 'S2', '2200', 760, NULL, '2017-08-16 22:38:05', '2017-08-16 22:38:05'),
(4, 'S2', '3500-200000', 900, NULL, '2017-08-16 22:40:03', '2017-08-16 22:40:03'),
(5, 'S3', '> 200000', 735, NULL, '2017-08-16 22:40:49', '2017-08-16 22:40:49'),
(6, 'R1', '1300', 1352, NULL, '2017-08-16 22:46:14', '2017-08-16 22:46:14'),
(7, 'R1', '2200', 1352, NULL, '2017-08-16 22:46:38', '2017-08-16 22:46:38'),
(8, 'R3', '6600', 1352, NULL, '2017-08-16 22:48:50', '2017-08-16 22:48:50'),
(9, 'S2', '450', 360, 15000, '2017-08-17 01:08:43', '2017-08-17 03:59:29'),
(10, 'S2', '900', 360, 10000, '2017-08-17 01:10:08', '2017-08-17 03:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pelanggaran`
--

DROP TABLE IF EXISTS `jenis_pelanggaran`;
CREATE TABLE `jenis_pelanggaran` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_06_29_160310_pelanggan', 1),
(4, '2017_06_29_161001_pemeriksaan', 1),
(5, '2017_06_29_162625_pembayaran', 1),
(6, '2017_06_29_163511_tidak_lanjut', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_daya` int(11) UNSIGNED DEFAULT NULL,
  `daya` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `kd_daya`, `daya`, `alamat`, `created_at`, `updated_at`) VALUES
('PLG-2017080001', 'Jamal Apriadi', 9, '450', 'pangkah', '2017-08-17 00:42:04', '2017-08-17 04:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pembayaran` datetime NOT NULL,
  `no_agenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_beban` float DEFAULT NULL,
  `rp_bayar` double(8,2) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `tgl_pembayaran`, `no_agenda`, `biaya_beban`, `rp_bayar`, `user_id`, `created_at`, `updated_at`) VALUES
('PMB-2017080001', '2017-08-18 00:00:00', 'PMK-2017080001', 6750, 892296.00, 1, '2017-08-18 08:39:43', '2017-08-18 08:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

DROP TABLE IF EXISTS `pemeriksaan`;
CREATE TABLE `pemeriksaan` (
  `no_agenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pemeriksaan` date NOT NULL,
  `id_pelanggan` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_ba` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_pemeriksaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saving_kwh` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`no_agenda`, `tgl_pemeriksaan`, `id_pelanggan`, `no_ba`, `hasil_pemeriksaan`, `saving_kwh`, `user_id`, `created_at`, `updated_at`) VALUES
('PMK-2017080001', '2017-08-17', 'PLG-2017080001', '3452236664444', 'P3', '2478.6', 1, '2017-08-17 06:20:25', '2017-08-17 06:51:53'),
('PMK-2017080002', '2017-08-17', 'PLG-2017080001', '12345', 'K2', '100000', 1, '2017-08-17 09:37:09', '2017-08-17 09:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

DROP TABLE IF EXISTS `tarif`;
CREATE TABLE `tarif` (
  `kd_tarif` varchar(15) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`kd_tarif`, `keterangan`, `created_at`, `updated_at`) VALUES
('B1', 'B1', '2017-08-16 22:43:12', '2017-08-16 22:43:12'),
('B2', 'B2', '2017-08-16 22:43:18', '2017-08-16 22:43:18'),
('B3', 'B3', '2017-08-16 22:43:24', '2017-08-16 22:43:24'),
('l1', 'L1', '2017-08-16 22:44:22', '2017-08-16 22:44:22'),
('l2', 'l2', '2017-08-16 22:44:31', '2017-08-16 22:44:31'),
('l3', 'l3', '2017-08-16 22:44:40', '2017-08-16 22:44:40'),
('l4', 'l4', '2017-08-16 22:45:14', '2017-08-16 22:45:14'),
('P1', 'P1', '2017-08-16 22:45:32', '2017-08-16 22:45:32'),
('P2', 'P2', '2017-08-16 22:45:38', '2017-08-16 22:45:38'),
('R1', 'R1', '2017-08-16 22:42:47', '2017-08-16 22:42:47'),
('R2', 'R2', '2017-08-16 22:42:54', '2017-08-16 22:42:54'),
('R3', 'R3', '2017-08-16 22:42:59', '2017-08-16 22:42:59'),
('S2', 'S2', '2017-08-16 21:19:50', '2017-08-16 21:19:50'),
('S3', 'S3', '2017-08-16 21:19:56', '2017-08-16 21:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

DROP TABLE IF EXISTS `tindakan`;
CREATE TABLE `tindakan` (
  `id_tindakan` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_tindakan` datetime NOT NULL,
  `no_agenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tindak_lanjut` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tindakan`
--

INSERT INTO `tindakan` (`id_tindakan`, `tgl_tindakan`, `no_agenda`, `tindak_lanjut`, `keterangan`, `user_id`, `created_at`, `updated_at`) VALUES
('TDK-2017080001', '2017-08-18 00:00:00', 'PMK-2017080001', 'Lanjut', NULL, 1, '2017-08-18 08:19:42', '2017-08-18 08:41:04'),
('TDK-2017080002', '2017-08-18 00:00:00', 'PMK-2017080002', 'Tindak Lanjut', NULL, 1, '2017-08-18 08:33:02', '2017-08-18 08:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('admin','manager','spv') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mujiono', 'mujiono5@gmail.com', '$2y$10$dXKiABh8XiVdI2fSrOuJNOXzHAOAc/uDPee.WVbA3MRFnLjh3Zm.y', 'admin', 'zABkkXEDZE7TlsaDuf48yxXiXoz1qttGzbeIS6mW480gRcKL8ENDbNPbBOe0', '2017-06-29 09:49:54', '2017-06-29 09:49:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daya`
--
ALTER TABLE `daya`
  ADD PRIMARY KEY (`kd_daya`),
  ADD KEY `kd_tarif` (`kd_tarif`);

--
-- Indexes for table `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD KEY `no_agenda` (`no_agenda`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`no_agenda`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`kd_tarif`);

--
-- Indexes for table `tindakan`
--
ALTER TABLE `tindakan`
  ADD KEY `no_agenda` (`no_agenda`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daya`
--
ALTER TABLE `daya`
  MODIFY `kd_daya` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `daya`
--
ALTER TABLE `daya`
  ADD CONSTRAINT `fkdd` FOREIGN KEY (`kd_tarif`) REFERENCES `tarif` (`kd_tarif`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_noag` FOREIGN KEY (`no_agenda`) REFERENCES `pemeriksaan` (`no_agenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_noags` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD CONSTRAINT `fk_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tindakan`
--
ALTER TABLE `tindakan`
  ADD CONSTRAINT `fk_tdk` FOREIGN KEY (`no_agenda`) REFERENCES `pemeriksaan` (`no_agenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tdk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
