-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2020 at 09:41 PM
-- Server version: 10.3.18-MariaDB-50+deb10u1.cba-log
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
-- Table structure for table `l_products`
--

CREATE TABLE `l_products` (
  `id` int(10) DEFAULT NULL,
  `name1` varchar(60) DEFAULT NULL,
  `name2` varchar(60) DEFAULT NULL,
  `price1` varchar(15) DEFAULT NULL,
  `price2` varchar(15) DEFAULT NULL,
  `o01` text NOT NULL,
  `o02` text NOT NULL,
  `o11` text NOT NULL,
  `o12` text NOT NULL,
  `vis` bit(1) NOT NULL DEFAULT b'1',
  `keyVal` int(3) NOT NULL,
  `unixTime` varchar(15) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `cat` varchar(30) DEFAULT NULL,
  `limed` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `l_products`
--
ALTER TABLE `l_products`
  ADD PRIMARY KEY (`keyVal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `l_products`
--
ALTER TABLE `l_products`
  MODIFY `keyVal` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
