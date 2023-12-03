-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2020 at 09:42 PM
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
-- Table structure for table `l_users`
--

CREATE TABLE `l_users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `val` varchar(40) DEFAULT NULL,
  `r_date` varchar(50) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `r_ip` varchar(16) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `conf` bit(1) NOT NULL DEFAULT b'0',
  `hesh` varchar(255) DEFAULT NULL,
  `conf_c` varchar(24) NOT NULL DEFAULT '::::',
  `type` varchar(255) NOT NULL DEFAULT '1',
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `vis` bit(1) DEFAULT b'0',
  `phone` varchar(20) DEFAULT NULL,
  `u_name` varchar(30) DEFAULT NULL,
  `u_surname` varchar(30) DEFAULT NULL,
  `u_date` varchar(20) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `city` varchar(65) DEFAULT NULL,
  `lang` tinyint(1) NOT NULL DEFAULT 1,
  `que` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `l_users`
--

INSERT INTO `l_users` (`id`, `login`, `val`, `r_date`, `date`, `r_ip`, `ip`, `email`, `conf`, `hesh`, `conf_c`, `type`, `facebook`, `youtube`, `twitter`, `instagram`, `pinterest`, `vis`, `phone`, `u_name`, `u_surname`, `u_date`, `about`, `city`, `lang`, `que`) VALUES
(4, 'username-after-rot-13', 'some-password-after-rot-13', '07:17:40 27:02:18', '15:15:07 14:08:18', NULL, '1.1.1.1', 'max@patii.uk', b'1', 'hash', '::::', '2', 'https://facebook.patii.uk', 'https://youtube.patii.uk', 'https://twitter.patii.uk', 'https://instagram.patii.uk/', 'https://vk.patii.uk', b'0', '+380501234567', 'Максим', 'Патіюк', '2000-01-01', 'Інформація про мене', NULL, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `l_users`
--
ALTER TABLE `l_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `l_users`
--
ALTER TABLE `l_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
