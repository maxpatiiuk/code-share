-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 26, 2020 at 11:58 PM
-- Server version: 10.3.22-MariaDB-54+deb10u1-log
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

-- --------------------------------------------------------

--
-- Table structure for table `p_categories`
--

CREATE TABLE `p_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` int(10) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `p_categories`
--

INSERT INTO `p_categories` (`id`, `name`, `active`) VALUES
(3, 'Market', 1),
(2, 'Shop', 1);

-- --------------------------------------------------------

--
-- Table structure for table `p_salary`
--

CREATE TABLE `p_salary` (
  `id` int(11) NOT NULL,
  `id_worker` int(10) NOT NULL,
  `amount` decimal(60,2) NOT NULL,
  `products_cost` decimal(60,2) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `p_shop`
--

CREATE TABLE `p_shop` (
  `id` int(11) NOT NULL,
  `worker_ids` varchar(200) NOT NULL,
  `amount` decimal(60,2) NOT NULL,
  `terminal` decimal(60,2) NOT NULL,
  `out` decimal(60,2) NOT NULL,
  `products_cost` decimal(60,2) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `p_workers`
--

CREATE TABLE `p_workers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_category` int(5) NOT NULL,
  `percent` decimal(60,2) NOT NULL DEFAULT 7.00,
  `active` int(10) NOT NULL DEFAULT 1,
  `base_income` decimal(60,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_workers`
--

INSERT INTO `p_workers` (`id`, `name`, `id_category`, `percent`, `active`, `base_income`) VALUES
(1, 'John', 2, '7.00', 1, '100.00'),
(2, 'Marry', 3, '7.00', 1, '100.00'),
(3, 'Matt', 2, '7.00', 1, '300.00'),
(4, 'Debra', 3, '10.00', 1, '200.00'),
(5, 'Girald', 2, '7.00', 1, '200.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `p_categories`
--
ALTER TABLE `p_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_salary`
--
ALTER TABLE `p_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_shop`
--
ALTER TABLE `p_shop`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_index` (`date`);

--
-- Indexes for table `p_workers`
--
ALTER TABLE `p_workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `p_categories`
--
ALTER TABLE `p_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `p_salary`
--
ALTER TABLE `p_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_shop`
--
ALTER TABLE `p_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_workers`
--
ALTER TABLE `p_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
