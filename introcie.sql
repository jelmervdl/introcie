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
  `naam` varchar(64) CHARACTER SET latin1 NOT NULL,
  `email` varchar(64) CHARACTER SET latin1 NOT NULL,
  `bericht` text CHARACTER SET latin1 NOT NULL,
  `datum` int(11) NOT NULL,
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL COMMENT 'IPv4 (voor blokken)',
  PRIMARY KEY (`bericht_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inschrijvingen`
--

CREATE TABLE IF NOT EXISTS `inschrijvingen` (
  `deelnemer_id` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(64) CHARACTER SET latin1 NOT NULL,
  `tussenvoegsel` varchar(16) CHARACTER SET latin1 NOT NULL,
  `achternaam` varchar(64) CHARACTER SET latin1 NOT NULL,
  `adres` varchar(128) CHARACTER SET latin1 NOT NULL,
  `postcode` varchar(10) CHARACTER SET latin1 NOT NULL COMMENT 'Hebben duitsers andere postcodes? voor de zekerheid iig',
  `woonplaats` varchar(32) CHARACTER SET latin1 NOT NULL,
  `telefoonnummer` varchar(15) CHARACTER SET latin1 NOT NULL,
  `thuisnummer` varchar(15) CHARACTER SET latin1 NOT NULL,
  `rekeningnummer` varchar(15) CHARACTER SET latin1 NOT NULL,
  `vega` enum('ja','nee') CHARACTER SET latin1 NOT NULL DEFAULT 'nee',
  `deelnemer` enum('sjaars','ouderejaars','mentor') CHARACTER SET latin1 NOT NULL,
  `opleiding` enum('KI','INF','Anders') CHARACTER SET latin1 NOT NULL,
  `email` varchar(128) CHARACTER SET latin1 NOT NULL,
  `mededeling` text CHARACTER SET latin1 NOT NULL,
  `betaald` enum('ja','nee') CHARACTER SET latin1 NOT NULL DEFAULT 'nee',
  `akkosten` enum('ja','nee') CHARACTER SET latin1 NOT NULL COMMENT 'Akkoord voor de kosten van het kamp',
  `akvoorwaarden` enum('ja','nee') CHARACTER SET latin1 NOT NULL COMMENT 'Akkoord met de algemene kamp voorwaarden',
  PRIMARY KEY (`deelnemer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
