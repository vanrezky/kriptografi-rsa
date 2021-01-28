-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2021 at 03:09 AM
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
-- Database: `skripsi_enkripsi`
--
CREATE DATABASE IF NOT EXISTS `skripsi_enkripsi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `skripsi_enkripsi`;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama_dokter` varchar(128) NOT NULL,
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
(2, 'Vanrezky S.Pog', '3047 16024 6042', '3047 16024 6042', 'a92937af3d32cbef1a155328b62d402e.jpeg', '2021-01-17 22:27:02', '2021-01-21 21:58:42'),
(3, 'Winda S.pok', '16024 10026 3047', '16024 10026 3047', '208d59c92d13494213d8e739ad6b36e7.jpg', '2021-01-17 22:31:33', '2021-01-21 21:58:27'),
(4, 'Siska Afni', '3047 16024 10026 3047 6042 7726 16024', '3047 10026 16024 7726 10026 3047 16024 6042 7726 3047', '74c3652387c2987fc6e343f95d5af33b.jpg', '2021-01-17 22:34:32', '2021-01-21 22:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `kode_pasien` varchar(128) NOT NULL,
  `nama_pasien` varchar(128) NOT NULL,
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
(1, 'P-0001', 'Vanrezky Sadewa', '6042 14402 3047 10026 16024 15654 10026 6042 3047 16024 15654', 'dewasa', 'laki-laki', 23, 'Jl lintas timur desa kemang', '3047 10026 16024 10026 4641 3047 10026 14402 3047 10026 16024 10026 3047 16024', '2021-01-21 23:35:35', '0000-00-00 00:00:00'),
(2, 'P-0001', 'Iky', '3047 10026 16024', 'bayi', 'laki-laki', 2, 'Jln Lintas Sumatera Km 10 Kota Pekanbaru', '7726 15654 3047 10026', '2021-01-21 23:46:16', '0000-00-00 00:00:00'),
(3, 'P-0003', 'asdasdasd', '3047 10026 16024 3047 10026 16024 3047 10026 16024', 'anak-anak', 'laki-laki', 23, 'ddfsdfasdasdadasdasd', '15654 16024 14402 10026 16024 14402 10026 16024 14402 10026 16024 14402', '2021-01-23 20:24:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `perawat_bidan`
--

CREATE TABLE `perawat_bidan` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
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
(5, 'Widya Amd.Kep', '3047 10026 16024 3047 10026 4641 3047', 'perawat', '7726 15654 10026 10026 10203 15654 10026 10203 10026 7726 3047 7687', '4fe75f8aa2c5ebb6ab47ae94ee989597.jpg', '2021-01-17 22:56:15', '2021-01-21 21:20:13'),
(6, 'Cantik Jelita', '3047 10026 16024', 'perawat', '7726 15654 7687 15654 7687 15654 3047 10026 16024 15654', 'a0e5a105172236b85f06edadf12480a7.jpg', '2021-01-19 22:11:57', '2021-01-21 21:20:06'),
(7, 'Rindaman Amd.Kep', '15654 6042 6042 4641 7687 4641 10026 4641 7687 10026 7726 16024 15654 14402 7687', 'perawat', '7726 15654 10026 10026 10203 15654 10026 10203 10026 7726 3047 7687', 'd12531a8575ebfb3d35c2e04bfc10d94.jpeg', '2021-01-21 21:15:33', NULL);

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
(6, 3, '2021-01-17', '6413 4358 14937 11189 6345 6201 14937 12763 7158 4358 4180 4358 13629 6201 17339 11189 1494 10629 15351 8480 6201 6345 12763 15934 14722 10629 2479 8799 4358 6345', 170, 55, 60, 'TM', '4180 4358 15934 4358 14722 12763 6345 4358 2479 2341 7158', 3, NULL, '2021-02-25 10:01:35', '2021-01-26 23:10:55'),
(7, 1, '2021-01-26', '4305 12763 15934 11189 4358 15351 8480', 170, 72, 80, 'TM', '4305 4358 7158 4358 2479 6201 2479 11189 15351 8480 8480 10629', 4, NULL, '2021-01-26 23:10:36', NULL);

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
(5, 'rezky', '$2y$10$DoOlNKLPn1q/8pRQyf1jiu8aV5IcTacg8e.2YECqjx3Cs5sM7Weje', 'Rezky', 'pemilik', 'd5460ae9d49a99d2f5f01dcbdd1bfa25.jpg', '2021-01-17 21:29:31', '2021-01-17 22:43:52'),
(6, 'afni', '$2y$10$z0V8wuCjEN1ldhNjKzzamuenRtK7pUiSRs/LrHkoZNQPtRaFLzUCG', 'afni', 'admin-klinik', '45648a4962d3cd91b5d33d4cf0dfc5cc.jpg', '2021-01-17 22:44:22', '2021-01-27 13:23:04'),
(7, 'pemilik', '$2y$10$loJj4n4qvh6jHZy/ZMKBieXGc1kR0gRiCuvFXKaxJ5kdezi8tYyyu', 'Riki', 'pemilik', '3ae52f2c987d5f262372b2512e40316b.jpg', '2021-01-19 21:41:38', '2021-01-19 21:47:44');

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `riwayat_pasien`
--
ALTER TABLE `riwayat_pasien`
  ADD CONSTRAINT `id_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_perawat_bidan` FOREIGN KEY (`id_pb`) REFERENCES `perawat_bidan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
