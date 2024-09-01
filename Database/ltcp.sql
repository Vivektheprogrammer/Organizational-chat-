-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2024 at 07:37 AM
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
-- Database: `ltcp`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Yashaswini:The Helping Hand', 'Congratulations Yashaswini N for winning the title of \"The Helping Hand\" for her tremendous support to team mates', '2024-08-17 10:10:09', '2024-08-17 10:10:09'),
(2, 'Varshini : Creative Mind ', 'Appreciating Varshini J on receiving the title of \"Creative Mind\" ', '2024-08-17 10:11:55', '2024-08-17 10:11:55'),
(3, 'Shubhashree : Dancing Queen', 'Shubhashree T.K as recieved the title of Dancing Queen for her excellent performance in dance', '2024-08-17 10:15:05', '2024-08-17 10:15:05'),
(4, 'Vivek : Tech geek', 'Congratulations to Vivek R for his contribution in technical aspects ', '2024-08-17 10:25:42', '2024-08-17 10:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'vivekgowda480@gmail.com ', 'Admin@123'),
(2, 'yashaswinin348@gmail.com', 'Admin@123'),
(3, 'varshinijayaprabhu500@gmail.com', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('text','video','image') NOT NULL,
  `content_data` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `type`, `content_data`, `user_id`, `user_email`) VALUES
(1, 'Qr Code Preparation ', 'text', 'Prepare the Qr code for collecting required information ', 5, NULL),
(2, 'Qr Code Preparation ', 'text', 'Prepare the Qr code for collecting required information ', 1, NULL),
(3, 'Qr Code Preparation ', 'text', 'Prepare the Qr code for collecting required information ', 7, NULL),
(4, 'Code Correction', 'image', 'uploads/code correction.png', 5, NULL),
(5, 'Code Correction', 'image', 'uploads/code correction.png', 1, NULL),
(6, 'Code Correction', 'image', 'uploads/code correction.png', 7, NULL),
(7, 'add design to pages', 'video', 'uploads/Arc 2024-08-08 14-54-34.mp4', 5, NULL),
(8, 'add design to pages', 'video', 'uploads/Arc 2024-08-08 14-54-34.mp4', 1, NULL),
(9, 'add design to pages', 'video', 'uploads/Arc 2024-08-08 14-54-34.mp4', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `approved`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Vivek', 'R', 'vivekgowda480@gmail.com', '02769a92012a4b6d522541fa277efcb9', 1, '', NULL),
(2, 'Vivek', 'R', 'vivekrkdc2021bca@gmail.com', '355f61645d2edc98463d3827b0451d0a', 1, 'c4b2ee0640b5f2fb10c7ac62e0a0129c47195cd359aa623baebc0c180b5662e1', '2024-07-02 16:42:15'),
(3, 'K', 'Ramesh', 'vivekgowda.r@gmail.com', '7c6197c698b6a77abb6d808b29de3cfa', 0, NULL, NULL),
(4, 'varshini', 'jayaprabhu', 'varshinijayaprabhu50@gmail.com', '4d9f0c7e1dc574b6e148579dc5974a58', 0, NULL, NULL),
(5, 'varshini', 'J', 'varshinijayaprabhu500@gmail.com', '6c031f665bf1b5d4e5c7282af632b77b', 1, '', NULL),
(6, 'Vivek', 'R', 'demo@gmail.com', '2876a485a2c4c7fbb5b1b501a0f25cd7', 1, NULL, NULL),
(7, 'Yashaswini', 'N', 'yashaswinin348@gmail.com', 'ed084cf21620c0440250487c8c8fbb50', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_content_user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `fk_content_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
