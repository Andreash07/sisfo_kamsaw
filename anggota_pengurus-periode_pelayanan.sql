-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2026 at 10:54 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsisfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota_pengurus_pelayanan`
--

CREATE TABLE `anggota_pengurus_pelayanan` (
  `id` int(11) NOT NULL,
  `anggota_jemaat_id` int(11) NOT NULL,
  `periode_pelayanan` tinyint(4) NOT NULL,
  `pelayanan` varchar(40) DEFAULT NULL,
  `jabatan` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT -1 COMMENT '-1:usulan;\r\n0: setujui pdkt\r\n1: bersedia;\r\n2: tidak bersedia',
  `prioritas` tinyint(4) NOT NULL,
  `diusulkan_tgl` date DEFAULT NULL,
  `status_final` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: belum diputuskan\r\n1: final bersedia\r\n2: final dibatalkan MJ\r\n3: final dibatalkan pengunduran diri (calon)\r\n4:final pengunduran pada masa pelayanan',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota_pengurus_pelayanan`
--

INSERT INTO `anggota_pengurus_pelayanan` (`id`, `anggota_jemaat_id`, `periode_pelayanan`, `pelayanan`, `jabatan`, `status`, `prioritas`, `diusulkan_tgl`, `status_final`, `notes`, `created_at`, `created_id`, `updated_at`, `updated_by`) VALUES
(1, 102, 1, 'MIK', '', -1, 1, NULL, 0, '', '2026-10-20 04:19:00', 10, NULL, NULL),
(2, 103, 1, 'MIK', '', -1, 1, NULL, 0, '', '2026-10-20 04:19:00', 10, NULL, NULL),
(3, 102, 1, 'KOMPELKES', '', -1, 2, NULL, 0, '', '2026-10-20 07:17:39', 10, NULL, NULL),
(4, 728, 1, 'KOMPELKES', '', -1, 1, NULL, 0, '', '2026-10-20 07:17:39', 10, NULL, NULL),
(5, 102, 1, 'KHRG', '', -1, 3, '2026-10-20', 0, '', '2026-10-20 08:06:37', 10, NULL, NULL),
(6, 102, 1, 'KOPEM', '', -1, 4, '2026-10-21', 0, '', '2026-10-20 08:16:14', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `periode_pelayanan`
--

CREATE TABLE `periode_pelayanan` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periode_pelayanan`
--

INSERT INTO `periode_pelayanan` (`id`, `name`, `status`, `created_at`) VALUES
(1, '2027-2029', 1, '2026-10-20 03:13:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota_pengurus_pelayanan`
--
ALTER TABLE `anggota_pengurus_pelayanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periode_pelayanan`
--
ALTER TABLE `periode_pelayanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota_pengurus_pelayanan`
--
ALTER TABLE `anggota_pengurus_pelayanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `periode_pelayanan`
--
ALTER TABLE `periode_pelayanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
