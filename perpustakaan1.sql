-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_perpustakaan
CREATE DATABASE IF NOT EXISTS `db_perpustakaan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_perpustakaan`;

-- Dumping structure for table db_perpustakaan.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perpustakaan.admin: ~1 rows (approximately)
DELETE FROM `admin`;
INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
	(1, 'admin', '482c811da5d5b4bc6d497ffa98491e38', 'Administrator Global');

-- Dumping structure for table db_perpustakaan.anggota
CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` int NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `id_jurusan` int DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_anggota`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perpustakaan.anggota: ~27 rows (approximately)
DELETE FROM `anggota`;
INSERT INTO `anggota` (`id_anggota`, `nim`, `id_jurusan`, `nama`, `jenis_kelamin`, `alamat`, `created_at`, `updated_at`) VALUES
	(1, '11283837', 1, 'Rizki Adha', 'L', NULL, '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(2, '4433', 2, 'Adam', 'L', NULL, '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(3, '2200001', 1, 'Fajar Ramadhan', 'L', 'Jl. Gatot Subroto No. 80', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(4, '2200002', 3, 'Dedi Kurniawan', 'L', 'Jl. Gatot Subroto No. 49', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(5, '2200003', 4, 'Fitri Handayani', 'P', 'Jl. Rasuna Said No. 47', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(6, '2200004', 3, 'Kartika Putri', 'P', 'Jl. Thamrin No. 26', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(7, '2200005', 3, 'Naufal Abdi', 'L', 'Jl. Gatot Subroto No. 19', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(8, '2200006', 3, 'Kartika Putri', 'P', 'Jl. Thamrin No. 26', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(9, '2200007', 1, 'Dedi Kurniawan', 'L', 'Jl. Sudirman No. 82', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(10, '2200008', 5, 'Hana Pertiwi', 'P', 'Jl. Rasuna Said No. 22', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(11, '2200009', 4, 'Cahyo Utomo', 'L', 'Jl. Thamrin No. 77', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(12, '2200010', 5, 'Hana Pertiwi', 'P', 'Jl. Rasuna Said No. 3', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(13, '2200011', 5, 'Naufal Abdi', 'L', 'Jl. Rasuna Said No. 93', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(14, '2200012', 4, 'Gita Gutawa', 'P', 'Jl. Thamrin No. 37', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(15, '2200013', 5, 'Naufal Abdi', 'L', 'Jl. Thamrin No. 51', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(16, '2200014', 4, 'Galih Saputra', 'L', 'Jl. Thamrin No. 24', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(17, '2200015', 3, 'Citra Lestari', 'P', 'Jl. Thamrin No. 26', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(18, '2200016', 1, 'Ahmad Fauzi', 'L', 'Jl. Gatot Subroto No. 80', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(19, '2200017', 4, 'Lukman Hakim', 'L', 'Jl. Sudirman No. 59', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(20, '2200018', 3, 'Budi Santoso', 'L', 'Jl. Thamrin No. 76', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(21, '2200019', 3, 'Indra Lesmana', 'L', 'Jl. Gatot Subroto No. 74', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(22, '2200020', 5, 'Cahyo Utomo', 'L', 'Jl. Thamrin No. 69', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(23, '2200021', 3, 'Joko Susilo', 'L', 'Jl. Gatot Subroto No. 24', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(24, '2200022', 4, 'Muhammad Ridho', 'L', 'Jl. Gatot Subroto No. 47', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(25, '2200023', 4, 'Kevin Sanjaya', 'L', 'Jl. Thamrin No. 57', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(26, '2200024', 4, 'Nia Ramadhani', 'P', 'Jl. Rasuna Said No. 13', '2026-05-06 03:19:51', '2026-05-06 03:19:52'),
	(27, '2200025', 5, 'Gita Gutawa', 'P', 'Jl. Rasuna Said No. 41', '2026-05-06 03:19:51', '2026-05-06 03:19:52');

-- Dumping structure for table db_perpustakaan.buku
CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `isbn` varchar(20) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `stok` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_buku`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perpustakaan.buku: ~2 rows (approximately)
DELETE FROM `buku`;
INSERT INTO `buku` (`id_buku`, `isbn`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `created_at`, `updated_at`) VALUES
	(1, '978-602-03-3160-7', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', 3, '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(2, '978-979-12-2702-5', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', '1980', 3, '2026-05-06 03:19:52', '2026-05-06 03:19:52');

-- Dumping structure for table db_perpustakaan.jurusan
CREATE TABLE IF NOT EXISTS `jurusan` (
  `id_jurusan` int NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perpustakaan.jurusan: ~5 rows (approximately)
DELETE FROM `jurusan`;
INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
	(1, 'Teknik Informatika', '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(2, 'Sistem Informasi', '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(3, 'Hukum', '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(4, 'Manajemen', '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(5, 'Akuntansi', '2026-05-06 03:19:52', '2026-05-06 03:19:52');

-- Dumping structure for table db_perpustakaan.peminjaman
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id_pinjam` int NOT NULL AUTO_INCREMENT,
  `id_buku` int NOT NULL,
  `id_anggota` int NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('Pinjam','Kembali') DEFAULT 'Pinjam',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pinjam`),
  KEY `id_buku` (`id_buku`),
  KEY `id_anggota` (`id_anggota`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perpustakaan.peminjaman: ~2 rows (approximately)
DELETE FROM `peminjaman`;
INSERT INTO `peminjaman` (`id_pinjam`, `id_buku`, `id_anggota`, `tgl_pinjam`, `tgl_kembali`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2026-04-01', NULL, 'Pinjam', '2026-05-06 03:19:52', '2026-05-06 03:19:52'),
	(2, 1, 1, '2026-04-29', NULL, 'Pinjam', '2026-05-06 03:19:52', '2026-05-06 03:19:52');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
