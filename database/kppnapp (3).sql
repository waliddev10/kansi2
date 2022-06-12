-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 03:38 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kppnapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

CREATE TABLE `agendas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workunit_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_agenda_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `title`, `slug`, `description`, `user_id`, `start`, `end`, `link`, `workunit_id`, `attachment`, `status_agenda_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Seminar Bersama Siwanda', '1617770341-seminar-bersama-siwanda', 'Dalam kegiatan ini, semuanya harus merasa bahagia tanpa terkecuali. Karena sebagai manusia kita harus berusaha semaksimal mungkin dan hanya ada beberapa orang yang tidak bisa hadir.', 3, '2021-03-01 23:00:00', '2021-03-02 00:00:00', NULL, '1,2', 'https://google.com', 2, '2021-03-15 10:00:00', '2021-04-07 04:39:01', NULL),
(2, 'Pelatihan Pengadministrasian Siwanda', '1618994558-pelatihan-pengadministrasian-siwanda', 'Moderator yang akan hadir adalah umum dan maka atas berkat rahmat Allah yang maha kuasa dan dengan didorongkan oleh keinginan luhur supaya berkehidupan kebangsaan yang bebas maka rakyat indonesia menyatakan dengan ini kemerdekaannya.', 2, '2021-04-01 16:00:00', '2021-04-01 20:00:00', 'https://google.com', '1,4', 'https://google.com', 1, '2021-03-15 10:00:00', '2021-04-21 08:42:38', NULL),
(3, 'Sosialisasi Aplikasi Perbendaharaan', '1618994469-sosialisasi-aplikasi-perbendaharaan', 'Luana adalah moderator dalam kegiatan ini. Siapapun yang bertemu dengan Luana maka ia akan segera jatuh cinta.', 2, '2021-05-11 18:00:00', '2021-05-12 00:00:00', 'https://zoom.us/meet/95785580?roomID=r7xiez7rihcirx7rghry&passcode=565567', '1', 'https://drive.google.com/file/heienkshdjenskdihrkensn', 1, '2021-03-15 10:00:00', '2021-04-21 08:41:09', NULL),
(4, 'Diklat Ajar Perbendaharaan', '1617763798-diklat-ajar-perbendaharaan', 'Praktek Pengelolaan Keuangan Negara bersama dengan pembimbing tercinta di sana. Kami bersama dengan para insinyur membuat kapal luar angkasa seperti yang dilakukan oleh kalau tidak salah Elon Musk.', 2, '2021-04-09 00:00:00', '2021-04-09 05:00:00', NULL, '1', NULL, 1, '2021-03-15 10:00:00', '2021-04-07 02:49:58', NULL),
(5, 'Diklat Kita Semua', '1619010678-diklat-kita-semua', 'Ini adalah testing untuk kegiatan diklat kita. Maka dari itu penjajahan di atas dunia harus dihapuskan karena tidak sesuai dengan peri kemanusiaan dan peri keadilan.', 2, '2021-04-02 10:00:00', '2021-04-02 12:00:00', NULL, '1,2', NULL, 2, '2021-03-15 10:00:00', '2021-04-21 13:11:18', NULL),
(13, 'Makan Bersama Keluarga', '1617774247-makan-bersama-keluarga', 'Makan bersama', 3, '2021-04-08 18:00:00', '2021-04-08 19:00:00', 'Coba', NULL, 'Coba', 1, '2021-04-07 05:44:07', '2021-04-07 05:44:07', NULL),
(14, 'Komedoumenoi', '1618994995-komedoumenoi', 'Panji Pragiwaksono', 2, '2021-04-22 15:47:59', '2021-04-23 18:00:00', 'https://tersinggungolehpandji.com', '8,1,2,10', 'https://drive.google.com', 1, '2021-04-21 08:49:55', '2021-04-21 08:49:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `content`, `question_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'pengujian terhadap surat perintah pembayaran, berdasarkan peraturan perundang-undangan;', 1, 2, '2021-04-23 17:00:00', '2021-04-23 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `position`, `handphone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Moh. Walid Arkham Sani', 'Kepala Seksi', '085157626557', '2021-04-05 21:00:00', '2021-04-24 01:10:01', NULL),
(2, 'Diah Karunia Meilia Putri', 'Kepala Badan', '085157626000', '2021-04-05 21:00:00', '2021-04-24 01:09:51', NULL),
(3, 'Ayu Kusuma Widyastuti', 'Kepala Badan', '083123812300', '2021-04-08 14:37:51', '2021-04-24 01:10:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_000000_create_positions_table', 1),
(2, '2014_10_11_000000_create_workunits_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2021_03_30_000000_create_status_agendas_table', 2),
(12, '2021_03_30_140502_create_agendas_table', 2),
(14, '2021_04_06_201941_create_contacts_table', 3),
(15, '2021_04_09_033640_create_presents_table', 4),
(16, '2021_04_22_063415_create_notifications_table', 5),
(17, '2021_04_22_075933_create_read_notifications_table', 6),
(18, '2021_04_24_095128_create_questions_table', 7),
(20, '2021_04_24_190547_create_answers_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `slug`, `description`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Selamat Datang di Siwanda Kapur KPPN Purwodadi!', 'selamat-datang-di-siwanda-kapur-kppn-purwodadi', 'Siwanda Kapur adalah sebuah website dari KPPN Purwodadi untuk memudahkan agenda bersama seluruh satuan kerja yang ada di wilayah kerja KPPN Purwodadi.', 2, '2021-04-22 13:00:00', '2021-04-22 13:00:00', NULL),
(2, 'Update Aplikasi Siwanda Kapur v2.0', '1619123348-update-aplikasi-siwanda-kapur-v20', 'Update ini berisikan notifikasi bagi seluruh peserta dan perbaikan bugs yang ada.', 2, '2021-04-22 14:00:00', '2021-04-22 20:29:08', NULL),
(3, 'Cek Notifikasi', '1619123372-cek-notifikasi', 'Cek Notifikasi', 2, '2021-04-22 20:29:32', '2021-04-22 20:36:17', '2021-04-22 20:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kepala Kantor', '2021-03-21 22:43:34', '2021-04-04 12:46:25', NULL),
(2, 'Kepala Seksi', '2021-03-21 22:43:34', '2021-04-04 11:14:36', NULL),
(3, 'Pelaksana', '2021-03-21 22:43:34', '2021-04-04 10:56:49', NULL),
(66, 'Kepala Bagian', '2021-04-04 11:12:00', '2021-04-04 11:13:02', '2021-04-04 11:13:02'),
(67, 'Sekretaris', '2021-04-04 11:33:13', '2021-04-05 15:33:47', '2021-04-05 15:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `presents`
--

CREATE TABLE `presents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presents`
--

INSERT INTO `presents` (`id`, `user_id`, `agenda_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 13, '2021-04-08 17:00:00', '2021-04-08 17:00:00', NULL),
(2, 4, 13, '2021-04-08 17:00:00', '2021-04-08 17:00:00', NULL),
(6, 2, 2, '2021-04-08 21:57:43', '2021-04-08 21:57:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `slug`, `content`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Apakah tugas dan fungsi dari KPPN?', 'apa-yang-membuat-kita-berhasil', 'KPPN adalah kuasa bendahara umum negara untuk menyalurkan dana dari kas negara ke beberapa satuan kerja di bawah kemeterian/lembaga lain ataupun di bawah kemeterian keuangan sendiri. Dalam rangka melaksanakan tugas pokok tersebut, KPPN menyelenggarakan fungsi apa saja?', 2, '2021-04-23 17:00:00', '2021-04-23 17:00:00', NULL),
(2, 'Arti Logo Ditjen Perbendaharaan?', 'mengapa-hal-tersebut-bisa-terjadi', 'Truth or Dare atau biasa disingkat ToD sering banget deh jadi permainan pas obrolan mulai garing atau gabut aja pas lagi kumpul. Entah jadi ajang saling menjahili atau malah menumpahkan ember-ember kejujuran, game ini asyik dan simpel banget karena nggak butuh peralatan apapun. Cukup modal pertanyaan yang kena sasaran sama ide tantangan unik aja, jadi deh!', 4, '2021-04-23 17:00:00', '2021-04-23 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `read_notifications`
--

CREATE TABLE `read_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `read_notifications`
--

INSERT INTO `read_notifications` (`id`, `user_id`, `notification_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 2, 2, '2021-04-22 02:36:16', '2021-04-24 12:38:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_agendas`
--

CREATE TABLE `status_agendas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_agendas`
--

INSERT INTO `status_agendas` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Wajib', '2021-03-15 17:00:00', '2021-03-15 17:00:00', NULL),
(2, 'Opsional', '2021-03-15 17:00:00', '2021-04-06 16:28:09', NULL),
(3, 'Opsionality', '2021-04-06 13:52:27', '2021-04-06 13:55:38', '2021-04-06 13:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','moderator','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `workunit_id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `username`, `email`, `email_verified_at`, `password`, `handphone`, `role`, `workunit_id`, `position_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'MOH. WALID ARKHAM SANI', '123456789123456789', 'admin', 'mohwalidas2@gmail.com', '2021-03-22 00:09:42', '$2y$10$mS/vMYB/38bVB6iu6LkqaesNT/tFjBFzzUpcwXuTVddxtJ0.3dWJW', '085157626557', 'admin', 1, 2, 'prs5KXZEZF6N2z8ls2ri0WV8nV5vHLJOkJMgVpBF2Ejjo5a1aUt3wnIE7GAI', '2021-03-21 23:57:02', '2021-04-13 02:49:51', NULL),
(3, 'SETYA NANDA PRATIWI', '123456789123456789', 'moderator', 'mohwalidas@gmail.com', '2021-04-03 00:02:59', '$2y$10$ZJZuhPc90qdHuNEeVlwBIO10aiaVCSGAaljomI83e759oG.rgqHby', '080000000000', 'moderator', 1, 1, NULL, '2021-04-03 00:02:16', '2021-04-09 05:39:27', NULL),
(4, 'LUANA AULIYA RASMIKO', '000000000000000000', 'user', 'arkhammwb@gmail.com', '2021-04-03 02:32:26', '$2y$10$ZJZuhPc90qdHuNEeVlwBIO10aiaVCSGAaljomI83e759oG.rgqHby', '083879101232', 'user', 2, 3, NULL, '2021-04-03 02:23:07', '2021-04-09 05:39:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workunits`
--

CREATE TABLE `workunits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baes1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workunits`
--

INSERT INTO `workunits` (`id`, `name`, `baes1`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KPPN PURWODADI', '12345', '648812', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(2, 'PENGADILAN AGAMA PURWODADI', '91700', '155677', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(4, 'PENGADILAN NEGERI PURWODADI', '91700', '155678', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(5, 'KPU KABUPATEN BLORA', '22030', '979600', '2021-03-21 22:43:34', '2021-04-05 13:14:21', NULL),
(6, 'KANTOR PELAYANAN PAJAK PRATAMA BLORA', '01504', '409577', '2021-03-21 22:43:34', '2021-04-05 13:12:30', NULL),
(7, 'KPU KABUPATEN GROBOGAN', '22030', '657281', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(8, 'KPPN PURWODADI PENGELOLA PENYALURAN DANA ALOKASI KHUSUS FISIK DAN DANA DESA', '12345', '403529', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(9, 'KEJAKSAAN NEGERI GROBOGAN', '12345', '005435', '2021-03-21 22:43:34', '2021-03-21 22:43:34', NULL),
(10, 'PENGADILAN NEGERI BLORA', '12345', '097851', '2021-03-21 22:43:34', '2021-04-05 13:43:01', NULL),
(12, 'PENGADILAN AGAMA BLORA', '91700', '155680', '2021-03-21 22:43:34', '2021-04-05 13:42:57', NULL),
(14, 'KEJAKSAAN NEGERI BLORA', '12345', '005436', '2021-03-21 22:43:34', '2021-04-05 13:12:39', NULL),
(15, 'BALAI PERAWATAN PERKERETAAPIA', '02209', '467373', '2021-04-05 13:47:21', '2021-04-08 14:41:41', NULL),
(16, 'POLITEKNIK ENERGI DAN MINERAL AKAMIGAS', '02012', '477120', '2021-04-05 13:48:06', '2021-04-05 13:48:06', NULL),
(17, 'BALAI PERAWATAN PERKERETAAPIAN 2', '09209', '9201392', '2021-04-05 14:32:04', '2021-04-05 14:32:10', '2021-04-05 14:32:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agendas_user_id_foreign` (`user_id`),
  ADD KEY `agendas_status_agenda_id_foreign` (`status_agenda_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_question_id_foreign` (`question_id`),
  ADD KEY `answers_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presents`
--
ALTER TABLE `presents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presents_user_id_foreign` (`user_id`),
  ADD KEY `presents_agenda_id_foreign` (`agenda_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `read_notifications`
--
ALTER TABLE `read_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `read_notifications_user_id_foreign` (`user_id`),
  ADD KEY `read_notifications_notification_id_foreign` (`notification_id`);

--
-- Indexes for table `status_agendas`
--
ALTER TABLE `status_agendas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_workunit_id_foreign` (`workunit_id`),
  ADD KEY `users_position_id_foreign` (`position_id`);

--
-- Indexes for table `workunits`
--
ALTER TABLE `workunits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `presents`
--
ALTER TABLE `presents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `read_notifications`
--
ALTER TABLE `read_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `status_agendas`
--
ALTER TABLE `status_agendas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workunits`
--
ALTER TABLE `workunits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_status_agenda_id_foreign` FOREIGN KEY (`status_agenda_id`) REFERENCES `status_agendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agendas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presents`
--
ALTER TABLE `presents`
  ADD CONSTRAINT `presents_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `read_notifications`
--
ALTER TABLE `read_notifications`
  ADD CONSTRAINT `read_notifications_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `read_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_workunit_id_foreign` FOREIGN KEY (`workunit_id`) REFERENCES `workunits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
