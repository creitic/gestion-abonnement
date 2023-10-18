-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 10 nov. 2019 à 13:14
-- Version du serveur :  5.7.24
-- Version de PHP :  7.1.26

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
-- Structure de la table `abonnements`
--

DROP TABLE IF EXISTS `abonnements`;
CREATE TABLE IF NOT EXISTS `abonnements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debut` datetime DEFAULT CURRENT_TIMESTAMP,
  `expiration` datetime NOT NULL,
  `annuler` tinyint(4) DEFAULT '0',
  `service_id` int(11) DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_abonnements_publications1_idx` (`service_id`),
  KEY `fk_abonnements_utilisateurs1_idx` (`utilisateurs_id`),
  KEY `fk_abonnements_status1_idx` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `abonnements`
--

INSERT INTO `abonnements` (`id`, `debut`, `expiration`, `annuler`, `service_id`, `utilisateurs_id`, `status_id`) VALUES
(1, '2019-10-21 12:41:57', '2020-07-21 12:41:57', 1, NULL, 2, 2),
(2, '2019-10-21 12:42:30', '2020-07-21 12:42:30', 0, 5, 2, 2),
(4, '2019-10-22 16:38:37', '2020-07-22 16:38:37', 0, 13, 2, 2),
(5, '2019-10-22 20:51:31', '2020-11-22 20:51:31', 1, 16, 1, 18),
(6, '2019-10-22 20:56:24', '2020-11-22 20:56:24', 1, 15, 1, 18),
(7, '2019-10-22 21:09:15', '2020-11-22 21:09:15', 1, 19, 1, 18),
(8, '2019-10-23 10:16:03', '2020-11-23 10:16:03', 1, 19, 1, 18),
(9, '2019-10-23 10:21:46', '2020-11-23 10:21:46', 1, 15, 1, 18),
(10, '2019-10-23 10:24:09', '2020-11-23 10:24:09', 1, 15, 1, 18),
(11, '2019-10-23 10:34:39', '2020-11-23 10:34:39', 1, 19, 1, 18),
(12, '2019-10-23 10:35:27', '2020-11-23 10:35:27', 1, 16, 1, 18),
(13, '2019-10-23 10:37:10', '2020-07-23 10:37:10', 1, NULL, 2, 2),
(14, '2019-10-23 10:55:25', '2020-10-23 10:55:25', 1, NULL, 2, 11),
(15, '2019-10-23 16:03:50', '2020-11-23 16:03:50', 0, 19, 1, 18),
(16, '2019-10-23 16:07:00', '2020-10-23 16:07:00', 1, NULL, 2, 11),
(17, '2019-10-23 16:08:48', '2020-07-23 16:08:48', 0, NULL, 2, 2),
(18, '2019-10-23 17:32:04', '2020-11-23 17:32:04', 1, 15, 1, 18),
(19, '2019-10-26 12:21:36', '2020-07-26 12:21:36', 1, 12, 2, 2),
(20, '2019-10-27 15:04:44', '2020-07-27 15:04:44', 0, NULL, 13, 2);

-- --------------------------------------------------------

--
-- Structure de la table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `selecteur` varbinary(20) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `utilisateurs_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selecteur` (`selecteur`) USING BTREE,
  KEY `utilisateurs_id` (`utilisateurs_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `code` varchar(255) NOT NULL,
  `type` enum('om','mv','am','pp','other') DEFAULT 'om',
  `solde` decimal(15,3) DEFAULT '0.000',
  `numero_tel` varchar(20) DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `numero_tel_UNIQUE` (`numero_tel`),
  KEY `fk_compte_utilisateurs1_idx` (`utilisateurs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`code`, `type`, `solde`, `numero_tel`, `utilisateurs_id`) VALUES
('123456', 'om', '3599954.000', '0322266175', 2),
('00001111', 'om', '7600046.000', '0342705117', 1),
('5117396183199466', 'am', '800000.000', '(462)622-3127', 13),
('4532839189448322', 'mv', '1000000.000', '(202)261-8251x03406', 14),
('4114753521440', 'om', '1000000.000', '953-081-1247x6575', 15),
('4532721993645', 'om', '1000000.000', '(243)059-6309x217', 16),
('5388535342148624', 'om', '1000000.000', '994.804.3790', 17),
('5519421105532745', 'om', '1000000.000', '600.183.4876x505', 18),
('6011060649139492', 'pp', '1000000.000', '088-427-4944', 19),
('5269817476162569', 'mv', '1000000.000', '765-209-5702', 20),
('5116993763960829', 'mv', '1000000.000', '118.075.1188x82872', 21),
('5265330981796311', 'pp', '1000000.000', '06423924768', 22),
('6011715689661770', 'om', '1000000.000', '441.917.5575x55983', 23),
('5183167670915828', 'om', '1000000.000', '1-696-605-5164', 24),
('5236998992276370', 'pp', '1000000.000', '01700424062', 25),
('5305606955115669', 'pp', '1000000.000', '491-420-6362x3665', 26),
('5361598570362175', 'pp', '1000000.000', '888.316.0683', 27),
('5428966364549064', 'om', '1000000.000', '+45(7)6202943469', 28),
('5105668014936232', 'om', '1000000.000', '951.106.9559x1762', 29),
('5550541806892562', 'mv', '1000000.000', '893-919-0558', 30),
('6011884650009932', 'pp', '1000000.000', '(350)898-8722x925', 31),
('5382252978975532', 'om', '1000000.000', '(427)550-8904', 32),
('5526437917338322', 'am', '1000000.000', '683-330-0910x06991', 33),
('5364187249183919', 'mv', '1000000.000', '846-157-5740', 34),
('5219984907180482', 'mv', '1000000.000', '132-386-1921', 35),
('347658900054890', 'am', '1000000.000', '261.973.7711x48978', 36),
('5561247193680855', 'mv', '1000000.000', '(218)007-6428', 37),
('5123899243257219', 'mv', '1000000.000', '861.065.1455x313', 38),
('5523989781770133', 'om', '1000000.000', '458.815.0387', 39),
('4024007132687', 'mv', '1000000.000', '(148)114-6817', 40),
('5425587500784835', 'pp', '1000000.000', '202.232.0190x97349', 41),
('5285341124152502', 'pp', '1000000.000', '1-328-540-8212x5920', 42);

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `utilisateurs_id` int(11) NOT NULL,
  `nom_e` varchar(255) DEFAULT NULL,
  `activite` text,
  PRIMARY KEY (`utilisateurs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`utilisateurs_id`, `nom_e`, `activite`) VALUES
