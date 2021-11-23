-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2021 at 08:37 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbwefix`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '11111111');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `schedule` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `amount` float NOT NULL,
  `dateadded` datetime NOT NULL,
  `status` text NOT NULL,
  `dateapproved` datetime NOT NULL,
  `dateintransit` datetime NOT NULL,
  `dateongoing` datetime NOT NULL,
  `datecancelled` datetime NOT NULL,
  `datecompleted` datetime NOT NULL,
  `durationintransit` text NOT NULL,
  `durationupdate` text NOT NULL,
  `durationupdate_lat` text NOT NULL,
  `durationupdate_lng` text NOT NULL,
  `fee` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `serviceid`, `clientid`, `schedule`, `rating`, `amount`, `dateadded`, `status`, `dateapproved`, `dateintransit`, `dateongoing`, `datecancelled`, `datecompleted`, `durationintransit`, `durationupdate`, `durationupdate_lat`, `durationupdate_lng`, `fee`) VALUES
(2, 1, 1, '2021-08-27 14:00:00', 0, 0, '2021-08-26 14:35:10', 'Completed', '2021-08-29 22:14:12', '2021-08-29 23:42:33', '2021-08-30 09:23:26', '0000-00-00 00:00:00', '2021-08-30 09:30:55', 'less than a minute', 'less than a minute', '14.401536', '120.9401344', 0),
(3, 2, 1, '2021-08-26 22:15:00', 0, 0, '2021-08-26 21:14:38', 'Pending', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', 0),
(4, 1, 1, '2021-08-27 11:00:00', 0, 0, '2021-08-26 21:44:00', 'Completed', '2021-08-30 09:34:38', '2021-08-30 09:35:28', '2021-08-30 09:36:11', '0000-00-00 00:00:00', '2021-08-30 10:06:01', 'less than a minute', 'less than a minute', '14.401536', '120.9401344', 5000),
(6, 1, 1, '2021-10-24 12:00:00', 0, 0, '2021-10-24 09:09:29', 'Completed', '2021-10-24 09:12:01', '2021-10-24 09:12:38', '2021-10-24 09:14:19', '0000-00-00 00:00:00', '2021-10-24 09:14:54', 'less than a minute', 'less than a minute', '13.8162016', '121.2740813', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `fullname`, `mobile`, `email`, `address`, `password`, `latitude`, `longitude`) VALUES
(1, 'Mario Santos', '09280000000', 'mariosantos@gmail.com', 'Unit 3 Blk 15 Sample Village, Brgy. Cawongan, Padre Garcia, Batangas', '11111111', '13.8847395', '121.24887550000001');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `providerid` int(11) NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `providerid`, `file`) VALUES
(8, 2, 'assets/documents/doc3.txt'),
(7, 2, 'assets/documents/doc1.txt'),
(6, 1, 'assets/documents/doc2.txt'),
(5, 1, 'assets/documents/doc1.txt'),
(9, 1, 'assets/documents/doc3.txt'),
(17, 9, 'assets/documents/KOJ_LOCATION_LIST.csv'),
(16, 8, 'assets/documents/KOJ_LOCATION_LIST.csv'),
(15, 7, 'assets/documents/UPDATED LEASE DATE.xlsx'),
(14, 6, 'assets/documents/[SETUP GUIDE] OPC.docx');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL,
  `active` int(11) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `services` text NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `company`, `contact`, `email`, `address`, `password`, `active`, `deleted`, `services`, `img`) VALUES
(1, 'Home Solutions, Inc.', '09274587910', 'homesolutions@gmail.com', 'Brgy. Tambo, Lipa City, Batangas 4217', '11111111', 1, b'0', 'Cabinet Making, Carpentry, Painting', 'img/img.jpg'),
(2, 'Repair Buddy', '09284410278', 'repairbuddy@gmail.com', 'Brgy. Pinagkawitan, Lipa City, Batangas 4217', '11111111', 1, b'0', 'Carpentry, Painting', 'img/img.jpg'),
(6, 'Sample Company', '09197865428', 'sample@gmail.com', '302-A', '11111111', 1, b'1', 'Cabinet Making, Carpentry, Painting', 'img/img.jpg'),
(9, 'Sample Company 2', '09197865422', 'sample2@gmail.com', 'N/A', '11111111', 0, b'0', 'Aircon Repair, Cabinet Making', 'img/download.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE IF NOT EXISTS `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointmentid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `appointmentid`, `rate`, `remarks`, `dateadded`) VALUES
(1, 2, 5, 'this is a sample remarks', '2021-08-30 10:33:05'),
(2, 4, 4, 'not okay', '2021-08-30 10:43:29'),
(3, 6, 5, 'sample', '2021-10-24 09:15:16'),
(4, 3, 5, 's', '2021-11-22 14:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `providerid` int(11) NOT NULL,
  `service` text NOT NULL,
  `description` text NOT NULL,
  `dateadded` datetime NOT NULL,
  `typeid` int(11) NOT NULL,
  `tags` text NOT NULL,
  `longitude` text NOT NULL,
  `latitude` text NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `providerid`, `service`, `description`, `dateadded`, `typeid`, `tags`, `longitude`, `latitude`, `deleted`) VALUES
(1, 1, 'Electrical Repair Service', 'Electrical repairs involve a wide variety of services, ranging from major installation, or rewiring your home, to changing over a broken socket or breaker.', '2021-08-25 15:32:32', 7, 'electric, electrical', '121.2511902', '13.8810106', b'0'),
(2, 2, 'Painting Service', 'Involves painting for interior, exterior, cabinets and more.', '2021-08-25 17:28:08', 5, 'paint, wall, painting', '121.2275282', '13.8759486', b'0'),
(4, 6, 'Sample Service', 'sample', '2021-11-16 08:40:39', 1, 'sample', '1.0', '1.0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE IF NOT EXISTS `service_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `type`, `deleted`) VALUES
(1, 'Aircon Repair', b'0'),
(2, 'Electric Fan Repair', b'0'),
(3, 'TV Repair', b'1'),
(4, 'Washing Machine Repair', b'0'),
(5, 'Painting', b'0'),
(6, 'Plumbing', b'0'),
(7, 'Electrical Repair', b'0'),
(8, 'Ceiling Fan Installation', b'0'),
(9, 'Switch and Outlet Repair/Installation', b'0'),
(10, 'Tiling', b'0'),
(11, 'Carpentry', b'0'),
(12, 'Cabinet Making', b'0'),
(13, 'Shelving', b'0'),
(14, 'Door Replacement', b'0'),
(15, 'Framing', b'0'),
(16, 'Toilet Repair', b'0'),
(17, 'Leak Repair', b'0');
