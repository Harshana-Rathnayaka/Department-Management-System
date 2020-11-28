-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 28, 2020 at 01:16 PM
-- Server version: 8.0.21
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `department_ms`
--
CREATE DATABASE IF NOT EXISTS `department_ms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `department_ms`;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Design Department'),
(2, 'Pattern Making Department'),
(3, 'Sampling Department'),
(4, 'Fabric Store and Fabric Sourcing Department'),
(5, 'Trims and Accessory Department'),
(6, 'Production Planning and Control Department'),
(7, 'Marketing Department'),
(8, 'Finance Department'),
(9, 'Test'),
(10, 'Test 23');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `attempt_id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`attempt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
CREATE TABLE IF NOT EXISTS `login_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `fk_user_id_log` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`log_id`, `user_id`, `login_time`, `login_ip`) VALUES
(1, 2, '2020-11-24 09:56:33', '::1'),
(2, 2, '2020-11-24 09:58:48', '::1'),
(3, 3, '2020-11-24 09:59:17', '::1'),
(4, 4, '2020-11-24 10:12:45', '::1'),
(5, 2, '2020-11-24 14:40:02', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `department_id` int NOT NULL,
  `item` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `placed_on` date NOT NULL,
  `updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `fk_ordered_department` (`department_id`),
  KEY `fk_ordered_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `department_id`, `item`, `quantity`, `order_details`, `order_status`, `placed_on`) VALUES
(1, 2, 2, 'sheet', '10', '  Test Order  ', 2, '2020-11-12'),
(2, 2, 2, 'pins', '100', '   Test Order 2   ', 3, '2020-11-12'),
(3, 2, 2, 'Clothes', '20', 'Another Test Order', 0, '2020-11-12'),
(4, 2, 3, 'Clothes', '25', 'Need this asap', 2, '2020-11-14'),
(5, 2, 2, 'Table', '1', 'Need a table ASAP', 2, '2020-11-14'),
(6, 2, 6, 'Bottle', '5', 'Need water bottles for the staff', 0, '2020-11-15'),
(7, 2, 7, 'Campaign', '1', 'URGENT!!', 1, '2020-11-16'),
(8, 2, 5, 'Paper Cutters', '3', 'Need this by tomorrow', 2, '2020-11-16'),
(9, 2, 3, 'Bottles', '2', 'Need this today!!!!', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `senior_managers`
--

DROP TABLE IF EXISTS `senior_managers`;
CREATE TABLE IF NOT EXISTS `senior_managers` (
  `senior_manager_id` int NOT NULL AUTO_INCREMENT,
  `senior_manager_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senior_manager_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`senior_manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `senior_managers`
--

INSERT INTO `senior_managers` (`senior_manager_id`, `senior_manager_name`, `senior_manager_email`) VALUES
(1, 'Test Email', 'test1@gmail.com'),
(2, 'Test Email 2', 'test2@gmail.com'),
(3, 'Test Email 3', 'test3@gmail.com'),
(4, 'Senior Manager 4', 'test4@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int NOT NULL,
  `department_id` int NOT NULL,
  `status` int NOT NULL,
  `attempts` int NOT NULL,
  `otp` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `user_type`, `department_id`, `status`, `attempts`, `otp`) VALUES
(1, 'Admin Test', 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 1, 1, 0, 335782),
(2, 'Leader Test', 'leader', 'leader1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 0, 356134),
(3, 'Manager Test 1', 'manager1', 'manager1@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 2, 1, 0, 728192),
(4, 'Finance Manager', 'finance', 'finance@gmail.com', '202cb962ac59075b964b07152d234b70', 3, 8, 1, 0, 285845),
(5, 'Manager Test 2', 'manager2', 'manager2@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 3, 1, 0, 0),
(6, 'Leader Test 2', 'leader2', 'leader2@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 3, 1, 0, 0),
(7, 'Leader Test 3', 'leader3', 'leader3@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 2, 1, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `fk_user_id_log` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_ordered_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_ordered_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
