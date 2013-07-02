-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2013 at 12:06 AM
-- Server version: 5.1.66
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `introcie`
--

-- --------------------------------------------------------

--
-- Table structure for table `gastenboek`
--

CREATE TABLE IF NOT EXISTS `gastenboek` (
  `bericht_id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `bericht` text NOT NULL,
  `datum` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL COMMENT 'IPv4 (voor blokken)',
  PRIMARY KEY (`bericht_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inschrijvingen`
--

CREATE TABLE IF NOT EXISTS `inschrijvingen` (
  `deelnemer_id` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(64) NOT NULL,
  `tussenvoegsel` varchar(16) NOT NULL,
  `achternaam` varchar(64) NOT NULL,
  `adres` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL COMMENT 'Hebben duitsers andere postcodes? voor de zekerheid iig',
  `woonplaats` varchar(32) NOT NULL,
  `telefoonnummer` varchar(15) NOT NULL,
  `thuisnummer` varchar(15) NOT NULL,
  `rekeningnummer` varchar(15) NOT NULL,
  `vega` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `deelnemer` enum('sjaars','ouderejaars','mentor') NOT NULL,
  `opleiding` enum('KI','INF','Anders') NOT NULL,
  `email` varchar(128) NOT NULL,
  `mededeling` text NOT NULL,
  `betaald` enum('ja','nee') NOT NULL DEFAULT 'nee',
  `akkosten` enum('ja','nee') NOT NULL COMMENT 'Akkoord voor de kosten van het kamp',
  `akvoorwaarden` enum('ja','nee') NOT NULL COMMENT 'Akkoord met de algemene kamp voorwaarden',
  `random_id` CHAR(13) NOT NULL COMMENT 'Unieke waarde om dubbele invoer te voorkomen',
   PRIMARY KEY (`deelnemer_id`),
   UNIQUE KEY `random_id` (`random_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
