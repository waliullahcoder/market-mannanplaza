-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 09:20 AM
-- Server version: 10.6.25-MariaDB-cll-lve
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kassafco_mannanplazamarket`
--
use `market_mannanplaza`;
-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `username` text DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `role`, `password`, `image`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'Admin', 2, '$2y$12$qUALEPPeND2liKMrAs9UZ.wB3p85nxKnibt0sr7HO7A0iLYbE8mN2', 'public/uploads/admin_images/mtx_51067366335.php', 1, 'HftBsS0WaFhNaeki9GEnbTOdo99h14G9dS1WtBq9AJJkzUuSyNKsUxMufhEx', '2019-04-17 01:04:35', '2025-10-07 23:03:35'),
(20, 'marketadmin', 'marketadmin@gmail.com', 'marketadmin@gmail.com', 3, '$2y$10$C2IDEw3Eq6gzWpOtY7jicOwocQf3X7BBeDM.MEWB./qXTjlIclz.6', 'public/uploads/admin_images/logo1_45669423686.png', 1, NULL, '2026-06-03 03:51:19', '2026-06-03 03:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `collection_ebill`
--

CREATE TABLE `collection_ebill` (
  `id` int(11) NOT NULL,
  `Client_Code` text NOT NULL,
  `CMonth` text NOT NULL,
  `CYear` int(11) NOT NULL,
  `billing_month` date DEFAULT NULL,
  `PreviousUnit` int(11) NOT NULL,
  `LastUnit` int(11) NOT NULL,
  `LossUnit` int(11) NOT NULL DEFAULT 0,
  `UsesUnit` int(11) NOT NULL,
  `SerialNo` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `penalty` decimal(10,0) NOT NULL DEFAULT 0,
  `PaidDate` text DEFAULT NULL,
  `PositionNo` text DEFAULT NULL,
  `deposit_date` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `bank` text DEFAULT NULL,
  `cash` text DEFAULT NULL,
  `Project_ID` int(11) NOT NULL,
  `CreateBy` text NOT NULL,
  `CreateDate` text DEFAULT NULL,
  `UpdateBy` text NOT NULL,
  `Updatedate` datetime DEFAULT NULL,
  `ReceiveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `collection_ebill`
--

