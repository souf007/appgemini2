-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 12:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easydoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankaccounts`
--

CREATE TABLE `bankaccounts` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `rib` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `agency` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `codecl` varchar(255) NOT NULL,
  `ice` varchar(255) NOT NULL,
  `iff` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `company` varchar(255) NOT NULL,
  `dateadd` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `rs` varchar(255) NOT NULL,
  `logo1` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `capital` varchar(255) DEFAULT NULL,
  `rc` varchar(255) NOT NULL,
  `patente` varchar(255) NOT NULL,
  `iff` varchar(255) NOT NULL,
  `cnss` varchar(255) NOT NULL,
  `ice` varchar(255) NOT NULL,
  `facture` int(11) NOT NULL DEFAULT 1,
  `devis` int(11) NOT NULL DEFAULT 1,
  `avoir` int(11) NOT NULL DEFAULT 1,
  `br` int(11) NOT NULL DEFAULT 1,
  `factureproforma` int(11) NOT NULL DEFAULT 1,
  `bl` int(11) NOT NULL DEFAULT 1,
  `bs` int(11) NOT NULL DEFAULT 1,
  `bc` int(11) NOT NULL DEFAULT 1,
  `bre` int(11) NOT NULL DEFAULT 1,
  `trash` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailsdocuments`
--

CREATE TABLE `detailsdocuments` (
  `id` int(11) NOT NULL,
  `doc` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `uprice` double NOT NULL,
  `tva` int(11) NOT NULL,
  `discounttype` varchar(255) NOT NULL,
  `discount` double NOT NULL,
  `tprice` double NOT NULL,
  `client` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `typedoc` varchar(255) NOT NULL,
  `dateadd` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `state` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `client` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `note` text NOT NULL,
  `modepayment` text NOT NULL,
  `conditions` text NOT NULL,
  `abovetable` text NOT NULL,
  `correctdoc` varchar(255) NOT NULL,
  `attachments` text NOT NULL,
  `user` int(11) NOT NULL,
  `dateadd` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infodocs`
--

CREATE TABLE `infodocs` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `modepayment` text NOT NULL,
  `conditions` text NOT NULL,
  `abovetable` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `facture` varchar(10) NOT NULL,
  `avoir` varchar(10) NOT NULL,
  `caissein` varchar(10) NOT NULL,
  `caisseout` varchar(10) NOT NULL,
  `unpaid` varchar(10) NOT NULL,
  `inwaiting` varchar(10) NOT NULL,
  `outwaiting` varchar(10) NOT NULL,
  `rcaissein` varchar(10) NOT NULL,
  `rcaisseout` varchar(10) NOT NULL,
  `remis` varchar(10) NOT NULL,
  `rremis` varchar(10) NOT NULL,
  `incach` varchar(10) NOT NULL,
  `outcach` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `facture`, `avoir`, `caissein`, `caisseout`, `unpaid`, `inwaiting`, `outwaiting`, `rcaissein`, `rcaisseout`, `remis`, `rremis`, `incach`, `outcach`) VALUES
(1, 'on-1', 'on-1', 'on-1', 'on-1', 'on-0', 'off-0', 'off-0', 'on-1', 'on-1', 'on-undefin', 'off-0', 'off-0', 'off-0');

-- --------------------------------------------------------

--
-- Table structure for table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `nbrows` int(11) NOT NULL,
  `rowcolor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `doc` int(11) NOT NULL,
  `worker` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `nature` varchar(255) NOT NULL,
  `modepayment` varchar(255) NOT NULL,
  `imputation` varchar(255) NOT NULL,
  `rib` int(11) NOT NULL,
  `invoiced` varchar(255) NOT NULL DEFAULT 'Oui',
  `paid` int(11) NOT NULL,
  `tva` double NOT NULL,
  `remis` int(11) NOT NULL,
  `dateremis` varchar(255) NOT NULL,
  `nremise` varchar(255) NOT NULL,
  `company` int(11) NOT NULL,
  `note` text NOT NULL,
  `typedoc` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `dateadd` varchar(255) NOT NULL,
  `datedue` varchar(255) NOT NULL,
  `datepaid` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `attachments` text NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `store` varchar(255) NOT NULL,
  `oneprice` int(11) NOT NULL,
  `onlyproduct` int(11) NOT NULL,
  `onlyservice` int(11) NOT NULL,
  `useproject` int(11) NOT NULL,
  `dategap` int(11) NOT NULL,
  `inventaire` int(11) NOT NULL,
  `defaultstate` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `cover`, `store`, `oneprice`, `onlyproduct`, `onlyservice`, `useproject`, `dategap`, `inventaire`, `defaultstate`, `currency`) VALUES
