-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Mai 2016 um 09:23
-- Server-Version: 10.1.9-MariaDB
-- PHP-Version: 7.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `imagedb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_shared` tinyint(1) UNSIGNED NOT NULL,
  `fk_user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` int(11) UNSIGNED NOT NULL,
  `image_path` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_path` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `fk_gallery_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images_tags`
--

CREATE TABLE `images_tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `fk_image_id` int(10) UNSIGNED NOT NULL,
  `fk_tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(1, 'severin.kaderli@gmail.com', '$2y$10$AsBeGVsL96koosMIQFvNpOqDzE3l6xOEYJccYKrkpQYBRHQ/6MPRG', 0),
(2, 'test@test.com', '$2y$10$Ufihms8wiPTj.PjTnAdteus4IAjgfV4PgizvyLs6UPPYs0avnv2Ie', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `images_tags`
--
ALTER TABLE `images_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `images_tags`
--
ALTER TABLE `images_tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
