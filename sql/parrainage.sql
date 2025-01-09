-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql_8
-- Généré le : jeu. 09 jan. 2025 à 22:39
-- Version du serveur : 8.0.40
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `parrainage`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie_question`
--

CREATE TABLE `categorie_question` (
                                      `id_categorie` int UNSIGNED NOT NULL,
                                      `titre_categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `options_questions`
--

CREATE TABLE `options_questions` (
                                     `option_id` int UNSIGNED NOT NULL,
                                     `question_id` smallint UNSIGNED NOT NULL,
                                     `texte_option` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                     `scores_personnalite` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `profil_personnalite`
--

CREATE TABLE `profil_personnalite` (
                                       `id_profil` smallint UNSIGNED NOT NULL,
                                       `titre_profil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
                                       `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
                                       `born_inf_score` double DEFAULT NULL,
                                       `born_sup_score` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `questionnaire`
--

CREATE TABLE `questionnaire` (
                                 `question_id` smallint UNSIGNED NOT NULL,
                                 `texte_question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                 `img_question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
                                 `id_categorie` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `relations_parrainage`
--

CREATE TABLE `relations_parrainage` (
                                        `relation_id` int UNSIGNED NOT NULL,
                                        `parrain_id` int UNSIGNED NOT NULL,
                                        `filleul_id` int UNSIGNED NOT NULL,
                                        `date_debut` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                        `date_fin` timestamp NULL DEFAULT NULL,
                                        `statut` enum('ACTIF','TERMINE') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'ACTIF',
                                        `score_compatibilite` tinyint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `reponses_utilisateurs`
--

CREATE TABLE `reponses_utilisateurs` (
                                         `reponse_id` int UNSIGNED NOT NULL,
                                         `utilisateur_id` int UNSIGNED NOT NULL,
                                         `question_id` smallint UNSIGNED NOT NULL,
                                         `option_id` int UNSIGNED NOT NULL,
                                         `date_reponse` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
                                `utilisateur_id` int UNSIGNED NOT NULL,
                                `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `niveau` varchar(3) COLLATE utf8mb4_bin DEFAULT NULL,
                                `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `mot_de_passe_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `photo` text COLLATE utf8mb4_bin,
                                `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                `score_personnalite` double DEFAULT NULL,
                                `id_profil` smallint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déclencheurs `utilisateurs`
--
DELIMITER $$
CREATE TRIGGER `assign_profil_after_insert` AFTER INSERT ON `utilisateurs` FOR EACH ROW BEGIN
    DECLARE profil_id INT;

    -- Trouver l'ID du profil correspondant au score_personnalite
    SELECT id_profil INTO profil_id
    FROM profil_personnalite
    WHERE NEW.score_personnalite BETWEEN born_inf_score AND born_sup_score
    LIMIT 1;

    -- Mettre à jour id_profil ou le laisser NULL si aucun profil ne correspond
    IF profil_id IS NOT NULL THEN
        UPDATE utilisateurs
        SET id_profil = profil_id
        WHERE utilisateur_id = NEW.utilisateur_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `assign_profil_after_update` AFTER UPDATE ON `utilisateurs` FOR EACH ROW BEGIN
    DECLARE profil_id INT;

    -- Si le score_personnalite a changé, trouver le profil correspondant
    IF OLD.score_personnalite != NEW.score_personnalite THEN
        SELECT id_profil INTO profil_id
        FROM profil_personnalite
        WHERE NEW.score_personnalite BETWEEN born_inf_score AND born_sup_score
        LIMIT 1;

        -- Mettre à jour id_profil ou le laisser NULL si aucun profil ne correspond
        UPDATE utilisateurs
        SET id_profil = profil_id
        WHERE utilisateur_id = NEW.utilisateur_id;
    END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie_question`
--
ALTER TABLE `categorie_question`
    ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `options_questions`
--
ALTER TABLE `options_questions`
    ADD PRIMARY KEY (`option_id`),
    ADD KEY `idx_question` (`question_id`);

--
-- Index pour la table `profil_personnalite`
--
ALTER TABLE `profil_personnalite`
    ADD PRIMARY KEY (`id_profil`);

--
-- Index pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
    ADD PRIMARY KEY (`question_id`),
    ADD KEY `fk_questionnaire` (`id_categorie`);

--
-- Index pour la table `relations_parrainage`
--
ALTER TABLE `relations_parrainage`
    ADD PRIMARY KEY (`relation_id`),
    ADD KEY `idx_parrain` (`parrain_id`),
    ADD KEY `idx_filleul` (`filleul_id`),
    ADD KEY `idx_statut` (`statut`),
    ADD KEY `idx_dates` (`date_debut`,`date_fin`),
    ADD KEY `idx_score` (`score_compatibilite`);

--
-- Index pour la table `reponses_utilisateurs`
--
ALTER TABLE `reponses_utilisateurs`
    ADD PRIMARY KEY (`reponse_id`),
    ADD KEY `idx_utilisateur_question` (`utilisateur_id`,`question_id`),
    ADD KEY `question_id` (`question_id`),
    ADD KEY `option_id` (`option_id`),
    ADD KEY `idx_date` (`date_reponse`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    ADD PRIMARY KEY (`utilisateur_id`),
    ADD UNIQUE KEY `idx_email` (`email`),
    ADD UNIQUE KEY `unq_utilisateurs_id_profil` (`id_profil`),
    ADD KEY `idx_nom_prenom` (`nom`,`prenom`),
    ADD KEY `idx_date_creation` (`date_creation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie_question`
--
ALTER TABLE `categorie_question`
    MODIFY `id_categorie` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `options_questions`
--
ALTER TABLE `options_questions`
    MODIFY `option_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT pour la table `profil_personnalite`
--
ALTER TABLE `profil_personnalite`
    MODIFY `id_profil` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
    MODIFY `question_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `relations_parrainage`
--
ALTER TABLE `relations_parrainage`
    MODIFY `relation_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponses_utilisateurs`
--
ALTER TABLE `reponses_utilisateurs`
    MODIFY `reponse_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    MODIFY `utilisateur_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `options_questions`
--
ALTER TABLE `options_questions`
    ADD CONSTRAINT `options_questions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `profil_personnalite`
--
ALTER TABLE `profil_personnalite`
    ADD CONSTRAINT `fk_profil_personnalite_utilisateurs` FOREIGN KEY (`id_profil`) REFERENCES `utilisateurs` (`id_profil`);

--
-- Contraintes pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
    ADD CONSTRAINT `fk_questionnaire` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_question` (`id_categorie`);

--
-- Contraintes pour la table `relations_parrainage`
--
ALTER TABLE `relations_parrainage`
    ADD CONSTRAINT `relations_parrainage_ibfk_1` FOREIGN KEY (`parrain_id`) REFERENCES `utilisateurs` (`utilisateur_id`),
    ADD CONSTRAINT `relations_parrainage_ibfk_2` FOREIGN KEY (`filleul_id`) REFERENCES `utilisateurs` (`utilisateur_id`);

--
-- Contraintes pour la table `reponses_utilisateurs`
--
ALTER TABLE `reponses_utilisateurs`
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`utilisateur_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`),
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `options_questions` (`option_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
