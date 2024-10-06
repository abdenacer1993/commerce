-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 11 mai 2024 à 00:33
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_com`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(5, 'pc portable'),
(6, 'Telephone'),
(7, 'tablette'),
(8, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `valeur` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `valeur`) VALUES
(1, 'address', 'Gafsa 2151'),
(2, 'phone', '+21623456789'),
(3, 'facebook', 'Gafsaianet'),
(4, 'twitter', 'AlGiNET'),
(5, 'instagram', 'AlGiNET'),
(6, 'email', 'Gafsia-net@support.com');

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `repondre` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id`, `question`, `repondre`) VALUES
(6, 'Qui sommes-nous?', 'Nous sommes un site de vente e-commerce, tout est Ã©lectronique, notre objectif est de vendre en ligne'),
(7, 'Qui peut utiliser notre site ?', 'Notre site Internet comporte deux parcours : CrÃ©ation d\'un compte Â« client Â» pour acheter nos produits en ligne et crÃ©ation d\'un compte investisseur Le rÃ´le de ce compte est de faire connaÃ®tre son entreprise.');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

DROP TABLE IF EXISTS `personnes`;
CREATE TABLE IF NOT EXISTS `personnes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `addresse` varchar(250) NOT NULL,
  `mot_passe` varchar(200) NOT NULL,
  `role` varchar(30) NOT NULL,
  `code` int(11) NOT NULL DEFAULT '0',
  `expiration` int(11) NOT NULL DEFAULT '0',
  `date_creation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personnes`
--

INSERT INTO `personnes` (`id`, `nom`, `prenom`, `email`, `telephone`, `addresse`, `mot_passe`, `role`, `code`, `expiration`, `date_creation`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '23122312', 'Gafsa 2151', '$2y$10$MPJDY.eXHj4XFNdFtsT1gunyBmxfy0JmIOOI6ODHuk6lCPwIW3dDi', 'admin', 46812, 1714262526, 1712015490),
(14, 'testZ', 'azertyz', 'test@gmail.comz', '23456789z', 'test testz', '$2y$10$1kmIh7TgLuQ2lwrlzwlqKOn9q3Vej4suPSPvpxma/jZM/SRE8Ttcu', 'client', 0, 0, 1715122131),
(16, 'test', 'azerty', 'testd@gmail.com', '23456789', 'test test', '$2y$10$MX3wdK6vByWuTIo/KNVolu/Ii2KOhGyCdva1DGvhOWMVu.s7y6G2a', 'investisseur', 0, 0, 1715123185),
(17, 'hamdi', 'medeb', 'medb@gmail.com', '23456789', 'Gafsa 2151', '$2y$10$jF8ZcII6YFXU5E9sbXA1h.EXw24jDVlhyS9m3CQvmC6nrE9tXPIci', 'client', 0, 0, 1715176662),
(18, 'nacer', 'hasnaoui', 'nacer@gmail.com', '23456789', 'Gafsa 2151', '$2y$10$Tq8gm88/SSCCHrh26QUlhehIb3h96nTLxysM8U8sf2RCpk.WOgDeu', 'investisseur', 0, 0, 1715184668);

-- --------------------------------------------------------

--
-- Structure de la table `politique`
--

DROP TABLE IF EXISTS `politique`;
CREATE TABLE IF NOT EXISTS `politique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `politique` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `politique`
--

INSERT INTO `politique` (`id`, `politique`) VALUES
(1, 'ARTICLE 1 - PRIXxc\r\n1.1 - Les prix de nos produits sont indiquÃ©s en Dinars toutes taxes (TVA et autres taxes) comprises hors participation aux frais de port et sont valables tant quÂ´ils sont prÃ©sents Ã  lÂ´Ã©cran.\r\n1.2 - Toutes les commandes sont payables en Dinars Tunisiens.\r\n1.3 - Tunisianet se rÃ©serve le droit de modifier ses prix Ã  tout moment mais les produits seront facturÃ©s au tarif en vigueur au moment de la crÃ©ation de commande.\r\n1.4 - Les produits demeurent la propriÃ©tÃ© de Tunisianet jusquÂ´au complet encaissement du prix.\r\n\r\nARTICLE 2 - COMMANDExc\r\nLes commandes sont Ã  passer sur le site Internet : www.tunisianet.com.tn ou par tÃ©lÃ©phone au 31 31 00 00 ou par email sur contact (Ã ) tunisianet.com.tn ou Ã  notre siÃ¨ge Ã  Tunis.\r\nLes informations contractuelles sont prÃ©sentÃ©es en langue franÃ§aise et feront lÂ´objet dÂ´une confirmation par messagerie Ã©lectronique reprenant ces informations contractuelles une fois votre commande validÃ©e.');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(500) NOT NULL,
  `prix` double NOT NULL,
  `description` varchar(1000) NOT NULL,
  `categorie` varchar(500) NOT NULL,
  `images` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `titre`, `prix`, `description`, `categorie`, `images`) VALUES