(1, 'logo.png', 'bg.jpg', 'EasyBM', 2, 1, 1, 0, 0, 0, 'Nouvelle', 'DH');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `codefo` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `respname` varchar(255) NOT NULL,
  `respphone` varchar(255) NOT NULL,
  `respemail` varchar(255) NOT NULL,
  `respfax` varchar(255) NOT NULL,
  `ice` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dateadd` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `company` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tvas`
--

CREATE TABLE `tvas` (
  `id` int(11) NOT NULL,
  `tva` double NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tvas`
--

INSERT INTO `tvas` (`id`, `tva`, `trash`) VALUES
(2, 20, 1),
(3, 7, 1),
(4, 10, 1),
(5, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `roles` text NOT NULL,
  `superadmin` int(11) NOT NULL,
  `defaultstate` varchar(255) NOT NULL,
  `depots` text NOT NULL,
  `companies` text NOT NULL,
  `projects` text NOT NULL,
  `datesignup` varchar(255) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `picture`, `email`, `password`, `phone`, `type`, `roles`, `superadmin`, `defaultstate`, `depots`, `companies`, `projects`, `datesignup`, `trash`) VALUES
(4, 'SuperAdmin', 'avatar.png', 'superadmin', 'superadmin', '0709999589', 'moderator', 'Consulter Tableau de bord,Consulter Trésorerie,Ajouter Trésorerie,Modifier Trésorerie,Supprimer Trésorerie,Exporter Trésorerie,Consulter Factures,Ajouter Factures,Modifier Factures,Supprimer Factures,Exporter Factures,Consulter Devis,Ajouter Devis,Modifier Devis,Supprimer Devis,Exporter Devis,Consulter Factures proforma,Ajouter Factures proforma,Modifier Factures proforma,Supprimer Factures proforma,Exporter Factures proforma,Consulter Bons de livraison,Ajouter Bons de livraison,Modifier Bons de livraison,Supprimer Bons de livraison,Exporter Bons de livraison,Consulter Bons de sortie,Ajouter Bons de sortie,Modifier Bons de sortie,Supprimer Bons de sortie,Exporter Bons de sortie,Consulter Bons de retour,Ajouter Bons de retour,Modifier Bons de retour,Supprimer Bons de retour,Exporter Bons de retour,Consulter Factures avoir,Ajouter Factures avoir,Modifier Factures avoir,Supprimer Factures avoir,Exporter Factures avoir,Consulter Clients,Ajouter Clients,Modifier Clients,Supprimer Clients,Exporter Clients,CA Clients,Consulter Bons de commande,Ajouter Bons de commande,Modifier Bons de commande,Supprimer Bons de commande,Exporter Bons de commande,Consulter Bons de réception,Ajouter Bons de réception,Modifier Bons de réception,Supprimer Bons de réception,Exporter Bons de réception,Consulter Fournisseurs,Ajouter Fournisseurs,Modifier Fournisseurs,Supprimer Fournisseurs,Exporter Fournisseurs,CA Fournisseurs,Consulter Sociétés,Ajouter Sociétés,Modifier Sociétés,Supprimer Sociétés,Exporter Sociétés,CA Sociétés,Consulter Utilisateurs,Ajouter Utilisateurs,Modifier Utilisateurs,Supprimer Utilisateurs,Consulter TVA,Ajouter TVA,Modifier TVA,Supprimer TVA,Consulter Formation,Consultation des notifications,Réglage des notifications,Modification date opération,Transformation / Dupplication documents,Modification statut de paiement,Suppression historique de paiement,Télécharger Backup', 1, 'Livrée', '0', '0,1', '0', '1678533547', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `fullname` (`fullname`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs` (`rs`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `detailsdocuments`
--
ALTER TABLE `detailsdocuments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `type` (`type`),
  ADD KEY `client` (`client`),
  ADD KEY `supplier` (`supplier`);

--
-- Indexes for table `infodocs`
--
ALTER TABLE `infodocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `respphone` (`respphone`);

--
-- Indexes for table `tvas`
--
ALTER TABLE `tvas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailsdocuments`
--
ALTER TABLE `detailsdocuments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infodocs`
--
ALTER TABLE `infodocs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tvas`
--
ALTER TABLE `tvas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
