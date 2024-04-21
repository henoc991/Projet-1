-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 avr. 2024 à 10:41
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

""
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsn`
--
CREATE DATABASE gsn
USE gsn
-- --------------------------------------------------------

--
-- Structure de la table `enfant`
--

CREATE TABLE `enfant` (
  `id_enfant` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `Id_user` int(11) DEFAULT NULL,
  `age` int(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nounou`
--

CREATE TABLE `nounou` (
  `id_nounou` int(11) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Id_enfant` int(11) DEFAULT NULL,
  `Id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nounou`
--

INSERT INTO `nounou` (`id_nounou`, `Nom`, `Prenom`, `Numero`, `Email`, `Id_enfant`, `Id_user`) VALUES
(1, 'menard', 'jade', '0140085612', 'menar.jade@example.com', NULL, NULL),
(4, 'leonard', 'annie', '0733245675', 'annie.leonard@gmail.com', NULL, NULL),
(5, 'curry', 'ayesha', ' 059055677', 'ayesha.curry@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `Id_user` int(11) DEFAULT NULL,
  `Id_nounou` int(11) DEFAULT NULL,
  `Date_reservation` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `type` enum('user','admin') DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `email`, `numero`, `type`, `mot_de_passe`) VALUES
(1, '', '', 'admin@gmail.com', '', 'admin', 'password'),
(2, 'ambehm', 'salomon', 'salomonambehm@gmail.com', '', 'user', 'villa532');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `enfant`
--
ALTER TABLE `enfant`
  ADD PRIMARY KEY (`id_enfant`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Index pour la table `nounou`
--
ALTER TABLE `nounou`
  ADD PRIMARY KEY (`id_nounou`),
  ADD KEY `Id_enfant` (`Id_enfant`),
  ADD KEY `Id_user` (`Id_user`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `Id_user` (`Id_user`),
  ADD KEY `Id_nounou` (`Id_nounou`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `enfant`
--
ALTER TABLE `enfant`
  MODIFY `id_enfant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `nounou`
--
ALTER TABLE `nounou`
  MODIFY `id_nounou` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `enfant`
--
ALTER TABLE `enfant`
  ADD CONSTRAINT `enfant_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `nounou`
--
ALTER TABLE `nounou`
  ADD CONSTRAINT `nounou_ibfk_1` FOREIGN KEY (`Id_enfant`) REFERENCES `enfant` (`id_enfant`),
  ADD CONSTRAINT `nounou_ibfk_2` FOREIGN KEY (`Id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Id_user`) REFERENCES `utilisateur` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Id_nounou`) REFERENCES `nounou` (`id_nounou`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
