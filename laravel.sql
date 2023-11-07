-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 09:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `id` int(5) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '1=progress, \r\n2=extend, \r\n3=done',
  `status_customer` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=no confirm,\r\n2=confirm',
  `created_by` varchar(50) DEFAULT NULL,
  `defect_id` int(5) DEFAULT NULL,
  `project_id` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`id`, `title`, `detail`, `image`, `status`, `status_customer`, `created_by`, `defect_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'ฝ้าเพดานรั่ว ห้อง A', 'ฝ้ามุมขวาห้องมีน้ำซึม', '{\"urls\":[\"1698054557_i7jSvqZhIe.png\"]}', 1, 1, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 16:49:17', '2023-10-23 16:51:20'),
(2, 'พื้นบวม ห้อง A', NULL, '{\"urls\":[\"1698054719_rGx2vW4dzY.png\"]}', 1, 1, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 16:51:59', '2023-10-29 08:07:22'),
(3, 'สีกำแพงห้อง C ไม่เรียบร้อย', 'ทาสียังไม่เรียบร้อย', '{\"urls\":[\"1698054895_z0ayoYdQgX.png\"]}', 2, 1, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 16:54:55', '2023-10-27 22:50:25'),
(4, 'ฝ้าเพดานรั่ว ห้อง B', 'มีน้ำซึมที่ฝ้าเพดานห้อง B', '{\"urls\":[\"1698055718_CUV73glqBk.png\",\"1698055718_8IpmH0ygcE.png\"]}', 3, 2, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 17:08:38', '2023-10-23 19:09:15'),
(5, 'พื้นบวม ห้อง B', NULL, '{\"urls\":[\"1698055743_6PlxkbVEQs.png\",\"1698055743_9i4Nt0c15m.png\"]}', 3, 2, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 17:09:03', '2023-10-23 19:47:10'),
(6, 'สีกำแพงห้อง B ไม่เรียบร้อย', 'ทาสียังไม่เรียบร้อย', '{\"urls\":[\"1698055770_HOCcMZeKHE.png\",\"1698055770_oZX8cqiKxA.png\",\"1698055770_XxB2u4Zxl1.png\"]}', 3, 2, 'แอดมิน ทดสอบ', 1, 1, '2023-10-23 17:09:30', '2023-10-23 20:03:39'),
(7, 'พื้นห้องยังไม่เรียบร้อย', 'พื้นห้อง A ไม่เรียบร้อย', '{\"urls\":[\"1698068046_X4keGQSut1.png\",\"1698068046_a8iV7k4h5w.png\",\"1698068046_YI6jqzAr2P.png\"]}', 3, 1, 'แอดมิน ทดสอบ', 2, 2, '2023-10-23 20:34:06', '2023-10-23 20:36:09'),
(8, 'ทาสีกำแพงยังไม่เรียบร้อย', NULL, '{\"urls\":[\"1698160327_g4F4iDAd0p.png\",\"1698160327_3NxMcrR2nG.png\"]}', 3, 1, 'แอดมิน ทดสอบ', 4, 1, '2023-10-24 22:12:07', '2023-10-24 22:12:33');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_comment`
--

