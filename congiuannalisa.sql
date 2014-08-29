-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2014 at 09:27 AM
-- Server version: 5.6.20
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `congiuannalisa`
--

-- --------------------------------------------------------

--
-- Table structure for table `manga`
--

CREATE TABLE IF NOT EXISTS `manga` (
`id` bigint(20) unsigned NOT NULL,
  `titolo` varchar(128) NOT NULL,
  `titolo_orig` varchar(128) NOT NULL,
  `n_volume` int(4) DEFAULT NULL,
  `autore` varchar(128) NOT NULL,
  `casa_ed` varchar(128) DEFAULT NULL,
  `anno_pub` year(4) NOT NULL,
  `lingua` varchar(50) NOT NULL,
  `categoria` varchar(10) NOT NULL,
  `genere` varchar(25) DEFAULT NULL,
  `descrizione` varchar(300) DEFAULT NULL,
  `prezzo` decimal(3,2) unsigned NOT NULL,
  `n_articoli` int(5) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `manga`
--

INSERT INTO `manga` (`id`, `titolo`, `titolo_orig`, `n_volume`, `autore`, `casa_ed`, `anno_pub`, `lingua`, `categoria`, `genere`, `descrizione`, `prezzo`, `n_articoli`) VALUES
(1, 'After School Nightmare', 'Houkago Hokenshitsu', 1, 'Mizushiro Setona', NULL, 2004, 'Italiano', 'Manga', NULL, NULL, '4.00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `utente_manga`
--

CREATE TABLE IF NOT EXISTS `utente_manga` (
  `acquisto_id` int(11) NOT NULL,
  `utente_fk` bigint(20) unsigned NOT NULL,
  `prodotto` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
`u_id` bigint(20) unsigned NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(15) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `civico` int(4) unsigned DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `cap` int(5) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`u_id`, `username`, `password`, `email`, `nome`, `cognome`, `via`, `civico`, `citta`, `provincia`, `cap`) VALUES
(1, 'utente1', 'utente1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'utente2', 'utente2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venditore_manga`
--

CREATE TABLE IF NOT EXISTS `venditore_manga` (
  `venditore_fk` bigint(20) unsigned NOT NULL,
  `manga_fk` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `venditori`
--

CREATE TABLE IF NOT EXISTS `venditori` (
`v_id` bigint(20) unsigned NOT NULL,
  `azienda` varchar(24) NOT NULL,
  `password` varchar(15) NOT NULL,
  `nome_tit` varchar(128) DEFAULT NULL,
  `cognome_tit` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `civico` int(4) unsigned DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `cap` int(5) unsigned DEFAULT NULL,
  `descrizione` varchar(400) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `venditori`
--

INSERT INTO `venditori` (`v_id`, `azienda`, `password`, `nome_tit`, `cognome_tit`, `email`, `via`, `civico`, `citta`, `provincia`, `cap`, `descrizione`) VALUES
(1, 'venditore1', 'venditore1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'venditore2', 'venditore2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manga`
--
ALTER TABLE `manga`
 ADD UNIQUE KEY `id` (`id`), ADD UNIQUE KEY `titolo` (`titolo`), ADD UNIQUE KEY `autore` (`autore`);

--
-- Indexes for table `utente_manga`
--
ALTER TABLE `utente_manga`
 ADD PRIMARY KEY (`acquisto_id`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
 ADD UNIQUE KEY `u_id` (`u_id`);

--
-- Indexes for table `venditore_manga`
--
ALTER TABLE `venditore_manga`
 ADD PRIMARY KEY (`venditore_fk`,`manga_fk`);

--
-- Indexes for table `venditori`
--
ALTER TABLE `venditori`
 ADD UNIQUE KEY `v_id` (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
MODIFY `u_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `venditori`
--
ALTER TABLE `venditori`
MODIFY `v_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
