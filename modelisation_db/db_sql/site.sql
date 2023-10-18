-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 18 sep. 2019 à 07:05
-- Version du serveur :  5.7.24
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `site`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonner`
--

DROP TABLE IF EXISTS `abonner`;
CREATE TABLE IF NOT EXISTS `abonner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_fin` datetime DEFAULT NULL,
  `status` enum('BASIQUE','MOYEN','AVANCE','AUTRE') DEFAULT NULL,
  `annuler` enum('0','1') DEFAULT NULL,
  `frais` decimal(15,3) DEFAULT NULL,
  `services_id` int(11) DEFAULT NULL,
  `utilisateurs_abonner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_abonnement_utilisateurs2_idx` (`utilisateurs_abonner_id`),
  KEY `fk_abonnement_services1_idx` (`services_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `code` varchar(255) NOT NULL,
  `type` enum('ORANGE MONEY','MVOLA','AIRTEL MONEY','PAYPAL','AUTRES') DEFAULT NULL,
  `solde` decimal(15,3) DEFAULT '0.000',
  `numero_tel` varchar(20) DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `numero_tel_UNIQUE` (`numero_tel`),
  KEY `fk_compte_utilisateurs1_idx` (`utilisateurs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `dernier_modif` datetime DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_configuration_utilisateurs1_idx` (`utilisateurs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `utilisateurs_id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `activite` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`utilisateurs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `motif` varchar(255) DEFAULT NULL,
  `some_a_paye` decimal(15,3) DEFAULT NULL,
  `abonner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_facture_abonnement1_idx` (`abonner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `publier_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medias_article1_idx` (`publier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `publier`
--

DROP TABLE IF EXISTS `publier`;
CREATE TABLE IF NOT EXISTS `publier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `contenu` text,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `en_ligne` enum('0','1') DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  `services_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_utilisateurs_idx` (`utilisateurs_id`),
  KEY `fk_article_services1_idx` (`services_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `en_ligne` enum('0','1') DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_services_utilisateurs1_idx` (`fournisseur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom_d_utilisateur` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `type` enum('ADMIN','ENTREPRISE','CLIENT') DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `acces` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `nom_d_utilisateur_UNIQUE` (`nom_d_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
