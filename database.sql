-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2014 at 06:54 PM
-- Server version: 5.1.70-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fipich_trash2`
--

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `labels`
--

INSERT INTO `labels` (`id`, `name`) VALUES
(1, 'Horror'),
(2, 'Komödie'),
(3, 'Action'),
(4, 'Dokumentation'),
(5, 'Romantik'),
(6, 'Musical'),
(7, 'Liebesfilm'),
(8, 'Fantasy');

-- --------------------------------------------------------

--
-- Table structure for table `label_mediums`
--

CREATE TABLE IF NOT EXISTS `label_mediums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `labelId` int(11) NOT NULL,
  `mediumId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `label_mediums`
--

INSERT INTO `label_mediums` (`id`, `labelId`, `mediumId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 9),
(4, 0, 9),
(5, 4, 9),
(6, 0, 9),
(9, 5, 11),
(10, 1, 11),
(11, 0, 11),
(12, 0, 11),
(13, 0, 11),
(14, 0, 11),
(15, 0, 11),
(16, 0, 11),
(17, 0, 11),
(18, 0, 11),
(27, 4, 12),
(28, 1, 10),
(29, 2, 10),
(30, 2, 14),
(31, 2, 5),
(32, 3, 5),
(33, 2, 7),
(34, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `lendings`
--

CREATE TABLE IF NOT EXISTS `lendings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lenderId` int(11) NOT NULL,
  `mediumId` int(11) NOT NULL,
  `datefrom` datetime DEFAULT NULL,
  `dateto` datetime DEFAULT NULL,
  `status` enum('pending','yes','no','wrongdate','sent','completed') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `lendings`
--

INSERT INTO `lendings` (`id`, `lenderId`, `mediumId`, `datefrom`, `dateto`, `status`) VALUES
(1, 6, 9, NULL, NULL, 'sent'),
(2, 6, 9, NULL, NULL, 'yes'),
(3, 6, 9, '2013-12-01 00:00:00', '2013-12-12 00:00:00', 'pending'),
(4, 6, 4, '2013-04-12 00:00:00', '2013-04-12 00:00:00', 'pending'),
(5, 6, 4, '2013-04-14 00:00:00', '2013-05-16 00:00:00', 'pending'),
(6, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(7, 6, 4, '2013-12-04 00:00:00', '2013-12-12 00:00:00', 'pending'),
(8, 6, 4, '2013-04-12 00:00:00', '2013-05-12 00:00:00', 'pending'),
(9, 6, 4, '2013-04-12 00:00:00', '2013-05-12 00:00:00', 'pending'),
(10, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(11, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(12, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(13, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(14, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(15, 6, 4, '2013-04-12 00:00:00', '2013-05-13 00:00:00', 'pending'),
(16, 6, 6, '2013-12-04 00:00:00', '2013-12-04 00:00:00', 'wrongdate'),
(17, 6, 6, '2013-12-04 00:00:00', '2013-12-04 00:00:00', 'no'),
(18, 7, 11, '2013-12-09 00:00:00', '2013-12-09 00:00:00', 'pending'),
(19, 6, 12, '2013-12-24 00:00:00', '2013-12-24 00:00:00', 'pending'),
(20, 6, 1, '2014-01-05 00:00:00', '2014-01-05 00:00:00', 'pending'),
(21, 6, 1, '2014-01-05 00:00:00', '2014-01-05 00:00:00', 'pending'),
(22, 6, 12, '2014-01-06 00:00:00', '2014-01-06 00:00:00', 'wrongdate');

-- --------------------------------------------------------

--
-- Table structure for table `mediums`
--

CREATE TABLE IF NOT EXISTS `mediums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `description` text,
  `userId` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `mediums`
--

INSERT INTO `mediums` (`id`, `name`, `description`, `userId`, `price`) VALUES
(1, 'James Bond', 'Krakenqualle ist der neue James Bond Film Jahr 2014. Superspannend!', 0, 0),
(2, 'Die Hard 7', 'Immer noch langweilig.hmmm', 0, 0),
(3, 'Spongebob - Der Film', 'David Hasselhoff ist wieder einmal fantastisch.', 0, 0),
(4, 'Man in Black - Noch einer', 'Ist immer noch daselbe, deshalb möchte ich ihn gerne irgendjemandem verteilen.', 0, 0),
(5, 'Frozen', '	\r\n4\r\nFrozen (2013)\r\n 102 min  -  Animation | Adventure | Comedy  -  27 November 2013 (USA)\r\n8.1 Your rating:   -/10   Ratings: 8.1/10 from 50,483 users   Metascore: 74/100 \r\nReviews: 262 user | 254 critic | 43 from Metacritic.com\r\nFearless optimist Anna teams up with Kristoff in an epic journey, encountering Everest-like conditions, and a hilarious snowman named Olaf in a race to find Anna''s sister Elsa, whose icy powers have trapped the kingdom in eternal winter.', 6, 3),
(6, 'Hunger Games 2 - Catching fire', 'Katniss Everdeen and Peeta Mellark become targets of the Capitol after their victory in the 74th Hunger Games sparks a rebellion in the Districts of Panem. (146 mins.)', 6, 0),
(7, 'Wreck-It-Ralph', 'A video game villain wants to be a hero and sets out to fulfill his dream, but his quest brings havoc to the whole arcade where he lives. (108 mins.)', 6, 0),
(10, 'Disney up', 'Alter Mann fliegt mit Luftballonen um die Welt', 6, 15.3),
(11, 'lieben und lassen', 'Noch eine Beschreibung blah blah', 7, 0),
(12, 'Der Hobbit', 'Der Hobbit läuft und läuft und läuft usw.', 6, 0),
(14, '27 Dresses', 'Liebeskomödie ', 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `info` text,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `info`, `address`) VALUES
(1, '', 'test', NULL, '', ''),
(2, '', 'benjamin', NULL, NULL, ''),
(3, '', 'benjamin', NULL, NULL, ''),
(6, 'fipichopf@gmail.com', 'Philipp Zimmermann', 'd653ea7ea31e77b41041e7e3d32e3e4a', 'Mein Name ist Philipp Zimmermann. Ich studiere an der ZHAW.', 'Philipp Zimmermann\r\nBrühlgartenstr. 6\r\n8401 Winterthur'),
(7, 'ornella@saranda.com', 'ornella@saranda.com', 'd653ea7ea31e77b41041e7e3d32e3e4a', NULL, ''),
(8, 'test17@gmail.com', 'test17@gmail.com', '733b3670efc9193a3ab01bad75999283', NULL, 'Teststrasse 25\r\nRümlang');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
