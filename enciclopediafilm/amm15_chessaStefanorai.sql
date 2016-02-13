-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Feb 13, 2016 alle 18:36
-- Versione del server: 5.5.41-0ubuntu0.14.04.1
-- Versione PHP: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amm15_chessaStefanorai`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `caseproduttrici`
--

CREATE TABLE IF NOT EXISTS `caseproduttrici` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nomecasaproduttrice` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `caseproduttrici`
--

INSERT INTO `caseproduttrici` (`id`, `nomecasaproduttrice`) VALUES
(1, 'Universal'),
(2, 'Sony'),
(3, 'Medusa Film');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomecategoria` varchar(30) DEFAULT NULL,
  `idcasaproduttrice` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `caseproduttrici_fk` (`idcasaproduttrice`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nomecategoria`, `idcasaproduttrice`) VALUES
(1, 'Horror', 1),
(2, 'Drammatico', 1),
(3, 'Romantico', 2),
(4, 'Thriller', 2),
(5, 'Commedia', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE IF NOT EXISTS `clienti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`id`, `nome`, `cognome`, `email`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'davide', 'spano', 'spano@unica.it', 'doberdo', 55, 'carbonia', 'cliente1', 'spano'),
(2, 'carlo', 'conti', 'carlo.conti@gmail.com', 'italia', 72, 'firenze', 'cliente2', 'conti');
-- --------------------------------------------------------

--
-- Struttura della tabella `filmi`
--

CREATE TABLE IF NOT EXISTS `filmi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `titolo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `filmi`
--

INSERT INTO `filmi` (`id`, `idcategoria`, `anno`, `titolo`) VALUES
(1, 1, 1984, 'The ring'),
(2, 1, 2003, 'Non aprite quella porta'),
(3, 2, 1970, 'Banditi a Orgosolo'),
(4, 3, 1999, 'Titanic'),
(7, 4, 1995, 'Primavera di granito'),
(8, 5, 2015, 'Quo'' Vado');

-- --------------------------------------------------------

--
-- Struttura della tabella `gestori`
--

CREATE TABLE IF NOT EXISTS `gestori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) DEFAULT NULL,
  `cognome` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `via` varchar(128) DEFAULT NULL,
  `numero_civico` int(128) DEFAULT NULL,
  `citta` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `gestori`
--

INSERT INTO `gestori` (`id`, `nome`, `cognome`, `email`, `via`, `numero_civico`, `citta`, `username`, `password`) VALUES
(1, 'stefano', 'chessa', 'sr.chessa@tiscali.it', 'Genova', 12, 'Benetutti', 'gestore', 'chessa');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `caseproduttici_fk` FOREIGN KEY (`idcasaproduttrice`) REFERENCES `caseproduttrici` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
