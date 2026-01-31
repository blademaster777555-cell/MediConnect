-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 01:54 PM
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
-- Database: `mediconnect`
--

DELIMITER $$
--
-- Procedures
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
-- Table structure for table `appointments`
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
  `cancellation_reason` text DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_id`, `schedule_id`, `created_by`, `booking_type`, `date`, `time`, `patient_note`, `status`, `cancellation_reason`, `fee`, `payment_status`, `created_at`, `updated_at`) VALUES
(38, 1, 12, NULL, NULL, 'patient', '2026-01-30', '14:30:00', 'No note', 'cancelled', NULL, 50.00, 'refunded', '2026-01-28 22:11:35', '2026-01-28 22:15:11'),
(39, 1, 12, NULL, NULL, 'patient', '2026-01-30', '10:00:00', 'Arrived 10min early', 'completed', NULL, 50.00, 'refunded', '2026-01-28 22:21:37', '2026-01-31 01:43:30'),
(40, 1, 12, NULL, NULL, 'patient', '2026-01-30', '10:30:00', 'redo', 'cancelled', 'trùng lịch', 50.00, 'refunded', '2026-01-28 22:24:37', '2026-01-30 02:10:53'),
(41, 1, 12, NULL, NULL, 'patient', '2026-01-31', '09:30:00', NULL, 'cancelled', 'sai lịch', 50.00, 'refunded', '2026-01-30 01:54:57', '2026-01-30 02:06:20'),
(42, 1, 12, NULL, NULL, 'patient', '2026-01-31', '09:30:00', 'chest pain', 'cancelled', NULL, 50.00, 'forfeited', '2026-01-30 05:42:59', '2026-01-31 02:17:35'),
(45, 1, 15, NULL, NULL, 'patient', '2026-02-01', '10:00:00', NULL, 'confirmed', NULL, 50.00, 'paid', '2026-01-31 05:24:43', '2026-01-31 05:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-bacsi.minh@mediconnect.com|127.0.0.1', 'i:1;', 1769654844),
('laravel-cache-bacsi.minh@mediconnect.com|127.0.0.1:timer', 'i:1769654844;', 1769654844),
('laravel-cache-bacsia@mediconnect.com|127.0.0.1', 'i:1;', 1769613917),
('laravel-cache-bacsia@mediconnect.com|127.0.0.1:timer', 'i:1769613917;', 1769613917),
('laravel-cache-bacsingocthuy@mediconnect.com|127.0.0.1', 'i:1;', 1769085216),
('laravel-cache-bacsingocthuy@mediconnect.com|127.0.0.1:timer', 'i:1769085216;', 1769085216),
('laravel-cache-bacsita@mediconnect.com|127.0.0.1', 'i:1;', 1769763062),
('laravel-cache-bacsita@mediconnect.com|127.0.0.1:timer', 'i:1769763062;', 1769763062),
('laravel-cache-bacsithuy2@mediconnect.com|127.0.0.1', 'i:1;', 1769085225),
('laravel-cache-bacsithuy2@mediconnect.com|127.0.0.1:timer', 'i:1769085225;', 1769085225),
('laravel-cache-bacsitin@mediconect.com|127.0.0.1', 'i:1;', 1769843210),
('laravel-cache-bacsitin@mediconect.com|127.0.0.1:timer', 'i:1769843210;', 1769843210),
('laravel-cache-bacsitin@mediconnect.com|127.0.0.1', 'i:1;', 1769843198),
('laravel-cache-bacsitin@mediconnect.com|127.0.0.1:timer', 'i:1769843198;', 1769843198),
('laravel-cache-bacsy@mediconnect.com|127.0.0.1', 'i:1;', 1767097979),
('laravel-cache-bacsy@mediconnect.com|127.0.0.1:timer', 'i:1767097979;', 1767097979),
('laravel-cache-benhnhan@mediconnect.com|127.0.0.1', 'i:1;', 1769843866),
('laravel-cache-benhnhan@mediconnect.com|127.0.0.1:timer', 'i:1769843866;', 1769843866),
('laravel-cache-khach@mediconnect.com|127.0.0.1', 'i:2;', 1769097587),
('laravel-cache-khach@mediconnect.com|127.0.0.1:timer', 'i:1769097587;', 1769097587),
('laravel-cache-tuvan@mediconnect.com|127.0.0.1', 'i:1;', 1768025831),
('laravel-cache-tuvan@mediconnect.com|127.0.0.1:timer', 'i:1768025831;', 1768025831);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hanoi', NULL, '2026-01-31 03:22:59'),
(2, 'Ho Chi Minh City', NULL, '2026-01-31 03:22:59'),
(3, 'Da Nang', NULL, '2026-01-31 03:22:59'),
(5, 'Can Tho', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(6, 'Hai Phong', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(7, 'Bien Hoa', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(8, 'Vung Tau', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(9, 'Nha Trang', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(10, 'Hue', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(11, 'Quy Nhon', '2026-01-03 03:52:15', '2026-01-31 03:22:59'),
(12, 'Vinh Long', '2026-01-22 06:55:35', '2026-01-31 03:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
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
-- Table structure for table `doctor_availabilities`
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
-- Dumping data for table `doctor_availabilities`
--

INSERT INTO `doctor_availabilities` (`id`, `doctor_id`, `day_of_week`, `date`, `start_time`, `end_time`, `is_available`, `created_at`, `updated_at`) VALUES
(29, 1, 'Sat', '2026-01-17', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(30, 1, 'Sun', '2026-01-18', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(31, 1, 'Mon', '2026-01-19', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(32, 1, 'Tue', '2026-01-20', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(33, 1, 'Wed', '2026-01-21', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(34, 1, 'Thu', '2026-01-22', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(35, 1, 'Fri', '2026-01-23', '09:00:00', '17:00:00', 1, '2026-01-17 06:08:25', '2026-01-17 06:08:25'),
(85, 1, 'Sat', '2026-01-24', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(86, 1, 'Sun', '2026-01-25', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(87, 1, 'Mon', '2026-01-26', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(88, 1, 'Tue', '2026-01-27', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(89, 1, 'Wed', '2026-01-28', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(90, 1, 'Thu', '2026-01-29', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-24 03:47:56'),
(91, 1, 'Fri', '2026-01-30', '09:00:00', '17:00:00', 1, '2026-01-24 03:47:56', '2026-01-28 21:53:09'),
(103, 1, 'Sat', '2026-01-31', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09'),
(104, 1, 'Sun', '2026-02-01', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09'),
(105, 1, 'Mon', '2026-02-02', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09'),
(106, 1, 'Tue', '2026-02-03', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09'),
(107, 1, 'Wed', '2026-02-04', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09'),
(108, 1, 'Thu', '2026-02-05', '09:00:00', '17:00:00', 1, '2026-01-28 21:53:07', '2026-01-28 21:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_profiles`
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
  `rejection_reason` text DEFAULT NULL,
  `certificate` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_profiles`
--

INSERT INTO `doctor_profiles` (`id`, `user_id`, `specialization_id`, `bio`, `phone`, `license_number`, `consultation_fee`, `is_approved`, `rejection_reason`, `certificate`, `image`, `degree`, `experience_years`, `created_at`, `updated_at`, `city_id`) VALUES
(1, 2, 1, 'Head of Cardiology with 10 years of experience.', '0123456789', NULL, 50.00, 1, NULL, '[]', NULL, 'Tiến sĩ Y khoa', 0, NULL, '2026-01-31 05:18:02', 7),
(9, 16, NULL, 'Chưa cập nhật tiểu sử', '0123456789', NULL, 0.00, 0, NULL, NULL, NULL, NULL, 0, '2026-01-24 03:15:24', '2026-01-24 03:15:24', 2),
(11, 1, NULL, 'Chưa cập nhật tiểu sử', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, 0, '2026-01-28 19:49:34', '2026-01-28 19:49:34', NULL),
(12, 14, NULL, 'Chưa cập nhật tiểu sử', '0123456789', NULL, 0.00, 0, NULL, NULL, NULL, NULL, 0, '2026-01-28 21:55:06', '2026-01-28 21:55:06', 2),
(13, 19, NULL, 'Chưa cập nhật tiểu sử', '0769862328', NULL, 0.00, 1, NULL, NULL, NULL, NULL, 0, '2026-01-31 00:03:03', '2026-01-31 03:04:53', 2);

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
-- Table structure for table `feedbacks`
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

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `medical_content`
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
-- Dumping data for table `medical_content`
--

INSERT INTO `medical_content` (`id`, `title`, `content`, `category`, `image`, `author_id`, `published_date`, `created_at`, `updated_at`) VALUES
(1, 'Seasonal Flu: Symptoms and Prevention', '<h2><strong>Overview</strong></h2><p>Seasonal influenza (the flu) is an acute respiratory infection caused by influenza viruses. It is common in all parts of the world. Most people recover without treatment.</p><p>Influenza spreads easily between people when they cough or sneeze. Vaccination is the best way to prevent the disease.</p><p>Symptoms of influenza include acute onset of fever, cough, sore throat, body aches and fatigue.</p><p>Treatment should aim to relieve symptoms. People with the flu should rest and drink plenty of liquids. Most people will recover on their own within a week. Medical care may be needed in severe cases and for people with risk factors.</p><p>There are 4 types of influenza viruses, types A, B, C and D. Influenza A and B viruses circulate and cause <strong>seasonal epidemics</strong> of disease.</p><ul><li><strong>Influenza A viruses</strong> are further classified into subtypes according to the combinations of the proteins on the surface of the virus. Currently circulating in humans are subtype A(H1N1) and A(H3N2) influenza viruses. The A(H1N1) is also written as A(H1N1)pdm09 as it caused the pandemic in 2009 and replaced the previous A(H1N1) virus which had circulated prior to 2009. Only influenza type A viruses are known to have caused pandemics.</li><li><strong>Influenza B viruses</strong> are not classified into subtypes but can be broken down into lineages. Influenza type B viruses belong to either B/Yamagata or B/Victoria lineage.</li><li><strong>Influenza C virus</strong> is detected less frequently and usually causes mild infections, thus does not present public health importance.</li><li><strong>Influenza D viruses</strong> primarily affect cattle and are not known to infect or cause illness in people.</li></ul><h2><strong>Signs and symptoms</strong></h2><p>Symptoms of influenza usually begin around 2 days after being infected by someone who has the virus.</p><p>Symptoms include:</p><ul><li>sudden onset of fever</li><li>cough (usually dry)</li><li>headache</li><li>muscle and joint pain</li><li>severe malaise (feeling unwell)</li><li>sore throat</li><li>runny nose.</li></ul><p>The cough can be severe and can last 2 weeks or more.</p><p>Most people recover from fever and other symptoms within a week without requiring medical attention. However, influenza can cause severe illness or death, especially in people at high risk.</p><p>Influenza can worsen symptoms of other chronic diseases. In severe cases influenza can lead to pneumonia and sepsis. People with other medical issues or who have severe symptoms should seek medical care.</p><p>Hospitalization and death due to influenza occur mainly among high-risk groups.</p><p>In industrialized countries most deaths associated with influenza occur among people aged 65 years or older<i> (1)</i>.</p><p>The effects of seasonal influenza epidemics in developing countries are not fully known, but research estimates that 99% of deaths in children under 5 years of age with influenza related lower respiratory tract infections are in developing countries <i>(2)</i>.</p><h2><strong>Epidemiology</strong></h2><p>All age groups can be affected but there are groups that are more at risk than others.</p><ul><li>People at greater risk of severe disease or complications when infected are pregnant women, children under 5 years of age, older people, individuals with chronic medical conditions (such as chronic cardiac, pulmonary, renal, metabolic, neurodevelopmental, liver or hematologic diseases) and individuals with immunosuppressive conditions/treatments (such as HIV, receiving chemotherapy or steroids, or malignancy).</li><li>Health and care workers are at high risk of acquiring influenza virus infection due to increased exposure to the patients, and of further spreading particularly to vulnerable individuals. Vaccination can protect health workers and the people around them.</li></ul><p>Epidemics can result in high levels of worker/school absenteeism and productivity losses. Clinics and hospitals can be overwhelmed during peak illness periods.</p><h2><strong>Transmission</strong></h2><p>Seasonal influenza spreads easily, with rapid transmission in crowded areas including schools and nursing homes. When an infected person coughs or sneezes, droplets containing viruses (infectious droplets) are dispersed into the air and can infect persons in close proximity. The virus can also be spread by hands contaminated with influenza viruses. To prevent transmission, people should cover their mouth and nose with a tissue when coughing and wash their hands regularly.</p><p>In temperate climates, seasonal epidemics occur mainly during winter, while in tropical regions, influenza may occur throughout the year, causing outbreaks more irregularly.</p><p>The time from infection to illness, known as the incubation period, is about 2 days, but ranges from 1–4 days.</p><h2><strong>Diagnosis</strong></h2><p>Most cases of human influenza are clinically diagnosed. However, during periods of low influenza activity or outside of epidemics situations, the infection of other respiratory viruses (e.g. SARS-CoV-2, rhinovirus, respiratory syncytial virus, parainfluenza and adenovirus) can also present as influenza-like illness (ILI), which makes the clinical differentiation of influenza from other pathogens difficult.</p><p>Collection of appropriate respiratory samples and the application of a laboratory diagnostic test is required to establish a definitive diagnosis. Proper collection, storage and transport of respiratory specimens is the essential first step for laboratory detection of influenza virus infections. Laboratory confirmation is commonly performed using direct antigen detection, virus isolation, or detection of influenza-specific RNA by reverse transcriptase-polymerase chain reaction (RT-PCR). Various guidance on the laboratory techniques is <a href=\"https://www.who.int/publications/i/item/surveillance-standards-for-vaccine-preventable-diseases-2nd-edition\">published and updated by WHO</a>.</p><p>Rapid diagnostic tests are used in clinical settings, but they have lower sensitivity compared to RT-PCR methods and their reliability depends largely on the conditions under which they are used.</p><h2><strong>Treatment</strong></h2><p>Most people will recover from influenza on their own. People with severe symptoms or other medical conditions should seek medical care.</p><p>People with mild symptoms should:</p><ul><li>stay home to avoid infecting other people</li><li>rest</li><li>drink plenty of fluids</li><li>treat other symptoms such as fever</li><li>seek medical care if symptoms get worse.</li></ul><p>People at high risk or with severe symptoms should be treated with antiviral medications as soon as possible. They include people who are:</p><ul><li>pregnant</li><li>children under 59 months of age</li><li>aged 65 years and older</li><li>living with other chronic illnesses</li><li>receiving chemotherapy</li><li>living with suppressed immune systems due to HIV or other conditions.</li></ul><p>The WHO Global Influenza Surveillance and Response System (GISRS) monitors resistance to antivirals among circulating influenza viruses to provide timely evidence for national policies related to antiviral use.</p><h2><strong>Prevention</strong></h2><p>Vaccination is the best way to prevent influenza.</p><p>Safe and effective vaccines have been used for more than 60 years. Immunity from vaccination goes away over time so annual vaccination is recommended to protect against influenza.</p><p>The vaccine may be less effective in older people, but it will make the illness less severe and reduces the chance of complications and death.</p><p>Vaccination is especially important for people at high risk of influenza complications and their carers.</p><p>Annual vaccination is recommended for:</p><ul><li>pregnant women</li><li>children aged 6 months to 5 years</li><li>people over age 65</li><li>people with chronic medical conditions</li><li>health workers.</li></ul><p>Other ways to prevent influenza:</p><ul><li>wash and dry your hands regularly</li><li>cover your mouth and nose when coughing or sneezing</li><li>dispose of tissues correctly</li><li>stay home when feeling unwell</li><li>avoid close contact with sick people</li><li>avoid touching your eyes, nose or mouth.</li></ul><h2><strong>Vaccines</strong></h2><p>Vaccines are updated routinely with new vaccines developed that contain viruses that match those circulating. Several inactivated influenza vaccines and recombinant influenza vaccines are available in injectable form. Live attenuated influenza vaccines are available as a nasal spray.</p><h2><strong>WHO response</strong></h2><p>WHO, through the Global Influenza Programme and GISRS, in collaboration with other partners, continuously monitors influenza viruses and activity globally, recommends seasonal influenza vaccine compositions twice a year for the northern and southern hemisphere influenza seasons, guides countries in tropical and subtropical areas as to which formulation vaccines to use, supports decisions for timing of vaccination campaigns, and supports Member States to develop prevention and control strategies.</p><p>WHO works to strengthen national, regional and global influenza response capacities including diagnostics, antiviral susceptibility monitoring, disease surveillance and outbreak response, to increase vaccine coverage among high-risk groups, and to support research and development of new therapeutics and other countermeasures.&nbsp;</p>', 'disease', 'storage/medical-content/ng3P8j7Ic76Uyk8RjewaOHNhId9OPiVdJctLDjdH.jpg', 1, '2025-12-26 17:00:00', '2025-12-27 04:16:18', '2026-01-31 03:26:42'),
(2, 'Diabetes The Silent Killer', '<h2><strong>Overview</strong></h2><p>Diabetes is a chronic disease that occurs either when the pancreas does not produce enough insulin or when the body cannot effectively use the insulin it produces. Insulin is a hormone that regulates blood glucose. Hyperglycaemia, also called raised blood glucose or raised blood sugar, is a common effect of uncontrolled diabetes and over time leads to serious damage to many of the body\'s systems, especially the nerves and blood vessels.</p><p><a href=\"https://www.who.int/data/gho/data/themes/topics/noncommunicable-diseases-risk-factors\">In 2022</a>, 14% of adults aged 18 years and older were living with diabetes, an increase from 7% in 1990. More than half (59%) of adults aged 30 years and over living with diabetes were not taking medication for their diabetes in 2022. Diabetes treatment coverage was lowest in low- and middle-income countries.</p><p>In 2021, diabetes was the direct cause of 1.6 million deaths and 47% of all deaths due to diabetes occurred before the age of 70 years. Another 530 000 kidney disease deaths were caused by diabetes, and high blood glucose causes around 11% of cardiovascular deaths <i>(1)</i>.</p><p>Since 2000, mortality rates from diabetes have been increasing. By contrast, the probability of dying from any one of the four main noncommunicable diseases (cardiovascular diseases, cancer, chronic respiratory diseases or diabetes) between the ages of 30 and 70 decreased by 20% globally between 2000 and 2019.&nbsp;</p><h2><strong>Symptoms</strong></h2><p>Symptoms of diabetes may occur suddenly. In type 2 diabetes, the symptoms can be mild and may take many years to be noticed.</p><p>Symptoms of diabetes include:</p><ul><li>feeling very thirsty</li><li>needing to urinate more often than usual</li><li>blurred vision</li><li>feeling tired</li><li>losing weight unintentionally</li></ul><p>Over time, diabetes can damage blood vessels in the heart, eyes, kidneys and nerves.</p><p>People with diabetes have a higher risk of health problems including heart attack, stroke and kidney failure.</p><p>Diabetes can cause permanent vision loss by damaging blood vessels in the eyes.</p><p>Many people with diabetes develop problems with their feet from nerve damage and poor blood flow. This can cause foot ulcers and may lead to amputation.</p><h2><strong>Type 1 diabetes</strong></h2><p>Type 1 diabetes (previously known as insulin-dependent, juvenile or childhood-onset) is characterized by deficient insulin production and requires daily administration of insulin. In 2017 there were 9 million people with type 1 diabetes; the majority of them live in high-income countries.&nbsp;Neither its cause nor the means to prevent it are known.</p><h2><strong>Type 2 diabetes</strong></h2><p>Type 2 diabetes affects how your body uses sugar (glucose) for energy. It stops the body from using insulin properly, which can lead to high levels of blood sugar if not treated.</p><p>Over time, type 2 diabetes can cause serious damage to the body, especially nerves and blood vessels.</p><p>Type 2 diabetes is often preventable. Factors that contribute to developing type 2 diabetes include being overweight, not getting enough exercise, and genetics.</p><p>Early diagnosis is important to prevent the worst effects of type 2 diabetes. The best way to detect diabetes early is to get regular check-ups and blood tests with a healthcare provider.</p><p>Symptoms of type 2 diabetes can be mild. They may take several years to be noticed. &nbsp;Symptoms may be similar to those of type 1 diabetes but are often less marked. As a result, the disease may be diagnosed several years after onset, after complications have already arisen.</p><p>More than 95% of people with diabetes have type 2 diabetes. Type 2 diabetes was formerly called non-insulin dependent, or adult onset. Until recently, this type of diabetes was seen only in adults but it is now also occurring increasingly frequently in children.</p><h2><strong>Gestational diabetes</strong></h2><p>Gestational diabetes is hyperglycaemia with blood glucose values above normal but below those diagnostic of diabetes. Gestational diabetes occurs during pregnancy.</p><p>Women with gestational diabetes are at an increased risk of complications during pregnancy and at delivery. These women and possibly their children are also at increased risk of type 2 diabetes in the future.</p><p>Gestational diabetes is diagnosed through prenatal screening, rather than through reported symptoms.</p><h2><strong>Impaired glucose tolerance and impaired fasting glycaemia</strong></h2><p>Impaired glucose tolerance (IGT) and impaired fasting glycaemia (IFG) are intermediate conditions in the transition between normality and diabetes. People with IGT or IFG are at high risk of progressing to type 2 diabetes, although this is not inevitable.</p><h2><strong>Prevention</strong></h2><p>Lifestyle changes are the best way to prevent or delay the onset of type 2 diabetes.</p><p>To help prevent type 2 diabetes and its complications, people should:</p><ul><li>reach and keep a health body weight</li><li>stay physically active with at least 150 minutes of moderate exercise each week</li><li>eat a healthy diet and avoid sugar and saturated fat</li><li>not smoke tobacco.</li></ul><h2><strong>Diagnosis and treatment</strong></h2><p>Early diagnosis can be accomplished through relatively inexpensive testing of blood glucose. People with type 1 diabetes need insulin injections for survival.</p><p>One of the most important ways to treat diabetes is to keep a healthy lifestyle.</p><p>Some people with type 2 diabetes will need to take medicines to help manage their blood sugar levels. These can include insulin injections or other medicines. Some examples include:</p><ul><li>metformin</li><li>sulfonylureas</li><li>sodium-glucose co-transporters type 2 (SGLT-2) inhibitors.</li></ul><p>Along with medicines to lower blood sugar, people with diabetes often need medications to lower their blood pressure and statins to reduce the risk of complications.</p><p>Additional medical care may be needed to treat the effects of diabetes:</p><ul><li>foot care to treat ulcers</li><li>screening and treatment for kidney disease</li><li>eye exams to screen for retinopathy (which causes blindness).</li></ul><h2><strong>WHO response</strong></h2><p>WHO aims to stimulate and support the adoption of effective measures for the surveillance, prevention and control of diabetes and its complications, particularly in low- and middle-income countries. To this end, WHO:</p><ul><li>provides scientific guidelines for the prevention of major noncommunicable diseases including diabetes;</li><li>develops norms and standards for diabetes diagnosis and care;</li><li>builds awareness on the global epidemic of diabetes, marking World Diabetes Day (14 November); and</li><li>conducts surveillance of diabetes and its risk factors.</li></ul><p>In April 2021 WHO launched the Global Diabetes Compact, a global initiative aiming for sustained improvements in diabetes prevention and care, with a particular focus on supporting low- and middle-income countries.</p><p>In May 2021, the World Health Assembly agreed a Resolution on strengthening prevention and control of diabetes. In May 2022 the World Health Assembly endorsed five global diabetes coverage targets to be achieved by 2030.</p><p>To learn more about the Global Diabetes Compact, to access diabetes-related technical publications to get involved in upcoming initiatives, visit the <a href=\"https://www.who.int/initiatives/the-who-global-diabetes-compact\">Global Diabetes Compact webpage</a>.</p>', 'disease', 'storage/medical-content/LFr9P3tOFAzSZfHQT7UYMXie0gwen5QqVsSWPSup.jpg', 1, '2025-12-26 17:00:00', '2025-12-27 04:16:18', '2026-01-31 03:27:54'),
(3, 'Hypertension: What You Need to Know', '<h2><strong>Overview</strong><br>&nbsp;</h2><p>Hypertension (high blood pressure) is when the pressure in your blood vessels is too high (140/90 mmHg or higher). It is common but can be serious if not treated.</p><p>People with high blood pressure may not feel symptoms. The only way to know is to get your blood pressure checked.</p><p>Things that increase the risk of having high blood pressure include:</p><ul><li>older age&nbsp;</li><li>genetics</li><li>being overweight or obese</li><li>not being physically active&nbsp;</li><li>high-salt diet</li><li>drinking too much alcohol</li></ul><p>Lifestyle changes like eating a healthier diet, quitting tobacco and being more active can help lower blood pressure. Some people may still need to take medicines.</p><p>Blood pressure is written as two numbers. The first (systolic) number represents the pressure in blood vessels when the heart contracts or beats. The second (diastolic) number represents the pressure in the vessels when the heart rests between beats.<br><br>Hypertension is diagnosed if, when it is measured on two different days, the systolic blood pressure readings on both days is ≥140 mmHg and/or the diastolic blood pressure readings on both days is ≥90 mmHg.</p><h2><strong>Risk factors</strong></h2><p>Modifiable risk factors include unhealthy diets (excessive salt consumption, a diet high in saturated fat and trans fats, low intake of fruits and vegetables), physical inactivity, consumption of tobacco and alcohol, and being overweight or obese. In addition, there are environmental risk factors for hypertension and associated diseases, where air pollution is the most significant.&nbsp;<br><br>Non-modifiable risk factors include a family history of hypertension, age over 65 years and co-existing diseases such as diabetes or kidney disease.</p><h2><strong>Symptoms</strong></h2><p>Most people with hypertension don’t feel any symptoms. Very high blood pressures can cause&nbsp;headaches, blurred vision, chest pain and other symptoms.&nbsp;</p><p>Checking your blood pressure is the best way to know if you have high blood pressure. If hypertension isn’t treated, it can cause other health conditions like kidney disease, heart disease and stroke.<br>&nbsp;</p><p>People with very high blood pressure (usually 180/120 or higher) can experience symptoms including:</p><ul><li>severe headaches</li><li>chest pain</li><li>dizziness</li><li>difficulty breathing</li><li>nausea</li><li>vomiting</li><li>blurred vision or other vision changes</li><li>anxiety</li><li>confusion</li><li>buzzing in the ears</li><li>nosebleeds</li><li>abnormal heart rhythm</li></ul><p>If you are experiencing any of these symptoms and a high blood pressure, seek care immediately.</p><p>The only way to detect hypertension is to have a health professional measure blood pressure. Having blood pressure measured is quick and painless. Although individuals can measure their own blood pressure using automated devices, an evaluation by a health professional is important for assessment of risk and associated conditions.</p><h2><strong>Treatment</strong></h2><p>Lifestyle changes can help lower high blood pressure. These include:</p><ul><li>eating a healthy, low-salt diet</li><li>losing weight</li><li>being physically active</li><li>quitting tobacco.</li></ul><p>If you have high blood pressure, your doctor may recommend one or more medicines. Your recommended blood pressure goal may depend on what other health conditions you have.&nbsp;<br>&nbsp;</p><p>Blood pressure goal is less than 130/80 if you have:</p><ul><li>cardiovascular disease (heart disease or stroke)</li><li>diabetes (high blood sugar)</li><li>chronic kidney disease</li><li>high risk for cardiovascular disease.</li></ul><p>For most people, the goal is to have a blood pressure less than 140/90.&nbsp;<br>&nbsp;</p><p>There are several common blood pressure medicines:&nbsp;</p><ul><li>ACE inhibitors including enalapril and lisinopril relax blood vessels and prevent kidney damage.</li><li>Angiotensin-2 receptor blockers (ARBs) including losartan and telmisartan relax blood vessels and prevent kidney damage.</li><li>Calcium channel blockers including amlodipine and felodipine relax blood vessels.</li><li>Diuretics including hydrochlorothiazide and chlorthalidone eliminate extra water from the body, lowering blood pressure.</li></ul><h2><strong>Prevention</strong></h2><p>Lifestyle changes can help lower high blood pressure and can help anyone with hypertension. Many who make these changes will still need to take medicine.&nbsp;<br>&nbsp;</p><p>These lifestyle changes can help prevent and lower high blood pressure.&nbsp;<br>&nbsp;</p><p>Do:</p><ul><li>Eat more vegetables and fruits.</li><li>Sit less.</li><li>Be more physically active, which can include walking, running, swimming, dancing or activities that build strength, like lifting weights.<br><ul><li>Get at least 150 minutes per week of moderate-intensity aerobic activity or 75 minutes per week of vigorous aerobic activity.</li><li>Do strength building exercises 2 or more days each week.</li></ul></li><li>Lose weight if you’re overweight or obese.</li><li>Take medicines as prescribed by your health care professional.</li><li>Keep appointments with your health care professional.</li></ul><p>Don’t:</p><ul><li>eat too much salty food (try to stay under 2 grams per day)</li><li>eat foods high in saturated or trans fats</li><li>smoke or use tobacco</li><li>drink too much alcohol (1 drink daily max for women, 2 for men)</li><li>miss or share medication.</li></ul><p>Reducing hypertension prevents heart attack, stroke and kidney damage, as well as other health problems.</p><p>Reduce the risks of hypertension by:</p><ul><li>reducing and managing stress</li><li>regularly checking blood pressure</li><li>treating high blood pressure</li><li>managing other medical conditions</li><li>reducing exposure to polluted air.</li></ul><h2><strong>Complications of uncontrolled hypertension</strong></h2><p>Among other complications, hypertension can cause serious damage to the heart. Excessive pressure can harden arteries, decreasing the flow of blood and oxygen to the heart. This elevated pressure and reduced blood flow can cause:</p><ul><li>chest pain, also called angina;</li><li>heart attack, which occurs when the blood supply to the heart is blocked and heart muscle cells die from lack of oxygen. The longer the blood flow is blocked, the greater the damage to the heart;</li><li>heart failure, which occurs when the heart cannot pump enough blood and oxygen to other vital body organs; and</li><li>irregular heart beat which can lead to a sudden death.</li></ul><p>Hypertension can also burst or block arteries that supply blood and oxygen to the brain, causing a stroke.</p><p>In addition, hypertension can cause kidney damage, leading to kidney failure.</p><h2><strong>Prevalence of hypertension</strong></h2><p>The prevalence of hypertension varies across regions and country income groups. The WHO Eastern Mediterranean Region has the highest prevalence of hypertension (38%) while the WHO Western Pacific Region has the lowest prevalence of hypertension (29%).</p><p>The number of adults with hypertension increased from 650 million in 1990 to 1.4 billion in 2024, with the increase seen largely in low- and middle-income countries. This increase is due mainly to a rise in the number of older adults in those countries.&nbsp;</p><h2><strong>WHO response</strong></h2><p>The World Health Organization (WHO) supports countries to reduce hypertension as a public health problem.</p><p>In 2021, WHO released a <a href=\"https://apps.who.int/iris/bitstream/handle/10665/344424/9789240033986-eng.pdf\">new guideline for on the pharmacological treatment of hypertension</a> in adults. The publication provides evidence-based recommendations for the initiation of treatment of hypertension, and recommended intervals for follow-up. The document also includes target blood pressure to be achieved for control, and information on who, in the health-care system, can initiate treatment.</p><p>To support governments in strengthening the prevention and control of cardiovascular disease, WHO and the United States Centers for Disease Control and Prevention (U.S. CDC) launched the <a href=\"https://www.who.int/news/item/15-09-2016-global-hearts-initiative\">Global Hearts Initiative </a>in September 2016, which includes the HEARTS technical package. The six modules of the <a href=\"https://www.who.int/publications/i/item/9789240001367\">HEARTS technical package</a> (Healthy-lifestyle counselling, Evidence-based treatment protocols, Access to essential medicines and technology, Risk-based management, Team-based care, and Systems for monitoring) provide a strategic approach to improve cardiovascular health in countries across the world.</p><p>In September 2017, WHO began a partnership with Resolve to Save Lives, an initiative of Vital Strategies, to support national governments to implement the Global Hearts Initiative. Other partners contributing to the Global Hearts Initiative are the CDC Foundation, the Global Health Advocacy Incubator, the Johns Hopkins Bloomberg School of Public Health, the Pan American Health Organization (PAHO) and the U.S. CDC. Since implementation of the programme in 2017, in more than 40 low- and middle-income countries, 13.5 million people have been put on protocol-based hypertension treatment through person-centred models of care. These programmes demonstrate the feasibility and effectiveness of standardized hypertension control programmes.</p>', 'disease', 'storage/medical-content/rW0r2guwWxbkhltxVxurdLEkEvpBXsEIUsf1EIe7.jpg', 1, '2025-12-26 17:00:00', '2025-12-27 04:16:18', '2026-01-31 03:28:31'),
(4, 'Dengue fever: Dangerous warning signs', '<h2><strong>Overview</strong></h2><p>Dengue (break-bone fever) is a viral infection that is spread from mosquitoes to people. It is more common in tropical and subtropical than in temperate climates.</p><p>Most people who get dengue do not have symptoms. For those who do, the most common symptoms are high fever, headache, body aches, nausea and rash. Most get better in 1–2 weeks. Some develop severe dengue and need care in a hospital.&nbsp;</p><p>In severe cases, dengue can be fatal.&nbsp;&nbsp;</p><p>You can lower your risk of dengue by avoiding mosquito bites, especially during the day.</p><p>Dengue is treated through pain management as there is no specific treatment currently.</p><h2><strong>Symptoms</strong></h2><p>Most people with dengue have mild or no symptoms and will get better in 1–2 weeks. Rarely, dengue can be severe and lead to death. &nbsp;</p><p>If symptoms occur, they usually begin 4–10 days after infection and last for 2–7 days. Symptoms may include:</p><ul><li>high fever (40°C/104°F)</li><li>severe headache</li><li>pain behind the eyes</li><li>muscle and joint pains</li><li>nausea</li><li>vomiting</li><li>swollen glands</li><li>rash.&nbsp;</li></ul><p>Individuals who are infected for the second time are at greater risk of severe dengue.&nbsp;The symptoms of severe dengue often come after the fever has gone away and may include:</p><ul><li>severe abdominal pain</li><li>persistent vomiting</li><li>rapid breathing</li><li>bleeding gums or nose&nbsp;</li><li>fatigue</li><li>restlessness</li><li>blood in vomit or stool</li><li>being very thirsty</li><li>pale and cold skin</li><li>feeling weak.</li></ul><p>People with these severe symptoms should seek care immediately.&nbsp;&nbsp;</p><p>After recovery, people who have had dengue may experience fatigue for several weeks.</p><h2><strong>Diagnostics and treatment</strong></h2><p>Laboratory-based and point of care diagnostics are critical to control and manage dengue, yet global disparities in laboratory capabilities present significant challenges. The diagnostic algorithms, testing strategies and test methodologies employed vary, depending on the capabilities of national laboratory systems. The wide range of available tests – including nucleic acid amplification tests (NAATs), enzyme-linked immunosorbent assays (ELISAs) and rapid diagnostic tests (RDTs) – &nbsp;vary significantly in quality and performance.</p><p>Laboratory testing for arboviruses can be accomplished through either direct detection methods such as virus isolation, molecular detection of nucleic acid or antigen testing, including rapid diagnostic tests (RDTs) within the first week of illness.</p><p>There is no specific treatment for dengue, although pain can be managed with medication such as paracetamol (acetaminophen). Non-steroidal anti-inflammatory medicines such as ibuprofen and aspirin should be avoided as they can increase the risk of bleeding.</p><p>For people with severe dengue, hospitalization is often necessary.</p><p><strong>Global burden</strong></p><p>The incidence of dengue has grown dramatically worldwide in recent decades, with the number of cases reported to WHO increasing from 505&nbsp;430 cases in 2000 to 14.6 million in 2024. The vast majority of cases are asymptomatic or mild and self-managed, and hence the actual numbers of dengue cases are under-reported. The disease is now endemic in more than 100 countries.</p><p>In 2024, more cases of dengue were recorded than ever before in a 12-month period, affecting over 100 countries on all continents. During 2024, ongoing transmission, combined with an unexpected spike in dengue cases, resulted in a historic high of over 14.6 million cases and more than 12 000 dengue-related deaths reported. The Region of the Americas contributed&nbsp;a significant proportion of the global burden, with over 13 million cases reported to WHO.&nbsp;</p><p>Several factors are associated with the increasing risk of spread of the dengue epidemic, including the changing distribution of the responsible vectors (chiefly&nbsp;<i>Aedes aegypti and Aedes albopictus</i>), especially in previously dengue-naive countries; climate change leading to increasing temperatures, high rainfall and humidity; fragile and overburdened health systems; limitations in surveillance and reporting; and political and financial instabilities in countries facing complex humanitarian crises and high population movements.</p><p>One modelling estimate indicates 390&nbsp;million dengue virus infections per year, of which 96&nbsp;million manifest clinically(1).A recent study on the prevalence of dengue estimates that 5.6&nbsp;billion people are at risk of infection with dengue and other arboviruses(2).</p><p>From January to July 2025, over 4 million cases and over 3000 deaths have been reported to WHO from 97 countries.</p><p>Dengue is spreading to new areas, including the European and Eastern Mediterranean regions. In 2024, 308 cases were reported to WHO from three European countries (France, Italy and Spain) and an additional 1291 cases and four deaths were recorded in the French overseas territories of Mayotte and Réunion.&nbsp;</p><p><strong>Transmission</strong></p><h3><strong>Transmission through the mosquito bite</strong></h3><p>The dengue virus is transmitted to humans through the bites of infected female mosquitoes, primarily the&nbsp;<i>Aedes aegypti</i>&nbsp;mosquito. Other species within the <i>Aedes</i> genus can also act as vectors, but their contribution is normally secondary to&nbsp;<i>Aedes aegypti</i>.</p><p>After feeding on a DENV-infected person, the virus replicates in the mosquito midgut before disseminating to secondary tissues, including the salivary glands. The time it takes from ingesting the virus to actual transmission to a new host is termed the extrinsic incubation period (EIP). The EIP takes about 8–12 days when the ambient temperature is 25–28°C. Variations in the EIP are not only influenced by ambient temperature but also by several other factors&nbsp;– such as the magnitude of daily temperature fluctuations, the virus genotype, and the initial viral concentration&nbsp;– which can also alter the time it takes for a mosquito to transmit the virus. Once infectious, a mosquito can transmit the virus for the rest of its life.</p><h3><strong>Human-to-mosquito transmission</strong></h3><p>Mosquitoes can become infected by people who are viremic with DENV. This can be someone who has a symptomatic dengue infection, someone who is yet to have a symptomatic infection (those who are pre-symptomatic), and also someone who shows no signs of illness (those who are asymptomatic).</p><p>Human-to-mosquito transmission can occur up to 2 days before someone shows symptoms of the illness, and up to 2 days after the fever has resolved.</p><p>The risk of mosquito infection is positively associated with high viremia and high fever in the patient; conversely, high levels of DENV-specific antibodies are associated with a decreased risk of mosquito infection. Most people are viremic for about 4–5 days, but viremia can last as long as 12 days.</p><h3><strong>Maternal transmission</strong></h3><p>The primary mode of transmission of the DENV between humans involves mosquito vectors. There is evidence, however, of the possibility of maternal transmission (i.e. from a pregnant mother to her baby). At the same time, vertical transmission rates appear low, with the risk of vertical transmission seemingly linked to the timing of acquiring the dengue infection during pregnancy. When a mother does have a dengue infection when she is pregnant, babies may suffer from pre-term birth, low birthweight and fetal distress.</p><h3><strong>Other transmission modes</strong></h3><p>Rare cases of transmission via blood products, organ donation and transfusions have been recorded. Similarly, transovarial transmission of the virus within mosquitoes has also been recorded.&nbsp;</p><h2><strong>Risk factors</strong></h2><p>Previous infection with DENV increases the risk of an individual developing severe dengue.</p><p>Urbanization (especially rapid, unplanned urbanization), is associated with dengue transmission through multiple social and environmental factors: population density, human mobility, access to reliable water source, water storage practices, etc.</p><p>Community risks to dengue also depend on population knowledge, attitudes and practices towards dengue, as exposure is closely related to behaviours such as water storage, plant-keeping and self-protection against mosquito bites. Routine vector surveillance and control activities and targeted community engagement greatly enhance resilience.&nbsp;</p><p>Vectors can adapt to new environments and climate. The interaction between the dengue virus, the host and the environment is dynamic. Consequently, disease risks may change and shift with climate change in tropical and subtropical areas, in combination with increased urbanization and population movement.</p><h2><strong>Prevention and control</strong></h2><p>The mosquitoes that spread dengue are active during the day.&nbsp;</p><p>To lower your risk of getting dengue, protect yourself from mosquito bites by using:&nbsp;</p><ul><li>clothes that cover as much of your body as possible;</li><li>mosquito nets, ideally sprayed with insect repellent, if sleeping during the day;</li><li>window screens;</li><li>mosquito repellents (containing DEET, Picaridin or IR3535); and</li><li>coils and vaporizers.</li></ul><p>To prevent mosquitoes from breeding:</p><ul><li>implement environmental management and modification practices to stop mosquitoes from accessing egg-laying habitats;</li><li>dispose of solid waste properly and remove artificial habitats that can hold water;</li><li>cover, empty and clean domestic water storage containers on a weekly basis; and</li><li>apply appropriate insecticides to water storage outdoor containers.</li></ul><p>If you get dengue, it’s important to:</p><ul><li>rest;</li><li>drink plenty of liquids;</li><li>use acetaminophen (paracetamol) for pain;</li><li>avoid non-steroidal anti-inflammatory medication such as ibuprofen and aspirin; and</li><li>watch for severe symptoms and contact your doctor as soon as possible if you notice any.</li></ul><p>Currently, one vaccine (QDenga) is available and licensed in some countries. However, it is recommended only for those aged 6–16 years in high transmission settings. Several additional vaccines are under evaluation.</p><p><strong>WHO response</strong></p><p>WHO responds to dengue by:</p><ul><li>supporting countries in the confirmation of outbreaks through its collaborating network of laboratories;</li><li>providing technical advice and guidance to countries for the effective management of dengue outbreaks;</li><li>supporting countries to improve their reporting systems and capture the true burden of the disease;</li><li>providing training on clinical management, diagnosis and vector control at the country and regional levels in collaboration with its collaborating centres;</li><li>formulating evidence-based strategies and policies;</li><li>supporting countries to develop dengue prevention and control strategies and adopt the Global Vector Control Response (2017–2030) and the Global Arbovirus Initiative (2022–2025);</li><li>reviewing and making recommendations on the development of new tools, including insecticide products and application technologies;</li><li>gathering official records of dengue and severe dengue from over 100 Member States; and</li><li>publishing guidance and handbooks for surveillance, case management, diagnosis, dengue prevention and control for Member States.</li></ul>', 'disease', 'storage/medical-content/IX76bzZrpNKBl3whqNgZnAaM96nCXoeUgKUDfqT5.png', 1, '2025-12-26 17:00:00', '2025-12-27 04:16:18', '2026-01-31 03:32:32'),
(5, 'A unified call for One Health: driving implementation, science, policy and investment for global impact', '<p><i>Issued at the Third Quadripartite Executive Annual Meeting, 25–27 March 2025, WOAH headquarters, Paris</i></p><p>As global leaders in human, animal and environmental health, the Quadripartite collaboration comprising the Food and Agriculture Organization of the United Nations (FAO), the United Nations Environment Programme (UNEP), the World Health Organization (WHO), and the World Organisation for Animal Health (WOAH) reaffirms its unwavering commitment to advancing the One Health approach. This integrated approach is essential to sustainably balance and optimize the health of people, animals, plants and ecosystems and to address health risks at the human-animal-environment interface. Meeting at WOAH headquarters in Paris for the Third Quadripartite Executive Annual Meeting, we call for urgent, strategic and sustained support and investments to scale up One Health implementation worldwide.</p><h3><strong>Advancing the One Health agenda</strong></h3><p>Since its establishment in March 2022, the Quadripartite has made significant progress in four strategic priority areas.</p><ol><li><strong>Implementation of the</strong> <a href=\"https://www.who.int/publications/i/item/9789240059139\">One Health Joint Plan of Action (OH JPA)</a>. Over the past year, the Quadripartite has strengthened cross-sectoral collaboration through regional and sub-regional One Health workshops in Europe, central Asia, and Pacific islands, leading to increased adoption of the OH JPA at the national level. Capacity-building efforts have expanded, with multiple country-level workshops focusing on workforce development, joint risk assessments and multisectoral coordination mechanisms. Additionally, key implementation tools have been translated into multiple languages, increasing their accessibility and adoption.</li><li><strong>Strengthening One Health science and evidence</strong>. The second term of the Quadripartite <a href=\"https://www.who.int/groups/one-health-high-level-expert-panel\">One Health High-Level Expert Panel (OHHLEP)</a> has been established, broadening its expertise to include social sciences, economics and governance. Key scientific deliverables will include mapping international legal and policy instruments that have a bearing on One Health and analysing barriers and enablers of One Health implementation. The Quadripartite One Health Knowledge Nexus serves as an interactive space for collective knowledge generation and co-learning. Under this platform, a joint Community of Practice was launched in November 2023 on the return on investment for One Health. A new community of practice on One Health governance is planned to be launched in 2025. In 2024, the Quadripartite contributed actively to the 8th World One Health Congress and several other international scientific fora to strengthen partnerships with the scientific community.</li><li><strong>Enhancing political engagement and advocacy</strong>. The Quadripartite played a significant role in global political processes, advocating for the inclusion of One Health in major discussions and declarations. This includes supporting the adoption of a <a href=\"https://press.un.org/en/2024/ga12642.doc.htm\">UN General Assembly political declaration</a> on antimicrobial resistance (AMR) and advocating for One Health integration in G20 health ministerial discussions and declarations. Additionally, the Quadripartite contributed to the adoption of a Global Action Plan on Biodiversity and Health at the Convention on Biological Diversity (COP16) and hosted a high-level One Health event at UN Climate Change Conference (COP29) to promote climate-health policy integration.</li><li><strong>Mobilizing investments for One Health</strong>. The Quadripartite is developing a Joint Offer – a unified advocacy document for targeted One Health investments. This effort will be bolstered by structured outreach to funding partners through roundtable discussions and high-level dialogues. The Quadripartite continues to advocate for embedding One Health in existing financial mechanisms, and strengthening regional and national One Health investment planning to catalyse broader financial commitments, ensuring sustainable investments at national and global levels.</li></ol><h3><strong>Investing in One Health now</strong></h3><p>The complexity of today’s health challenges – ranging from AMR and zoonotic diseases to food safety risks and climate-related health threats, amongst others – demands an integrated and well-resourced One Health response. Investing in One Health is not an option; it is an imperative. It is a strategic and cost-effective approach to preventing future health crises, reducing economic losses, strengthening global health security and promoting sustainable development.</p><p>The Quadripartite underscores that investing in One Health today is an investment in a safer, healthier and more resilient future. The world cannot afford to wait. We call on policymakers, donors and global leaders to act decisively, turning commitments into concrete actions and ensuring that One Health is effectively implemented, leaving no one behind.</p><p><strong>Related</strong></p><p><a href=\"https://www.who.int/health-topics/one-health\">One health</a></p><p><a href=\"https://www.who.int/teams/one-health-initiative/quadripartite-secretariat-for-one-health/one-health-joint-plan-of-action\">One Health Joint Plan of Action</a></p><p><a href=\"https://www.who.int/teams/one-health-initiative/quadripartite-secretariat-for-one-health\">Quadripartite Secretariat for One Health</a></p><p><strong>Fact sheets</strong></p><p>&nbsp;</p><p><a href=\"https://www.who.int/news-room/fact-sheets/detail/one-health\"><strong>One Health</strong> 23 October 2023</a></p><p>&nbsp;</p><ul><li><br>&nbsp;</li></ul>', 'news', 'storage/medical-content/UBZYFHUh7K1OwAboPzQJPh4sFWKfi9cJ1bsCZioZ.png', 1, '2025-12-26 17:00:00', '2025-12-27 04:16:18', '2026-01-31 03:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
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
(34, '2026_01_24_080759_update_notifications_table_to_standard', 15),
(35, '2026_01_28_160306_modify_certificate_column_in_doctor_profiles_table', 16),
(36, '2026_01_28_162342_add_rejection_reason_to_doctor_profiles_table', 17),
(37, '2026_01_29_051913_add_cancellation_reason_to_appointments_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
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
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('009f142d-65c5-4d48-96ac-bc6ce45219b7', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":32,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #32\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 02:21:11', '2026-01-24 05:19:50'),
('0e7dbddf-feb7-43c2-9b14-1c9ef5db6a10', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 2, '{\"appointment_id\":45,\"message\":\"B\\u1ea1n c\\u00f3 l\\u1ecbch h\\u1eb9n m\\u1edbi t\\u1eeb Patient1 v\\u00e0o ng\\u00e0y 2026-02-01 l\\u00fac 10:00:00.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/appointments\",\"type\":\"new_booking\"}', NULL, '2026-01-31 05:24:43', '2026-01-31 05:24:43'),
('12483293-5027-49d7-aba2-0123cca66649', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":34,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #34\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:13:42', '2026-01-24 05:19:50'),
('192ff555-bcea-499d-afdf-86985a0de0e2', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":31,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #31\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 02:20:29', '2026-01-24 02:05:29', '2026-01-24 02:20:29'),
('23aef568-1b93-4d2f-8868-bc0fce807194', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-30 06:40:39', '2026-01-30 06:40:39'),
('2dfbe093-a278-4dc4-9495-04410805a70a', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":35,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #35\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:14:23', '2026-01-24 05:19:50'),
('35740e72-11f6-4975-bbc6-1fbc2e795697', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 19, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 03:04:58', '2026-01-31 03:04:58'),
('3c019e6f-1fbb-4918-a244-c426e814cacd', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 2, '{\"appointment_id\":43,\"message\":\"B\\u1ea1n c\\u00f3 l\\u1ecbch h\\u1eb9n m\\u1edbi t\\u1eeb Patient1 v\\u00e0o ng\\u00e0y 2026-02-01 l\\u00fac 10:00:00.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/appointments\",\"type\":\"new_booking\"}', NULL, '2026-01-31 05:08:44', '2026-01-31 05:08:44'),
('453c7cf2-65e6-4ddb-add0-1ad0750920ec', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":43,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #43\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', NULL, '2026-01-31 05:08:44', '2026-01-31 05:08:44'),
('456b06ac-391f-4b0f-8901-3af2d4d9f9dc', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":39,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #39\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-30 05:37:58', '2026-01-28 22:21:37', '2026-01-30 05:37:58'),
('4df3aa53-4934-420e-a44a-1a61c3c0eefa', 'App\\Notifications\\ProfileUpdated', 'App\\Models\\User', 1, '{\"user_id\":2,\"name\":\"Minh T\\u00e2m\",\"role\":\"doctor\",\"message\":\"Ng\\u01b0\\u1eddi d\\u00f9ng Minh T\\u00e2m (doctor) v\\u1eeba c\\u1eadp nh\\u1eadt h\\u1ed3 s\\u01a1.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\"}', NULL, '2026-01-31 05:15:56', '2026-01-31 05:15:56'),
('500d3662-efaf-44fe-92a3-3c615e446dbd', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 05:18:02', '2026-01-31 05:18:02'),
('5f7b3a9e-90d8-449d-9929-11721f9ef26f', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 03:34:20', '2026-01-31 03:34:20'),
('60c833c7-fff4-41b3-beeb-e0d09970d479', 'App\\Notifications\\ProfileUpdated', 'App\\Models\\User', 1, '{\"user_id\":2,\"name\":\"Minh T\\u00e2m\",\"role\":\"doctor\",\"message\":\"Ng\\u01b0\\u1eddi d\\u00f9ng Minh T\\u00e2m (doctor) v\\u1eeba c\\u1eadp nh\\u1eadt h\\u1ed3 s\\u01a1.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/dashboard\"}', NULL, '2026-01-30 05:55:33', '2026-01-30 05:55:33'),
('640b79f3-88b9-47ee-80ca-b2f9863dad44', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 20, '{\"appointment_id\":45,\"message\":\"L\\u1ecbch h\\u1eb9n c\\u1ee7a b\\u1ea1n v\\u1edbi BS. Minh T\\u00e2m \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/my-appointments\",\"type\":\"status_update\"}', NULL, '2026-01-31 05:25:54', '2026-01-31 05:25:54'),
('6ef66658-fcbc-4448-8e39-6b8425415185', 'App\\Notifications\\NewDoctorRegistered', 'App\\Models\\User', 1, '{\"type\":\"new_doctor\",\"user_id\":19,\"message\":\"B\\u00e1c s\\u0129 m\\u1edbi \\u0111\\u0103ng k\\u00fd: T\\u00cdn\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/doctors\"}', NULL, '2026-01-31 00:03:07', '2026-01-31 00:03:07'),
('7238a88e-9010-47b7-a57a-a62cf1d3f311', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 20, '{\"appointment_id\":43,\"message\":\"L\\u1ecbch h\\u1eb9n c\\u1ee7a b\\u1ea1n v\\u1edbi BS. Minh T\\u00e2m \\u0111\\u00e3 ho\\u00e0n th\\u00e0nh.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/my-appointments\",\"type\":\"status_update\"}', NULL, '2026-01-31 05:14:12', '2026-01-31 05:14:12'),
('78045ca2-53ba-4d6c-b28b-a1813a146568', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 03:34:45', '2026-01-31 03:34:45'),
('78ef21ec-8e74-4806-90d7-9eeb6ddbc3e4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 20, '{\"appointment_id\":44,\"message\":\"L\\u1ecbch h\\u1eb9n c\\u1ee7a b\\u1ea1n v\\u1edbi BS. Minh T\\u00e2m \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/my-appointments\",\"type\":\"status_update\"}', NULL, '2026-01-31 05:21:21', '2026-01-31 05:21:21'),
('7a73b61d-0af5-401d-92e3-18622f72de2a', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 19, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 03:04:57', '2026-01-31 03:04:57'),
('819f346e-f116-4f56-8b55-3f14687a18f4', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":40,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #40\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-30 05:37:58', '2026-01-28 22:24:37', '2026-01-30 05:37:58'),
('8cd5dd95-bb88-4543-b05a-4505be1f501c', 'App\\Notifications\\NewDoctorRegistered', 'App\\Models\\User', 1, '{\"type\":\"new_doctor\",\"user_id\":18,\"message\":\"B\\u00e1c s\\u0129 m\\u1edbi \\u0111\\u0103ng k\\u00fd: Minh Ho\\u00e0ng\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/doctors\"}', '2026-01-24 05:27:20', '2026-01-24 05:25:45', '2026-01-24 05:27:20'),
('97640d43-5a07-41b4-9246-a412cadfd2e8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 20, '{\"appointment_id\":43,\"message\":\"L\\u1ecbch h\\u1eb9n c\\u1ee7a b\\u1ea1n v\\u1edbi BS. Minh T\\u00e2m \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c x\\u00e1c nh\\u1eadn.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/my-appointments\",\"type\":\"status_update\"}', NULL, '2026-01-31 05:14:02', '2026-01-31 05:14:02'),
('99e736fa-fd9f-4dd6-8e6d-4a900a9f79af', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":45,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #45\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', NULL, '2026-01-31 05:24:43', '2026-01-31 05:24:43'),
('a217677e-24b7-4951-bbbc-d99c7ee2f357', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been rejected. Reason: wrong document\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_rejected\"}', NULL, '2026-01-31 03:34:12', '2026-01-31 03:34:12'),
('af5cac42-3670-480a-8e43-3c8b8ac2518c', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":30,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #30\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 01:34:48', '2026-01-24 01:34:16', '2026-01-24 01:34:48'),
('b5dc5859-24e4-4389-bc94-f3380bffc5e2', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":44,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #44\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', NULL, '2026-01-31 05:19:53', '2026-01-31 05:19:53'),
('b934e88f-1c9f-4c4a-86d1-eb5eb2cfb650', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 2, '{\"appointment_id\":42,\"message\":\"B\\u1ea1n c\\u00f3 l\\u1ecbch h\\u1eb9n m\\u1edbi t\\u1eeb Kh\\u00e1ch 1 v\\u00e0o ng\\u00e0y 2026-01-31 l\\u00fac 09:30:00.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/appointments\",\"type\":\"new_booking\"}', NULL, '2026-01-30 05:42:59', '2026-01-30 05:42:59'),
('d4d938ca-dd63-40fc-b147-2e2ed300563d', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":33,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #33\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-24 05:19:50', '2026-01-24 03:04:11', '2026-01-24 05:19:50'),
('dab02625-e218-4a33-a85d-b2414174d71a', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-31 03:33:38', '2026-01-31 03:33:38'),
('dad753f4-c836-40bf-a585-4e571764f99c', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":41,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #41\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-30 05:37:58', '2026-01-30 01:55:00', '2026-01-30 05:37:58'),
('e4c8c359-68f2-4e68-9a82-d4d69ffb9490', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\User', 2, '{\"appointment_id\":44,\"message\":\"B\\u1ea1n c\\u00f3 l\\u1ecbch h\\u1eb9n m\\u1edbi t\\u1eeb Patient1 v\\u00e0o ng\\u00e0y 2026-02-01 l\\u00fac 10:00:00.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/appointments\",\"type\":\"new_booking\"}', NULL, '2026-01-31 05:19:53', '2026-01-31 05:19:53'),
('ea8e5f65-06cb-4be7-be7b-88a1a3f2cbec', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been rejected. Reason: wrong document\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_rejected\"}', NULL, '2026-01-31 03:34:13', '2026-01-31 03:34:13'),
('ec37d32c-a890-4aa3-8fb5-eb134f806b8e', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":42,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #42\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', NULL, '2026-01-30 05:42:59', '2026-01-30 05:42:59'),
('f6b41122-3f8d-45d3-9412-c8aaf0883988', 'App\\Notifications\\NewAppointmentCreated', 'App\\Models\\User', 1, '{\"type\":\"new_appointment\",\"appointment_id\":38,\"message\":\"L\\u1ecbch h\\u1eb9n m\\u1edbi #38\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/appointments\"}', '2026-01-30 05:18:03', '2026-01-28 22:11:38', '2026-01-30 05:18:03'),
('fcdcf478-9560-4119-89bd-0b346d2c737b', 'App\\Notifications\\SystemNotification', 'App\\Models\\User', 2, '{\"message\":\"Your doctor profile has been approved. You can now start using the platform.\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/doctor\\/profile\",\"type\":\"profile_approved\"}', NULL, '2026-01-30 06:40:38', '2026-01-30 06:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
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
-- Table structure for table `patient_profiles`
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
-- Dumping data for table `patient_profiles`
--

INSERT INTO `patient_profiles` (`id`, `user_id`, `phone`, `address`, `date_of_birth`, `gender`, `medical_history`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, NULL, NULL, NULL, NULL, '2026-01-15 04:00:39', '2026-01-15 04:00:39'),
(6, 2, NULL, NULL, NULL, NULL, NULL, '2026-01-15 06:19:35', '2026-01-15 06:19:35'),
(12, 14, '0123456789', 'Q1', NULL, NULL, NULL, '2026-01-22 09:06:07', '2026-01-22 09:06:07'),
(13, 16, '0123456789', 'Q2', NULL, NULL, NULL, '2026-01-24 01:03:30', '2026-01-24 01:03:30'),
(15, 20, '0123456789', 'A123', NULL, NULL, NULL, '2026-01-31 05:05:31', '2026-01-31 05:05:31');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
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
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `summary`, `content`, `image`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Cúm mùa và cách phòng tránh', 'cum-mua', 'Các biện pháp đơn giản để bảo vệ bản thân khỏi cúm mùa.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Disease+Prevention', 'disease', '2025-12-30 05:26:47', NULL),
(2, 'Công nghệ AI trong chẩn đoán ung thư', 'ai-ung-thu', 'Phát minh mới giúp phát hiện ung thư sớm nhờ trí tuệ nhân tạo.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Invention', 'invention', '2025-12-30 05:26:47', NULL),
(3, 'Bộ Y tế khuyến cáo về dịch sốt xuất huyết', 'sot-xuat-huyet', 'Số ca mắc tăng cao, người dân cần chủ động diệt muỗi.', 'Nội dung chi tiết...', 'https://via.placeholder.com/600x400?text=Medical+News', 'news', '2025-12-30 05:26:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
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
-- Table structure for table `specializations`
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
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `image_url`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Cardiologist', NULL, 'Specializing in heart disease treatment.', NULL, NULL, '2026-01-31 03:18:51'),
(2, 'Pediatrics', NULL, 'Khám cho trẻ em', NULL, NULL, '2026-01-31 03:22:59'),
(3, 'Dermatology', NULL, 'Các bệnh về da', NULL, NULL, '2026-01-31 03:22:59'),
(4, 'Internal Medicine', NULL, 'Chuyên khoa nội khoa tổng quát, điều trị các bệnh lý nội khoa', NULL, '2026-01-03 03:52:15', '2026-01-31 03:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `role`, `status`, `image`, `remember_token`, `created_at`, `updated_at`, `city_id`, `avatar`) VALUES
(1, 'Administrator', 'admin@mediconnect.com', NULL, NULL, NULL, '$2y$12$dknZCb8su46UEsJ7n1ayi.NTEPc9yRcRS9eGEs71FVm8NDNBMVKdO', 'admin', 'active', NULL, '9Bod79RmD1ire4daWK8zET993Pr1aSjunmIBHLoF9NTzCokSrAkk3t6TIxQ7', NULL, '2026-01-22 06:12:46', NULL, NULL),
(2, 'Minh Tâm', 'bacsitam@mediconnect.com', NULL, NULL, NULL, '$2y$12$clnXbMosgKplOicl5P.qXeLzRm9CEVnu0E0XJC3axEW6v8Y1gm2Lq', 'doctor', 'active', 'avatars/DXuXoi42VnsXaNxHCFRvhIkhaSS1JTSP13FEMahx.jpg', NULL, NULL, '2026-01-28 20:14:40', NULL, NULL),
(14, 'Khách 1', 'khach1@mediconnect.com', '0123456789', 'Q1', NULL, '$2y$12$DRNSfWMn1Vr3Oq1CIgNWPOIIwIJpKW2zmUv/X5K5V0ITjH0NVZkIu', 'patient', 'active', NULL, 'Rob7lBpWkTmwMySjy69tpEiCAGQujNeyBxpHKCToekqjYRVPe3RKETEbVGyL', '2026-01-22 09:06:07', '2026-01-22 09:06:07', 2, NULL),
(16, 'Khách 2', 'khach2@mediconnect.com', '0123456789', 'Q2', NULL, '$2y$12$Uo4Z8pIoAtqs1WcoKZvdzOcDuoRrrZ6v120QvVXV0ottGMCgCG3gu', 'patient', 'active', NULL, NULL, '2026-01-24 01:03:30', '2026-01-24 01:03:30', 2, NULL),
(19, 'TÍn', 'bacsitin@gmail.com', '0769862328', '65/5A Trần Văn Mười, Xuân thới đông, Hóc Môn TPHCM', NULL, '$2y$12$5bIiiXBmfVNh.oTkGFOTGOtexF6VrLpug9FmhOrKbPmn6gK7xsjJq', 'doctor', 'active', NULL, NULL, '2026-01-31 00:03:03', '2026-01-31 00:03:03', 2, NULL),
(20, 'Patient1', 'Patient1@mediconnect.com', '0123456789', 'A123', NULL, '$2y$12$CFGJc8T1.1fvf1B3NrwzCOe3QDv/Zd2qoeaRWzWyjqOq3ljYh/Uny', 'patient', 'active', NULL, NULL, '2026-01-31 05:05:31', '2026-01-31 05:05:31', 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_created_by_foreign` (`created_by`),
  ADD KEY `appointments_date_index` (`date`),
  ADD KEY `appointments_status_index` (`status`),
  ADD KEY `appointments_patient_id_status_index` (`patient_id`,`status`),
  ADD KEY `appointments_doctor_id_status_index` (`doctor_id`,`status`);

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
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_availabilities_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_city_id_foreign` (`city_id`),
  ADD KEY `doctor_profiles_specialization_id_index` (`specialization_id`),
  ADD KEY `doctor_profiles_user_id_index` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_user_id_foreign` (`user_id`),
  ADD KEY `feedbacks_doctor_id_foreign` (`doctor_id`),
  ADD KEY `feedbacks_appointment_id_foreign` (`appointment_id`);

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
-- Indexes for table `medical_content`
--
ALTER TABLE `medical_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_content_author_id_foreign` (`author_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_records_appointment_id_unique` (`appointment_id`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Indexes for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_index` (`city_id`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_content`
--
ALTER TABLE `medical_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_availabilities`
--
ALTER TABLE `doctor_availabilities`
  ADD CONSTRAINT `doctor_availabilities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD CONSTRAINT `doctor_profiles_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `feedbacks_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`),
  ADD CONSTRAINT `feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medical_content`
--
ALTER TABLE `medical_content`
  ADD CONSTRAINT `medical_content_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD CONSTRAINT `patient_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
