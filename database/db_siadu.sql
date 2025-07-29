-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2025 at 08:42 AM
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
(1, 1, 2, 'oke', '2025-07-29 03:50:18', '2025-07-29 03:50:18'),
(2, 1, 2, 'Pengaduan \"Jalanan Trotoar Rusak\" telah diterima dan akan segera diproses oleh petugas.', '2025-07-29 03:50:34', '2025-07-29 03:50:34'),
(3, 1, 2, 'di tunggu ya mas', '2025-07-29 03:50:53', '2025-07-29 03:50:53'),
(4, 1, 3, 'oke akan saya tunggu', '2025-07-29 03:51:06', '2025-07-29 03:51:06'),
(5, 1, 3, 'SIAPPP!!!!', '2025-07-29 03:51:19', '2025-07-29 03:51:19'),
(6, 1, 3, 'Okeee', '2025-07-29 03:51:37', '2025-07-29 03:51:37'),
(7, 1, 3, 'mas di tunggu update nya!!', '2025-07-29 03:52:22', '2025-07-29 03:52:22'),
(8, 1, 3, 'HEHEHEHE', '2025-07-29 03:57:15', '2025-07-29 03:57:15'),
(9, 1, 2, 'APA CIK WOILA gk sabar banget loh ya abang ini!! 😠😠😠💢💢💢', '2025-07-29 03:57:50', '2025-07-29 03:57:50'),
(10, 1, 3, 'IYA iya weh aku dah sabar ni', '2025-07-29 03:58:12', '2025-07-29 03:58:12');

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
(9, '2025_06_22_075955_notifikasi_table', 1),
(10, '2025_07_29_103937_create_pengaduan_petugas_table', 1),
(11, '2025_07_29_104050_add_assigned_petugas_to_pengaduan_table', 1),
(12, '2025_07_29_143213_create_user_otps_table', 2),
(13, '2025_07_29_143605_add_otp_verified_to_user_table', 3);

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
(1, NULL, 2, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:50:02', '2025-07-29 03:50:12'),
(2, NULL, 1, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/admin/pengaduan/1/detail', 1, '2025-07-29 03:50:02', '2025-07-29 03:51:32'),
(3, 1, 3, 'chat', 'Pesan Baru dari Petugas', 'Anda menerima pesan baru dari petugas di Pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 1, '2025-07-29 03:50:19', '2025-07-29 03:50:25'),
(4, 1, 3, 'status', 'Pengaduan Diterima', 'Pengaduan \"Jalanan Trotoar Rusak\" Anda telah diterima oleh petugas. Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 1, '2025-07-29 03:50:34', '2025-07-29 03:50:44'),
(5, 1, 3, 'chat', 'Pesan Baru dari Petugas', 'Anda menerima pesan baru dari petugas di Pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 1, '2025-07-29 03:50:54', '2025-07-29 03:57:04'),
(6, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:51:06', '2025-07-29 03:51:10'),
(7, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:51:19', '2025-07-29 03:53:14'),
(8, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:51:37', '2025-07-29 03:53:14'),
(9, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:52:22', '2025-07-29 03:53:14'),
(10, NULL, 2, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/2/detail', 1, '2025-07-29 03:52:57', '2025-07-29 03:53:14'),
(11, NULL, 1, 'pengaduan', 'Pengaduan Baru', 'Ada pengaduan baru dari Trisna Almuti. Silakan cek dan proses.', 'http://127.0.0.1:8000/backend/admin/pengaduan/2/detail', 0, '2025-07-29 03:52:57', '2025-07-29 03:52:57'),
(12, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:57:15', '2025-07-29 03:57:19'),
(13, 1, 3, 'chat', 'Pesan Baru dari Petugas', 'Anda menerima pesan baru dari petugas di Pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/user/aduan/1/detail', 1, '2025-07-29 03:57:50', '2025-07-29 08:21:03'),
(14, 1, 2, 'chat', 'Balasan Baru dari User', 'Ada balasan baru dari Trisna Almuti pada pengaduan \"Jalanan Trotoar Rusak\". Klik untuk melihat detail.', 'http://127.0.0.1:8000/backend/petugas/pengaduan/1/detail', 1, '2025-07-29 03:58:12', '2025-07-29 03:58:29');

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
(1, 'admin', '2025-07-29 03:44:22', '2025-07-29 03:44:22');

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
  `assigned_petugas` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `id_user`, `judul`, `deskripsi`, `kategori`, `foto`, `lokasi`, `tanggal_lapor`, `status`, `assigned_petugas`, `created_at`, `updated_at`) VALUES
(1, 3, 'Jalanan Trotoar Rusak', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Hic nisi dicta, quae consequuntur dolores at. Doloremque quo ab adipisci quidem non ad repudiandae rem autem nihil eum odit, nobis animi corporis quod libero quas cupiditate nesciunt quis ut ex eveniet. Nisi temporibus soluta beatae saepe, fuga autem itaque iure, est exercitationem magnam error doloribus rem recusandae ad quas reprehenderit nobis quod corporis deleniti illo, ipsam eum molestiae reiciendis unde! Quaerat molestias odio repellat cupiditate architecto sint labore eveniet recusandae accusamus totam ipsum, nobis debitis quos ex assumenda. Necessitatibus nobis delectus provident cumque aliquid explicabo quidem dolore nostrum, ut unde eveniet.', 'Infrastruktur', '20250729105001_688844e9b0ff4.jpeg', 'Jl. Kalianyar IV No. 29b', '2025-07-29 10:50:01', 'diterima', 2, '2025-07-29 03:50:01', '2025-07-29 03:50:34'),
(2, 3, 'WALAWEEE', 'MALING PANGSIT !!!!!!!!!!!!!!!!!!!!!', 'Lain-lain', '20250729105257_688845991b4e4.jpg', 'Jl. Kalianyar IV No. 29b', '2025-07-29 10:52:57', 'belum ditangani', NULL, '2025-07-29 03:52:57', '2025-07-29 03:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan_petugas`
--

CREATE TABLE `pengaduan_petugas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `role_petugas` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `status_penanganan` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unassigned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan_petugas`
--

INSERT INTO `pengaduan_petugas` (`id`, `id_pengaduan`, `id_user`, `role_petugas`, `status_penanganan`, `assigned_at`, `unassigned_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'petugas', 'aktif', '2025-07-29 03:50:34', NULL, '2025-07-29 03:50:34', '2025-07-29 03:50:34');

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
  `otp_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `nik`, `email`, `instansi`, `role`, `status`, `password`, `no_hp`, `foto`, `remember_token`, `otp_verified`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, 'admin@gmail.com', 'Kementrian Keamanan', '1', 1, '$2y$12$3.0h6C.kSbyGqT1WQyBRYuKW9nsyxojgePygtPpFlsDVWlEKHDxKa', '08123456789', 'admin.jpg', NULL, 1, '2025-07-29 03:44:22', '2025-07-29 03:44:22'),
(2, 'Vestia Zeta', NULL, 'zeta@gmail.com', 'Hololive Corporation', '2', 1, '$2y$12$bQU5PUFCQ9te0y0aw9TR5uppbL0KZ9q/o7jIgwlxhAKzC/MhZwiM2', '08123456710', 'petugas.jpg', NULL, 1, '2025-07-29 03:44:22', '2025-07-29 03:44:22'),
(3, 'Trisna Almuti', '1234567890123456', 'trisnahomie@gmail.com', NULL, '0', 1, '$2y$12$6YN7GwUYA4TFoIzpJPCh0uoS6R0gQTDxWnSUQ6/Y4FPYw3rdolXGO', '0895711856677', '', NULL, 1, '2025-07-29 03:44:23', '2025-07-29 08:12:23'),
(4, 'Fathur Rahman', '1234567890123456', 'fathur@gmail.com', NULL, '0', 1, '$2y$12$LCfAQKb7AsXUrQTyfkbKT.z9wyXnm1y8jl.4wQZDMVPLe82amZM1i', '089575567890', '', NULL, 0, '2025-07-29 03:44:23', '2025-07-29 03:44:23'),
(5, 'Zainal Abidin', '1234567890123456', 'zainal@gmail.com', NULL, '0', 0, '$2y$12$s6nOAAdzSeP6bhBvBkUVquxifUY.hkCoZwrZqy1rE67WhxSileCLa', '089575567890', '', NULL, 0, '2025-07-29 03:44:23', '2025-07-29 03:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `otp_code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('login','forgot') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_otps`
--

INSERT INTO `user_otps` (`id`, `id_user`, `otp_code`, `type`, `is_verified`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 3, '347578', 'login', 0, '2025-07-29 07:43:33', '2025-07-29 07:38:33', '2025-07-29 07:38:33'),
(2, 3, '347310', 'login', 1, '2025-07-29 08:16:43', '2025-07-29 08:11:43', '2025-07-29 08:12:23'),
(3, 1, '969519', 'login', 0, '2025-07-29 08:17:54', '2025-07-29 08:12:54', '2025-07-29 08:12:54');

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
  ADD KEY `pengaduan_id_user_foreign` (`id_user`),
  ADD KEY `pengaduan_assigned_petugas_foreign` (`assigned_petugas`);

--
-- Indexes for table `pengaduan_petugas`
--
ALTER TABLE `pengaduan_petugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaduan_petugas_id_pengaduan_id_user_unique` (`id_pengaduan`,`id_user`),
  ADD KEY `pengaduan_petugas_id_user_foreign` (`id_user`);

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
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_otps_id_user_type_is_verified_index` (`id_user`,`type`,`is_verified`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `passwd_debug`
--
ALTER TABLE `passwd_debug`
  MODIFY `id_passwd` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaduan_petugas`
--
ALTER TABLE `pengaduan_petugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tindaklanjut`
--
ALTER TABLE `tindaklanjut`
  MODIFY `id_tindak` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `pengaduan_assigned_petugas_foreign` FOREIGN KEY (`assigned_petugas`) REFERENCES `user` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengaduan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan_petugas`
--
ALTER TABLE `pengaduan_petugas`
  ADD CONSTRAINT `pengaduan_petugas_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengaduan_petugas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tindaklanjut`
--
ALTER TABLE `tindaklanjut`
  ADD CONSTRAINT `tindaklanjut_id_pengaduan_foreign` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tindaklanjut_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD CONSTRAINT `user_otps_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
