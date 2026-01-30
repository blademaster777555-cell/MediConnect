-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 24, 2026 lúc 01:55 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mediconnect`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddColumnIfNotExists` ()   BEGIN
    -- Thêm license_number
    IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'doctor_profiles' AND COLUMN_NAME = 'license_number') THEN
        ALTER TABLE `doctor_profiles` ADD COLUMN `license_number` VARCHAR(255) NULL AFTER `phone`;
    END IF;
    -- Thêm consultation_fee
    IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'doctor_profiles' AND COLUMN_NAME = 'consultation_fee') THEN
        ALTER TABLE `doctor_profiles` ADD COLUMN `consultation_fee` DECIMAL(10, 2) DEFAULT 0 AFTER `license_number`;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_type` enum('patient','admin','counselor') NOT NULL DEFAULT 'patient',
  `date` date NOT NULL,
  `time` time NOT NULL,
  `patient_note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `fee` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_id`, `schedule_id`, `created_by`, `booking_type`, `date`, `time`, `patient_note`, `status`, `fee`, `payment_status`, `created_at`, `updated_at`) VALUES
(22, 5, 12, NULL, NULL, 'patient', '2026-01-23', '10:00:00', 'ho', 'cancelled', 100.00, 'refunded', '2026-01-22 09:44:01', '2026-01-24 03:39:39'),
(23, 8, 13, NULL, NULL, 'patient', '2026-01-26', '11:00:00', 'Đau răng', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:06:38', '2026-01-24 01:35:11'),
(24, 8, 13, NULL, NULL, 'patient', '2026-01-26', '11:00:00', 'Đau răng', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:09:50', '2026-01-24 01:35:14'),
(25, 8, 13, NULL, NULL, 'patient', '2026-01-26', '11:00:00', 'Đau răng', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:10:33', '2026-01-24 01:35:17'),
(26, 8, 13, NULL, NULL, 'patient', '2026-01-26', '11:00:00', 'Đau răng', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:15:14', '2026-01-24 01:35:19'),
(27, 8, 13, NULL, NULL, 'patient', '2026-01-26', '10:30:00', 'Đau', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:17:12', '2026-01-24 01:35:21'),
(28, 8, 13, NULL, NULL, 'patient', '2026-01-26', '10:30:00', 'Đau', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:18:33', '2026-01-24 01:35:23'),
(29, 8, 13, NULL, NULL, 'patient', '2026-01-26', '10:30:00', 'Đau', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:26:45', '2026-01-24 01:35:25'),
(30, 8, 13, NULL, NULL, 'patient', '2026-01-26', '10:30:00', 'Đau', 'cancelled', 30.00, 'forfeited', '2026-01-24 01:34:16', '2026-01-24 01:35:27'),
(31, 2, 13, NULL, NULL, 'patient', '2026-01-26', '09:00:00', 'Đau', 'completed', 70.00, 'paid', '2026-01-24 02:05:29', '2026-01-24 02:05:52'),
(32, 2, 13, NULL, NULL, 'patient', '2026-01-26', '09:30:00', 'ho', 'completed', 70.00, 'paid', '2026-01-24 02:21:11', '2026-01-24 02:21:42'),
(33, 2, 13, NULL, NULL, 'patient', '2026-01-28', '09:00:00', NULL, 'cancelled', 70.00, 'refunded', '2026-01-24 03:04:11', '2026-01-24 03:04:52'),
(34, 2, 13, NULL, NULL, 'patient', '2026-01-26', '10:30:00', 'mmm', 'confirmed', 70.00, 'paid', '2026-01-24 03:13:42', '2026-01-24 03:16:01'),
(35, 5, 13, NULL, NULL, 'patient', '2026-01-26', '09:00:00', 'kkkk', 'cancelled', 100.00, 'refunded', '2026-01-24 03:14:23', '2026-01-24 03:39:38'),
(36, 5, 13, NULL, NULL, 'patient', '2026-01-25', '09:00:00', 'Đau tim', 'confirmed', 100.00, 'paid', '2026-01-24 04:04:35', '2026-01-24 04:05:28'),
(37, 5, 12, NULL, NULL, 'patient', '2026-01-25', '09:30:00', 'Sốt', 'pending', 100.00, 'paid', '2026-01-24 04:05:08', '2026-01-24 04:05:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-bacsingocthuy@mediconnect.com|127.0.0.1', 'i:1;', 1769085216),
('laravel-cache-bacsingocthuy@mediconnect.com|127.0.0.1:timer', 'i:1769085216;', 1769085216),
('laravel-cache-bacsithuy2@mediconnect.com|127.0.0.1', 'i:1;', 1769085225),
('laravel-cache-bacsithuy2@mediconnect.com|127.0.0.1:timer', 'i:1769085225;', 1769085225),
('laravel-cache-bacsy@mediconnect.com|127.0.0.1', 'i:1;', 1767097979),
('laravel-cache-bacsy@mediconnect.com|127.0.0.1:timer', 'i:1767097979;', 1767097979),
('laravel-cache-khach@mediconnect.com|127.0.0.1', 'i:2;', 1769097587),
('laravel-cache-khach@mediconnect.com|127.0.0.1:timer', 'i:1769097587;', 1769097587),
('laravel-cache-tuvan@mediconnect.com|127.0.0.1', 'i:1;', 1768025831),
('laravel-cache-tuvan@mediconnect.com|127.0.0.1:timer', 'i:1768025831;', 1768025831);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hà Nội', NULL, '2026-01-07 03:13:57'),
(2, 'Hồ Chí Minh', NULL, NULL),
(3, 'Đà Nẵng', NULL, NULL),
(5, 'Cần Thơ', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(6, 'Hải Phòng', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(7, 'Biên Hòa', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(8, 'Vũng Tàu', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(9, 'Nha Trang', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(10, 'Huế', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(11, 'Quy Nhơn', '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(12, 'Vĩnh Long', '2026-01-22 06:55:35', '2026-01-22 06:55:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Read','Unread') NOT NULL DEFAULT 'Unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctor_availabilities`
--