(7, 'iphone', 2500, 'iphone', 'Telephone', 'a:1:{i:0;s:36:\"352a2a90183bc404c3af07af47d1957e.jpg\";}'),
(8, 'Tablette', 1200, 'Tablette iPad Wi-Fi, Ã‰cran Liquid Retina LED IPS 10.9\" (2360x1640p), Processeur Puce Apple A14 Bionic 6 cÅ“urs, Stockage 64Go, Appareil photo arriÃ¨re grand-angle 12Mpx, CamÃ©ra avant ultra grand-angle 12Mpx, Touch ID, Wiâ€‘Fi6AX, Bluetooth 5.2, Batterie lithium-polymÃ¨re 28.6Wh (10heures), Poids: 477gr.', 'tablette', 'a:2:{i:0;s:36:\"ef24ab8ed66321f30d9bc43a9bbd4367.jpg\";i:1;s:36:\"baaa98d91b34d6ec1b6a70d498a67372.jpg\";}'),
(10, ' HP Pavilion 15-eh3016nf', 1400, 'Windows 11 FamilleAMD Ryzenâ„¢ 5 7530U16 Go RAM512 Go Disque SSD15.6\" FHDCarte graphique AMD Radeonâ„¢', 'pc portable', 'a:3:{i:0;s:36:\"472e19d76b03bce78a8ee71d997f8b05.jpg\";i:1;s:36:\"61eb7ed9a1c33aacd8e7c0afbf3a5217.jpg\";i:2;s:36:\"c6660cff0ef3a19c0f1d9875366538a9.jpg\";}'),
(11, 'Dell xps 15', 3600, 'Processeur\r\nProcesseur IntelÂ® Coreâ„¢ i7-13700H de 13e gÃ©nÃ©ration (cache 24 Mo, 14 coeurs, jusquâ€˜Ã  5,00 GHz Turbo)\r\n\r\nSystÃ¨me d\'exploitation\r\n(Dell Technologies recommande Windows 11 Professionnel pour les entreprises)\r\nWindows 11 Famille, anglais, nÃ©erlandais, franÃ§ais, allemand, italien\r\n\r\nCarte graphique\r\nCarte graphique IntelÂ® Arcâ„¢ A370M\r\n\r\nÃ‰cran\r\nÃ‰cran 15,6\" InfinityEdge FHD+ (1 920 x 1 200) non tactile, antiÃ©blouissement, 500 cd/mÂ²\r\n\r\nMÃ©moire \r\n16 Go, 2 x 8 Go de mÃ©moire DDR5 Ã  4 800 MHz\r\n\r\nStockage\r\nDisque SSD M.2 PCIe NVMe de 512 Go\r\n\r\nCouleur\r\nExtÃ©rieur Platinum Silver, intÃ©rieur noir\r\n\r\nLogiciels de productivitÃ©\r\nAucune licence Microsoft Office incluse, offre de version dâ€˜essai de 30 jours uniquement\r\n\r\nLogiciels de sÃ©curitÃ©\r\nMcAfee+ Premium, 1 an', 'pc portable', 'a:3:{i:0;s:36:\"2be8eceea55d525de22a08bc2999339f.jpg\";i:1;s:36:\"327cac4ab3ceb5c7c2d0d9db2a55b234.jpg\";i:2;s:36:\"ed9f03c2eb5082a96052ddbd4a2f8b50.jpg\";}');

-- --------------------------------------------------------

--
-- Structure de la table `propos`
--

DROP TABLE IF EXISTS `propos`;
CREATE TABLE IF NOT EXISTS `propos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `propos` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `propos`
--

INSERT INTO `propos` (`id`, `propos`) VALUES
(1, 'Notre entreprise\r\nAlGiNET est Le spÃ©cialiste de la vente en ligne en Tunisie. Nous disposons du plus grand choix et des meilleurs prix en Tunisie. AlGiNET travaille avec les plus grandes marques qui lui font entiÃ¨rement confiance. Par ailleurs AlGiNET a un contrat de Retailer HP au mÃªme titre que la grande distribution (Carrefour, Geant) ainsi quâ€™un contrat avec Dell : Partner Registred Dell, Asus : Gold Partner, Lenovo : Gold Partner. AlGiNET sâ€™est toujours engagÃ© Ã  servir ses clients au mieux et Ã  donner les meilleurs conseils.\r\n\r\nEnfin et c\'est loin d\'Ãªtre nÃ©gligeable, AlGiNET s\'appuie sur une chaÃ®ne logistique optimisÃ©e, afin de permettre d\'offrir des prix dÃ©fiant toute concurrence sur de nombreuses rÃ©fÃ©rences pour des livraisons sur tout le territoire Tunisien. La livraison est gratuite Ã  partir de 300 DT d\'achats.\r\n\r\nConseil avant vente\r\nVous hÃ©sitez dans le choix du produit le plus adaptÃ© Ã  votre besoin ?\r\n\r\nNos conseillers techniques sont Ã  votre disposition pour vous aider Ã  faire le meilleur choix, du lundi au vendredi de 08h Ã  19H et le samedi de 8H Ã  14H, hors jours fÃ©riÃ©s, au 31 31 00 00');

-- --------------------------------------------------------

--
-- Structure de la table `pub`
--

DROP TABLE IF EXISTS `pub`;
CREATE TABLE IF NOT EXISTS `pub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_investisseur` int(11) NOT NULL,
  `nom_ste` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `dateajout` varchar(22) NOT NULL,
  `statut` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pub`
