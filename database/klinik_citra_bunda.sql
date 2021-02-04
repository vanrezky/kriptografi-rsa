-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2021 at 02:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_citra_bunda`
--
CREATE DATABASE IF NOT EXISTS `klinik_citra_bunda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `klinik_citra_bunda`;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama_dokter` varchar(35) NOT NULL,
  `nip` text DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `foto` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama_dokter`, `nip`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(4, 'Testing', '36 116 41 36 73 126 116', '36 41 116 126 41 36 116 73 126 36', '74c3652387c2987fc6e343f95d5af33b.jpg', '2021-01-17 22:34:32', '2021-02-03 21:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `kode_pasien` varchar(11) NOT NULL,
  `nama_pasien` varchar(35) NOT NULL,
  `nik` tinytext NOT NULL,
  `kategori` enum('bayi','anak-anak','remaja','dewasa','lanjut usia') DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `umur` int(11) NOT NULL,
  `alamat` tinytext NOT NULL,
  `no_hp` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `kode_pasien`, `nama_pasien`, `nik`, `kategori`, `jenis_kelamin`, `umur`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'P-0001', 'test2', '73 13 36 41 116 56 41 73 36 116 56', 'dewasa', 'laki-laki', 23, 'Jl lintas timur desa kemang', '36 41 116 41 92 36 41 13 36 41 116 41 36 116', '2021-01-21 23:35:35', '2021-02-03 22:10:48'),
(3, 'P-0003', 'test1', '36 41 36 116 41 36 116 41 116 36', 'anak-anak', 'laki-laki', 23, 'ddfsdfasdasdadasdasd', '56 116 13 41 116 13 41 116 13 41 116 13', '2021-01-23 20:24:47', '2021-02-03 22:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `perawat_bidan`
--

CREATE TABLE `perawat_bidan` (
  `id` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `nip` text DEFAULT NULL,
  `pekerjaan` enum('perawat','bidan') DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `foto` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perawat_bidan`
--

INSERT INTO `perawat_bidan` (`id`, `nama`, `nip`, `pekerjaan`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(6, 'Testing Perawat', '36 41 116', 'perawat', '126 56 55 56 55 56 36 41 116 56', 'a0e5a105172236b85f06edadf12480a7.jpg', '2021-01-19 22:11:57', '2021-02-03 21:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pasien`
--

CREATE TABLE `riwayat_pasien` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tgl_berobat` date NOT NULL,
  `gejala` tinytext NOT NULL,
  `tb` double NOT NULL,
  `bb` double NOT NULL,
  `td` double NOT NULL,
  `kat_penyakit` enum('TM','M') NOT NULL COMMENT 'TM = tidak menular, M = menular',
  `obat` tinytext NOT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `id_pb` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `riwayat_pasien`
--

INSERT INTO `riwayat_pasien` (`id`, `id_pasien`, `tgl_berobat`, `gejala`, `tb`, `bb`, `td`, `kat_penyakit`, `obat`, `id_dokter`, `id_pb`, `created_at`, `updated_at`) VALUES
(6, 3, '2021-01-17', '8 59 68 118 129 98 68 62 4 59 18 59 99 98 91 118 100 39 33 38 98 129 62 49 80 39 21 32 59 129', 170, 55, 60, 'TM', '18 59 49 59 80 62 129 59 21 45 4', NULL, NULL, '2021-02-25 10:01:35', '2021-02-03 21:19:26'),
(7, 1, '2021-01-26', '77 62 49 118 59 33 38', 170, 72, 80, 'TM', '77 59 4 59 21 98 21 118 33 38 38 39', 4, NULL, '2021-01-26 23:10:36', '2021-02-03 21:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `nama` varchar(155) NOT NULL,
  `level` enum('pemilik','admin-klinik') NOT NULL,
  `foto` tinytext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `level`, `foto`, `created_at`, `updated_at`) VALUES
(7, 'pemilik', '$2y$10$loJj4n4qvh6jHZy/ZMKBieXGc1kR0gRiCuvFXKaxJ5kdezi8tYyyu', 'Riki', 'pemilik', '16b292c30eb679317d0c3c261aa3e169.png', '2021-01-19 21:41:38', '2021-01-30 18:02:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perawat_bidan`
--
ALTER TABLE `perawat_bidan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pasien`
--
ALTER TABLE `riwayat_pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_perawat_bidan` (`id_pb`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `perawat_bidan`
--
ALTER TABLE `perawat_bidan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `riwayat_pasien`
--
ALTER TABLE `riwayat_pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
