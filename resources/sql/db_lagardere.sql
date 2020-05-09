-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 30 avr. 2020 à 21:59
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_lagardere`
--

-- --------------------------------------------------------

--
-- Structure de la table `bilan`
--

CREATE TABLE `bilan` (
  `IdBilan` int(11) NOT NULL,
  `TitreBilan` varchar(100) NOT NULL,
  `DescriptionBil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `bilan`
--

INSERT INTO `bilan` (`IdBilan`, `TitreBilan`, `DescriptionBil`) VALUES
(1, 'Bilan Marketing 2018', 'Bilan Marketing 2018'),
(2, 'Bilan Marketing 2019', 'Bilan Marketing 2019'),
(3, 'Bilan Finance 2019', 'Bilan Finance 2019');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `IdRap` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `DateCom` datetime NOT NULL,
  `ContenuCom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`IdRap`, `IdUser`, `DateCom`, `ContenuCom`) VALUES
(1, 1, '2020-03-01 13:50:55', 'Commentaire_création_rapport1'),
(1, 3, '2020-03-01 16:50:26', 'Commentaire_edition_rapport1'),
(2, 1, '2019-03-31 10:30:11', 'Commentaire_création_rapport2'),
(2, 1, '2019-03-31 14:10:42', 'Commentaire_validation_rapport2'),
(2, 1, '2019-03-31 14:15:45', 'Commentaire_cloture_rapport2'),
(2, 2, '2019-03-31 14:00:34', 'Commentaire_soumis_rapport2'),
(2, 3, '2019-03-31 13:50:28', 'Commentaire_edition_rapport2'),
(3, 1, '2020-03-03 11:30:45', 'Commentaire_création_rapport3'),
(3, 2, '2020-03-01 13:20:19', 'Commentaire_soumis_rapport3'),
(3, 4, '2020-03-01 13:10:11', 'Commentaire_edition_rapport3');

-- --------------------------------------------------------

--
-- Structure de la table `comporter`
--

CREATE TABLE `comporter` (
  `IdRap` int(11) NOT NULL,
  `IdInd` int(11) NOT NULL,
  `Analyse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comporter`
--

INSERT INTO `comporter` (`IdRap`, `IdInd`, `Analyse`) VALUES
(1, 1, 'Analyse1'),
(1, 2, 'Analyse2'),
(2, 3, 'Analyse3'),
(3, 4, 'Analyse4'),
(3, 5, 'Analyse5'),
(3, 6, 'Analyse6');

-- --------------------------------------------------------

--
-- Structure de la table `constituer`
--

CREATE TABLE `constituer` (
  `IdBilan` int(11) NOT NULL,
  `IdRap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `constituer`
--

INSERT INTO `constituer` (`IdBilan`, `IdRap`) VALUES
(1, 2),
(2, 1),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `demanderapport`
--

CREATE TABLE `demanderapport` (
  `IdDem` int(11) NOT NULL,
  `ContenuDem` varchar(255) NOT NULL,
  `DestinationDem` varchar(50) NOT NULL,
  `EtatDem` varchar(30) NOT NULL,
  `IdUser` int(11) NOT NULL
) ;

--
-- Déchargement des données de la table `demanderapport`
--

INSERT INTO `demanderapport` (`IdDem`, `ContenuDem`, `DestinationDem`, `EtatDem`, `IdUser`) VALUES
(1, 'Analyse du marché en 2019', 'Service Marketing', 'traitée', 1),
(2, 'Analyse du marché en 2018', 'Service Marketing', 'traitée', 2),
(3, 'Analyse financière en 2019', 'Service Financier', 'traitée', 1);

-- --------------------------------------------------------

--
-- Structure de la table `indicateur`
--

CREATE TABLE `indicateur` (
  `IdInd` int(11) NOT NULL,
  `LibelleInd` varchar(100) NOT NULL,
  `IdType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `indicateur`
--

INSERT INTO `indicateur` (`IdInd`, `LibelleInd`, `IdType`) VALUES
(1, 'Nombre d\'abonnements par année', 1),
(2, 'Nombre d\'abonnements par type de publication', 1),
(3, 'Nombre de pays diffusant chaque publication', 1),
(4, 'Prix maximum et prix minimum de vente par publication', 2),
(5, 'Montant des abonnements par type de publication', 2),
(6, 'Montant dépensé par publication', 2);

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

CREATE TABLE `rapport` (
  `IdRap` int(11) NOT NULL,
  `TitreRap` varchar(100) NOT NULL,
  `DateCreation` date NOT NULL,
  `EtatRap` varchar(30) NOT NULL,
  `SyntheseRap` varchar(255) DEFAULT NULL,
  `IdType` int(11) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `rapport`
--

INSERT INTO `rapport` (`IdRap`, `TitreRap`, `DateCreation`, `EtatRap`, `SyntheseRap`, `IdType`) VALUES
(1, 'Rapport_Analyse Maketing en 2019', '2020-03-01', 'soumis', 'Synthese1', 1),
(2, 'Rapport_Analyse Maketing en 2018', '2019-03-31', 'cloturer', 'Synthese2', 1),
(3, 'Rapport_Analyse financière en 2019', '2020-03-03', 'soumis', 'Synthese3', 2);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `IdType` int(11) NOT NULL,
  `NomType` varchar(50) NOT NULL
) ;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`IdType`, `NomType`) VALUES
(1, 'Marketing'),
(2, 'Financier');

-- --------------------------------------------------------

--
-- Structure de la table `typeuser`
--

CREATE TABLE `typeuser` (
  `IdTypeUser` int(11) NOT NULL,
  `NomTypeUser` varchar(50) NOT NULL
) ;

--
-- Déchargement des données de la table `typeuser`
--

INSERT INTO `typeuser` (`IdTypeUser`, `NomTypeUser`) VALUES
(1, 'Directeur'),
(2, 'Directeur ventes'),
(3, 'Employé finance'),
(4, 'Employé marketing');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `IdUser` int(11) NOT NULL,
  `PseudoUser` varchar(30) NOT NULL,
  `PwdUser` varchar(30) NOT NULL,
  `IdTypeUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`IdUser`, `PseudoUser`, `PwdUser`, `IdTypeUser`) VALUES
