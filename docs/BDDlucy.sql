-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 28 Août 2020 à 08:56
-- Version du serveur :  5.7.31-0ubuntu0.18.04.1
-- Version de PHP :  7.2.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `BDDlucy`
--

-- --------------------------------------------------------

--
-- Structure de la table `assoc`
--

CREATE TABLE `assoc` (
  `ID_assoc` int(11) NOT NULL,
  `ID_item` int(11) NOT NULL,
  `ID_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `assoc`
--

INSERT INTO `assoc` (`ID_assoc`, `ID_item`, `ID_tag`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `ID_item` int(11) NOT NULL,
  `ID_room` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`ID_item`, `ID_room`, `content`, `date`) VALUES
(1, 1, 'wow trop bien !!', '2020-08-27 10:42:00'),
(4, 1, 'coucou', '2020-08-27 14:03:39'),
(5, 3, 'simon noooooon ne fais pas ça mécréant \r\n#please #pitié #tacos', '2020-08-27 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

CREATE TABLE `room` (
  `ID_room` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `room`
--

INSERT INTO `room` (`ID_room`, `name`, `password`) VALUES
(1, 'rom test', '$2y$10$Hyq3N4AmgnQZlVy6wwmRSu4LUYdP8kHDX5cpzeg9aziDGlLZa2lrC'),
(2, 'testenumero2', '$2y$10$oR.u0HCT/6K7OGtzlhpv.exDSPFKsx2b0ZGmv5Er7loR1aEDrLTIS'),
(3, 'loic', '$2y$10$XIniYplFb.Cq735SJ9S7ReCQYqq.nHHo./NLaBraC1bHuokX/aa9G');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `ID_tag` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `tag`
--

INSERT INTO `tag` (`ID_tag`, `tag_name`) VALUES
(1, '#youtube'),
(2, '#twitch');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `assoc`
--
ALTER TABLE `assoc`
  ADD PRIMARY KEY (`ID_assoc`),
  ADD KEY `ID_item` (`ID_item`),
  ADD KEY `ID_tag` (`ID_tag`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID_item`),
  ADD KEY `ID_room` (`ID_room`),
  ADD KEY `ID_room_2` (`ID_room`);

--
-- Index pour la table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`ID_room`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`ID_tag`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `assoc`
--
ALTER TABLE `assoc`
  MODIFY `ID_assoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `ID_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `room`
--
ALTER TABLE `room`
  MODIFY `ID_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `ID_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `assoc`
--
ALTER TABLE `assoc`
  ADD CONSTRAINT `item_tag` FOREIGN KEY (`ID_item`) REFERENCES `item` (`ID_item`),
  ADD CONSTRAINT `tag_item` FOREIGN KEY (`ID_tag`) REFERENCES `tag` (`ID_tag`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `room` FOREIGN KEY (`ID_room`) REFERENCES `room` (`ID_room`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
