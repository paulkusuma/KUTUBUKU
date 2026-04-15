-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2026 at 06:57 AM
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
-- Database: `kutubuku_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `description`, `price`, `stock`, `author`, `created_at`, `updated_at`) VALUES
(1, 'Laskar Pelangi', 'Novel tentang perjuangan dan kehidupan anak-anak di Belitung.', '84989.00', 21, 'Andrea Hirata', NULL, NULL),
(3, 'Atomic Habits', 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.', '95000.00', 25, 'James Clear', NULL, NULL),
(4, 'Clean Code', 'Buku wajib untuk programmer tentang cara menulis kode yang bersih dan mudah dipelihara.', '120000.00', 10, 'Robert C. Martin', NULL, NULL),
(5, 'Belajar Jaringan Komputer', 'Buku dasar tentang konsep jaringan, OSI Layer, dan TCP/IP', '125000.00', 50, 'Andrew S. Tanenbaum', NULL, NULL),
(6, 'Dasar-Dasar Pemrograman', 'Panduan pemrograman untuk pemula menggunakan Python', '95000.00', 40, 'Budi Raharjo', NULL, NULL),
(8, 'Keamanan Jaringan', 'Konsep dan implementasi keamanan pada jaringan komputer', '120000.00', 0, 'William Stallings', NULL, NULL),
(9, 'Database Management System', 'Teori dan praktik manajemen basis data', '140000.00', 30, 'Ramez Elmasri', NULL, NULL),
(11, 'LAIce', 'La', '600000.00', 90, 'Paulllll', NULL, NULL);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_14_182753_create_books_table', 1),
(6, '2026_01_14_185144_add_role_to_users_table', 1),
(7, '2026_01_15_063555_add_credit_card_to_users_table', 2),
(8, '2026_01_20_063314_make_credit_card_fields_nullable_in_users_table', 3);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `card_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_expiry` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_cvv` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_holder_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `card_number`, `card_expiry`, `card_cvv`, `card_holder_name`) VALUES
(1, 'Admin KUTUBUKU', 'admin@kutubuku.test', 'admin', '2026-01-14 12:11:08', '$2y$10$ZVYSaWus61xdlkHn9oUkQus5lSKykRKxHH/P.s7Ssh1Cn4KLLSNea', 'c5QYJKpDqCj2F7oEJp7ifvKl0Bk11G5sIwDeN2mW5hizeqIu75XxrjPP5aNI', '2026-01-14 12:11:08', '2026-01-14 12:11:08', '', '', '', ''),
(2, 'usera', 'usera@kutubuku.test', 'user', NULL, '$2y$12$ZM63BVa00ErDhWdTCOAvJewRWRou.Ik82.x2DBeshVsCVy9FkmT6W', NULL, '2026-01-14 12:45:22', '2026-01-21 00:46:10', '243546576213245', '44/34', '445', 'USERa'),
(3, 'userB', 'userb@kutubuku.test', 'user', NULL, '$2y$12$Il4N5Iaf3P7B0Zp.cAPxZ.qpk7vupBXOW1oUjC7ytymr52RN7FOPC', NULL, '2026-01-14 13:00:41', '2026-01-16 10:42:42', '213456', '32/44', '435', 'wertrye444'),
(4, 'userC', 'userc@kutubuku.test', 'user', NULL, '$2y$12$BKu2PAWAQ.lOPJ4gddnLAOXJtS9ThqosJMKVdxmj3nMBg9p9kzCE.', NULL, '2026-01-14 13:05:06', '2026-01-20 00:13:53', '324564764225', '3434', '333', 'qwert'),
(7, 'PAUL', 'paul@paul.test', 'user', NULL, '$2y$10$NZ8P5p48oiSVCR5SJVnlyuMCByNVrpj3o.3hbpvXxEroeCBUb71qK', NULL, '2026-01-21 01:01:14', '2026-01-21 01:01:14', '0', '0', '0', '0'),
(8, 'admin', 'admin2@gmail.com', 'admin', NULL, '$2y$10$sCh2xOOlZIuv.evX2OWKAeybG3P3GzTGxNl60BwO2pkRE94rgYEAy', NULL, NULL, NULL, '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