INSERT INTO `collection_ebill` (`id`, `Client_Code`, `CMonth`, `CYear`, `billing_month`, `PreviousUnit`, `LastUnit`, `LossUnit`, `UsesUnit`, `SerialNo`, `Amount`, `penalty`, `PaidDate`, `PositionNo`, `deposit_date`, `type`, `remarks`, `bank`, `cash`, `Project_ID`, `CreateBy`, `CreateDate`, `UpdateBy`, `Updatedate`, `ReceiveDate`) VALUES
(4, 'G04', 'May', 2026, '2026-05-01', 7393, 7490, 0, 97, 3, 1649, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:12:08', '', '2026-06-06 12:12:08', NULL),
(5, 'G05', 'May', 2025, '2025-05-01', 6091, 6191, 0, 100, 4, 1700, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:18:30', '', '2026-06-06 12:18:30', NULL),
(6, 'G03', 'May', 2026, '2026-05-01', 7315, 7399, 0, 84, 5, 1428, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:24:41', '', '2026-06-06 12:24:41', NULL),
(7, 'G06', 'May', 2026, '2026-05-01', 2188, 2491, 0, 303, 6, 5151, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:25:48', '', '2026-06-06 12:25:48', NULL),
(8, 'G07', 'May', 2026, '2026-05-01', 4168, 4273, 0, 105, 7, 1785, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:26:44', '', '2026-06-06 12:26:44', NULL),
(9, 'G08', 'May', 2026, '2026-05-01', 1826, 1864, 0, 38, 8, 646, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:28:20', '', '2026-06-06 12:28:20', NULL),
(10, 'G09', 'May', 2026, '2026-05-01', 5108, 5178, 0, 70, 9, 1190, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:29:04', '', '2026-06-06 12:29:04', NULL),
(11, 'G10-11A', 'May', 2026, '2026-05-01', 3566, 3796, 0, 230, 10, 3910, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:29:52', '', '2026-06-06 12:29:52', NULL),
(12, 'G12', 'May', 2026, '2026-05-01', 4026, 4080, 0, 54, 11, 918, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:32:19', '', '2026-06-06 12:32:19', NULL),
(13, 'G13', 'May', 2026, '2026-05-01', 1245, 1286, 0, 41, 12, 697, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:48:59', '', '2026-06-06 12:48:59', NULL),
(14, 'G15A', 'May', 2026, '2026-05-01', 6292, 6368, 0, 76, 13, 1292, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:50:07', '', '2026-06-06 12:50:07', NULL),
(15, 'G16', 'May', 2026, '2026-05-01', 7845, 7947, 0, 102, 14, 1734, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:51:00', '', '2026-06-06 12:51:00', NULL),
(16, 'G19', 'May', 2026, '2026-05-01', 15495, 15638, 0, 143, 15, 2431, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:51:31', '', '2026-06-06 12:51:31', NULL),
(17, 'G20', 'May', 2026, '2026-05-01', 9008, 9156, 0, 148, 16, 2516, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:52:19', '', '2026-06-06 12:52:19', NULL),
(18, 'G21', 'May', 2026, '2026-05-01', 806, 864, 0, 58, 17, 986, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:52:45', '', '2026-06-06 12:52:45', NULL),
(19, 'G22', 'May', 2026, '2026-05-01', 4923, 4981, 0, 58, 18, 986, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:54:07', '', '2026-06-06 12:54:07', NULL),
(20, 'G23', 'May', 2026, '2026-05-01', 1971, 2004, 0, 33, 19, 561, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:54:49', '', '2026-06-06 12:54:49', NULL),
(21, 'G24', 'May', 2026, '2026-05-01', 4960, 5006, 0, 46, 20, 782, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:55:30', '', '2026-06-06 12:55:30', NULL),
(22, 'G25', 'May', 2026, '2026-05-01', 2755, 2781, 0, 26, 21, 442, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:57:24', '', '2026-06-06 12:57:24', NULL),
(23, 'G28', 'May', 2026, '2026-05-01', 5096, 5164, 0, 68, 22, 1156, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:57:58', '', '2026-06-06 12:57:58', NULL),
(24, 'G29', 'May', 2026, '2026-05-01', 7032, 7137, 0, 105, 23, 1785, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:58:37', '', '2026-06-06 12:58:37', NULL),
(25, 'G30', 'May', 2026, '2026-05-01', 6809, 6867, 0, 58, 24, 986, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 12:59:46', '', '2026-06-06 12:59:46', NULL),
(26, 'G31', 'May', 2026, '2026-05-01', 8309, 8428, 0, 119, 25, 2023, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:00:29', '', '2026-06-06 13:00:29', NULL),
(27, 'G32', 'May', 2026, '2026-05-01', 1098, 1251, 0, 153, 26, 2601, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:01:32', '', '2026-06-06 13:01:32', NULL),
(28, 'G33', 'May', 2026, '2026-05-01', 27883, 28127, 0, 244, 27, 4148, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:02:35', '', '2026-06-06 13:02:35', NULL),
(29, 'G35', 'May', 2026, '2026-05-01', 8211, 8326, 0, 115, 28, 1955, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:05:08', '', '2026-06-06 13:05:08', NULL),
(30, 'G37', 'May', 2026, '2026-05-01', 8175, 8263, 0, 88, 29, 1496, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:17:31', '', '2026-06-06 13:17:31', NULL),
(31, 'G38', 'May', 2026, '2026-05-01', 13798, 13930, 0, 132, 30, 2244, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:18:24', '', '2026-06-06 13:18:24', NULL),
(32, 'G39', 'May', 2026, '2026-05-01', 6596, 6673, 0, 77, 31, 1309, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:18:58', '', '2026-06-06 13:18:58', NULL),
(33, 'G40', 'May', 2026, '2026-05-01', 1044, 1097, 0, 53, 32, 901, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:19:20', '', '2026-06-06 13:19:20', NULL),
(34, 'G44', 'May', 2026, '2026-05-01', 5233, 5274, 0, 41, 33, 697, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:20:41', '', '2026-06-06 13:20:41', NULL),
(35, 'G45', 'May', 2026, '2026-05-01', 9152, 9314, 0, 162, 34, 2754, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:21:15', '', '2026-06-06 13:21:15', NULL),
(36, 'G47', 'May', 2026, '2026-05-01', 5457, 5706, 0, 249, 35, 4233, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:22:03', '', '2026-06-06 13:22:03', NULL),
(37, 'G48', 'May', 2026, '2026-05-01', 156, 186, 0, 30, 36, 510, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:22:32', '', '2026-06-06 13:22:32', NULL),
(38, 'F01', 'May', 2026, '2026-05-01', 4179, 4206, 0, 27, 37, 459, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:24:54', '', '2026-06-06 13:24:54', NULL),
(39, 'F04', 'May', 2026, '2026-05-01', 3345, 3392, 0, 47, 38, 799, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:25:48', '', '2026-06-06 13:25:48', NULL),
(40, 'F05', 'May', 2026, '2026-05-01', 5924, 5999, 0, 75, 39, 1275, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:26:21', '', '2026-06-06 13:26:21', NULL),
(41, 'F06', 'May', 2026, '2026-05-01', 5140, 5212, 0, 72, 40, 1224, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:26:48', '', '2026-06-06 13:26:48', NULL),
(42, 'F07', 'May', 2026, '2026-05-01', 7624, 7748, 0, 124, 41, 2108, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:27:06', '', '2026-06-06 13:27:06', NULL),
(43, 'F08', 'May', 2026, '2026-05-01', 5046, 5106, 0, 60, 42, 1020, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 13:27:51', '', '2026-06-06 13:27:51', NULL),
(44, 'F09', 'May', 2026, '2026-05-01', 4151, 5262, 0, 1111, 43, 18887, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 14:25:46', '', '2026-06-06 14:25:46', NULL),
(45, 'F14', 'January', 2026, '2026-01-01', 4404, 4468, 0, 64, 44, 1088, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:35:49', '', '2026-06-06 18:35:49', NULL),
(46, 'F12-13', 'January', 2026, '2026-01-01', 7776, 7916, 0, 140, 45, 2380, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:36:42', '', '2026-06-06 18:36:42', NULL),
(47, 'F15-38', 'January', 2026, '2026-01-01', 7228, 7275, 0, 47, 46, 799, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:38:59', '', '2026-06-06 18:38:59', NULL),
(48, 'F17', 'January', 2026, '2026-01-01', 5240, 5295, 0, 55, 47, 935, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:40:07', '', '2026-06-06 18:40:07', NULL),
(49, 'F18', 'January', 2026, '2026-01-01', 5824, 5899, 0, 75, 48, 1275, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:41:23', '', '2026-06-06 18:41:23', NULL),
(50, 'F19', 'January', 2026, '2026-01-01', 6794, 6853, 0, 59, 49, 1003, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:42:26', '', '2026-06-06 18:42:26', NULL),
(51, 'F20', 'January', 2026, '2026-01-01', 9205, 9375, 0, 170, 50, 2890, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:43:15', '', '2026-06-06 18:43:15', NULL),
(52, 'F21', 'January', 2026, '2026-01-01', 6929, 7025, 0, 96, 51, 1632, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:43:43', '', '2026-06-06 18:43:43', NULL),
(53, 'F22-23', 'January', 2026, '2026-01-01', 4188, 4200, 0, 12, 52, 204, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:45:27', '', '2026-06-06 18:45:27', NULL),
(54, 'F24', 'January', 2026, '2026-01-01', 8615, 8708, 0, 93, 53, 1581, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:46:08', '', '2026-06-06 18:46:08', NULL),
(55, 'F25', 'January', 2026, '2026-01-01', 7606, 7710, 0, 104, 54, 1768, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:46:43', '', '2026-06-06 18:46:43', NULL),
(56, 'F26', 'January', 2026, '2026-01-01', 3318, 3348, 0, 30, 55, 510, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:47:16', '', '2026-06-06 18:47:16', NULL),
(57, 'F27', 'January', 2026, '2026-01-01', 6407, 6489, 0, 82, 56, 1394, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:48:04', '', '2026-06-06 18:48:04', NULL),
(58, 'F30', 'January', 2026, '2026-01-01', 8417, 8508, 0, 91, 57, 1547, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 18:50:54', '', '2026-06-06 18:50:54', NULL),
(59, 'F31', 'January', 2026, '2026-01-01', 3539, 3671, 0, 132, 58, 2244, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:21:41', '', '2026-06-06 19:21:41', NULL),
(60, 'F32', 'January', 2026, '2026-01-01', 4845, 4917, 0, 72, 59, 1224, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:22:28', '', '2026-06-06 19:22:28', NULL),
(61, 'F33', 'January', 2026, '2026-01-01', 5810, 5888, 0, 78, 60, 1326, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:23:43', '', '2026-06-06 19:23:43', NULL),
(62, 'F34', 'January', 2026, '2026-01-01', 4063, 4123, 0, 60, 61, 1020, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:24:28', '', '2026-06-06 19:24:28', NULL),
(63, 'F35', 'January', 2026, '2026-01-01', 4812, 4883, 0, 71, 62, 1207, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:25:03', '', '2026-06-06 19:25:03', NULL),
(64, 'F36', 'January', 2026, '2026-01-01', 3383, 3412, 0, 29, 63, 493, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:25:49', '', '2026-06-06 19:25:49', NULL),
(65, 'F37', 'January', 2026, '2026-01-01', 5958, 6023, 0, 65, 64, 1105, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:26:32', '', '2026-06-06 19:26:32', NULL),
(66, 'F39', 'January', 2026, '2026-01-01', 8072, 8189, 0, 117, 65, 1989, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:27:18', '', '2026-06-06 19:27:18', NULL),
(67, 'F L', 'January', 2026, '2026-01-01', 1627, 1661, 0, 34, 66, 578, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:27:57', '', '2026-06-06 19:27:57', NULL),
(68, '2Nd38-39', 'January', 2026, '2026-01-01', 5012, 5097, 0, 85, 67, 1445, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:28:35', '', '2026-06-06 19:28:35', NULL),
(71, 'B R C', 'January', 2026, '2026-01-01', 83919, 84597, 0, 678, 70, 11526, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:42:35', '', '2026-06-06 19:42:35', NULL),
(72, '4TH', 'January', 2026, '2026-01-01', 239245, 244753, 0, 5508, 71, 93636, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:44:33', '', '2026-06-06 19:44:33', NULL),
(73, 'G14', 'May', 2026, '2026-05-01', 3377, 3425, 0, 48, 72, 816, 0, '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:49:08', '', '2026-06-06 19:49:08', NULL),
(75, 'G36', 'May', 2026, '2026-05-01', 445, 569, 0, 124, 74, 2108, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 19:59:33', '', '2026-06-06 19:59:33', NULL),
(76, 'G41-42', 'May', 2026, '2026-05-01', 7013, 7119, 0, 106, 75, 1802, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:03:15', '', '2026-06-06 20:03:15', NULL),
(77, 'G46', 'May', 2026, '2026-05-01', 9880, 10002, 0, 122, 76, 2074, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:04:07', '', '2026-06-06 20:04:07', NULL),
(78, 'F10', 'May', 2026, '2026-05-01', 3549, 3623, 0, 74, 77, 1258, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:06:33', '', '2026-06-06 20:06:33', NULL),
(79, 'F28', 'May', 2026, '2026-05-01', 1621, 1734, 0, 113, 78, 1921, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:07:35', '', '2026-06-06 20:07:35', NULL),
(80, '5TH', 'January', 2026, '2026-01-01', 561636, 570098, 0, 8462, 79, 143854, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:10:27', '', '2026-06-06 20:10:27', NULL),
(81, 'BG', 'January', 2026, '2026-01-01', 408, 558, 0, 150, 80, 2550, 0, '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:17:20', '', '2026-06-06 20:17:20', NULL),
(82, 'Furt-1', 'May', 2026, '2026-05-01', 0, 17, 0, 17, 81, 289, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:23:21', '', '2026-06-06 20:23:21', NULL),
(83, 'Furt-2', 'May', 2026, '2026-05-01', 0, 50, 0, 50, 82, 850, 0, '2026-06-06 12:00:00', 'Ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'marketadmin', '2026-06-06 20:26:12', '', '2026-06-06 20:26:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collection_rant`
--

CREATE TABLE `collection_rant` (
  `id` int(11) NOT NULL,
  `Client_Code` text NOT NULL,
  `CMonth` text NOT NULL,
  `CYear` int(11) DEFAULT NULL,
  `billing_month` date DEFAULT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `penalty` decimal(10,2) NOT NULL DEFAULT 0.00,
  `SerialNo` text NOT NULL,
  `PaidDate` text DEFAULT NULL,
  `Project_ID` int(11) NOT NULL,
  `PositionNo` text DEFAULT NULL,
  `deposit_date` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `bank` text DEFAULT NULL,
  `cash` text DEFAULT NULL,
  `CreateBy` text NOT NULL,
  `Createdate` text DEFAULT NULL,
  `Updateby` text NOT NULL,
  `Updatedate` datetime DEFAULT NULL,
  `ReceiveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `collection_rant`
--

INSERT INTO `collection_rant` (`id`, `Client_Code`, `CMonth`, `CYear`, `billing_month`, `Amount`, `penalty`, `SerialNo`, `PaidDate`, `Project_ID`, `PositionNo`, `deposit_date`, `type`, `remarks`, `bank`, `cash`, `CreateBy`, `Createdate`, `Updateby`, `Updatedate`, `ReceiveDate`) VALUES
(8, 'G03', 'May', 2026, '2026-05-01', 1760, 176.00, '1', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 14:34:41', '', '2026-06-06 15:33:49', '2026-06-06'),
(9, 'G04', 'May', 2026, '2026-05-01', 1960, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(10, 'G05', 'May', 2026, '2026-05-01', 2111, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(11, 'G06', 'May', 2026, '2026-05-01', 2024, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(12, 'G07', 'May', 2026, '2026-05-01', 2024, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(13, 'G08', 'May', 2026, '2026-05-01', 2178, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(14, 'G09', 'May', 2026, '2026-05-01', 2968, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(15, 'G10-11A', 'May', 2026, '2026-05-01', 2600, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(16, 'G12', 'May', 2026, '2026-05-01', 1640, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(17, 'G13', 'May', 2026, '2026-05-01', 1680, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(18, 'G14', 'May', 2026, '2026-05-01', 1536, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(19, 'G15A', 'May', 2026, '2026-05-01', 1520, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(20, 'G16', 'May', 2026, '2026-05-01', 1518, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(21, 'G19', 'May', 2026, '2026-05-01', 980, 0.00, '2', '2026-06-06 12:00:00', 1, 'ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(22, 'G20', 'May', 2026, '2026-05-01', 1725, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(23, 'G21', 'May', 2026, '2026-05-01', 1760, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(24, 'G22', 'May', 2026, '2026-05-01', 1400, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(25, 'G23', 'May', 2026, '2026-05-01', 1400, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(26, 'G24', 'May', 2026, '2026-05-01', 1500, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(27, 'G25', 'May', 2026, '2026-05-01', 1500, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(28, 'G28', 'May', 2026, '2026-05-01', 1480, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(29, 'G29', 'May', 2026, '2026-05-01', 1500, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(30, 'G30', 'May', 2026, '2026-05-01', 1350, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(31, 'G31', 'May', 2026, '2026-05-01', 1350, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(32, 'G32', 'May', 2026, '2026-05-01', 1760, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(33, 'G33', 'May', 2026, '2026-05-01', 1620, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(34, 'G34', 'May', 2026, '2026-05-01', 1100, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(35, 'G35', 'May', 2026, '2026-05-01', 1400, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(36, 'G36', 'May', 2026, '2026-05-01', 1614, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(37, 'G37', 'May', 2026, '2026-05-01', 1672, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(38, 'G38', 'May', 2026, '2026-05-01', 1610, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(39, 'G39', 'May', 2026, '2026-05-01', 1640, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(40, 'G40', 'May', 2026, '2026-05-01', 1618, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(41, 'G41-42', 'May', 2026, '2026-05-01', 27402, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(42, 'G44', 'May', 2026, '2026-05-01', 772, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(43, 'G45', 'May', 2026, '2026-05-01', 16999, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(44, 'G46', 'May', 2026, '2026-05-01', 1, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(45, 'G47', 'May', 2026, '2026-05-01', 1, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(46, 'G48', 'May', 2026, '2026-05-01', 1, 0.00, '2', '2026-06-06 12:00:00', 1, 'Ground floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 16:55:27', '', '2026-06-06 16:55:27', NULL),
(47, 'F25', 'June', 2026, '2026-06-01', 2385, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(48, '2Nd38-39', 'June', 2026, '2026-06-01', 8000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(49, 'F01', 'June', 2026, '2026-06-01', 1050, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(50, 'F02-3', 'June', 2026, '2026-06-01', 2421, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(51, 'F04', 'June', 2026, '2026-06-01', 1520, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(52, 'F05', 'June', 2026, '2026-06-01', 1760, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(53, 'F06', 'June', 2026, '2026-06-01', 1740, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(54, 'F07', 'June', 2026, '2026-06-01', 1760, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(55, 'F08', 'June', 2026, '2026-06-01', 2000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(56, 'F09', 'June', 2026, '2026-06-01', 2000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(57, 'F10', 'June', 2026, '2026-06-01', 2120, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(58, 'F12-13', 'June', 2026, '2026-06-01', 3064, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(59, 'F14', 'June', 2026, '2026-06-01', 1100, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(60, 'F15-38', 'June', 2026, '2026-06-01', 1500, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(61, 'F17', 'June', 2026, '2026-06-01', 2300, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(62, 'F18', 'June', 2026, '2026-06-01', 2300, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(63, 'F19', 'June', 2026, '2026-06-01', 1080, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(64, 'F20', 'June', 2026, '2026-06-01', 2385, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(65, 'F21', 'June', 2026, '2026-06-01', 12000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(66, 'F22-23', 'June', 2026, '2026-06-01', 2610, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(67, 'F24', 'June', 2026, '2026-06-01', 2385, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(68, 'F26', 'June', 2026, '2026-06-01', 1540, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(69, 'F27', 'June', 2026, '2026-06-01', 2160, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(70, 'F28', 'June', 2026, '2026-06-01', 2140, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(71, 'F29', 'June', 2026, '2026-06-01', 2140, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(72, 'F30', 'June', 2026, '2026-06-01', 2120, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(73, 'F31', 'June', 2026, '2026-06-01', 2085, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(74, 'F32', 'June', 2026, '2026-06-01', 2431, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(75, 'F33', 'June', 2026, '2026-06-01', 2394, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(76, 'F34', 'June', 2026, '2026-06-01', 2080, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(77, 'F35', 'June', 2026, '2026-06-01', 2120, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(78, 'F36', 'June', 2026, '2026-06-01', 2080, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(79, 'F37', 'June', 2026, '2026-06-01', 2035, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(80, 'F39', 'June', 2026, '2026-06-01', 1080, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(81, 'F L', 'June', 2026, '2026-06-01', 1500, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(82, 'B R C', 'June', 2026, '2026-06-01', 40000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(83, '4TH', 'June', 2026, '2026-06-01', 80000, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(84, '5TH', 'June', 2026, '2026-06-01', 57690, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(85, '6TH', 'June', 2026, '2026-06-01', 57690, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(86, 'BG', 'June', 2026, '2026-06-01', 13980, 0.00, '3', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:34:43', '', '2026-06-06 18:34:43', NULL),
(87, 'F16', 'May', 2026, '2026-05-01', 450, 0.00, '4', '2026-06-06 12:00:00', 1, '1st Floor', NULL, NULL, NULL, NULL, NULL, 'marketadmin', '2026-06-06 18:47:08', '', '2026-06-06 18:47:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collection_servicecharge`
--

CREATE TABLE `collection_servicecharge` (
  `id` int(11) NOT NULL,
  `Client_Code` text NOT NULL,
  `CMonth` text NOT NULL,
  `CYear` int(11) NOT NULL,
  `billing_month` date DEFAULT NULL,
  `Utility_ID` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `penalty` decimal(10,0) NOT NULL DEFAULT 0,
  `SerialNo` text NOT NULL,
  `PaidDate` text DEFAULT NULL,
  `PositionNo` text DEFAULT NULL,
  `deposit_date` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `bank` text DEFAULT NULL,
  `cash` text DEFAULT NULL,
  `Project_ID` int(11) NOT NULL,
  `CreateBy` text NOT NULL,
  `CreateDate` text DEFAULT NULL,
  `UpdateBy` text NOT NULL,
  `Updatedate` datetime DEFAULT NULL,
  `ReceiveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `collection_servicecharge`
--

INSERT INTO `collection_servicecharge` (`id`, `Client_Code`, `CMonth`, `CYear`, `billing_month`, `Utility_ID`, `Amount`, `penalty`, `SerialNo`, `PaidDate`, `PositionNo`, `deposit_date`, `type`, `remarks`, `bank`, `cash`, `Project_ID`, `CreateBy`, `CreateDate`, `UpdateBy`, `Updatedate`, `ReceiveDate`) VALUES
(9, 'F25', 'May', 2026, '2026-05-01', 7, 300, 0, '3', '2026-06-06 12:00:00', '1st Floor', NULL, NULL, NULL, NULL, NULL, 1, 'Admin', '2026-06-06 14:49:02', '', '2026-06-06 14:49:02', NULL),
(10, 'G03', 'May', 2026, '2026-05-01', 7, 300, 0, '4', '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'Admin', '2026-06-06 14:57:49', '', '2026-06-06 14:57:49', NULL),
(11, 'G03', 'May', 2026, '2026-05-01', 1, 150, 0, '4', '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'Admin', '2026-06-06 14:57:49', '', '2026-06-06 14:57:49', NULL),
(12, 'G03', 'May', 2026, '2026-05-01', 6, 30, 0, '4', '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'Admin', '2026-06-06 14:57:49', '', '2026-06-06 14:57:49', NULL),
(13, 'G03', 'May', 2026, '2026-05-01', 4, 353, 0, '4', '2026-06-06 12:00:00', 'ground floor', NULL, NULL, NULL, NULL, NULL, 1, 'Admin', '2026-06-06 14:57:49', '', '2026-06-06 14:57:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collection_wbill`
--

CREATE TABLE `collection_wbill` (
  `id` int(11) NOT NULL,
  `Client_Code` text NOT NULL,
  `CMonth` text NOT NULL,
  `CYear` int(11) NOT NULL,
  `billing_month` date DEFAULT NULL,
  `PreviousUnit` int(11) NOT NULL,
  `LastUnit` int(11) NOT NULL,
  `UsesUnit` int(11) NOT NULL,
  `SerialNo` text NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `PaidDate` timestamp NULL DEFAULT NULL,
  `PositionNo` text NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `CreateBy` text NOT NULL,
  `CreateDate` timestamp NULL DEFAULT NULL,
  `UpdateBy` text NOT NULL,
  `Updatedate` timestamp NULL DEFAULT NULL,
  `ReceiveDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `collection_wbill`
--

INSERT INTO `collection_wbill` (`id`, `Client_Code`, `CMonth`, `CYear`, `billing_month`, `PreviousUnit`, `LastUnit`, `UsesUnit`, `SerialNo`, `Amount`, `PaidDate`, `PositionNo`, `Project_ID`, `CreateBy`, `CreateDate`, `UpdateBy`, `Updatedate`, `ReceiveDate`) VALUES
(1, 'G10-11A', 'May', 2026, '2026-05-01', 42, 45, 3, '100001', 180, '2026-06-06 06:00:00', 'ground floor', 1, 'marketadmin', '2026-06-06 08:43:28', '', '2026-06-06 08:43:28', NULL),
(2, 'B R C', 'May', 2026, '2026-05-01', 215, 223, 8, '100002', 480, '2026-06-06 06:00:00', '1st Floor', 1, 'marketadmin', '2026-06-06 10:37:32', '', '2026-06-06 10:37:32', NULL),
(3, '2Nd38-39', 'May', 2026, '2026-05-01', 663, 669, 6, '100003', 360, '2026-06-06 06:00:00', '1st Floor', 1, 'marketadmin', '2026-06-06 10:38:59', '', '2026-06-06 10:38:59', NULL),
(4, '4TH', 'May', 2026, '2026-05-01', 6637, 6695, 58, '100004', 3480, '2026-06-06 06:00:00', '1st Floor', 1, 'marketadmin', '2026-06-06 10:40:24', '', '2026-06-06 10:40:24', NULL),
(5, '6TH', 'January', 2026, '2026-01-01', 7114, 7150, 36, '100005', 2160, '2026-06-06 06:00:00', '1st Floor', 1, 'marketadmin', '2026-06-06 14:02:54', '', '2026-06-06 14:02:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

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
-- Table structure for table `saleposition`
--

CREATE TABLE `saleposition` (
  `ID` int(11) NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Name` text DEFAULT NULL,
  `FName` text DEFAULT NULL,
  `MName` text DEFAULT NULL,
  `SName` text DEFAULT NULL,
  `Mobile` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `NationalID` text DEFAULT NULL,
  `TINNo` text DEFAULT NULL,
  `District` text DEFAULT NULL,
  `Thana` text DEFAULT NULL,
  `PO` text DEFAULT NULL,
  `House` text DEFAULT NULL,
  `Project` text DEFAULT NULL,
  `Unit` text DEFAULT NULL,
  `Floor` text DEFAULT NULL,
  `PositionNo` text DEFAULT NULL,
  `PositionSize` decimal(10,0) DEFAULT NULL,
  `ebill_meter_no` text DEFAULT NULL,
  `wbill_meter_no` text DEFAULT NULL,
  `tenant_image` text DEFAULT NULL,
  `DepositeAmount` decimal(10,0) DEFAULT NULL,
  `RentRate` float DEFAULT NULL,
  `EntryReson` text DEFAULT NULL,
  `Agg0ne` float DEFAULT NULL,
  `AggTwo` decimal(10,0) DEFAULT NULL,
  `incrRate` decimal(10,0) DEFAULT NULL,
  `IsRent` text DEFAULT NULL,
  `BusinessType` text DEFAULT NULL,
  `BusinessStart` timestamp NULL DEFAULT NULL,
  `RenterName` text DEFAULT NULL,
  `RenterMobile` text DEFAULT NULL,
  `EntryBy` text DEFAULT NULL,
  `EntryDate` timestamp NULL DEFAULT NULL,
  `UpdateBy` text DEFAULT NULL,
  `UpdateDate` timestamp NULL DEFAULT NULL,
  `MonthlyDeduct` decimal(10,0) DEFAULT NULL,
  `StampNo` text DEFAULT NULL,
  `PassportNo` text DEFAULT NULL,
  `BirthCertificateNo` text DEFAULT NULL,
  `DateofBirth` timestamp NULL DEFAULT NULL,
  `PShopName` text DEFAULT NULL,
  `IsActive` text DEFAULT NULL,
  `EndDate` timestamp NULL DEFAULT NULL,
  `LastSalesAmount` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `saleposition`
--

INSERT INTO `saleposition` (`ID`, `Code`, `Name`, `FName`, `MName`, `SName`, `Mobile`, `address`, `NationalID`, `TINNo`, `District`, `Thana`, `PO`, `House`, `Project`, `Unit`, `Floor`, `PositionNo`, `PositionSize`, `ebill_meter_no`, `wbill_meter_no`, `tenant_image`, `DepositeAmount`, `RentRate`, `EntryReson`, `Agg0ne`, `AggTwo`, `incrRate`, `IsRent`, `BusinessType`, `BusinessStart`, `RenterName`, `RenterMobile`, `EntryBy`, `EntryDate`, `UpdateBy`, `UpdateDate`, `MonthlyDeduct`, `StampNo`, `PassportNo`, `BirthCertificateNo`, `DateofBirth`, `PShopName`, `IsActive`, `EndDate`, `LastSalesAmount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'F25', '(1) Mrs Rubi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2384.5, 2, 1, NULL, NULL, NULL, NULL, NULL, 'Admin', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-02 06:00:00', NULL, 1, '2026-06-02 05:35:09', '2026-06-06 11:56:17'),
(3, '2Nd38-39', 'Dr md arman molla', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 8000, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 10:25:49', '2026-06-06 11:58:45'),
(4, 'G03', 'md abdul matin gazi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1760, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:17:09', '2026-06-04 14:18:05'),
(5, 'G04', 'md.khokon.yakub ali patowary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1960, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:20:51', '2026-06-04 14:20:51'),
(6, 'G05', 'A b m Hayder ali (manik)(2) Mahmudun Nabi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 2110.5, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:26:38', '2026-06-04 14:26:38'),
(7, 'G06', 'Md. Abdul Matin GAzI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 2024, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:30:29', '2026-06-04 14:30:29'),
(8, 'G07', 'MD.Abdul matin Gazi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2024, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:36:31', '2026-06-04 14:36:47'),
(9, 'G08', 'Mrs.kamrujjahan,samsur haque', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2178, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:39:39', '2026-06-04 14:39:54'),
(10, 'G09', 'Johirul Islam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 2968, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:41:30', '2026-06-04 14:41:30'),
(11, 'G10-11A', 'Abul kalam Azad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 2600, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 14:43:41', '2026-06-04 14:43:41'),
(12, 'G12', 'Md.Monur uddin Dawan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1640, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:25:20', '2026-06-04 15:25:20'),
(13, 'G13', 'Ayesha,Aktar,M,A.Wohab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1680, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:28:10', '2026-06-04 15:28:10'),
(14, 'G14', 'Md.Abul Kalam Gazi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1536, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:29:58', '2026-06-04 15:30:10'),
(15, 'G15A', 'Md.Abdul Alim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1520, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:31:57', '2026-06-04 15:31:57'),
(16, 'G16', 'M.G.H.Shahanour', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1518.44, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:33:20', '2026-06-04 15:33:20'),
(17, 'G19', 'Md.Hossain,kobir Hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 980, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:35:57', '2026-06-04 15:35:57'),
(18, 'G20', 'M.G.H. Shahanour', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1725.21, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:37:46', '2026-06-04 15:37:46'),
(19, 'G21', 'Most Ashma Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1760, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:39:06', '2026-06-04 15:39:06'),
(20, 'G22', 'Md Jakir Hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1400, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:40:03', '2026-06-04 15:40:03'),
(21, 'G23', 'Md alamgir khan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1400, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:41:45', '2026-06-04 16:04:41'),
(22, 'G24', 'Nasima AktharSweety', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1500, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-04 06:00:00', NULL, 1, '2026-06-04 15:45:10', '2026-06-04 16:05:25'),
(23, 'G25', 'Mrs.  Bilkios Akther', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1500, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:41:59', '2026-06-05 10:41:59'),
(24, 'G28', 'Samsul Haque', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1480, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:43:47', '2026-06-05 10:43:47'),
(25, 'G29', 'Md Mayen Uddin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1500, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:45:15', '2026-06-05 10:45:15'),
(26, 'G30', 'md                  zillur Rahman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1349.6, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:47:25', '2026-06-05 10:47:25'),
(27, 'G31', 'md.Shahadat Hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1349.6, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:49:13', '2026-06-05 10:49:13'),
(28, 'G32', 'md. SHSRIF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1760, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:50:39', '2026-06-05 10:50:39'),
(29, 'G33', 'Masud Ralhan,Safali Akther', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1620, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:55:04', '2026-06-05 10:55:04'),
(30, 'G34', 'Billah hossin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1100, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 10:59:42', '2026-06-05 10:59:42'),
(31, 'G35', 'Hafez md. abdul Sattar ,Shopon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1400, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:03:57', '2026-06-05 11:03:57'),
(32, 'G36', 'SALIM Miah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Gran Unit', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1613.64, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:05:53', '2026-06-06 13:57:51'),
(33, 'G37', 'Abdul Rashid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1671.84, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:07:16', '2026-06-05 11:07:16'),
(34, 'G38', 'Abdul Razzak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1610, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:08:25', '2026-06-05 11:08:25'),
(35, 'G39', 'Md Shadat hossain And Mrs Begum (parvin)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1640, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:11:18', '2026-06-05 11:11:18'),
(36, 'G40', 'Abu Bokkor Siddik and Younus Ali, Delowar Hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 1617.57, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:13:49', '2026-06-05 11:13:49'),
(37, 'G41-42', 'debndro Mondol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 27402, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:15:37', '2026-06-05 11:15:37'),
(38, 'G44', 'Alesa Khatun', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Sale', 772.2, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:19:02', '2026-06-05 11:19:02'),
(39, 'G45', 'Md.Rubel Mollik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 17000, NULL, 2, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:20:44', '2026-06-05 11:23:21'),
(40, 'G46', 'Mojibur Rahaman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', 3000, NULL, 'Rent', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:22:06', '2026-06-05 11:22:06'),
(41, 'G47', 'Md  Ismail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', 9000, NULL, 'Rent', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:25:06', '2026-06-05 11:25:06'),
(42, 'G48', 'Mehadi Hasan,Sohidul Islam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Unit One', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', 4000, NULL, 'Rent', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:26:48', '2026-06-05 11:26:48'),
(43, 'F01', 'Sohidul Islam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1050, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:32:34', '2026-06-06 11:58:59'),
(44, 'F02-3', 'Md Jomir Uddin Khan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2420.68, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:36:26', '2026-06-06 11:59:19'),
(45, 'F04', 'Md Sujayet ullah ,Abul Kamal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1520, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:41:42', '2026-06-06 11:59:54'),
(46, 'F05', 'MD SHAJAHAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1760, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:42:21', '2026-06-06 11:59:35'),
(47, 'F06', 'Md. hakim Uddin Daean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1740, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:50:25', '2026-06-06 12:00:05'),
(48, 'F07', 'Hafez Md.Abu Sattar Shopon Mia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1760, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:52:39', '2026-06-06 12:00:17'),
(50, 'F08', 'Md. Salim Mai', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2000, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 11:53:51', '2026-06-06 12:00:56'),
(52, 'F09', 'Rofikul Islam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2000, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:00:21', '2026-06-06 12:01:08'),
(53, 'F10', 'Rashidui Islam Takuldar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2120, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:04:24', '2026-06-06 12:01:20'),
(54, 'F12-13', 'Khokon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 3063.84, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:07:20', '2026-06-06 12:01:39'),
(55, 'F14', 'Md Shajahan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1100, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:08:39', '2026-06-06 12:01:52'),
(56, 'F15-38', 'Md. Abu Nasar Talukdar.Abdul Kader Bhuiya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1500, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:11:59', '2026-06-06 12:02:05'),
(57, 'F17', 'Khudeja Akter(Kosum)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2300, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:14:30', '2026-06-06 12:03:02'),
(58, 'F18', 'Md. Rafikuln  Isiam (khokon)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2300, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:17:30', '2026-06-06 12:03:18'),
(59, 'F19', 'Md Abdul kadir Mia ,Kobir hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1080, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:19:44', '2026-06-06 12:04:09'),
(60, 'F20', 'Shahadat Hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2384.5, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:20:56', '2026-06-06 12:04:36'),
(61, 'F21', 'Md Omrfaruque Gazi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 12000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:23:31', '2026-06-06 12:05:25'),
(63, 'F22-23', 'Pronas Chand Das', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2610, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:29:36', '2026-06-06 12:05:47'),
(64, 'F24', 'Md nazrul Mizi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2384.5, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:32:21', '2026-06-06 11:51:51'),
(68, 'F26', 'Md Nazir Ahmad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1540, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:42:03', '2026-06-06 12:06:08'),
(69, 'F27', 'warrent officer [retd] md shajahan abdul khalek', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2160, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:48:26', '2026-06-06 12:06:36'),
(70, 'F28', 'md ismail hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2140, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 12:51:09', '2026-06-06 12:08:09'),
(71, 'F29', 'md mokter hossain titu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2140, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:31:53', '2026-06-06 12:11:10'),
(72, 'F30', 'Alamgir  hossain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2120, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:36:16', '2026-06-06 12:11:43'),
(73, 'F31', 'Md golam sarowar shaheen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2085.3, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:39:16', '2026-06-06 12:12:11'),
(74, 'F32', 'Abdul Rashid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2431, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:41:41', '2026-06-06 12:15:36'),
(75, 'F33', 'Abdul  Rashid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2394, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:43:31', '2026-06-06 12:25:09'),
(76, 'F34', 'Md Kamal Hossain Abdul Rasid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2080, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:46:04', '2026-06-06 12:25:27'),
(77, 'F35', 'Abdur Rashid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2120, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:47:32', '2026-06-06 12:25:57'),
(78, 'F36', 'Md Ali Abdur Rashid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2080, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:50:30', '2026-06-06 12:26:17'),
(79, 'F37', 'Ruma Akter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 2034.9, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:52:11', '2026-06-06 12:28:00'),
(80, 'F39', 'Md Nazim Uddin Dawan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Sale', 1080, 2, 1, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:54:11', '2026-06-06 12:28:21'),
(81, 'F L', 'Shopon mia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 1500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 13:55:42', '2026-06-06 12:28:40'),
(82, 'B R C', 'Bhuluya Royal City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 40000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 14:13:17', '2026-06-06 12:31:09'),
(83, '4TH', 'Sumch Mohammad Tarek', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 80000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 14:16:45', '2026-06-06 12:31:47'),
(84, '5TH', 'Yaminur Rahman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 67690, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 10000, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 14:23:49', '2026-06-06 12:32:07'),
(85, '6TH', 'Yaminur Rahman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 67690, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, 10000, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 14:27:42', '2026-06-06 12:32:46'),
(86, 'BG', 'Yaminur Rahman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, NULL, NULL, NULL, 'Rent', 13980, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-05 06:00:00', NULL, 1, '2026-06-05 14:29:52', '2026-06-06 12:33:54'),
(87, 'F16', 'Abul Kasem', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', '1st Unit', '1st Floor', '1st Floor', NULL, NULL, NULL, '', NULL, NULL, 'Rent', 450, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-06 06:00:00', NULL, 1, '2026-06-06 12:43:01', '2026-06-06 12:43:01'),
(88, 'Furt-1', 'Hiron', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Gran Unit', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Rent', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-06 06:00:00', NULL, 1, '2026-06-06 14:17:53', '2026-06-06 14:17:53'),
(89, 'Furt-2', 'Shalim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Gran Unit', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Rent', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-06 06:00:00', NULL, 1, '2026-06-06 14:18:58', '2026-06-06 14:18:58'),
(90, 'Sumon', 'Sumon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kassaf Shopping Center', 'Gran Unit', 'Ground Floor', 'Ground floor', NULL, NULL, NULL, '', NULL, NULL, 'Rent', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'marketadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes', '2026-06-06 06:00:00', NULL, 1, '2026-06-06 14:20:33', '2026-06-06 14:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_transactions`
--

CREATE TABLE `tbl_account_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `voucher_no` varchar(191) DEFAULT NULL,
  `voucher_type` varchar(191) DEFAULT NULL,
  `voucher_date` varchar(191) DEFAULT NULL,
  `coa_id` varchar(191) DEFAULT NULL,
  `coa_head_code` varchar(191) DEFAULT NULL,
  `unit_id` varchar(191) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `debit_amount` varchar(191) DEFAULT NULL,
  `credit_amount` varchar(191) DEFAULT NULL,
  `posted` varchar(191) DEFAULT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `approve_by` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `delete` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_account_transactions`
--

INSERT INTO `tbl_account_transactions` (`id`, `voucher_no`, `voucher_type`, `voucher_date`, `coa_id`, `coa_head_code`, `unit_id`, `narration`, `debit_amount`, `credit_amount`, `posted`, `approve`, `approve_by`, `active`, `delete`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'autocoll-1', 'CV', '2026-06-02', NULL, '30101', 'Unit One', NULL, '0', '0', 'I', 1, NULL, 1, 0, 1, NULL, NULL, NULL, NULL),
(2, 'autocoll-1', 'CV', '2026-06-02', NULL, '30102', 'Unit One', NULL, '0', '17530', 'I', 1, NULL, 1, 0, 1, NULL, NULL, NULL, NULL),
(3, 'autocoll-1', 'CV', '2026-06-02', NULL, NULL, 'Unit One', NULL, '17530', '0', 'I', 1, NULL, 1, 0, 1, NULL, '2026-06-02 05:54:52', NULL, '2026-06-02 05:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coa`
--

CREATE TABLE `tbl_coa` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_code` varchar(191) DEFAULT NULL,
  `head_name` varchar(191) DEFAULT NULL,
  `parent_head_name` varchar(191) DEFAULT NULL,
  `head_level` varchar(191) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `transaction` tinyint(4) NOT NULL DEFAULT 0,
  `general_ledger` tinyint(4) NOT NULL DEFAULT 0,
  `head_type` varchar(191) DEFAULT NULL,
  `budget_type` varchar(255) DEFAULT NULL,
  `budget` tinyint(4) NOT NULL,
  `depreciation` tinyint(4) NOT NULL,
  `depreciation_rate` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_coa`
--

INSERT INTO `tbl_coa` (`id`, `head_code`, `head_name`, `parent_head_name`, `head_level`, `active`, `transaction`, `general_ledger`, `head_type`, `budget_type`, `budget`, `depreciation`, `depreciation_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Assets', 'COA', '0', 1, 0, 0, 'A', NULL, 0, 0, '0.00', 1, NULL, NULL),
(32, '2', 'Liabilities', 'COA', '0', 1, 0, 0, 'L', NULL, 0, 0, '0.00', 1, NULL, NULL),
(50, '3', 'Income', 'COA', '0', 1, 0, 0, 'I', NULL, 0, 0, '0.00', 1, NULL, NULL),
(56, '4', 'Expence', 'COA', '0', 1, 0, 0, 'E', NULL, 0, 0, '0.00', 1, NULL, NULL),
(282, '101', 'Non-Current Assets', 'Assets', '1', 1, 0, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 07:03:36', '2025-02-20 08:53:11'),
(283, '102', 'Current Assets', 'Assets', '1', 1, 0, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 08:53:06', '2025-02-20 08:53:06'),
(284, '201', 'Shareholders Equity', 'Liabilities', '1', 1, 0, 1, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 08:54:09', '2025-02-20 11:13:00'),
(285, '202', 'Liabilities and Provisions', 'Liabilities', '1', 1, 0, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 08:54:24', '2025-02-20 08:54:24'),
(286, '10101', 'Property,Plant and Equipments', 'Non-Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:08:43', '2025-02-20 11:08:43'),
(287, '1010101', 'Furniture and Fixtures', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:08:57', '2025-02-20 11:08:57'),
(288, '1010102', 'Building', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:07', '2025-02-20 11:09:07'),
(289, '1010103', 'Land', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:15', '2025-02-20 11:09:15'),
(290, '1010104', 'IT Equepment', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:23', '2025-02-20 11:09:23'),
(291, '1010105', 'Computer & others', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:32', '2025-02-20 11:09:32'),
(292, '1010106', 'Software', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:39', '2025-02-20 11:09:39'),
(293, '1010107', 'Web site', 'Property,Plant and Equipments', '3', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:09:47', '2025-02-20 11:09:47'),
(294, '10102', 'Intangible assets', 'Non-Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:10:07', '2025-02-20 11:10:07'),
(295, '10103', 'Long-term investments', 'Non-Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:10:20', '2025-02-20 11:10:20'),
(296, '10204', 'All Advance & pre payments', 'Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:10:42', '2025-02-20 11:10:42'),
(297, '10205', 'Accounts Receivable', 'Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:10:54', '2025-02-20 11:10:54'),
(298, '10206', 'Cash and Cash Equivalents', 'Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:11:05', '2025-02-20 11:11:05'),
(299, '1020601', 'Cash at Bank', 'Cash and Cash Equivalents', '3', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:11:14', '2025-02-23 04:46:49'),
(300, '1020602', 'Cash in hand', 'Cash and Cash Equivalents', '3', 1, 1, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:11:42', '2025-02-23 04:46:43'),
(301, '10207', 'Others', 'Current Assets', '2', 1, 0, 1, 'A', NULL, 0, 0, NULL, 1, '2025-02-20 11:12:06', '2025-02-20 11:12:06'),
(302, '20101', 'Retained Earnings', 'Shareholders Equity', '2', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:13:21', '2025-02-20 11:13:21'),
(303, '20102', 'Net Income', 'Shareholders Equity', '2', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:13:33', '2025-02-20 11:13:33'),
(304, '20103', 'Drawings', 'Shareholders Equity', '2', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:13:42', '2025-02-20 11:13:42'),
(305, '20201', 'Non Curreent Liabilities', 'Liabilities and Provisions', '2', 1, 0, 1, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:14:03', '2025-02-20 11:14:03'),
(306, '2020101', 'Loan from Financial institute', 'Non Curreent Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:14:19', '2025-02-20 11:14:19'),
(307, '2020102', 'Deferred tax liabilities', 'Non Curreent Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:14:31', '2025-02-20 11:14:31'),
(308, '2020103', 'Long-term debt ( Mortgage)', 'Non Curreent Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:14:40', '2025-02-20 11:14:40'),
(309, '20202', 'Current Liabilities', 'Liabilities and Provisions', '2', 1, 0, 1, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:15:13', '2025-02-20 11:15:13'),
(310, '2020201', 'Loan from inter concern', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:15:25', '2025-02-20 11:15:25'),
(311, '2020202', 'personal loan from Honorable Chairman sir', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:15:34', '2025-02-20 11:15:34'),
(312, '2020203', 'MA Hasem & Yeatun Nesa Fundation', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:15:42', '2025-02-20 11:15:42'),
(313, '2020204', 'Accounts Payable', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:15:53', '2025-02-20 11:15:53'),
(314, '2020205', 'Accrued liabilities', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:16:04', '2025-02-20 11:16:04'),
(315, '2020206', 'Short-term loans', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:16:13', '2025-02-20 11:16:13'),
(316, '2020207', 'Unearned revenue', 'Current Liabilities', '3', 1, 1, 0, 'L', NULL, 0, 0, NULL, 1, '2025-02-20 11:16:21', '2025-02-20 11:16:21'),
(317, '301', 'Income from Service Revenue', 'Income', '1', 1, 0, 0, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:17:32', '2025-02-20 11:17:32'),
(318, '30101', 'Jamidary Bill', 'Income from Service Revenue', '2', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:18:01', '2025-02-20 11:18:01'),
(322, '30102', 'Electricity Bill', 'Income from Service Revenue', '2', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:21:08', '2025-02-20 11:21:08'),
(323, '30103', 'Service  Charge', 'Income from Service Revenue', '2', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:21:26', '2025-02-20 11:21:26'),
(324, '30104', '10% Requisition Premium Money', 'Income from Service Revenue', '2', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:21:48', '2025-02-20 11:21:48'),
(325, '30105', 'Rental Income', 'Income from Service Revenue', '2', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:22:33', '2025-02-20 11:22:33'),
(326, '30106', 'Income from Lift Instalation', 'Income from Service Revenue', '2', 1, 1, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:23:08', '2025-02-20 11:23:08'),
(327, '30107', 'Income from AC Instalation', 'Income from Service Revenue', '2', 1, 1, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:23:23', '2025-02-20 11:23:23'),
(328, '309', 'Income from Sales', 'Income', '1', 1, 0, 1, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:23:47', '2025-02-20 11:23:47'),
(329, '30901', 'Shop Sales', 'Income from Sales', '2', 1, 1, 0, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:23:57', '2025-02-20 11:23:57'),
(330, '30902', 'Sales from Others', 'Income from Sales', '2', 1, 1, 0, 'I', NULL, 0, 0, NULL, 1, '2025-02-20 11:24:06', '2025-02-20 11:24:06'),
(331, '401', 'Operating Expensess', 'Expence', '1', 1, 0, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:24:43', '2025-02-20 11:24:43'),
(332, '40101', 'Admistrative Expensess', 'Operating Expensess', '2', 1, 0, 1, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:01', '2025-02-20 11:25:01'),
(333, '40102', 'Selling Expensess', 'Operating Expensess', '2', 1, 0, 1, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:14', '2025-02-20 11:25:14'),
(334, '4010101', 'Salary & Allowance', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:29', '2025-02-20 11:25:29'),
(335, '4010102', 'Remmunaration', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:39', '2025-02-20 11:25:39'),
(336, '4010103', 'Electricity Bill', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:47', '2025-02-20 11:25:47'),
(337, '4010104', 'Electricity Bill (MA Hasem Bhaban)', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:25:56', '2025-02-20 11:25:56'),
(338, '4010105', 'Conveyance', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:26:07', '2025-02-20 11:26:07'),
(339, '4010106', 'Gas Bill (MA Hasem Bhaban)', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:26:27', '2025-02-20 11:26:27'),
(340, '4010107', 'Photocopy Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:26:47', '2025-02-20 11:26:47'),
(341, '4010108', 'Entertainment', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:26:55', '2025-02-20 11:26:55'),
(342, '4010109', 'Printing & Stationary', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:27:04', '2025-02-20 11:27:04'),
(343, '4010110', 'Mobile BIll', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:27:13', '2025-02-20 11:27:13'),
(344, '4010111', 'Repair & Maintanance', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:27:28', '2025-02-20 11:27:28'),
(345, '4010112', 'Electric Goods', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:27:34', '2025-02-20 11:27:34'),
(346, '4010113', 'Construction Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:27:46', '2025-02-20 11:27:46'),
(347, '4010114', 'Miscellaneous Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:04', '2025-02-20 11:28:04'),
(348, '4010115', 'Gift, Tips & Donation', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:11', '2025-02-20 11:28:11'),
(349, '4010116', 'Fine waived', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:18', '2025-02-20 11:28:18'),
(350, '4010117', 'Utility Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:26', '2025-02-20 11:28:26'),
(351, '4010118', 'Tours & Travel', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:33', '2025-02-20 11:28:33'),
(352, '4010119', 'Domin & Hosting', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:41', '2025-02-20 11:28:41'),
(353, '4010120', 'Software Bill', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:48', '2025-02-20 11:28:48'),
(354, '4010121', 'Security Bill', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:28:56', '2025-02-20 11:28:56'),
(355, '4010122', 'Internet Bill', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:04', '2025-02-20 11:29:04'),
(356, '4010123', 'Legal Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:11', '2025-02-20 11:29:11'),
(357, '4010124', 'Labour & Wages', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:21', '2025-02-20 11:29:21'),
(358, '4010125', 'IT Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:29', '2025-02-20 11:29:29'),
(359, '4010126', 'Bonus', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:37', '2025-02-20 11:29:37'),
(360, '4010127', 'Oil, Fuel & Gas', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:29:45', '2025-02-20 11:29:45'),
(361, '4010128', 'Rent', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:30:01', '2025-02-20 11:30:01'),
(362, '4010129', 'Depreciation Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:30:08', '2025-02-20 11:30:08'),
(363, '4010130', 'Cleaning Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:30:16', '2025-02-20 11:30:16'),
(364, '4010131', 'Office Exp.', 'Admistrative Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:30:23', '2025-02-20 11:30:23'),
(365, '4010201', 'Advertisement', 'Selling Expensess', '3', 1, 1, 0, 'E', NULL, 0, 0, NULL, 1, '2025-02-20 11:30:50', '2025-02-20 11:30:50'),
(366, '102060101', 'IBBL-AC/No-2996', 'Cash at Bank', '4', 1, 1, 0, 'A', NULL, 0, 0, NULL, 1, '2025-02-25 05:50:22', '2025-02-25 05:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_menu` varchar(100) DEFAULT NULL,
  `menu_name` varchar(100) DEFAULT NULL,
  `menu_link` text DEFAULT NULL,
  `menu_icon` varchar(100) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `parent_menu`, `menu_name`, `menu_link`, `menu_icon`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dashboard', 'admin.index', 'fa fa-bars', 1, '1', '2020-07-08 23:22:23', '2021-01-05 04:02:48'),
(2, '13', 'Menu', 'menu.index', 'fa fa-caret', 1, '1', NULL, NULL),
(3, '13', 'Users Role', 'userRole.index', 'fa fa-bars', 4, '1', '2020-03-03 13:48:57', '2020-03-15 06:02:37'),
(4, '13', 'Menu Action Type', 'menuActionType.index', 'fa fa-bars', 2, '1', NULL, NULL),
(5, '13', 'User', 'user.index', 'fa fa-bars', 3, '1', '2020-03-14 02:06:15', '2020-03-15 06:02:33'),
(6, NULL, 'Front-End Management', 'admin.index', 'fa fa-bars', 100, '0', '2020-04-16 09:54:08', '2022-05-11 10:34:44'),
(7, '6', 'Website Information', 'websiteInformation.index', 'fa fa-caret', 1, '1', '2020-04-16 10:43:15', '2020-04-16 10:43:15'),
(8, '6', 'Menus', 'frontEndMenu.index', NULL, 2, '1', '2020-04-18 08:17:03', '2020-04-18 08:17:03'),
(10, '6', 'Social Links', 'socialLink.index', 'fa fa-caret', 3, '1', '2020-04-18 10:14:20', '2020-04-18 10:14:20'),
(11, '6', 'Sliders', 'sliders.index', 'fa fa-bars', 4, '1', '2020-04-19 08:19:58', '2020-04-19 08:19:58'),
(12, '6', 'Pages', 'page.index', 'fa fa-caret', 5, '1', '2020-05-10 05:09:10', '2020-05-10 05:09:10'),
(13, NULL, 'User Management', 'admin.index', 'fa fa-bars', 9, '1', NULL, '2022-05-11 02:48:40'),
(15, '13', 'Admin Information', 'adminPanelInformation.index', 'fa fa-bars', 5, '1', '2020-07-09 00:45:20', '2020-07-09 00:45:20'),
(16, NULL, 'System Setup', 'admin.index', NULL, 2, '1', '2020-09-07 05:27:51', '2022-05-11 02:48:12'),
(17, '16', 'Floor Setup', 'floorSetup.index', NULL, 1, '1', '2020-09-07 05:28:38', '2020-09-07 05:28:38'),
(18, '16', 'Unit Setup', 'unitSetup.index', NULL, 2, '1', '2020-09-07 06:17:49', '2020-09-07 06:17:49'),
(19, '16', 'Utility Setup', 'utilitySetup.index', NULL, 3, '1', '2020-09-07 06:18:11', '2020-09-07 06:18:11'),
(20, NULL, 'New Project', 'newProject.index', NULL, 97, '0', '2020-09-07 09:00:28', '2026-06-06 06:28:19'),
(21, NULL, 'Position Agreement', 'admin.index', NULL, 3, '1', '2020-12-30 01:22:30', '2022-05-11 05:40:12'),
(22, '21', 'Position Information', 'positionInformation.index', NULL, 1, '1', '2020-12-30 01:23:05', '2020-12-30 01:42:29'),
(23, '21', 'Client List', 'tenant.list.index', NULL, 3, '1', '2020-12-30 01:23:29', '2022-09-04 22:51:13'),
(24, NULL, 'Bill Prepare', 'admin.index', NULL, 3, '1', '2020-12-30 01:23:50', '2021-01-03 01:44:15'),
(25, '24', 'Jamidari Prepare', 'jamidari.prepare.index', NULL, 1, '1', '2020-12-30 01:24:53', '2020-12-30 01:24:53'),
(26, '24', 'Electricity Bill Prepare', 'ebill.prepare.index', NULL, 2, '1', '2020-12-30 01:30:54', '2021-01-02 00:22:29'),
(27, '24', 'Service Charge Prepare', 'service.charge.prepare', NULL, 3, '1', '2020-12-30 01:31:43', '2021-01-04 02:28:53'),
(28, NULL, 'Reports', 'admin.index', NULL, 6, '1', '2020-12-30 01:32:29', '2022-05-11 02:49:40'),
(30, '28', 'Collection Report', 'collection.report', NULL, 4, '1', '2020-12-30 01:33:24', '2021-01-05 04:05:39'),
(32, '52', 'Jamidari Register', 'jamidari.register.index', NULL, 1, '1', '2020-12-30 01:34:05', '2021-01-11 04:11:50'),
(33, '52', 'Electric Bill Register', 'electric.bill.register', NULL, 2, '1', '2020-12-30 01:34:30', '2021-01-11 04:12:03'),
(34, '52', 'Service Charge Register', 'service.charge.register', NULL, 3, '1', '2020-12-30 01:35:11', '2021-01-11 04:12:08'),
(43, '24', 'Water Bill Prepare', 'wbill.prepare.index', NULL, 2, '1', '2020-12-30 01:30:54', '2021-01-02 00:22:29'),
(44, NULL, 'Bill Collection', 'admin.index', NULL, 4, '1', '2021-01-03 01:43:10', '2022-05-11 02:49:39'),
(45, '44', 'By Code', 'collection.add.bycode', NULL, 1, '1', '2021-01-03 01:45:52', '2021-01-03 01:45:52'),
(46, '44', 'By BarCode', 'collection.add.bybarcode', NULL, 2, '0', '2021-01-03 01:46:32', '2026-06-06 08:45:08'),
(47, '28', 'Collection Demand', 'collection.summary.report', NULL, 5, '1', '2021-01-05 03:25:05', '2022-05-11 05:41:20'),
(48, '28', 'Jamidari Due Report', 'jamidari.due.report', NULL, 6, '1', '2021-01-05 04:13:33', '2021-01-05 04:13:33'),
(49, '28', 'Utility Due Report', 'service.due.report', NULL, 7, '1', '2021-01-05 04:13:54', '2021-01-05 04:13:54'),
(50, '28', 'EBill Reading Sheet', 'ebill.reading.sheet', NULL, 1, '1', '2021-01-07 00:32:32', '2022-05-11 05:42:45'),
(51, '52', 'Water Bill Register', 'water.bill.register', NULL, 4, '1', '2021-01-08 23:44:19', '2021-01-11 04:12:13'),
(52, NULL, 'Bill Register', 'admin.index', NULL, 5, '1', '2021-01-11 04:11:28', '2022-05-11 05:40:40'),
(53, NULL, 'Reprint', 'admin.index', NULL, 7, '1', '2021-01-21 00:16:23', '2021-01-21 00:18:03'),
(54, '53', 'Jamidari', 'jamidari.reprint.view', NULL, 1, '1', '2021-01-21 00:16:34', '2021-01-21 00:16:34'),
(55, '53', 'Utility', 'ebill.reprint.view', NULL, 2, '1', '2021-01-21 00:16:50', '2021-02-03 00:02:15'),
(56, NULL, 'General Accounting', 'admin.index', NULL, 8, '0', '2022-04-30 10:30:46', '2026-06-06 06:28:16'),
(57, '56', 'Transaction', 'admin.index', NULL, 1, '1', '2022-04-30 10:31:28', '2022-04-30 10:31:28'),
(58, '56', 'Reports', 'admin.index', NULL, 2, '1', '2022-04-30 10:31:39', '2022-04-30 10:31:39'),
(59, '57', 'Chart of Accounts', 'coaSetup.index', NULL, 1, '1', '2022-04-30 10:32:39', '2022-04-30 10:32:39'),
(60, '57', 'Debit Voucher Entry', 'debitEntry.index', NULL, 2, '1', '2022-04-30 10:33:21', '2022-04-30 10:33:21'),
(61, '57', 'Voucher Approve', 'voucherApprove.index', NULL, 5, '1', '2022-04-30 10:35:54', '2022-05-17 00:11:05'),
(62, '57', 'Credit Voucher Entry', 'creditEntry.index', NULL, 3, '1', '2022-04-30 10:36:10', '2022-05-17 00:10:37'),
(63, '57', 'Journal Voucher Entry', 'journalEntry.index', NULL, 4, '1', '2022-04-30 10:37:48', '2025-01-05 06:00:02'),
(66, '58', 'Daily Voucher List', 'voucherList.index', NULL, 1, '1', '2022-04-30 11:10:04', '2022-04-30 11:10:04'),
(67, '58', 'Daily Cash Book', 'cashBook.index', NULL, 2, '1', '2022-04-30 11:10:27', '2022-04-30 11:10:27'),
(68, '58', 'Daily Bank Book', 'bankBook.index', NULL, 3, '1', '2022-04-30 11:10:41', '2022-04-30 11:10:41'),
(69, '58', 'Transaction Ledger', 'transactionLedger.index', NULL, 4, '1', '2022-04-30 11:11:17', '2022-04-30 11:11:17'),
(70, '58', 'General Ledger', 'generalLedger.index', NULL, 5, '1', '2022-04-30 11:12:04', '2022-04-30 11:12:04'),
(71, '58', 'Income Statement', 'incomeStatement.index', NULL, 6, '1', '2022-04-30 11:12:25', '2022-04-30 11:12:25'),
(72, '58', 'Trial Balance', 'trialBalance.index', NULL, 7, '1', '2022-04-30 11:12:42', '2022-04-30 11:12:42'),
(73, '58', 'Balance Sheet', 'balanceSheet.index', NULL, 8, '1', '2022-04-30 11:12:57', '2022-04-30 11:12:57'),
(74, '44', 'Collection Deposit', 'collectionDeposit.index', NULL, 3, '0', '2022-05-07 11:27:05', '2026-06-06 08:45:11'),
(75, '28', 'Collection Status Report', 'collectionDeposit.report', NULL, 9, '1', '2022-05-08 09:30:08', '2022-05-11 02:41:37'),
(76, '28', 'Jamidari Increase Status', 'jamidariIncrease.report', NULL, 10, '1', '2022-05-10 06:55:52', '2022-05-11 05:43:11'),
(77, '21', 'Rent Increment', 'rent.increment', NULL, 2, '1', '2022-09-04 22:50:58', '2022-09-04 22:50:58'),
(78, '56', 'Daily Income Expense', 'daily.income.expense', NULL, 3, '1', '2022-11-27 12:21:56', '2022-11-27 12:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_actions`
--

CREATE TABLE `tbl_menu_actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_menu_id` int(11) DEFAULT NULL,
  `menu_type` int(11) DEFAULT NULL,
  `action_name` varchar(100) DEFAULT NULL,
  `action_link` varchar(100) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_menu_actions`
--

INSERT INTO `tbl_menu_actions` (`id`, `parent_menu_id`, `menu_type`, `action_name`, `action_link`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'Add', 'menu.add', 1, 1, NULL, NULL),
(3, 2, 2, 'Edit', 'menu.edit', 2, 1, NULL, NULL),
(4, 2, 3, 'Status', 'menu.status', 3, 1, NULL, NULL),
(5, 2, 8, 'View Menu Action', 'menuAction.index', 4, 1, NULL, NULL),
(6, 2, 4, 'Delete', 'menu.delete', 5, 1, NULL, NULL),
(7, 4, 1, 'Add', 'menuActionType.add', 1, 1, NULL, NULL),
(8, 4, 2, 'Edit', 'menuActionType.edit', 2, 1, NULL, NULL),
(9, 4, 3, 'Status', 'menuActionType.status', 3, 1, NULL, NULL),
(10, 4, 4, 'Delete', 'menuActionType.delete', 4, 1, NULL, NULL),
(11, 3, 1, 'Add', 'userRole.add', 1, 1, '2020-03-06 23:37:18', '2020-03-06 23:37:18'),
(12, 3, 2, 'Edit', 'userRole.edit', 2, 1, '2020-03-07 00:16:00', '2020-03-07 00:16:00'),
(13, 3, 5, 'Permission', 'userRole.permission', 3, 1, '2020-03-07 00:17:25', '2020-03-07 00:17:25'),
(14, 3, 3, 'Status', 'userRole.status', 4, 1, '2020-03-07 00:18:08', '2020-03-07 00:18:08'),
(15, 3, 4, 'Delete', 'userRole.delete', 5, 1, '2020-03-07 00:18:22', '2020-03-07 00:18:22'),
(21, 5, 1, 'Add', 'user.add', 1, 1, '2020-03-14 02:06:39', '2020-03-14 02:06:39'),
(22, 5, 2, 'Edit', 'user.edit', 2, 1, '2020-03-14 02:06:53', '2020-03-14 02:06:53'),
(23, 5, 8, 'View Profile', 'user.profile', 3, 1, '2020-03-14 02:07:32', '2020-03-14 02:07:32'),
(24, 5, 6, 'Change Password', 'user.changePassword', 4, 1, '2020-03-14 02:07:57', '2020-03-14 02:07:57'),
(25, 5, 3, 'Status', 'user.status', 5, 1, '2020-03-14 02:08:23', '2020-03-14 02:08:23'),
(26, 5, 4, 'Delete', 'user.delete', 6, 1, '2020-03-14 02:08:35', '2020-03-14 02:08:35'),
(28, 7, 1, 'Add', 'websiteInformation.add', 1, 1, '2020-04-16 11:50:12', '2020-04-16 11:50:12'),
(29, 7, 2, 'Edit', 'websiteInformation.edit', 2, 1, '2020-04-16 11:50:28', '2020-04-16 11:50:28'),
(30, 8, 1, 'Add', 'frontEndMenu.add', 1, 1, '2020-04-18 08:18:00', '2020-04-18 08:18:00'),
(31, 8, 2, 'Edit', 'frontEndMenu.edit', 2, 1, '2020-04-18 08:18:14', '2020-04-18 08:18:14'),
(32, 8, 3, 'Status', 'frontEndMenu.status', 3, 1, '2020-04-18 08:20:33', '2020-04-18 08:20:33'),
(33, 8, 4, 'Delete', 'frontEndMenu.delete', 4, 1, '2020-04-18 08:20:48', '2020-04-18 08:20:48'),
(39, 10, 1, 'Add', 'socialLink.add', 1, 1, '2020-04-18 10:14:43', '2020-04-18 10:14:43'),
(40, 10, 2, 'Edit', 'socialLink.edit', 2, 1, '2020-04-18 10:14:54', '2020-04-18 10:14:54'),
(41, 10, 3, 'Status', 'socialLink.status', 3, 1, '2020-04-18 10:15:15', '2020-04-18 10:15:15'),
(42, 10, 4, 'Delete', 'socialLink.delete', 4, 1, '2020-04-18 10:15:32', '2020-04-18 10:15:32'),
(43, 11, 1, 'Add', 'sliders.add', 1, 1, '2020-04-19 08:20:24', '2020-04-19 08:20:24'),
(44, 11, 2, 'Edit', 'sliders.edit', 2, 1, '2020-04-19 08:20:39', '2020-04-19 08:20:39'),
(45, 11, 3, 'Status', 'sliders.status', 3, 1, '2020-04-19 08:20:59', '2020-04-19 08:20:59'),
(46, 11, 4, 'Delete', 'sliders.delete', 4, 1, '2020-04-19 08:21:14', '2020-04-19 08:21:14'),
(47, 12, 1, 'Add', 'page.add', 1, 1, '2020-05-10 05:09:46', '2020-05-10 05:09:46'),
(48, 12, 2, 'Edit', 'page.edit', 2, 1, '2020-05-10 05:09:58', '2020-05-10 05:09:58'),
(49, 12, 3, 'Status', 'page.status', 3, 1, '2020-05-10 05:10:22', '2020-05-10 05:10:22'),
(50, 12, 8, 'View Posts', 'post.index', 4, 1, '2020-05-10 05:11:48', '2020-05-10 05:11:48'),
(51, 12, 4, 'Delete', 'page.delete', 5, 1, '2020-05-10 05:12:01', '2020-05-10 05:12:01'),
(52, 15, 1, 'Add', 'adminPanelInformation.add', 1, 1, '2020-07-09 00:45:42', '2020-07-09 00:45:42'),
(53, 15, 2, 'Edit', 'adminPanelInformation.edit', 2, 1, '2020-07-09 00:45:50', '2020-07-09 00:45:50'),
(54, 17, 1, 'Add', 'floorSetup.add', 1, 1, '2020-09-07 05:28:57', '2020-09-07 05:28:57'),
(55, 17, 2, 'Edit', 'floorSetup.edit', 2, 1, '2020-09-07 05:29:07', '2020-09-07 05:29:07'),
(56, 17, 3, 'Status', 'floorSetup.status', 3, 1, '2020-09-07 05:29:17', '2020-09-07 05:29:17'),
(57, 17, 4, 'Delete', 'floorSetup.delete', 4, 1, '2020-09-07 05:29:26', '2020-09-07 05:29:26'),
(58, 19, 1, 'Add', 'utilitySetup.add', 1, 1, '2020-09-07 06:18:30', '2020-09-07 06:18:30'),
(59, 19, 2, 'Edit', 'utilitySetup.edit', 2, 1, '2020-09-07 06:18:40', '2020-09-07 06:18:40'),
(60, 19, 3, 'Status', 'utilitySetup.status', 3, 1, '2020-09-07 06:18:48', '2020-09-07 06:18:48'),
(61, 19, 4, 'Delete', 'utilitySetup.delete', 4, 1, '2020-09-07 06:18:56', '2020-09-07 06:18:56'),
(62, 18, 1, 'Add', 'unitSetup.add', 1, 1, '2020-09-07 06:19:25', '2020-09-07 06:19:25'),
(63, 18, 2, 'Edit', 'unitSetup.edit', 2, 1, '2020-09-07 06:19:35', '2020-09-07 06:19:35'),
(64, 18, 3, 'Status', 'unitSetup.status', 3, 1, '2020-09-07 06:19:46', '2020-09-07 06:19:46'),
(65, 18, 4, 'Delete', 'unitSetup.delete', 4, 1, '2020-09-07 06:19:55', '2020-09-07 06:19:55'),
(66, 20, 1, 'Add', 'newProject.add', 1, 1, '2020-09-07 09:02:10', '2020-09-07 09:02:10'),
(67, 20, 2, 'Edit', 'newProject.edit', 2, 1, '2020-09-07 09:02:18', '2020-09-07 09:02:18'),
(68, 20, 3, 'Status', 'newProject.status', 3, 1, '2020-09-07 09:02:26', '2020-09-07 09:02:26'),
(69, 20, 4, 'Delete', 'newProject.delete', 4, 1, '2020-09-07 09:02:36', '2020-09-07 09:02:36'),
(70, 22, 1, 'Add', 'positionInformation.add', 1, 1, '2020-12-30 01:42:49', '2020-12-30 01:42:49'),
(71, 22, 2, 'Edit', 'positionInformation.edit', 2, 1, '2020-12-30 01:43:05', '2020-12-30 01:43:05'),
(72, 22, 4, 'Delete', 'positionInformation.delete', 5, 1, '2020-12-30 01:43:20', '2021-01-04 01:23:35'),
(73, 22, 3, 'Status', 'positionInformation.status', 4, 1, '2020-12-30 01:43:37', '2020-12-30 01:43:37'),
(74, 25, 1, 'Add', 'jamidari.prepare.add', 1, 1, '2020-12-31 06:54:15', '2020-12-31 06:54:15'),
(75, 25, 8, 'View', 'jamidari.prepare.view', 2, 1, '2020-12-31 06:55:11', '2020-12-31 06:55:11'),
(76, 25, 4, 'Delete', 'jamidari.prepare.delete', 4, 1, '2020-12-31 06:55:34', '2021-01-03 23:08:21'),
(77, 26, 1, 'Add', 'ebill.prepare.add', 1, 1, '2021-01-02 00:22:54', '2021-01-02 00:22:54'),
(78, 26, 8, 'View', 'ebill.prepare.view', 2, 1, '2021-01-02 00:23:10', '2021-01-02 00:23:10'),
(79, 26, 4, 'Delete', 'ebill.prepare.delete', 4, 1, '2021-01-02 00:23:21', '2021-01-04 03:36:24'),
(80, 43, 1, 'Add', 'wbill.prepare.add', 1, 1, '2021-01-02 00:22:54', '2021-01-02 00:22:54'),
(81, 43, 8, 'View', 'wbill.prepare.view', 2, 1, '2021-01-02 00:23:10', '2021-01-02 00:23:10'),
(82, 43, 4, 'Delete', 'wbill.prepare.delete', 4, 1, '2021-01-02 00:23:21', '2021-01-04 23:10:49'),
(83, 25, 11, 'Print', 'jamidari.prepare.print', 3, 1, '2021-01-03 23:07:30', '2021-01-03 23:08:23'),
(84, 22, 8, 'View', 'positionInformation.view', 3, 1, '2021-01-04 01:22:16', '2021-01-04 01:23:36'),
(85, 27, 4, 'Delete', 'service.charge.prepare.delete', 4, 1, '2021-01-04 02:33:25', '2021-01-04 23:13:08'),
(86, 27, 8, 'View', 'service.charge.prepare.view', 1, 1, '2021-01-04 02:53:32', '2021-01-04 02:53:32'),
(87, 26, 11, 'Print', 'ebill.prepare.print', 3, 1, '2021-01-04 03:32:00', '2021-01-04 03:36:26'),
(88, 43, 11, 'Print', 'wbill.prepare.print', 3, 1, '2021-01-04 23:09:34', '2021-01-04 23:10:48'),
(89, 27, 11, 'Print', 'service.prepare.print', 3, 1, '2021-01-04 23:12:52', '2021-01-04 23:13:09'),
(90, 60, 1, 'Add', 'debitEntry.add', 1, 1, '2022-04-30 10:33:55', '2022-04-30 10:33:55'),
(91, 60, 2, 'Edit', 'debitEntry.edit', 2, 1, '2022-04-30 10:34:03', '2022-04-30 10:34:03'),
(92, 60, 8, 'View Debit Entry', 'debitEntry.view', 3, 1, '2022-04-30 10:34:20', '2022-04-30 10:34:20'),
(93, 60, 11, 'Print Debit Voucher', 'journalEntry.printDebitVoucher', 4, 1, '2022-04-30 10:34:31', '2022-04-30 10:34:31'),
(94, 60, 4, 'Delete', 'debitEntry.delete', 5, 1, '2022-04-30 10:34:43', '2022-04-30 10:34:43'),
(95, 60, 3, 'Publish', 'debitEntry.publish', 6, 1, '2022-04-30 10:35:14', '2022-04-30 10:46:43'),
(96, 62, 1, 'Add', 'creditEntry.add', 1, 1, '2022-04-30 10:36:33', '2022-04-30 10:36:33'),
(97, 62, 2, 'Edit', 'creditEntry.edit', 2, 1, '2022-04-30 10:36:40', '2022-04-30 10:36:40'),
(98, 62, 8, 'View Credit Entry', 'creditEntry.view', 3, 1, '2022-04-30 10:36:58', '2022-04-30 10:36:58'),
(99, 62, 11, 'Print Credit Voucher', 'journalEntry.printCreditVoucher', 4, 1, '2022-04-30 10:37:08', '2022-04-30 10:37:08'),
(100, 62, 4, 'Delete', 'creditEntry.delete', 5, 1, '2022-04-30 10:37:17', '2022-04-30 10:37:17'),
(101, 62, 3, 'Status', 'creditEntry.publish', 6, 1, '2022-04-30 10:37:27', '2022-04-30 10:37:27'),
(102, 63, 1, 'Add', 'journalEntry.add', 1, 1, '2022-04-30 10:38:53', '2022-04-30 10:38:53'),
(103, 63, 2, 'Edit', 'journalEntry.edit', 2, 1, '2022-04-30 10:39:00', '2022-04-30 10:39:00'),
(104, 63, 8, 'View Journal Entry', 'journalEntry.view', 3, 1, '2022-04-30 10:39:15', '2022-04-30 10:39:47'),
(105, 63, 11, 'Print Journal Voucher', 'journalEntry.printJournalVoucher', 4, 1, '2022-04-30 10:39:23', '2022-04-30 10:39:56'),
(106, 63, 4, 'Delete', 'journalEntry.delete', 5, 1, '2022-04-30 10:40:10', '2022-04-30 10:40:10'),
(107, 63, 3, 'Publish', 'journalEntry.publish', 6, 1, '2022-04-30 10:40:20', '2022-04-30 10:40:20'),
(108, 65, 1, 'Add', 'reconciliationEntry.add', 1, 1, '2022-04-30 10:42:56', '2022-04-30 10:42:56'),
(109, 65, 2, 'Edit', 'reconciliationEntry.edit', 2, 1, '2022-04-30 10:43:05', '2022-04-30 10:43:05'),
(110, 65, 8, 'View', 'reconciliationEntry.view', 3, 1, '2022-04-30 10:43:15', '2022-04-30 10:43:15'),
(111, 65, 3, 'Publish', 'reconciliationEntry.publish', 4, 1, '2022-04-30 10:43:24', '2022-04-30 10:43:24'),
(112, 65, 4, 'Delete', 'reconciliationEntry.delete', 5, 1, '2022-04-30 10:43:32', '2022-04-30 10:43:32'),
(113, 65, 11, 'Print', 'reconciliationEntry.printJournalVoucher', 6, 1, '2022-04-30 10:43:46', '2022-04-30 10:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_action_type`
--

CREATE TABLE `tbl_menu_action_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_menu_action_type`
--

INSERT INTO `tbl_menu_action_type` (`id`, `name`, `action_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Add', 1, 1, '2020-03-05 13:42:26', '2020-03-05 13:42:26'),
(2, 'Edit', 2, 1, '2020-03-05 13:43:02', '2020-03-05 13:43:02'),
(3, 'Publication Status', 3, 1, '2020-03-05 13:49:41', '2020-03-05 13:49:41'),
(4, 'Delete', 4, 1, '2020-03-05 13:51:00', '2020-03-05 13:51:00'),
(6, 'Permission', 5, 1, '2020-03-06 02:11:00', '2020-03-06 02:11:00'),
(7, 'Change Password', 6, 1, '2020-03-06 02:11:38', '2020-03-06 02:12:58'),
(8, 'View PopUp', 7, 1, '2020-03-06 02:11:59', '2020-03-06 02:11:59'),
(9, 'View', 8, 1, '2020-03-06 02:12:09', '2020-03-06 02:12:09'),
(10, 'Shipping Status', 9, 1, '2020-03-06 02:12:20', '2020-03-06 02:12:20'),
(11, 'Product List', 10, 1, '2020-03-06 02:12:28', '2020-03-06 02:12:28'),
(12, 'View PDF', 11, 1, '2020-03-06 02:12:39', '2020-03-06 02:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_floor`
--

CREATE TABLE `tbl_setup_floor` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setup_floor`
--

INSERT INTO `tbl_setup_floor` (`id`, `code`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(2, 'G03', 'Ground Floor', 1, 20, '2026-06-04 10:10:23', 1, '2026-06-06 09:14:11'),
(3, 'F01', '1st Floor', 1, 1, '2026-06-06 09:12:39', NULL, '2026-06-06 09:12:39'),
(4, 'F02', '2nd Floor', 1, 1, '2026-06-06 09:12:58', NULL, '2026-06-06 09:12:58'),
(5, 'F03', '3rd Floor', 1, 1, '2026-06-06 09:13:14', NULL, '2026-06-06 09:13:14'),
(6, 'F04', '4th Floor', 1, 1, '2026-06-06 09:13:27', NULL, '2026-06-06 09:13:27'),
(7, 'F05', '5th Floor', 1, 1, '2026-06-06 09:13:39', NULL, '2026-06-06 09:13:39'),
(8, 'F06', '6th Floor', 1, 1, '2026-06-06 09:14:48', NULL, '2026-06-06 09:14:48'),
(9, 'F07', '7th Floor', 1, 1, '2026-06-06 09:20:14', NULL, '2026-06-06 09:20:14'),
(10, 'F08', '8th Floor', 1, 1, '2026-06-06 09:20:42', NULL, '2026-06-06 09:20:42'),
(11, 'F09', '9th Floor', 1, 1, '2026-06-06 09:20:54', NULL, '2026-06-06 09:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_project`
--

CREATE TABLE `tbl_setup_project` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` text NOT NULL,
  `ebill_rate` double NOT NULL,
  `wbill_rate` double NOT NULL,
  `address` text NOT NULL,
  `contact` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_setup_project`
--

INSERT INTO `tbl_setup_project` (`id`, `code`, `name`, `ebill_rate`, `wbill_rate`, `address`, `contact`, `created_at`, `updated_at`) VALUES
(1, 'P01\r\n', 'Mannan Plaza', 17, 17, 'B-25, Khilkhet Bazar, Dhaka-1229', 'Phone: 58970404, 58977035', '2020-12-30 05:54:54', '2020-12-30 05:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_rate`
--

CREATE TABLE `tbl_setup_rate` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `rate` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_setup_rate`
--

INSERT INTO `tbl_setup_rate` (`id`, `project_id`, `type`, `rate`) VALUES
(1, 1, 'ebill', 17),
(2, 1, 'wbill', 60);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_system`
--

CREATE TABLE `tbl_setup_system` (
  `id` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `company_address` text NOT NULL,
  `company_utility` text NOT NULL,
  `report_footer` text NOT NULL,
  `ebill_serial` text NOT NULL,
  `space_rent_serial` text NOT NULL,
  `service_charge_serial` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_setup_system`
--

INSERT INTO `tbl_setup_system` (`id`, `company_name`, `company_address`, `company_utility`, `report_footer`, `ebill_serial`, `space_rent_serial`, `service_charge_serial`, `created_at`, `updated_at`) VALUES
(1, 'Mannan Plaza', 'B-25, Khilkhet Bazar, Dhaka-1229', '01571705916,01316246364,01554307665', '', '0', '0', '0', '2020-10-05 02:20:26', '2020-10-05 02:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_unit`
--

CREATE TABLE `tbl_setup_unit` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setup_unit`
--

INSERT INTO `tbl_setup_unit` (`id`, `code`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'u02', '2nd Unit', 1, 4, '2020-09-07 06:32:22', 20, '2026-06-06 11:31:30'),
(2, 'U04', '4rd Unit', 1, 4, '2020-09-07 06:32:36', 20, '2026-06-06 11:32:39'),
(4, 'U03', '3rd Unit', 1, 1, '2024-08-18 13:04:41', 20, '2026-06-06 11:32:03'),
(6, 'U0', 'Gran Unit', 1, 20, '2026-06-04 10:46:46', 20, '2026-06-06 11:33:36'),
(7, 'U01', '1st Unit', 1, 20, '2026-06-04 10:48:25', 20, '2026-06-06 11:27:34'),
(8, 'U05', '5th Unit', 1, 20, '2026-06-06 11:39:04', NULL, '2026-06-06 11:39:04'),
(9, 'U06', '6th Unil', 1, 20, '2026-06-06 11:40:05', NULL, '2026-06-06 11:40:05'),
(10, 'U07', '7th Unit', 1, 20, '2026-06-06 11:40:43', NULL, '2026-06-06 11:40:43'),
(11, 'U08', '8th Unit', 1, 20, '2026-06-06 11:41:19', NULL, '2026-06-06 11:41:19'),
(12, 'U09', '9th Unit', 1, 20, '2026-06-06 11:41:58', NULL, '2026-06-06 11:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_utility`
--

CREATE TABLE `tbl_setup_utility` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setup_utility`
--

INSERT INTO `tbl_setup_utility` (`id`, `code`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, '01', 'Generator Bill', 1, 4, '2020-09-07 06:44:10', NULL, '2020-09-07 06:44:10'),
(2, '02', 'Gas Bill', 1, 4, '2020-09-07 06:44:23', NULL, '2020-09-07 06:45:00'),
(3, '03', 'Signboard Bill', 1, 4, '2020-09-07 06:44:43', NULL, '2020-09-07 06:44:43'),
(4, '04', 'Passage Charge', 1, 4, '2020-09-07 06:44:50', 4, '2020-09-07 06:45:36'),
(6, '05', 'Water Bill', 1, NULL, NULL, NULL, NULL),
(7, '06', 'Service Charge', 1, NULL, NULL, NULL, NULL),
(8, '07', 'Meter Charge', 1, NULL, NULL, NULL, NULL),
(9, '08', 'VAT', 1, NULL, NULL, NULL, NULL),
(10, '10', 'Car Parking', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sliders`
--

CREATE TABLE `tbl_sliders` (
  `id` int(11) NOT NULL,
  `first_title` varchar(255) DEFAULT NULL,
  `second_title` varchar(255) DEFAULT NULL,
  `third_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_links`
--

CREATE TABLE `tbl_social_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `parent_role` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `permission` text DEFAULT NULL,
  `action_permission` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`id`, `name`, `parent_role`, `level`, `status`, `permission`, `action_permission`, `created_at`, `updated_at`) VALUES
(2, 'Super User', NULL, 1, 1, '1,16,17,18,19,21,22,24,25,26,27,43,44,45,46,74,52,32,33,34,51,28,30,47,48,49,50,75,76,53,54,55,56,57,59,60,61,62,63,58,66,67,68,69,70,71,72,73,78,13,2,3,4,5,15', '54,55,56,57,62,63,64,65,58,59,60,61,70,71,84,73,72,74,75,83,76,77,78,87,79,86,89,85,80,81,88,82,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,2,3,4,5,6,11,12,13,14,15,7,8,9,10,21,22,23,24,25,26,52,53', '2019-04-17 00:50:05', '2026-06-02 05:56:57'),
(3, 'Admin', 2, 1, 1, '1,16,17,18,19,21,22,24,25,26,27,43,44,45,46,74,52,32,33,34,51,28,30,47,48,49,50,75,76,53,54,55', '54,55,56,57,62,63,64,65,58,59,60,61,70,71,84,73,72,74,75,83,76,77,78,87,79,86,85,80,81,82', '2019-04-17 00:52:54', '2026-06-06 08:46:06'),
(4, 'User', NULL, 1, 1, '1,21,22,23,77,24,25,26,27,43,44,45,46,74,52,32,33,34,51,28,30,47,48,49,50,75,76,53,54,55,56,57,59,60,61,62,63,58,66,67,68,69,70,71,72,73', '70,71,84,74,75,83,77,78,87,86,89,80,81,88,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,24', '2020-03-07 00:49:33', '2022-09-04 22:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_stamps`
--

CREATE TABLE `tenant_stamps` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `stamp_no` text DEFAULT NULL,
  `stamp_image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Stand-in structure for view `view_trial_balance`
-- (See below for the actual view)
--
CREATE TABLE `view_trial_balance` (
`voucher_type` varchar(191)
,`voucher_no` varchar(191)
,`voucher_date` varchar(191)
,`coa_head_code` varchar(191)
,`debit_amount` varchar(191)
,`credit_amount` varchar(191)
,`transaction` tinyint(4)
,`general` tinyint(4)
,`parent_head_name` varchar(191)
,`head_type` varchar(191)
,`head_name` varchar(191)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `collection_ebill`
--
ALTER TABLE `collection_ebill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_rant`
--
ALTER TABLE `collection_rant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_servicecharge`
--
ALTER TABLE `collection_servicecharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_wbill`
--
ALTER TABLE `collection_wbill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
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
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `saleposition`
--
ALTER TABLE `saleposition`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Code` (`Code`) USING HASH;

--
-- Indexes for table `tbl_account_transactions`
--
ALTER TABLE `tbl_account_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coa`
--
ALTER TABLE `tbl_coa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu_actions`
--
ALTER TABLE `tbl_menu_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu_action_type`
--
ALTER TABLE `tbl_menu_action_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_floor`
--
ALTER TABLE `tbl_setup_floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_project`
--
ALTER TABLE `tbl_setup_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_rate`
--
ALTER TABLE `tbl_setup_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_system`
--
ALTER TABLE `tbl_setup_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_unit`
--
ALTER TABLE `tbl_setup_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setup_utility`
--
ALTER TABLE `tbl_setup_utility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sliders`
--
ALTER TABLE `tbl_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_social_links`
--
ALTER TABLE `tbl_social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant_stamps`
--
ALTER TABLE `tenant_stamps`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `collection_ebill`
--
ALTER TABLE `collection_ebill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `collection_rant`
--
ALTER TABLE `collection_rant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `collection_servicecharge`
--
ALTER TABLE `collection_servicecharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `collection_wbill`
--
ALTER TABLE `collection_wbill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `saleposition`
--
ALTER TABLE `saleposition`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_account_transactions`
--
ALTER TABLE `tbl_account_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_coa`
--
ALTER TABLE `tbl_coa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tbl_menu_actions`
--
ALTER TABLE `tbl_menu_actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `tbl_menu_action_type`
--
ALTER TABLE `tbl_menu_action_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_setup_floor`
--
ALTER TABLE `tbl_setup_floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_setup_project`
--
ALTER TABLE `tbl_setup_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_setup_rate`
--
ALTER TABLE `tbl_setup_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_setup_system`
--
ALTER TABLE `tbl_setup_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_setup_unit`
--
ALTER TABLE `tbl_setup_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_setup_utility`
--
ALTER TABLE `tbl_setup_utility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_sliders`
--
ALTER TABLE `tbl_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_social_links`
--
ALTER TABLE `tbl_social_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tenant_stamps`
--
ALTER TABLE `tenant_stamps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- --------------------------------------------------------

--
-- Structure for view `view_trial_balance`
--
DROP TABLE IF EXISTS `view_trial_balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`kassafco_mannanplazamarket`@`localhost` SQL SECURITY DEFINER VIEW `view_trial_balance`  AS SELECT `tbl_account_transactions`.`voucher_type` AS `voucher_type`, `tbl_account_transactions`.`voucher_no` AS `voucher_no`, `tbl_account_transactions`.`voucher_date` AS `voucher_date`, `tbl_account_transactions`.`coa_head_code` AS `coa_head_code`, `tbl_account_transactions`.`debit_amount` AS `debit_amount`, `tbl_account_transactions`.`credit_amount` AS `credit_amount`, `tbl_coa`.`transaction` AS `transaction`, `tbl_coa`.`general_ledger` AS `general`, `tbl_coa`.`parent_head_name` AS `parent_head_name`, `tbl_coa`.`head_type` AS `head_type`, `tbl_coa`.`head_name` AS `head_name` FROM (`tbl_account_transactions` left join `tbl_coa` on(`tbl_coa`.`head_code` = `tbl_account_transactions`.`coa_head_code`)) WHERE `tbl_account_transactions`.`approve` = 1 ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
