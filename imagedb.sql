-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2016 um 22:38
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

--
-- Daten für Tabelle `galleries`
--

INSERT INTO `galleries` (`id`, `name`, `is_shared`, `fk_user_id`) VALUES
(1, 'Jake - Galerie (Shared)', 1, 13),
(2, 'Jake - Galerie 2', 1, 13),
(5, 'Awesome TEST', 1, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` int(11) UNSIGNED NOT NULL,
  `image_path` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail_path` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `filetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fk_gallery_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id`, `image_path`, `thumbnail_path`, `size`, `filetype`, `fk_gallery_id`) VALUES
(12, 'upload/images/full_573b6b083e736.jpg', 'upload/images/thumb_573b6b083e736.jpg', 0, '', 3),
(13, 'upload/images/full_573b6b0866bde.jpg', 'upload/images/thumb_573b6b0866bde.jpg', 0, '', 3),
(14, 'upload/images/full_573b6b8e4ea8d.jpg', 'upload/images/thumb_573b6b8e4ea8d.jpg', 0, '', 4),
(15, 'upload/images/full_573b6b8eb9650.jpg', 'upload/images/thumb_573b6b8eb9650.jpg', 0, '', 4),
(16, 'upload/images/full_573b6b8f081e3.jpg', 'upload/images/thumb_573b6b8f081e3.jpg', 0, '', 4),
(17, 'upload/images/full_573b6b8f4335f.jpg', 'upload/images/thumb_573b6b8f4335f.jpg', 0, '', 4),
(18, 'upload/images/full_573b6b8f90677.jpg', 'upload/images/thumb_573b6b8f90677.jpg', 0, '', 4),
(19, 'upload/images/full_573b6b8fe4e77.jpg', 'upload/images/thumb_573b6b8fe4e77.jpg', 0, '', 4),
(20, 'upload/images/full_573b7429bb5ea.jpg', 'upload/images/thumb_573b7429bb5ea.jpg', 0, '', 6),
(21, 'upload/images/full_573b7429d384c.jpg', 'upload/images/thumb_573b7429d384c.jpg', 0, '', 6),
(22, 'upload/images/full_573b7429f2048.jpg', 'upload/images/thumb_573b7429f2048.jpg', 0, '', 6),
(23, 'upload/images/full_573b742a267a9.jpg', 'upload/images/thumb_573b742a267a9.jpg', 0, '', 6),
(24, 'upload/images/full_573b742a6283e.jpg', 'upload/images/thumb_573b742a6283e.jpg', 0, '', 6),
(25, 'upload/images/full_573b742a90ac6.jpg', 'upload/images/thumb_573b742a90ac6.jpg', 0, '', 6),
(26, 'upload/images/full_573e13f9680a1.jpg', 'upload/images/thumb_573e13f9680a1.jpg', 0, '', 7),
(27, 'upload/images/full_573e13f9899df.jpg', 'upload/images/thumb_573e13f9899df.jpg', 0, '', 7),
(28, 'upload/images/full_573e13f9a547c.jpg', 'upload/images/thumb_573e13f9a547c.jpg', 0, '', 7),
(29, 'upload/images/full_573e13f9c3b63.jpg', 'upload/images/thumb_573e13f9c3b63.jpg', 0, '', 7),
(30, 'upload/images/full_573e13fa06358.jpg', 'upload/images/thumb_573e13fa06358.jpg', 0, '', 7),
(31, 'upload/images/full_573e13fa28a32.jpg', 'upload/images/thumb_573e13fa28a32.jpg', 0, '', 7),
(32, 'upload/images/full_573e1551f2193.jpg', 'upload/images/thumb_573e1551f2193.jpg', 0, '', 8),
(33, 'upload/images/full_573e155216142.jpg', 'upload/images/thumb_573e155216142.jpg', 0, '', 8),
(34, 'upload/images/full_573e1552320f0.jpg', 'upload/images/thumb_573e1552320f0.jpg', 0, '', 8),
(35, 'upload/images/full_573e155248f88.jpg', 'upload/images/thumb_573e155248f88.jpg', 0, '', 8),
(36, 'upload/images/full_573e1552655d2.jpg', 'upload/images/thumb_573e1552655d2.jpg', 0, '', 8),
(37, 'upload/images/full_573e15528167a.jpg', 'upload/images/thumb_573e15528167a.jpg', 0, '', 8),
(44, 'upload/images/full_573f3fd9f36b3.jpg', 'upload/images/thumb_573f3fd9f36b3.jpg', 0, '', 2),
(45, 'upload/images/full_573f3fda1d0aa.jpg', 'upload/images/thumb_573f3fda1d0aa.jpg', 0, '', 2),
(46, 'upload/images/full_573f3fda3b39a.jpg', 'upload/images/thumb_573f3fda3b39a.jpg', 0, '', 2),
(47, 'upload/images/full_573f3fda513b8.jpg', 'upload/images/thumb_573f3fda513b8.jpg', 0, '', 2),
(48, 'upload/images/full_573f3fda6c12e.jpg', 'upload/images/thumb_573f3fda6c12e.jpg', 0, '', 2),
(49, 'upload/images/full_573f3fda86aa8.jpg', 'upload/images/thumb_573f3fda86aa8.jpg', 0, '', 2),
(57, 'upload/images/full_573f50f82dbf4.jpg', 'upload/images/thumb_573f50f82dbf4.jpg', 0, '', 5),
(59, 'upload/images/full_573f50f8644f1.jpg', 'upload/images/thumb_573f50f8644f1.jpg', 0, '', 5),
(61, 'upload/images/full_573f50f89b95c.jpg', 'upload/images/thumb_573f50f89b95c.jpg', 0, '', 5),
(62, 'upload/images/full_573f5936648b0.jpg', 'upload/images/thumb_573f5936648b0.jpg', 0, '', 5),
(63, 'upload/images/full_573f5a2919dad.jpg', 'upload/images/thumb_573f5a2919dad.jpg', 171694, '.jpg', 5),
(64, 'upload/images/full_573f5a293a61b.jpg', 'upload/images/thumb_573f5a293a61b.jpg', 744239, '.jpg', 5),
(65, 'upload/images/full_573f5a295f8cd.jpg', 'upload/images/thumb_573f5a295f8cd.jpg', 661659, '.jpg', 5),
(66, 'upload/images/full_573f5a297bbf7.jpg', 'upload/images/thumb_573f5a297bbf7.jpg', 389903, '.jpg', 5),
(67, 'upload/images/full_573f5a29a2646.jpg', 'upload/images/thumb_573f5a29a2646.jpg', 341146, '.jpg', 5),
(68, 'upload/images/full_573f5a29c96bd.jpg', 'upload/images/thumb_573f5a29c96bd.jpg', 201741, '.jpg', 5),
(69, 'upload/images/full_573f5adba75af.jpg', 'upload/images/thumb_573f5adba75af.jpg', 171694, '.jpg', 5),
(70, 'upload/images/full_573f5adbe262d.jpg', 'upload/images/thumb_573f5adbe262d.jpg', 744239, '.jpg', 5),
(71, 'upload/images/full_573f5adc1aed5.jpg', 'upload/images/thumb_573f5adc1aed5.jpg', 661659, '.jpg', 5),
(72, 'upload/images/full_573f5adc62bfd.jpg', 'upload/images/thumb_573f5adc62bfd.jpg', 389903, '.jpg', 5),
(73, 'upload/images/full_573f5adcd007c.jpg', 'upload/images/thumb_573f5adcd007c.jpg', 341146, '.jpg', 5),
(74, 'upload/images/full_573f5add045c9.jpg', 'upload/images/thumb_573f5add045c9.jpg', 201741, '.jpg', 5),
(75, 'upload/images/full_573f5de642823.png', 'upload/images/thumb_573f5de642823.png', 613392, '.png', 5),
(76, 'upload/images/full_573f5eb6b29e0.jpg', 'upload/images/thumb_573f5eb6b29e0.jpg', 5584535, '.jpg', 5);

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

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'Art'),
(2, 'Nature'),
(3, 'Abstract'),
(4, 'Cars'),
(5, 'Fantasy'),
(6, 'Animals');

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
(1, 'severin.kaderli@gmail.com', '$2y$10$AsBeGVsL96koosMIQFvNpOqDzE3l6xOEYJccYKrkpQYBRHQ/6MPRG', 1),
(11, 'man@mail.com', '', 1),
(12, 'woman@mail.com', '$2y$10$UIEhud1jOq5ln7SlzmGa0.AKI8EKkL4ulwjqZ6ruymR6koep3O7Wu', 1),
(13, 'jake@gmail.com', '$2y$10$wtBRzSFCJCarmiuGYQF46O8wEFOtMXx/qdU/Z/awRI.Yuv4hLq9m.', 0),
(14, 'severin@gmail.com', '$2y$10$dnge3CZEAA9FPneJUJ86Euhs8jarIAs/274yyvyxTSgtvaDhMeoi.', 0);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT für Tabelle `images_tags`
--
ALTER TABLE `images_tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
