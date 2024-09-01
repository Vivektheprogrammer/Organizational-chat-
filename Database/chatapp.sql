-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2024 at 07:38 AM
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
-- Database: `chatapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(1, 1404724300, 124403285, 'hi bhar'),
(2, 124403285, 1404724300, 'heloooo'),
(3, 1404724300, 997274612, 'hi akko'),
(4, 1404724300, 997274612, 'wt doing 😁'),
(5, 997274612, 1404724300, 'hii '),
(6, 997274612, 1404724300, 'eating pani puri'),
(7, 997274612, 1404724300, 'what about you'),
(8, 997274612, 1404724300, 'hi guys how are you'),
(9, 1404724300, 795185588, 'hello'),
(10, 795185588, 1404724300, 'meeting is at 3 pm'),
(11, 795185588, 1404724300, 'ok i and shilpa mam will'),
(12, 795185588, 1404724300, 'come'),
(13, 1404724300, 1372351077, 'hello chotu'),
(14, 1372351077, 1404724300, 'hu helo'),
(15, 1404724300, 997274612, 'i am fine '),
(16, 1404724300, 997274612, 'tomorrow final check of project '),
(17, 1404724300, 870191721, 'Hi Varshini '),
(18, 1404724300, 870191721, 'we have project submission tomorrow  '),
(19, 870191721, 1636824624, 'Hello Yashu '),
(20, 870191721, 1636824624, 'Did u complete ur task?'),
(21, 1636824624, 870191721, 'yes sir '),
(22, 1636824624, 870191721, 'i have uploaded the file also !'),
(23, 870191721, 1636824624, 'good job '),
(24, 1636824624, 870191721, 'thankyou sir '),
(25, 870191721, 1401404802, 'hello'),
(26, 1401404802, 870191721, 'hii'),
(27, 870191721, 1401404802, 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`) VALUES
(1, 1404724300, 'Varshini', 'J', 'varshinijayaprabhu500@gmail.com', '4d9f0c7e1dc574b6e148579dc5974a58', '1716004040bg.png', 'Active now'),
(2, 124403285, 'Bhargavi', 'M', 'bhargavimreddy128@gmail.com', 'dd6a32c9df65c93c02b6ca9f86771b5e', '1716004159bulbon.jpg', 'Offline now'),
(3, 997274612, 'sujatha ', 'c', 'sujathanagraj47@gmail.com', 'ed084cf21620c0440250487c8c8fbb50', '171612557119053547_0.jpg', 'Active now'),
(7, 415090242, 'varsh', 'j', 'varshini@gmail.com', '4d9f0c7e1dc574b6e148579dc5974a58', '1718430346cooooo.png', 'Active now'),
(8, 870191721, 'Yashaswini', 'N', 'yashaswinin348@gmail.com', 'cd76036ad0ebb93b596c50b76dc4f06a', '1723960853happy.jpg', 'Active now'),
(9, 1636824624, 'Gojo', 'Satoru', 'yashaswinin2kdc2021bcads@gmail.com', 'cd76036ad0ebb93b596c50b76dc4f06a', '1723961675gojo.jpg', 'Offline now'),
(10, 1401404802, 'Vivek', 'R', 'vivekgowda480@gmail.com', '02769a92012a4b6d522541fa277efcb9', '1723989168tm.jpg', 'Offline now');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