CREATE TABLE `doctor_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` enum('Mon','Tue','Wed','Thu','Fri','Sat','Sun') NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `doctor_availabilities`
--

INSERT INTO `doctor_availabilities` (`id`, `doctor_id`, `day_of_week`, `date`, `start_time`, `end_time`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 4, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 0, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(2, 4, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 0, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(3, 4, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(4, 4, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 0, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(5, 4, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 1, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(6, 4, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 0, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(7, 4, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 05:27:08', '2026-01-17 05:27:08'),
(8, 2, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 1, '2026-01-17 05:28:47', '2026-01-17 05:28:47'),
(9, 2, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 1, '2026-01-17 05:28:47', '2026-01-17 05:28:47'),
(10, 2, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 0, '2026-01-17 05:28:47', '2026-01-17 05:28:47'),
(11, 2, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 05:28:47', '2026-01-17 05:28:47'),
(12, 2, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 0, '2026-01-17 05:28:47', '2026-01-17 05:28:47'),
(13, 2, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 1, '2026-01-17 05:28:47', '2026-01-22 05:35:59'),
(14, 2, 'Fri', '2026-01-23', '13:00:00', '17:00:00', 0, '2026-01-17 05:28:47', '2026-01-22 05:35:59'),
(15, 3, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 1, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(16, 3, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 0, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(17, 3, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(18, 3, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(19, 3, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 0, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(20, 3, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 0, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(21, 3, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 05:30:24', '2026-01-17 05:30:24'),
(22, 5, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 0, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(23, 5, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 0, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(24, 5, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(25, 5, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(26, 5, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 1, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(27, 5, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 1, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(28, 5, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 05:45:34', '2026-01-17 05:52:41'),
(29, 1, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(30, 1, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(31, 1, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(32, 1, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(33, 1, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(34, 1, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(35, 1, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(36, 6, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(37, 6, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(38, 6, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(39, 6, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(40, 6, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(41, 6, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(42, 6, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 06:10:14', '2026-01-17 06:10:14'),
(43, 2, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 1, '2026-01-22 05:34:58', '2026-01-24 03:47:42'),
(44, 2, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 0, '2026-01-22 05:34:58', '2026-01-24 03:47:42'),
(45, 2, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-22 05:34:58', '2026-01-24 03:47:42'),
(46, 2, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-22 05:34:58', '2026-01-24 03:47:42'),
(47, 2, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-22 05:34:58', '2026-01-24 03:47:42'),
(48, 5, 'Sat', '2026-01-24', '07:00:00', '10:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(49, 5, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(50, 5, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 0, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(51, 5, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(52, 5, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(53, 5, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(54, 5, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 00:40:35', '2026-01-24 03:47:18'),
(55, 8, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(56, 8, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 0, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(57, 8, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(58, 8, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(59, 8, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(60, 8, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(61, 8, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 01:05:30', '2026-01-24 04:09:29'),
(62, 2, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 01:53:01', '2026-01-24 03:47:42'),
(63, 2, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 01:53:01', '2026-01-24 03:47:42'),
(64, 6, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 0, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(65, 6, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(66, 6, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(67, 6, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(68, 6, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(69, 6, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(70, 6, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:11', '2026-01-24 03:47:11'),
(71, 3, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 0, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(72, 3, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(73, 3, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(74, 3, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(75, 3, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(76, 3, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(77, 3, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:25', '2026-01-24 03:47:25'),
(78, 4, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 0, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(79, 4, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 0, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(80, 4, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(81, 4, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(82, 4, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(83, 4, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(84, 4, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:49', '2026-01-24 03:47:49'),
(85, 1, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(86, 1, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(87, 1, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(88, 1, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(89, 1, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(90, 1, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(91, 1, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(92, 10, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(93, 10, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(94, 10, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(95, 10, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(96, 10, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(97, 10, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12'),
(98, 10, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 05:27:12', '2026-01-24 05:27:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctor_profiles`
--

CREATE TABLE `doctor_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT 0.00,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `certificate` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `doctor_profiles`
--

INSERT INTO `doctor_profiles` (`id`, `user_id`, `specialization_id`, `bio`, `phone`, `license_number`, `consultation_fee`, `is_approved`, `certificate`, `image`, `degree`, `experience_years`, `created_at`, `updated_at`, `city_id`) VALUES
(1, 2, 1, 'Trưởng khoa tim mạch với 10 năm kinh nghiệm.', '0123456789', NULL, 50.00, 1, NULL, NULL, 'Tiến sĩ Y khoa', 0, NULL, '2026-01-22 09:04:46', 7),
(2, 7, 4, 'Bác sĩ nội dày dặn kinh nghiệm. Chuyên khoa 2 bệnh viện Đại học Y dược', '0123456789', NULL, 70.00, 1, NULL, NULL, NULL, 0, '2026-01-17 04:53:07', '2026-01-22 09:04:42', 2),
(3, 8, 2, 'Bác sĩ Nhi có kinh nghiệm dày dặn. Luôn vui vẻ với trẻ con', '0909121737', NULL, 60.00, 1, NULL, NULL, NULL, 0, '2026-01-17 04:54:28', '2026-01-22 09:04:40', 8),
(4, 6, 1, 'Bác sĩ tim mạch chuyên khoa 2 Bệnh viện Phạm Ngọc Thạch', '0123456789', NULL, 50.00, 1, NULL, NULL, NULL, 0, '2026-01-17 05:03:01', '2026-01-22 09:26:35', 3),
(5, 10, 1, 'Tiến sĩ Tim mạch. Chuyên khoa 2 Đại học Y dược. Giảng viên dạy và đào tạo nhiều bác sĩ tại trường Đại học Y dược Hồ Chí Minh', '0931185932', NULL, 100.00, 1, NULL, NULL, NULL, 0, '2026-01-17 05:43:41', '2026-01-22 09:04:38', 2),
(6, 11, 3, 'Bác sĩ chuyên khoa da liễu.', '0123456789', NULL, 50.00, 1, NULL, NULL, NULL, 0, '2026-01-17 06:09:36', '2026-01-22 09:04:34', 1),
(8, 15, 6, 'Bác sĩ Răng Hàm Mặt Tổng quát', '0123456789', NULL, 30.00, 1, NULL, NULL, NULL, 0, '2026-01-24 00:41:49', '2026-01-24 01:04:21', 2),
(9, 16, NULL, 'Chưa cập nhật tiểu sử', '0123456789', NULL, 0.00, 0, NULL, NULL, NULL, 0, '2026-01-24 03:15:24', '2026-01-24 03:15:24', 2),
(10, 18, 1, 'Chưa cập nhật tiểu sử', '0123456789', NULL, 0.00, 1, NULL, NULL, NULL, 0, '2026-01-24 05:25:45', '2026-01-24 05:26:56', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `user_id`, `doctor_id`, `appointment_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(5, 16, 2, 31, 5, NULL, '2026-01-24 02:22:11', '2026-01-24 02:22:11'),
(6, 16, 2, 32, 5, 'tốt', '2026-01-24 02:22:22', '2026-01-24 02:22:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `medical_content`
--

CREATE TABLE `medical_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'news',
  `image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `published_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `medical_content`
--

INSERT INTO `medical_content` (`id`, `title`, `content`, `category`, `image`, `author_id`, `published_date`, `created_at`, `updated_at`) VALUES
(1, 'Bệnh Cúm Mùa: Triệu chứng và Cách phòng ngừa', 'Bệnh cúm mùa là một nhiễm trùng đường hô hấp cấp tính do virus cúm gây ra. Triệu chứng bao gồm sốt đột ngột, ho, đau đầu, đau cơ, mệt mỏi, đau họng và chảy nước mũi. Để phòng ngừa, hãy tiêm vắc xin cúm hàng năm, rửa tay thường xuyên và tránh tiếp xúc gần với người bệnh.', 'disease', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(2, 'Đái tháo đường (Tiểu đường) - Kẻ giết người thầm lặng', 'Đái tháo đường là bệnh rối loạn chuyển hóa mạn tính. Triệu chứng thường gặp: khát nước nhiều, đi tiểu nhiều, sụt cân nhanh, mờ mắt. Phòng ngừa bằng cách duy trì cân nặng hợp lý, vận động thể lực ít nhất 30 phút mỗi ngày và ăn uống lành mạnh hạn chế đường.', 'disease', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(3, 'Tăng Huyết Áp: Những điều cần biết', 'Tăng huyết áp được mệnh danh là \"kẻ giết người thầm lặng\" vì thường không có triệu chứng rõ ràng. Biến chứng nguy hiểm gồm đột quỵ, nhồi máu cơ tim, suy thận. Kiểm soát bằng cách ăn nhạt, hạn chế rượu bia, không hút thuốc lá và đo huyết áp thường xuyên.', 'disease', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(4, 'Sốt xuất huyết: Dấu hiệu cảnh báo nguy hiểm', 'Sốt xuất huyết do virus Dengue gây ra, lây truyền qua muỗi vằn. Dấu hiệu cảnh báo: Đau bụng dữ dội, nôn liên tục, chảy máu lợi, nôn ra máu, thở nhanh, mệt mỏi, bồn chồn. Khi có dấu hiệu này cần nhập viện ngay lập tức.', 'disease', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(5, 'Bộ Y tế phát động chiến dịch tiêm chủng vắc xin sởi', 'Bộ Y tế vừa phát động chiến dịch tiêm chủng vắc xin sởi - rubella cho trẻ em trên toàn quốc nhằm ứng phó với nguy cơ dịch sởi quay trở lại. Chiến dịch sẽ diễn ra tại 63 tỉnh thành, ưu tiên các vùng khó khăn, vùng sâu vùng xa.', 'news', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(6, 'Công nghệ AI trong chẩn đoán hình ảnh: Bước tiến mới của Y học', 'Việc ứng dụng Trí tuệ nhân tạo (AI) trong chẩn đoán hình ảnh đang giúp các bác sĩ phát hiện sớm ung thư phổi và ung thư vú với độ chính xác lên tới 95%. Nhiều bệnh viện lớn tại Việt Nam đã bắt đầu triển khai hệ thống này.', 'news', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(7, 'Hội thảo Quốc tế về Tim mạch học 2024 tổ chức tại Hà Nội', 'Hơn 500 chuyên gia tim mạch hàng đầu thế giới đã tụ họp tại Hà Nội để chia sẻ những cập nhật mới nhất về điều trị suy tim và can thiệp mạch vành. Hội thảo mang lại nhiều cơ hội hợp tác và phát triển cho ngành y tế nước nhà.', 'news', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18'),
(8, 'Cảnh báo về tình trạng lạm dụng thuốc kháng sinh', 'Tổ chức Y tế Thế giới (WHO) cảnh báo tình trạng kháng thuốc kháng sinh đang ở mức báo động. Người dân được khuyến cáo không tự ý mua thuốc kháng sinh mà phải tuân thủ kê đơn của bác sĩ để bảo vệ sức khỏe cộng đồng.', 'news', NULL, 1, '2025-12-27 04:16:18', '2025-12-27 04:16:18', '2025-12-27 04:16:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text DEFAULT NULL,
  `doctor_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_27_114836_create_cities_table', 1),
(5, '2025_12_27_114845_create_specializations_table', 1),
(6, '2025_12_27_114859_add_columns_to_users_table', 1),
(7, '2025_12_27_114909_create_doctors_table', 1),
(8, '2025_12_27_114919_create_schedules_table', 1),
(9, '2025_12_27_114936_create_appointments_table', 1),
(10, '2025_12_27_114945_create_posts_table', 1),
(11, '2025_12_30_000001_update_appointments_add_created_by', 1),
(12, '2025_12_30_000002_update_users_add_counselor_role', 1),
(13, '2025_12_30_122259_update_appointments_add_created_by', 1),
(14, '2026_01_01_144318_create_doctor_availabilities_table', 2),
(15, '2026_01_01_144427_create_feedbacks_table', 2),
(16, '2026_01_01_144504_add_city_id_to_doctors_table', 2),
(17, '2026_01_02_000001_create_patients_table', 3),
(18, '2026_01_02_000002_create_notifications_table', 3),
(19, '2026_01_02_000003_create_contact_messages_table', 3),
(20, '2026_01_02_000004_create_medical_records_table', 3),
(21, '2026_01_02_000005_add_image_to_users_table', 4),
(22, '2026_01_09_153134_create_medical_content_table', 5),
(23, '2026_01_09_155620_update_doctors_table_to_profiles', 6),
(24, '2026_01_10_062045_create_feedback_table', 7),
(25, '2026_01_15_122633_change_role_column_in_users_table', 7),
(26, '2026_01_15_123338_rename_patients_to_patient_profiles_table', 8),
(27, '2026_01_15_133211_make_specialization_id_nullable_in_doctor_profiles_table', 9),
(28, '2026_01_17_114612_add_indexes_to_optimization_tables', 10),
(29, '2026_01_17_122314_fix_doctor_availabilities_table', 11),
(30, '2026_01_22_154336_add_is_approved_to_doctor_profiles_table', 12),
(31, '2026_01_22_160004_add_fee_to_appointments_table', 13),
(32, '2026_01_24_074854_add_certificate_to_doctor_profiles_table', 14),
(34, '2026_01_24_080759_update_notifications_table_to_standard', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('009f142d-65c5-4d48-96ac-bc6ce45219b7', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":32,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #32\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 02:21:11', '2026-01-24 05:19:50'),
('12483293-5027-49d7-aba2-0123cca66649', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":34,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #34\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:13:42', '2026-01-24 05:19:50'),
('192ff555-bcea-499d-afdf-86985a0de0e2', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":31,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #31\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 02:20:29', '2026-01-24 02:05:29', '2026-01-24 02:20:29'),
('2dfbe093-a278-4dc4-9495-04410805a70a', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":35,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #35\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:14:23', '2026-01-24 05:19:50'),
('65b21fda-21c2-4bb9-aa49-b09f4060bdec', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":36,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #36\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 04:04:35', '2026-01-24 05:19:50'),
('8cd5dd95-bb88-4543-b05a-4505be1f501c', 'App\\Notifications\\NewDoctorRegistered', 'App\\Models\\User', 1, '{\"type\":\"new_doctor\",\"user_id\":18,\"message\":\"B\\u00e1c s\\u0129 m\\u1edbi \\u0111\\u0103ng k\\u00fd: Minh Ho\\u00e0ng\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/doctors\"}', '2026-01-24 05:27:20', '2026-01-24 05:25:45', '2026-01-24 05:27:20'),
('af5cac42-3670-480a-8e43-3c8b8ac2518c', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":30,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #30\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 01:34:48', '2026-01-24 01:34:16', '2026-01-24 01:34:48'),
('d4d938ca-dd63-40fc-b147-2e2ed300563d', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":33,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #33\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:04:11', '2026-01-24 05:19:50'),
('f4682207-2540-4e4d-bb38-e33784fd7ade', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":37,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #37\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 04:05:08', '2026-01-24 05:19:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(191) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `patient_profiles`
--

CREATE TABLE `patient_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `patient_profiles`
--

INSERT INTO `patient_profiles` (`id`, `user_id`, `phone`, `address`, `date_of_birth`, `gender`, `medical_history`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, NULL, NULL, NULL, NULL, '2026-01-15 04:00:39', '2026-01-15 04:00:39'),
(6, 2, NULL, NULL, NULL, NULL, NULL, '2026-01-15 06:19:35', '2026-01-15 06:19:35'),
(8, 6, NULL, NULL, NULL, NULL, NULL, '2026-01-17 05:09:25', '2026-01-17 05:09:25'),
(10, 10, NULL, NULL, NULL, NULL, NULL, '2026-01-22 05:27:24', '2026-01-22 05:27:24'),
(11, 7, NULL, NULL, NULL, NULL, NULL, '2026-01-22 05:37:12', '2026-01-22 05:37:12'),
(12, 14, '0123456789', 'Q1', NULL, NULL, NULL, '2026-01-22 09:06:07', '2026-01-22 09:06:07'),
(13, 16, '0123456789', 'Q2', NULL, NULL, NULL, '2026-01-24 01:03:30', '2026-01-24 01:03:30'),
(14, 17, '0123456789', 'Q4', NULL, NULL, NULL, '2026-01-24 05:17:38', '2026-01-24 05:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'news',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `summary`, `content`, `image`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Cúm mùa và cách phòng tránh', 'cum-mua', 'Các biện pháp đơn giản để bảo vệ bản thân khỏi cúm mùa.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Disease+Prevention', 'disease', '2025-12-30 05:26:47', NULL),
(2, 'Công nghệ AI trong chẩn đoán ung thư', 'ai-ung-thu', 'Phát minh mới giúp phát hiện ung thư sớm nhờ trí tuệ nhân tạo.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Invention', 'invention', '2025-12-30 05:26:47', NULL),
(3, 'Bộ Y tế khuyến cáo về dịch sốt xuất huyết', 'sot-xuat-huyet', 'Số ca mắc tăng cao, người dân cần chủ động diệt muỗi.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Medical+News', 'news', '2025-12-30 05:26:47', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `image_url`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Tim mạch', NULL, 'Chuyên trị bệnh tim', NULL, NULL, NULL),
(2, 'Nhi khoa', NULL, 'Khám cho trẻ em', NULL, NULL, NULL),
(3, 'Da liễu', NULL, 'Các bệnh về da', NULL, NULL, NULL),
(4, 'Nội khoa', NULL, 'Chuyên khoa nội khoa tổng quát, điều trị các bệnh lý nội khoa', NULL, '2026-01-03 03:52:15', '2026-01-03 03:52:15'),
(5, 'Ngoại khoa', NULL, 'Chuyên chấn thương chỉnh hình, phẫu thuật', NULL, '2026-01-22 06:56:28', '2026-01-22 10:27:56'),
(6, 'Răng hàm mặt', NULL, 'Chuyên tổng quát', NULL, '2026-01-22 10:27:37', '2026-01-22 10:27:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `role`, `status`, `image`, `remember_token`, `created_at`, `updated_at`, `city_id`, `avatar`) VALUES
(1, 'Administrator', 'admin@mediconnect.com', NULL, NULL, NULL, '$2y$12$dknZCb8su46UEsJ7n1ayi.NTEPc9yRcRS9eGEs71FVm8NDNBMVKdO', 'admin', 'active', NULL, NULL, NULL, '2026-01-22 06:12:46', NULL, NULL),
(2, 'Minh Tâm', 'bacsitam@mediconnect.com', NULL, NULL, NULL, '$2y$12$clnXbMosgKplOicl5P.qXeLzRm9CEVnu0E0XJC3axEW6v8Y1gm2Lq', 'doctor', 'active', 'avatars/K3WFHaCnme12XRqxCKBEEYdcCM43JzuW7bg4yiis.jpg', NULL, NULL, '2026-01-24 03:39:05', NULL, NULL),
(6, 'Thu Thuỷ', 'bacsithuy@mediconnect.com', NULL, NULL, NULL, '$2y$12$F3LIW4aptdBCJhFIlnt.s.3R4BPL95b9pH81SgaFTwvXG6xwjUvW.', 'doctor', 'active', 'avatars/SuL6JNI5Ox06jDlkK2usiz9PutKwihmtvtq0med6.jpg', NULL, '2026-01-15 06:27:18', '2026-01-24 03:38:47', NULL, NULL),
(7, 'Ngọc Thuỷ', 'bacsithuy1@mediconnect.com', '0123456789', '123 A, Q1', NULL, '$2y$12$sXAlBxxQuFwl8CEI/2rvH.m3xnQg4FPN4nQhsKiu1cXWMDxHaeYdy', 'doctor', 'active', 'avatars/aEDMNNyaOMi7zkQNFHqeicqeOLwT2OO7z0k3sTCm.jpg', NULL, '2026-01-17 04:53:07', '2026-01-24 03:26:20', 2, NULL),
(8, 'Hữu Thuận', 'bacsithuan@mediconnect.com', '0909121737', '68 Hoà Bình', NULL, '$2y$12$7OBiyOnJPrvDbImGVYUBl.48G53ndrpfGoZSkHWRyGNNkeZAxtJYO', 'doctor', 'active', 'avatars/gJqfvUzuLpNB7xvFlzRR742goJsUksHRCB9WwjMs.jpg', NULL, '2026-01-17 04:54:28', '2026-01-24 03:38:21', 8, NULL),
(10, 'Thuận Đạt', 'bacsidat@mediconnect.com', '0931185932', '017 Lạc Long Quân', NULL, '$2y$12$m8EvzLw2o9fcsDv44itR7ev5OyJnJopRPRklf7wZvLW4ie3R0yxDW', 'doctor', 'active', 'avatars/UNmUCCHym9zlvjyYyxVcghT0BLN611utGnEHNuSA.jpg', NULL, '2026-01-17 05:43:41', '2026-01-24 03:37:22', 2, NULL),
(11, 'Văn Quang', 'bacsiquang@mediconnect.com', '0123456789', '123 A, Hà Nội', NULL, '$2y$12$BBygsp8mDQ/6t8m5n9VV7OHMPtHaFfpAc4fTC/s1aYDs/vfl6Tn2C', 'doctor', 'active', 'avatars/urStGXXkemXzUCDw60PIWlwrX8otEahumlaISWRy.jpg', NULL, '2026-01-17 06:09:36', '2026-01-24 03:36:55', 1, NULL),
(14, 'Khách 1', 'khach1@mediconnect.com', '0123456789', 'Q1', NULL, '$2y$12$DRNSfWMn1Vr3Oq1CIgNWPOIIwIJpKW2zmUv/X5K5V0ITjH0NVZkIu', 'patient', 'active', NULL, NULL, '2026-01-22 09:06:07', '2026-01-22 09:06:07', 2, NULL),
(15, 'Duy Khánh', 'bacsikhanh@mediconnect.com', '0123456789', 'Q3', NULL, '$2y$12$WiGFt93lQzVp0FHmZ.ENduYO0APaABX9Qwy8ISXUaOPgHsagZqDPK', 'doctor', 'active', 'avatars/2dNO03a8IEj58PWrwqOnyzg1bAAu8vguybQM9kZO.jpg', NULL, '2026-01-24 00:41:49', '2026-01-24 03:36:21', 2, NULL),
(16, 'Khách 2', 'khach2@mediconnect.com', '0123456789', 'Q2', NULL, '$2y$12$Uo4Z8pIoAtqs1WcoKZvdzOcDuoRrrZ6v120QvVXV0ottGMCgCG3gu', 'patient', 'active', NULL, NULL, '2026-01-24 01:03:30', '2026-01-24 01:03:30', 2, NULL),
(17, 'Khách 3', 'khach3@mediconnect.com', '0123456789', 'Q4', NULL, '$2y$12$i9CCHQcQuSx/rFh161S7S.d6H2.GEmh04da21OX.6n7R6wyM7eOGe', 'patient', 'active', NULL, NULL, '2026-01-24 05:17:38', '2026-01-24 05:17:38', 2, NULL),
(18, 'Minh Hoàng', 'bacsihoang@mediconnect.com', '0123456789', 'Q1', NULL, '$2y$12$4XYeR0J9DjTtZpF9TE2n8u7NGQd6S12CmZTfbFdhaNhFAqFISIIZK', 'doctor', 'active', 'avatars/vRmPQy5uRcxLD9TQdjnnD9p3EGxLbbW6k831X18I.jpg', NULL, '2026-01-24 05:25:45', '2026-01-24 05:26:56', 2, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_created_by_foreign` (`created_by`),
  ADD KEY `appointments_date_index` (`date`),
  ADD KEY `appointments_status_index` (`status`),
  ADD KEY `appointments_patient_id_status_index` (`patient_id`,`status`),
  ADD KEY `appointments_doctor_id_status_index` (`doctor_id`,`status`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_availabilities_doctor_id_foreign` (`doctor_id`);

--
-- Chỉ mục cho bảng `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_city_id_foreign` (`city_id`),
  ADD KEY `doctor_profiles_specialization_id_index` (`specialization_id`),
  ADD KEY `doctor_profiles_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_user_id_foreign` (`user_id`),
  ADD KEY `feedbacks_doctor_id_foreign` (`doctor_id`),
  ADD KEY `feedbacks_appointment_id_foreign` (`appointment_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `medical_content`
--
ALTER TABLE `medical_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_content_author_id_foreign` (`author_id`);

--
-- Chỉ mục cho bảng `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_records_appointment_id_unique` (`appointment_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Chỉ mục cho bảng `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_profiles_user_id_unique` (`user_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_doctor_id_foreign` (`doctor_id`);

--
-- Chỉ mục cho bảng `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_index` (`city_id`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT cho bảng `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `medical_content`
--
ALTER TABLE `medical_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `patient_profiles`
--
ALTER TABLE `patient_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  ADD CONSTRAINT `doctor_availabilities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD CONSTRAINT `doctor_profiles_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `feedbacks_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`),
  ADD CONSTRAINT `feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `medical_content`
--
ALTER TABLE `medical_content`
  ADD CONSTRAINT `medical_content_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD CONSTRAINT `patient_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
