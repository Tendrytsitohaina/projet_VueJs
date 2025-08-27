-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 28 août 2025 à 00:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `locationvoiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `numloc` varchar(50) NOT NULL,
  `nom_loc` varchar(50) NOT NULL,
  `design_voiture` varchar(50) NOT NULL,
  `nbr_jour` int(11) NOT NULL,
  `taux_jour` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`numloc`, `nom_loc`, `design_voiture`, `nbr_jour`, `taux_jour`) VALUES
('1', 'BOZY', '1234TBA', 12, 34000),
('10', 'IZY', '3421TBA ', 11, 30000),
('2', 'Bako', '5453TBA', 34, 23000),
('90', 'tendry', '1002TBA', 21, 54000);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `codeCli` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`codeCli`, `username`, `password`) VALUES
(5, 'tendry', '$2y$10$2SyGtV5muM.os.ImqkVUUedi8wQYHsxlaeyCo8oUkV/w2t80I9O5G'),
(6, 'tendry2', '$2y$10$m6Gtl0N9MPDB4sPiKJpY1.NqnITVO8v/J/Po0HMSU1dsyliG.C5HK'),
(7, 'Tsitohaina', '$2y$10$u8tdBeL27xZnzVQCP8a3kezSVmpiIt8auuLB/8fCwb/22QVs/kpKS'),
(8, 'tsito', '$2y$10$9ZG2ScBTOFNUS7Ug.yvjH.yo9FjWsJtQsI1hUqpOGxj4BpQzjauES'),
(9, 'test', '$2y$10$LVzYpnwj3xpkUb4qwQBAJOetaUjiQVbssJNcEPg8MUjKylblE1d6a');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`numloc`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`codeCli`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `codeCli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
