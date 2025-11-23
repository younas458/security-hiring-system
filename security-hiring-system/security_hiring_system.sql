-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 05:00 PM
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
-- Database: `security_hiring_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `hiring_request_id` int(11) NOT NULL,
  `guard_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `hours_per_week` int(11) DEFAULT 40,
  `assignment_status` enum('active','completed','cancelled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guards`
--

CREATE TABLE `guards` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `experience` int(11) NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `hourly_rate` decimal(6,2) NOT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guards`
--

INSERT INTO `guards` (`id`, `name`, `specialty`, `experience`, `rating`, `hourly_rate`, `available`, `created_at`) VALUES
(1, 'Michael Johnson', 'Corporate Security', 8, 4.5, 25.00, 1, '2025-11-21 16:13:10'),
(2, 'Sarah Williams', 'Event Security', 6, 5.0, 30.00, 1, '2025-11-21 16:13:10'),
(3, 'David Chen', 'Personal Protection', 10, 4.0, 45.00, 1, '2025-11-21 16:13:10'),
(4, 'James Rodriguez', 'Retail Security', 5, 4.5, 22.00, 1, '2025-11-21 16:13:10'),
(5, 'Emily Brown', 'Residential Security', 4, 4.2, 20.00, 1, '2025-11-21 16:13:10'),
(6, 'Robert Wilson', 'Corporate Security', 12, 4.8, 35.00, 1, '2025-11-21 16:13:10'),
(7, 'Lisa Anderson', 'Event Security', 7, 4.7, 28.00, 1, '2025-11-21 16:13:10'),
(8, 'Thomas Clark', 'Personal Protection', 15, 4.9, 50.00, 0, '2025-11-21 16:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `guard_skills`
--

CREATE TABLE `guard_skills` (
  `id` int(11) NOT NULL,
  `guard_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` enum('beginner','intermediate','expert') DEFAULT 'intermediate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guard_skills`
--

INSERT INTO `guard_skills` (`id`, `guard_id`, `skill_name`, `proficiency_level`) VALUES
(1, 1, 'Crowd Control', 'expert'),
(2, 1, 'Emergency Response', 'intermediate'),
(3, 1, 'First Aid', 'intermediate'),
(4, 2, 'Event Planning', 'expert'),
(5, 2, 'Customer Service', 'expert'),
(6, 2, 'Conflict Resolution', 'expert'),
(7, 3, 'Self Defense', 'expert'),
(8, 3, 'Risk Assessment', 'expert'),
(9, 3, 'Defensive Driving', 'expert'),
(10, 4, 'Loss Prevention', 'intermediate'),
(11, 4, 'Surveillance', 'intermediate'),
(12, 5, 'Residential Patrol', 'intermediate'),
(13, 5, 'Access Control', 'intermediate'),
(14, 6, 'Executive Protection', 'expert'),
(15, 6, 'Security Planning', 'expert');

-- --------------------------------------------------------

--
-- Table structure for table `hiring_requests`
--

CREATE TABLE `hiring_requests` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `guard_type` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `requirements` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hiring_requests`
--

INSERT INTO `hiring_requests` (`id`, `first_name`, `last_name`, `email`, `phone`, `company`, `guard_type`, `duration`, `location`, `requirements`, `status`, `submitted_at`) VALUES
(1, 'younas', 'ahmad', 'bacha@gmail.com', '+923473181107', 'police', 'corporate', 'permanent', 'swat', '1', 'pending', '2025-11-21 16:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('client','admin') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin@secureguardpro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-11-22 01:35:14'),
(2, 'john_client', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', '2025-11-22 01:35:14'),
(3, 'sarah_client', 'sarah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', '2025-11-22 01:35:14'),
(4, 'khan', 'xada@gmail.com', '$2y$10$I5kYdr4xMysNoMkJtpC0i.cRth7fQkLaY2jemWjKjusdh0krh1Gd2', 'client', '2025-11-22 02:46:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hiring_request_id` (`hiring_request_id`),
  ADD KEY `guard_id` (`guard_id`);

--
-- Indexes for table `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_specialty` (`specialty`),
  ADD KEY `idx_available` (`available`);

--
-- Indexes for table `guard_skills`
--
ALTER TABLE `guard_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guard_id` (`guard_id`);

--
-- Indexes for table `hiring_requests`
--
ALTER TABLE `hiring_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_email` (`email`);

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
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guards`
--
ALTER TABLE `guards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guard_skills`
--
ALTER TABLE `guard_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hiring_requests`
--
ALTER TABLE `hiring_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`hiring_request_id`) REFERENCES `hiring_requests` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`guard_id`) REFERENCES `guards` (`id`);

--
-- Constraints for table `guard_skills`
--
ALTER TABLE `guard_skills`
  ADD CONSTRAINT `guard_skills_ibfk_1` FOREIGN KEY (`guard_id`) REFERENCES `guards` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