CREATE TABLE `checklist_comment` (
  `id` int(5) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 2 COMMENT '1=employee, 2=customer',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=progress(emp),\r\n1=unfinished(cus),\r\n2=done\r\n3=delete',
  `checklist_id` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklist_comment`
--

INSERT INTO `checklist_comment` (`id`, `username`, `comment`, `image`, `type`, `status`, `checklist_id`, `created_at`, `updated_at`) VALUES
(1, 'พนักงาน ทดสอบ', 'กำลังดำเนินการแก้ไขครับ', '1698057678_rgIy0NfxEX.png', 1, 0, 4, '2023-10-23 17:41:18', '2023-10-23 17:41:18'),
(2, 'พนักงาน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698062061_Ep5ITc2ZzS.png', 1, 0, 4, '2023-10-23 18:54:21', '2023-10-23 18:54:21'),
(3, 'ลูกค้า', 'รบกวนแก้ไขมุมหลังห้อง B เพิ่มอีกจุดด้วยครับ', '1698062145_cV0ajUdElv.png', 2, 1, 4, '2023-10-23 18:55:45', '2023-10-23 18:55:45'),
(4, 'แอดมิน ทดสอบ', 'แก้ไขเรียบร้อยครับ', '1698062584_d3qP8gOc0N.png', 1, 0, 4, '2023-10-23 19:03:04', '2023-10-23 19:03:04'),
(5, 'ลูกค้า', 'ขอบคุณครับ ขอปิดเช็คลิสต์นี้ครับ', NULL, 2, 2, 4, '2023-10-23 19:09:15', '2023-10-23 19:09:15'),
(6, 'แอดมิน ทดสอบ', 'พนักงานกำลังแก้ไขครับ', '1698063270_Ch2T2nP9EJ.png', 1, 0, 5, '2023-10-23 19:14:30', '2023-10-23 19:14:30'),
(7, 'พนักงาน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698064814_zK2A9YfNdv.png', 1, 0, 5, '2023-10-23 19:40:14', '2023-10-23 19:40:14'),
(8, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 5, '2023-10-23 19:42:00', '2023-10-23 19:42:00'),
(9, 'ลูกค้า', 'ผมขอเพิ่มอย่างนึงครับ ช่วยเคลียร์พื้นด้วยนะครับ', '1698065105_u3bXYPfJp0.png', 2, 1, 5, '2023-10-23 19:45:05', '2023-10-23 19:45:05'),
(10, 'พนักงาน ทดสอบ', 'จัดการเรียบร้อยครับ', '1698065134_jQtsyGLCKu.png', 1, 0, 5, '2023-10-23 19:45:34', '2023-10-23 19:45:34'),
(11, 'พนักงาน ทดสอบ', 'ยังมีส่วนไหนอีกไหมครับ', NULL, 1, 0, 5, '2023-10-23 19:46:23', '2023-10-23 19:46:23'),
(12, 'ลูกค้า', 'ห้องนี้ไม่เหลือแล้วครับ ขอบคุณครับ', NULL, 2, 2, 5, '2023-10-23 19:47:10', '2023-10-23 19:47:10'),
(13, 'พนักงาน ทดสอบ', 'กำลังแก้ไขครับ', '1698065279_OqEb5g89Uw.png', 1, 0, 6, '2023-10-23 19:47:59', '2023-10-23 19:47:59'),
(14, 'พนักงาน ทดสอบ', 'เสร็จเรียบร้อยครับ', '1698065542_2ahkrsdQkn.png', 1, 0, 6, '2023-10-23 19:52:22', '2023-10-23 19:52:22'),
(15, 'แอดมิน ทดสอบ', 'มีตรงไหนต้องแก้อีกไหมครับ', NULL, 1, 0, 6, '2023-10-23 19:52:51', '2023-10-23 19:52:51'),
(16, 'ลูกค้า', 'มุมห้องด้านหลังด้วยนะครับ', '1698065615_j3qLqmRn0d.png', 2, 1, 6, '2023-10-23 19:53:35', '2023-10-23 19:53:35'),
(17, 'แอดมิน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698065946_kL0VTbK5xs.png', 1, 0, 6, '2023-10-23 19:59:06', '2023-10-23 19:59:06'),
(18, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 6, '2023-10-23 20:03:18', '2023-10-23 20:03:18'),
(19, 'แอดมิน ทดสอบ', 'ปิดเช็คลิสต์ครับ', NULL, 1, 2, 6, '2023-10-23 20:03:39', '2023-10-23 20:03:39'),
(20, 'แอดมิน ทดสอบ', 'กำลังแก้ไขครับ', '1698067390_GOZII7vFIa.png', 1, 0, 3, '2023-10-23 20:23:10', '2023-10-23 20:23:10'),
(21, 'แอดมิน ทดสอบ', 'กำลังแก้ไขครับ', '1698068063_8bOb0RdMID.png', 1, 0, 7, '2023-10-23 20:34:23', '2023-10-23 20:34:23'),
(22, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 7, '2023-10-23 20:35:46', '2023-10-23 20:35:46'),
(23, 'แอดมิน ทดสอบ', 'ปิดเช็คลิสต์ครับ', NULL, 1, 2, 7, '2023-10-23 20:36:09', '2023-10-23 20:36:09'),
(24, 'แอดมิน ทดสอบ', 'กำลังดำเนินการแก้ไขครับ', '1698160345_SMAXqB1rnx.png', 1, 0, 8, '2023-10-24 22:12:25', '2023-10-24 22:12:25'),
(25, 'แอดมิน ทดสอบ', 'ปิดเช็คลิสต์ครับ', NULL, 1, 2, 8, '2023-10-24 22:12:33', '2023-10-24 22:12:33'),
(26, 'ลูกค้า', 'ขอบคุณครับ', NULL, 2, 1, 3, '2023-10-27 22:26:22', '2023-10-27 22:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_comment_log`
--

CREATE TABLE `checklist_comment_log` (
  `id` int(5) NOT NULL,
  `comment_by` varchar(50) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL COMMENT '1=employee, 2=customer',
  `status` tinyint(3) DEFAULT NULL COMMENT '0=progress(emp), 1=unfinished(cus), 2=done	',
  `checklist_id` int(5) DEFAULT NULL,
  `action` tinyint(3) DEFAULT NULL COMMENT '0=edited,\r\n1=deleted,\r\n2=first',
  `action_by` varchar(100) DEFAULT NULL,
  `checklist_comment_id` int(5) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklist_comment_log`
--

INSERT INTO `checklist_comment_log` (`id`, `comment_by`, `comment`, `image`, `type`, `status`, `checklist_id`, `action`, `action_by`, `checklist_comment_id`, `created_at`, `updated_at`) VALUES
(1, 'พนักงาน ทดสอบ', 'กำลังดำเนินการแก้ไขครับ', '1698057678_rgIy0NfxEX.png', 1, 0, 4, 2, 'พนักงาน ทดสอบ', 1, '2023-10-23 17:41:18', '2023-10-23 17:41:18'),
(2, 'พนักงาน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698062061_Ep5ITc2ZzS.png', 1, 0, 4, 2, 'พนักงาน ทดสอบ', 2, '2023-10-23 18:54:21', '2023-10-23 18:54:21'),
(3, 'ลูกค้า', 'รบกวนแก้ไขมุมหลังห้อง B เพิ่มอีกจุดด้วยครับ', '1698062145_cV0ajUdElv.png', 2, 1, 4, 2, 'ลูกค้า', 3, '2023-10-23 18:55:45', '2023-10-23 18:55:45'),
(4, 'แอดมิน ทดสอบ', 'แก้ไขเรียบร้อยครับ', '1698062584_d3qP8gOc0N.png', 1, 0, 4, 2, 'แอดมิน ทดสอบ', 4, '2023-10-23 19:03:04', '2023-10-23 19:03:04'),
(5, 'ลูกค้า', 'ขอบคุณครับ ขอปิดเช็คลิสต์นี้ครับ', NULL, 2, 2, 4, 2, 'ลูกค้า', 5, '2023-10-23 19:09:15', '2023-10-23 19:09:15'),
(6, 'แอดมิน ทดสอบ', 'พนักงานกำลังแก้ไขครับ', '1698063270_Ch2T2nP9EJ.png', 1, 0, 5, 2, 'แอดมิน ทดสอบ', 6, '2023-10-23 19:14:30', '2023-10-23 19:14:30'),
(7, 'พนักงาน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698064814_zK2A9YfNdv.png', 1, 0, 5, 2, 'พนักงาน ทดสอบ', 7, '2023-10-23 19:40:14', '2023-10-23 19:40:14'),
(8, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 5, 2, 'ลูกค้า', 8, '2023-10-23 19:42:00', '2023-10-23 19:42:00'),
(9, 'ลูกค้า', 'ผมขอเพิ่มอย่างนึงครับ ช่วยเคลียร์พื้นด้วยนะครับ', '1698065105_u3bXYPfJp0.png', 2, 1, 5, 2, 'ลูกค้า', 9, '2023-10-23 19:45:05', '2023-10-23 19:45:05'),
(10, 'พนักงาน ทดสอบ', 'จัดการเรียบร้อยครับ', '1698065134_jQtsyGLCKu.png', 1, 0, 5, 2, 'พนักงาน ทดสอบ', 10, '2023-10-23 19:45:34', '2023-10-23 19:45:34'),
(11, 'พนักงาน ทดสอบ', 'ยังมีส่วนไหนอีกไหมครับ', NULL, 1, 0, 5, 2, 'พนักงาน ทดสอบ', 11, '2023-10-23 19:46:23', '2023-10-23 19:46:23'),
(12, 'ลูกค้า', 'ห้องนี้ไม่เหลือแล้วครับ ขอบคุณครับ', NULL, 2, 2, 5, 2, 'ลูกค้า', 12, '2023-10-23 19:47:10', '2023-10-23 19:47:10'),
(13, 'พนักงาน ทดสอบ', 'กำลังแก้ไขครับ', '1698065279_OqEb5g89Uw.png', 1, 0, 6, 2, 'พนักงาน ทดสอบ', 13, '2023-10-23 19:47:59', '2023-10-23 19:47:59'),
(14, 'พนักงาน ทดสอบ', 'เสร็จเรียบร้อยครับ', '1698065542_2ahkrsdQkn.png', 1, 0, 6, 2, 'พนักงาน ทดสอบ', 14, '2023-10-23 19:52:22', '2023-10-23 19:52:22'),
(15, 'แอดมิน ทดสอบ', 'มีตรงไหนต้องแก้อีกไหมครับ', NULL, 1, 0, 6, 2, 'แอดมิน ทดสอบ', 15, '2023-10-23 19:52:51', '2023-10-23 19:52:51'),
(16, 'ลูกค้า', 'มุมห้องด้านหลังด้วยนะครับ', '1698065615_j3qLqmRn0d.png', 2, 1, 6, 2, 'ลูกค้า', 16, '2023-10-23 19:53:35', '2023-10-23 19:53:35'),
(17, 'แอดมิน ทดสอบ', 'แก้ไขเสร็จเรียบร้อยครับ', '1698065946_kL0VTbK5xs.png', 1, 0, 6, 2, 'แอดมิน ทดสอบ', 17, '2023-10-23 19:59:06', '2023-10-23 19:59:06'),
(18, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 6, 2, 'ลูกค้า', 18, '2023-10-23 20:03:18', '2023-10-23 20:03:18'),
(19, 'แอดมิน ทดสอบ', 'ปิดเช็คลิสต์ครับ', NULL, 1, 2, 6, 2, 'แอดมิน ทดสอบ', 19, '2023-10-23 20:03:39', '2023-10-23 20:03:39'),
(20, 'แอดมิน ทดสอบ', 'กำลังแก้ไขครับ', '1698067390_GOZII7vFIa.png', 1, 0, 3, 2, 'แอดมิน ทดสอบ', 20, '2023-10-23 20:23:10', '2023-10-23 20:23:10'),
(21, 'แอดมิน ทดสอบ', 'กำลังแก้ไขครับ', '1698068063_8bOb0RdMID.png', 1, 0, 7, 2, 'แอดมิน ทดสอบ', 21, '2023-10-23 20:34:23', '2023-10-23 20:34:23'),
(22, 'ลูกค้า', 'เรียบร้อยครับ', NULL, 2, 1, 7, 2, 'ลูกค้า', 22, '2023-10-23 20:35:46', '2023-10-23 20:35:46'),
(23, 'แอดมิน ทดสอบ', 'กำลังดำเนินการแก้ไขครับ', '1698160345_SMAXqB1rnx.png', 1, 0, 8, 2, 'แอดมิน ทดสอบ', 24, '2023-10-24 22:12:25', '2023-10-24 22:12:25'),
(24, 'แอดมิน ทดสอบ', 'ปิดเช็คลิสต์ครับ', NULL, 1, 2, 8, 2, 'แอดมิน ทดสอบ', 25, '2023-10-24 22:12:33', '2023-10-24 22:12:33'),
(25, 'ลูกค้า', 'ขอบคุณครับ', NULL, 2, 1, 3, 2, 'ลูกค้า', 26, '2023-10-27 22:26:22', '2023-10-27 22:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `defect`
--

CREATE TABLE `defect` (
  `id` int(5) NOT NULL,
  `project_id` int(5) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=unfinished,\r\n1=done',
  `count` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `defect`
--

INSERT INTO `defect` (`id`, `project_id`, `status`, `count`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, '2023-10-23 16:13:54', '2023-10-23 16:13:54'),
(2, 2, 0, 1, '2023-10-23 20:32:29', '2023-10-23 20:32:29'),
(3, 2, 1, 2, '2023-10-23 20:47:07', '2023-10-23 20:47:07'),
(4, 1, 0, 2, '2023-10-24 21:47:42', '2023-10-24 21:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(5) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `email_company` varchar(100) DEFAULT NULL,
  `email_customer` varchar(100) DEFAULT NULL,
  `project_name` varchar(50) NOT NULL,
  `manager_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '1=progress, \r\n2=progress(extend)\r\n3=done',
  `project_code` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `start_date`, `end_date`, `email_company`, `email_customer`, `project_name`, `manager_name`, `description`, `image`, `status`, `project_code`, `created_at`, `updated_at`) VALUES
(1, '2023-10-20', '2023-10-30', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'CHANEL CODES COULEUR', 'จิราพร', 'ป๊อปอัพอีเว้นต์ ที่ใจกลางพาร์คพารากอน', 'aFDUXFKXzN.png', 2, 'nx42qquybr', '2023-10-23 14:50:23', '2023-10-27 16:32:56'),
(2, '2023-10-30', '2023-11-10', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'BMW MOTORRAD 2023', 'จิราพร', 'งานเปิดตัวรถ The New BMW', 'SYaN9Y9DSX.png', 3, 'w2as7piurw', '2023-10-23 14:52:31', '2023-10-23 20:47:07'),
(3, '2023-10-15', '2023-11-05', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'Clarins', 'จิราพร', 'EMPORIUM DEPARTMENTSTORE', 'Tolsc4BEs4.png', 1, 'g5qlkmsiiu', '2023-10-23 20:29:22', '2023-10-27 16:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `projects_log`
--

CREATE TABLE `projects_log` (
  `id` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `email_company` varchar(100) DEFAULT NULL,
  `email_customer` varchar(100) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '1=progress,\r\n2=progress(done),\r\n3=done',
  `image` varchar(255) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_log`
--

INSERT INTO `projects_log` (`id`, `start_date`, `end_date`, `email_company`, `email_customer`, `reason`, `status`, `image`, `project_id`, `fullname`, `created_at`, `updated_at`) VALUES
(1, '2023-10-20', '2023-10-30', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'สร้างครั้งแรก', 1, 'aFDUXFKXzN.png', 1, 'สร้างครั้งแรก', '2023-10-23 14:50:23', '2023-10-23 14:50:23'),
(2, '2023-10-30', '2023-11-10', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'สร้างครั้งแรก', 1, 'SYaN9Y9DSX.png', 2, 'สร้างครั้งแรก', '2023-10-23 14:52:31', '2023-10-23 14:52:31'),
(3, '2023-10-15', '2023-11-05', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'สร้างครั้งแรก', 1, 'Tolsc4BEs4.png', 3, 'สร้างครั้งแรก', '2023-10-23 20:29:22', '2023-10-23 20:29:22'),
(4, '2023-10-20', '2023-10-30', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'ขยายระยะเวลา', 2, 'aFDUXFKXzN.png', 1, 'แอดมิน ทดสอบ', '2023-10-23 20:31:17', '2023-10-23 20:31:17'),
(5, '2023-10-30', '2023-11-10', 'nattapong.paungpool@gmail.com', 'nattapong.bsn@gmail.com', 'ส่งมอบโปรเจกต์', 3, 'SYaN9Y9DSX.png', 2, 'แอดมิน ทดสอบ', '2023-10-23 20:47:07', '2023-10-23 20:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1=emp, 2=pmt',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `image`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1234', 'แอดมิน', 'ทดสอบ', 'FYJrSL7ICY.png', 2, '2023-10-23 13:29:49', '2023-10-23 13:57:15'),
(2, 'employee', '1234', 'พนักงาน', 'ทดสอบ', NULL, 1, '2023-10-23 13:30:06', '2023-10-23 13:30:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checklist_comment`
--
ALTER TABLE `checklist_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checklist_comment_log`
--
ALTER TABLE `checklist_comment_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `defect`
--
ALTER TABLE `defect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects_log`
--
ALTER TABLE `projects_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `checklist_comment`
--
ALTER TABLE `checklist_comment`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `checklist_comment_log`
--
ALTER TABLE `checklist_comment_log`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `defect`
--
ALTER TABLE `defect`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects_log`
--
ALTER TABLE `projects_log`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
