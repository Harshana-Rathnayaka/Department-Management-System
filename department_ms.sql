-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 17, 2020 at 08:51 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Design Department'),
(2, 'Pattern Making Department'),
(3, '  Sampling Department'),
(4, 'Fabric Store and Fabric Sourcing Department'),
(5, 'Trims and Accessory Department'),
(6, 'Production Planning and Control Department'),
(7, 'Marketing Department'),
(8, 'Finance Department'),
(9, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `attempt_id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`attempt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `department_id` int NOT NULL,
  `item` varchar(250) NOT NULL,
  `quantity` varchar(150) NOT NULL,
  `order_details` text NOT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `placed_on` date NOT NULL,
  `updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `fk_ordered_department` (`department_id`),
  KEY `fk_ordered_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `department_id`, `item`, `quantity`, `order_details`, `order_status`, `placed_on`) VALUES
(1, 2, 2, 'sheet', '10', '  Test Order  ', 2, '2020-11-12'),
(2, 2, 2, 'pins', '100', '   Test Order 2   ', 3, '2020-11-12'),
(3, 2, 2, 'Clothes', '20', 'Another Test Order', 0, '2020-11-12'),
(4, 2, 3, 'Clothes', '25', 'Need this asap', 2, '2020-11-14'),
(5, 2, 2, 'Table', '1', 'Need a table ASAP', 0, '2020-11-14'),
(6, 2, 6, 'Bottle', '5', 'Need water bottles for the staff', 0, '2020-11-15'),
(7, 2, 7, 'Campaign', '1', 'URGENT!!', 1, '2020-11-16'),
(8, 2, 5, 'Paper Cutters', '3', 'Need this by tomorrow', 2, '2020-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `senior_managers`
--

DROP TABLE IF EXISTS `senior_managers`;
CREATE TABLE IF NOT EXISTS `senior_managers` (
  `senior_manager_id` int NOT NULL AUTO_INCREMENT,
  `senior_manager_name` varchar(150) NOT NULL,
  `senior_manager_email` varchar(200) NOT NULL,
  PRIMARY KEY (`senior_manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `senior_managers`
--

INSERT INTO `senior_managers` (`senior_manager_id`, `senior_manager_name`, `senior_manager_email`) VALUES
(1, 'Test Email', 'test@gmail.comdds'),
(2, 'Test Email 2', 'test2@gmail.com'),
(3, 'Test Email 3', 'test3@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_type` int NOT NULL,
  `department_id` int NOT NULL,
  `status` int NOT NULL,
  `attempts` int NOT NULL,
  `otp` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `user_type`, `department_id`, `status`, `attempts`, `otp`) VALUES
(1, 'Admin Test', 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 0, 1, 1, 0, 195802),
(2, 'Leader Test', 'leader', 'leader1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 0, 927521),
(3, 'Manager Test 1', 'manager1', 'manager1@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 2, 1, 0, 330216),
(4, 'Finance Manager', 'finance', 'finance@gmail.com', '202cb962ac59075b964b07152d234b70', 3, 8, 1, 0, 352212),
(5, 'Manager Test 2', 'manager2', 'manager2@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 3, 1, 0, 0),
(6, 'Leader Test 2', 'leader2', 'leader2@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 3, 1, 0, 0);

--
-- Constraints for dumped tables
--

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