--

INSERT INTO `pub` (`id`, `id_investisseur`, `nom_ste`, `image`, `dateajout`, `statut`) VALUES
(3, 1, 'Dell', 'a:1:{i:0;s:36:\"cc6b447a1abb78ddc8faccfd9b6e5285.png\";}', '2024-04-28', 'Accepter'),
(4, 18, 'hp', 'a:1:{i:0;s:36:\"5b788586c13616cf97c3b5962fd51b2f.png\";}', '2024-04-28', 'Accepter'),
(5, 1, 'msi', 'a:1:{i:0;s:36:\"85cc33297a2e8bfc5526260a7ce17935.png\";}', '2024-04-28', 'Accepter'),
(6, 18, 'mac', 'a:1:{i:0;s:36:\"f6469974fc3d17893082d7a4490eca5a.png\";}', '2024-04-28', 'Accepter'),
(7, 1, 'lenovo', 'a:1:{i:0;s:36:\"50033ec3a166be0557e679c28a5a51d3.png\";}', '2024-04-28', 'Accepter'),
(8, 18, 'huwaei', 'a:1:{i:0;s:36:\"52e7129361211c4b880a72dfb6c9d0a4.png\";}', '2024-04-28', 'Accepter'),
(14, 0, 'testtttttttttttttttt', 'a:1:{i:0;s:36:\"c1780a064617b0f3569eed278e6fba40.png\";}', '2024-05-08', 'En attente'),
(15, 18, 'testghghgjgj', 'a:1:{i:0;s:36:\"acefb1b0a83cb0ceb7cda913c250b021.png\";}', '2024-05-08', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `horodatage` datetime NOT NULL,
  `address` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `nom_prenom`, `email`, `details`, `horodatage`, `address`) VALUES
(22, 'medeb hamdi ', 'medb@gmail.com', 'a:2:{i:11;a:7:{s:2:\"id\";s:2:\"11\";s:5:\"title\";s:11:\"Dell xps 15\";s:5:\"price\";s:4:\"3600\";s:11:\"description\";s:741:\"ProcesseurProcesseur IntelÂ® Coreâ„¢ i7-13700H de 13e gÃ©nÃ©ration (cache 24 Mo, 14 coeurs, jusquâ€˜Ã  5,00 GHz Turbo)SystÃ¨me d\'exploitation(Dell Technologies recommande Windows 11 Professionnel pour les entreprises)Windows 11 Famille, anglais, nÃ©erlandais, franÃ§ais, allemand, italienCarte graphiqueCarte graphique IntelÂ® Arcâ„¢ A370MÃ‰cranÃ‰cran 15,6\" InfinityEdge FHD+ (1 920 x 1 200) non tactile, antiÃ©blouissement, 500 cd/mÂ²MÃ©moire 16 Go, 2 x 8 Go de mÃ©moire DDR5 Ã  4 800 MHzStockageDisque SSD M.2 PCIe NVMe de 512 GoCouleurExtÃ©rieur Platinum Silver, intÃ©rieur noirLogiciels de productivitÃ©Aucune licence Microsoft Office incluse, offre de version dâ€˜essai de 30 jours uniquementLogiciels de sÃ©curitÃ©McAfee+ Premium, 1 an\";s:8:\"category\";s:11:\"pc portable\";s:8:\"quantity\";s:1:\"1\";s:5:\"image\";s:36:\"2be8eceea55d525de22a08bc2999339f.jpg\";}i:10;a:7:{s:2:\"id\";s:2:\"10\";s:5:\"title\";s:24:\" HP Pavilion 15-eh3016nf\";s:5:\"price\";s:4:\"1400\";s:11:\"description\";s:102:\"Windows 11 FamilleAMD Ryzenâ„¢ 5 7530U16 Go RAM512 Go Disque SSD15.6\" FHDCarte graphique AMD Radeonâ„¢\";s:8:\"category\";s:11:\"pc portable\";s:8:\"quantity\";s:1:\"1\";s:5:\"image\";s:36:\"472e19d76b03bce78a8ee71d997f8b05.jpg\";}}', '2024-05-08 02:01:27', 'Gafsa 2151');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
