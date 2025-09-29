-- phpMyAdmin SQL Dump
-- version 6.0.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 27, 2025 at 05:51 AM
-- Server version: 11.7.2-MariaDB
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pro`
--
DROP DATABASE IF EXISTS `pro`;
CREATE DATABASE IF NOT EXISTS `pro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pro`;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
  `genderId` tinyint(1) NOT NULL AUTO_INCREMENT,
  `gender` varchar(20) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`genderId`),
  UNIQUE KEY `gender` (`gender`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`genderId`, `gender`, `updated`, `created`) VALUES
(1, 'Female', '2025-09-27 05:21:47', '2025-09-27 05:21:47'),
(2, 'Male', '2025-09-27 05:21:47', '2025-09-27 05:21:47'),
(3, 'Rather not say', '2025-09-27 05:21:47', '2025-09-27 05:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleId` tinyint(1) NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`roleId`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleId`, `role`, `updated`, `created`) VALUES
(1, 'Admin', '2025-09-27 05:21:47', '2025-09-27 05:21:47'),
(2, 'Teacher', '2025-09-27 05:21:47', '2025-09-27 05:21:47'),
(3, 'Student', '2025-09-27 05:21:47', '2025-09-27 05:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `skillId` smallint(4) NOT NULL AUTO_INCREMENT,
  `skill` varchar(15) NOT NULL DEFAULT '',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`skillId`),
  UNIQUE KEY `skill` (`skill`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` bigint(10) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `verify_code` varchar(10) DEFAULT NULL,
  `code_expiry_time` datetime NOT NULL DEFAULT current_timestamp(),
  `mustchange` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Active','Pending','Suspended','Deleted') NOT NULL DEFAULT 'Pending',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `genderId` tinyint(1) NOT NULL DEFAULT 1,
  `roleId` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`),
  KEY `genderId` (`genderId`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

DROP TABLE IF EXISTS `user_skills`;
CREATE TABLE IF NOT EXISTS `user_skills` (
  `userId` bigint(10) NOT NULL DEFAULT 0,
  `skillId` smallint(4) NOT NULL DEFAULT 0,
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`userId`,`skillId`),
  KEY `user_skills_ibfk_2` (`skillId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`genderId`) REFERENCES `gender` (`genderId`) ON DELETE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE NO ACTION;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skillId`) REFERENCES `skills` (`skillId`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
