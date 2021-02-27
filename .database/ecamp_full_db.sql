-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Mrz 2018 um 11:03
-- Server-Version: 10.1.30-MariaDB
-- PHP-Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ecamp`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `camp`
--

CREATE TABLE `camp` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) DEFAULT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `group_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `slogan` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_course` smallint(1) NOT NULL,
  `jstype` smallint(6) NOT NULL,
  `type` smallint(6) NOT NULL,
  `type_text` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `creator_user_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `ca_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ca_street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ca_city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_tel` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_coor` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `t_created` int(10) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Camps';

--
-- Daten für Tabelle `camp`
--

INSERT INTO `camp` (`id`, `group_id`, `name`, `group_name`, `slogan`, `short_name`, `is_course`, `jstype`, `type`, `type_text`, `creator_user_id`, `ca_name`, `ca_street`, `ca_zipcode`, `ca_city`, `ca_tel`, `ca_coor`, `t_created`, `t_edited`) VALUES
(1, 0, 'Testkurs', 'Testpfadi', 'Kursmotto', 'CH-TST-18', 1, 53, 14, 'Kursart-Freitext', 1, 'Kursadresse-Name', 'Kursadresse-Strasse', '6666', 'Kursadresse-Ort', 'Kursadresse-Telefon', '000.111/222.333', 1514764800, '2017-12-31 23:00:00'),
(2, 0, 'Testlager', 'Testpfadi', 'Lagermotto', 'So-La', 0, 52, 0, 'Kursart-Freitext', 1, 'Lageradresse-Name', 'Lageradresse-Strasse', '6666', 'Lageradresse-Ort', 'Lageradresse-Telefon', '000.111/222.333', 1514764800, '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `form_type` tinyint(3) UNSIGNED DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Kategorien pro Camp';

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `camp_id`, `name`, `short_name`, `color`, `form_type`, `t_edited`) VALUES
(1, 1, 'Ausbildung', 'A', '548dd4', 4, '2017-12-31 23:00:00'),
(2, 1, 'Pfadi erleben', 'P', 'ffa200', 4, '2017-12-31 23:00:00'),
(3, 1, 'Roter Faden', 'RF', '14dd33', 4, '2017-12-31 23:00:00'),
(4, 1, 'Gruppestunde', 'GS', '99ccff', 4, '2017-12-31 23:00:00'),
(5, 1, 'Essen', '', 'bbbbbb', 0, '2017-12-31 23:00:00'),
(6, 1, 'Sonstiges', '', 'FFFFFF', 0, '2017-12-31 23:00:00'),
(7, 2, 'Essen', 'ES', 'bbbbbb', 0, '2017-12-31 23:00:00'),
(8, 2, 'Lagerprogramm', 'LP', '99ccff', 3, '2017-12-31 23:00:00'),
(9, 2, 'Lageraktivität', 'LA', 'ffa200', 2, '2017-12-31 23:00:00'),
(10, 2, 'Lagersport', 'LS', '14dd33', 1, '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_aim`
--

CREATE TABLE `course_aim` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` mediumint(8) UNSIGNED DEFAULT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `aim` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_checklist`
--

