-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2020 at 08:03 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `addressbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_city` varchar(50) NOT NULL,
  `address_province` varchar(2) NOT NULL,
  `address_postalcode` varchar(7) NOT NULL,
  `birthday` date NOT NULL,
  `salesrep_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `salesrep` (`salesrep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `firstname`, `lastname`, `phone`, `email`, `address_street`, `address_city`, `address_province`, `address_postalcode`, `birthday`, `salesrep_id`) VALUES
(2, 'Ivy', 'Kramer', '1-437-867-1282', 'aliquet.libero@pedemalesuadavel.org', '346-4462 Suspendisse Ave', 'Nenana', 'NL', 'B1J 8N8', '1968-04-12', 3),
(3, 'Fitzgerald', 'Shepard', '1-206-777-0595', 'magnis.dis.parturient@Cras.ca', 'P.O. Box 380 5309 Amet Avenue', 'Kennewick', 'ON', 'S5H 2I6', '1961-02-21', 4),
(5, 'Amaya', 'Jackson', '1-762-542-0380', 'Fusce@utaliquam.ca', 'P.O. Box 121 3581 Purus Avenue', 'Richland', 'MB', 'R2Q 9T6', '1974-09-13', 3),
(6, 'Jarrod', 'Huber', '1-469-899-2702', 'consectetuer.cursus.et@Praesent.edu', 'P.O. Box 419 4348 Elit. Ave', 'Falls Church', 'MB', 'I5Z 1F4', '1983-05-30', 4),
(8, 'Kirestin', 'Mcmahon', '1-244-146-8495', 'lacus@mollis.edu', '328-5079 Felis St.', 'Milford', 'BC', 'R5A 9X5', '1969-02-13', 5);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(3, 'heejeong@php.com', '$2y$10$fLRDUCdEILtONb/WDbyAjeDyCQrJSkYS23WQ5hdnAWYDOLy.CUBH2', 'Heejeong', 'Cho'),
(4, 'john@php.com', '$2y$10$q/nj1aYTPEBZng.eEqym6e6oupHV4HkDANgfmzdkOtF.Yqb5.jCke', 'John', 'Smith'),
(5, 'harry@php.com', '$2y$10$mFIdXNNxEhy3QnnA6W.cJ.46DqLHD4H/PnWBAdsNWycN77Nwfn4b.', 'Harry', 'Potter');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`salesrep_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
