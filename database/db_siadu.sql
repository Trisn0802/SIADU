-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2025 at 01:49 AM
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
-- Database: `db_siadu`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` bigint UNSIGNED NOT NULL,
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id_chat`, `id_pengaduan`, `id_user`, `pesan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'OK', '2025-06-27 09:31:02', '2025-06-27 09:31:02'),
(2, 1, 2, 'Pengaduan \"Jalan Trotoar Bolong\" telah diterima dan akan segera diproses oleh petugas.', '2025-06-27 09:32:34', '2025-06-27 09:32:34'),
(3, 1, 2, 'Aduan anda telah selesai ditangani. silahkan cek di menu riwayat tindak lanjut', '2025-06-27 09:33:17', '2025-06-27 09:33:17'),
(4, 1, 1, 'Maaf, aduan anda \"Jalan Trotoar Bolong\" ditolak. Silakan cek riwayat percakapan aduan.', '2025-06-27 09:34:55', '2025-06-27 09:34:55'),
(5, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh petugas.', '2025-06-27 09:48:01', '2025-06-27 09:48:01'),
(6, 1, 1, 'tfest', '2025-06-27 09:53:11', '2025-06-27 09:53:11'),
(7, 1, 1, 'oy', '2025-06-27 09:53:17', '2025-06-27 09:53:17'),
(8, 1, 3, 'OK', '2025-06-27 09:57:22', '2025-06-27 09:57:22'),
(9, 1, 1, 'YA', '2025-06-27 09:57:26', '2025-06-27 09:57:26'),
(10, 1, 3, 'test', '2025-06-27 11:52:00', '2025-06-27 11:52:00'),
(11, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:11:43', '2025-06-27 12:11:43'),
(12, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:12:04', '2025-06-27 12:12:04'),
(13, 1, 1, 'TEST', '2025-06-27 12:12:14', '2025-06-27 12:12:14'),
(14, 1, 1, 'YO NIGGA', '2025-06-27 12:12:25', '2025-06-27 12:12:25'),
(15, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:14:51', '2025-06-27 12:14:51'),
(16, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:15:15', '2025-06-27 12:15:15'),
(17, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:15:30', '2025-06-27 12:15:30'),
(18, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:15:49', '2025-06-27 12:15:49'),
(19, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:16:20', '2025-06-27 12:16:20'),
(20, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:16:54', '2025-06-27 12:16:54'),
(21, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:18:42', '2025-06-27 12:18:42'),
(22, 1, 1, 'APA COBA !!!', '2025-06-27 12:18:57', '2025-06-27 12:18:57'),
(23, 1, 1, 'Aduan anda \"Jalan Trotoar Bolong\" telah selesai ditangani. Terima kasih, silahkan cek di menu riwayat tindak lanjut.', '2025-06-27 12:19:09', '2025-06-27 12:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_user_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_19_184010_create_passwd_debug', 1),
(6, '2025_06_14_152537_pengaduan_table', 1),
(7, '2025_06_14_152628_tindaklanjut_table', 1),
(8, '2025_06_18_062719_chat_table', 1),
(9, '2025_06_22_075955_notifikasi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint UNSIGNED NOT NULL,
  `id_pengaduan` bigint UNSIGNED DEFAULT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_pengaduan`, `id_user`, `type`, `title`, `pesan`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-06-27 09:23:02', '2025-06-27 09:23:32'),
