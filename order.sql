-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `order`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `id` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `discount` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`id`, `orderId`, `productId`, `qty`, `discount`) VALUES
(5, 6, 1, 2, 10.00),
(6, 7, 1, 2, 10.00),
(7, 8, 1, 2, 10.00),
(8, 9, 1, 2, 10.00),
(9, 10, 1, 2, 10.00),
(10, 11, 1, 2, 10.00),
(11, 12, 1, 2, 10.00),
(12, 13, 3, 2, 12.00),
(13, 13, 2, 4, 15.00),
(14, 13, 4, 1, 0.00),
(15, 14, 3, 2, 12.00),
(16, 14, 2, 4, 15.00),
(17, 14, 4, 1, 0.00),
(18, 15, 3, 2, 12.00),
(19, 15, 2, 4, 15.00),
(20, 15, 4, 1, 0.00),
(21, 16, 3, 2, 12.00),
(22, 16, 2, 4, 15.00),
(23, 16, 4, 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`) VALUES
(1, 'Battery', 50000.00),
(2, 'Charger', 100000.00),
(3, 'Flower', 60000.00),
(4, 'PenTouch', 39000.00);

-- --------------------------------------------------------

--
-- Table structure for table `salesorder`
--

CREATE TABLE `salesorder` (
  `id` int(11) NOT NULL,
  `orderNum` varchar(50) NOT NULL,
  `customerRef` varchar(50) NOT NULL,
  `orderDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesorder`
--

INSERT INTO `salesorder` (`id`, `orderNum`, `customerRef`, `orderDate`) VALUES
(6, 'S012', 'PT XYZ', '2024-10-24'),
(7, 'S012', 'PT XYZ', '2024-10-24'),
(8, 'S012', 'PT XYZ', '2024-10-24'),
(9, 'S012', 'PT XYZ', '2024-10-24'),
(10, 'S012', 'PT XYZ', '2024-10-24'),
(11, 'S012', 'PT XYZ', '2024-10-24'),
(12, 'S012', 'PT XYZ', '2024-10-24'),
(13, 'YO99', 'AN', '2024-10-28'),
(14, 'YO99', 'AN', '2024-10-28'),
(15, 'YO99', 'AN', '2024-10-28'),
(16, 'YO99', 'AN', '2024-10-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesorder`
--
ALTER TABLE `salesorder`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salesorder`
--
ALTER TABLE `salesorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `salesorder` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