CREATE TABLE `course_checklist` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` mediumint(8) UNSIGNED DEFAULT NULL,
  `short` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `short_1` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `short_2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `selectable` tinyint(4) NOT NULL DEFAULT '1',
  `valid` tinyint(4) NOT NULL DEFAULT '1',
  `course_type` tinyint(4) DEFAULT NULL,
  `checklist_type` tinyint(4) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_type`
--

CREATE TABLE `course_type` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `scout_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `js_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `course_type`
--

INSERT INTO `course_type` (`id`, `scout_name`, `js_name`, `section`, `t_edited`) VALUES
(1, 'Anderer Kurs', '', '', '2009-07-02 09:46:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `day`
--

CREATE TABLE `day` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `subcamp_id` mediumint(8) UNSIGNED NOT NULL,
  `day_offset` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `story` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Days pro Subcamp';

--
-- Daten für Tabelle `day`
--

INSERT INTO `day` (`id`, `subcamp_id`, `day_offset`, `story`, `notes`, `t_edited`) VALUES
(1, 1, 0, '', '', '2017-12-31 23:00:00'),
(2, 1, 1, '', '', '2017-12-31 23:00:00'),
(3, 1, 2, '', '', '2017-12-31 23:00:00'),
(4, 1, 3, '', '', '2017-12-31 23:00:00'),
(5, 1, 4, '', '', '2017-12-31 23:00:00'),
(6, 1, 5, '', '', '2017-12-31 23:00:00'),
(7, 1, 6, '', '', '2017-12-31 23:00:00'),
(8, 1, 7, '', '', '2017-12-31 23:00:00'),
(9, 2, 0, '', '', '2017-12-31 23:00:00'),
(10, 2, 1, '', '', '2017-12-31 23:00:00'),
(11, 2, 2, '', '', '2017-12-31 23:00:00'),
(12, 2, 3, '', '', '2017-12-31 23:00:00'),
(13, 2, 4, '', '', '2017-12-31 23:00:00'),
(14, 2, 5, '', '', '2017-12-31 23:00:00'),
(15, 2, 6, '', '', '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dropdown`
--

CREATE TABLE `dropdown` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `list` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `item_nr` mediumint(8) NOT NULL,
  `entry` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Liste von Dropdown-Menus';

--
-- Daten für Tabelle `dropdown`
--