(1, 'DUAL', 'Producteur de son----------------------'),
(2, 'Test', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(17, 'Konopelski Group', 'Rerum et hic dolorem commodi iusto libero exercitationem voluptas. Dolores provident omnis et provident. Distinctio minima autem sunt non ducimus ipsum. Esse dicta voluptates aut rem.'),
(15, 'Lemke Inc', 'Cumque quos et itaque expedita expedita eum. Hic voluptate quo architecto. Sed saepe aut consequatur sunt occaecati ratione. Architecto assumenda et officia quaerat amet.'),
(16, 'Rowe and Sons', 'Dicta voluptatibus deleniti deserunt autem aut iure sequi. Tempore explicabo voluptates voluptas quo cum nihil. Nam itaque consequatur quas saepe esse velit.'),
(13, 'Kirlin, Casper and Wisoky', 'Officiis qui voluptas facere laborum est voluptatibus. Ex corporis cupiditate quidem est iusto voluptatem rem.'),
(14, 'Predovic and Sons', 'Maxime perspiciatis omnis error et voluptas dignissimos ut. Et atque nisi odit eum assumenda animi et.'),
(18, 'Abbott-Streich', 'Atque dolorem qui magni rerum sit dolores ut. Consectetur totam nam nihil impedit enim sint ea. Quod in omnis repudiandae est asperiores.'),
(19, 'Lakin, Tromp and Schaefer', 'Dolorem ipsam voluptatum quia libero. Tenetur omnis accusantium id est. Rerum adipisci voluptatem laborum rerum.'),
(20, 'Gleason-Hahn', 'Quo cum consequuntur est quisquam quod. Ducimus ullam sequi quisquam ut est. Aut quia omnis id et. Illo ut aut soluta repellendus praesentium delectus modi.'),
(21, 'Bergnaum PLC', 'Incidunt reiciendis qui quasi qui id. Natus ullam repudiandae temporibus error eius alias corrupti. Consequatur repellat quia nam. Magnam quod voluptatibus ut.'),
(22, 'Mayer, Ortiz and Willms', 'Temporibus distinctio est impedit et suscipit veritatis harum magni. Ut enim laudantium reprehenderit aut sit facere voluptas. Qui ipsam quibusdam est sunt ut.'),
(23, 'Swaniawski and Sons', 'Voluptatum optio enim magni praesentium illum nisi ab. Et delectus corporis minima aut rerum rerum voluptates. Optio aut nostrum amet ratione architecto saepe doloremque.'),
(24, 'VonRueden-Mills', 'Aspernatur placeat quam quasi sed non. Pariatur repellendus sit sit eveniet et quam velit iste. Sit quibusdam dolores tempora voluptatem fugiat laboriosam sunt dolorem.'),
(25, 'Ferry, Anderson and Padberg', 'Sint repellat omnis voluptas inventore sed earum nisi. Quis voluptatem sit fuga autem eos perspiciatis tempora molestias. Et saepe nam qui amet nostrum ducimus. Quia quae natus molestiae ut quo velit sed.'),
(26, 'Yundt-Becker', 'Quia ipsam iste sit amet ab. Aut et eligendi voluptate.'),
(27, 'Douglas, Cormier and Kemmer', 'Iure sunt nostrum culpa ad non ad architecto. Non quisquam assumenda culpa. Deleniti et commodi quaerat ducimus officiis.'),
(28, 'Wunsch-Shields', 'Perspiciatis et itaque voluptatem porro quibusdam sit. In autem ratione et et nihil. Minima eum laboriosam ut quo. Quo fugiat placeat architecto pariatur labore facilis atque velit.'),
(29, 'Douglas, Kunde and Rohan', 'Assumenda ut quis nemo magnam. Dolorem tempore qui dicta vel tempora maxime. Illum et nihil omnis dolorem maxime.'),
(30, 'Hirthe-Douglas', 'Delectus ea quos corrupti debitis ex vitae dolorem. Nemo aut porro ut pariatur iusto vitae. Beatae maxime ea eaque modi ut impedit. Velit placeat animi consequuntur odit ut doloribus at.'),
(31, 'Hauck, Tromp and Turner', 'Repudiandae molestiae enim qui commodi dolorum animi. Libero quos asperiores quasi aut nostrum harum similique molestias. Asperiores repellat iure laboriosam quidem et laudantium.'),
(32, 'Kohler-Swaniawski', 'Minima rerum qui sit omnis nam harum. Libero ea quis praesentium neque quia impedit officiis consequuntur. Iste odio deleniti et molestias maiores minus.'),
(33, 'Gerhold, Kub and Weber', 'Et non est distinctio commodi sequi minima velit. Nulla rerum non veritatis non doloremque. Ea sed temporibus distinctio nemo architecto.'),
(34, 'Gislason, Collier and Orn', 'Quis nihil qui consequatur iste optio. Quis magni aut voluptas omnis sunt et reprehenderit est. Sunt voluptas et autem sint quos. Rerum soluta blanditiis dolorem et.'),
(35, 'Lang and Sons', 'Dolor omnis rerum dolorum est esse quas et. Sunt tempora quis voluptas suscipit in autem molestiae. Cumque labore consequuntur at cumque.'),
(36, 'Osinski PLC', 'Facilis delectus tenetur nam ad. Est dignissimos suscipit assumenda molestiae. Dolor qui enim est autem nesciunt itaque incidunt. Veritatis ea ipsa esse possimus est omnis hic commodi.'),
(37, 'Cummerata-Lebsack', 'Et officia in cupiditate quae et eum reiciendis. Enim eligendi libero quidem. In et repudiandae hic. Provident quod aut maxime est earum reprehenderit. Deserunt eum ipsum tempora est et.'),
(38, 'Cremin Inc', 'Magni et praesentium quaerat eaque optio. Reprehenderit nam minima sit at odit aut. Autem praesentium magni eos. Eum animi aut saepe praesentium consequatur.'),
(39, 'Murazik, Hudson and King', 'Iste dignissimos modi aperiam nobis distinctio. Ipsam ad eum qui fugit temporibus. Ducimus itaque qui asperiores qui quisquam soluta est omnis.'),
(40, 'McLaughlin-Kuhic', 'Quod quibusdam et quisquam adipisci ipsum officiis. Facere sit eos dignissimos amet eos ut soluta. Est aut facere ducimus quae fuga quia aperiam. Laboriosam laboriosam quaerat reiciendis ducimus mollitia consequatur deleniti. Nemo occaecati consequatur vero.'),
(41, 'O\'Reilly-Mertz', 'Est vero dolorum cumque illo optio expedita. Nesciunt tenetur modi perferendis est delectus aliquam aut. Placeat omnis minima quidem iusto aut iure quos eum.'),
(42, 'Hermiston-King', 'Dolorum et maiores ut repudiandae maiores. Quis ipsum sit ipsam at. Quas necessitatibus fugit aut aliquid consequatur natus reprehenderit.');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `motif` varchar(255) DEFAULT NULL,
  `some_a_paye` decimal(15,3) DEFAULT NULL,
  `abonnements_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_facture_abonnement1_idx` (`abonnements_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_f` varchar(255) DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `type_f` varchar(255) DEFAULT NULL,
  `publications_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medias_article1_idx` (`publications_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`id`, `nom_f`, `fichier`, `type_f`, `publications_id`) VALUES
(7, 'test', 'Background.jpg', 'img', 10),
(14, 'dettttt', 'gh.jpg', 'img', 4),
(15, 'tere', 'claudio2019-.jpg', 'img', 10),
(16, 'ghhgh', 'claudio2019.jpg', 'img', 14),
(12, 'err', 'Sans titre-1.jpg', 'img', 4),
(17, 'trrrr', 'cld.jpg', 'img', 14),
(18, 'rere', 'FB_IMG_15583792873088831.jpg', 'img', 14),
(19, 'ee', 'Background.jpg', 'img', 20),
(20, 'ttt', '70298071_1331376263681922_1714460071645151232_o.jpg', 'img', 21),
(21, 'trte', 'image2.png', 'img', 21),
(22, 'image tst', 'vlcsnap-2019-09-30-18h16m30s339.png', 'img', 23),
(23, 'capt', 'Capture.PNG', 'img', 23),
(24, 'capture', 'Capture22.PNG', 'img', 23),
(25, 'trt', 'gsm.PNG', 'img', 24),
(26, 'trtrt', 'iccon.jpg', 'img', 25),
(28, 'hgh', 'espa.png', 'img', 25);

-- --------------------------------------------------------

--
-- Structure de la table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `contenu` text,
  `type` enum('article','service','status') DEFAULT 'article',
  `creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `modification` datetime DEFAULT CURRENT_TIMESTAMP,
  `en_ligne` tinyint(4) DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `utilisateurs_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_utilisateurs_idx` (`utilisateurs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `publications`
--

INSERT INTO `publications` (`id`, `nom`, `contenu`, `type`, `creation`, `modification`, `en_ligne`, `slug`, `utilisateurs_id`) VALUES
(1, 'basic', NULL, 'status', '2019-10-07 09:55:16', '2019-10-17 09:20:17', 1, 'basic', 1),
(2, 'pro', NULL, 'status', '2019-10-07 10:10:43', '2019-10-17 09:20:10', 1, 'pro', 1),
(10, 'Article5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'article', '2019-10-10 11:06:08', '2019-10-25 18:38:46', 1, 'article5', 1),
(4, 'article du jour', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'article', '2019-10-07 10:18:13', '2019-10-25 18:40:05', 1, 'monarticle', 1),
(5, 'serv', NULL, 'service', '2019-10-07 10:18:21', '2019-10-16 17:31:10', 1, 'serv', 1),
(11, 'premium', NULL, 'status', '2019-10-13 18:01:34', '2019-10-17 09:20:26', 1, 'premium', 1),
(12, 'programation', NULL, 'service', '2019-10-15 11:44:28', '2019-10-15 08:44:28', 1, 'ttt', 1),
(13, 'traitement de texte', NULL, 'service', '2019-10-15 15:33:41', '2019-10-16 17:31:54', 1, 'traitement', 1),
(14, 'mickael', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'article', '2019-10-22 16:39:31', '2019-10-25 20:02:49', 1, 'tet', 2),
(15, 'Mon status', NULL, 'service', '2019-10-22 19:15:58', '2019-10-22 19:15:58', 1, 'servvv', 2),
(16, 'programmaton', NULL, 'service', '2019-10-22 19:16:22', '2019-10-22 19:16:22', 1, 'ttt', 2),
(17, 'Mon status', NULL, 'status', '2019-10-22 19:17:03', '2019-10-22 19:17:03', 1, 'sttt', 2),
(18, 'status2', NULL, 'status', '2019-10-22 19:17:27', '2019-10-22 19:17:27', 1, 'hh', 2),
(19, 'terr', NULL, 'service', '2019-10-22 21:07:18', '2019-10-22 21:07:18', 1, 'tttt', 2),
(20, 'zere', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'article', '2019-10-25 18:39:15', '2019-10-25 18:39:15', 1, 'eeee', 1),
(21, 'arduino', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'article', '2019-10-25 20:19:48', '2019-10-25 20:19:48', 1, 'tees', 2),
(22, 'article', 'article', 'article', '2019-10-26 12:19:43', '2019-10-26 12:19:43', 1, 'trrr', 2),
(23, 'Contricity', 'terer', 'article', '2019-10-27 15:08:03', '2019-10-27 15:08:03', 1, 'cntrl', 13),
(24, 'artt', 'rtrtrt', 'article', '2019-10-27 15:14:47', '2019-10-27 15:14:47', 1, 'trtrr', 13),
(25, 'rtr', 'rttrt', 'article', '2019-10-27 15:15:07', '2019-10-27 15:15:07', 1, 'rtrt', 13),
(26, 'Formation dev', NULL, 'service', '2019-10-27 15:18:31', '2019-10-27 15:18:31', 1, 'frm', 13),
(27, 'Formation en projet', NULL, 'service', '2019-10-27 15:18:52', '2019-10-27 15:18:52', 1, 'frmprj', 13),
(28, 'Basique', NULL, 'status', '2019-10-27 15:19:45', '2019-10-27 15:19:45', 1, 'bs', 13);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `publications_id` int(11) NOT NULL,
  `nbr_mois` int(11) DEFAULT NULL,
  `prix` decimal(15,3) DEFAULT NULL,
  PRIMARY KEY (`publications_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`publications_id`, `nbr_mois`, `prix`) VALUES
(1, 6, '100000.000'),
(2, 9, '200000.000'),
(11, 12, '400023.000'),
(17, 3, '100.000'),
(18, 13, '1000000.000'),
(28, 3, '20000.000');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `sexe` enum('masculin','feminin') NOT NULL DEFAULT 'masculin',
  `photo` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `email` varchar(255) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `acces` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `nom_d_utilisateur_UNIQUE` (`pseudo`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `sexe`, `photo`, `pseudo`, `mot_de_passe`, `role`, `email`, `cin`, `pays`, `ville`, `acces`) VALUES
(1, 'RAMAHAVITA', 'Claudio', 'masculin', 'cc.jpg', 'claudio', '$2y$10$.pZx0P0QfVxAFGYRfslwOeU3YAPVEjzgpez7Zc/9rL1CCWIktfiwm', 'admin', 'claudioramahavita@gmail.com', '301031021247', 'Madagascar', 'Toamasina', 1),
(2, 'INDALANA', 'Anthonio Arnolet', 'masculin', 'Background.jpg', 'anthonio', '$2y$10$Y2sestI5TVE/JVh24ipC8OPtAGKaZklqabFUu0EWCsbkcHLrD1zjO', 'client', 'ghghghgh@gmail.com', '33333333333333333', 'Afghanistan', 'TAMAGA', 1),
(17, 'Rafaela', 'Purdy', 'feminin', NULL, 'lind.rory', '$2y$10$9DVO2A/2YLwyOsOVX9WJmeYQuWh72ZaZCOXc8xoS1HtqSbGna52Ca', 'client', 'rowe.rhianna@yahoo.com', '4485496058355', 'Bulgaria', 'New Preston', 1),
(16, 'Aurelia', 'DuBuque', 'feminin', NULL, 'hirthe.zoila', '$2y$10$yWVqknRTU/7jqC5sf/ddT.NH7hWXhJ9Qs9DLrD57AouNQybRD3eH.', 'client', 'ally.price@hammes.com', '5375634100008081', 'Ukraine', 'Jonesberg', 1),
(15, 'Jamil', 'Keebler', 'masculin', NULL, 'feeney.hans', '$2y$10$a9bB6xb0hN2N29dX54OO4e3kzYjxFZ9oNi6krSYsOgrIpmAuT75Za', 'client', 'casper.stephen@gmail.com', '5478418504682514', 'Paraguay', 'Jasttown', 1),
(13, 'King', 'Wolff', 'masculin', 'test.png', 'ywolf', '$2y$10$aRsptxbnz1XtZPiPaKkZkebuT0Em3oLz6yTNIvBBbPHsE4vlSFf3y', 'client', 'lebsack.dion@jakubowski.biz', '4716884107493724', 'Vanuatu ', 'Lorenztown', 1),
(14, 'Malvina', 'Willms', 'masculin', NULL, 'xtowne', '$2y$10$7M2mp5IvNY0s71oOUVgbi.uHN6J/xRxahgvojh2kFz08QV5mSXJE.', 'client', 'madilyn.schuster@ebert.com', '4532840231029', 'Czech Republic', 'Fisherview', 1),
(18, 'Camille', 'Kovacek', 'feminin', NULL, 'kendall23', '$2y$10$Bs/cAGg7U6Vc23armiNMEOiJ4gKV5LAO4mlTz0XAhToJY9zfwBEzS', 'client', 'violet19@gmail.com', '5220331348574338', 'Cocos (Keeling) Islands', 'Connietown', 1),
(19, 'Ken', 'Heathcote', 'feminin', NULL, 'o\'connell.elissa', '$2y$10$R4pvSnmLdsM65gwYKV0Y1e7TkVJf.WR.lKbaZHHcKUbA6vfgvZaPG', 'client', 'lkunze@adams.com', '4024007118532', 'Andorra', 'Lucybury', 1),
(20, 'Elliott', 'Harber', 'masculin', NULL, 'kellen.gaylord', '$2y$10$hCRghWyfrGVBoYNuaiTJhuvfis2b7wivXt9R6aa5foAoWd5vop5Vi', 'client', 'white.tyrese@gmail.com', '6011908482489798', 'Gabon', 'Port Darrickbury', 1),
(21, 'Broderick', 'Breitenberg', 'feminin', NULL, 'abbott.jacey', '$2y$10$sr98RmOadAOqaxPJbV.deeUXfvVBKgghXemZ38Fyud3LKRHGkCwBm', 'client', 'rachael.vonrueden@gmail.com', '5169452085243859', 'Suriname', 'New Woodrow', 1),
(22, 'Elyse', 'Marquardt', 'masculin', NULL, 'juana48', '$2y$10$5S4bSZEWk1wnXhvxX5i2gefIm2rkRgFm7fVpqcIQ4ZIPirsH4A5ym', 'client', 'mikel.bashirian@grant.net', '5125393248081308', 'French Southern Territories', 'Port Kaileyshire', 1),
(23, 'Aliya', 'Osinski', 'masculin', NULL, 'pagac.vidal', '$2y$10$Tr.GYD5jF1fxp2lLxhZCnOmRw/s55ZMd42ngZcqa0S3dAK/Q1Sc/C', 'client', 'elijah.ruecker@hotmail.com', '5455322523517720', 'Serbia', 'Fayhaven', 1),
(24, 'America', 'Ferry', 'feminin', NULL, 'gene38', '$2y$10$AxROYlt7Di8RQkTXh54KMuqWPwtNclOqQ0e7r1Vz5Y1ZrEYUyonIa', 'client', 'juliana73@yahoo.com', '5360389005726529', 'Slovakia (Slovak Republic)', 'Reneeview', 1),
(25, 'Albert', 'Aufderhar', 'feminin', NULL, 'smitham.tia', '$2y$10$xD4MzOOKoUQ/FmEmagixeedgd0Ij5sMyn.Crws5.Ivz1CH1cKUDGS', 'client', 'quinn68@hotmail.com', '4539156844406463', 'Australia', 'Boehmbury', 1),
(26, 'Clair', 'Rolfson', 'masculin', NULL, 'maxwell.leffler', '$2y$10$ipqzWW7jEwbVAvRCLLhmW.IBlR5wrte1gpcZdX2hc6csMIBlFjiZq', 'client', 'anjali.schulist@weissnathermiston.com', '5479235899288349', 'Ethiopia', 'North Elfrieda', 1),
(27, 'Amely', 'Collins', 'masculin', NULL, 'murl.keebler', '$2y$10$IUexuDxT7Am2R0ilMq7TNO4CyIDu0ZdQz4XfDRF9F2YPkqz5IuK9K', 'client', 'amparo.boehm@cummerata.com', '5479482615601004', 'Sao Tome and Principe', 'Jaydenfort', 1),
(28, 'Al', 'Skiles', 'masculin', NULL, 'kayla11', '$2y$10$r5OpfuA5POz9.hjf1f3fquKijjm5ZwbLM8OsWta4K9hnOViMCanpG', 'client', 'ruby16@kulas.com', '5384249554152314', 'Argentina', 'Daltonland', 1),
(29, 'Alford', 'Armstrong', 'masculin', NULL, 'udenesik', '$2y$10$1OpH0g7/7OjczZRtgoV54OESeCPH9dUKuMFjeE1aT7aktPel48.oy', 'client', 'guiseppe16@buckridge.com', '6011315349238735', 'Mozambique', 'North Sabrinaborough', 1),
(30, 'Damion', 'Dietrich', 'masculin', NULL, 'runolfsdottir.ava', '$2y$10$Hb9VLjPL/Sy0NGh8PS8VMu/MfZdF/5r2Vb5GM6ClP2.novfVuO09e', 'client', 'block.abbigail@legros.info', '5389268196954972', 'British Virgin Islands', 'New Francescomouth', 1),
(31, 'Cody', 'Larson', 'feminin', NULL, 'unitzsche', '$2y$10$yiMiib5WLgVolDmAdJmLqeizyUHxmqJboetZAk4I/XllKV0tLzea2', 'client', 'zdickens@legrosgrant.com', '5403710788503416', 'Honduras', 'East Laurel', 1),
(32, 'Camron', 'Nolan', 'masculin', NULL, 'bahringer.eriberto', '$2y$10$3BM3Th44t72hV2/fbYQnmeHiyNpRlJ7pUv0oxD8QAAZM.on2ZtsaW', 'client', 'nicolas49@hotmail.com', '5172576699836405', 'Saint Barthelemy', 'Luismouth', 1),
(33, 'Clementine', 'Hauck', 'feminin', NULL, 'judy29', '$2y$10$xkdsq76PUBkBNNzoK/aUDe6833TblNRjntwSb1LhHPzqaxTYd0Xlu', 'client', 'kane.lang@stoltenbergzieme.net', '5509397693731721', 'Saint Martin', 'North Alicia', 1),
(34, 'Bert', 'Grimes', 'feminin', NULL, 'wquigley', '$2y$10$fslGaZlFXixbRGyVfwpHM.Y.hvtx5LYL0CPt.ZrDagS/L/gPZN/LK', 'client', 'loraine.nikolaus@boscowillms.com', '4532040706307912', 'Puerto Rico', 'East Virginieshire', 1),
(35, 'Xzavier', 'Langosh', 'masculin', NULL, 'keeling.brandt', '$2y$10$j9gfJeskUHnOItszL.V9UeAP/hNekDhYl.X60cCewjbjBMvWEFIpm', 'client', 'leta90@yahoo.com', '4513177246868', 'Martinique', 'New Carleeside', 1),
(36, 'Gene', 'Weimann', 'feminin', NULL, 'ernser.nico', '$2y$10$.oBNzKCwHvaY0SIpm1ria.O192/UZtaZSTJQAG3IQZ7Gl..HaciAG', 'client', 'hhills@zemlak.com', '346428104655981', 'Cape Verde', 'Emmieshire', 1),
(37, 'Treva', 'Schultz', 'masculin', NULL, 'lucious.farrell', '$2y$10$gcR0yVOShNjDEW97Eq5rfOLFqNq71cfULFrVH/ALAe3T34ROCKUU6', 'client', 'pearl.hoeger@yahoo.com', '4929784710647', 'Switzerland', 'Cheyanneburgh', 1),
(38, 'Elmer', 'Wunsch', 'masculin', NULL, 'justine.gerhold', '$2y$10$G9CSR2vR2NRhKI43FTZ4MuLQdrp/7XoooPnmFwA1NmrOekfRq3tja', 'client', 'candida.hudson@gmail.com', '5393900209107002', 'Central African Republic', 'Osinskiport', 1),
(39, 'Keyon', 'O\'Connell', 'feminin', NULL, 'ilangworth', '$2y$10$MLbBGKf2T/iwjyCt.motxOBAlv3VWuGLSxxjKfSdW4Be0UBSl/x0a', 'client', 'ehills@lemke.com', '4556595723053515', 'Trinidad and Tobago', 'New Erlingland', 1),
(40, 'Annie', 'Legros', 'feminin', NULL, 'ara28', '$2y$10$IqzpmS4LaKrtl8EnujJzxuMkYX.LwIhI35Hu7O34GclBXiewQ1nnW', 'client', 'zgreenholt@macejkovicmante.info', '5280704654053711', 'Iraq', 'Lake Deion', 1),
(41, 'Antone', 'Jacobi', 'feminin', NULL, 'maureen.hirthe', '$2y$10$aNyD1rT6JGnUrYvwr0dBeuNfM85xHetScoxWhub7fdH8TYllbdBQq', 'client', 'orland69@bartolettischumm.com', '5210889547734450', 'Algeria', 'New Aleenfort', 1),
(42, 'Daron', 'Thompson', 'masculin', NULL, 'sfeest', '$2y$10$cGohahwQVxfRROMnWZCZ8u2j9j5qdRjERgKshjBbjORwllHaiN0c.', 'client', 'mlegros@hotmail.com', '5476448261060426', 'Marshall Islands', 'Sheldonmouth', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
