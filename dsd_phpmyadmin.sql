-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 14 Avril 2017 à 18:25
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dsd`
--

-- --------------------------------------------------------

--
-- Structure de la table `associations`
--

CREATE TABLE `associations` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `is_considered` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `associations`
--

INSERT INTO `associations` (`id`, `category_id`, `product_id`, `is_considered`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `assoc_carriers_inputs`
--

CREATE TABLE `assoc_carriers_inputs` (
  `id` int(11) NOT NULL,
  `carrier_id` int(11) NOT NULL,
  `input_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `assoc_carriers_inputs`
--

INSERT INTO `assoc_carriers_inputs` (`id`, `carrier_id`, `input_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `assoc_carriers_rv`
--

CREATE TABLE `assoc_carriers_rv` (
  `id` int(11) NOT NULL,
  `carrier_id` int(11) NOT NULL,
  `removalvoucher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `assoc_carriers_rv`
--

INSERT INTO `assoc_carriers_rv` (`id`, `carrier_id`, `removalvoucher_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `carriers`
--

CREATE TABLE `carriers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `matriculeFiscale` varchar(255) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `text` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `carriers`
--

INSERT INTO `carriers` (`id`, `name`, `adresse`, `matriculeFiscale`, `tel`, `text`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'azaaaaa', NULL, '', '', '', '2017-04-14 14:49:56', '2017-04-14 14:49:56', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `pictogramme_path` varchar(255) DEFAULT NULL,
  `description_categ` longtext,
  `doc_path` varchar(255) DEFAULT NULL,
  `doc_path2` varchar(255) DEFAULT NULL,
  `doc_path3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`, `modified`, `created_by`, `modified_by`, `pictogramme_path`, `description_categ`, `doc_path`, `doc_path2`, `doc_path3`) VALUES
(1, 'Categ 1', '2017-04-14 14:50:17', '2017-04-14 14:50:17', 1, 1, NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `matriculeFiscale` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '1',
  `adress` varchar(45) DEFAULT NULL,
  `email1` varchar(45) DEFAULT NULL,
  `email2` varchar(45) DEFAULT NULL,
  `email3` varchar(45) DEFAULT NULL,
  `tel1` varchar(45) DEFAULT NULL,
  `tel2` varchar(45) DEFAULT NULL,
  `tel3` varchar(45) DEFAULT NULL,
  `fax1` varchar(45) DEFAULT NULL,
  `fax2` varchar(45) DEFAULT NULL,
  `fax3` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `entrepositaire` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `name`, `matriculeFiscale`, `code`, `approved`, `adress`, `email1`, `email2`, `email3`, `tel1`, `tel2`, `tel3`, `fax1`, `fax2`, `fax3`, `created`, `modified`, `created_by`, `modified_by`, `entrepositaire`) VALUES
(1, 'azeaze', '', '', 1, '', '', '', '', '', '', '', '', '', '', '2017-04-14 14:49:43', '2017-04-14 14:49:43', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `dependencies`
--

CREATE TABLE `dependencies` (
  `id` int(11) NOT NULL,
  `id_category1` int(11) NOT NULL,
  `id_category2` int(11) NOT NULL,
  `quota` double NOT NULL DEFAULT '0',
  `tolerance` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `dependencies`
--

INSERT INTO `dependencies` (`id`, `id_category1`, `id_category2`, `quota`, `tolerance`, `created_by`, `modified_by`, `created`, `modified`) VALUES
(1, 1, 1, 5000, 0, 1, NULL, '2017-04-14 14:50:17', '2017-04-14 14:50:17');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `path` varchar(256) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `number` varchar(45) NOT NULL,
  `startDate` date DEFAULT NULL,
  `canceled` tinyint(1) DEFAULT '0',
  `client_id` int(11) NOT NULL,
  `input_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `statut` int(11) DEFAULT '0',
  `provider_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `files`
--

INSERT INTO `files` (`id`, `number`, `startDate`, `canceled`, `client_id`, `input_id`, `created`, `modified`, `statut`, `provider_id`, `created_by`, `modified_by`) VALUES
(1, 'D20170414001', '2017-04-14', 0, 1, 1, '2017-04-14 14:50:51', '2017-04-14 14:51:21', 1, 1, 1, 1),
(2, 'D20170414002', '2017-04-14', 0, 1, 2, '2017-04-14 15:36:53', '2017-04-14 16:01:39', 2, 1, 1, 1),
(3, 'D20170414003', '2017-04-14', 0, 1, NULL, '2017-04-14 15:56:45', '2017-04-14 15:56:45', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inputs`
--

CREATE TABLE `inputs` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `inputs`
--

INSERT INTO `inputs` (`id`, `date`, `file_id`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, '2017-04-14 14:51:21', 1, '2017-04-14 14:51:21', '2017-04-14 14:51:21', 1, 1),
(2, '2017-04-14 15:37:15', 2, '2017-04-14 15:37:15', '2017-04-14 15:37:15', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `lots`
--

CREATE TABLE `lots` (
  `id` int(11) NOT NULL,
  `number` varchar(45) NOT NULL,
  `deadline` date DEFAULT NULL,
  `deadlineConsumption` date DEFAULT NULL,
  `expectedQte` double DEFAULT '0',
  `actualQte` double DEFAULT '-1',
  `product_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `input_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `remainedQte` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `referenceProvider` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lots`
--

INSERT INTO `lots` (`id`, `number`, `deadline`, `deadlineConsumption`, `expectedQte`, `actualQte`, `product_id`, `client_id`, `zone_id`, `input_id`, `file_id`, `created`, `modified`, `remainedQte`, `created_by`, `modified_by`, `referenceProvider`) VALUES
(1, 'L20170414001', '2017-04-14', '2018-04-14', 1000, 1000, 1, 1, 1, 1, 1, '2017-04-14 14:51:07', '2017-04-14 15:35:48', 0, 1, 1, 'Ref'),
(2, 'L20170414002', '2017-04-14', '2018-04-14', 2000, 2000, 1, 1, 1, 2, 2, '2017-04-14 15:37:04', '2017-04-14 16:01:22', 0, 1, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `movements`
--

CREATE TABLE `movements` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `qte` double DEFAULT NULL,
  `before_qte` double DEFAULT NULL,
  `after_qte` double DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `lot_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `movements`
--

INSERT INTO `movements` (`id`, `type`, `date`, `qte`, `before_qte`, `after_qte`, `stock_id`, `created`, `modified`, `lot_id`, `created_by`, `modified_by`) VALUES
(1, 0, '2017-04-14 14:51:21', 1000, 0, 1000, 1, '2017-04-14 14:51:21', '2017-04-14 14:51:21', 1, 1, NULL),
(2, 0, '2017-04-14 15:37:16', 2000, 1000, 3000, 1, '2017-04-14 15:37:16', '2017-04-14 15:37:16', 2, 1, NULL),
(3, 2, '2017-04-14 15:56:07', 100, 3000, 2900, 1, '2017-04-14 15:56:07', '2017-04-14 15:56:07', 2, 1, NULL),
(4, 2, '2017-04-14 15:56:07', 1000, 2900, 1900, 1, '2017-04-14 15:56:07', '2017-04-14 15:56:07', 2, 1, NULL),
(5, 2, '2017-04-14 15:58:18', 100, 1900, 1800, 1, '2017-04-14 15:58:18', '2017-04-14 15:58:18', 2, 1, NULL),
(6, 2, '2017-04-14 16:01:39', 800, 1800, 1000, 1, '2017-04-14 16:01:39', '2017-04-14 16:01:39', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `outputs`
--

CREATE TABLE `outputs` (
  `id` int(11) NOT NULL,
  `qte` double DEFAULT NULL,
  `lot_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `outputSet_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `outputs`
--

INSERT INTO `outputs` (`id`, `qte`, `lot_id`, `file_id`, `outputSet_id`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 1000, 1, 1, 1, '2017-04-14 15:35:48', '2017-04-14 15:35:48', 1, 1),
(2, 100, 2, 2, 2, '2017-04-14 15:44:26', '2017-04-14 15:44:26', 1, 1),
(3, 1000, 2, 2, 3, '2017-04-14 15:50:23', '2017-04-14 15:50:23', 1, 1),
(4, 100, 2, 2, 4, '2017-04-14 15:57:09', '2017-04-14 15:57:09', 1, 1),
(5, 800, 2, 2, 5, '2017-04-14 16:01:22', '2017-04-14 16:01:22', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `output_sets`
--

CREATE TABLE `output_sets` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `statut` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removalVoucher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `output_sets`
--

INSERT INTO `output_sets` (`id`, `file_id`, `created`, `modified`, `statut`, `created_by`, `modified_by`, `removalVoucher_id`) VALUES
(1, 1, '2017-04-14 15:35:38', '2017-04-14 15:35:38', 0, 1, 1, NULL),
(2, 2, '2017-04-14 15:44:17', '2017-04-14 15:56:07', 1, 1, 1, 1),
(3, 2, '2017-04-14 15:50:14', '2017-04-14 15:56:07', 1, 1, 1, 1),
(4, 2, '2017-04-14 15:56:59', '2017-04-14 15:58:18', 1, 1, 1, 2),
(5, 2, '2017-04-14 16:01:12', '2017-04-14 16:01:39', 1, 1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `packagings`
--

CREATE TABLE `packagings` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `packagings`
--

INSERT INTO `packagings` (`id`, `name`, `created`, `modified`, `created_by`, `modified_by`, `type`, `weight`) VALUES
(1, 'azeza', '2017-04-14 14:49:37', '2017-04-14 14:49:37', 1, 1, 'aze', 20);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `productCode` varchar(20) NOT NULL,
  `ngpCode` varchar(20) NOT NULL,
  `barCode` varchar(20) NOT NULL,
  `subjectToQuota` tinyint(1) NOT NULL DEFAULT '0',
  `quota` double DEFAULT NULL,
  `tolerance` double DEFAULT '0',
  `approved` tinyint(1) DEFAULT '1',
  `packaging_id` int(11) DEFAULT NULL,
  `unitQte` double DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `productState_id` int(11) NOT NULL,
  `pic_path` varchar(255) DEFAULT NULL,
  `description_product` longtext,
  `doc_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `name`, `productCode`, `ngpCode`, `barCode`, `subjectToQuota`, `quota`, `tolerance`, `approved`, `packaging_id`, `unitQte`, `unit`, `stock_id`, `created`, `modified`, `zone_id`, `created_by`, `modified_by`, `productState_id`, `pic_path`, `description_product`, `doc_path`) VALUES
(1, 'Produit 1', 'P0001', 'azeaz', 'azeaez', 1, NULL, 0, 1, 1, NULL, 'Kg', NULL, '2017-04-14 14:50:39', '2017-04-14 14:50:39', 1, 1, 1, 1, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `productstates`
--

CREATE TABLE `productstates` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `productstates`
--

INSERT INTO `productstates` (`id`, `name`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'azeaze', '2017-04-14 14:49:26', '2017-04-14 14:49:26', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `adress` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `providers`
--

INSERT INTO `providers` (`id`, `name`, `adress`, `email`, `website`, `tel`, `fax`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'azeazqs', '', '', '', '', '', '2017-04-14 14:49:49', '2017-04-14 14:49:49', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `removalvouchers`
--

CREATE TABLE `removalvouchers` (
  `id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `number` varchar(45) NOT NULL,
  `entrepositaire_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `RemovalVoucherscol` date DEFAULT NULL,
  `date_rv` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `removalvouchers`
--

INSERT INTO `removalvouchers` (`id`, `created`, `modified`, `created_by`, `modified_by`, `number`, `entrepositaire_id`, `client_id`, `RemovalVoucherscol`, `date_rv`) VALUES
(1, '2017-04-14 15:56:06', '2017-04-14 15:56:06', 1, 1, 'BAE20170414001', 1, 1, NULL, '2017-04-14'),
(2, '2017-04-14 15:58:18', '2017-04-14 15:58:18', 1, 1, 'BAE20170414002', 1, 1, NULL, '2017-04-14'),
(3, '2017-04-14 16:01:39', '2017-04-14 16:01:39', 1, 1, 'BAE20170414003', 1, 1, NULL, '2017-04-14');

-- --------------------------------------------------------

--
-- Structure de la table `required_docs`
--

CREATE TABLE `required_docs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `unitQte` double DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `stocks`
--

INSERT INTO `stocks` (`id`, `amount`, `unitQte`, `unit`, `product_id`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 1000, NULL, 'Kg', 1, '2017-04-14 14:50:39', '2017-04-14 16:01:39', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `enable` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `products` int(11) DEFAULT '0',
  `categories` int(11) DEFAULT '0',
  `providers` int(11) DEFAULT '0',
  `stocks` int(11) DEFAULT '0',
  `movements` int(11) DEFAULT '0',
  `clients` int(11) DEFAULT '0',
  `lots` int(11) DEFAULT '0',
  `zones` int(11) DEFAULT '0',
  `files` int(11) DEFAULT '0',
  `inputs` int(11) DEFAULT '0',
  `documents` int(11) DEFAULT '0',
  `outputSets` int(11) DEFAULT '0',
  `required_docs` int(11) DEFAULT '0',
  `outputs` int(11) DEFAULT '0',
  `users` int(11) DEFAULT '0',
  `dependencies` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `enable`, `created`, `modified`, `products`, `categories`, `providers`, `stocks`, `movements`, `clients`, `lots`, `zones`, `files`, `inputs`, `documents`, `outputSets`, `required_docs`, `outputs`, `users`, `dependencies`, `created_by`, `modified_by`) VALUES
(1, 'superadmin', '$2y$10$KWeRwN/4b/5Le0pq3c5fq.IDTnQ1KHOr7m6poeTf5Lu9dkvi7GfUq', 'admin', 1, '2016-06-03 13:05:01', '2016-06-03 13:05:01', 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 1, 1),
(4, 'douanier', '$2y$10$.UppJuZpC1GrL3.bX2XCiOsZu80F0DpGG2obq47IyjSEfx6bh8Ore', 'douanier', 1, '2016-09-14 08:28:01', '2016-09-14 08:28:01', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

CREATE TABLE `zones` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `subjectToQuota` tinyint(1) DEFAULT NULL,
  `quota` double NOT NULL DEFAULT '0',
  `tolerance` double DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `zones`
--

INSERT INTO `zones` (`id`, `name`, `subjectToQuota`, `quota`, `tolerance`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Zone A', NULL, 0, 0, '2017-04-14 14:50:02', '2017-04-14 14:50:02', 1, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `associations`
--
ALTER TABLE `associations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_associations_products_idx` (`product_id`),
  ADD KEY `FK_associations_categories_idx` (`category_id`);

--
-- Index pour la table `assoc_carriers_inputs`
--
ALTER TABLE `assoc_carriers_inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_assoc_c_ops_carrier_idx` (`carrier_id`),
  ADD KEY `FK_assoc_c_input_input_idx` (`input_id`);

--
-- Index pour la table `assoc_carriers_rv`
--
ALTER TABLE `assoc_carriers_rv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_assoc_carrier_idx` (`carrier_id`),
  ADD KEY `FK_assoc_rv_idx` (`removalvoucher_id`);

--
-- Index pour la table `carriers`
--
ALTER TABLE `carriers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_carriers_users_idx` (`created_by`),
  ADD KEY `FK_carriers_users_m_idx` (`modified_by`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `FK_categories_users_idx` (`created_by`),
  ADD KEY `FK_categories_users_m_idx` (`modified_by`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_clients_users_idx` (`created_by`),
  ADD KEY `FK_clients_users_m_idx` (`modified_by`);

--
-- Index pour la table `dependencies`
--
ALTER TABLE `dependencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_dependencies_categories_idx` (`id_category1`),
  ADD KEY `FK_dependencies_categories_id2_idx` (`id_category2`),
  ADD KEY `FK_dependencies_users_idx` (`created_by`),
  ADD KEY `FK_dependencies_users_m_idx` (`modified_by`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_documents_files_idx` (`file_id`),
  ADD KEY `FK_documents_users_idx` (`created_by`),
  ADD KEY `FK_documents_users_m_idx` (`modified_by`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number_UNIQUE` (`number`),
  ADD KEY `FK_files_clients_idx` (`client_id`),
  ADD KEY `FK_files_inputs_idx` (`input_id`),
  ADD KEY `FK_files_providers_idx` (`provider_id`),
  ADD KEY `FK_files_users_idx` (`created_by`),
  ADD KEY `FK_files_users_m_idx` (`modified_by`);

--
-- Index pour la table `inputs`
--
ALTER TABLE `inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_inputs_files_idx` (`file_id`),
  ADD KEY `FK_inputs_users_idx` (`created_by`),
  ADD KEY `FK_inputs_users_m_idx` (`modified_by`);

--
-- Index pour la table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number_UNIQUE` (`number`),
  ADD KEY `FK_lots_products_idx` (`product_id`),
  ADD KEY `FK_lots_clients_idx` (`client_id`),
  ADD KEY `FK_lots_zones_idx` (`zone_id`),
  ADD KEY `FK_lots_inputs_idx` (`input_id`),
  ADD KEY `FK_lots_files_idx` (`file_id`),
  ADD KEY `FK_lots_users_idx` (`created_by`),
  ADD KEY `FK_lots_users_m_idx` (`modified_by`);

--
-- Index pour la table `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_movements_stocks_idx` (`stock_id`),
  ADD KEY `FK_movements_lots_idx` (`lot_id`),
  ADD KEY `FK_movements_users_idx` (`created_by`),
  ADD KEY `FK_movements_users_idx1` (`modified_by`);

--
-- Index pour la table `outputs`
--
ALTER TABLE `outputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_outputs_lots_idx` (`lot_id`),
  ADD KEY `FK_outputs_files_idx` (`file_id`),
  ADD KEY `FK_outputs_outputSets_idx` (`outputSet_id`),
  ADD KEY `FK_outputs_users_idx` (`created_by`),
  ADD KEY `FK_outputs_users_idx1` (`modified_by`);

--
-- Index pour la table `output_sets`
--
ALTER TABLE `output_sets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_outpuSets_files_idx` (`file_id`),
  ADD KEY `FK_outputSets_users_idx` (`created_by`),
  ADD KEY `FK_outputSets_users_m_idx` (`modified_by`),
  ADD KEY `FK_outputSets_removalVoucher_idx` (`removalVoucher_id`);

--
-- Index pour la table `packagings`
--
ALTER TABLE `packagings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_packaging_users_idx` (`created_by`),
  ADD KEY `FK_packaging_users_m_idx` (`modified_by`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_products_stocks_idx` (`stock_id`),
  ADD KEY `FK_products_zones_idx` (`zone_id`),
  ADD KEY `FK_products_users_idx` (`created_by`),
  ADD KEY `FK_products_users_m_idx` (`modified_by`),
  ADD KEY `FK_products_productStates_idx` (`productState_id`),
  ADD KEY `FK_products_packagings_idx` (`packaging_id`);

--
-- Index pour la table `productstates`
--
ALTER TABLE `productstates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_productStates_users_idx` (`created_by`),
  ADD KEY `FK_productStates_users_m_idx` (`modified_by`);

--
-- Index pour la table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_providers_users_idx` (`created_by`),
  ADD KEY `FK_providers_users_m_idx` (`modified_by`);

--
-- Index pour la table `removalvouchers`
--
ALTER TABLE `removalvouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_RemovalVouchers_users_idx` (`created_by`),
  ADD KEY `FK_RemovalVouchers_users_m_idx` (`modified_by`),
  ADD KEY `FK_RemovalVouchers_clients1_idx` (`entrepositaire_id`),
  ADD KEY `FK_RemovalVouchers_clients2_idx` (`client_id`);

--
-- Index pour la table `required_docs`
--
ALTER TABLE `required_docs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `FK_requiredDocs_users_idx` (`created_by`),
  ADD KEY `FK_requiredDocs_users_m_idx` (`modified_by`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_stocks_products_idx` (`product_id`),
  ADD KEY `FK_stocks_users_idx` (`created_by`),
  ADD KEY `FK_stocks_users_m_idx` (`modified_by`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_users1_idx` (`created_by`),
  ADD KEY `FK_users_users2_idx` (`modified_by`);

--
-- Index pour la table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_zones_users_idx` (`created_by`),
  ADD KEY `FK_zones_users_m_idx` (`modified_by`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `associations`
--
ALTER TABLE `associations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `assoc_carriers_inputs`
--
ALTER TABLE `assoc_carriers_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `assoc_carriers_rv`
--
ALTER TABLE `assoc_carriers_rv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `carriers`
--
ALTER TABLE `carriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `dependencies`
--
ALTER TABLE `dependencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `outputs`
--
ALTER TABLE `outputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `output_sets`
--
ALTER TABLE `output_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `packagings`
--
ALTER TABLE `packagings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `productstates`
--
ALTER TABLE `productstates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `removalvouchers`
--
ALTER TABLE `removalvouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `required_docs`
--
ALTER TABLE `required_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `associations`
--
ALTER TABLE `associations`
  ADD CONSTRAINT `FK_associations_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_associations_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `assoc_carriers_inputs`
--
ALTER TABLE `assoc_carriers_inputs`
  ADD CONSTRAINT `FK_assoc_c_input_carrier` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_assoc_c_input_input` FOREIGN KEY (`input_id`) REFERENCES `inputs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `assoc_carriers_rv`
--
ALTER TABLE `assoc_carriers_rv`
  ADD CONSTRAINT `FK_assoc_carrier` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_assoc_rv` FOREIGN KEY (`removalvoucher_id`) REFERENCES `removalvouchers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `carriers`
--
ALTER TABLE `carriers`
  ADD CONSTRAINT `FK_carriers_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_carriers_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_categories_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_categories_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `FK_clients_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_clients_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `dependencies`
--
ALTER TABLE `dependencies`
  ADD CONSTRAINT `FK_dependencies_categories_id1` FOREIGN KEY (`id_category1`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_dependencies_categories_id2` FOREIGN KEY (`id_category2`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_dependencies_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_dependencies_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `FK_documents_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_documents_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_documents_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `FK_files_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_files_inputs` FOREIGN KEY (`input_id`) REFERENCES `inputs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_files_providers` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `FK_files_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_files_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `inputs`
--
ALTER TABLE `inputs`
  ADD CONSTRAINT `FK_inputs_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_inputs_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_inputs_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `FK_lots_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_lots_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_lots_inputs` FOREIGN KEY (`input_id`) REFERENCES `inputs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_lots_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_lots_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_lots_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_lots_zones` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `FK_movements_lots` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_movements_stocks` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_movements_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `outputs`
--
ALTER TABLE `outputs`
  ADD CONSTRAINT `FK_outputs_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_outputs_lots` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_outputs_outputSets` FOREIGN KEY (`outputSet_id`) REFERENCES `output_sets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_outputs_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_outputs_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `output_sets`
--
ALTER TABLE `output_sets`
  ADD CONSTRAINT `FK_outpuSets_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_outputSets_removalVouchers` FOREIGN KEY (`removalVoucher_id`) REFERENCES `removalvouchers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_outputSets_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_outputSets_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `packagings`
--
ALTER TABLE `packagings`
  ADD CONSTRAINT `FK_packagings_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_packagings_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products_packagings` FOREIGN KEY (`packaging_id`) REFERENCES `packagings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_products_productStates` FOREIGN KEY (`productState_id`) REFERENCES `productstates` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_products_stocks` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_products_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_products_zones` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `productstates`
--
ALTER TABLE `productstates`
  ADD CONSTRAINT `FK_productStates_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_productStates_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `FK_providers_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_providers_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `removalvouchers`
--
ALTER TABLE `removalvouchers`
  ADD CONSTRAINT `FK_RemovalVouchers_clients1` FOREIGN KEY (`entrepositaire_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RemovalVouchers_clients2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RemovalVouchers_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_RemovalVouchers_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `required_docs`
--
ALTER TABLE `required_docs`
  ADD CONSTRAINT `FK_requiredDocs_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_requiredDocs_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `FK_stocks_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_stocks_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_stocks_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_users1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `FK_users_users2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `zones`
--
ALTER TABLE `zones`
  ADD CONSTRAINT `FK_zones_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_zones_users_m` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
