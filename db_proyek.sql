-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Des 2020 pada 14.19
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_proyek`
--
CREATE DATABASE IF NOT EXISTS `db_proyek` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_proyek`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_alat`
--

CREATE TABLE `tb_alat` (
  `id` int(11) NOT NULL,
  `kode_alat` varchar(128) DEFAULT NULL,
  `nama_alat` varchar(254) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_alat`
--

INSERT INTO `tb_alat` (`id`, `kode_alat`, `nama_alat`, `date_created`) VALUES
(2, 'ALT3124', 'Garpu tala', '2020-12-20 22:04:21'),
(3, 'ALT3125', 'Palu', '2020-12-20 22:08:48'),
(4, 'ALT3126', 'Sendok Semen', '2020-12-20 22:19:23'),
(6, 'ALT3127', 'Cangkul', '2020-12-21 22:19:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(128) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `kode_barang`, `nama_barang`, `keterangan`, `date_created`) VALUES
(4, 'BRG0003', 'Batu Bata', 'Batu bata kulim', '2020-12-15 22:51:19'),
(5, 'BRG0004', 'Pasir Cor', 'Pasir Cor', '2020-12-20 21:54:59'),
(6, 'BRG0005', 'Semen', 'Semen Padang', '2020-12-20 21:55:21'),
(7, 'BRG0006', 'Pasir Kasarr', 'Pasir kasar dari air molekkk', '2020-12-27 15:35:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pemasukan`
--

CREATE TABLE `tb_pemasukan` (
  `id` int(11) NOT NULL,
  `proyek` int(11) DEFAULT NULL,
  `jumlah` varchar(30) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_bayar` enum('cash','transfer') DEFAULT NULL,
  `bukti_bayar` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pemasukan`
--

INSERT INTO `tb_pemasukan` (`id`, `proyek`, `jumlah`, `tanggal`, `jenis_bayar`, `bukti_bayar`) VALUES
(2, 1, '2000000', '2020-12-29', 'transfer', 'df499399b26db589d9bd21da6eebcd06.jpg'),
(3, 1, '20000000', '2020-12-29', 'cash', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_proyek`
--

CREATE TABLE `tb_proyek` (
  `id` int(11) NOT NULL,
  `nama_proyek` varchar(254) NOT NULL,
  `alamat_proyek` tinytext DEFAULT NULL,
  `anggaran_proyek` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `pemilik` tinytext DEFAULT NULL,
  `dokumen` tinytext DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_proyek`
--

INSERT INTO `tb_proyek` (`id`, `nama_proyek`, `alamat_proyek`, `anggaran_proyek`, `tanggal_mulai`, `tanggal_selesai`, `pemilik`, `dokumen`, `date_created`) VALUES
(1, 'Singgalang', 'Jl. ga jelas', '5000000000', '2020-12-01', '2020-12-31', 'Sujiwo', '44761acbc0fd093fb45f1e4a35fb83fc.pdf', '2020-12-21 22:26:59'),
(3, 'Hambalang mmm', 'Jalan Jalan', '2000000000', '2020-12-01', '2020-12-31', 'Tejo', 'be1185a650fbc6bb6f2937ff2decf9e7.pdf', '2020-12-27 23:23:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_satuan`
--

CREATE TABLE `tb_satuan` (
  `satuan_id` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_satuan`
--

INSERT INTO `tb_satuan` (`satuan_id`, `satuan`) VALUES
(1, 'Lusin'),
(2, 'Bungkus'),
(3, 'Pak'),
(4, 'Slop'),
(5, 'Dus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sub_transaksi`
--

CREATE TABLE `tb_sub_transaksi` (
  `id` int(11) NOT NULL,
  `no_trans` varchar(100) NOT NULL,
  `id_item` int(11) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `satuan` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_sub_transaksi`
--

INSERT INTO `tb_sub_transaksi` (`id`, `no_trans`, `id_item`, `jenis`, `satuan`, `jumlah`, `harga`) VALUES
(91, 'TRX0005', 1, 'transportasi', NULL, 2, '50000'),
(92, 'TRX0005', 2, 'transportasi', NULL, 1, '50000'),
(93, 'TRX0006', 2, 'alat', NULL, 1, '40000'),
(94, 'TRX0007', 1, 'transportasi', NULL, 1, '2000000'),
(95, 'TRX0008', 2, 'alat', NULL, 10, '2000'),
(96, 'TRX0008', 3, 'alat', NULL, 10, '2000'),
(97, 'TRX0008', 6, 'alat', NULL, 10, '2000'),
(98, 'TRX0008', 4, 'alat', NULL, 10, '2000'),
(99, 'TRX0009', 3, 'alat', NULL, 1, '10000'),
(100, 'TRX0009', 2, 'alat', NULL, 1, '10000'),
(102, 'TRX0012', 5, 'barang', 4, 24, '50000'),
(103, 'TRX0012', 4, 'barang', 1, 72, '50000'),
(104, 'TRX0013', 4, 'barang', 2, 22, '300000'),
(105, 'TRX0013', 5, 'barang', 2, 10, '300000'),
(106, 'TRX0014', 5, 'barang', 1, 1, '1000000'),
(107, 'TRX0014', 5, 'barang', 2, 1, '1000000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_suplier`
--

CREATE TABLE `tb_suplier` (
  `id` int(11) NOT NULL,
  `nama_suplier` varchar(254) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_suplier`
--

INSERT INTO `tb_suplier` (`id`, `nama_suplier`, `date_created`) VALUES
(1, 'Jaya abadi', '2020-12-21 22:33:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `no_trans` varchar(100) NOT NULL,
  `total` varchar(20) NOT NULL,
  `suplier` int(11) DEFAULT NULL,
  `jenis_transaksi` varchar(20) DEFAULT NULL,
  `proyek` int(11) DEFAULT NULL,
  `jenis_pembayaran` varchar(20) DEFAULT NULL,
  `bukti_bayar` tinytext DEFAULT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`no_trans`, `total`, `suplier`, `jenis_transaksi`, `proyek`, `jenis_pembayaran`, `bukti_bayar`, `date_created`) VALUES
('TRX0005', '150000', 1, 'transportasi', 1, 'cash', NULL, '2020-12-26'),
('TRX0006', '40000', 1, 'alat', 1, 'transfer', '73716d019e7d1136952b065cfc5c257a.png', '2020-12-26'),
('TRX0007', '2000000', 1, 'transportasi', 1, 'cash', NULL, '2020-12-26'),
('TRX0008', '80000', 1, 'alat', 1, 'transfer', '608a52ea2de3c2ed161a3915016c00cd.jpg', '2020-12-26'),
('TRX0009', '20000', 1, 'alat', 1, 'cash', NULL, '2020-12-26'),
('TRX0012', '4800000', 1, 'barang', 1, 'cash', NULL, '2020-12-27'),
('TRX0013', '9600000', 1, 'barang', 1, 'cash', NULL, '2020-12-27'),
('TRX0014', '2000000', 1, 'barang', 1, 'transfer', '98d9f1e246d45cfe3c77d339dec07c50.jpg', '2020-12-27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transportasi`
--

CREATE TABLE `tb_transportasi` (
  `id` int(11) NOT NULL,
  `nama_kendaraan` varchar(128) NOT NULL,
  `jenis_kendaraan` enum('pickup','truk','kontainer') NOT NULL DEFAULT 'pickup'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_transportasi`
--

INSERT INTO `tb_transportasi` (`id`, `nama_kendaraan`, `jenis_kendaraan`) VALUES
(1, 'L300', 'pickup'),
(2, 'Mitsubishi Canter HDL', 'truk');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(248) NOT NULL,
  `role_id` int(1) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'vanrezky', 'vanrezkysadewa1@gmail.com', 'default.png', '$2y$10$CKzopz5HkuaoE.9GuMFhoeF2rIt0xF5Jg.Bevb78W2txwBdJXJwxq', 1, 1, 1592804077),
(2, 'Yensiska', 'yensiska@gmail.com', 'default.png', '$2y$10$q1fUUZ9Xd4cWb46lAdAg..s9hURx2Z6PBCV4PKzKF6pv7CcSGacWu', 2, 1, 1592807639),
(6, 'kasir', 'kasir@gmail.com', 'default.png', '$2y$10$JUzowKxWhHibbOdSS7xQeu55c9Z4eyAHaE5CRnQawgkYAkNzUCYqK', 3, 1, 1592808349),
(7, 'Administrator', 'admin@admin.com', 'default.png', '$2y$10$TeQIYhONz.f8WSlfB9R2YOE7lEsh/OYjcsbIv/3S3X1s7JjRh43c.', 1, 1, 1592969750),
(8, 'Bos Besar', 'bosgadang@gmail.com', 'default.png', '$2y$10$pK8YEcL4ayOzrcgZG1MZK.r29SpurvqzOBBC0OMpbFW6yVn/dDx8u', 2, 1, 1592969782),
(9, 'pimpinan', 'pimpinan@gmail.com', 'default.png', '$2y$10$9fCNDn0FcxIKIl9otR3cGe5o7psVFuTMOwOvna6q4ogVVbETXi6/C', 2, 1, 1608046657),
(10, 'Vanrezky Kece', 'asdasd@gmail.com', 'e754e5f7fc98d5749e4afe1d33e3e78b.jpg', '321', 2, 1, 1608481190),
(11, 'pegawai', 'pegawai@gmail.com', '625838a32ed5b36f136f26cee73784ac.jpg', '$2y$10$Bs56RQeDHJoE7AoLY3316.AFefwia8cmOW2saS99KIOPP3iiYlKBy', 3, 1, 1608969141);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_access_menu`
--

CREATE TABLE `tb_user_access_menu` (
  `id_uam` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `a_create` enum('0','1') DEFAULT NULL,
  `a_read` enum('0','1') DEFAULT NULL,
  `a_update` enum('0','1') DEFAULT NULL,
  `a_delete` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user_access_menu`
--

INSERT INTO `tb_user_access_menu` (`id_uam`, `menu_id`, `role_id`, `a_create`, `a_read`, `a_update`, `a_delete`) VALUES
(22, 2, 1, '1', '1', '1', '1'),
(25, 3, 1, '1', '1', '1', '1'),
(27, 4, 1, '1', '1', '1', '1'),
(31, 1, 1, '1', '1', '1', '1'),
(55, 4, 2, NULL, NULL, NULL, NULL),
(56, 3, 2, NULL, NULL, NULL, NULL),
(59, 2, 2, NULL, NULL, NULL, NULL),
(60, 1, 2, NULL, NULL, NULL, NULL),
(63, 8, 2, NULL, NULL, NULL, NULL),
(64, 3, 3, NULL, NULL, NULL, NULL),
(65, 2, 3, NULL, NULL, NULL, NULL),
(66, 4, 3, NULL, NULL, NULL, NULL),
(67, 8, 3, NULL, NULL, NULL, NULL),
(68, 9, 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_menu`
--

CREATE TABLE `tb_user_menu` (
  `id_um` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `menu_urut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user_menu`
--

INSERT INTO `tb_user_menu` (`id_um`, `menu`, `menu_urut`) VALUES
(1, 'Admin Management', 6),
(2, 'Master Management', 2),
(3, 'Dashboard', 1),
(4, 'Transaksi Management', 4),
(8, 'Laporan Management', 5),
(9, 'Pemasukan Management', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_role`
--

CREATE TABLE `tb_user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user_role`
--

INSERT INTO `tb_user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Pimpinan'),
(3, 'Pegawai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_sub_menu`
--

CREATE TABLE `tb_user_sub_menu` (
  `id_usm` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `field_url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user_sub_menu`
--

INSERT INTO `tb_user_sub_menu` (`id_usm`, `menu_id`, `title`, `field_url`, `icon`, `is_active`) VALUES
(1, 1, 'Menu', 'menu', 'fas fa-th-large', 1),
(2, 3, 'Dashboard', 'dashboard', 'fas fa-fire', 1),
(4, 2, 'Barang', 'barang', 'far fa-square', 1),
(5, 1, 'User', 'user', 'fas fa-users', 1),
(8, 4, 'Transaksi', 'transaksi', 'fas fa-th', 1),
(10, 2, 'Alat', 'alat', 'fas fa-tools', 0),
(11, 2, 'Transportasi', 'transportasi', 'fas fa-car', 0),
(12, 2, 'Proyek', 'proyek', 'fas fa-box', 0),
(13, 2, 'Suplier', 'suplier', 'fas fa-users', 0),
(14, 8, 'Laporan', 'laporan/transaksi', 'fas fa-file-pdf', 0),
(15, 9, 'Pemasukan', 'pemasukan', 'fas fa-cash-register', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_alat`
--
ALTER TABLE `tb_alat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_proyek`
--
ALTER TABLE `tb_proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indeks untuk tabel `tb_sub_transaksi`
--
ALTER TABLE `tb_sub_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_resi` (`no_trans`);

--
-- Indeks untuk tabel `tb_suplier`
--
ALTER TABLE `tb_suplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`no_trans`);

--
-- Indeks untuk tabel `tb_transportasi`
--
ALTER TABLE `tb_transportasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user_access_menu`
--
ALTER TABLE `tb_user_access_menu`
  ADD PRIMARY KEY (`id_uam`);

--
-- Indeks untuk tabel `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  ADD PRIMARY KEY (`id_um`);

--
-- Indeks untuk tabel `tb_user_role`
--
ALTER TABLE `tb_user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  ADD PRIMARY KEY (`id_usm`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_alat`
--
ALTER TABLE `tb_alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_proyek`
--
ALTER TABLE `tb_proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `satuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_sub_transaksi`
--
ALTER TABLE `tb_sub_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT untuk tabel `tb_suplier`
--
ALTER TABLE `tb_suplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_transportasi`
--
ALTER TABLE `tb_transportasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_user_access_menu`
--
ALTER TABLE `tb_user_access_menu`
  MODIFY `id_uam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  MODIFY `id_um` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_user_role`
--
ALTER TABLE `tb_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  MODIFY `id_usm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_sub_transaksi`
--
ALTER TABLE `tb_sub_transaksi`
  ADD CONSTRAINT `no_resi` FOREIGN KEY (`no_trans`) REFERENCES `tb_transaksi` (`no_trans`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
