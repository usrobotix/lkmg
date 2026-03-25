-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el9.remi
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 25 2026 г., 21:19
-- Версия сервера: 8.0.44-35
-- Версия PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dbcabinet`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `external_id` char(36) DEFAULT NULL,
  `inn` varchar(20) DEFAULT NULL,
  `kpp` varchar(20) DEFAULT NULL,
  `legal_type` enum('ЮридическоеЛицо','ФизическоеЛицо','Иное') DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `external_id`, `inn`, `kpp`, `legal_type`, `user_id`, `name`, `email`, `phone`, `address`, `status`, `created_at`) VALUES
(11, 'e2e04900-191a-11f0-8295-002590de6828', '2312273423', '231201001', 'ЮридическоеЛицо', 1, 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ \"КАПИТАЛ-СТРОЙ\"', 'snab@avalloncompany.ru', NULL, 'Краснодарский крайКраснодар гЯлтинская ул3701000001', 'active', '2026-03-04 00:14:37'),
(12, 'c487c731-451e-11f0-a78d-8539bca52a63', '616206358361', NULL, 'ФизическоеЛицо', 1, 'Оганян Гаврил Яковлевич, ИП', NULL, NULL, 'Краснодарский край3633151', 'active', '2026-03-04 00:14:37'),
(13, 'ca108b23-570f-11f0-a78e-974dc39ddce6', '235212450478', NULL, 'ФизическоеЛицо', 1, 'Петрик Николай Михайлович, ИП', NULL, NULL, 'Краснодарский крайТемрюкский р-нТемрюк гРозы Люксембург ул3651101001', 'active', '2026-03-04 00:14:37'),
(14, '8db39e4e-4524-11f0-a78d-8539bca52a63', '231900044007', NULL, 'ФизическоеЛицо', 1, 'Чернушевич Михаил Антонович', NULL, NULL, 'Краснодарский крайСочи гДонская ул3726000001', 'active', '2026-03-04 00:14:37');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `external_id` char(36) DEFAULT NULL,
  `external_number` varchar(50) DEFAULT NULL,
  `client_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('new','processing','completed','cancelled') DEFAULT 'new',
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `external_id`, `external_number`, `client_id`, `user_id`, `order_date`, `status`, `total`) VALUES
(21, '7e485b32-001e-11f1-a7a3-ade8e62872a1', 'УТУТ-001170', 12, 1, '2026-02-02 10:04:08', 'new', 12960.00),
(22, '70bc7d95-0021-11f1-a7a3-ade8e62872a1', 'УТУТ-001173', 13, 1, '2026-02-02 10:25:11', 'new', 41918.40),
(23, '372d7b3d-00cb-11f1-a7a3-ade8e62872a1', 'УТУТ-001199', 12, 1, '2026-02-03 06:40:25', 'new', 34560.00),
(24, 'd0ffcfb9-00d2-11f1-a7a3-ade8e62872a1', 'УТУТ-001203', 11, 1, '2026-02-03 07:34:49', 'new', 8.64),
(25, '25a1b174-01c8-11f1-a7a3-ade8e62872a1', 'УТУТ-001278', 11, 1, '2026-02-04 12:51:03', 'new', 13.77),
(26, '2ce745e8-0260-11f1-a7a3-ade8e62872a1', 'УТУТ-001293', 11, 1, '2026-02-05 06:59:22', 'new', 115920.00),
(27, 'a7130583-0260-11f1-a7a3-ade8e62872a1', 'УТУТ-001294', 11, 1, '2026-02-05 07:02:44', 'new', 36720.00),
(28, 'e7c60523-028b-11f1-a7a3-ade8e62872a1', 'УТУТ-001319', 12, 1, '2026-02-05 12:12:16', 'new', 14040.00),
(29, '05b31e6e-0291-11f1-a7a3-ade8e62872a1', 'УТУТ-001322', 11, 1, '2026-02-05 12:48:53', 'new', 61776.00),
(30, '8b1c0c80-0339-11f1-a7a3-ade8e62872a1', 'УТУТ-001345', 11, 1, '2026-02-06 08:55:15', 'new', 36720.00),
(31, '8990064f-0590-11f1-a7a3-ade8e62872a1', 'УТУТ-001430', 11, 1, '2026-02-09 08:22:58', 'new', 8.64),
(32, 'e4db9bf3-05a9-11f1-a7a3-ade8e62872a1', 'УТУТ-001459', 11, 1, '2026-02-09 11:24:33', 'new', 30.60),
(33, 'a24bfc2d-0655-11f1-a7a3-ade8e62872a1', 'УТУТ-001486', 11, 1, '2026-02-10 07:53:56', 'new', 6480.00),
(34, '60c9f431-0677-11f1-a7a3-ade8e62872a1', 'УТУТ-001509', 11, 1, '2026-02-10 11:55:23', 'new', 256140.00),
(35, '9755865b-0803-11f1-a7a3-ade8e62872a1', 'УТУТ-001617', 11, 1, '2026-02-12 11:11:36', 'new', 2.88),
(36, '097d2d1a-08d2-11f1-a7a3-ade8e62872a1', 'УТУТ-001671', 11, 1, '2026-02-13 11:49:24', 'new', 98496.00),
(37, 'd91eecec-08d9-11f1-a7a3-ade8e62872a1', 'УТУТ-001675', 11, 1, '2026-02-13 12:45:23', 'new', 92880.00),
(38, 'af20220b-0b26-11f1-a7a3-ade8e62872a1', 'УТУТ-001763', 11, 1, '2026-02-16 11:00:22', 'new', 2.88),
(39, '8d7ae031-0b33-11f1-a7a3-ade8e62872a1', 'УТУТ-001771', 11, 1, '2026-02-16 12:32:33', 'new', 475200.00),
(40, 'e1905af8-0bfe-11f1-a7a3-ade8e62872a1', 'УТУТ-001815', 11, 1, '2026-02-17 12:48:00', 'new', 36720.00),
(41, 'a13bc896-0ca8-11f1-a7a3-ade8e62872a1', 'УТУТ-001837', 11, 1, '2026-02-18 09:03:06', 'new', 32760.00),
(42, 'c12be7a1-0cc6-11f1-a7a3-ade8e62872a1', 'УТУТ-001857', 11, 1, '2026-02-18 12:38:43', 'new', 105840.00),
(43, '6c77b50a-0ccf-11f1-a7a3-ade8e62872a1', 'УТУТ-001871', 11, 1, '2026-02-18 13:40:49', 'new', 148014.00),
(44, '031881df-0cd3-11f1-a7a3-ade8e62872a1', 'УТУТ-001874', 11, 1, '2026-02-18 14:06:30', 'new', 126000.00),
(45, '7de9dd54-0d6a-11f1-a7a3-ade8e62872a1', 'УТУТ-001896', 11, 1, '2026-02-19 08:10:48', 'new', 20.16),
(46, 'd586f389-0d6c-11f1-a7a3-ade8e62872a1', 'УТУТ-001898', 11, 1, '2026-02-19 08:27:32', 'new', 5.76),
(47, '4b4fa203-0d83-11f1-a7a3-ade8e62872a1', 'УТУТ-001916', 12, 1, '2026-02-19 11:08:21', 'new', 34560.00),
(48, '645f3da2-0d84-11f1-a7a3-ade8e62872a1', 'УТУТ-001918', 13, 1, '2026-02-19 11:16:15', 'new', 11246.40),
(49, '1a7d0e0d-0d8d-11f1-a7a3-ade8e62872a1', 'УТУТ-001925', 13, 1, '2026-02-19 12:18:34', 'new', 25560.00),
(50, '979f66f9-0d92-11f1-a7a3-ade8e62872a1', 'УТУТ-001927', 13, 1, '2026-02-19 12:57:50', 'new', 33408.00),
(51, '60a0ed65-0e30-11f1-a7a3-ade8e62872a1', 'УТУТ-001946', 11, 1, '2026-02-20 07:47:18', 'new', 7.47),
(52, '1f3cd5f2-0e4b-11f1-a7a3-ade8e62872a1', 'УТУТ-001967', 13, 1, '2026-02-20 10:58:53', 'new', 40896.00),
(53, 'ff11d094-0e59-11f1-a7a3-ade8e62872a1', 'УТУТ-001974', 11, 1, '2026-02-20 12:45:19', 'new', 44730.00),
(54, '5f756290-115b-11f1-a7a3-ade8e62872a1', 'УТУТ-002045', 13, 1, '2026-02-24 08:32:38', 'new', 4204.80),
(55, '87a821d8-1168-11f1-a7a3-ade8e62872a1', 'УТУТ-002062', 13, 1, '2026-02-24 10:06:50', 'new', 36806.40),
(56, 'b2ac96cd-1229-11f1-a7a3-ade8e62872a1', 'УТУТ-002117', 13, 1, '2026-02-25 09:09:35', 'new', 36806.40),
(57, 'b4810ff9-1314-11f1-a7a3-ade8e62872a1', 'УТУТ-002208', 11, 1, '2026-02-26 13:11:56', 'new', 84.91),
(58, '332b650c-13b1-11f1-a7a3-ade8e62872a1', 'УТУТ-002228', 11, 1, '2026-02-27 07:52:03', 'new', 240.66),
(59, 'e2742c19-13b5-11f1-a7a3-ade8e62872a1', 'УТУТ-002231', 11, 1, '2026-02-27 08:25:40', 'new', 24.30),
(60, '8a8deee2-1617-11f1-a7a3-ade8e62872a1', 'УТУТ-002325', 11, 1, '2026-03-02 09:09:46', 'new', 141408.00),
(61, '3c895eaf-1618-11f1-a7a3-ade8e62872a1', 'УТУТ-002326', 11, 1, '2026-03-02 09:14:42', 'new', 4320.00);

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` decimal(10,3) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `total_price`) VALUES
(53, 21, 'Lemuriano Blue 7731 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 10.080, 750.00, 7560.00),
(54, 21, 'Armani Beige 7733 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 7.200, 750.00, 5400.00),
(55, 22, 'Calacatta 7749 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 59.040, 710.00, 41918.40),
(56, 23, 'Urban Gray Light MT 60x60 (4 шт / 1.44 м²) 1(А)', 43.200, 800.00, 34560.00),
(57, 24, 'Calacatta Gold MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(58, 24, 'Maykel Gray MT 60x60 (5 шт / 1.8 м²) 1(A)', 0.360, 8.00, 2.88),
(59, 24, 'Statuаrio MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(60, 25, 'Elegant МТ 30x90 (6 шт / 1.62 м²)', 1.620, 8.50, 13.77),
(61, 26, 'Manilla Beige MT 60x60 (4 шт / 1.44 м²) 1(A)', 165.600, 700.00, 115920.00),
(62, 27, 'Kristian Bej PGL 60x120 (3 шт / 2.16 м²) 1(A)', 36.720, 1000.00, 36720.00),
(63, 28, 'Lemuriano Blue 7731 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 18.720, 750.00, 14040.00),
(64, 29, 'Onyx Gold 7735 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 48.960, 650.00, 31824.00),
(65, 29, 'Armani Beige 7733 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 46.080, 650.00, 29952.00),
(66, 30, 'Aynaz PGL 60x120 (3 шт / 2.16 м²) 1(A)', 36.720, 1000.00, 36720.00),
(67, 31, 'Artstone Gray MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(68, 31, 'Pro Beton MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(69, 31, 'Quartiz Beige MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(70, 32, 'Artbeton Dark 6068 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(71, 32, 'Artbeton Light 6069 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(72, 32, 'Madeira Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(73, 32, 'Concret Dark 6048 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(74, 33, 'Kristian Bej PGL 60x120 (3 шт / 2.16 м²) 1(A)', 6.480, 1000.00, 6480.00),
(75, 34, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 68.400, 650.00, 44460.00),
(76, 34, 'Travertine Cream PGL 60x120 (3 шт / 2.16 м²) 1(A)', 211.680, 1000.00, 211680.00),
(77, 35, 'Travertin MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(78, 36, 'Dunay Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 950.00, 684.00),
(79, 36, 'Dunay Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 87.120, 950.00, 82764.00),
(80, 36, 'Kolorado White MT 60x120 (2 шт / 1.44 м²) 1(A)', 15.840, 950.00, 15048.00),
(81, 37, 'Jasmin Black PGL 60x120 (3 шт / 2.16 м²) 1(A)', 92.880, 1000.00, 92880.00),
(82, 38, 'Terazzo MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(83, 39, 'Jasmin Black PGL 60x120 (3 шт / 2.16 м²) 1(A)', 475.200, 1000.00, 475200.00),
(84, 40, 'Artbeton Dark 6068 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 36.720, 1000.00, 36720.00),
(85, 41, 'Maykel Gray MT 60x60 (5 шт / 1.8 м²) 1(A)', 50.400, 650.00, 32760.00),
(86, 42, 'Pro Beton MT 60x60 (4 шт / 1.44 м²) 1(A)', 151.200, 700.00, 105840.00),
(87, 43, 'Grafit Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 69.120, 700.00, 48384.00),
(88, 43, 'Arctic MT 30x90 (6 шт / 1.62 м²)', 79.380, 750.00, 59535.00),
(89, 43, 'Basalt MT 30x90 (6 шт / 1.62 м²)', 53.460, 750.00, 40095.00),
(90, 44, 'Artstone Cream MT 60x60 (4 шт / 1.44 м²) 1(A)', 180.000, 700.00, 126000.00),
(91, 45, 'Fusion Gray Dark MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(92, 45, 'Urban Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(93, 45, 'Grafit Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(94, 45, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 0.360, 8.00, 2.88),
(95, 45, 'Murano Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(96, 45, 'Murano Light MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(97, 45, 'Murano MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(98, 46, 'Grafit Gray Light MT 60x60 (4 шт / 1.44м²) 1(A)*', 0.360, 8.00, 2.88),
(99, 46, 'Urban Gray Light MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(100, 47, 'Marbel GL 60x60 (5 шт / 1.8 м²) 2(B)', 57.600, 600.00, 34560.00),
(101, 48, 'Onyx Gold 7735 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 15.840, 710.00, 11246.40),
(102, 49, 'Onyx Gold 7735 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 36.000, 710.00, 25560.00),
(103, 50, 'Mars Cream MT 60х60 (4 шт / 1.44 м²) 1(A)', 41.760, 800.00, 33408.00),
(104, 51, 'Elegant МТ 30x90 (6 шт / 1.62 м²)', 0.270, 8.48, 2.29),
(105, 51, 'Basalt MT 30x90 (6 шт / 1.62 м²)', 0.270, 8.52, 2.30),
(106, 51, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 0.360, 8.00, 2.88),
(107, 52, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 57.600, 710.00, 40896.00),
(108, 53, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 9.000, 650.00, 5850.00),
(109, 53, 'Travertine Cream PGL 60x120 (3 шт / 2.16 м²) 1(A)', 38.880, 1000.00, 38880.00),
(110, 54, 'Pekan Cream 7736 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 5.760, 730.00, 4204.80),
(111, 55, 'Onyx Gold 7735 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 51.840, 710.00, 36806.40),
(112, 56, 'Selen 7739 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 51.840, 710.00, 36806.40),
(113, 57, 'Baykal Cream MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(114, 57, 'Kolorado White MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(115, 57, 'Sofia Cream MT M135 60x120 (2шт /1,41 м²) 1(A)', 0.720, 11.00, 7.92),
(116, 57, 'Diamond Gray Dark PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(117, 57, 'Diamond Opal PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(118, 57, 'Dominic Gray Dark PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(119, 57, 'Jasmin Black PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(120, 57, 'Sonita PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(121, 57, 'Spidеr PGL 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(122, 57, 'Verona MT 74x74 (3 шт / 1.64 м²) 1(A)', 0.546, 10.00, 5.46),
(123, 57, 'Patria Gray MT 74x74 (3 шт / 1.640 м²) 1(A)', 0.547, 10.00, 5.47),
(124, 57, 'Savana Gray Light MT 73,5x73,5 (3 шт / 1.62 м²) 1(A)', 0.540, 9.00, 4.86),
(125, 58, 'Black Project MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.50, 3.06),
(126, 58, 'Mars Brown MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(127, 58, 'Mars Cream MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(128, 58, 'Ultra MT 60x60 (4 шт / 1.44 м²) 1 (A)', 0.360, 8.00, 2.88),
(129, 58, 'Pro Beton MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(130, 58, 'Crocus Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(131, 58, 'Crocus Light MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(132, 58, 'Arnika Gray Dark MT 60x60 (5 шт / 1.8 м²) 1(А)', 0.360, 8.00, 2.88),
(133, 58, 'Arnika Antracit МТ 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(134, 58, 'Artstone Cream MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(135, 58, 'Artstone Gray MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(136, 58, 'Artstone Black MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(137, 58, 'Calacatta Gold MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(138, 58, 'Calacatta Toronto MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(139, 58, 'Statuаrio MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(140, 58, 'Satvario Gray MT 60x60 (4 шт / 1.44 м²) 1(A)*', 0.360, 8.00, 2.88),
(141, 58, 'Galaxy MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(142, 58, 'Santana Light Beige MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(143, 58, 'Manilla Beige MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(144, 58, 'Manilla Brown MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(145, 58, 'Maykel Gray MT 60x60 (5 шт / 1.8 м²) 1(A)', 0.360, 8.00, 2.88),
(146, 58, 'White Project МТ 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(147, 58, 'Travertin MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(148, 58, 'Quartiz Beige MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(149, 58, 'Fusion Gray Light MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(150, 58, 'Fusion Gray Dark MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(151, 58, 'Murano Light MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(152, 58, 'Murano Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(153, 58, 'Grafit Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(154, 58, 'Urban Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(155, 58, 'Urban Gray Light MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(156, 58, 'Murano MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(157, 58, 'Crystal Cream MT 60x60 (5 шт / 1.8 м²) 1(A)', 0.360, 8.00, 2.88),
(158, 58, 'Niagara Black MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(159, 58, 'Neva Gray MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(160, 58, 'Pamir Gray MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(161, 58, 'Bosfor Gray MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(162, 58, 'Volga Gray Dark MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(163, 58, 'Madeira Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(164, 58, 'Dunay Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(165, 58, 'Dunay Gray Dark MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(166, 58, 'Araz Gray Light MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(167, 58, 'Araz Gray Dark MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(168, 58, 'Antik 6044 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(169, 58, 'Artbeton Light 6069 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(170, 58, 'Concret Light 6049 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(171, 58, 'Venecian 6070 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(172, 58, 'Plaster 6046 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(173, 58, 'Volkano 6047 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(174, 58, 'Artbeton Dark 6068 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(175, 58, 'Concret Dark 6048 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.720, 11.00, 7.92),
(176, 58, 'Baykal Cream MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(177, 58, 'Kolorado White MT 60x120 (2 шт / 1.44 м²) 1(A)', 0.720, 9.50, 6.84),
(178, 59, 'Plaster 6046 SHG 60x120 (3 шт / 2.16 м²) 1(A)', 0.360, 11.00, 3.96),
(179, 59, 'Urban Gray Light MT 60x60 (4 шт / 1.44 м²) 1(А)', 0.360, 8.00, 2.88),
(180, 59, 'Artstone Cream MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(181, 59, 'Ultra MT 60x60 (4 шт / 1.44 м²) 1 (A)', 0.360, 8.00, 2.88),
(182, 59, 'Pro Beton MT 60x60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(183, 59, 'Black Project MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.50, 3.06),
(184, 59, 'Artstone Black MT 60х60 (4 шт / 1.44 м²) 1(A)', 0.360, 8.00, 2.88),
(185, 59, 'Grafit Gray Light MT 60x60 (4 шт / 1.44м²) 1(A)*', 0.360, 8.00, 2.88),
(186, 60, 'Espio Black 7743 GL Lux 60x60 (4 шт / 1.44 м²) 1(A)', 155.520, 650.00, 101088.00),
(187, 60, 'Grafit Gray Dark MT 60x60 (4 шт / 1.44 м²) 1(A)', 57.600, 700.00, 40320.00),
(188, 61, 'Karino PGL 60x120 (3 шт / 2.16 м²) 1(A)', 4.320, 1000.00, 4320.00);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `external_id` char(36) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `external_id`, `product_name`, `size`, `price`) VALUES
(19, 'ee8f36ba-45a0-11ef-8886-002590de6828', 'BRICK 109 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(20, '76bc2a6e-16c2-11f0-89df-002590de6828', 'Atlan 118 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(21, 'b8716c80-16c2-11f0-89df-002590de6828', 'Atlan 117 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(22, 'ba6903a6-2fb2-11ef-8a4b-002590de6828', 'BRICK 105 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(23, 'e9df86a0-2fb2-11ef-8a4b-002590de6828', 'BRICK 106 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(24, 'f29c390a-2fb2-11ef-8a4b-002590de6828', 'BRICK 104 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(25, 'ffbfed20-2fb2-11ef-8a4b-002590de6828', 'BRICK 103 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(26, '8e81f02a-96b1-11ef-9365-002590de6828', 'BRIСK 107 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 780.00),
(27, '7058922a-3eaf-11ef-9b5b-002590de6828', 'Atlan 110 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(28, '2f36dab2-3eb0-11ef-9b5b-002590de6828', 'Atlan 119 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(29, 'fc750218-95fb-11ef-9d1b-002590de6828', 'Atlan 107 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(30, '35c1ca38-95fc-11ef-9d1b-002590de6828', 'Atlan 109 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(31, '533ab37c-95fc-11ef-9d1b-002590de6828', 'Atlan 113 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(32, '69fb93ce-95fc-11ef-9d1b-002590de6828', 'Atlan 111 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(33, 'f394189e-95fd-11ef-9d1b-002590de6828', 'Atlan 108 MRP 30x90 (6 шт / 1.62 м²)', NULL, 730.00),
(34, 'd113f0d0-95ff-11ef-9d1b-002590de6828', 'BRIСK 111 RsMT 30x90 (6 шт / 1.62 м²)', NULL, 770.00),
(35, 'c714303a-24f3-11f0-9e9e-002590de6828', 'Atlan 116 MRP 30x90 (6 шт / 1.62 м²)', NULL, 0.00),
(36, 'e9279aa4-24f3-11f0-9e9e-002590de6828', 'Atlan 114 MRP 30x90 (6 шт / 1.62 м²)', NULL, 0.00),
(37, '26620f9b-4210-11f0-a78d-8539bca52a63', 'Atlan 115 MRP 30x90 (6 шт / 1.62 м²)', NULL, 0.00),
(38, 'f6bf16b8-b1bc-11f0-a78f-ce0c8adeda44', 'Basalt MT 30x90 (6 шт / 1.62 м²)', NULL, 0.00),
(39, '6c2ff084-b1bd-11f0-a78f-ce0c8adeda44', 'Elegant МТ 30x90 (6 шт / 1.62 м²)', NULL, 0.00),
(40, '8fac1b7f-b1bd-11f0-a78f-ce0c8adeda44', 'Arctic MT 30x90 (6 шт / 1.62 м²)', NULL, 0.00);

-- --------------------------------------------------------

--
-- Структура таблицы `rate_limit_sessions`
--

CREATE TABLE `rate_limit_sessions` (
  `id` int NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempt_count` int DEFAULT '1',
  `first_attempt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_attempt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_blocked` tinyint(1) DEFAULT '0',
  `blocked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rate_limit_sessions`
