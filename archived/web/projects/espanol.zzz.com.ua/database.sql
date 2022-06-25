-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for osx10.16 (x86_64)
--
-- Host: mysql.zzz.com.ua    Database: mambo_zzz_com_ua
-- ------------------------------------------------------
-- Server version	10.3.27-MariaDB-31.cba+deb10u1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `e_categories`
--

DROP TABLE IF EXISTS `e_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `type` int(2) NOT NULL,
  `class` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `e_posts`
--

DROP TABLE IF EXISTS `e_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `content` mediumtext NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `created_unix` int(10) NOT NULL,
  `verified` int(2) NOT NULL,
  `comments` text NOT NULL DEFAULT '{}',
  `src` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=283 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `e_users`
--

DROP TABLE IF EXISTS `e_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `e_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(40) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `register_date` int(10) NOT NULL,
  `birth_date` int(10) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_city` varchar(60) NOT NULL,
  `u_edu` varchar(70) NOT NULL,
  `u_sm` text NOT NULL,
  `u_about` text NOT NULL,
  `u_ava` varchar(255) NOT NULL,
  `u_phone` varchar(40) NOT NULL,
  `u_last_online` int(10) NOT NULL,
  `type` int(10) NOT NULL DEFAULT 1,
  `parameters` text NOT NULL,
  `register_ip` varchar(15) NOT NULL,
  `banned_ips` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(50) NOT NULL,
  `directory` varchar(50) NOT NULL,
  `eTime` varchar(20) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `userID` int(5) NOT NULL DEFAULT -1,
  `type` int(11) NOT NULL,
  `val` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=314 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(30) NOT NULL,
  `user` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` int(8) NOT NULL,
  `type` int(4) NOT NULL DEFAULT 1,
  `info` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


