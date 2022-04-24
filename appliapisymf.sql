-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 24 avr. 2022 à 18:37
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appliapisymf`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220201181746', '2022-02-01 19:18:18', 53),
('DoctrineMigrations\\Version20220201190555', '2022-02-01 20:06:05', 56),
('DoctrineMigrations\\Version20220422124750', '2022-04-22 15:52:18', 697),
('DoctrineMigrations\\Version20220422124943', '2022-04-22 15:52:18', 94),
('DoctrineMigrations\\Version20220422125627', '2022-04-22 15:52:18', 4);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `nom`) VALUES
(1, 'fiat'),
(3, 'renault'),
(5, 'Peugeot'),
(7, 'ford'),
(8, 'audi'),
(9, 'dacia');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` datetime DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `voiture_id` int(11) DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `prenom`, `date_naiss`, `ville_id`, `voiture_id`, `tel`, `email`, `user_id`) VALUES
(13, 'Hugo', 'Victor', '1972-01-14 18:43:59', 2, 1, '0612345678', 'victor.hugo@hotmail.fr', 2),
(14, 'Valjean', 'Jean', '1972-01-14 18:43:59', 1, 1, '0612345678', 'valjean@hotmail.com', 7),
(15, 'Macron', 'Brigitte', '1972-01-14 18:43:59', 1, 6, '0676543217', 'mac.brig@caramail.fr', 8);

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `ville_dep_id` int(11) DEFAULT NULL,
  `ville_arr_id` int(11) DEFAULT NULL,
  `nb_kms` int(11) DEFAULT NULL,
  `date_trajet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id`, `ville_dep_id`, `ville_arr_id`, `nb_kms`, `date_trajet`) VALUES
(1, 1, 2, 50, '2022-04-22 18:37:44'),
(2, 2, 1, 50, '2022-04-23 18:37:44');

-- --------------------------------------------------------

--
-- Structure de la table `trajet_personne`
--

CREATE TABLE `trajet_personne` (
  `trajet_id` int(11) NOT NULL,
  `personne_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trajet_personne`
--

INSERT INTO `trajet_personne` (`trajet_id`, `personne_id`) VALUES
(1, 13),
(2, 15);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `api_token`) VALUES
(2, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$gkD8xuwl/vE00t/.fSyo.ODkMusQgYE2lGmcDLwzxOMCaV0mahpje', '100972'),
(7, 'user', '[\"ROLE_USER\"]', '$2y$13$H0B1P3HKYizTUheP/P1gaegJ.AuLea7j2pnkU0aZ2Kqw28prT1CEO', '108972'),
(8, 'roro', '[\"ROLE_USER\"]', '$2y$13$oqBXqBenTlNWXqa4mc580usyPDv9gkBWoiBBKkZkHGP4N00RI77zy', '208972');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepostal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `codepostal`) VALUES
(1, 'Pontivy', 56300),
(2, 'Vannes', 56000);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `marque_id` int(11) NOT NULL,
  `nb_places` int(11) NOT NULL,
  `modele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `marque_id`, `nb_places`, `modele`) VALUES
(1, 1, 3, 'Panda'),
(3, 9, 4, 'Sandero'),
(4, 7, 4, 'escort'),
(5, 5, 4, '308'),
(6, 3, 6, 'Espace');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_FCEC9EFA76ED395` (`user_id`),
  ADD KEY `IDX_FCEC9EFA73F0036` (`ville_id`),
  ADD KEY `IDX_FCEC9EF181A8BA` (`voiture_id`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2B5BA98C97A9E2C6` (`ville_dep_id`),
  ADD KEY `IDX_2B5BA98CBFADF06C` (`ville_arr_id`);

--
-- Index pour la table `trajet_personne`
--
ALTER TABLE `trajet_personne`
  ADD PRIMARY KEY (`trajet_id`,`personne_id`),
  ADD KEY `IDX_58D4CBCBD12A823` (`trajet_id`),
  ADD KEY `IDX_58D4CBCBA21BD112` (`personne_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D6497BA2F5EB` (`api_token`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E9E2810F4827B9B2` (`marque_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `FK_FCEC9EF181A8BA` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`),
  ADD CONSTRAINT `FK_FCEC9EFA73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `FK_FCEC9EFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `FK_2B5BA98C97A9E2C6` FOREIGN KEY (`ville_dep_id`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `FK_2B5BA98CBFADF06C` FOREIGN KEY (`ville_arr_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `trajet_personne`
--
ALTER TABLE `trajet_personne`
  ADD CONSTRAINT `FK_58D4CBCBA21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_58D4CBCBD12A823` FOREIGN KEY (`trajet_id`) REFERENCES `trajet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `FK_E9E2810F4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
