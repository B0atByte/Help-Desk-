-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 12:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'ระบบอินเทอร์เน็ต'),
(6, 'คอมพิวเตอร์'),
(7, 'ระบบเครือข่าย'),
(8, 'อื่นๆ'),
(9, 'ระบบเครื่องพิมพ์'),
(10, 'ระบบอินเทอร์เน็ต'),
(11, 'ระบบบัญชีผู้ใช้งาน'),
(12, 'ระบบฮาร์ดแวร์'),
(13, 'ระบบสิทธิ์การใช้งาน'),
(14, 'ระบบเครือข่าย'),
(15, 'ซอฟต์แวร์สำนักงาน'),
(16, 'ระบบมัลติมีเดีย');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticket_id`, `user_id`, `comment`, `created_at`) VALUES
(5, 38, 1, 'ได้เเเล้วครับผม ขอบคุณครับ\r\n', '2025-05-14 03:26:57'),
(6, 38, 2, 'โอเครครับ ปิดงานไดด้เลยนะครับ\r\n', '2025-05-14 03:27:22'),
(7, 38, 1, 'ปิดได้เลยครับ\r\n', '2025-05-14 03:27:55'),
(8, 38, 2, 'ได้เเล้วครับ', '2025-05-14 03:57:53'),
(9, 40, 2, 'ขออนุญาติรับงานครับ', '2025-05-14 04:01:57'),
(10, 40, 1, 'เเจ้งพี่กลับด้วย', '2025-05-14 04:02:14'),
(11, 39, 1, 'กฟไก', '2025-05-14 04:02:33'),
(12, 41, 2, 'กฟไก', '2025-05-14 04:04:22'),
(13, 42, 7, 'ทำไร', '2025-05-14 04:15:46'),
(14, 43, 2, 'ติดปัญหาอะไรครับ', '2025-05-14 04:20:45'),
(15, 43, 7, '1111', '2025-05-14 04:21:05'),
(16, 43, 7, '1212', '2025-05-14 04:21:18'),
(17, 43, 7, '\"ฏ\"', '2025-05-14 04:25:14'),
(18, 44, 2, 'ตอนยังไม่ติดใช่ไหม', '2025-05-14 04:41:42'),
(19, 44, 1, 'ยังไม่ติดจ้าา', '2025-05-14 04:42:18'),
(20, 44, 2, 'ขอทราบเลขในการรีโมทเข้าไปหน่อยครับ', '2025-05-14 04:42:44'),
(21, 44, 1, '11948', '2025-05-14 04:42:52'),
(22, 44, 2, 'กำลังเข้าครับ', '2025-05-14 04:43:03'),
(23, 44, 2, 'เเก้ไขเเล้วครับ', '2025-05-14 04:43:31'),
(24, 44, 1, 'ขอบคุณจ้า', '2025-05-14 04:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('new','in_progress','resolved','closed') DEFAULT 'new',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_at` datetime DEFAULT current_timestamp(),
  `assigned_to` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `category_id`, `title`, `description`, `status`, `priority`, `created_at`, `assigned_to`, `attachment`) VALUES
(38, 1, 9, 'w', 'w', 'closed', 'high', '2025-05-14 02:38:46', 2, 'uploads/1747165126_S__8634387.jpg'),
(39, 1, 12, 'E', 'E', 'closed', 'medium', '2025-05-14 03:14:19', 2, 'uploads/1747167259_S__8634387.jpg'),
(40, 1, 15, 'PFD หมดอายุุ', 'เเก้ไขด่วน ติดต่อกลับ', 'closed', 'high', '2025-05-14 04:01:19', 2, 'uploads/1747170079_Screenshot_1.png'),
(41, 7, 16, 'เบอร์ชน', 'โทรไม่ได้', 'closed', 'high', '2025-05-14 04:04:09', 2, 'uploads/1747170249_____________________________________.png'),
(42, 7, 16, '1', '1', 'closed', 'medium', '2025-05-14 04:13:56', 2, 'uploads/1747170836_Screenshot_1.png'),
(43, 7, 14, '3', '3', 'new', 'high', '2025-05-14 04:20:11', 2, NULL),
(44, 1, 12, 'จอดับ', 'จอไม่ติดลองขยับสายเเล้ว', 'closed', 'high', '2025-05-14 04:38:58', 2, 'uploads/1747172338_S__8634387.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','technician','admin') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'พนักงาน', 'boatzaha2905@gmail.com', '$2y$10$m17./paalUrWk4DC5oelperOdRINx5mIM1iyois9vKD5CFH6mujYK', 'user', '2025-05-10 03:18:34'),
(2, 'ช่าง', 'ad@ad.com', '$2y$10$jHBGVlUY/ppEeqGJtynfjercVv8Hb0Oyqc9qkQtGWlE3HQ.ZfuMIO', 'technician', '2025-05-10 03:28:48'),
(3, 'หัวหน้าช่าง', '1@1.com', '$2y$10$XAsp3AcACYFPcqr4Z/JU9OlgT8HLjk.FjVb/d716xSgrkTqpkymve', 'admin', '2025-05-10 03:30:17'),
(4, 'user', 'user@a.com', '$2y$10$Yg/qKPMlGC/D7xAHSZyb1udGNoDCzanJVRcjSCi9c0BL0Cud75Gfy', 'user', '2025-05-10 03:33:48'),
(5, 'พัฒนพงษ์ IT', 'IT@IT.com', '$2y$10$pT4bA8HUV68n6f5fmiFr1uvmlEEDXLiyDE9MVsjB734lNkIqoAnbe', 'user', '2025-05-10 03:53:17'),
(6, 'สมชาย ใจดี', 'u@u.com', '$2y$10$nk6W3M8sZfGTKTe2R7pcF.izjutel/k2t.lS.YsUPQbkeLGzaQtj6', 'user', '2025-05-10 04:02:20'),
(7, 'Boat', 'D@D.com', '$2y$10$07GI2k3VvY2oNoppUR5uVOgPxNb3BF1G1MIR/jentvw7/DH1tL4Zi', 'user', '2025-05-14 04:03:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
