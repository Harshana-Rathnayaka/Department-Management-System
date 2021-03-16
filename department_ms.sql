-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 16, 2021 at 07:13 AM
-- Server version: 10.5.4-MariaDB
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
CREATE DATABASE IF NOT EXISTS `department_ms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `department_ms`;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, 'Test 23'),
(11, 'Administration');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `attempt_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attempt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
CREATE TABLE IF NOT EXISTS `login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `fk_user_id_log` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`log_id`, `user_id`, `login_time`, `login_ip`) VALUES
(1, 2, '2020-11-24 09:56:33', '::1'),
(2, 2, '2020-11-24 09:58:48', '::1'),
(3, 3, '2020-11-24 09:59:17', '::1'),
(4, 4, '2020-11-24 10:12:45', '::1'),
(5, 2, '2020-11-24 14:40:02', '::1'),
(6, 2, '2021-03-02 15:01:19', '::1'),
(7, 2, '2021-03-15 14:19:44', '::1'),
(8, 2, '2021-03-15 15:01:20', '::1'),
(9, 2, '2021-03-15 15:04:16', '::1'),
(10, 2, '2021-03-15 15:15:07', '::1'),
(11, 6, '2021-03-15 15:22:55', '::1'),
(12, 7, '2021-03-15 15:25:31', '::1'),
(13, 3, '2021-03-15 15:27:44', '::1'),
(14, 3, '2021-03-15 15:30:49', '::1'),
(15, 5, '2021-03-15 15:32:03', '::1'),
(16, 4, '2021-03-15 15:32:51', '::1'),
(17, 2, '2021-03-15 15:51:02', '::1'),
(18, 2, '2021-03-15 18:50:04', '::1'),
(19, 2, '2021-03-15 18:52:21', '::1'),
(20, 2, '2021-03-15 18:53:25', '::1'),
(21, 3, '2021-03-15 18:54:28', '::1'),
(22, 3, '2021-03-15 18:55:21', '::1'),
(23, 3, '2021-03-15 18:56:07', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `item` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`order_id`),
  KEY `fk_ordered_department` (`department_id`),
  KEY `fk_ordered_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `department_id`, `item`, `quantity`, `order_details`, `order_status`, `placed_on`, `updated_on`) VALUES
(1, 2, 2, 'sheet', '10', '  Test Order  ', 2, '2020-11-12', '2020-11-28 13:17:03'),
(2, 2, 2, 'pins', '100', '   Test Order 2   ', 3, '2020-11-12', '2020-11-28 13:17:03'),
(3, 2, 2, 'Clothes', '20', 'Another Test Order', 2, '2020-11-12', '2021-03-15 21:04:47'),
(4, 2, 3, 'Clothes', '25', 'Need this asap', 2, '2020-11-14', '2020-11-28 13:17:03'),
(5, 2, 2, 'Table', '1', 'Need a table ASAP', 2, '2020-11-14', '2020-11-28 13:17:03'),
(6, 2, 6, 'Bottle', '5', 'Need water bottles for the staff', 0, '2020-11-15', '2020-11-28 13:17:03'),
(7, 2, 7, 'Campaign', '1', 'URGENT!!', 2, '2020-11-16', '2021-03-15 21:04:34'),
(8, 2, 5, 'Paper Cutters', '3', 'Need this by tomorrow', 2, '2020-11-16', '2020-11-28 13:17:03'),
(9, 2, 3, 'Bottles', '2', 'Need this today!!!!', 2, '0000-00-00', '2021-03-15 21:04:45'),
(10, 2, 1, 'Item 67', '45', 'Testing without the department', 0, '2021-03-15', '2021-03-15 20:48:18'),
(11, 2, 1, 'Item 68', '50', 'Testing again without department', 0, '2021-03-15', '2021-03-15 20:51:15'),
(12, 2, 1, 'Item 60', '40', 'Another test without the department', 0, '2021-03-15', '2021-03-15 20:52:18'),
(13, 6, 3, 'Item 01', '10', 'First order from the second leader account', 2, '2021-03-15', '2021-03-15 21:04:39'),
(14, 6, 3, 'Item 02', '15', 'Second order from the second leader account', 2, '2021-03-15', '2021-03-15 21:04:52'),
(15, 6, 3, 'Item 03', '20', 'Third order from the second leader account', 1, '2021-03-15', '2021-03-15 21:02:12'),
(16, 7, 2, 'Item 101', '1000', 'Frist item from the third leader account', 2, '2021-03-15', '2021-03-15 21:04:49'),
(17, 7, 2, 'Item 102', '500', 'Second order from the third leader account', 2, '2021-03-15', '2021-03-15 21:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `senior_managers`
--

DROP TABLE IF EXISTS `senior_managers`;
CREATE TABLE IF NOT EXISTS `senior_managers` (
  `senior_manager_id` int(11) NOT NULL AUTO_INCREMENT,
  `senior_manager_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senior_manager_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`senior_manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `senior_managers`
--

INSERT INTO `senior_managers` (`senior_manager_id`, `senior_manager_name`, `senior_manager_email`) VALUES
(1, 'Test Email', 'huratnayaka@gmail.com'),
(2, 'Test Email 2', 'test2@gmail.com'),
(3, 'Test Email 3', 'test3@gmail.com'),
(4, 'Senior Manager 4', 'test4@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `attempts` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `user_type`, `department_id`, `status`, `attempts`, `otp`) VALUES
(1, 'Admin Test', 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 11, 1, 0, 267922),
(2, 'Leader Test', 'leader', 'leader1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 0, 575659),
(3, 'Manager Test 1', 'manager1', 'manager1@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 2, 1, 0, 943354),
(4, 'Finance Manager', 'finance', 'finance@gmail.com', '202cb962ac59075b964b07152d234b70', 3, 8, 1, 0, 694453),
(5, 'Manager Test 2', 'manager2', 'manager2@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 3, 1, 0, 223355),
(6, 'Leader Test 2', 'leader2', 'leader2@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 3, 1, 0, 738098),
(7, 'Leader Test 3', 'leader3', 'leader3@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 2, 1, 0, 368479);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `fk_user_id_log` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_ordered_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`),
  ADD CONSTRAINT `fk_ordered_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