(2, NULL, 1, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/admin/pengaduan/1/detail', 1, '2025-06-27 09:23:02', '2025-06-27 09:34:04'),
(10, 1, 3, 'chat', 'Pesan Baru dari Admin', 'Anda menerima pesan baru dari admin pada pengaduan: \"Jalan Trotoar Bolong\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 1, '2025-06-27 09:57:26', '2025-06-27 10:32:19'),
(11, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/2/detail', 0, '2025-06-27 12:11:43', '2025-06-27 12:11:43'),
(12, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/3/detail', 0, '2025-06-27 12:12:04', '2025-06-27 12:12:04'),
(13, 1, 3, 'chat', 'Pesan Baru dari Admin', 'Anda menerima pesan baru dari admin pada pengaduan: \"Jalan Trotoar Bolong\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 0, '2025-06-27 12:12:14', '2025-06-27 12:12:14'),
(14, 1, 3, 'chat', 'Pesan Baru dari Admin', 'Anda menerima pesan baru dari admin pada pengaduan: \"Jalan Trotoar Bolong\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 0, '2025-06-27 12:12:25', '2025-06-27 12:12:25'),
(15, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/4/detail', 0, '2025-06-27 12:14:52', '2025-06-27 12:14:52'),
(16, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/5/detail', 0, '2025-06-27 12:15:15', '2025-06-27 12:15:15'),
(17, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/6/detail', 0, '2025-06-27 12:15:30', '2025-06-27 12:15:30'),
(18, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/7/detail', 0, '2025-06-27 12:15:49', '2025-06-27 12:15:49'),
(19, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/8/detail', 0, '2025-06-27 12:16:20', '2025-06-27 12:16:20'),
(20, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/9/detail', 0, '2025-06-27 12:16:55', '2025-06-27 12:16:55'),
(21, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/10/detail', 0, '2025-06-27 12:18:42', '2025-06-27 12:18:42'),
(22, 1, 3, 'chat', 'Pesan Baru dari Admin', 'Anda menerima pesan baru dari admin pada pengaduan: \"Jalan Trotoar Bolong\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 0, '2025-06-27 12:18:57', '2025-06-27 12:18:57'),
(23, 1, 3, 'tindaklanjut', 'Tindak Lanjut Baru', 'Pengaduan \"Jalan Trotoar Bolong\" Anda telah ditindak lanjuti. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/tindaklanjut/11/detail', 0, '2025-06-27 12:19:09', '2025-06-27 12:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `passwd_debug`
--

CREATE TABLE `passwd_debug` (
  `id_passwd` bigint UNSIGNED NOT NULL,
  `passDebug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passwd_debug`
--

INSERT INTO `passwd_debug` (`id_passwd`, `passDebug`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-06-27 07:07:18', '2025-06-27 07:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lapor` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('belum ditangani','diterima','diproses','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum ditangani',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `id_user`, `judul`, `deskripsi`, `kategori`, `foto`, `lokasi`, `tanggal_lapor`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Jalan Trotoar Bolong', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus, nisi obcaecati? Error maiores voluptatem sed quaerat itaque voluptates. Laborum iste error exercitationem molestias quasi sunt quae nesciunt nobis veniam perferendis?', 'Lain-lain', '20250627162301_685e62f5d3c09.jpeg', 'TEST', '2025-06-27 16:23:01', 'selesai', '2025-06-27 09:23:01', '2025-06-27 12:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tindaklanjut`
--

CREATE TABLE `tindaklanjut` (
  `id_tindak` bigint UNSIGNED NOT NULL,
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `tanggal_tindak` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status_akhir` enum('diproses','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diproses',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tindaklanjut`
--

INSERT INTO `tindaklanjut` (`id_tindak`, `id_pengaduan`, `id_user`, `tanggal_tindak`, `catatan`, `status_akhir`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-06-27 16:32:00', 'OKE SUDAH SELESAI!!!', 'selesai', '20250627163317_685e655df0554.jpg', '2025-06-27 09:33:18', '2025-06-27 09:33:18'),
(2, 1, 1, '2025-06-27 19:10:00', 'TEST', 'diproses', NULL, '2025-06-27 12:11:43', '2025-06-27 12:11:43'),
(3, 1, 1, '2025-06-27 19:11:00', 'TEST', 'diproses', NULL, '2025-06-27 12:12:04', '2025-06-27 12:12:04'),
(4, 1, 1, '2025-06-27 19:14:00', 'COGG', 'diproses', NULL, '2025-06-27 12:14:52', '2025-06-27 12:14:52'),
(5, 1, 1, '2025-06-27 19:15:00', 'TATA', 'diproses', NULL, '2025-06-27 12:15:15', '2025-06-27 12:15:15'),
(6, 1, 1, '2025-06-27 19:15:00', 'COG', 'diproses', NULL, '2025-06-27 12:15:30', '2025-06-27 12:15:30'),
(7, 1, 1, '2025-06-27 19:15:00', 'HELL NAAAHHH!!!!', 'diproses', NULL, '2025-06-27 12:15:49', '2025-06-27 12:15:49'),
(8, 1, 1, '2025-06-27 19:16:00', 'TEST', 'diproses', NULL, '2025-06-27 12:16:20', '2025-06-27 12:16:20'),
(9, 1, 1, '2025-06-27 19:16:00', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum dolor, voluptatibus delectus ducimus enim repellendus minus molestias nulla natus facilis temporibus accusamus fugiat iusto ratione voluptates fuga? Modi, qui in!', 'diproses', NULL, '2025-06-27 12:16:55', '2025-06-27 12:16:55'),
(10, 1, 1, '2025-06-27 19:18:00', 'OYYY', 'diproses', NULL, '2025-06-27 12:18:42', '2025-06-27 12:18:42'),
(11, 1, 1, '2025-06-27 19:19:00', 'YEA YEAH', 'selesai', '20250627191909_685e8c3da1203.jpg', '2025-06-27 12:19:09', '2025-06-27 12:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `nik`, `email`, `instansi`, `role`, `status`, `password`, `no_hp`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, 'admin@gmail.com', 'Kementrian Keamanan', '1', 1, '$2y$12$89v6nuIEsZen4qrIp8rqB.DT5tTYVt.uzZQ3MxcgjjoR7shcJvsp6', '08123456789', 'admin.jpg', NULL, '2025-06-27 07:07:18', '2025-06-27 07:07:18'),
(2, 'Vestia Zeta', NULL, 'zeta@gmail.com', 'Hololive Corporation', '2', 1, '$2y$12$rin2lKmmRRuwqINBNkxsO.Pdf8Zy70EWZ9sB9ckVNXTvQ0gJEYi9e', '08123456710', 'petugas.jpg', NULL, '2025-06-27 07:07:19', '2025-06-27 07:07:19'),
(3, 'Trisna Almuti', '1234567890123456', 'trisnahomie@gmail.com', NULL, '0', 1, '$2y$12$Wv4D0Jo8l.tfwSfO5Ml8weccjM6Gzs9jdpL67uwXYehouEQYC/mES', '0895711856677', '', NULL, '2025-06-27 07:07:19', '2025-06-27 07:07:19'),
(4, 'Fathur Rahman', '1234567890123456', 'fathur@gmail.com', NULL, '0', 1, '$2y$12$kSpmH5El7lDQ/btapD1oM.u5ushr7eJkH36XiHpRZBHvfUNvBEFLG', '089575567890', '', NULL, '2025-06-27 07:07:19', '2025-06-27 07:07:19'),
(5, 'Zainal Abidin', '1234567890123456', 'zainal@gmail.com', NULL, '0', 0, '$2y$12$pQ5l5.hZXD8gygYun9bs4.iHTiiuQub2oU25a2BRMI5lFfFyE0yqy', '089575567890', '', NULL, '2025-06-27 07:07:19', '2025-06-27 07:07:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `chat_id_pengaduan_foreign` (`id_pengaduan`),
  ADD KEY `chat_id_user_foreign` (`id_user`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_pengaduan_foreign` (`id_pengaduan`),
  ADD KEY `notifikasi_id_user_foreign` (`id_user`);

--
-- Indexes for table `passwd_debug`
--
ALTER TABLE `passwd_debug`
  ADD PRIMARY KEY (`id_passwd`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `pengaduan_id_user_foreign` (`id_user`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tindaklanjut`
--
ALTER TABLE `tindaklanjut`
  ADD PRIMARY KEY (`id_tindak`),
  ADD KEY `tindaklanjut_id_pengaduan_foreign` (`id_pengaduan`),
  ADD KEY `tindaklanjut_id_user_foreign` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `passwd_debug`
--
ALTER TABLE `passwd_debug`
  MODIFY `id_passwd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tindaklanjut`
--
ALTER TABLE `tindaklanjut`
  MODIFY `id_tindak` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tindaklanjut`
--
ALTER TABLE `tindaklanjut`
  ADD CONSTRAINT `tindaklanjut_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tindaklanjut_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
