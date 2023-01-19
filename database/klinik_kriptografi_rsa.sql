/*
SQLyog Ultimate
MySQL - 10.6.5-MariaDB-log : Database - klinik_citra_bunda
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `dokter` */

DROP TABLE IF EXISTS `dokter`;

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_dokter` varchar(35) NOT NULL,
  `nip` text DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `foto` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `dokter` */

insert  into `dokter`(`id`,`nama_dokter`,`nip`,`no_hp`,`foto`,`created_at`,`updated_at`) values (4,'dr. Ira Mirosa','141 72 72 31 114 141 72 8 84 69 36 84 13 31 29 29 83 114 108 8 31 116 36 36 76 31 41 126 36 76','36 41 116 126 41 36 116 73 126 36','74c3652387c2987fc6e343f95d5af33b.jpg','2021-01-17 22:34:32','2023-01-19 20:28:01'),(6,'dr. Sutri Wahyuni','36','126 56 41 36 55 36 41 76 73 73 73 116','default.png','2023-01-19 20:29:50',NULL),(7,'drg. Nila Parmusia','36 73 55 36 126 76 36 126 98 41 126 126 116 36 41 98 126 126 116','','default.png','2023-01-19 20:30:54',NULL),(8,'drg. Rosenti','36 73 55 76 126 76 126 73 98 41 126 126 76 126 13 98 126 126 56','','default.png','2023-01-19 20:31:25',NULL);

/*Table structure for table `pasien` */

DROP TABLE IF EXISTS `pasien`;

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pasien` varchar(11) NOT NULL,
  `nama_pasien` varchar(35) NOT NULL,
  `nik` tinytext NOT NULL,
  `kategori` enum('bayi','anak-anak','remaja','dewasa','lanjut usia') DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `umur` int(11) NOT NULL,
  `alamat` tinytext NOT NULL,
  `no_hp` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pasien` */

insert  into `pasien`(`id`,`kode_pasien`,`nama_pasien`,`nik`,`kategori`,`jenis_kelamin`,`umur`,`alamat`,`no_hp`,`created_at`,`updated_at`) values (1,'P-0001','test2','73 13 36 41 116 56 41 73 36 116 56','dewasa','laki-laki',23,'Jl lintas timur desa kemang','36 41 116 41 92 36 41 13 36 41 116 41 36 116','2021-01-21 23:35:35','2021-02-03 22:10:48'),(3,'P-0003','test1','36 41 36 116 41 36 116 41 116 36','anak-anak','laki-laki',23,'ddfsdfasdasdadasdasd','56 116 13 41 116 13 41 116 13 41 116 13','2021-01-23 20:24:47','2021-02-03 22:10:38');

/*Table structure for table `perawat_bidan` */

DROP TABLE IF EXISTS `perawat_bidan`;

CREATE TABLE `perawat_bidan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(35) NOT NULL,
  `nip` text DEFAULT NULL,
  `pekerjaan` enum('perawat','bidan') DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `foto` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `perawat_bidan` */

insert  into `perawat_bidan`(`id`,`nama`,`nip`,`pekerjaan`,`no_hp`,`foto`,`created_at`,`updated_at`) values (6,'Nelleksum','36 73 56 36 126 76 126 55 98 41 126 126 76 126 13 98 41 98 126 126 73','perawat','','a0e5a105172236b85f06edadf12480a7.jpg','2021-01-19 22:11:57','2023-01-19 20:24:42'),(8,'Nira Dewi','36 73 56 41 126 73 36 13 98 41 126 36 92 126 116 98 41 98 126 126 13','perawat','','default.png','2023-01-19 20:25:02',NULL),(9,'Narti Jelita Siregar','36 73 56 41 126 76 41 55 98 41 126 36 56 126 92 98 41 98 126 126 41','perawat','','default.png','2023-01-19 20:25:39',NULL),(10,'Novita Sari','111','perawat','','default.png','2023-01-19 20:26:09',NULL),(11,'Monalisa','126 13 84 126 116 84 126 36 84 66 84 126 13 36','perawat','','default.png','2023-01-19 20:26:52',NULL);

/*Table structure for table `riwayat_pasien` */

DROP TABLE IF EXISTS `riwayat_pasien`;

CREATE TABLE `riwayat_pasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_perawat_bidan` (`id_pb`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `riwayat_pasien` */

insert  into `riwayat_pasien`(`id`,`id_pasien`,`tgl_berobat`,`gejala`,`tb`,`bb`,`td`,`kat_penyakit`,`obat`,`id_dokter`,`id_pb`,`created_at`,`updated_at`) values (6,3,'2021-01-17','8 59 68 118 129 98 68 62 4 59 18 59 99 98 91 118 100 39 33 38 98 129 62 49 80 39 21 32 59 129',170,55,60,'TM','18 59 49 59 80 62 129 59 21 45 4',8,NULL,'2021-02-25 10:01:35','2023-01-19 21:18:56'),(7,1,'2021-01-26','77 62 49 118 59 33 38',170,72,80,'TM','77 59 4 59 21 98 21 118 33 38 38 39',4,NULL,'2021-01-26 23:10:36','2021-02-03 21:19:08');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `nama` varchar(155) NOT NULL,
  `level` enum('pemilik','admin-klinik') NOT NULL,
  `foto` tinytext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`nama`,`level`,`foto`,`created_at`,`updated_at`) values (7,'pemilik','$2y$10$loJj4n4qvh6jHZy/ZMKBieXGc1kR0gRiCuvFXKaxJ5kdezi8tYyyu','Riki','pemilik','16b292c30eb679317d0c3c261aa3e169.png','2021-01-19 21:41:38','2021-01-30 18:02:18'),(8,'admin','$2y$10$S2IxeBXuHaMBNPsbWz5MCuRsQPw.8tbB3b6u3QYqhEGh6YjRPp/0W','Admin','admin-klinik','default.png','2023-01-19 21:18:03',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
