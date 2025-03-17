-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql_8
-- Généré le : sam. 08 fév. 2025 à 00:09
-- Version du serveur : 8.0.41
-- Version de PHP : 8.2.27

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

--
-- Déchargement des données de la table `categorie_question`
--

INSERT INTO `categorie_question` (`id_categorie`, `titre_categorie`) VALUES
                                                                         (5, 'Préférences et intérêts'),
                                                                         (6, 'Habitudes et le comportement'),
                                                                         (7, '3'),
                                                                         (8, '4'),
                                                                         (9, '5');

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
) ;

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

--
-- Déchargement des données de la table `questionnaire`
--

INSERT INTO `questionnaire` (`question_id`, `texte_question`, `img_question`, `id_categorie`) VALUES
                                                                                                  (21, 'Quel est ton sport préféré ?', NULL, 5),
                                                                                                  (22, 'Real ou Barça ?', NULL, 5),
                                                                                                  (23, 'Qui est le GOAT du basket ?', NULL, 5),
                                                                                                  (24, 'DC ou MARVEL', NULL, 5),
                                                                                                  (25, 'Quel genre de films préfères-tu ?', NULL, 5),
                                                                                                  (26, 'tu es plus de films ou de séries ? ', NULL, 5),
                                                                                                  (27, 'Loisir fav', NULL, 5),
                                                                                                  (28, 'sucré ou salé ?', NULL, 5),
                                                                                                  (29, 'Tu es plus ? (console fav)', NULL, 5),
                                                                                                  (30, 'Team Sony ou team XBOX ?', '', 5),
                                                                                                  (31, 'Team IOS ou Androïd ?', NULL, 5),
                                                                                                  (32, 'Reseau fav ?', NULL, 5),
                                                                                                  (33, 'Aimes-tu lire?', NULL, 5),
                                                                                                  (34, 'Systeme d\'exploitation préféré', NULL, 5),
                                                                                                  (35, 'Si tu pouvais vivre dans un animé/mangas lequel choisirais-tu ?', NULL, 5),
                                                                                                  (36, 'Si tu pouvais vivre dans un jeu lequel ça serait ?', NULL, 5),
                                                                                                  (37, 'Frites ou alloco', '', 5),
                                                                                                  (38, 'Foutou vs Placalis', NULL, 5),
                                                                                                  (39, 'pays de reve', NULL, 5),
                                                                                                  (40, 'Tu dors combien d\'heure par nuit ?', NULL, 6),
                                                                                                  (41, 'Quelle est la première chose que tu fais en te réveillant ?', NULL, 6),
                                                                                                  (42, 'Combien de temps passes-tu sur ton téléphone par jour ?', NULL, 6),
                                                                                                  (43, 'Tu te laves combien de fois par jours ?', NULL, 6),
                                                                                                  (44, 'Quel mode de transport utilises-tu le plus souvent ?', NULL, 6),
                                                                                                  (45, 'Tu sèches ?', NULL, 6),
                                                                                                  (46, 'Ton record de sèche ?', NULL, 6),
                                                                                                  (47, 'Ta boisson préféré ?', NULL, 5),
                                                                                                  (48, 'Introverti ou Extraverti ?', NULL, 6),
                                                                                                  (49, 'Tu es accro au IA ?', NULL, 6),
                                                                                                  (50, 'Arriver à l’heure ou en retard ?', NULL, 6),
                                                                                                  (51, 'Paiyasseur ?', NULL, 6),
                                                                                                  (53, 'Casanier ou paiyasseur ?', NULL, 6),
                                                                                                  (55, 'Tu fais quelle taille ?', NULL, 7),
                                                                                                  (56, 'Ta skincare?', NULL, 7),
                                                                                                  (57, 'Tu habites quelle commune ?', NULL, 7),
                                                                                                  (58, 'Ecole est dure ?', NULL, 7),
                                                                                                  (59, 'Ton prof Fav ?', NULL, 7),
                                                                                                  (60, 'Si tu étais un plat ivoirien, lequel serais-tu ?', NULL, 7);

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
                                `niveau` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
                                `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `mot_de_passe_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
                                `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
                                `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                `score_personnalite` double DEFAULT NULL,
                                `id_profil` smallint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateurs`
--
--
-- Déclencheurs `utilisateurs`
--
DELIMITER $$
CREATE TRIGGER `assign_profil_after_insert` AFTER INSERT ON `utilisateurs` FOR EACH ROW BEGIN
    DECLARE profil_id SMALLINT UNSIGNED;

-- Vérifier si le score_personnalite n'est pas NULL
    IF NEW.score_personnalite IS NOT NULL THEN
        -- Trouver l'ID du profil correspondant au score_personnalite
        SELECT id_profil
        INTO profil_id
        FROM profil_personnalite
        WHERE NEW.score_personnalite BETWEEN born_inf_score AND born_sup_score
        LIMIT 1;

-- Mettre à jour id_profil si un profil valide a été trouvé
        IF profil_id IS NOT NULL THEN
            UPDATE utilisateurs
            SET id_profil = profil_id
            WHERE utilisateur_id = NEW.utilisateur_id
              AND (id_profil IS NULL OR id_profil != profil_id);
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `assign_profil_after_update` AFTER UPDATE ON `utilisateurs` FOR EACH ROW BEGIN
    DECLARE profil_id SMALLINT UNSIGNED;

-- Vérifier si le score_personnalite a changé et n'est pas NULL
    IF NEW.score_personnalite IS NOT NULL
        AND (OLD.score_personnalite IS NULL OR OLD.score_personnalite != NEW.score_personnalite) THEN
        -- Trouver l'ID du profil correspondant au score_personnalite
        SELECT id_profil
        INTO profil_id
        FROM profil_personnalite
        WHERE NEW.score_personnalite BETWEEN born_inf_score AND born_sup_score
        LIMIT 1;

-- Mettre à jour id_profil seulement si nécessaire
        IF profil_id IS NOT NULL
            AND (NEW.id_profil IS NULL OR NEW.id_profil != profil_id) THEN
            UPDATE utilisateurs
            SET id_profil = profil_id
            WHERE utilisateur_id = NEW.utilisateur_id
              AND (id_profil IS NULL OR id_profil != profil_id);
        END IF;
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
    MODIFY `id_categorie` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `options_questions`
--
ALTER TABLE `options_questions`
    MODIFY `option_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT pour la table `profil_personnalite`
--
ALTER TABLE `profil_personnalite`
    MODIFY `id_profil` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
    MODIFY `question_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
    MODIFY `utilisateur_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
