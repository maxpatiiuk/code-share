SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `h_simple_posts` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `short_content` text NOT NULL,
  `date` int(10) NOT NULL,
  `date_edit` int(10) NOT NULL,
  `url` varchar(240) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `h_simple_posts` (`id`, `name`, `content`, `short_content`, `date`, `date_edit`, `url`, `meta_title`, `meta_description`) VALUES
(30, '', '', '', 0, 0, '', '', ''),
(29, '', '', '', 0, 0, '', '', ''),
(28, '', '', '', 0, 0, '', '', ''),
(27, '', '', '', 0, 0, '', '', ''),
(26, '', '', '', 0, 0, '', '', ''),
(25, '', '', '', 0, 0, '', '', ''),
(24, '', '', '', 0, 0, '', '', ''),
(23, '', '', '', 0, 0, '', '', ''),
(22, '', '', '', 0, 0, '', '', ''),
(21, '', '', '', 0, 0, '', '', ''),
(20, '', '', '', 0, 0, '', '', ''),
(19, '', '', '', 0, 0, '', '', ''),
(18, '', '', '', 0, 0, '', '', ''),
(17, '', '', '', 0, 0, '', '', ''),
(31, '', '', '', 0, 0, '', '', ''),
(32, '', '', '', 0, 0, '', '', ''),
(33, '', '', '', 0, 0, '', '', ''),
(34, '', '', '', 0, 0, '', '', ''),
(35, '', '', '', 0, 0, '', '', ''),
(36, '', '', '', 0, 0, '', '', ''),
(37, '', '', '', 0, 0, '', '', ''),
(38, '', '', '', 0, 0, '', '', ''),
(39, '', '', '', 0, 0, '', '', ''),
(40, '', '', '', 0, 0, '', '', ''),
(41, '', '', '', 0, 0, '', '', ''),
(42, '', '', '', 0, 0, '', '', ''),
(43, '', '', '', 0, 0, '', '', ''),
(44, '', '', '', 0, 0, '', '', ''),
(45, '', '', '', 0, 0, '', '', ''),
(46, '', '', '', 0, 0, '', '', ''),
(47, '', '', '', 0, 0, '', '', ''),
(48, '', '', '', 0, 0, '', '', '');

CREATE TABLE `h_simple_products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `date` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `h_simple_products` (`id`, `name`, `content`, `date`, `price`) VALUES
(1, 'nameee3', 'contenttt1\r\nsdf', 1543679010, 55),
(2, '1', '3', 1543678195, 0);

CREATE TABLE `h_simple_users` (
  `id` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `hash` varchar(64) NOT NULL,
  `email` varchar(254) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `h_simple_users` (`id`, `login`, `hash`, `email`, `ip`) VALUES
(3, 'mambo', '--hash-was-here--', 'max@patii.uk', '1.1.1.1');


ALTER TABLE `h_simple_posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `h_simple_products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `h_simple_users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `h_simple_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
ALTER TABLE `h_simple_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `h_simple_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