INSERT INTO `dropdown` (`id`, `list`, `item_nr`, `entry`, `value`, `t_edited`) VALUES
(1, 'function_camp', 1, 'AL', '50', '2009-11-02 19:40:35'),
(2, 'function_camp', 2, 'Lagerleiter', '50', '2009-11-02 19:40:47'),
(3, 'function_camp', 3, 'Leiter', '40', '2009-11-02 19:43:02'),
(4, 'function_camp', 5, 'Gast', '20', '2009-11-02 19:43:24'),
(5, 'function_camp', 0, 'Support', '0', '2009-11-02 19:43:15'),
(6, 'sex', 1, 'Männlich', '', '2008-10-05 16:49:44'),
(7, 'sex', 2, 'Weiblich', '', '2008-10-05 16:49:44'),
(8, 'jsedu', 0, '-', '', '2008-10-05 16:49:44'),
(9, 'jsedu', 1, 'Gruppenleiter', '', '2008-10-05 16:49:44'),
(10, 'jsedu', 2, 'Lagerleiter', '', '2008-10-05 16:49:44'),
(11, 'jsedu', 3, 'Ausbildner', '', '2008-10-05 16:49:44'),
(12, 'jsedu', 4, 'Experte', '', '2008-10-05 16:49:44'),
(20, 'pbsedu', 0, '-', '', '2008-10-05 16:49:44'),
(21, 'pbsedu', 1, 'Basiskurs', '', '2008-10-05 16:49:44'),
(22, 'pbsedu', 2, 'Aufbaukurs', '', '2008-10-05 16:49:44'),
(23, 'pbsedu', 3, 'Panokurs', '', '2008-10-05 16:49:44'),
(24, 'pbsedu', 4, 'Spektrum', '', '2008-10-05 16:49:44'),
(25, 'pbsedu', 5, 'Topkurs', '', '2008-10-05 16:49:44'),
(26, 'pbsedu', 6, 'Gillwell', '', '2008-10-05 16:49:44'),
(34, 'form', 0, 'kein Detailprogramm', '0', '2008-08-18 15:27:28'),
(35, 'form', 1, 'Lagersport', '1', '2008-10-05 16:38:43'),
(36, 'form', 2, 'Lageraktivität', '2', '2008-10-05 16:38:43'),
(37, 'form', 3, 'Sonstiges Lagerprogramm', '3', '2008-10-05 16:38:43'),
(38, 'form', 4, 'Ausbildungsblock', '4', '2008-10-05 16:38:43'),
(39, 'camptype', 0, 'J&S-Lager', '0', '2008-08-11 09:07:33'),
(41, 'coursetype', 1, '1. Stufe Basiskurs', '1', '2009-09-22 18:40:59'),
(42, 'coursetype', 2, '1. Stufe Aufbaukurs', '3', '2009-09-22 18:40:59'),
(43, 'coursetype', 3, '2. Stufe Basiskurs', '2', '2009-09-22 18:40:59'),
(44, 'coursetype', 4, '2. Stufe Aufbaukurs', '4', '2009-09-22 18:40:59'),
(45, 'coursetype', 99, 'Anderer Kurs', '99', '2017-10-18 16:42:19'),
(46, 'function_camp', 4, 'Coach', '20', '2009-11-02 19:44:23'),
(47, 'function_course', 0, 'Support', '0', '2009-11-02 19:46:33'),
(48, 'function_course', 1, 'Kursleiter', '50', '2009-11-02 19:46:33'),
(49, 'function_course', 2, 'Mitleiter', '40', '2009-11-02 19:53:38'),
(50, 'function_course', 3, 'LKB', '20', '2009-11-02 19:46:33'),
(51, 'function_course', 4, 'Gast', '20', '2009-11-02 19:46:33'),
(52, 'jstype', 1, 'J+S Kids', '1', '2009-12-10 00:59:34'),
(53, 'jstype', 2, 'J+S Teen', '2', '2009-12-10 00:59:34'),
(54, 'jstype', 3, 'Nicht J+S', '3', '2009-12-10 00:59:46'),
(55, 'coursetype', 5, 'Wolfsstufe Basiskurs', '11', '2011-12-06 21:40:09'),
(56, 'coursetype', 6, 'Wolfsstufe Aufbaukurs', '13', '2011-12-06 23:34:45'),
(57, 'coursetype', 7, 'Pfadistufe Basiskurs', '12', '2011-12-06 23:35:26'),
(58, 'coursetype', 8, 'Pfadistufe Aufbaukurs', '14', '2011-12-06 21:40:44'),
(59, 'coursetype', 21, 'Basiskurs Wolfsstufe', '21', '2017-10-18 16:37:37'),
(60, 'coursetype', 22, 'Basiskurs Pfadistufe', '22', '2017-10-18 16:38:29'),
(61, 'coursetype', 23, 'Aufbaukurs Wolfsstufe', '23', '2017-10-18 16:38:29'),
(62, 'coursetype', 24, 'Aufbaukurs Pfadistufe', '24', '2017-10-18 16:39:15'),
(63, 'coursetype', 25, 'Aufbaukurs Wolfs-/Pfadistufe', '25', '2017-10-18 16:39:15'),
(64, 'coursetype', 26, 'Einführungskurs Wolfsstufe', '26', '2017-10-18 16:39:50'),
(65, 'coursetype', 27, 'Einführungskurs Pfadistufe', '27', '2017-10-18 16:39:50'),
(66, 'coursetype', 28, 'Einführungskurs Piostufe', '28', '2017-10-18 16:40:40');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event`
--

CREATE TABLE `event` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `category_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `story` text COLLATE utf8_unicode_ci NOT NULL,
  `aim` text COLLATE utf8_unicode_ci NOT NULL,
  `method` text COLLATE utf8_unicode_ci NOT NULL,
  `topics` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `seco` text COLLATE utf8_unicode_ci NOT NULL,
  `progress` smallint(6) NOT NULL DEFAULT '0',
  `in_edition_by` mediumint(9) NOT NULL,
  `in_edition_time` int(10) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Events pro Day';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_aim`
--

CREATE TABLE `event_aim` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `aim_id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_checklist`
--

CREATE TABLE `event_checklist` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `checklist_id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_comment`
--

CREATE TABLE `event_comment` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `t_created` int(10) UNSIGNED DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Kommentare zu Events';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_detail`
--

CREATE TABLE `event_detail` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `prev_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `resp` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sorting` mediumint(8) UNSIGNED NOT NULL,
  `revision` int(11) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Details pro Event';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_document`
--

CREATE TABLE `event_document` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `print` tinyint(6) NOT NULL,
  `time` int(11) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PDFs an Events anhängen';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_instance`
--

CREATE TABLE `event_instance` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `day_id` mediumint(8) UNSIGNED NOT NULL,
  `starttime` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'min',
  `length` smallint(5) UNSIGNED NOT NULL DEFAULT '60' COMMENT 'min',
  `dleft` float NOT NULL DEFAULT '0',
  `width` float NOT NULL DEFAULT '1',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Event_dummys um Events zu Spliten';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event_responsible`
