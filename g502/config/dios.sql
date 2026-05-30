-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 07:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dios`
--
CREATE DATABASE IF NOT EXISTS `dios` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dios`;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('andresbeltran1806@gmail.com', '$2y$10$vT9KkXVLKRehbP0W7s9o8uLChnb4FRWsqrJShyTgF1RrhFtBfE906', '2025-06-14 04:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `pepe`
--

CREATE TABLE `pepe` (
  `puesto` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Marco Andres', 'andresbeltran1806@gmail.com', NULL, '$2y$10$7QUG0OXMQvI8gbbwppN7CubUGHScVvyOmsYQHPanQQRPVPnS3QiYC', NULL, '2025-06-12 12:16:15', '2025-06-12 12:16:15');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Database: `dios1`
--
CREATE DATABASE IF NOT EXISTS `dios1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dios1`;

-- --------------------------------------------------------

--
-- Table structure for table `abrahan`
--

CREATE TABLE `abrahan` (
  `puesto` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido primer` varchar(20) NOT NULL,
  `telefono` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `slug`) VALUES
(1, 'Cerveza', 'cerveza'),
(2, 'Aguardiente', 'aguardiente'),
(3, 'Ron', 'ron'),
(4, 'Whisky', 'whisky'),
(5, 'Vinos', 'vinos'),
(6, 'Cremas', 'cremas'),
(7, 'Cigarrillos', 'cigarrillos'),
(8, 'Comestibles', 'comestibles'),
(9, 'Otros', 'otros');

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `telefono`, `password`) VALUES
(1, 'kmkm', '', 'kmk', ''),
(2, 'Marco Andres Beltran Parra', 'andresbeltran1806@gmail.com', '3114435729', ''),
(3, 'Marco Andres Beltran Parra', 'andresbeltran1806@gmail.com', '3114435729', ''),
(4, 'Marco Andres Beltran Parra', 'andresbeltran1806@gmail.com', '3114435729', '$2y$10$eBQcEZeqcFtNFsgv6sXRA.gsksmmlV5BB5/IgVWkPYLJ6LOj4CoCW'),
(6, 'marco andres', 'andresbeltran1806@gmail.com', '3114435729', '$2y$10$Uv5dkD0XQeJvhe.6Cl.h4eRNQoaxYRz4mkaSjVvsSY4fEyx2bKteO'),
(7, 'marco andres', 'andresbeltran1806@gmail.com', '3114435729', '$2y$10$iMU0VbJYGiJbJy0gqzIwX.y6SprI3p2mUQ8CrJMcWX.5BAJC3g16q'),
(8, 'dsd', 'andresbeltran1806@gmail.com', '2222222222', '$2y$10$B3jaTigMEfPxYSOHxHmaDuSdSMFythn2gcg4qlxwy5gZ9JycMhN4a'),
(9, 'hkhbjhb', 'andresbeltran1806@gmail.com', '67777777777', '$2y$10$UK9/V1WqyVyUgrPNgV2kNutQwODvLEMDFPMyFr5KIBT59SfZc/T/i'),
(10, 'hkhbjhb', 'andresbeltran1806@gmail.com', '67777777777', '$2y$10$1uPJSofMuERdvwWzoHXh/u2I52A6.E8IyVWFfJicQoRLE73J18aEe'),
(11, 'hkhbjhb', 'andresbeltran1806@gmail.com', '67777777777', '$2y$10$oQAY6U3RQYxnCIK4Jh3V4.UPj4edTHh2VngDk4StGZ2oANCBEQ/P6'),
(12, 'Pepe', 'andreggsbeltran1806@gmail.com', '3112888729', '$2y$10$ZXEW6IdTJaZpwrAChJKsxeqOdUyNx8EHew8RbQZhFer9pASfSL4ly'),
(13, 'marco andres222222222', 'andresbeltran1806@gmail.com', '223333333333', '$2y$10$fD4Xt7Rpcx1V2kuRS7W88.hCMnAfTyd1wE/8JHWPPNCcXc0sgoQ1K'),
(14, 'Mariana', 'angyloreta@email.com', '3112888729', '$2y$10$CiqDUZpDG/Y1txtlaSjVIuFIPgPDk2Bvy7sIwTHlyhIh3rHynsYk.'),
(15, 'Mariana', 'angyloreta@email.com', '3112888729', '$2y$10$HBC7vAsnY/vbGLDfRcpSD.7v1oZo5R40lqscrhJOJVAvXR.EXfkRu'),
(16, 'Mariana', 'angyloreta@email.com', '3112888729', '$2y$10$k9Ygrr.SwQHHon5hACyFTuyiGiJJ5dmJ3Rbhp/9vGiQEpFtjPklYi'),
(17, 'pepe', 'pepetupep@gmail.com', '3227786543', '$2y$10$CLX..O3/.W7qCnzusxBh/.tY7qBDlKiPxw2igIH8Xm86YeUWWfzde');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `caracteristica` varchar(255) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `id_pedido`, `id_producto`, `nombre_producto`, `caracteristica`, `cantidad`, `precio_unitario`, `total`) VALUES
(1, 1, 182, 'Rothmans', NULL, 2, 12000.00, 0.00),
(2, 1, 181, 'Rothmans', NULL, 7, 6000.00, 0.00),
(3, 1, 116, 'Poker', NULL, 10, 18000.00, 0.00),
(4, 1, 115, 'Poker', NULL, 1, 3300.00, 0.00),
(5, 1, 117, 'Poker', NULL, 6, 67000.00, 0.00),
(6, 1, 69, 'Buchanan\'s', NULL, 12, 173000.00, 0.00),
(7, 1, 118, 'Poker', NULL, 1, 4200.00, 0.00),
(8, 1, 121, 'Aguila', NULL, 1, 3300.00, 0.00),
(9, 1, 103, 'Celebracion', NULL, 1, 49000.00, 0.00),
(10, 2, 102, 'Celebracion', '750ml aperitivo', 1, 49000.00, 0.00),
(11, 3, 209, 'L & m', '10 und morado', 1, 4600.00, 0.00),
(12, 4, 51, 'Aguardiente antioqueño', '750ml sin azucar verde', 1, 48000.00, 0.00),
(13, 5, 115, 'Poker', '330ml lata und', 2, 3300.00, 0.00),
(14, 6, 4, 'Ron viejo de caldas', '750ml', 1, 58000.00, 0.00),
(15, 7, 115, 'Poker', '330ml lata und', 1, 3300.00, 0.00),
(16, 8, 102, 'Celebracion', '750ml aperitivo', 1, 49000.00, 0.00),
(17, 9, 113, 'vive100', '380ml original', 1, 2500.00, 0.00),
(18, 11, 8, 'La vinaja', '1000', 1, 22000.00, 22000.00),
(19, 11, 182, 'Rothmans', '20', 1, 12000.00, 12000.00),
(20, 11, 68, 'Old parr', '750', 2, 153000.00, 306000.00),
(21, 11, 101, 'Baileys', '750', 1, 87000.00, 87000.00),
(22, 12, 113, 'vive100', '380', 122, 2500.00, 305000.00),
(23, 13, 29, 'Casillero del diablo', '750', 1, 61000.00, 61000.00),
(24, 13, 15, 'Gato negro', '187', 1, 14000.00, 14000.00),
(25, 13, 100, 'Baileys', '375', 15, 54000.00, 810000.00),
(26, 14, 115, 'Poker', '330', 1, 3300.00, 3300.00),
(27, 15, 107, 'Ron viejo de caldas', '750', 28, 44000.00, 1232000.00),
(28, 15, 16, 'Buchanan\'s', '1000', 51, 220000.00, 11220000.00),
(29, 16, 104, 'Ron viejo de caldas', '375', 1, 30000.00, 30000.00),
(30, 17, 115, 'Poker', '330', 6, 3300.00, 19800.00),
(31, 17, 31, 'Aguardiente nectar', '375', 22, 25000.00, 550000.00),
(32, 18, 4, 'Ron viejo de caldas', '750', 2, 58000.00, 116000.00),
(33, 19, 113, 'vive100', '380', 1, 2500.00, 2500.00),
(34, 20, 35, 'Aguardiente nectar', '750', 2, 44000.00, 88000.00),
(35, 20, 2, 'Aguardiente antioqueño', '1000', 3, 132000.00, 396000.00),
(36, 20, 30, 'Aguardiente llanero', '750', 6, 44000.00, 264000.00),
(37, 21, 4, 'Ron viejo de caldas', '750', 5, 58000.00, 290000.00),
(38, 21, 25, 'Leyenda', '750', 5, 40000.00, 200000.00),
(39, 22, 69, 'Buchanan\'s', '750', 30, 173000.00, 5190000.00),
(40, 23, 29, 'Casillero del diablo', '750', 6, 61000.00, 366000.00),
(41, 24, 16, 'Buchanan\'s', '1000', 2, 220000.00, 440000.00),
(42, 25, 16, 'Buchanan\'s', '1000', 10, 220000.00, 2200000.00),
(43, 26, 182, 'Rothmans', '20', 4, 12000.00, 48000.00),
(44, 26, 188, 'Pielroja', '18', 1, 9500.00, 9500.00),
(45, 26, 16, 'Buchanan\'s', '1000', 2, 220000.00, 440000.00),
(46, 27, 280, 'halls', '12', 4, 1800.00, 7200.00),
(47, 28, 104, 'Ron viejo de caldas', '375', 1, 999.00, 999.00),
(48, 28, 107, 'Ron viejo de caldas', '750', 4, 44000.00, 176000.00),
(49, 29, 101, 'Baileys', '750', 4, 87000.00, 348000.00),
(50, 29, 182, 'Rothmans', '20', 1, 12000.00, 12000.00),
(51, 30, 8, 'La vinaja', '1000ml', 1, 22000.00, 22000.00),
(52, 31, 113, 'vive100', '380ml original', 3, 2500.00, 7500.00),
(53, 31, 4, 'Ron viejo de caldas', '750ml', 5, 58000.00, 290000.00),
(54, 31, 105, 'Ron medellin Dorado', '375ml', 5, 30000.00, 150000.00),
(55, 31, 116, 'Poker', '1980ml six lata', 4, 18000.00, 72000.00),
(56, 32, 101, 'Baileys', '750ml the original', 2, 87000.00, 174000.00),
(57, 32, 102, 'Celebracion', '750ml aperitivo', 2, 49000.00, 98000.00),
(58, 33, 182, 'Rothmans', '20 und azul', 4, 12000.00, 48000.00),
(59, 33, 185, 'Chesterfield', '10 und', 4, 5500.00, 22000.00),
(60, 33, 113, 'vive100', '380ml original', 6, 2500.00, 15000.00),
(61, 34, 280, 'halls', '12 mora zau', 7, 1800.00, 12600.00),
(62, 34, 281, 'halls', '12 mora zau', 3, 1800.00, 5400.00),
(63, 34, 8, 'La vinaja', '1000ml', 4, 22000.00, 88000.00);

-- --------------------------------------------------------

--
-- Table structure for table `donjorgito`
--

CREATE TABLE `donjorgito` (
  `id` int(225) NOT NULL,
  `producto` varchar(225) NOT NULL,
  `caracteristica` varchar(255) NOT NULL,
  `precio` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donjorgito`
--

INSERT INTO `donjorgito` (`id`, `producto`, `caracteristica`, `precio`) VALUES
(6, 'vive 100', '230ml', '2500');

-- --------------------------------------------------------

--
-- Table structure for table `donjorgito1`
--

CREATE TABLE `donjorgito1` (
  `id` int(250) NOT NULL,
  `ca` varchar(250) NOT NULL,
  `producto` varchar(250) NOT NULL,
  `caracteristica` varchar(250) NOT NULL,
  `precio` double NOT NULL,
  `cantidad` int(250) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `es_tendencia` tinyint(1) NOT NULL,
  `marca` varchar(11) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donjorgito1`
--

INSERT INTO `donjorgito1` (`id`, `ca`, `producto`, `caracteristica`, `precio`, `cantidad`, `imagen`, `es_tendencia`, `marca`) VALUES
(2, 'Aguardiente', 'Aguardiente antioqueño', '1000ml azul', 132000, 1, '11111111111111111111111111.png', 0, '0'),
(4, 'Ron', 'Ron viejo de caldas', '750ml', 58000, 1, '666666666666666.png', 0, '0'),
(7, 'Vinos', 'Moscato passito', '1000ml', 22000, 1, 'mascato.png', 0, '0'),
(8, 'Vinos', 'La vinaja', '1000ml', 22000, 1, 'vinajacaja.png', 0, '0'),
(9, 'Vinos', 'Cata tinto', '1000ml', 22000, 1, 'catatinto.png', 0, '0'),
(10, 'Vinos', 'J.Alfonso', '1000ml', 22000, 1, 'jalfonso.png', 0, '0'),
(11, 'Vinos', 'Sanson', '700ml', 26000, 1, 'sanson.png', 0, '0'),
(12, 'Vinos', 'Carbenet sauvignon 120', '187 ml reserva especial', 14000, 1, '120vino.png', 0, '0'),
(15, 'Vinos', 'Gato negro', '187ml cabernet', 14000, 1, 'smallgatopequeño.png', 0, '0'),
(16, 'Whisky', 'Buchanan&#39;s', '1000ml 12 años', 220000, 1, 'duplicado', 1, '0'),
(17, 'Vinos', 'Celebracion', '750ml vino de manzana', 17000, 1, 'VINOCARIÑOSO750MLMANZANA.png', 0, '0'),
(18, 'Vinos', 'Gato negro', '750ml cabernet', 40000, 1, 'gatonegro_750.png', 0, '0'),
(19, 'Vinos', 'Cariñoso', '750ml durazno', 17000, 1, 'CARINOSODURAZNO750ML.png', 0, '0'),
(20, 'Vinos', 'Manischewitz', '750ml concord grape', 63000, 1, 'MANISCHEWITZ750M.png', 0, '0'),
(21, 'Vinos', 'Gato negro', '750ml carmenere', 40000, 1, 'gato-negro-carmenere750ml.png', 0, '0'),
(22, 'Vinos', 'Gato negro', '750ml merlo', 40000, 1, 'VinoTintoFinoGatoNegroMerlot-750.png', 0, '0'),
(23, 'Vinos', 'Gato negro', '750ml blanc', 40000, 1, 'gato_negro_black.png', 0, '0'),
(24, 'Vinos', 'Leyenda', '750ml Cabernet', 40000, 1, 'Leyenda-Cabernet-Sauvignon-750.png', 0, '0'),
(25, 'Vinos', 'Leyenda', '750ml blanc', 40000, 1, 'leyendablack.png', 0, '0'),
(26, 'Vinos', 'Isabella', '750ml blanc', 40000, 1, 'isabellablanc.png', 0, '0'),
(27, 'Vinos', 'Casillero del diablo', '750ml cabernet', 61000, 1, 'Casillero-del-Diablo.png', 0, '0'),
(28, 'Vinos', 'Casillero del diablo', '750ml malbec', 61000, 1, 'Casillero-del-DiabloMalbec.png', 0, '0'),
(29, 'Vinos', 'Casillero del diablo', '750ml merlot', 61000, 1, 'casillero-del-diablo-merlot-750.png', 0, '0'),
(30, 'Aguardiente', 'Aguardiente llanero', '750ml', 44000, 1, 'llanero.png', 0, '0'),
(31, 'Aguardiente', 'Aguardiente nectar', '375ml azul', 25000, 1, 'Nectar-azul.png', 0, '0'),
(32, 'Aguardiente', 'Aguardiente nectar', '750ml dorado', 53000, 1, '22222222222222222222222222222.png', 0, '0'),
(33, 'Aguardiente', 'Aguardiente nectar', '750ml sin azucar', 44000, 1, 'verde750mlnectar.png', 0, '0'),
(34, 'Aguardiente', 'Aguardiente nectar', '750ml original rojo', 44000, 1, 'rojo750nectar.png', 0, '0'),
(35, 'Aguardiente', 'Aguardiente nectar', '750ml club verde', 44000, 1, '333333333333333.png', 0, '0'),
(36, 'Aguardiente', 'Aguardiente nectar azul', '750ml azul', 44000, 1, 'nectarazul750.png', 0, '0'),
(37, 'Aguardiente', 'Cristal', '750ml sin azucar verde', 36000, 1, 'cristalbotrella.png', 0, '0'),
(38, 'Aguardiente', 'Cristal', '750ml original', 40000, 1, 'Crista750ml.png', 0, '0'),
(39, 'Aguardiente', 'Aguardiente nectar', '750ml sin azucar rojo', 44000, 1, 'rojosinazucarnectar.png', 0, '0'),
(40, 'Aguardiente', 'Aguardiente nectar', '1000ml sin azucar verde', 54000, 1, 'nectarcajalitro.png', 0, '0'),
(41, 'Aguardiente', 'Cristal', '1000ml sin azucar verde', 40000, 1, 'CRISTAL1000.png', 0, '0'),
(42, 'Aguardiente', 'Aguardiente nectar', '250ml sin azucar verde', 14000, 1, '250verdenectar.png', 0, '0'),
(43, 'Aguardiente', 'Aguardiente nectar', '1500ml sin azucar verde', 77000, 1, 'aguardientetra-pack1500ml.png', 0, '0'),
(44, 'Aguardiente', 'Aguardiente antioqueño', '1050ml original rojo', 68000, 1, 'antio.rojo1050.png', 0, '0'),
(45, 'Aguardiente', 'Aguardiente antioqueño', '1050ml sin azucar azul', 68000, 1, 'azul1050.png', 0, '0'),
(46, 'Aguardiente', 'Aguardiente antioqueño', '1050ml sin azucar verde', 57000, 1, 'verde1050.png', 0, '0'),
(47, 'Aguardiente', 'Aguardiente antioqueño', '280ml sin azucar verde', 14000, 1, 'aguardienteverde260ml.png', 0, '0'),
(48, 'Aguardiente', 'Aguardiente antioqueño', '260ml sin azucar azul', 19500, 1, 'AntioquenoAzul260ml.png', 0, '0'),
(49, 'Aguardiente', 'Aguardiente antioqueño', '375ml sin azucar verde', 25000, 1, 'sinazucarverde375.png', 0, '0'),
(50, 'Aguardiente', 'Aguardiente antioqueño', '375ml sin azucar azul', 29000, 1, 'Azul-Sin-Azúcar-375ml.png', 0, '0'),
(51, 'Aguardiente', 'Aguardiente antioqueño', '750ml sin azucar verde', 48000, 1, '444444444444444444444.png', 0, '0'),
(52, 'Aguardiente', 'Aguardiente antioqueño', '750ml sin azucar azul', 53500, 1, 'sinazucar750ml.png', 0, '0'),
(53, 'Aguardiente', 'Aguardiente antioqueño', '1000ml sin azucar azul', 73000, 1, 'antioquenosinazucar1000ml.png', 0, '0'),
(54, 'Aguardiente', 'Aguardiente antioqueño', '2000ml sin azucar azul', 132000, 1, '2000mlazul.png', 0, '0'),
(55, 'Aguardiente', 'Aguardiente nectar', '2000ml sin azucar verde', 110000, 1, 'garrafonnectar.png', 0, '0'),
(56, 'Aguardiente', 'Chorrito', '500ml sin azucar', 18000, 1, 'sinazucar500.png.png', 0, '0'),
(57, 'Aguardiente', 'Chorrito', '1000ml sin azucar limon', 33000, 1, '55555555555555.png', 0, '0'),
(58, 'Aguardiente', 'Chorrito', '1000ml sin azucar', 33000, 1, 'sinazucarlitro.png', 0, '0'),
(68, 'Whisky', 'Old parr', '750ml 12 años', 153000, 1, 'oldparr.png', 0, '0'),
(69, 'Whisky', 'Buchanan&#39;s', '750ml 12 años', 171000, 1, 'BuchanansScotch750ml.png', 0, '0'),
(70, 'Whisky', 'Buchanan&#39;s', '750ml Master 15 años', 203000, 1, 'BuchanansMasterScotch750ml.png', 0, '0'),
(71, 'Whisky', 'Buchanan\'s', '1000ml Master 15 años', 255000, 1, 'BuchanansMasterScotch1000ml.png', 0, '0'),
(72, 'Whisky', 'The highland supreme', '750ml', 78000, 1, 'thehighlandsupremeblend750ml.png', 0, '0'),
(73, 'Whisky', 'Black & white', '700ml', 59000, 1, 'blackwhite700ml.png', 0, '0'),
(74, 'Whisky', 'Jhonnie walker', '1000ml red label', 97000, 1, 'johnniewalkerredlabel1000ml.png', 0, '0'),
(75, 'Whisky', 'Jhonnie walker', '700ml red label', 75000, 1, 'Johnnie_Walker.png', 0, '0'),
(76, 'Whisky', 'Jhonnie walker', '700ml black label', 160000, 1, 'Johnnie_Walker_Black.png', 0, '0'),
(77, 'Whisky', 'Grant&#39;s', '1000ml', 90000, 1, 'Wiskygrants_1000.png', 0, '0'),
(78, 'Whisky', 'Grant&#39;s', '700ml', 67000, 1, 'Wiskygrants_700.png', 0, '0'),
(79, 'Whisky', 'Passport scotch', '700ml', 55000, 1, 'passport.png', 0, '0'),
(80, 'Whisky', 'Jack daniel\'s', '700ml fire', 128000, 1, 'jack-danielsfire.png', 0, '0'),
(81, 'Whisky', 'Jack daniel\'s', '700ml Honey', 128000, 1, 'jack-danielshoney.png', 0, '0'),
(82, 'Whisky', 'Jack daniel\'s', '700ml jennesse black', 128000, 1, 'jack-daniels.png', 0, '0'),
(83, 'Whisky', 'Jagermeister', '700ml', 105000, 1, 'jagerme.png', 0, '0'),
(84, 'Whisky', 'Ballantines', '700ml finest', 66000, 1, 'ballentine.png', 0, '0'),
(85, 'Whisky', 'Something special', '1000ml blended scoth', 96000, 1, 'somethingspecialbig.png', 0, '0'),
(86, 'Whisky', 'Something special', '750ml blended scoth', 70000, 1, 'somethingspecialsmall.png', 0, '0'),
(87, 'Whisky', 'John Thomas', '750ml', 51000, 1, 'johnthomastradicional750.png', 0, '0'),
(88, 'Whisky', 'Old parr', '500ml 12 años', 108000, 1, 'oldparrbotella.png', 0, '0'),
(89, 'Whisky', 'John Thomas', '375ml', 25000, 1, 'johnthomassmall.png', 0, '0'),
(90, 'Whisky', 'Black & white', '375ml', 31000, 1, 'BlackWhite375ml.png', 0, '0'),
(91, 'Whisky', 'Jack daniel\'s', '375ml Honey', 68000, 1, 'honey-375ml.png', 0, '0'),
(92, 'Whisky', 'Jagermeister', '350ml', 64000, 1, 'jagerme.png', 0, '0'),
(93, 'Whisky', 'Buchanan\'s', '375ml deluxe 12 años', 102000, 1, 'BuchanansScotch750ml.png', 0, '0'),
(94, 'Whisky', 'Jhonnie walker', '375ml red label', 48000, 1, 'Johnnie_Walker.png', 0, '0'),
(95, 'Whisky', 'Grant&#39;s', '350ml', 41000, 1, 'Wiskygrants_700.png', 0, '0'),
(96, 'Whisky', 'Jack daniel\'s', '200ml jennessee black', 37000, 1, 'jack-daniels.png', 0, '0'),
(97, 'Whisky', 'Something special', '200ml blended scotch', 24000, 1, 'something special 200ml.png', 0, '0'),
(98, 'Whisky', 'Ballantines', '200ml', 23000, 1, 'ballentine.png', 0, '0'),
(99, 'Whisky', 'Passport scotch', '200ml', 17000, 1, 'passport.png', 0, '0'),
(100, 'Cremas', 'Baileys', '375ml the original', 54000, 1, 'baileysoriginal.png', 0, '0'),
(101, 'Cremas', 'Baileys', '750ml the original', 87000, 1, 'baileysoriginal750ml.png', 0, '0'),
(102, 'Cremas', 'Celebracion', '750ml aperitivo', 49000, 1, 'celebritecrema.png', 0, '0'),
(103, 'Cremas', 'Celebracion', '750ml aperitivo maracuya', 49000, 1, 'celebritemaracuya.png', 0, '0'),
(104, 'Ron', 'Ron viejo de caldas', '375ml', 999, 1, 'ron-viejo-de-caldas-375ml.png', 0, '0'),
(105, 'Ron', 'Ron medellin Dorado', '375ml', 30000, 1, 'Ron-Medellin-Anejo375ml.png.png', 0, '0'),
(106, 'Ron', 'Ron medellin', '375ml 3 años tradicional', 31500, 1, 'Ron-Medellin-Anejo375ml3años.png', 0, '0'),
(107, 'Ron', 'Ron viejo de caldas', '750ml blanco', 44000, 0, 'Ron-Viejo-de-Caldas-Blanco.png', 0, '0'),
(108, 'Ron', 'Licor de ron viejo de caldas', '750ml esencial 29%', 44000, 1, 'Ron-Viejo-de-Caldasazul.png', 0, '0'),
(109, 'Ron', 'Ron viejo de caldas', '750ml tradicional', 58000, 1, 'Ron-Viejo-de-Caldas1.png', 0, '0'),
(110, 'Ron', 'Ron medellin Dorado', '750ml', 58000, 1, 'ron-medellin-dorado.png', 0, '0'),
(111, 'Ron', 'Ron medellin', '750ml 3 años', 56000, 1, 'RON-MEDELLIN-3-ANOS750ML.png', 0, '0'),
(112, 'Ron', 'Ron santafe', '750ml 4 años', 48000, 1, 'ron-santafe-4-anos-botella.png', 0, '0'),
(113, 'Comestibles', 'vive100', '380ml original', 2500, 1, 'vive100.png', 0, '0'),
(115, 'Cerveza', 'Poker', '330ml lata und', 3300, 1, 'poker_und_lata.png', 0, '0'),
(116, 'Cerveza', 'Poker', '1980ml six lata', 18000, 1, 'pokersixpack.png', 0, '0'),
(117, 'Cerveza', 'Poker', '7920ml Bandeja', 67000, 1, 'bandejapoker.png', 0, '0'),
(118, 'Cerveza', 'Poker', '473ml laton und', 4200, 1, 'latondepoker.png', 0, '0'),
(119, 'Cerveza', 'Poker', 'Laton sixpack', 23000, 1, 'platonpoker.png', 0, '0'),
(120, 'Cerveza', 'Poker', 'Bandeja laton', 88000, 1, 'latorpor24.png', 0, '0'),
(121, 'Cerveza', 'Aguila', '330ml lata und', 3300, 1, 'aguila_und_lata.png', 0, '0'),
(122, 'Cerveza', 'Aguila', '1980ml six lata', 18000, 1, 'aguilaoriginal.png', 0, '0'),
(123, 'Cerveza', 'Aguila', '7920ml Bandeja', 67000, 1, 'bandekaaguila.png', 0, '0'),
(124, 'Cerveza', 'Aguila light', '330ml lata und', 3300, 1, 'aguilalight.png', 0, '0'),
(125, 'Cerveza', 'Aguila light', '1980ml six lata', 18000, 1, 'lightaguila.png', 0, '0'),
(126, 'Cerveza', 'Aguila light', '7920ml Bandeja', 67000, 1, 'lightbandeja.png', 0, '0'),
(127, 'Cerveza', 'Club colombia', '330ml lata und dorada', 3500, 1, 'club_colombia_und_lata.png', 0, '0'),
(128, 'Cerveza', 'Club colombia', '1980ml six lata dorada', 20000, 1, 'clubcolombiadora.png', 0, '0'),
(129, 'Cerveza', 'Club colombia', '7920ml Bandeja dorada', 74000, 1, 'clubcolombia.png', 0, '0'),
(130, 'Cerveza', 'Club colombia', '330ml lata und roja', 22000, 1, 'clubroja.png', 0, '0'),
(131, 'Cerveza', 'Clu colombia', '1980ml six lata roja', 22000, 1, 'rojaclub.png', 0, '0'),
(132, 'Cerveza', 'Club colombia', '7920ml Bandeja roja', 88000, 1, 'redbandeja.png', 0, '0'),
(133, 'Cerveza', 'Club colombia', '1980ml six lata trigo', 22000, 1, 'colombiatrigo.png', 0, '0'),
(134, 'Cerveza', 'Club colombia', '7920ml Bandeja trigo', 84000, 1, 'trigobandeja.png', 0, '0'),
(135, 'Cerveza', 'Club colombia', '1980ml six lata negra', 22000, 1, 'negraclubcolom.png', 0, '0'),
(136, 'Cerveza', 'Club colombia', '7920ml Bandeja negra', 84000, 1, 'negrabandeja.png', 0, '0'),
(137, 'Cerveza', 'Costeña bacana', '330ml lata und', 2600, 1, 'bacana_costeña.png', 0, '0'),
(138, 'Cerveza', 'Costeña bacana', '1980ml six lata', 15000, 1, 'costeñabacana.png', 0, '0'),
(139, 'Cerveza', 'Costeña bacana', '7920ml Bandeja', 60000, 1, 'pacacosteñabacana.png', 0, '0'),
(140, 'Cerveza', 'Costeña gris', '1980ml six lata', 13500, 1, 'costeñagris.png', 0, '0'),
(141, 'Cerveza', 'Costeña gris', '7920ml Bandeja', 52000, 1, 'costeñaabndeja.png', 0, '0'),
(142, 'Cerveza', 'Redd\'s', '1614ml six lata', 19000, 1, 'sixredds.png', 0, '0'),
(143, 'Cerveza', 'Redd', '6456ml bandeja', 74000, 1, 'reddsbaneeja.png', 0, '0'),
(144, 'Cerveza', 'Budweiser', '269ml lata und', 2700, 1, 'budweizer_und_lata.png', 0, '0'),
(145, 'Cerveza', 'Budweiser', '1980ml six lata', 16000, 1, 'budweizersix.png', 0, '0'),
(146, 'Cerveza', 'Budweiser', '7920ml Bandeja lata', 60000, 1, 'budweiserpaca.png', 0, '0'),
(147, 'Cerveza', 'Cola & pola', '330ml lata und', 2500, 1, 'refajocolaypola.png', 0, '0'),
(148, 'Cerveza', 'Cola & pola', '1980ml six lata', 14000, 1, 'colaypolasix.png', 0, '0'),
(149, 'Cerveza', 'Cola & pola', '7920ml Bandeja lata', 50000, 1, 'colaypolapaca.png', 0, '0'),
(150, 'Cerveza', 'Andina', '330ml lata und', 2500, 1, 'andina.png', 0, '0'),
(151, 'Cerveza', 'Andina', '1980ml six lata', 15000, 1, 'andinasix.png', 0, '0'),
(152, 'Cerveza', 'Andina', '7920ml Bandeja lata', 54000, 1, 'pacaandina.png', 0, '0'),
(153, 'Cerveza', 'Andina', '473ml laton und', 3500, 1, 'andinalaton.png', 0, '0'),
(154, 'Cerveza', 'Andina', '5676ml 12und lata', 39000, 1, 'andinalaton.pngpaca.png', 0, '0'),
(155, 'Cerveza', 'Cola & pola', '1500ml', 6200, 1, 'colapolabig.png', 0, '0'),
(156, 'Cerveza', 'Poker', '330ml botella und', 2500, 1, 'pokerund.png', 0, '0'),
(157, 'Cerveza', 'Poker', '1000ml botella und', 6000, 1, 'botellapokeron.png', 0, '0'),
(158, 'Cerveza', 'Poker', '9900ml botella 30und', 73000, 1, 'pokerundpetaco.png', 0, '0'),
(159, 'Cerveza', 'Poker', '13000ml botella 13und', 71000, 1, 'petacodepokeron.png', 0, '0'),
(160, 'Cerveza', 'Aguila', '330ml botella und', 2500, 1, 'aguilaund.png', 0, '0'),
(161, 'Cerveza', 'Aguila', '1000ml botella und', 6000, 1, 'aguilonund.png', 0, '0'),
(162, 'Cerveza', 'Aguila', '9900ml botella 30und', 73000, 1, 'petacoaguilaund.png', 0, '0'),
(163, 'Cerveza', 'Aguila', '13000ml botella 13und', 71000, 1, 'petacoaguilon.png', 0, '0'),
(164, 'Cerveza', 'Aguila light', '330ml botella und', 2500, 1, 'aguilaundbotella.png', 0, '0'),
(165, 'Cerveza', 'Aguila light', '1000ml botella und', 6000, 1, 'aguilonlight1000.png', 0, '0'),
(166, 'Cerveza', 'Aguila light', '9900ml botella 30und', 73000, 1, 'petacoaguilalight.png', 0, '0'),
(167, 'Cerveza', 'Aguila light', '13000ml botella 13und', 71000, 1, 'petacoaguilalightbig.png', 0, '0'),
(168, 'Cerveza', 'Club colombia', '330ml botella und dorada', 3500, 1, 'clubbotelladorada.png', 0, '0'),
(169, 'Cerveza', 'Club colombia', '9900ml botella 30und dorada', 98000, 1, 'petacoclubdorada.png', 0, '0'),
(170, 'Cerveza', 'Club colombia', '800ml botella und dorada', 6500, 1, 'clubcolombia1000.png', 0, '0'),
(171, 'Cerveza', 'Club colombia', '10400ml botella 13und', 70000, 1, '13clubcolombiabotella.png', 0, '0'),
(172, 'Cerveza', 'Corona', '330ml botella und', 5000, 1, 'coronaund.png', 0, '0'),
(173, 'Cerveza', 'Corona', '1980ml six botella', 26000, 1, 'corona_six_pack.png', 0, '0'),
(174, 'Cerveza', 'Corona', '7920ml caja botella', 85000, 1, 'coronacaja.png', 0, '0'),
(175, 'Cerveza', 'Coronita', '210ml botella und', 3500, 1, 'coronitaund.png', 0, '0'),
(176, 'Cerveza', 'Coronita', '1260ml six botella', 19000, 1, 'CORONITAbotella.png', 0, '0'),
(177, 'Cerveza', 'Coronita', '5400ml caja botella', 65000, 1, 'coronitacaja.png', 0, '0'),
(178, 'Cerveza', 'Stella artois', '1980ml six botella', 24000, 1, 'stellasixbotella.png', 0, '0'),
(179, 'Cerveza', 'Stella artois', '7920ml caja botella', 80000, 1, 'stellacaja.png', 0, '0'),
(181, 'Cigarrillos', 'Rothmans', '10 und', 6000, 1, 'mustangorigibal.png', 0, '0'),
(182, 'Cigarrillos', 'Rothmans', '20 und azul', 12000, 1, 'mustangorigibal.png', 0, '0'),
(183, 'Cigarrillos', 'Rothmans', '10 und blanco', 9000, 1, 'blancomustang.png', 0, '0'),
(184, 'Cigarrillos', 'Rothmans', '10 und blanco', 4600, 1, 'blancomustang.png', 0, '0'),
(185, 'Cigarrillos', 'Chesterfield', '10 und', 5500, 1, 'chester.png', 0, '0'),
(186, 'Cigarrillos', 'Rothmans', '10 und gris', 6000, 1, 'belmon.png', 0, '0'),
(187, 'Cigarrillos', 'Rothmans', '20 und gris', 12000, 1, 'belmon.png', 0, '0'),
(188, 'Cigarrillos', 'Pielroja', '18 und', 9500, 1, 'pielroja.png', 0, '0'),
(189, 'Cigarrillos', 'Malboro', '10 und rojo', 6500, 1, 'malbororojo.png', 0, '0'),
(190, 'Cigarrillos', 'Malboro', '20 und rojo', 13000, 1, 'malbororojo.png', 0, '0'),
(191, 'Cigarrillos', 'Malboro', '10 und gold blanco', 6500, 1, 'goldmalboro.png', 0, '0'),
(192, 'Cigarrillos', 'Malboro', '20 und gold blanco', 13000, 1, 'goldmalboro.png', 0, '0'),
(193, 'Cigarrillos', 'Malboro', '10 und morado', 7000, 1, 'malboromorado.png', 0, '0'),
(194, 'Cigarrillos', 'Malboro', '20 und morado', 14000, 1, 'malboromorado.png', 0, '0'),
(195, 'Cigarrillos', 'Malboro', '10 und sandia', 7000, 1, 'malborosandia.png', 0, '0'),
(196, 'Cigarrillos', 'Malboro', '20 und sandia', 14000, 1, 'malborosandia.png', 0, '0'),
(197, 'Cigarrillos', 'Heets', '20 und blue selection', 7000, 1, 'heets.png', 0, '0'),
(198, 'Cigarrillos', 'Lucky strike', '10 und azul', 7000, 1, 'luckyazul.png', 0, '0'),
(199, 'Cigarrillos', 'Lucky strike', '10 und verde', 7000, 1, 'luckyverde.png', 0, '0'),
(200, 'Cigarrillos', 'Lucky strike', '20 und azul', 14000, 1, 'luckyazul.png', 0, '0'),
(201, 'Cigarrillos', 'Lucky strike', '20 und verde', 14000, 1, 'luckyverde.png', 0, '0'),
(202, 'Cigarrillos', 'Lucky strike', '10 und alaska', 7000, 1, 'LUCKYSTRIKEALASKA.png', 0, '0'),
(203, 'Cigarrillos', 'Lucky strike', '10 und mora azul', 7000, 1, 'luckystrikemorado.png', 0, '0'),
(204, 'Cigarrillos', 'Rothmans', '10 und blue classics', 4000, 1, 'blueclassic.png', 0, '0'),
(205, 'Cigarrillos', 'Rothmans', '10 und morado', 4000, 1, 'cigarrosmorado.png', 0, '0'),
(206, 'Cigarrillos', 'L & m', '10 und blanco', 4600, 1, 'cigarrillolmblueevo10.png', 0, '0'),
(207, 'Cigarrillos', 'L & m', '20 und blanco', 9000, 1, 'cigarrillolmblueevo10.png', 0, '0'),
(208, 'Cigarrillos', 'L & m', '10 und azul', 4000, 1, 'lymblue.png', 0, '0'),
(209, 'Cigarrillos', 'L & m', '10 und morado', 4600, 1, 'lymmorado.png', 0, '0'),
(210, 'Ron', 'Ron viejo de caldas', '1000ml caja', 63000, 1, 'RON-VIEJO-DE-CALDAS-TRADICIONAL-CUARTOl.png', 0, '0'),
(211, 'Ron', 'Ron santafe', '1000ml 4 años caja', 58000, 1, 'ronsantafe4años.png', 0, '0'),
(212, 'Ron', 'Ron santafe', '1000ml tradicional caja', 58000, 1, 'ron-santafe1000.png', 0, '0'),
(213, 'Ron', 'Ron medellin', '1000ml 3 años caja', 69000, 1, 'Ron-Medellin-Tetra.png', 0, '0'),
(214, 'Ron', 'Ron viejo de caldas', '250ml caja', 18500, 1, 'RONVIEJODECALDAS250ML.png', 0, '0'),
(215, 'Whisky', 'buchanan\'s two almas', '750 ml 12 años', 191900, 1, '00500019600621l.png', 0, '0'),
(216, 'Whisky', 'Buchanan&#39;s', '1000ml 12 años', 224000, 1, 'BuchanansScotch1000ml.png', 0, '0'),
(217, 'Vinos', 'Casillero del diablo', '750ml malbec', 61000, 1, 'Casillero-del-DiabloMalbec.png', 0, '0'),
(218, 'Whisky', 'Jhonnie walker', '700ml black label', 160000, 1, 'Johnnie_Walker_Black.png', 0, '0'),
(221, 'Champaña', 'Gran brindis', '750ml rosado', 22000, 1, NULL, 0, '0'),
(222, 'Champaña', 'Katich', '750 ml uva blanca', 22000, 1, NULL, 0, '0'),
(223, 'Champaña', 'Katich', '750ml rosado', 22000, 1, NULL, 0, '0'),
(224, 'Champaña', 'Casa nova', '750ml blanco', 22000, 1, NULL, 0, '0'),
(225, 'Brandy', 'Domecq', '375ml', 34000, 1, NULL, 0, '0'),
(226, 'Brandy', 'Domecq', '750ml', 64000, 1, NULL, 0, '0'),
(227, 'Brandy', 'Grand Prix', '375ml', 22500, 1, NULL, 0, '0'),
(228, 'Brandy', 'Grand Prix', '750ml', 40000, 1, NULL, 0, '0'),
(229, 'Aperitivo', 'Reagee', '750ml crema piña colada', 34000, 1, NULL, 0, '0'),
(230, 'Aperitivo', 'Sabajon Apolo', '700ml brandy', 41000, 1, NULL, 0, '0'),
(231, 'Aperitivo', 'Bacardi', '750ml mojito', 50000, 1, NULL, 0, '0'),
(232, 'Aperitivo', 'Bacardi', '750ml zombie', 52000, 1, NULL, 0, '0'),
(233, 'Aperitivo', 'Bacardi', '750ml mandarina', 50000, 1, NULL, 0, '0'),
(234, 'Aperitivo', 'Bacardi', '750ml limon', 50000, 1, NULL, 0, '0'),
(235, 'Aperitivo', 'Smirnoff', '1000ml lujo sin azucar', 50000, 1, NULL, 0, '0'),
(236, 'Vodka', 'Smirnoff', '1000ml lulo sin azucar', 50000, 1, NULL, 0, '0'),
(237, 'Vodka', 'Smirnoff', '750ml lujo sin azucar', 46000, 1, NULL, 0, '0'),
(238, 'Vodka', 'Smirnoff', '375 ml lulo sin azucar', 25000, 1, NULL, 0, '0'),
(239, 'Aperitivo', 'Bacardi', '375ml limon', 32000, 1, NULL, 0, '0'),
(240, 'Vodka', 'Smirnoff', '275ml apple flavour', 9000, 1, NULL, 0, '0'),
(241, 'Vodka', 'Skyy', '750ml', 72000, 1, NULL, 0, '0'),
(242, 'Vodka', 'Absolut vodka', '750ml', 88000, 1, '', 0, '0'),
(243, 'Ginebra', 'Gordon\'s', '350ml london dry gin', 35000, 1, NULL, 0, '0'),
(244, 'Ginebra', 'Gordon\'s', '750ml london dry gin', 79000, 1, NULL, 0, '0'),
(245, 'Tequila', 'Don Julio', '700ml blanco', 241000, 1, NULL, 0, '0'),
(246, 'Tequila', 'El jimador', '375ml', 55000, 1, NULL, 0, '0'),
(247, 'Tequila', 'Olmeca tequila', '700ml', 72000, 1, NULL, 0, '0'),
(248, 'Tequila', 'Jose cuervo', '750ml', 87000, 1, NULL, 0, '0'),
(249, 'Tequila', 'El jimador', '700ml reposado', 98000, 1, NULL, 0, '0'),
(250, 'Tequila', 'El jimador', '750ml blanco', 98000, 1, NULL, 0, '0'),
(251, 'Tequila', 'Jose cuervo', '375ml', 55000, 1, NULL, 0, '0'),
(252, 'Aperitivo', 'Like', '300ml fresh apple', 3800, 1, NULL, 0, '0'),
(253, 'Aperitivo', 'Like', '300ml blueberry', 3800, 1, NULL, 0, '0'),
(254, 'Promoxiones', 'Aguardiente antioqueño', 'Aguardiente antioqueño 1050 ml + vaso coctelero', 68000, 1, NULL, 0, '0'),
(255, 'Promoxiones', 'Ron medellin', 'Ron medellin dorado 750ml + vaso ronero vidrio', 57000, 1, NULL, 0, '0'),
(256, 'Promoxiones', 'Aguardiente antioqueño', 'Aguardiente antioqueño verde 1050 ml + 2 copas', 58000, 1, 'Aguardiente antioqueño verde 1050 ml + 2 copas.png', 0, '0'),
(257, 'Promoxiones', 'Something special', 'Something special 750ml + vaso vidrio', 73000, 1, 'Something special+vaso', 0, '0'),
(258, 'Desechables', 'Platos', '20cm 20 unidades', 4500, 1, NULL, 0, '0'),
(259, 'Desechables', 'Platos', '25oz (plato hondo) 20unidades', 6000, 1, NULL, 0, '0'),
(260, 'Desechables', 'Platos', '26cm 20unidades', 6000, 1, NULL, 0, '0'),
(261, 'Desechables', 'Aluminio', '16 mts', 5300, 1, NULL, 0, '0'),
(262, 'Desechables', 'Vasos', '7oz 50 unidades', 2800, 1, NULL, 0, '0'),
(263, 'Desechables', 'Copas', '1 oz 50 unidades', 2200, 1, NULL, 0, '0'),
(264, 'Personal', 'Papel higiénico', 'Elite duo', 2500, 1, NULL, 0, '0'),
(265, 'Personal', 'Papel higiénico', 'Familia expert', 2800, 1, NULL, 0, '0'),
(266, 'Personal', 'Papel higiénico', 'Familia green', 2000, 1, NULL, 0, '0'),
(267, 'Personal', 'Copas de champaña', '12 unidades', 9000, 1, NULL, 0, '0'),
(268, 'Personal', 'Servilletas', 'Familia 150 unidades', 2600, 1, NULL, 0, '0'),
(269, 'Personal', 'Servilletas', 'Familia 300 unidades', 4800, 1, NULL, 0, '0'),
(270, 'Desechables', 'Cucharas', 'Pequeña 20 unidades', 1500, 1, NULL, 0, '0'),
(271, 'Desechables', 'Cuchillos', 'Normal 20 unidades', 2000, 1, NULL, 0, '0'),
(272, 'Desechables', 'Tenedores', 'Pequeña 20 unidades', 1500, 1, NULL, 0, '0'),
(273, 'Desechables', 'Bolsa de basura', 'Pequeña', 2000, 1, NULL, 0, '0'),
(274, 'Desechables', 'Bolsa de basura', 'Mediana paquete', 2000, 1, NULL, 0, '0'),
(275, 'Desechables', 'Bolsa de basura', 'Grande paquete', 3500, 1, NULL, 0, '0'),
(276, 'Desechables', 'Bolsa de basura', 'Jumbo paquete', 8000, 1, NULL, 0, '0'),
(277, 'Desechables', 'Bolsa de basura', 'Extra jumbo paquete', 12000, 1, NULL, 0, '0'),
(278, 'Whisky', 'Blue label', '750ml', 1200000, 1, NULL, 0, '0'),
(280, 'comestibles', 'halls', '12 mora zau', 1800, 1, NULL, 0, '0'),
(281, 'comestibles', 'halls', '12 mora zau', 1800, 1, NULL, 0, '0'),
(282, 'Cerveza', 'Club Colombia', '2838ml sixpack dorada grande', 25000, 1, NULL, 0, '0'),
(283, 'Cerveza', 'Club Colombia', '11352ml bandeja dorada grande', 94000, 1, NULL, 0, '0'),
(284, 'Cerveza', 'Aguila', '473ml und grande', 4300, 1, NULL, 0, '0'),
(285, 'Cerveza', 'Aguila', '2838 ml sixpack grande', 24000, 1, NULL, 0, '0'),
(286, 'Cerveza', 'Aguila', '11352ml Bandeja grande', 86000, 1, NULL, 0, '0'),
(287, 'Whisky', 'Chivas Regal', '750ml 12 años', 149000, 1, 'chivasregal12años.png', 0, '0'),
(288, 'Whisky', 'Jhonnie walker', '200ml red label', 29000, 1, 'Jhonnie walker 200ml red label.png', 0, '0'),
(289, 'Whisky', 'Black & white', '200 ml', 21000, 1, 'Blackwhite200ml.png', 0, '0'),
(290, 'Whisky', 'Jack daniel&#39;s', '750ml Tennessee Apple', 128000, 1, 'Jack daniels 750ml Tennessee Apple.png', 0, '0'),
(291, 'Whisky', 'John Thomas', '750 ml', 51000, 1, NULL, 0, '0'),
(292, 'Whisky', 'John Thomas', '375ml', 25000, 1, NULL, 0, '0'),
(293, 'Whisky', 'John Thomas', '375ml', 25000, 1, NULL, 0, '0'),
(294, 'Aguardiente', 'Cristal', '750 ml xs', 37000, 1, NULL, 0, '0'),
(295, 'Aguardiente', 'Cristal', '375ml XS', 20000, 1, NULL, 0, '0'),
(296, 'Aguardiente', 'Cristal', '1000ml xs caja', 45000, 1, NULL, 0, '0'),
(297, 'Aguardiente', 'Amarillo de Manzanares', '1500ml sin azucar', 100000, 1, 'amarillo1000ml.png', 0, '0'),
(298, 'Aguardiente', 'Amarillo de Manzanares', '1000ml sin azucar', 69000, 1, 'amariilo1000ml.png', 0, '0'),
(299, 'Aguardiente', 'Amarillo de Manzanares', '750 ml', 54000, 1, 'amariilo1000ml.png', 0, '0'),
(300, 'Aguardiente', 'Amarillo de Manzanares', '375ml sin azucar', 28000, 1, 'amarillo375ml.png', 0, '0'),
(301, 'Cerveza', 'Club Colombia', '473ml und grande', 4500, 1, NULL, 0, '0'),
(302, 'Vinos', '120 Santa Rita', '187,5ml cabernet sauvignon', 14000, 1, '', 0, '0'),
(303, 'Cremas', 'Savor&#039;s', '750ml aperitivo', 49000, 1, NULL, 0, '0'),
(304, 'cremas', 'Savor&#039;s', '750 ml', 49000, 1, NULL, 0, '0'),
(305, 'Vodka', 'smirnoff', '275ml original', 9000, 1, NULL, 0, '0'),
(306, 'Aperitivo', 'Like', '300ml Mango', 4000, 1, NULL, 0, '0'),
(307, 'Aperitivo', 'Like', '300ml Fusion berries', 4000, 1, NULL, 0, '0'),
(308, 'Aperitivo', 'Cuates', '269ml fresa', 4500, 1, NULL, 0, '0'),
(309, 'Aperitivo', 'Cuates', '269ml limon', 4500, 1, NULL, 0, '0'),
(310, 'Aperitivo', 'Cuates', '269ml mango', 4500, 1, NULL, 0, '0'),
(311, 'Aperitivo', 'Cuates', '473ml grande mango', 6500, 1, NULL, 0, '0'),
(312, 'Aperitivo', 'Four Loko', '473ml lulo', 17000, 1, NULL, 0, '0'),
(313, 'Aperitivo', 'Four Loko', '473ml Blue', 17000, 1, NULL, 0, '0'),
(314, 'Aperitivo', 'Four Loko', '473ml gold', 17000, 1, NULL, 0, '0'),
(315, 'Aperitivo', 'Four Loko', '473ml Sandia', 17000, 1, NULL, 0, '0'),
(316, 'Aperitivo', 'Four Loko', '473ml purple', 17000, 1, NULL, 0, '0'),
(317, 'Aperitivo', 'Four Loko', '473ml green', 17000, 1, NULL, 0, '0'),
(318, 'bebidas', 'Coca Cola', '3000ml original', 11000, 1, NULL, 0, '0'),
(319, 'bebidas', 'Coca Cola', '2500ml original', 7500, 1, NULL, 0, '0'),
(320, 'bebidas', 'Coca Cola', '2000ml original retornable', 6000, 1, NULL, 0, '0'),
(321, 'bebidas', 'Quatro', '3000ml', 8000, 1, NULL, 0, '0'),
(322, 'bebidas', 'Sprite', '3000ml', 8000, 1, NULL, 0, '0'),
(323, 'bebidas', 'Jugo del Valle Fresh', '2500ml Frutas Citricas', 6500, 1, NULL, 0, '0'),
(324, 'bebidas', 'Coca Cola', '1500ml original', 6000, 1, NULL, 0, '0'),
(325, 'bebidas', 'Coca Cola', '1365ml zero', 5000, 1, NULL, 0, '0'),
(326, 'bebidas', 'Coca Cola', '1000ml original', 4500, 1, NULL, 0, '0'),
(327, 'bebidas', 'Coca Cola', '1000ml original retornable', 3500, 1, NULL, 0, '0'),
(328, 'bebidas', 'Quatro', '1500ml', 4500, 1, NULL, 0, '0'),
(329, 'bebidas', 'Sprite', '1500ml', 4500, 1, NULL, 0, '0'),
(330, 'bebidas', 'Jugo del Valle Fresh', '1500ml Frutas Citricas', 4500, 1, NULL, 0, '0'),
(331, 'bebidas', 'Brisa con gas', '1500ml manzana', 4000, 1, NULL, 0, '0'),
(332, 'bebidas', 'Brisa con gas', '1500ml maracuya', 4000, 1, NULL, 0, '0'),
(333, 'bebidas', 'Kola Román', '1500ml', 4500, 1, NULL, 0, '0'),
(334, 'bebidas', 'Brisa con gas', '600ml', 1800, 1, NULL, 0, '0'),
(335, 'bebidas', 'Brisa con gas', '600ml manzana', 2500, 1, NULL, 0, '0'),
(336, 'bebidas', 'Brisa con gas', '600ml maracuya', 2500, 1, NULL, 0, '0'),
(337, 'bebidas', 'Jugo del Valle Fresh', '400ml Frutas Citricas', 2000, 1, NULL, 0, '0'),
(338, 'bebidas', 'Coca Cola', '500ml original', 3000, 1, NULL, 0, '0'),
(339, 'bebidas', 'Coca Cola', '500ml zero', 3000, 1, NULL, 0, '0'),
(340, 'bebidas', 'Coca Cola', '250ml original', 2000, 1, NULL, 0, '0'),
(341, 'bebidas', 'Quatro', '400ml', 2600, 1, NULL, 0, '0'),
(342, 'bebidas', 'Coca Cola', '330ml original lata', 3500, 1, NULL, 0, '0'),
(343, 'bebidas', 'Powerade', '500ml mountain blast', 3800, 1, NULL, 0, '0'),
(344, 'bebidas', 'Powerade', '500ml frutas tropicales', 3800, 1, NULL, 0, '0'),
(345, 'bebidas', 'Brisa con gas', '280ml manzana', 1500, 1, NULL, 0, '0'),
(346, 'bebidas', 'Brisa con gas', '280ml limon', 1500, 1, NULL, 0, '0'),
(347, 'bebidas', 'Monster Energy', '473ml verde', 8500, 1, NULL, 0, '0'),
(348, 'bebidas', 'Monster Energy', '473ml mango loco', 8500, 1, NULL, 0, '0'),
(349, 'bebidas', 'Monster Energy', '473ml blanco', 8500, 1, NULL, 0, '0'),
(350, 'bebidas', 'Colombiana', '3125ml original', 8000, 1, NULL, 0, '0'),
(351, 'bebidas', 'Manzana Postobon', '3125ml original', 8000, 1, NULL, 0, '0'),
(352, 'bebidas', 'Colombiana', '2500ml', 5500, 1, NULL, 0, '0'),
(353, 'bebidas', 'Manzana Postobon', '2500ml', 5500, 1, NULL, 0, '0'),
(354, 'bebidas', 'Pepsi', '2500ml original', 5500, 1, NULL, 0, '0'),
(355, 'bebidas', 'Bretaña', '1500ml', 4500, 1, NULL, 0, '0'),
(356, 'bebidas', 'Colombiana', '1500ml original', 4500, 1, NULL, 0, '0'),
(357, 'bebidas', 'Manzana Postobon', '1500ml original', 4500, 1, NULL, 0, '0'),
(358, 'bebidas', 'Naranja Postobon', '1500ml original', 4500, 1, NULL, 0, '0'),
(359, 'bebidas', 'Uva Postobon', '1500ml original', 4500444, 1, NULL, 0, '0'),
(360, 'bebidas', 'Pepsi', '1500ml original', 4500, 1, NULL, 0, '0'),
(361, 'bebidas', 'Canada Dry', '1500ml ginger ale', 5000, 1, NULL, 0, '0'),
(362, 'bebidas', 'Agua Cristal', '600ml', 1500, 1, NULL, 0, '0'),
(363, 'bebidas', 'H2OH!', '1500ml limonata', 4000, 1, NULL, 0, '0'),
(364, 'bebidas', 'H2OH!', '1500ml lima limon', 4000, 1, NULL, 0, '0'),
(365, 'bebidas', 'Jugo Hit', '1500ml mora', 5000, 1, NULL, 0, '0'),
(366, 'bebidas', 'Jugo Hit', '1500ml mango', 5000, 1, NULL, 0, '0'),
(367, 'bebidas', 'Jugo Hit', '1500ml naranja piña', 5000, 1, NULL, 0, '0'),
(368, 'bebidas', 'Postobon', '1000ml Econolitro manzana', 3500, 1, NULL, 0, '0'),
(369, 'bebidas', 'Postobon', '1000ml Econolitro colombiana', 3500, 1, NULL, 0, '0'),
(370, 'bebidas', 'Agua Cristal', '1000ml', 2400, 1, NULL, 0, '0'),
(371, 'bebidas', 'Jugo Hit', '1000ml caja naranja piña', 4600, 1, NULL, 0, '0'),
(372, 'bebidas', 'Jugo Hit', '1000ml caja mora', 4600, 1, NULL, 0, '0'),
(373, 'bebidas', 'Jugo Hit', '1000ml caja mango', 4600, 1, NULL, 0, '0'),
(374, 'bebidas', 'Jugo Hit', '1000ml caja lulo', 4600, 1, NULL, 0, '0'),
(375, 'bebidas', 'Jugo Hit', '500ml mora', 2800, 1, NULL, 0, '0'),
(376, 'bebidas', 'Jugo Hit', '500ml mango', 2800, 1, NULL, 0, '0'),
(377, 'bebidas', 'Jugo Hit', '500ml tropical', 2800, 1, NULL, 0, '0'),
(378, 'bebidas', 'Jugo Hit', '500ml lulo', 2800, 1, NULL, 0, '0'),
(379, 'bebidas', 'Colombiana', '400ml original', 2500, 1, NULL, 0, '0'),
(380, 'bebidas', 'speed max', '250ml', 1500, 1, NULL, 0, '0'),
(381, 'bebidas', 'Bretaña', '300ml', 2500, 1, NULL, 0, '0'),
(382, 'bebidas', 'Agua Cristal', '300ml', 600, 1, NULL, 0, '0'),
(383, 'bebidas', 'Jugo Hit', '200ml caja mango', 1400, 1, NULL, 0, '0'),
(384, 'bebidas', 'Jugo Hit', '200ml caja mora', 1400, 1, NULL, 0, '0'),
(385, 'bebidas', 'Jugo Hit', '200ml caja tropical', 1400, 1, NULL, 0, '0'),
(386, 'bebidas', 'Jugo Hit', '200ml caja lulo', 1400, 1, NULL, 0, '0'),
(387, 'bebidas', 'Jugo Hit', '200ml caja naranja piña', 1400, 1, NULL, 0, '0'),
(388, 'bebidas', 'Mr Tea', '500ml durazno', 2500, 1, NULL, 0, '0'),
(389, 'bebidas', 'Mr Tea', '500ml limon', 2500, 1, NULL, 0, '0'),
(390, 'bebidas', 'H2OH!', '600ml lima limon', 2500, 1, NULL, 0, '0'),
(391, 'bebidas', 'H2OH!', '600ml maracuya', 2500, 1, NULL, 0, '0'),
(392, 'bebidas', 'H2OH!', '600ml limonata', 2500, 1, NULL, 0, '0'),
(393, 'bebidas', 'Gatorade', '500ml maracuya', 3800, 1, NULL, 0, '0'),
(394, 'bebidas', 'Gatorade', '500ml frutos tropicales', 3800, 1, NULL, 0, '0'),
(395, 'bebidas', 'Gatorade', '500ml blue ice', 3800, 1, NULL, 0, '0'),
(396, 'bebidas', 'Agua Cristal', '6000ml bolsa', 4500, 1, NULL, 0, '0'),
(397, 'bebidas', 'Agua Cristal', '18900ml garrafon retornable', 16000, 1, NULL, 0, '0'),
(398, 'bebidas', 'Agua Cristal', '5000ml', 8000, 1, NULL, 0, '0'),
(399, 'bebidas', 'Red Bull', '250ml regular', 7000, 1, NULL, 0, '0'),
(400, 'bebidas', 'speed max', '310ml lata', 2000, 1, NULL, 0, '0'),
(401, 'bebidas', 'Vive 100', '380ml original', 2500, 1, NULL, 0, '0'),
(402, 'bebidas', 'Vive 100', '380ml ultra', 2500, 1, NULL, 0, '0'),
(403, 'bebidas', 'Vive 100', '380ml fusion', 2500, 1, NULL, 0, '0'),
(404, 'bebidas', 'Vive 100', '210ml original', 1500, 1, NULL, 0, '0'),
(405, 'bebidas', 'California', '300ml nectar durazno', 2800, 1, NULL, 0, '0'),
(406, 'bebidas', 'California', '300ml nectar pera', 2800, 1, NULL, 0, '0'),
(407, 'bebidas', 'California', '300ml nectar manzana', 2800, 1, NULL, 0, '0'),
(408, 'bebidas', 'California', '900ml nectar durazno', 7500, 1, NULL, 0, '0'),
(409, 'bebidas', 'California', '900ml nectar pera', 7500, 1, NULL, 0, '0'),
(410, 'bebidas', 'California', '200ml nectar durazno', 2200, 1, NULL, 0, '0'),
(411, 'bebidas', 'California', '200ml nectar pera', 2200, 1, NULL, 0, '0'),
(412, 'bebidas', 'Pony Malta', '200ml', 1700, 1, NULL, 0, '0'),
(413, 'bebidas', 'Pony Malta', '330ml', 2500, 1, NULL, 0, '0'),
(414, 'bebidas', 'Sporade', '500ml tropical', 2500, 1, NULL, 0, '0'),
(415, 'bebidas', 'Electrolit', '625ml maracuya', 8500, 1, NULL, 0, '0'),
(416, 'bebidas', 'Electrolit', '625ml fresa-kiwi', 8500, 1, NULL, 0, '0'),
(417, 'bebidas', 'Electrolit', '625ml naranja mandarina', 8500, 1, NULL, 0, '0'),
(418, 'bebidas', 'Electrolit', '625ml mora azul', 8500, 1, NULL, 0, '0'),
(419, 'bebidas', 'Tangelo', '286ml citrus punch', 1300, 1, NULL, 0, '0'),
(420, 'bebidas', 'Amper Energy', '473ml blanco', 3500, 1, NULL, 0, '0'),
(421, 'bebidas', 'Amper Energy', '473ml original', 3500, 1, NULL, 0, '0'),
(422, 'bebidas', 'Coca Cola', '350ml original retornable', 2500, 1, NULL, 0, '0'),
(423, 'bebidas', 'Big Cola', '400ml original', 1500, 1, NULL, 0, '0'),
(424, 'bebidas', 'Big Cola', '400ml piña', 1500, 1, NULL, 0, '0'),
(425, 'bebidas', 'Pony Malta', '1500ml', 6200, 1, NULL, 0, '0'),
(426, 'bebidas', 'Pony Malta', '1000ml', 4200, 1, NULL, 0, '0'),
(427, 'Dulces', 'bom bom bum', 'rojo', 600, 1, NULL, 0, '0'),
(429, 'Aguardiente', 'buchanan&#039;s two almas', '750 ml 12 años', 191900, 1, 'duplicado', 0, '0'),
(430, 'Cerveza', 'xxx', 'xx', 1, 1, 'Donjorgitofinal/prod_68eb4fa0ca8823.50091130.png', 0, '0'),
(431, 'Aguardiente', '120 Santa Rita', 'rojo', 191.9, 1, NULL, 0, '0'),
(432, 'Cervezax', 'aaax', '111x', 12399, 1, 'rojo1050.png', 0, '0'),
(433, 'Cerveza', 'aaaq', '111x', 1, 1, '55555555555555.png', 0, '0'),
(434, 'Cerveza', 'aaa2', 'thats', 222, 1, '504921_Clun_negra-removebg-preview.png', 0, '0'),
(435, 'Cerveza', 'aaa3', '1', 1, 1, 'flat,750x,075,f-pad,750x1000,f8f8f8.jpg', 0, '0'),
(436, 'Cerveza', 'aaa3', '1', 1, 1, 'flat,750x,075,f-pad,750x1000,f8f8f8.jpg', 0, '0'),
(437, 'Aguardiente', 'aaa4', '250ml', 1, 1, '1000024282.jpg', 0, '0'),
(438, 'Cerveza', 'aaa3', '1', 1, 1, 'flat,750x,075,f-pad,750x1000,f8f8f8.jpg', 0, '0'),
(439, 'Cerveza', 'aaa5ac', 'xx', 222, 1, 'rojo1050.png', 0, '0'),
(440, 'Cerveza', 'aaa5', 'xx', 222, 1, 'rojo1050.png', 0, '0'),
(441, 'Cerveza', 'aaa5', 'xx', 222, 1, '../Donjorgitofinal/00500019600621l.png', 0, '0'),
(442, 'Cerveza', 'aaa5', '111x', 191900, 1, '../Donjorgitofinal/2000mlazul.png', 0, '0'),
(443, 'Vinos', 'aaax', 'ddddddddddddddddd', 1, 1, '../Donjorgitofinal/circular-line-drawing-of-a-3d-astronaut-unique-illustration-powerpoint-background_63d2adbfe0__960_54.jpg', 0, '0'),
(444, 'Ron', 'Coca', '1', 2500, 1, '../Donjorgitofinal/_123106767_mediaitem123106765.jpg.webp', 0, '0'),
(445, 'Cerveza', 'coca', 'lata', 111111, 1, '../Donjorgitofinal/OIP.jpg', 0, '0'),
(446, 'Ron', 'Zorra', '1 hora', 50, 1, '../Donjorgitofinal/20251015_214404.jpg', 0, '0'),
(447, 'Personal', 'crema 5dental', 'faes', 123, 1, '../Donjorgitofinal/Captura de pantalla 2025-09-12 120743.png', 0, '0'),
(448, 'aguardiente', 'Aguardiente Nectar', '750ml sugar free sin azucar', 48000, 1, '../Donjorgitofinal/InShot_20240802_180257498-removebg-preview.png', 0, ''),
(449, 'aguardiente', 'Aguardiente Nectar', '1000ml rojo sin azucar', 54000, 1, '../Donjorgitofinal/IMAGENES_NUEVAS_-_2024-10-11T155852.825_1200x-removebg-preview.png', 0, ''),
(450, 'aguardiente', 'Aguardiente Antioqueño', '2000ml azul sin azúcar garrafa', 132000, 1, '../Donjorgitofinal/Aguardiente-Sin-Azucar-Garrafa-X-2000ml-902302_a-removebg-preview.png', 0, ''),
(451, 'aguardiente', 'Aguardiente Nectar', '500ml sin azucar verde', 29000, 1, '../Donjorgitofinal/AGUARDIENTE-NECTAR-CLUB-500-ML-1408633_a-removebg-preview.png', 0, ''),
(452, 'aguardiente', 'Aguardiente nectar', '250ml rojo', 14000, 1, '../Donjorgitofinal/AGUARDIENTE-TETRA-355771_a-removebg-preview (1).png', 0, ''),
(453, 'aguardiente', 'Aguardiente Nectar', '375ml sin azucar verde', 23000, 1, '../Donjorgitofinal/AGUARDIENTE-CLUB-SAZUC-732039_a-removebg-preview.png', 0, ''),
(454, 'aguardiente', 'Aguardiente Nectar', '375ml rojo', 23000, 1, '../Donjorgitofinal/IMAGENES_NUEVAS_-_2024-10-11T155132.742_1200x-removebg-preview.png', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favoritos`
--

CREATE TABLE `favoritos` (
  `id_favorito` int(11) NOT NULL,
  `producto_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `integrales_calculadas`
--

CREATE TABLE `integrales_calculadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `funcion_original` varchar(255) NOT NULL,
  `variable` varchar(50) NOT NULL,
  `resultado_integral` text NOT NULL,
  `fecha_calculo` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `integrales_calculadas`
--

INSERT INTO `integrales_calculadas` (`id`, `funcion_original`, `variable`, `resultado_integral`, `fecha_calculo`) VALUES
(1, 'x**2', 'x', 'x**3/3', '2025-06-10 23:16:11'),
(2, 'x**2', 'x', 'x**3/3', '2025-06-10 23:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `telefono_cliente` varchar(50) DEFAULT NULL,
  `direccion_cliente` varchar(255) DEFAULT NULL,
  `ciudad_cliente` varchar(100) DEFAULT NULL,
  `total_final` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_pedido` decimal(10,2) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `estado_pedido` varchar(50) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `nombre_cliente`, `email_cliente`, `telefono_cliente`, `direccion_cliente`, `ciudad_cliente`, `total_final`, `total_pedido`, `fecha_pedido`, `estado_pedido`) VALUES
(1, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 2783800.00, '2025-05-29 23:58:09', 'pendiente'),
(2, NULL, 'marco', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 49000.00, '2025-05-30 00:07:12', 'pendiente'),
(3, NULL, 'Marlen', 'marlen0429@hotmail.com', '3227784205', 'Cra79a# 35 18', 'Bogota', 0.00, 4600.00, '2025-05-30 11:40:20', 'pendiente'),
(4, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'ca', 'medellin', 0.00, 48000.00, '2025-05-30 12:30:28', 'pendiente'),
(5, NULL, 'Brayn', 'srebv@ho.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 6600.00, '2025-05-30 12:37:14', 'pendiente'),
(6, NULL, 'Brayn', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'Bogotá', 0.00, 58000.00, '2025-05-30 23:04:53', 'pendiente'),
(7, NULL, 'Brayn', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 3300.00, '2025-05-30 23:33:17', 'pendiente'),
(8, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 49000.00, '2025-06-02 01:38:26', 'pendiente'),
(9, NULL, 'sebastion gutierrs', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 0.00, 2500.00, '2025-06-02 09:30:59', 'pendiente'),
(11, NULL, 'sebastion cadena sin fuentes', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 427000.00, 0.00, '2025-06-03 21:38:45', 'pendiente'),
(12, NULL, 'pepe fernadez', 'pepitomanguero@gmail.com', '32277843', 'Cra. 79a, Kennedy, Bogotá', 'saragosa', 305000.00, 0.00, '2025-06-03 21:40:13', 'pendiente'),
(13, NULL, 'Brayn', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 885000.00, 0.00, '2025-06-03 21:51:31', 'pendiente'),
(14, NULL, 'Brayn', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 3300.00, 0.00, '2025-06-03 23:26:53', 'pendiente'),
(15, NULL, 'Daniel cardenas', 'danielcardenas@gmail.com', '1111111111', 'Carrera 65', 'Bogotá', 12452000.00, 0.00, '2025-06-04 00:09:03', 'pendiente'),
(16, NULL, 'pepe', 'peep@gmail.com', '222222222222', 'Cra. 79a, Kennedy, Bogotá', 'Bogotá', 30000.00, 0.00, '2025-06-05 00:43:52', 'pendiente'),
(17, NULL, 'pablo escobar', '1@email.com', '334333234', 'Cra. 71', 'Bogotá', 569800.00, 0.00, '2025-06-06 10:39:42', 'pendiente'),
(18, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'ccccccc', 'medellin', 116000.00, 0.00, '2025-06-06 10:41:22', 'pendiente'),
(19, NULL, 'd', 'andresbeltran1806@gmail.com', '3114435729', 's', 'medellin', 2500.00, 0.00, '2025-06-06 10:43:32', 'en_proceso'),
(20, NULL, 's', 'sss@gmail.com', '222222222222222', '22222', 'dddd', 748000.00, 0.00, '2025-06-06 10:50:56', 'cancelado'),
(21, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'zz', 'medellin', 490000.00, 0.00, '2025-06-06 11:12:58', 'entregado'),
(22, NULL, 'MARCO', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 5190000.00, 0.00, '2025-06-06 13:40:47', ''),
(23, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 366000.00, 0.00, '2025-06-08 16:06:36', ''),
(24, NULL, 'Daniel cardenas', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 440000.00, 0.00, '2025-06-13 13:32:07', 'cancelado'),
(25, NULL, 'Brayn', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellinmedallo', 2200000.00, 0.00, '2025-06-14 17:56:55', ''),
(26, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 497500.00, 0.00, '2025-08-15 22:08:39', 'cancelado'),
(27, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 7200.00, 0.00, '2025-10-11 01:59:54', ''),
(28, NULL, 'mark1', 'a@gmail.com', '11111111111111', 'Cra. 79a, Kennedy, Bogotá', 'Bogotá', 176999.00, 0.00, '2025-10-23 00:38:27', ''),
(29, NULL, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 360000.00, 0.00, '2025-10-23 01:42:42', ''),
(30, 0, 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 22000.00, 22000.00, '2025-10-23 01:46:17', 'cancelado'),
(31, 0, 'marco|', 'andresbeltran1806@gmail.com', '3114435729', 'wcs', 'medellin', 519500.00, 519500.00, '2025-10-23 01:49:37', 'cancelado'),
(32, 0, 'xxx', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellinc', 272000.00, 272000.00, '2025-10-22 21:56:19', 'entregado'),
(33, 0, 'xxx1', 'andresbeltran1806@gmail.com', '3114435729', 'Cra. 79a, Kennedy, Bogotá', 'medellin', 85000.00, 85000.00, '2025-10-22 22:09:25', 'pendiente'),
(34, 0, 'jorge', 'andresbeltran1806@gmail.com', '3114435729', 'c', 'medellin', 106000.00, 106000.00, '2025-10-22 22:10:22', 'entregado');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen_url` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `volumen` varchar(50) DEFAULT NULL,
  `graduacion_alcoholica` decimal(4,2) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promociones`
--

CREATE TABLE `promociones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_descuento` enum('porcentaje','fijo','2x1','envio_gratis') NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `codigo_cupon` varchar(50) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `activa` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `descripcion`, `tipo_descuento`, `valor`, `codigo_cupon`, `fecha_inicio`, `fecha_fin`, `activa`, `fecha_creacion`) VALUES
(1, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:23:43', '2025-06-12 09:23:43', 1, '2025-06-05 07:23:43'),
(2, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:23:43', '2025-07-05 09:23:43', 1, '2025-06-05 07:23:43'),
(3, 'Mega Descuento Licores', 'Descuento fijo de $20.000 en licores premium.', 'fijo', 20000.00, 'LICOR20K', '2025-06-05 09:23:43', '2025-06-12 09:23:43', 1, '2025-06-05 07:23:43'),
(4, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:23:59', '2025-06-12 09:23:59', 1, '2025-06-05 07:23:59'),
(5, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:23:59', '2025-07-05 09:23:59', 1, '2025-06-05 07:23:59'),
(7, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:00', '2025-06-12 09:24:00', 1, '2025-06-05 07:24:00'),
(8, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:00', '2025-07-05 09:24:00', 1, '2025-06-05 07:24:00'),
(10, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:00', '2025-06-12 09:24:00', 1, '2025-06-05 07:24:00'),
(11, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:00', '2025-07-05 09:24:00', 1, '2025-06-05 07:24:00'),
(13, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:00', '2025-06-12 09:24:00', 1, '2025-06-05 07:24:00'),
(14, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:00', '2025-07-05 09:24:00', 1, '2025-06-05 07:24:00'),
(16, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:00', '2025-06-12 09:24:00', 1, '2025-06-05 07:24:00'),
(17, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:00', '2025-07-05 09:24:00', 1, '2025-06-05 07:24:00'),
(19, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:01', '2025-06-12 09:24:01', 1, '2025-06-05 07:24:01'),
(20, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:01', '2025-07-05 09:24:01', 1, '2025-06-05 07:24:01'),
(22, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:01', '2025-06-12 09:24:01', 1, '2025-06-05 07:24:01'),
(23, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:01', '2025-07-05 09:24:01', 1, '2025-06-05 07:24:01'),
(25, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:01', '2025-06-12 09:24:01', 1, '2025-06-05 07:24:01'),
(26, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:01', '2025-07-05 09:24:01', 1, '2025-06-05 07:24:01'),
(28, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:01', '2025-06-12 09:24:01', 1, '2025-06-05 07:24:01'),
(29, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:01', '2025-07-05 09:24:01', 1, '2025-06-05 07:24:01'),
(31, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:02', '2025-06-12 09:24:02', 1, '2025-06-05 07:24:02'),
(32, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:02', '2025-07-05 09:24:02', 1, '2025-06-05 07:24:02'),
(34, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:02', '2025-06-12 09:24:02', 1, '2025-06-05 07:24:02'),
(35, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:02', '2025-07-05 09:24:02', 1, '2025-06-05 07:24:02'),
(37, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:03', '2025-06-12 09:24:03', 1, '2025-06-05 07:24:03'),
(38, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:03', '2025-07-05 09:24:03', 1, '2025-06-05 07:24:03'),
(40, 'Descuento de Lanzamiento', '15% de descuento en productos seleccionados por lanzamiento.', 'porcentaje', 15.00, NULL, '2025-06-05 09:24:12', '2025-06-12 09:24:12', 1, '2025-06-05 07:24:12'),
(41, 'Oferta Semanal Bebidas', '10% de descuento en todas las bebidas gaseosas.', 'porcentaje', 10.00, NULL, '2025-06-06 09:24:12', '2025-07-05 09:24:12', 1, '2025-06-05 07:24:12'),
(43, 'descuento', 'eeeeeeeeeeeeeeeeeee', 'porcentaje', 200.00, NULL, '2025-06-05 02:28:00', '2025-06-05 02:28:00', 1, '2025-06-05 07:28:24'),
(44, 'ssssssssssss', 'ssssssssssssssssssss', 'porcentaje', 200.00, 'sssssssssssssssss', '2025-06-05 02:30:00', '2025-06-05 02:30:00', 1, '2025-06-05 07:30:35');

-- --------------------------------------------------------

--
-- Table structure for table `promociones_productos`
--

CREATE TABLE `promociones_productos` (
  `promocion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','administrador') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(3, 'Penelope', 'andresbeltr@hotmaill.com', '$2y$10$Hv01v80b3ObayQzkQPDKMOMIksv0A2UpYp.X.DZUE5.1X8RyolKSm', 'usuario', '2025-05-31 04:11:11'),
(4, 'Pablo', 'pablo@gmail.com', '$2y$10$9mF8.sjHuksPmtn9cudUVud2XmZXjeLRIvRDx54ipxBKSGSOQRfZ6', 'usuario', '2025-05-31 04:21:34'),
(6, 'Brayan', 'andresbeltran@gmail.com', '$2y$10$Lz3h1CSW2iSy4Ri7zLP6Au56WPo2JvcxerhtH1cVhGmdu8A4akKri', 'usuario', '2025-05-31 20:07:30'),
(7, 'Marco', 'andresbeltran1806@gmail.com', '$2y$10$gaFM3HZP7ZkeD0NcoNy8GO0a6s.jOWvjoshFLJ5MB3BXSdPEDh/um', 'usuario', '2025-06-03 12:39:44'),
(8, 'your mom', 'a@gmail.com', '$2y$10$jp3LF4pmvIT9/xl8uNo/OO5s6Ci34rBPI7RYNrk0ESet5Zgh5Wz/q', 'administrador', '2025-09-30 06:37:22'),
(11, 'Marco1', 'addgdsfgd@gmail.com', '$2y$10$ZHaNUqf.SG2Fl8vPRd6g4ODQoeEfynhrmEy.4eL/tpBRT/WKoC46y', 'usuario', '2025-10-23 03:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `ventas_manuales`
--

CREATE TABLE `ventas_manuales` (
  `id` int(11) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ventas_manuales`
--

INSERT INTO `ventas_manuales` (`id`, `fecha`, `monto`, `fecha_registro`) VALUES
(1, '2025-10-11', 99999999.99, '2025-10-11 01:50:05'),
(2, '2025-10-12', 99999999.99, '2025-10-11 01:50:28'),
(3, '2025-10-15', 99999999.99, '2025-10-11 01:50:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abrahan`
--
ALTER TABLE `abrahan`
  ADD PRIMARY KEY (`puesto`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `donjorgito`
--
ALTER TABLE `donjorgito`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donjorgito1`
--
ALTER TABLE `donjorgito1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_favorito`),
  ADD KEY `fk_producto_favorito` (`producto_id`);

--
-- Indexes for table `integrales_calculadas`
--
ALTER TABLE `integrales_calculadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indexes for table `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_cupon` (`codigo_cupon`);

--
-- Indexes for table `promociones_productos`
--
ALTER TABLE `promociones_productos`
  ADD PRIMARY KEY (`promocion_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ventas_manuales`
--
ALTER TABLE `ventas_manuales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abrahan`
--
ALTER TABLE `abrahan`
  MODIFY `puesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `donjorgito`
--
ALTER TABLE `donjorgito`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donjorgito1`
--
ALTER TABLE `donjorgito1`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=455;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `integrales_calculadas`
--
ALTER TABLE `integrales_calculadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ventas_manuales`
--
ALTER TABLE `ventas_manuales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `donjorgito1` (`id`);

--
-- Constraints for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_producto_favorito` FOREIGN KEY (`producto_id`) REFERENCES `donjorgito1` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `promociones_productos`
--
ALTER TABLE `promociones_productos`
  ADD CONSTRAINT `promociones_productos_ibfk_1` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`),
  ADD CONSTRAINT `promociones_productos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
--
-- Database: `dios2`
--
CREATE DATABASE IF NOT EXISTS `dios2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dios2`;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_name` varchar(100) DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT 0,
  `document_password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `title`, `file_name`, `file_type`, `file_size`, `upload_date`, `category_name`, `is_protected`, `document_password_hash`) VALUES
(2, 1, 'no-math', '1_6862f818ecc800.91137679.pdf', 'application/pdf', 115615, '2025-06-30 20:48:24', NULL, 0, NULL),
(3, 1, 'teo', '1_6862f84513e6f5.98978135.pdf', 'application/pdf', 1664358, '2025-06-30 20:49:09', NULL, 0, NULL),
(4, 2, 'fff', '2_6862f92ac3e7c1.19995495.pdf', 'application/pdf', 431555, '2025-06-30 20:52:58', NULL, 0, NULL),
(5, 1, 'inteligente', '1_6867ddccc4bca1.95247954.txt', 'text/plain', 262, '2025-07-04 13:57:32', NULL, 0, NULL),
(6, 1, 'dddd', '1_6867e0343894a5.78617618.sql', 'text/plain', 3341, '2025-07-04 14:07:48', NULL, 0, NULL),
(7, 1, 'pruebadetext', '1_68693086ad8a81.03788136.txt', 'text/plain', 262, '2025-07-05 14:02:46', NULL, 0, NULL),
(9, 1, '1', '1_68728e43ede635.09837368.txt', 'text/plain', 88, '2025-07-12 16:33:07', 'Marketing', 0, NULL),
(10, 1, 'finanzas', '1_68728e81728750.50637775.html', 'text/html', 169086, '2025-07-12 16:34:09', 'Finanzas', 0, NULL),
(11, 1, 'teo1', '1_6873d333b07685.87336260.html', 'text/html', 169086, '2025-07-13 15:39:31', 'General', 0, NULL),
(12, 1, 'projecto', '1_687620bd184ca5.43366626.pdf', 'application/pdf', 1780281, '2025-07-15 09:34:53', 'Desarrollo', 0, NULL),
(13, 1, 'ia', '1_68762ca2e4a424.83548451.pdf', 'application/pdf', 16904866, '2025-07-15 10:25:38', 'Estudios', 0, NULL),
(15, 1, 'Python beginner', '1_68a50fa9b5c3f0.38393358.pdf', 'application/pdf', 16904866, '2025-08-19 23:58:33', 'Estudios', 0, NULL),
(16, 1, 'python beginner writter', '1_68a52e4a4e4ac6.39127294.txt', 'text/plain', 950, '2025-08-20 02:09:14', 'Estudios', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, '1001186113', 'andresbeltran1806@gmail.com', '$2y$10$hvwcoBJt5MHgPQkACblTcOKAvIowdj3IdIg5Px66KcUzBcHe2goTe', '2025-06-30 13:51:45'),
(2, 'jorge', '123@gmail.com', '$2y$10$3UIMUf6mRbxcqqbAWn1KAuc3i4wHkzWemAYXYkSDTza0TqanxU81K', '2025-06-30 15:51:42'),
(3, 'kratos', '1@gmail.com', '$2y$10$FnpMrdE0dgW42tO5sY90/OSSBEfDKRkIl7ydRJHf/qKTEXgWN4l6K', '2025-07-12 12:01:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
--
-- Database: `mi_base_de_datos`
--
CREATE DATABASE IF NOT EXISTS `mi_base_de_datos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mi_base_de_datos`;

-- --------------------------------------------------------

--
-- Table structure for table `pepe`
--

CREATE TABLE `pepe` (
  `1` int(11) NOT NULL,
  `11` int(111) NOT NULL,
  `111` int(11) NOT NULL,
  `1111` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2019-10-21 13:37:09', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
