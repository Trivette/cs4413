-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2015 at 08:48 PM
-- Server version: 5.5.43-37.2-log
-- PHP Version: 5.5.24
CREATE DATABASE  IF NOT EXISTS `uniball` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `uniball`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uniball`
--

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE IF NOT EXISTS `webuser` (
  `userId` int(11) NOT NULL,
  `userName` varchar(255)	COLLATE utf8_unicode_ci NOT NULL,
  `hockName` varchar(40)  	CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) 	COLLATE utf8_unicode_ci DEFAULT NULL,
  `email`	 varchar(255)	COLLATE utf8_unicode_ci DEFAULT NULL,
  `url`		 varchar(255)	COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture`	 varchar(255)	COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userlogin`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`userId`), ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `webuser`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