--

INSERT INTO `rate_limit_sessions` (`id`, `identifier`, `login`, `ip_address`, `attempt_count`, `first_attempt`, `last_attempt`, `is_blocked`, `blocked_until`) VALUES
(1, 'admin1', 'admin1', '85.173.127.104', 69, '0000-00-00 00:00:00', '2026-03-10 11:26:27', 0, '0000-00-00 00:00:00'),
(28, '111', '111', '85.173.127.104', 3, '2026-02-16 21:14:52', '2026-02-16 21:33:40', 0, NULL),
(46, 'у', 'у', '185.242.85.34', 1, '2026-02-25 19:04:11', '2026-02-25 19:04:11', 0, NULL),
(65, 'admin2', 'admin2', '77.91.75.113', 1, '2026-03-04 00:20:49', '2026-03-04 00:20:49', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('manager','admin','sales') DEFAULT 'manager',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `email`, `role`, `created_at`, `reset_token`, `reset_token_expires`) VALUES
(1, 'admin1', '$2y$10$/ofHtuMVsMiWw6bFJod4XOmwLHEnAWGIo9RQAw3RypuGyKY.b.MYK', 'Админ 1', 'mt-work@yandex.ru', 'admin', '2026-02-11 09:20:11', 'a6729434a07d2d67a5312004bc324dcd', '2026-02-25 09:36:20'),
(2, 'admin2', '$2y$10$ZyXwVuTsRqPoNmLkJiHgFeDcBa09876543210987654321098765', 'Админ 2', 'admin2@example.com', 'admin', '2026-02-11 09:20:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_actions`
--

CREATE TABLE `user_actions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `description` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_actions`
--

INSERT INTO `user_actions` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, NULL, 'login_failed', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:51:05'),
(2, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:51:07'),
(3, NULL, 'login_failed', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:51:14'),
(4, NULL, 'login_failed', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:51:16'),
(5, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:51:19'),
(6, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:52:06'),
(7, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 20:52:17'),
(8, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 21:00:24'),
(9, NULL, 'login_success', 'Login attempt: admin1', '85.173.127.104', '2026-02-16 21:01:05'),
(10, NULL, 'login_failed', 'Login attempt: у', '185.242.85.34', '2026-02-25 19:04:11'),
(11, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-02-25 19:04:22'),
(12, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-02-25 19:04:34'),
(13, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-02-25 19:05:00'),
(14, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-02-25 19:05:24'),
(15, 1, 'login_failed', 'Login attempt: admin1', '176.208.56.53', '2026-03-03 11:43:53'),
(16, 1, 'login_failed', 'Login attempt: admin1', '176.208.56.53', '2026-03-03 11:43:59'),
(17, 1, 'login_failed', 'Login attempt: admin1', '176.208.56.53', '2026-03-03 11:44:09'),
(18, 1, 'import_sync_completed', 'Summary: {\"clients\":{\"created\":4,\"updated\":0,\"skipped\":0,\"errors\":0},\"products\":{\"created\":22,\"updated\":0,\"skipped\":0,\"errors\":0},\"orders\":{\"created\":41,\"updated\":0,\"skipped\":0,\"errors\":0},\"order_items\":{\"created\":136,\"updated\":0,\"skipped\":0,\"errors\":0}}', '77.91.75.113', '2026-03-04 00:14:37'),
(19, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:15:02'),
(20, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:15:09'),
(21, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:15:20'),
(22, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:16:58'),
(23, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:17:11'),
(24, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:17:18'),
(25, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:17:29'),
(26, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:18:26'),
(27, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:18:35'),
(28, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:20:16'),
(29, 1, 'login_failed', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:20:37'),
(30, 2, 'login_failed', 'Login attempt: admin2', '77.91.75.113', '2026-03-04 00:20:49'),
(31, 1, 'login_success', 'Login attempt: admin1', '77.91.75.113', '2026-03-04 00:23:53'),
(32, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-03-05 21:30:40'),
(33, 1, 'login_success', 'Login attempt: admin1', '185.242.85.34', '2026-03-05 21:52:38'),
(34, 1, 'login_success', 'Login attempt: admin1', '77.91.74.72', '2026-03-06 09:39:26'),
(35, 1, 'login_success', 'Login attempt: admin1', '77.91.74.72', '2026-03-06 09:40:36'),
(36, 1, 'login_success', 'Login attempt: admin1', '176.208.56.53', '2026-03-06 09:49:34'),
(37, 1, 'login_success', 'Login attempt: admin1', '85.173.113.244', '2026-03-10 11:26:12'),
(38, 1, 'login_failed', 'Login attempt: admin1', '85.173.113.244', '2026-03-10 11:26:18'),
(39, 1, 'login_success', 'Login attempt: admin1', '85.173.113.244', '2026-03-10 11:26:27');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_clients_external_id` (`external_id`),
  ADD KEY `idx_clients_user_id` (`user_id`),
  ADD KEY `idx_clients_inn` (`inn`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_orders_external_id` (`external_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_products_external_id` (`external_id`);

--
-- Индексы таблицы `rate_limit_sessions`
--
ALTER TABLE `rate_limit_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`),
  ADD KEY `idx_login` (`login`),
  ADD KEY `idx_ip` (`ip_address`),
  ADD KEY `idx_is_blocked` (`is_blocked`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `idx_reset_token` (`reset_token`);

--
-- Индексы таблицы `user_actions`
--
ALTER TABLE `user_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `rate_limit_sessions`
--
ALTER TABLE `rate_limit_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user_actions`
--
ALTER TABLE `user_actions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_actions`
--
ALTER TABLE `user_actions`
  ADD CONSTRAINT `user_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
