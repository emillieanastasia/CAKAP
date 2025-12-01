-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2025 at 03:31 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int UNSIGNED NOT NULL,
  `siswa_id` int UNSIGNED NOT NULL,
  `jadwal_kelas_id` int UNSIGNED NOT NULL,
  `status` enum('hadir','izin','alpha','sakit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `siswa_id`, `jadwal_kelas_id`, `status`, `tanggal`, `created_at`) VALUES
(1, 1, 20, 'alpha', '2025-11-30', '2025-11-29 21:23:34'),
(2, 1, 5, 'izin', '2025-11-30', '2025-11-30 00:29:28'),
(3, 7, 5, 'hadir', '2025-11-30', '2025-11-30 00:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `id` int UNSIGNED NOT NULL,
  `kelas_id` int UNSIGNED NOT NULL,
  `mata_pelajaran_id` int UNSIGNED NOT NULL,
  `tentor_id` int UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id`, `kelas_id`, `mata_pelajaran_id`, `tentor_id`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES
(5, 5, 2, 2, 'Senin', '13:00:00', '14:30:00', '2025-11-27 18:05:25'),
(6, 7, 3, 3, 'Senin', '15:00:00', '16:30:00', '2025-11-27 18:06:50'),
(7, 8, 11, 8, 'Senin', '16:30:00', '18:00:00', '2025-11-27 18:07:27'),
(8, 13, 7, 5, 'Senin', '18:30:00', '20:00:00', '2025-11-27 18:08:34'),
(9, 6, 6, 4, 'Selasa', '13:00:00', '14:30:00', '2025-11-28 08:20:42'),
(10, 7, 3, 3, 'Selasa', '13:00:00', '14:30:00', '2025-11-28 08:21:37'),
(11, 19, 12, 14, 'Selasa', '14:30:00', '17:00:00', '2025-11-28 08:22:13'),
(12, 1, 1, 1, 'Selasa', '13:00:00', '14:30:00', '2025-11-28 08:22:45'),
(13, 24, 14, 6, 'Rabu', '18:00:00', '19:30:00', '2025-11-28 08:23:22'),
(14, 26, 17, 10, 'Rabu', '19:30:00', '22:00:00', '2025-11-28 08:25:05'),
(15, 15, 2, 11, 'Rabu', '18:30:00', '20:00:00', '2025-11-28 08:25:33'),
(16, 24, 11, 8, 'Jumat', '18:00:00', '19:30:00', '2025-11-28 09:35:32'),
(17, 19, 2, 2, 'Jumat', '18:30:00', '20:00:00', '2025-11-28 15:20:09'),
(18, 11, 3, 3, 'Jumat', '19:00:00', '20:30:00', '2025-11-28 15:20:53'),
(19, 6, 6, 4, 'Kamis', '08:12:00', '09:18:00', '2025-11-28 21:12:54'),
(20, 3, 2, 2, 'Minggu', '02:07:00', '05:11:00', '2025-11-29 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int UNSIGNED NOT NULL,
  `kelas` enum('Calistung','TK','SD','SMP','SMA','UTBK','Kedinasan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_kelas` varchar(20) DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `mata_pelajaran_id` int UNSIGNED NOT NULL,
  `tentor_id` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`, `nama_kelas`, `harga`, `mata_pelajaran_id`, `tentor_id`, `created_at`) VALUES
(1, 'Calistung', 'Calistung Dasar', 25000.00, 1, NULL, '2025-11-27 15:41:13'),
(2, 'SD', 'Kelas I', 30000.00, 2, NULL, '2025-11-27 15:41:13'),
(3, 'SD', 'Kelas II', 30000.00, 2, NULL, '2025-11-27 15:41:13'),
(4, 'SD', 'Kelas III', 30000.00, 3, NULL, '2025-11-27 15:41:13'),
(5, 'SD', 'Kelas IV', 30000.00, 4, NULL, '2025-11-27 15:41:13'),
(6, 'SD', 'Kelas V', 30000.00, 2, NULL, '2025-11-27 15:41:13'),
(7, 'SD', 'Kelas VI', 30000.00, 4, NULL, '2025-11-27 15:41:13'),
(8, 'SMP', 'Kelas VII', 40000.00, 2, NULL, '2025-11-27 15:41:13'),
(9, 'SMP', 'Kelas VII', 40000.00, 3, NULL, '2025-11-27 15:41:13'),
(10, 'SMP', 'Kelas VIII', 40000.00, 4, NULL, '2025-11-27 15:41:13'),
(11, 'SMP', 'Kelas IX', 40000.00, 2, NULL, '2025-11-27 15:41:13'),
(12, 'SMP', 'Kelas IX', 40000.00, 5, NULL, '2025-11-27 15:41:13'),
(13, 'SMA', 'Kelas X', 50000.00, 2, NULL, '2025-11-27 15:41:13'),
(14, 'SMA', 'Kelas X', 50000.00, 3, NULL, '2025-11-27 15:41:13'),
(15, 'SMA', 'Kelas XI', 50000.00, 7, NULL, '2025-11-27 15:41:13'),
(16, 'SMA', 'Kelas XI', 50000.00, 8, NULL, '2025-11-27 15:41:13'),
(17, 'SMA', 'Kelas XI', 50000.00, 11, NULL, '2025-11-27 15:41:13'),
(18, 'SMA', 'Kelas XI', 50000.00, 12, NULL, '2025-11-27 15:41:13'),
(19, 'SMA', 'Kelas XII', 55000.00, 6, NULL, '2025-11-27 15:41:13'),
(20, 'SMA', 'Kelas XII', 55000.00, 9, NULL, '2025-11-27 15:41:13'),
(21, 'SMA', 'Kelas XII', 55000.00, 2, NULL, '2025-11-27 15:41:13'),
(22, 'UTBK', 'Pejuang PTN', 65000.00, 13, NULL, '2025-11-27 15:41:13'),
(23, 'UTBK', 'Pejuang PTN', 65000.00, 16, NULL, '2025-11-27 15:41:13'),
(24, 'UTBK', 'Intensif SNBT', 65000.00, 14, NULL, '2025-11-27 15:41:13'),
(25, 'UTBK', 'Intensif SNBT', 65000.00, 15, NULL, '2025-11-27 15:41:13'),
(26, 'Kedinasan', 'Kelas SKD', 75000.00, 17, NULL, '2025-11-27 15:41:13'),
(27, 'Kedinasan', 'Kelas SKD', 75000.00, 18, NULL, '2025-11-27 15:41:13'),
(28, 'Kedinasan', 'Kelas SKD', 75000.00, 19, NULL, '2025-11-27 15:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_siswa`
--

CREATE TABLE `kelas_siswa` (
  `id` int UNSIGNED NOT NULL,
  `siswa_id` int UNSIGNED DEFAULT NULL,
  `jadwal_id` int UNSIGNED DEFAULT NULL,
  `tentor_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas_siswa`
--

INSERT INTO `kelas_siswa` (`id`, `siswa_id`, `jadwal_id`, `tentor_id`, `created_at`, `updated_at`) VALUES
(11, 7, 14, 10, NULL, NULL),
(12, 1, 20, 2, NULL, NULL),
(13, 7, 5, 2, '2025-11-30 00:27:24', '2025-11-30 00:27:24'),
(14, 7, 17, 2, '2025-11-30 00:27:35', '2025-11-30 00:27:35'),
(15, 1, 5, 2, '2025-11-30 00:29:02', '2025-11-30 00:29:02'),
(16, 1, 6, 3, '2025-11-30 01:45:41', '2025-11-30 01:45:41'),
(17, 1, 7, 8, '2025-11-30 01:45:46', '2025-11-30 01:45:46'),
(18, 1, 8, 5, '2025-11-30 01:45:51', '2025-11-30 01:45:51'),
(19, 1, 9, 4, '2025-11-30 01:45:57', '2025-11-30 01:45:57'),
(20, 1, 10, 3, '2025-11-30 01:46:02', '2025-11-30 01:46:02'),
(21, 1, 11, 14, '2025-11-30 01:46:09', '2025-11-30 01:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int UNSIGNED NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama_mapel`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Calistung', 'Belajar dasar Membaca, Menulis, dan Berhitung untuk usia dini.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(2, 'Matematika', 'Belajar hitungan, aljabar, dan geometri dasar hingga lanjut.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(3, 'Bahasa Inggris', 'Belajar grammar, speaking, dan reading.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(4, 'IPA', 'Ilmu Pengetahuan Alam terpadu (Fisika, Kimia, Biologi dasar).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(5, 'Informatika', 'Mempelajari teknologi komputer, pemrograman, dan data.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(6, 'Biologi', 'Mempelajari makhluk hidup, fungsi kehidupan', '2025-11-27 15:30:41', '2025-11-28 13:02:15'),
(7, 'Fisika', 'Belajar konsep energi, gaya, dan gerak.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(8, 'Kimia', 'Belajar struktur zat dan reaksinya.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(9, 'Sejarah', 'Belajar peristiwa masa lalu dan dampaknya.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(10, 'Geografi', 'Mempelajari fenomena fisik bumi dan kependudukan manusia.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(11, 'Ekonomi', 'Mempelajari pengelolaan sumber daya, pasar, dan keuangan.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(12, 'Sosiologi', 'Mempelajari interaksi sosial, masyarakat, dan budaya.', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(13, 'Tes Potensi Skolastik (TPS)', 'Menguji kemampuan kognitif, penalaran umum, dan pemahaman bacaan (UTBK).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(14, 'Literasi Bahasa Indonesia', 'Menguji kemampuan memahami dan menganalisis teks Bahasa Indonesia (UTBK).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(15, 'Literasi Bahasa Inggris', 'Menguji kemampuan memahami teks Bahasa Inggris (UTBK).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(16, 'Penalaran Matematika', 'Menguji penggunaan konsep matematika dalam masalah nyata (UTBK).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(17, 'Tes Intelegensi Umum (TIU)', 'Menguji kemampuan verbal, numerik, dan logika (Kedinasan).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(18, 'Tes Wawasan Kebangsaan (TWK)', 'Menguji pemahaman Pancasila, UUD 1945, dan Sejarah (Kedinasan).', '2025-11-27 15:30:41', '2025-11-28 19:02:59'),
(19, 'Tes Karakteristik Pribadi (TKP)', 'Menguji perilaku, pelayanan publik, dan jejaring kerja (Kedinasan).', '2025-11-27 15:30:41', '2025-11-28 19:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_24_184349_add_role_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('yuniekanuraini123@gmail.com', '$2y$12$4gZZ4klMop88n933SFVw6.95IjayCgo81zUmZ2k3YqY12cSnctkui', '2025-11-26 06:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int UNSIGNED NOT NULL,
  `siswa_id` int UNSIGNED NOT NULL,
  `kelas_id` int UNSIGNED NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode` enum('cash','transfer','qris') NOT NULL,
  `status` enum('pending','lunas','gagal') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `siswa_id`, `kelas_id`, `jumlah`, `tanggal_bayar`, `metode`, `status`, `created_at`) VALUES
(12, 1, 3, 295000.00, '2025-11-30', 'cash', 'lunas', '2025-11-30 02:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AyWmB95n0PAfmN15AVnnvxR8OiNLonaNOeShIHZv', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQkZiTG9FQUp5YWp5SEJMU2gxaVB3czZuZXFpUmh2YXQ4MGpEY2JIVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly93ZWJsYW5qdXQudGVzdC9kYXNoYm9hcmQtYWRtaW4iO3M6NToicm91dGUiO3M6MTU6ImRhc2hib2FyZC1hZG1pbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764473206),
('zv4csudxJHvR9zFmdhFJKQEMY3E6pcZpOgQOFmhL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQkFCWTViWUl2dWo1cVd4bTNEdWlPdWJRQzZ3cFVubTloSjFzZlR1diI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93ZWJsYW5qdXQudGVzdC9qYWR3YWwiO3M6NToicm91dGUiO3M6MTI6ImphZHdhbC5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764472717);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `kelas` enum('Calistung','TK','SD','SMP','SMA','UTBK','Kedinasan','Mahasiswa') DEFAULT NULL,
  `alamat` text,
  `status` enum('Aktif','Tidak Aktif','Cuti') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `tanggal_lahir`, `no_hp`, `kelas`, `alamat`, `status`, `created_at`) VALUES
(1, 3, '2006-06-26', '081234567890', 'Calistung', 'Surabaya', 'Aktif', '2025-11-25 01:10:25'),
(2, 4, NULL, '081298765432', 'SD', NULL, 'Aktif', '2025-11-25 01:10:25'),
(3, 5, NULL, '082112223334', 'SMP', NULL, 'Aktif', '2025-11-25 01:10:25'),
(4, 6, NULL, '081355577799', 'SMA', NULL, 'Aktif', '2025-11-25 01:10:25'),
(5, 7, NULL, '083811223344', 'UTBK', NULL, 'Aktif', '2025-11-25 01:10:25'),
(6, 8, '2025-11-27', NULL, 'Kedinasan', NULL, 'Aktif', '2025-11-25 09:28:21'),
(7, 9, '2004-09-06', '08213100000', 'Calistung', 'Jakarta', 'Aktif', '2025-11-25 10:00:13'),
(8, 10, '2001-01-01', '08100000000', 'Calistung', 'Nggalek', 'Aktif', '2025-11-25 21:41:10'),
(9, 11, '2025-11-28', '083', 'SMP', 'surabaya', 'Aktif', '2025-11-25 21:41:56'),
(10, 12, '2025-11-28', '082131000096', 'SMP', 'RT/RW 027/009 Dsn. Sumber Ds. Pojok Kec. Ngantru Kab. Tulungagung', 'Aktif', '2025-11-25 21:42:36'),
(11, 13, '2025-11-28', '082131000096', 'UTBK', 'RT/RW 027/009 Dsn. Sumber Ds. Pojok Kec. Ngantru Kab. Tulungagung', 'Aktif', '2025-11-25 21:43:25'),
(12, 16, '2025-11-12', '082131000096', 'SMA', 'RT/RW 027/009 Dsn. Sumber Ds. Pojok Kec. Ngantru Kab. Tulungagung', 'Aktif', '2025-11-26 06:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `tentor`
--

CREATE TABLE `tentor` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `mata_pelajaran_id` int UNSIGNED DEFAULT NULL,
  `pendidikan_terakhir` varchar(100) DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `no_hp` varchar(20) DEFAULT NULL,
  `status` enum('aktif','tidak aktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tentor`
--

INSERT INTO `tentor` (`id`, `user_id`, `mata_pelajaran_id`, `pendidikan_terakhir`, `alamat`, `no_hp`, `status`, `created_at`) VALUES
(1, 14, 1, 'SMA', 'Jalan Surabaya', '0831239128634', 'tidak aktif', '2025-11-26 03:10:44'),
(2, 15, 2, 'Sarjana', 'Malang', '082131000000000', 'aktif', '2025-11-26 04:45:40'),
(3, 17, 3, NULL, NULL, NULL, 'aktif', '2025-11-26 22:14:48'),
(4, 19, 6, 'SMA', 'Jalan Sumbersari Gang 7b no.18 RT/RW 06?03 Lowokwaru Malang', '082131000096', 'aktif', '2025-11-27 17:47:24'),
(5, 20, 7, NULL, NULL, NULL, 'aktif', '2025-11-27 17:55:52'),
(6, 21, 14, NULL, NULL, NULL, 'aktif', '2025-11-27 17:56:45'),
(7, 22, 3, NULL, NULL, NULL, 'aktif', '2025-11-27 17:57:16'),
(8, 23, 11, NULL, NULL, NULL, 'aktif', '2025-11-27 17:57:45'),
(9, 24, 5, NULL, NULL, NULL, 'aktif', '2025-11-27 17:58:23'),
(10, 25, 17, NULL, NULL, NULL, 'aktif', '2025-11-27 17:58:53'),
(11, 26, 2, NULL, NULL, NULL, 'aktif', '2025-11-27 17:59:21'),
(12, 27, 2, NULL, NULL, NULL, 'aktif', '2025-11-27 18:00:03'),
(13, 28, 18, NULL, NULL, NULL, 'aktif', '2025-11-27 18:00:29'),
(14, 29, 12, NULL, NULL, NULL, 'aktif', '2025-11-27 18:00:57'),
(15, 30, 8, NULL, NULL, NULL, 'aktif', '2025-11-27 18:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yuni Eka Nuraini', 'yuni@gmail.com', 'admin', NULL, '$2y$12$H.651y9J8Rt6iWHjk6VaKeUH1chOYg/YsS.GK9uB/075YK2w167tK', 'Q1n8xjSlazvzS4yqLvAmwj6GorDcXpK5n3YK5TqwEX2yyICQvvboVLqJEXEv', '2025-11-24 05:16:37', '2025-11-24 05:16:37'),
(3, 'Nadila Putri Paningrum', 'nadnad@gmail.com', 'siswa', NULL, '$2y$12$Ni/jeGFhivl7HR0H.rk6auhPTPK.G.WMW.aJHY86ICI0vYbJHDBgm', 'uGT1PuKMiFzfqSurdMgSMJaDalJ3KA9OE1mQRNEWUqAU5vd2i6QCoIeRNNnt', '2025-11-24 05:32:09', '2025-11-26 01:52:17'),
(4, 'Andi Pratama', 'andi@example.com', 'siswa', '2025-11-25 01:09:14', '$2y$12$kZl2NfT4iQup8znkJp8eUeZsznOJv4aX4HcPVpCY1BxE9U3dS8J7u', NULL, '2025-11-25 01:09:14', '2025-11-25 01:09:14'),
(5, 'Budi Santoso', 'budi@example.com', 'siswa', '2025-11-25 01:09:14', '$2y$12$kZl2NfT4iQup8znkJp8eUeZsznOJv4aX4HcPVpCY1BxE9U3dS8J7u', NULL, '2025-11-25 01:09:14', '2025-11-25 01:09:14'),
(6, 'Citra Ayu', 'citra@example.com', 'siswa', '2025-11-25 01:09:14', '$2y$12$kZl2NfT4iQup8znkJp8eUeZsznOJv4aX4HcPVpCY1BxE9U3dS8J7u', NULL, '2025-11-25 01:09:14', '2025-11-25 01:09:14'),
(7, 'Dewi Lestari', 'dewi@example.com', 'siswa', '2025-11-25 01:09:14', '$2y$12$kZl2NfT4iQup8znkJp8eUeZsznOJv4aX4HcPVpCY1BxE9U3dS8J7u', NULL, '2025-11-25 01:09:14', '2025-11-25 01:09:14'),
(8, 'siswa2', 'siswa@gmail.com', 'siswa', NULL, '$2y$12$ULFX746rLmy1onjM.Qi86uhfEg4zapxJgQQs4u70vDrdvEphxYDrC', NULL, '2025-11-25 02:28:21', '2025-11-25 02:28:21'),
(9, 'Amelia Putri', 'amelia@gmail.com', 'siswa', NULL, '$2y$12$XX8NSq1zFTTYgsT9i5Mru.WEH2HtmVcY53fsbze56ni5QES2H.wtS', 'NScu5bh9xf1ScNEPK2fwY8Hd7Pj8BYidBUy40AbHYZ7ahQ9491PSj7aDwfvQ', '2025-11-25 03:00:13', '2025-11-27 11:36:16'),
(10, 'agatha', 'agatha@gmail.com', 'siswa', NULL, '$2y$12$yFG6JE1oqpY5UdiDomhomeSBp/kZQW4Kk5LSPz7WXVwptIOo07cf6', NULL, '2025-11-25 14:41:10', '2025-11-25 14:41:10'),
(11, 'diandra', 'diandra@gmail.com', 'siswa', NULL, '$2y$12$u7sANJQ0vyPk8xrMAoUzZ.jc6KyXUd/l31jv.xdMplFtiopNBMoEu', NULL, '2025-11-25 14:41:56', '2025-11-25 14:41:56'),
(12, 'ramadana', 'ramadana@gmail.com', 'siswa', NULL, '$2y$12$HVGb2WvbFeGu4ijDbVe8zupSZGgaSRpb3pQXSMGGPj0HpBt9s1PbG', NULL, '2025-11-25 14:42:36', '2025-11-25 14:42:36'),
(13, 'cacamaricha', 'cama@gmail.com', 'siswa', NULL, '$2y$12$GSFOOIewI85YQYPicgzTyOcSUqhGLV5XUx535Qc58LLx.HMQD7RoO', NULL, '2025-11-25 14:43:24', '2025-11-25 14:43:24'),
(14, 'Larasati', 'larasati@gmail.com', 'tentor', NULL, '$2y$12$dPvu6b/FNroP8wPw69kKPeN99g9BveD2zfeUYC7fdXJnEUe6C7QKO', NULL, '2025-11-25 20:10:44', '2025-11-25 20:10:44'),
(15, 'Yahya', 'yahya@gmail.com', 'tentor', NULL, '$2y$12$q.fzavFFLPZdrCKDiTI11u5d5IJQfFw89pzzoGXpfGqBq/F5pZHLy', 'crvHreDrcnK6qaYPQEE1Zp1sA2HnGh1ohpNPiEVKSoSNUzhUbf2otvqxNcv6', '2025-11-25 21:45:40', '2025-11-25 21:45:40'),
(16, 'Aida', 'yuniekanuraini123@gmail.com', 'siswa', NULL, '$2y$12$cBWQ8rIYv91r3aq73m3XZeVI6V15znWW96jtS9ryFhGBaqINYKFXm', NULL, '2025-11-25 23:26:43', '2025-11-25 23:26:43'),
(17, 'Budi Santoso', 'budi@gmail.com', 'tentor', NULL, '$2y$12$YnD.CJ6hpIsv9rocTi5lwew.8IMRkqmBfkvWQkQx4BKgei6AzXoHe', NULL, '2025-11-26 15:14:48', '2025-11-26 15:14:48'),
(19, 'Fahma', 'fahma@gmail.com', 'tentor', NULL, '$2y$12$ecPAlCuSczUmEnBzTwlRe.eJEjQU9z7d6nPuKSscs9z5zZjkjVoga', NULL, '2025-11-27 10:47:24', '2025-11-27 10:47:24'),
(20, 'Adit Pratama', 'adit@gmail.com', 'tentor', NULL, '$2y$12$RePv.uU/ADmnNuD1PBf59.mjwTULG5n0857JFBiRJs4O77v4gZbOS', NULL, '2025-11-27 10:55:52', '2025-11-27 10:55:52'),
(21, 'Budi Pratama', 'budip@gmail.com', 'tentor', NULL, '$2y$12$JzPxXu5DPJGqnK6GKNRJF.q9gVMdSNfQKhJSLWGVpAAqtWCxJXpDa', NULL, '2025-11-27 10:56:45', '2025-11-27 10:56:45'),
(22, 'Citra Lestari', 'citra@gmail.com', 'tentor', NULL, '$2y$12$xS.xP1STKEc6HAjUz4U6UOkr9UVVO3u7/kADBzxsCRXnjnObCL.qC', NULL, '2025-11-27 10:57:16', '2025-11-27 10:57:16'),
(23, 'Dimas Ardiyansyah', 'dimas@gmail.com', 'tentor', NULL, '$2y$12$BZBpj3ZYNJS6nyY2ONx81OGMGDXvIo3y7bKp8nxqrLgrnD1qzoPZ6', NULL, '2025-11-27 10:57:45', '2025-11-27 10:57:45'),
(24, 'Eka Rahmawati', 'eka@gmail.com', 'tentor', NULL, '$2y$12$QQXPgRN7mc6RLQYGEi6kdOoeAxb.8XV3o0MpUxMQx65OZge2nchlK', NULL, '2025-11-27 10:58:23', '2025-11-27 10:58:23'),
(25, 'Farhan Nugraha', 'farhan@gmail.com', 'tentor', NULL, '$2y$12$V7GHpXa4Gq4N.JquhwBjj..niSCX/yrRGZgWvN588E0.UuktM5Brq', NULL, '2025-11-27 10:58:53', '2025-11-27 10:58:53'),
(26, 'Gita Sari', 'gita@gmail.com', 'tentor', NULL, '$2y$12$29NpvlYAYFDt0rqXQMd3BOaB8VjII/DkwhjcINO8FrbJNANW7RfXO', NULL, '2025-11-27 10:59:21', '2025-11-27 10:59:21'),
(27, 'Yola Febriani', 'yola@gmail.com', 'tentor', NULL, '$2y$12$RB5v39B.ut5kdoKnGYhhkukWKBDi1DeAqxDsCClHz3J8y2rOjmBHu', NULL, '2025-11-27 11:00:03', '2025-11-27 11:00:03'),
(28, 'Wahyu Hidayah', 'wahyu@gmail.com', 'tentor', NULL, '$2y$12$hMxg1JmfTR/iVLv2UHSXZOlrvTe7Its3t4tauGzxUyKuariaYgsPS', NULL, '2025-11-27 11:00:29', '2025-11-27 11:00:29'),
(29, 'Vira Anggraini', 'vira@gmail.com', 'tentor', NULL, '$2y$12$pM.y9NSsO2jX7tcPrvRYlOSwl3CLY1hLjMojVp64yvvkBPVNhfyJe', NULL, '2025-11-27 11:00:57', '2025-11-27 11:00:57'),
(30, 'Utari Ningsih', 'utari@gmail.com', 'tentor', NULL, '$2y$12$psFMr3GcadVP/gMWX6VBk.2fwxZ5FEn5GOAS.kPNKW5v1SeSimFnm', NULL, '2025-11-27 11:01:24', '2025-11-27 11:01:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `jadwal_kelas_id` (`jadwal_kelas_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `mata_pelajaran_id` (`mata_pelajaran_id`),
  ADD KEY `tentor_id` (`tentor_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mata_pelajaran_id` (`mata_pelajaran_id`),
  ADD KEY `fk_tentor` (`tentor_id`);

--
-- Indexes for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_kelas` (`jadwal_id`),
  ADD KEY `fk_jadwal_siswa` (`siswa_id`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tentor`
--
ALTER TABLE `tentor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_mata_pelajaran_id` (`mata_pelajaran_id`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tentor`
--
ALTER TABLE `tentor`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`jadwal_kelas_id`) REFERENCES `jadwal_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD CONSTRAINT `jadwal_kelas_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_kelas_ibfk_2` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_kelas_ibfk_3` FOREIGN KEY (`tentor_id`) REFERENCES `tentor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `fk_tentor` FOREIGN KEY (`tentor_id`) REFERENCES `tentor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas_siswa`
--
ALTER TABLE `kelas_siswa`
  ADD CONSTRAINT `fk_jadwal_kelas` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_kelas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_jadwal_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tentor`
--
ALTER TABLE `tentor`
  ADD CONSTRAINT `fk_mata_pelajaran_id` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tentor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