--

CREATE TABLE `event_responsible` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `who` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `main` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, wer für welche Events verantwortlich ist';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feedback`
--

CREATE TABLE `feedback` (
  `id` smallint(6) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Feedbacks ablegen';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `short_prefix` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `pid` mediumint(8) UNSIGNED DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Gruppierung / Strukturierung der Pfadi';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job`
--

CREATE TABLE `job` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `job_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `show_gp` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Jobs für jede Lager';

--
-- Daten für Tabelle `job`
--

INSERT INTO `job` (`id`, `camp_id`, `job_name`, `show_gp`, `t_edited`) VALUES
(1, 1, 'Tageschef', 1, '2017-12-31 23:00:00'),
(2, 2, 'Tageschef', 1, '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job_day`
--

CREATE TABLE `job_day` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `job_id` mediumint(8) UNSIGNED NOT NULL,
  `day_id` mediumint(8) UNSIGNED NOT NULL,
  `user_camp_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, wer welchen Job an welchem Tag machen muss';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mat_article`
--

CREATE TABLE `mat_article` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `buy_place` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Sammelliste von Einkaufsgegenständen';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mat_article_alias`
--

CREATE TABLE `mat_article_alias` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `mat_article_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mat_event`
--

CREATE TABLE `mat_event` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` mediumint(8) UNSIGNED NOT NULL,
  `user_camp_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `mat_list_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `mat_article_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `article_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `organized` tinyint(1) NOT NULL DEFAULT '0',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von zu organisierendem Material';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mat_list`
--

CREATE TABLE `mat_list` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `mat_list`
--

INSERT INTO `mat_list` (`id`, `camp_id`, `name`, `t_edited`) VALUES
(1, 1, 'Lebensmittel', '2017-12-31 23:00:00'),
(2, 1, 'Baumarkt', '2017-12-31 23:00:00'),
(3, 2, 'Lebensmittel', '2017-12-31 23:00:00'),
(4, 2, 'Baumarkt', '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `postit`
--

CREATE TABLE `postit` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `maximized` tinyint(1) DEFAULT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Speichert, wer einen Kommentar schon gesehen hat.';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pre_user`
--

CREATE TABLE `pre_user` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `function_id` smallint(5) UNSIGNED NOT NULL,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `scoutname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` smallint(5) UNSIGNED DEFAULT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `homenr` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `mobilnr` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(10) UNSIGNED DEFAULT NULL,
  `ahv` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `sex` mediumint(8) NOT NULL,
  `jspersnr` int(10) UNSIGNED DEFAULT NULL,
  `jsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `pbsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `regtime` int(10) UNSIGNED DEFAULT NULL,
  `t_edited` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von User, welche noch nicht Systemuser sind';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subcamp`
--

CREATE TABLE `subcamp` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `start` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `length` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Subcamps pro Camp';

--
-- Daten für Tabelle `subcamp`
--

INSERT INTO `subcamp` (`id`, `camp_id`, `start`, `length`, `t_edited`) VALUES
(1, 1, 6629, 8, '2017-12-31 23:00:00'),
(2, 2, 6777, 7, '2017-12-31 23:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `todo`
--

CREATE TABLE `todo` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `short` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `todo`
--

INSERT INTO `todo` (`id`, `camp_id`, `title`, `short`, `date`, `done`) VALUES
(1, 1, 'Kursanmeldung', 'Anmeldung an LKB (Picasso, Blockübersicht, Checklisten)', 6573, 0),
(2, 1, 'Detailprogramm einreichen', 'Definitives Detailprogramm an LKB.', 6615, 0),
(3, 1, 'Kursabschluss', 'TN-Liste, Kursbericht', 6657, 0),
(4, 1, 'J+S-Material/Landeskarten', 'J+S-Material und Landeskarten bestellen.', 6587, 0),
(5, 2, 'Lagerhaus/Lagerplatz reservieren', 'Das Lagerhaus/Lagerplatz definitiv reservieren.', 6537, 0),
(6, 2, 'Küchenteam suchen', 'Das Küchenteam zusammenstellen.', 6597, 0),
(7, 2, 'Picasso zusammenstellen', 'Ersten Entwurf des Picassos zusammenstellen.', 6597, 0),
(8, 2, 'PBS - Lageranmeldung', 'PBS - Lageranmeldung ausfüllen und an Coach schicken.', 6687, 0),
(9, 2, 'J&S - Materialbestellung', 'J&S - Materialbestellung ausfüllen und an Coach schicken', 6687, 0),
(10, 2, 'Landeskartenbestellung', 'Landeskartenbestellung ausfüllen und an Coach schicken', 6687, 0),
(11, 2, 'J&S - Lageranmeldung', 'Sicherstellen, dass Coach das Lager unter J&S anmeldet (online).', 6717, 0),
(12, 2, 'Spendenaufrufe verschicken', 'Spendenaufrufe an regionale Firmen verschicken.', 6717, 0),
(13, 2, 'Lageranmeldung verschicken', 'Lageranmeldung an alle TN verschicken.', 6717, 0),
(14, 2, 'Programmabgabe', 'Fertiges Programm an Coach abgeben.', 6735, 0),
(15, 2, 'Siebdruck anfertigen', 'Siebdruck / Lagerdruck anfertigen.', 6749, 0),
(16, 2, 'Regaversicherung', 'Für alle TN eine gratis - Regaversicherung abschliessen.', 6763, 0),
(17, 2, 'Letzte Infos verschicken', 'Letzte Infos für TNs verschicken', 6763, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `todo_user_camp`
--

CREATE TABLE `todo_user_camp` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_camp_id` mediumint(8) UNSIGNED NOT NULL,
  `todo_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `scoutname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` smallint(5) UNSIGNED DEFAULT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `homenr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobilnr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(5) DEFAULT NULL,
  `ahv` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `jspersnr` mediumint(9) DEFAULT NULL,
  `jsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `pbsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `last_camp` mediumint(8) NOT NULL,
  `regtime` int(10) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `acode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `image` blob,
  `news` text COLLATE utf8_unicode_ci NOT NULL,
  `copyspace` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registrierte User im System';

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `street`, `zipcode`, `city`, `homenr`, `mobilnr`, `birthday`, `ahv`, `sex`, `jspersnr`, `jsedu`, `pbsedu`, `last_camp`, `regtime`, `active`, `auth_key`, `acode`, `admin`, `image`, `news`, `copyspace`, `t_edited`) VALUES
(1, 'test@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Albis', 'Alfred', 'Alther', '', NULL, '', '', '', NULL, '', 0, NULL, '', '', 1, 0, 1, '', '00000000000000000000000000000000', 0, NULL, '', '', '2018-03-06 10:02:39'),
(2, 'test2@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Boa', 'Bettina', 'Bodmer', '', NULL, '', '', '', NULL, '', 0, NULL, '', '', 1, 0, 1, '', '00000000000000000000000000000000', 0, NULL, '', '', '2018-03-06 10:02:39'),
(3, 'test3@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Chnuschti', 'Christoph', 'Carozzi', '', NULL, '', '', '', NULL, '', 0, NULL, '', '', 1, 0, 1, '', '00000000000000000000000000000000', 0, NULL, '', '', '2018-03-06 10:02:39'),
(4, 'test4@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Dorie', 'Diana', 'Dillier', '', NULL, '', '', '', NULL, '', 0, NULL, '', '', 2, 0, 1, '', '00000000000000000000000000000000', 0, NULL, '', '', '2018-03-06 10:02:39'),
(5, 'test5@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Echo', 'Egon', 'Engelberger', '', NULL, '', '', '', NULL, '', 0, NULL, '', '', 2, 0, 1, '', '00000000000000000000000000000000', 0, NULL, '', '', '2018-03-06 10:02:39');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_camp`
--

CREATE TABLE `user_camp` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `camp_id` mediumint(8) UNSIGNED NOT NULL,
  `function_id` smallint(3) UNSIGNED NOT NULL,
  `invitation_id` mediumint(8) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, welche User zu welchen Camps zugang haben';

--
-- Daten für Tabelle `user_camp`
--

INSERT INTO `user_camp` (`id`, `user_id`, `camp_id`, `function_id`, `invitation_id`, `active`, `t_edited`) VALUES
(1, 1, 1, 48, 0, 1, '2017-12-31 23:00:00'),
(2, 2, 1, 49, 1, 1, '2017-12-31 23:00:00'),
(3, 3, 1, 50, 1, 1, '2017-12-31 23:00:00'),
(4, 1, 2, 1, 0, 1, '2017-12-31 23:00:00'),
(5, 4, 2, 46, 1, 1, '2017-12-31 23:00:00'),
(6, 5, 2, 2, 1, 1, '2017-12-31 23:00:00'),
(7, 3, 2, 3, 1, 1, '2017-12-31 23:00:00');


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session_data`
--

CREATE TABLE `session_data` (
  `session_id` varchar(32) NOT NULL default '',
  `hash` varchar(32) NOT NULL default '',
  `session_data` blob NOT NULL,
  `session_expire` int(11) NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_all_days`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_all_days` (
`camp_id` mediumint(8) unsigned
,`id` mediumint(8) unsigned
,`subcamp_id` mediumint(8) unsigned
,`day_offset` smallint(5) unsigned
,`story` text
,`notes` text
,`t_edited` timestamp
,`start` int(8) unsigned
,`daynr` bigint(22)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_event_nr`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_event_nr` (
`event_id` mediumint(8) unsigned
,`event_instance_id` mediumint(8) unsigned
,`day_nr` decimal(27,0)
,`event_nr` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur des Views `v_all_days`
--
DROP TABLE IF EXISTS `v_all_days`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_all_days`  AS  select `camp`.`id` AS `camp_id`,`day`.`id` AS `id`,`day`.`subcamp_id` AS `subcamp_id`,`day`.`day_offset` AS `day_offset`,`day`.`story` AS `story`,`day`.`notes` AS `notes`,`day`.`t_edited` AS `t_edited`,`subcamp`.`start` AS `start`,((select count(0) AS `count(*)` from (`day` `sday` join `subcamp` `ssubcamp`) where (((`ssubcamp`.`start` + `sday`.`day_offset`) < (`subcamp`.`start` + `day`.`day_offset`)) and (`ssubcamp`.`id` = `sday`.`subcamp_id`) and (`ssubcamp`.`camp_id` = `subcamp`.`camp_id`))) + 1) AS `daynr` from ((`camp` join `subcamp`) join `day`) where ((`subcamp`.`camp_id` = `camp`.`id`) and (`day`.`subcamp_id` = `subcamp`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_event_nr`
--
DROP TABLE IF EXISTS `v_event_nr`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_event_nr`  AS  select `event`.`id` AS `event_id`,`event_instance`.`id` AS `event_instance_id`,(((select ifnull(sum(`sub_subcamp`.`length`),0) AS `IFNULL( sum( sub_subcamp.length ), 0)` from `subcamp` `sub_subcamp` where ((`subcamp`.`camp_id` = `sub_subcamp`.`camp_id`) and (`subcamp`.`start` > `sub_subcamp`.`start`))) + `day`.`day_offset`) + 1) AS `day_nr`,(select count(`event_instance_down`.`id`) AS `count(event_instance_down.id)` from (((`event_instance` `event_instance_up` join `event_instance` `event_instance_down`) join `event`) join `category`) where ((`event_instance_up`.`id` = `event_instance`.`id`) and (`event_instance_up`.`day_id` = `event_instance_down`.`day_id`) and (`event_instance_down`.`event_id` = `event`.`id`) and (`event`.`category_id` = `category`.`id`) and (`category`.`form_type` > 0) and ((`event_instance_down`.`starttime` < `event_instance_up`.`starttime`) or ((`event_instance_down`.`starttime` = `event_instance_up`.`starttime`) and ((`event_instance_down`.`dleft` < `event_instance_up`.`dleft`) or ((`event_instance_down`.`dleft` = `event_instance_up`.`dleft`) and (`event_instance_down`.`id` <= `event_instance_up`.`id`))))))) AS `event_nr` from (((`event_instance` join `event`) join `day`) join `subcamp`) where ((`event`.`id` = `event_instance`.`event_id`) and (`event_instance`.`day_id` = `day`.`id`) and (`day`.`subcamp_id` = `subcamp`.`id`)) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `camp`
--
ALTER TABLE `camp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_userid` (`creator_user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camp` (`camp_id`);

--
-- Indizes für die Tabelle `course_aim`
--
ALTER TABLE `course_aim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `camp_id` (`camp_id`);

--
-- Indizes für die Tabelle `course_checklist`
--
ALTER TABLE `course_checklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indizes für die Tabelle `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique day offset` (`subcamp_id`,`day_offset`),
  ADD KEY `subcamp_id` (`subcamp_id`),
  ADD KEY `day_offset` (`day_offset`);

--
-- Indizes für die Tabelle `dropdown`
--
ALTER TABLE `dropdown`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `camp_id` (`camp_id`);

--
-- Indizes für die Tabelle `event_aim`
--
ALTER TABLE `event_aim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_id` (`aim_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indizes für die Tabelle `event_checklist`
--
ALTER TABLE `event_checklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_id` (`checklist_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indizes für die Tabelle `event_comment`
--
ALTER TABLE `event_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event` (`event_id`);

--
-- Indizes für die Tabelle `event_detail`
--
ALTER TABLE `event_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prev_id_2` (`prev_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indizes für die Tabelle `event_document`
--
ALTER TABLE `event_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `event_instance`
--
ALTER TABLE `event_instance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indizes für die Tabelle `event_responsible`
--
ALTER TABLE `event_responsible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indizes für die Tabelle `feedback`
--
ALTER TABLE `feedback`
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`pid`),
  ADD KEY `active` (`active`);

--
-- Indizes für die Tabelle `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camp` (`camp_id`);

--
-- Indizes für die Tabelle `job_day`
--
ALTER TABLE `job_day`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_day` (`job_id`,`day_id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_camp_id` (`user_camp_id`);

--
-- Indizes für die Tabelle `mat_article`
--
ALTER TABLE `mat_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indizes für die Tabelle `mat_article_alias`
--
ALTER TABLE `mat_article_alias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mat_article_id` (`mat_article_id`);

--
-- Indizes für die Tabelle `mat_event`
--
ALTER TABLE `mat_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_camp_id`),
  ADD KEY `mat_list_id` (`mat_list_id`),
  ADD KEY `mat_article_id` (`mat_article_id`);

--
-- Indizes für die Tabelle `mat_list`
--
ALTER TABLE `mat_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camp_id` (`camp_id`);

--
-- Indizes für die Tabelle `postit`
--
ALTER TABLE `postit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `pre_user`
--
ALTER TABLE `pre_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Mail` (`mail`),
  ADD KEY `camp_id` (`camp_id`),
  ADD KEY `function_id` (`function_id`);

--
-- Indizes für die Tabelle `subcamp`
--
ALTER TABLE `subcamp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camp_id` (`camp_id`);

--
-- Indizes für die Tabelle `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camp_id` (`camp_id`);

--
-- Indizes für die Tabelle `todo_user_camp`
--
ALTER TABLE `todo_user_camp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_camp_id` (`user_camp_id`),
  ADD KEY `todo_id` (`todo_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Mail` (`mail`);

--
-- Indizes für die Tabelle `user_camp`
--
ALTER TABLE `user_camp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `camp_id` (`camp_id`),
  ADD KEY `invitation_id` (`invitation_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `camp`
--
ALTER TABLE `camp`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `course_aim`
--
ALTER TABLE `course_aim`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `course_checklist`
--
ALTER TABLE `course_checklist`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `course_type`
--
ALTER TABLE `course_type`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `day`
--
ALTER TABLE `day`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `dropdown`
--
ALTER TABLE `dropdown`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT für Tabelle `event`
--
ALTER TABLE `event`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_aim`
--
ALTER TABLE `event_aim`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_checklist`
--
ALTER TABLE `event_checklist`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_comment`
--
ALTER TABLE `event_comment`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_detail`
--
ALTER TABLE `event_detail`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_document`
--
ALTER TABLE `event_document`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_instance`
--
ALTER TABLE `event_instance`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `event_responsible`
--
ALTER TABLE `event_responsible`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `job`
--
ALTER TABLE `job`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `job_day`
--
ALTER TABLE `job_day`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `mat_article`
--
ALTER TABLE `mat_article`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `mat_article_alias`
--
ALTER TABLE `mat_article_alias`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `mat_event`
--
ALTER TABLE `mat_event`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `mat_list`
--
ALTER TABLE `mat_list`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `pre_user`
--
ALTER TABLE `pre_user`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `subcamp`
--
ALTER TABLE `subcamp`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `todo`
--
ALTER TABLE `todo`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `todo_user_camp`
--
ALTER TABLE `todo_user_camp`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `user_camp`
--
ALTER TABLE `user_camp`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `camp`
--
ALTER TABLE `camp`
  ADD CONSTRAINT `camp_ibfk_1` FOREIGN KEY (`creator_user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `course_aim`
--
ALTER TABLE `course_aim`
  ADD CONSTRAINT `course_aim_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `course_aim` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_aim_ibfk_2` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `course_checklist`
--
ALTER TABLE `course_checklist`
  ADD CONSTRAINT `course_checklist_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `course_checklist` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `day`
--
ALTER TABLE `day`
  ADD CONSTRAINT `day_ibfk_1` FOREIGN KEY (`subcamp_id`) REFERENCES `subcamp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_aim`
--
ALTER TABLE `event_aim`
  ADD CONSTRAINT `event_aim_ibfk_1` FOREIGN KEY (`aim_id`) REFERENCES `course_aim` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_aim_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_checklist`
--
ALTER TABLE `event_checklist`
  ADD CONSTRAINT `event_checklist_ibfk_1` FOREIGN KEY (`checklist_id`) REFERENCES `course_checklist` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_checklist_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_comment`
--
ALTER TABLE `event_comment`
  ADD CONSTRAINT `event_comment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_detail`
--
ALTER TABLE `event_detail`
  ADD CONSTRAINT `event_detail_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_detail_ibfk_3` FOREIGN KEY (`prev_id`) REFERENCES `event_detail` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_document`
--
ALTER TABLE `event_document`
  ADD CONSTRAINT `event_document_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_instance`
--
ALTER TABLE `event_instance`
  ADD CONSTRAINT `event_instance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_instance_ibfk_2` FOREIGN KEY (`day_id`) REFERENCES `day` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `event_responsible`
--
ALTER TABLE `event_responsible`
  ADD CONSTRAINT `event_responsible_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_responsible_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `job_day`
--
ALTER TABLE `job_day`
  ADD CONSTRAINT `job_day_ibfk_5` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_day_ibfk_6` FOREIGN KEY (`day_id`) REFERENCES `day` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_day_ibfk_7` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `mat_article_alias`
--
ALTER TABLE `mat_article_alias`
  ADD CONSTRAINT `mat_article_alias_ibfk_1` FOREIGN KEY (`mat_article_id`) REFERENCES `mat_article` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `mat_event`
--
ALTER TABLE `mat_event`
  ADD CONSTRAINT `mat_event_ibfk_23` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mat_event_ibfk_24` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mat_event_ibfk_25` FOREIGN KEY (`mat_list_id`) REFERENCES `mat_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mat_event_ibfk_26` FOREIGN KEY (`mat_article_id`) REFERENCES `mat_article` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `mat_list`
--
ALTER TABLE `mat_list`
  ADD CONSTRAINT `mat_list_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `postit`
--
ALTER TABLE `postit`
  ADD CONSTRAINT `postit_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `pre_user`
--
ALTER TABLE `pre_user`
  ADD CONSTRAINT `pre_user_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `subcamp`
--
ALTER TABLE `subcamp`
  ADD CONSTRAINT `subcamp_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `todo_user_camp`
--
ALTER TABLE `todo_user_camp`
  ADD CONSTRAINT `todo_user_camp_ibfk_1` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `todo_user_camp_ibfk_2` FOREIGN KEY (`todo_id`) REFERENCES `todo` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `user_camp`
--
ALTER TABLE `user_camp`
  ADD CONSTRAINT `user_camp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_camp_ibfk_2` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
