-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 11 mai 2026 à 09:58
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
-- Base de données : `s2.sae.panier`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `num_carte_fidelite` varchar(20) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `est_bloque` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `adresse`, `email`, `telephone`, `num_carte_fidelite`, `date_creation`, `est_bloque`) VALUES
(1, 'Dubois', 'Marie', '15 rue de la République, 75001 Paris', 'marie.dubois@gmail.com', '699999999', 'A3K9L2', '2026-02-03 14:53:00', 0),
(2, 'Martin', 'Pierre', '42 avenue des Pommes, 75008 Paris', 'pierre.martin@outlook.fr', '623456789', 'B7M4N1', '2026-02-03 14:53:00', 0),
(3, 'Bernard', 'Sophie', '8 boulevard Victor Hugo, 69003 Lyon', 'sophie.bernard@yahoo.fr', '634567890', 'C2P8Q5', '2026-02-03 14:53:00', 1),
(4, 'Petit', 'Lucas', '23 rue Gambetta, 33000 Bordeaux', 'lucas.petit@hotmail.fr', '645678901', 'D6R3T9', '2026-02-03 14:53:00', 0),
(5, 'Robert', 'Emma', '56 place de la Mairie, 44000 Nantes', 'emma.robert@free.fr', '656789012', 'E1S7U4', '2026-02-03 14:53:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date_retrait` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `paniers`
--

INSERT INTO `paniers` (`id`, `type`, `prix`, `description`, `date_retrait`) VALUES
(1, '1p', 15.50, 'Tomates (500g), Carottes (500g), Pommes (4 pcs), Bananes (3 pcs), Salade (1 pièce)', '2026-02-06'),
(2, '1p', 14.90, 'Courgettes (500g), Poivrons (2 pcs), Oranges (4 pcs), Poires (3 pcs), Épinards (250g)', '2026-02-13'),
(3, '1p', 16.20, 'Concombre (1 pc), Aubergine (1 pc), Kiwis (4 pcs), Pommes (3 pcs), Champignons (200g), Persil (1 botte)', '2026-02-20'),
(4, '1p', 15.80, 'Poireaux (2 pcs), Navets (500g), Clémentines (6 pcs), Poires (2 pcs), Mâche (100g)', '2026-02-27'),
(5, '1p', 14.50, 'Betteraves (500g), Céleri (1 branche), Bananes (4 pcs), Raisin (250g), Roquette (100g)', '2026-03-06'),
(6, '2p', 28.00, 'Tomates (1kg), Carottes (1kg), Pommes (8 pcs), Bananes (6 pcs), Salade (2 pièces), Concombre (1 pc), Fraises (250g)', '2026-02-06');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `type_panier` varchar(10) NOT NULL,
  `date_panier` date NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_retrait` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `nom`, `prenom`, `type_panier`, `date_panier`, `date_commande`, `date_retrait`) VALUES
(1, 'Dubois', 'Marie', '1p', '2026-02-06', '2026-02-03 18:09:30', '2026-02-06'),
(2, 'Petit', 'Lucas', '2p', '2026-02-06', '2026-02-03 18:10:03', '2026-02-06'),
(3, 'Dubois', 'Marie', '1p', '2026-02-13', '2026-02-11 12:00:00', '2026-02-13'),
(4, 'Petit', 'Lucas', '1p', '2026-02-13', '2026-02-11 15:00:00', '2026-02-13'),
(5, 'Robert', 'Emma', '2p', '2026-02-06', '2026-02-03 14:10:03', '2026-02-03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `num_carte_fidelite` (`num_carte_fidelite`);

--
-- Index pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
