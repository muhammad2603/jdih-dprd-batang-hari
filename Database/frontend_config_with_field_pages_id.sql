-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2026 at 07:32 PM
-- Server version: 11.8.3-MariaDB-0+deb13u1 from Debian
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jdih_dprd_bth`
--

-- --------------------------------------------------------

--
-- Table structure for table `frontend_config`
--

CREATE TABLE `frontend_config` (
  `id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT 'Jika butuh link, contohnya link navigasi.',
  `page_id` int(11) DEFAULT NULL COMMENT 'Halaman yang memiliki konfigurasi ini',
  `component_id` int(11) DEFAULT NULL COMMENT 'Komponen frontend, relasi dari table frontend_components',
  `category_id` int(11) DEFAULT NULL COMMENT 'Kategori konfigurasi, relasi dari table frontend_config_category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='Konfigurasi frontend';

--
-- Dumping data for table `frontend_config`
--

INSERT INTO `frontend_config` (`id`, `content`, `link`, `page_id`, `component_id`, `category_id`) VALUES
(1, 'Beranda', '/', NULL, 1, 1),
(2, 'Produk Hukum', '/produk-hukum', NULL, 1, 1),
(3, 'Statistik', '/statistik', NULL, 1, 1),
(4, 'Tentang', '/tentang', NULL, 1, 1),
(5, 'Logo JDIH DPRD Kabupaten Batang Hari', '/assets/images/logo.png', NULL, NULL, 2),
(6, 'JDIH DPRD', NULL, NULL, NULL, 3),
(7, 'Kabupaten Batang Hari', NULL, NULL, NULL, 3),
(8, 'Jaringan Dokumentasi dan Informasi Hukum', NULL, 1, NULL, 4),
(9, 'Akses mudah dan transparan terhadap seluruh produk hukum daerah Kabupaten Batang Hari', NULL, 1, NULL, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `frontend_config`
--
ALTER TABLE `frontend_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_page_id` (`page_id`),
  ADD KEY `fk_component_id` (`component_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `frontend_config`
--
ALTER TABLE `frontend_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `frontend_config`
--
ALTER TABLE `frontend_config`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `frontend_categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_component_id` FOREIGN KEY (`component_id`) REFERENCES `frontend_components` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_id` FOREIGN KEY (`page_id`) REFERENCES `frontend_pages` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