(1, 'D', '000', 1),
(2, 'DV', '123', 2),
(3, 'EF', '456', 3),
(4, 'EM', '789', 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bilan`
--
ALTER TABLE `bilan`
  ADD PRIMARY KEY (`IdBilan`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`IdRap`,`IdUser`,`DateCom`),
  ADD KEY `Commentaire_user_IdUser_fk` (`IdUser`);

--
-- Index pour la table `comporter`
--
ALTER TABLE `comporter`
  ADD PRIMARY KEY (`IdRap`,`IdInd`),
  ADD KEY `Comporter_indicateur_IdInd_fk` (`IdInd`);

--
-- Index pour la table `constituer`
--
ALTER TABLE `constituer`
  ADD PRIMARY KEY (`IdBilan`,`IdRap`),
  ADD KEY `Constituer_rapport_IdRap_fk` (`IdRap`);

--
-- Index pour la table `demanderapport`
--
ALTER TABLE `demanderapport`
  ADD PRIMARY KEY (`IdDem`),
  ADD KEY `DemandeRapport_user_IdUser_fk` (`IdUser`);

--
-- Index pour la table `indicateur`
--
ALTER TABLE `indicateur`
  ADD PRIMARY KEY (`IdInd`),
  ADD KEY `Indicateur_type_IdType_fk` (`IdType`);

--
-- Index pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD PRIMARY KEY (`IdRap`),
  ADD KEY `Rapport_type_IdType_fk` (`IdType`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`IdType`);

--
-- Index pour la table `typeuser`
--
ALTER TABLE `typeuser`
  ADD PRIMARY KEY (`IdTypeUser`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `user_PseudoUser_uindex` (`PseudoUser`),
  ADD KEY `User _typeuser_IdTypeUser_fk` (`IdTypeUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bilan`
--
ALTER TABLE `bilan`
  MODIFY `IdBilan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `demanderapport`
--
ALTER TABLE `demanderapport`
  MODIFY `IdDem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `indicateur`
--
ALTER TABLE `indicateur`
  MODIFY `IdInd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `rapport`
--
ALTER TABLE `rapport`
  MODIFY `IdRap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `IdType` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `typeuser`
--
ALTER TABLE `typeuser`
  MODIFY `IdTypeUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `Commentaire_rapport_IdRap_fk` FOREIGN KEY (`IdRap`) REFERENCES `rapport` (`IdRap`) ON DELETE CASCADE,
  ADD CONSTRAINT `Commentaire_user_IdUser_fk` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comporter`
--
ALTER TABLE `comporter`
  ADD CONSTRAINT `Comporter_indicateur_IdInd_fk` FOREIGN KEY (`IdInd`) REFERENCES `indicateur` (`IdInd`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comporter_rapport_IdRap_fk` FOREIGN KEY (`IdRap`) REFERENCES `rapport` (`IdRap`) ON DELETE CASCADE;

--
-- Contraintes pour la table `constituer`
--
ALTER TABLE `constituer`
  ADD CONSTRAINT `Constituer_bilan_IdBilan_fk` FOREIGN KEY (`IdBilan`) REFERENCES `bilan` (`IdBilan`) ON DELETE CASCADE,
  ADD CONSTRAINT `Constituer_rapport_IdRap_fk` FOREIGN KEY (`IdRap`) REFERENCES `rapport` (`IdRap`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demanderapport`
--
ALTER TABLE `demanderapport`
  ADD CONSTRAINT `DemandeRapport_user_IdUser_fk` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`) ON DELETE CASCADE;

--
-- Contraintes pour la table `indicateur`
--
ALTER TABLE `indicateur`
  ADD CONSTRAINT `Indicateur_type_IdType_fk` FOREIGN KEY (`IdType`) REFERENCES `type` (`IdType`) ON DELETE CASCADE;

--
-- Contraintes pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD CONSTRAINT `Rapport_type_IdType_fk` FOREIGN KEY (`IdType`) REFERENCES `type` (`IdType`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `User _typeuser_IdTypeUser_fk` FOREIGN KEY (`IdTypeUser`) REFERENCES `typeuser` (`IdTypeUser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
