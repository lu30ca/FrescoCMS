-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ago 07, 2013 alle 23:44
-- Versione del server: 5.5.32-0ubuntu0.13.04.1
-- Versione PHP: 5.4.9-4ubuntu2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `FrescoCMS_a`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE IF NOT EXISTS `commenti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_contenuto` varchar(200) NOT NULL,
  `id_contenuto` mediumint(7) unsigned NOT NULL,
  `autore` mediumint(7) unsigned NOT NULL,
  `contenuto` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `contenuti`
--

CREATE TABLE IF NOT EXISTS `contenuti` (
  `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `titolo` varchar(200) NOT NULL,
  `contenuto` text NOT NULL,
  `data` datetime NOT NULL,
  `autore` mediumint(7) unsigned NOT NULL,
  `commenti` tinyint(1) NOT NULL DEFAULT '1',
  `layout_pagina` tinyint(1) NOT NULL DEFAULT '0',
  `numero_commenti` mediumint(7) NOT NULL DEFAULT '0',
  `importanza` tinyint(1) NOT NULL DEFAULT '0',
  `immagine` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `contenuti`
--

INSERT INTO `contenuti` (`id`, `titolo`, `contenuto`, `data`, `autore`, `commenti`, `layout_pagina`, `numero_commenti`, `importanza`, `immagine`) VALUES
(1, 'Articolo di test', 'Questo è un articolo di test. Non perdere tempo a leggerlo: non contiene nessuna informazione interessante!!!', '2013-08-01 09:50:47', 1, 1, 0, 0, 0, NULL),
(2, 'Pagina di test', 'Questa è una pagina di test. Ciò che stai leggendo non è interessante e non ti fornirà nessuna informazione utile, smetti finché sei in tempo!', '2013-08-01 09:52:27', 2, 1, 1, 0, 0, NULL),
(3, 'Chi siamo', 'Questo è un contenuto scritto solo per test che non rispecchia il vero contenuto della pagina "chi siamo". Non perdere tempo a leggerlo, non ci troverai niente di interessante, serve solo a testare la piattaforma.', '2013-08-01 19:09:36', 2, 1, 1, 0, 0, NULL),
(4, 'test 2', 'Testo di esempio per l''articolo di test numero 2, niente di importante come al solito... non perdere tempo a leggerlo e fai qualcosa di produttivo!', '2013-08-04 20:19:22', 2, 1, 0, 0, 2, NULL),
(5, 'Articolo di prova 3', 'Un altro articolo di prova per testare il sito web, non perdere tempo a leggermi!!!', '2013-08-04 20:25:37', 3, 0, 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `eventi`
--

CREATE TABLE IF NOT EXISTS `eventi` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `titolo` varchar(200) NOT NULL,
  `data_inizio` datetime NOT NULL,
  `data_fine` datetime DEFAULT NULL,
  `descrizione` text,
  `immagine` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `eventi`
--

INSERT INTO `eventi` (`id`, `titolo`, `data_inizio`, `data_fine`, `descrizione`, `immagine`) VALUES
(1, 'Evento di test', '2013-08-23 19:30:00', '2013-08-23 23:30:00', 'Un evento per testare il sistema, niente di importante.', NULL),
(2, 'Evento di prova', '2013-08-10 00:00:00', '2013-08-14 00:00:00', 'Una descrizione di prova per un evento di prova.', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `cognome` varchar(60) NOT NULL,
  `descrizione` text,
  `immagine` varchar(200) DEFAULT NULL,
  `mostra_email` tinyint(1) NOT NULL,
  `strumenti` varchar(200) DEFAULT NULL,
  `permessi` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `password`, `nome`, `cognome`, `descrizione`, `immagine`, `mostra_email`, `strumenti`, `permessi`) VALUES
(1, 'lu30ca@gmail.com', 'asd?', 'Luca', 'Rinelli', 'Asd? LoL!', NULL, 1, NULL, 0),
(2, 'non@la.ricordo', 'asd?', 'Giuseppe', 'Rinelli', 'Questa dovrebbe essere una piccola descrizione dell''utente.', NULL, 1, NULL, 0),
(3, 'asd@lol.troll', 'asd?', 'Luca', 'Rinelli', NULL, NULL, 0, NULL, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
