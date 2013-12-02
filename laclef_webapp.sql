-- laclef-webapp SQL Dump
-- 
-- Serveur: laclef.cc
-- Généré le : Lundi 02 Décembre 2013 à 13:00
-- Version du serveur: 5.1.72
-- Version de PHP: 5.3.3-7+squeeze17
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `equipments`
-- 

CREATE TABLE IF NOT EXISTS `equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(7) DEFAULT NULL,
  `name` varchar(48) NOT NULL,
  `description` varchar(256) NOT NULL,
  `hirer` varchar(32) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `messages`
-- 

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL,
  `message` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `orders`
-- 

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `swipe` int(11) NOT NULL,
  `snack` int(11) NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31358 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `payments`
-- 

CREATE TABLE IF NOT EXISTS `payments` (
  `uid` varchar(32) NOT NULL,
  `amount` float NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `permissions`
-- 

CREATE TABLE IF NOT EXISTS `permissions` (
  `uid` varchar(32) NOT NULL,
  `id` int(11) NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `readers`
-- 

CREATE TABLE IF NOT EXISTS `readers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(128) DEFAULT NULL,
  `services` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `snacks`
-- 

CREATE TABLE IF NOT EXISTS `snacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description_fr_FR` varchar(128) NOT NULL,
  `description_en_US` varchar(128) NOT NULL,
  `price` float NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `swipes`
-- 

CREATE TABLE IF NOT EXISTS `swipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `reader` int(11) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `service` smallint(6) NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31841 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `tags`
-- 

CREATE TABLE IF NOT EXISTS `tags` (
  `uid` char(8) NOT NULL,
  `owner` varchar(32) NOT NULL DEFAULT '',
  `keya` char(6) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(32) NOT NULL,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `locale` char(5) NOT NULL DEFAULT 'en_US',
  `balance` float NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `users`
-- 

INSERT INTO `users` VALUES ('admin', 'Administrateur', '', 'admin@localhost', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'fr_FR', 0);
