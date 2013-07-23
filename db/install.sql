
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `studip`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `neostats`
--

CREATE TABLE IF NOT EXISTS `neostats` (
  `statid` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `url` text COLLATE latin1_general_ci NOT NULL,
  `id` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `seitenname` text COLLATE latin1_general_ci NOT NULL,
  `count` int(10) NOT NULL,
  `day` int(10) NOT NULL,
  `chdate` int(10) NOT NULL,
  `mkdate` int(10) NOT NULL,
  PRIMARY KEY (`statid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `neostat_temp`
--

CREATE TABLE IF NOT EXISTS `neostat_temp` (
  `neostat_id` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `statid` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `url` text COLLATE latin1_general_ci,
  `id` text COLLATE latin1_general_ci,
  `chdate` int(20) NOT NULL,
  `mkdate` int(20) NOT NULL,
  PRIMARY KEY (`neostat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
