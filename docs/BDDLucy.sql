-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 02 sep. 2020 à 13:20
-- Version du serveur :  5.7.31-0ubuntu0.18.04.1
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `BDDLucy`
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
-- Déchargement des données de la table `assoc`
--

INSERT INTO `assoc` (`ID_assoc`, `ID_item`, `ID_tag`) VALUES
(9, 23, 7),
(10, 24, 8),
(11, 27, 5),
(13, 30, 5),
(25, 40, 15),
(26, 40, 16),
(27, 41, 16),
(28, 41, 17),
(29, 42, 18),
(30, 43, 19),
(31, 44, 20);

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
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`ID_item`, `ID_room`, `content`, `date`) VALUES
(23, 15, 'Mdrrrrrr #mdr', '2020-08-31 15:42:59'),
(24, 15, 'Aled #aled', '2020-08-31 15:48:34'),
(25, 15, 'loïc', '2020-08-31 16:19:15'),
(26, 15, 'évite ça ', '2020-08-31 16:19:28'),
(27, 15, 'évite lol #lol', '2020-08-31 16:19:37'),
(29, 15, 'évite àa \"lol\"', '2020-08-31 16:20:53'),
(30, 15, 'évite ça \"mdr\" \'lol\' #lol', '2020-08-31 16:21:06'),
(40, 19, 'Note one #first #note', '2020-09-02 10:44:39'),
(41, 19, 'Note two #note #second', '2020-09-02 10:44:59'),
(42, 19, 'My adresse : .... #adress', '2020-09-02 10:45:11'),
(43, 19, 'Today i cook .... #cook', '2020-09-02 10:45:27'),
(44, 19, 'So sad about ... #sad', '2020-09-02 10:45:52');

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
-- Déchargement des données de la table `room`
--

INSERT INTO `room` (`ID_room`, `name`, `password`) VALUES
(15, 'room_1', '$2y$10$veGZF7JdXMr1DnpXDfJxJ.E47c.jXvcbwj9BiGLYUfgQSYtsGgATG'),
(18, 'room_loic', '$2y$10$1yLTsbF1/O.6k0.Vef/BguoYISirY6JveuS.8JVigjfgZ.GgAFMxe'),
(19, 'room_test_loïc', '$2y$10$5zF7bwei8mLoc1qujUJXuucuJ71n97M69f9nTBmZlkEyjedc95Kxm'),
(20, 'room_test_kevin', '$2y$10$DR3lwzMlW4OfXasT5jTTauJ8jZdDRROM/.iv4c4pRQ5Jf7ERRy1u.');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `ID_tag` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`ID_tag`, `tag_name`) VALUES
(5, 'lol'),
(6, 'xd'),
(7, 'mdr'),
(8, 'aled'),
(9, 'test'),
(10, 'oll'),
(11, 'new'),
(12, 'hast1'),
(13, 'hast2'),
(14, 'hast3'),
(15, 'first'),
(16, 'note'),
(17, 'second'),
(18, 'adress'),
(19, 'cook'),
(20, 'sad');

--
-- Index pour les tables déchargées
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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `assoc`
--
ALTER TABLE `assoc`
  MODIFY `ID_assoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `ID_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `room`
--
ALTER TABLE `room`
  MODIFY `ID_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `ID_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assoc`
--
ALTER TABLE `assoc`
  ADD CONSTRAINT `item_tag` FOREIGN KEY (`ID_item`) REFERENCES `item` (`ID_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_item` FOREIGN KEY (`ID_tag`) REFERENCES `tag` (`ID_tag`) ON DELETE NO ACTION;

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `room` FOREIGN KEY (`ID_room`) REFERENCES `room` (`ID_room`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
