-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 18 mars 2022 à 08:33
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `grandoral`
--
CREATE DATABASE IF NOT EXISTS `grandoral` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `grandoral`;

-- --------------------------------------------------------

--
-- Structure de la table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL COMMENT 'Clé primaire',
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur lié',
  `q1` text NOT NULL COMMENT 'Question 1',
  `q2` text NOT NULL COMMENT 'Question 2',
  `e1valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que l''enseignant 1 a validé?',
  `e2valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que l''enseignant 2 a validé?',
  `proValid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Est-ce que le proviseur adjoint a validé?'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `form`
--

INSERT INTO `form` (`id`, `username`, `q1`, `q2`, `e1valid`, `e2valid`, `proValid`) VALUES
(1, 'garfield', 'azerty', 'qwerty', 0, 0, 0),
(2, 'garfield', 'dvorak', 'qwertz', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur, clé primaire étrangère sur users',
  `ine` varchar(11) NOT NULL COMMENT 'INE crypté; provient de la base siècle',
  `spec1` varchar(60) NOT NULL COMMENT 'Spécialité 1',
  `spec2` varchar(60) NOT NULL COMMENT 'Spécialité 2',
  `ens1` varchar(20) NOT NULL COMMENT 'Enseignant 1',
  `ens2` varchar(20) NOT NULL COMMENT 'Enseignant 2',
  `etabville` varchar(100) NOT NULL COMMENT 'Etablissement et ville; pourrait ne pas être demandé'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`username`, `ine`, `spec1`, `spec2`, `ens1`, `ens2`, `etabville`) VALUES
('garfield', '123456789af', 'lasagnes', 'dormir', 'Jean', 'Claude', 'paris');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL COMMENT 'Nom d''utilisateur, clé primaire, insensible à la casse',
  `password` varchar(48) NOT NULL COMMENT 'Mot de passe à hasher',
  `lastLog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `lastname` varchar(100) DEFAULT NULL COMMENT 'Pour la communication',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Définit le grade de l''user; 0: étudiant ; 1: enseignant; 2: proviseur adjoint ; 3: secrétaire ',
  `email` varchar(320) NOT NULL COMMENT 'Pour la communication'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tous les utilisateurs';

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `password`, `lastLog`, `firstname`, `lastname`, `status`, `email`) VALUES
('garfield', 'def456', '2022-03-18 07:23:28', 'gar', 'field', 0, 'gar@field.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire', AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
