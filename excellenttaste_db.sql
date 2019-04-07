-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 04 Dec 2017 om 20:47
-- Serverversie: 5.1.37
-- PHP-Versie: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'excellenttaste_db'
--
CREATE DATABASE excellenttaste_db DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE excellenttaste_db;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'bestelling'
--

CREATE TABLE bestelling (
  bestelling_id int(11) NOT NULL AUTO_INCREMENT,
  reservering_id int(11) NOT NULL,
  tafel int(11) NOT NULL,
  datum date NOT NULL,
  tijd time NOT NULL,
  menuitemcode varchar(4) NOT NULL,
  aantal int(11) NOT NULL,
  prijs decimal(5,2) NOT NULL,
  PRIMARY KEY (bestelling_id),
  KEY menuitemcode (menuitemcode)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Gegevens worden uitgevoerd voor tabel 'bestelling'
--

INSERT INTO bestelling (bestelling_id, reservering_id, tafel, datum, tijd, menuitemcode, aantal, prijs) VALUES
(11, 10, 7, '2017-11-01', '21:45:16', 'vl2', 3, '9.95'),
(12, 10, 7, '2017-11-01', '21:45:22', 'ij2', 3, '2.95'),
(13, 10, 7, '2017-11-01', '21:45:27', 'kv2', 2, '5.95'),
(14, 10, 7, '2017-11-01', '21:45:30', 'wv3', 5, '4.95'),
(15, 10, 7, '2017-11-01', '21:45:46', 'fi5', 4, '2.75'),
(16, 14, 6, '2017-11-01', '09:12:54', 'fi4', 2, '2.75'),
(17, 14, 6, '2017-11-01', '09:12:57', 'bi5', 1, '4.75'),
(18, 14, 6, '2017-11-01', '09:12:59', 'bi3', 1, '2.95'),
(19, 14, 6, '2017-11-01', '09:13:04', 'wa3', 2, '5.00'),
(20, 14, 6, '2017-11-01', '09:13:15', 'vl1', 5, '11.95'),
(21, 14, 6, '2017-11-01', '09:13:24', 'mo1', 3, '4.95'),
(22, 14, 6, '2017-11-01', '09:13:42', 'wv1', 1, '4.95'),
(23, 14, 6, '2017-11-01', '09:13:44', 'wv2', 1, '3.95'),
(24, 14, 6, '2017-11-01', '09:13:49', 'wv3', 3, '4.95'),
(30, 5, 7, '2017-11-01', '01:20:27', 'wd3', 3, '2.95'),
(32, 12, 4, '2017-11-01', '18:50:54', 'bi1', 1, '2.95'),
(38, 3, 6, '2017-11-01', '13:01:37', 'bi3', 2, '2.95'),
(39, 3, 6, '2017-11-01', '13:01:44', 'ko1', 3, '4.00'),
(41, 2, 5, '2017-11-01', '20:58:01', 'wi2', 2, '17.95'),
(43, 15, 2, '2017-11-01', '10:57:56', 'wi3', 5, '3.95'),
(54, 2, 5, '2017-11-01', '19:14:36', 'wd6', 3, '2.95'),
(55, 2, 5, '2017-11-01', '19:14:37', 'wi4', 1, '3.60'),
(56, 15, 2, '2017-11-01', '18:12:57', 'bi3', 3, '2.95'),
(60, 19, 4, '2017-11-01', '14:53:33', 'fi5', 3, '2.75'),
(61, 11, 0, '0000-00-00', '00:00:00', 'vl2', 0, '0.00'),
(62, 24, 1, '2017-11-16', '17:48:57', 'bi2', 1, '3.95'),
(69, 2, 5, '2017-11-16', '18:28:53', 'fi4', 1, '2.75'),
(70, 2, 5, '2017-11-19', '12:11:54', 'wd7', 1, '3.95'),
(71, 2, 5, '2017-11-19', '12:13:12', 'wd6', 1, '2.95'),
(72, 2, 5, '2017-11-19', '12:13:17', 'wd4', 1, '2.45'),
(73, 2, 5, '2017-11-19', '12:22:27', 'wd4', 1, '2.45'),
(74, 14, 6, '2017-12-04', '12:42:43', 've1', 1, '11.95');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'bon'
--

CREATE TABLE bon (
  tafel varchar(3) NOT NULL,
  datum date NOT NULL,
  tijd time NOT NULL,
  betalingswijze varchar(2) NOT NULL,
  PRIMARY KEY (tafel,datum,tijd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel 'bon'
--


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'gerecht'
--

CREATE TABLE gerecht (
  gerechtcode varchar(3) NOT NULL,
  gerechtnaam varchar(20) NOT NULL,
  PRIMARY KEY (gerechtcode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel 'gerecht'
--

INSERT INTO gerecht (gerechtcode, gerechtnaam) VALUES
('drk', 'Dranken'),
('hap', 'Hapjes'),
('hog', 'Hoofdgerechten'),
('nag', 'Nagerechten'),
('vog', 'Voorgerechten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'klant'
--

CREATE TABLE klant (
  klant_id int(11) NOT NULL AUTO_INCREMENT,
  klantnaam varchar(30) NOT NULL,
  telefoon varchar(11) NOT NULL,
  email varchar(128) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (klant_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel 'klant'
--

INSERT INTO klant (klant_id, klantnaam, telefoon, email, status) VALUES
(1, 'Piet Hein', '0616243524', 'piet.hein@gmail.com', 1),
(2, 'Yolanthe Snijder', '0633442188', 'yolo@hotmail.nl', 1),
(3, 'Mata Hari', '0676453212', 'matahari@gmail.com', 1),
(4, 'Piet Mondriaan', '06989898877', 'piet@mondriaan.nl', 1),
(5, 'Johnny Jordaan', '0678453425', 'john@jordaan.nl', 1),
(6, 'Linda de Mol', '0699889988', 'lindademol@demol.com', 1),
(7, 'Louis Couperus', '0600110023', 'l.couperus@obscura.nl', 1),
(8, 'Freddy Heineken', '0612123232', 'f.heinenken@heineken.eu', 1),
(9, 'Jeroen Krabbe', '0699998811', 'jeroenkrabbe@hotmail.com', 1),
(10, 'Anton Geesink', '0623764588', 'a.geesink@gmail.com', 1),
(11, 'Willem Alexander van Buren', '0610000000', 'willem@oranje.nl', 1),
(12, 'Herman Brood', '0612123333', 'herman@hermanbrood.nl', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'menuitem'
--

CREATE TABLE menuitem (
  subgerechtcode varchar(4) NOT NULL,
  menuitemcode varchar(4) NOT NULL,
  menuitemnaam varchar(30) NOT NULL,
  prijs decimal(5,2) NOT NULL,
  PRIMARY KEY (menuitemcode),
  KEY subgerechtcode (subgerechtcode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel 'menuitem'
--

INSERT INTO menuitem (subgerechtcode, menuitemcode, menuitemnaam, prijs) VALUES
('bik', 'bi1', 'Pilsner', '2.95'),
('bik', 'bi2', 'Weizen', '3.95'),
('bik', 'bi3', 'Stender', '2.95'),
('bik', 'bi4', 'Palm', '3.60'),
('bik', 'bi5', 'Kasteel donker', '4.85'),
('bik', 'bi6', 'Brugse Zot', '3.55'),
('bik', 'bi7', 'Grimbergen dubbel', '3.95'),
('fik', 'fi1', 'Tonic', '2.95'),
('fik', 'fi2', 'Seven Up', '2.95'),
('fik', 'fi3', 'Verse Jus', '3.95'),
('fik', 'fi4', 'Chaudfontaine rood', '2.75'),
('fik', 'fi5', 'Chaudfontaine blauw', '2.75'),
('ijn', 'ij1', 'Black Lady', '4.95'),
('ijn', 'ij2', 'Vruchtenijs', '2.95'),
('koh', 'ko1', 'Portie kaas met mosterd', '4.00'),
('koh', 'ko2', 'Brood met kruidenboter', '5.00'),
('koh', 'ko3', 'Portie salami worst', '4.00'),
('kov', 'kv1', 'Salade met geitenkaas', '4.95'),
('kov', 'kv2', 'Tonijnsalade', '5.95'),
('kov', 'kv3', 'Zalmsalade', '5.95'),
('mon', 'mo1', 'Chocolademousse', '4.95'),
('mon', 'mo2', 'Vanillemousse', '3.95'),
('veh', 've1', 'Bonengerecht met diverse groen', '11.95'),
('veh', 've2', 'Gebakken banana', '10.95'),
('vih', 'vi1', 'Gebakken makreel', '8.95'),
('vih', 'vi2', 'Mosselen uit pan', '9.95'),
('vlh', 'vl1', 'Biefstuk in champignonsaus', '11.95'),
('vlh', 'vl2', 'Wienerschnitzel', '9.95'),
('wah', 'wa1', 'Bitterballetjes met mosterd', '4.25'),
('wdk', 'wd1', 'Koffie', '2.45'),
('wdk', 'wd2', 'Thee', '2.45'),
('wdk', 'wd3', 'Chocolademelk', '2.95'),
('wdk', 'wd4', 'Espresso', '2.45'),
('wdk', 'wd5', 'Cappucino', '2.75'),
('wdk', 'wd6', 'Koffie verkeerd', '2.95'),
('wdk', 'wd7', 'Latte Macchiato', '3.95'),
('wik', 'wi1', 'Per glas', '3.95'),
('wik', 'wi2', 'Per fles', '17.95'),
('wik', 'wi3', 'Seizoenswijn', '3.95'),
('wik', 'wi4', 'Rode port', '3.60'),
('wav', 'wv1', 'Tomatensoep', '4.95'),
('wav', 'wv2', 'Groentesoep', '3.95'),
('wav', 'wv3', 'Aspergesoep', '4.95'),
('wav', 'wv4', 'Uiensoep', '3.95');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'reservering'
--

CREATE TABLE reservering (
  reservering_id int(11) NOT NULL AUTO_INCREMENT,
  tafel int(11) NOT NULL,
  datum date NOT NULL,
  tijd time NOT NULL,
  klant_id int(11) NOT NULL,
  aantal int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  datum_toegevoegd timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (reservering_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Gegevens worden uitgevoerd voor tabel 'reservering'
--

INSERT INTO reservering (reservering_id, tafel, datum, tijd, klant_id, aantal, status, datum_toegevoegd) VALUES
(1, 1, '2017-12-04', '17:00:00', 1, 5, 1, '2017-01-24 16:05:17'),
(2, 5, '2017-12-04', '13:30:00', 3, 6, 1, '2017-01-24 16:05:17'),
(3, 6, '2017-12-04', '17:15:00', 4, 8, 1, '2017-01-24 16:05:17'),
(4, 2, '2017-12-04', '21:30:00', 5, 2, 1, '2017-01-24 16:05:17'),
(5, 7, '2017-12-04', '19:00:00', 2, 6, 1, '2017-01-24 16:15:56'),
(6, 2, '2017-12-04', '19:00:00', 6, 4, 1, '2017-01-24 18:47:58'),
(7, 4, '2017-12-04', '21:30:00', 7, 8, 1, '2017-01-24 20:59:51'),
(8, 1, '2017-12-04', '19:45:00', 8, 2, 1, '2017-01-24 21:08:20'),
(10, 7, '2017-12-04', '21:00:00', 9, 5, 1, '2017-01-24 21:40:32'),
(11, 1, '2017-12-04', '20:00:00', 11, 5, 1, '2017-01-25 20:15:04'),
(12, 4, '2017-12-04', '22:00:00', 5, 2, 1, '2017-01-25 21:12:02'),
(13, 1, '2017-12-04', '18:00:00', 8, 4, 1, '2017-01-25 21:12:42'),
(14, 6, '2017-12-04', '15:00:00', 9, 6, 1, '2017-01-26 09:11:34'),
(15, 2, '2017-12-04', '20:18:00', 1, 5, 1, '2017-09-25 13:00:04'),
(16, 4, '2017-12-04', '20:00:00', 2, 4, 1, '2017-10-23 12:08:25'),
(17, 5, '2017-12-04', '19:30:00', 12, 2, 1, '2017-10-23 12:08:51'),
(18, 5, '2017-12-04', '20:00:00', 16, 10, 1, '2017-11-16 13:54:00'),
(19, 8, '2017-12-04', '20:18:00', 1, 8, 1, '2017-11-16 16:23:38'),
(20, 8, '2017-12-04', '17:00:00', 1, 8, 1, '2017-11-16 16:24:05'),
(21, 5, '2017-12-04', '17:00:00', 1, 15, 1, '2017-11-16 16:24:27'),
(22, 7, '2017-12-04', '17:00:00', 1, 7, 1, '2017-11-16 16:25:49'),
(23, 1, '2017-12-04', '17:00:00', 1, 15, 1, '2017-11-16 16:28:38'),
(24, 2, '2017-12-04', '17:00:00', 1, 5, 1, '2017-11-16 16:28:53'),
(25, 4, '2017-12-04', '19:00:00', 1, 1, 1, '2017-11-16 16:29:03'),
(26, 2, '2017-12-04', '17:00:00', 1, 3, 1, '2017-11-16 16:29:33');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel 'subgerecht'
--

CREATE TABLE subgerecht (
  gerechtcode varchar(3) NOT NULL,
  subgerechtcode varchar(4) NOT NULL,
  subgerechtnaam varchar(25) NOT NULL,
  PRIMARY KEY (subgerechtcode),
  KEY gerechtcode (gerechtcode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden uitgevoerd voor tabel 'subgerecht'
--

INSERT INTO subgerecht (gerechtcode, subgerechtcode, subgerechtnaam) VALUES
('nag', 'ijn', 'Ijs'),
('hap', 'koh', 'Koude hapjes'),
('vog', 'kov', 'Koude voorgerechten'),
('nag', 'mon', 'Mousse'),
('hog', 'veh', 'Vegetarische gerechten'),
('hog', 'vih', 'Visgerechten'),
('hog', 'vlh', 'Vleesgerechten'),
('hap', 'wah', 'Warme hapjes'),
('vog', 'wav', 'Warme voorgerechten'),
('drk', 'wdk', 'Warme dranken'),
('drk', 'wik', 'Wijnen');
