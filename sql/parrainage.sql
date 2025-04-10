-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 23 mars 2025 à 23:31
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Base de données : `parrainage`
-- --------------------------------------------------------

--
-- Structure de la table `categorie_question`
--
CREATE TABLE IF NOT EXISTS `categorie_question`
(
    `id_categorie`    int UNSIGNED NOT NULL AUTO_INCREMENT,
    `titre_categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    PRIMARY KEY (`id_categorie`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- Insertions des données de la table `categorie_question`
INSERT INTO `categorie_question` (`titre_categorie`)
VALUES ('Préférences et intérêts'),
       ('Habitudes et le comportement'),
       ('Caractéristiques personnelles');
-- --------------------------------------------------------

--
-- Structure de la table `questionnaire`
--
CREATE TABLE IF NOT EXISTS `questionnaire`
(
    `question_id`    smallint UNSIGNED                              NOT NULL AUTO_INCREMENT,
    `texte_question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
    `img_question`   text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
    `id_categorie`   int UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`question_id`),
    KEY `fk_questionnaire` (`id_categorie`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- Insertion des questions
-- Désactiver les contraintes de clé étrangère
SET foreign_key_checks = 0;
INSERT INTO `questionnaire` (`texte_question`, `img_question`, `id_categorie`)
VALUES ('Quel est ton sport préféré ?', NULL, 1),
       ('Real ou Barça ?', NULL, 1),
       ('Qui est le GOAT du basket ?', NULL, 1),
       ('DC ou MARVEL', NULL, 1),
       ('Quel genre de films préfères-tu ?', NULL, 1),
       ('tu es plus de films ou de séries ? ', NULL, 1),
       ('Loisir fav', NULL, 1),
       ('sucré ou salé ?', NULL, 1),
       ('Tu es plus ? (console fav)', NULL, 1),
       ('Team Sony ou team XBOX ?', '', 1),
       ('Team IOS ou Androïd ?', NULL, 1),
       ('Reseau fav ?', NULL, 1),
       ('Aimes-tu lire?', NULL, 1),
       ('Systeme d''exploitation préféré', NULL, 1),
       ('Si tu pouvais vivre dans un animé/mangas lequel choisirais-tu ?', NULL, 1),
       ('Si tu pouvais vivre dans un jeu lequel ça serait ?', NULL, 1),
       ('Frites ou alloco', '', 1),
       ('Foutou vs Placali', NULL, 1),
       ('Tu dors combien d''heure par nuit ?', NULL, 2),
       ('Tu te laves combien de fois par jours ?', NULL, 2),
       ('Tu sèches ?', NULL, 2),
       ('Ton record de sèche ?', NULL, 2),
       ('Ta boisson préféré ?', NULL, 1),
       ('Introverti ou Extraverti ?', NULL, 2),
       ('Tu es accro au IA ?', NULL, 2),
       ('Arriver à l’heure ou en retard ?', NULL, 2),
       ('Paiyasseur ?', NULL, 2),
       ('Casanier ou paiyasseur ?', NULL, 2),
       ('Tu fais quelle taille ?', NULL, 3),
       ('Ecole est dure ?', NULL, 3),
       ('Ton prof Fav ?', NULL, 3),
       ('Si tu étais un plat ivoirien, lequel serais-tu ?', NULL, 3),
       ('Tu pourrais vivre sans ordi ?', NULL, 1),
       ('Ton style musical ?', NULL, 1),
       ('Tu peux manger quoi tous les jours ?', NULL, 1),
       ('Si t’étais un animal ?', NULL, 3),
       ('Le cadeau qui te fait toujours plaisir ?', NULL, 1),
       ('Quand il pleut, tu fais quoi ?', NULL, 2),
       ('Si on te laisse seul 1 semaine ?', NULL, 2),
       ('T’es quel genre en vacances ?', NULL, 2),
       ('Ton appli la plus utilisée ?', NULL, 1),
       ('T’as déjà fait nuit blanche pourquoi ?', NULL, 2),
       ('Tu dors avec lumière allumée ?', NULL, 2),
       ('Tu préfères quelle saison ?', NULL, 1),
       ('Tu fais quoi quand tu es enervé ?', NULL, 3),
       ('Tu lis quoi ?', NULL, 1),
       ('Tu sors souvent le week-end ?', NULL, 2),
       ('Tu cuisines bien ?', NULL, 2),
       ('T’aimes faire rire les gens ?', NULL, 3),
       ('Dans un groupe, tu ?', NULL, 3);
-- Réactiver les contraintes de clé étrangère
SET foreign_key_checks = 1;
-- --------------------------------------------------------

--
-- Structure de la table `options_questions`
--
CREATE TABLE IF NOT EXISTS `options_questions`
(
    `option_id`           int UNSIGNED                                   NOT NULL AUTO_INCREMENT,
    `question_id`         smallint UNSIGNED                              NOT NULL,
    `texte_option`        text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
    `scores_personnalite` double DEFAULT NULL,
    PRIMARY KEY (`option_id`),
    KEY `idx_question` (`question_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- Insertion des données de la table `options_questions`
-- Désactiver les contraintes de clé étrangère
SET foreign_key_checks = 0;
INSERT INTO `options_questions` (`question_id`, `texte_option`, `scores_personnalite`)
VALUES (1, 'Basketball', 5),
       (1, 'Football', 3),
       (1, 'Argh', -5),
       (2, 'Real !!', 4),
       (2, 'Barça !!', 2),
       (3, 'Michael Jordan', 6),
       (3, 'LeBron James', 4),
       (4, 'DC toujours', -3),
       (4, 'Marvel', 3),
       (5, 'Horreurs', -4),
       (5, 'Humoristiques', 6),
       (5, 'Actions', 3),
       (5, 'Romances', 0),
       (6, 'Films', 2),
       (6, 'Séries', 4),
       (7, 'Dormir', -3),
       (7, 'Coder', 7),
       (7, 'Écouter de la musique', 2),
       (7, 'Le sport', 5),
       (8, 'Sucré', 1),
       (8, 'Salé', 3),
       (9, 'Playstation', 4),
       (9, 'XBOX', 2),
       (9, 'Nintendo', 3),
       (9, 'PC', 8),
       (10, 'Sony toujours!', 4),
       (10, 'Microsoft >>', 3),
       (11, 'iOS', 2),
       (11, 'Android', 5),
       (12, 'Insta', 3),
       (12, 'Snap', 0),
       (12, 'Facebook', -2),
       (12, 'TikTok', 4),
       (13, 'Eh tchai', 6),
       (13, 'Troop', -3),
       (14, 'Linux', 9),
       (14, 'Windows', 3),
       (14, 'MacOS', 5),
       (15, 'SNK', 7),
       (15, 'Naruto', 4),
       (15, 'DBZ', 3),
       (15, 'Demon Slayer', 5),
       (16, 'GTA', 1),
       (16, 'Les Sims', 2),
       (16, 'Un jeu Mario', 4),
       (16, 'Subway Surfer', -1),
       (17, 'FRIIIITTTTEESSSS', 2),
       (17, 'Alloco', 5),
       (18, 'Foutouuuuu', 6),
       (18, 'PLAAAAMIN (rentre dans moi)', 4),
       (19, '8h', 5),
       (19, '6h', 3),
       (19, '4h', -1),
       (19, 'Je suis Batman', -6),
       (20, '1 fois à 16h (pour matin et soir)', -3),
       (20, '2 fois (personne normale)', 5),
       (20, 'Plus de 2 fois (ah vieux!)', 7),
       (21, 'Sujet sensible', -4),
       (21, 'Non', 8),
       (22, '3 jours', -3),
       (22, '1 semaine', -6),
       (22, '2 semaines', -9),
       (22, '0 jour', 9),
       (23, 'Coca', 0),
       (23, 'Fanta', 1),
       (23, 'L''eau', 7),
       (23, 'C''est pas tout qu''on dit', -2),
       (24, 'Intro', -2),
       (24, 'Extra', 7),
       (25, 'Non', -3),
       (25, 'Moyen', 2),
       (25, 'Bien même', 8),
       (26, 'À l''heure tout le temps', 6),
       (26, 'Argh', -4),
       (27, 'Dans tous les paiyas', 8),
       (27, 'Non', -1),
       (28, 'Casanier', -2),
       (28, 'Le paiya', 7),
       (29, '[1m50;1m70[', 0),
       (29, '[1m70;1m80[', 2),
       (29, '[1m80;1m90[', 2),
       (29, '+1m90', 4),
       (30, 'On souffre même', -5),
       (30, 'Ça gère', 4),
       (30, 'Non, même pas', 7),
       (31, 'Mr. Godrin', 7),
       (31, 'Mr. Kouakou Matias', 5),
       (31, 'Mr. Codja', 4),
       (32, 'Garba', 3),
       (32, 'Le plaaminn(Placali)', 5),
       (33, 'Impossible', 7),
       (33, 'Oui, tranquille', -3),
       (33, 'Une pause, ok', 1),
       (33, 'Bof, ça dépend', 0),
       (34, 'Rap', 2),
       (34, 'Classique', -2),
       (34, 'Afrobeat', 3),
       (34, 'Biama', 0),
       (35, 'Riz', 1),
       (35, 'Garba', 3),
       (35, 'Pâtes', 5),
       (35, 'Attiéké', -1),
       (36, 'Lion', 3),
       (36, 'Chat', -3),
       (36, 'Porc', 2),
       (36, 'Tortue', -2),
       (37, 'Gadget', 4),
       (37, 'Argent', 2),
       (37, 'Livre', -3),
       (37, 'Bouffe', 2),
       (38, 'Dodo', -1),
       (38, 'Film', 0),
       (38, 'Jeux vidéo', 4),
       (38, 'C''est pas tout qu''on dit', 5),
       (39, 'Paradis', -4),
       (39, 'Bof', 0),
       (39, 'Je sors', 3),
       (40, 'Paiya', 2),
       (40, 'Voyage', 3),
       (40, 'Netflix & Chill', -3),
       (40, 'Full animé', 4),
       (41, 'WhatsApp', 2),
       (41, 'YouTube', 1),
       (41, 'TikTok', 3),
       (41, 'Instagram', -2),
       (41, 'X', -2),
       (42, 'Jeux', 4),
       (42, 'MIAGE', -5),
       (42, 'Le jeune homme là', 3),
       (42, 'La jeune fille là', 3),
       (42, 'Séries/Animé', 1),
       (42, 'Lecture', 1),
       (43, 'Oui (Ahh)', 2),
       (43, 'Non', -2),
       (43, 'Veilleuse', 0),
       (44, 'Chaleur', 2),
       (44, 'Pluie', -1),
       (44, 'Harmattan', -5),
       (45, 'Je pleure', -3),
       (45, 'Je crie', 2),
       (45, 'Je reste silencieux', -1),
       (45, 'Je pars', 0),
       (46, 'Manga', 0),
       (46, 'Roman', -3),
       (46, 'Mes cours', -5),
       (46, 'Webtoon', 1),
       (46, 'Rien', 3),
       (47, 'Toujours', 4),
       (47, 'Parfois', 1),
       (47, 'Jamais', -3),
       (47, 'Quand invité', 5),
       (48, 'Bah oui', 2),
       (48, 'Je me débrouille', 5),
       (48, 'Je ne sais pas allumer gaz', -2),
       (49, 'Oui', 3),
       (49, 'Un peu', 1),
       (49, 'Rarement', -1),
       (49, 'Pas du tout', -3),
       (50, 'Leader', 3),
       (50, 'Suiveur', -1),
       (50, 'Observateur', -2),
       (50, 'Ambianceur', 4);


-- Réactiver les contraintes de clé étrangère
SET foreign_key_checks = 1;
-- --------------------------------------------------------

--
-- Structure de la table `profil_personnalite`
--
CREATE TABLE IF NOT EXISTS `profil_personnalite`
(
    `id_profil`      smallint UNSIGNED NOT NULL AUTO_INCREMENT,
    `titre_profil`   varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `description`    text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
    `born_inf_score` double                                                DEFAULT NULL,
    `born_sup_score` double                                                DEFAULT NULL,
    PRIMARY KEY (`id_profil`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- Insertion des profils de personnalité basés sur les scores
INSERT INTO `profil_personnalite` (`titre_profil`, `description`, `born_inf_score`, `born_sup_score`)
VALUES ('Le Casanier Introverti',
        'Tu préfères rester chez toi, tu es calme, réfléchi, et tu apprécies les activités solitaires comme la lecture ou les jeux vidéo. Tu es plutôt ponctuel et assidu dans tes tâches.',
        -100, -2),

       ('L Analyste Technique',
        'Tu es passionné de technologie et de programmation. Tu as un esprit logique et analytique. Linux est probablement ton système d exploitation préféré, et tu passes beaucoup de temps à créer ou améliorer des choses.',
        -19, 0),

       ('L Équilibré',
        'Tu as un bon équilibre entre vie sociale et personnelle. Tu n es ni trop extraverti, ni trop introverti. Tu es généralement à l heure, tu prends soin de toi et tu as des habitudes saines.',
        1, 1),

       ('Le Social Actif',
        'Tu es énergique, sociable et tu aimes sortir avec tes amis. Les réseaux sociaux sont importants pour toi et tu préfères être dehors plutôt que chez toi. Tu es probablement fan de sport.',
        11, 32),

       ('L Aventurier Curieux',
        'Tu aimes découvrir de nouvelles choses, voyager et tester de nouvelles expériences. Tu es curieux, adaptable et tu apprécies aussi bien la technologie que les interactions sociales.',
        33, 60),

       ('Le Geek Extraverti',
        'Tu combines passion pour la technologie avec une vie sociale active. Tu es à l aise dans les discussions techniques comme dans les soirées. Tu es probablement passionné d anime et de jeux vidéo tout en ayant un cercle social étendu.',
        61, 100);

-- --------------------------------------------------------

--
-- Structure de la table `relations_parrainage`
--
CREATE TABLE IF NOT EXISTS `relations_parrainage`
(
    `relation_id`         int UNSIGNED NOT NULL AUTO_INCREMENT,
    `parrain_id`          int UNSIGNED NOT NULL,
    `filleul_id`          int UNSIGNED NOT NULL,
    `date_debut`          timestamp    NULL                                                  DEFAULT CURRENT_TIMESTAMP,
    `date_fin`            timestamp    NULL                                                  DEFAULT NULL,
    `statut`              enum ('ACTIF','TERMINE') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT 'ACTIF',
    `score_compatibilite` tinyint UNSIGNED                                                   DEFAULT NULL,
    PRIMARY KEY (`relation_id`),
    KEY `idx_parrain` (`parrain_id`),
    KEY `idx_filleul` (`filleul_id`),
    KEY `idx_statut` (`statut`),
    KEY `idx_dates` (`date_debut`, `date_fin`),
    KEY `idx_score` (`score_compatibilite`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- --------------------------------------------------------

--
-- Structure de la table `reponses_utilisateurs`
--
CREATE TABLE IF NOT EXISTS `reponses_utilisateurs`
(
    `reponse_id`     int UNSIGNED      NOT NULL AUTO_INCREMENT,
    `utilisateur_id` int UNSIGNED      NOT NULL,
    `question_id`    smallint UNSIGNED NOT NULL,
    `option_id`      int UNSIGNED      NOT NULL,
    `date_reponse`   timestamp         NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`reponse_id`),
    KEY `idx_utilisateur_question` (`utilisateur_id`, `question_id`),
    KEY `question_id` (`question_id`),
    KEY `option_id` (`option_id`),
    KEY `idx_date` (`date_reponse`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--
CREATE TABLE IF NOT EXISTS `utilisateurs`
(
    `utilisateur_id`     int UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `prenom`             varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  NOT NULL,
    `nom`                varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin  NOT NULL,
    `niveau`             varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin        DEFAULT NULL,
    `email`              varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
    `mot_de_passe_hash`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
    `photo`              text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
    `date_creation`      timestamp                                              NULL DEFAULT CURRENT_TIMESTAMP,
    `score_personnalite` double                                                      DEFAULT NULL,
    `id_profil`          smallint UNSIGNED                                           DEFAULT NULL,
    PRIMARY KEY (`utilisateur_id`),
    UNIQUE KEY `idx_email` (`email`),
    KEY `idx_nom_prenom` (`nom`, `prenom`),
    KEY `idx_date_creation` (`date_creation`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
-- --------------------------------------------------------

--
-- Structure de la table `votes_projet`
--
CREATE TABLE IF NOT EXISTS votes_projet
(
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL,
    projet_id      INT UNSIGNED NOT NULL,
    date_vote      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (utilisateur_id), -- un seul vote par utilisateur
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON DELETE CASCADE,
    FOREIGN KEY (projet_id) REFERENCES projets (id) ON DELETE CASCADE
);
--
-- Structure de la table `projets`
--
CREATE TABLE IF NOT EXISTS projets
(
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre        VARCHAR(100) NOT NULL,
    description  TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Insertion des projets dans la table `projets`
INSERT INTO projets (titre, description)
VALUES
    ('IA PROFIL', 'Les demandeurs d\'emploi ne sont plus des CV perdus, mais des profils analysés et proposés aux bonnes entreprises. Les employeurs ne recrutent plus au hasard : l\'IA filtre et trouve le talent idéal. Une expérience fluide et humaine, où chaque candidature compte car derrière elles se cache toujours une histoire.'),
    ('ChezMoi', 'Dans une COTE D\'IVOIRE en pleine urbanisation et croissance démographique, trouver un logement adapté devient un défi pour beaucoup. Un logement est bien plus qu\'une simple construction. C\'est un havre de paix, un lieu de liens, de réconfort et de chaleur humaine. C\'est aussi un foyer où naissent des idées et des projets, où se construit l\'Avenir. ChezMoi a pour but de permettre à chacun de trouver un logement correspondant à ses critères et à son budget. ChezMoi est un site web et une future application où les agents immobiliers peuvent publier leurs offres, les rendant accessibles à tous. Avec ChezMoi, plus besoin de prospecter sans fin pour trouver l\'offre idéale. Tout ce dont vous avez besoin est à portée de clic.'),
    ('WellMind', 'WellMind est une application web de soutien à la santé mentale offrant un chatbot thérapeutique disponible 24h/24. Face au taux alarmant de suicides, elle propose un accompagnement immédiat basé sur des approches scientifiques (TCC, pleine conscience), un suivi professionnel à distance et un système d\'intervention d\'urgence pour les personnes en crise. Son interface non stigmatisante rend les soins psychologiques accessibles à tous.'),
    ('MonBus', 'MonBus est une application mobile dont le but est de pouvoir faciliter le quotidien des travailleurs, étudiants et lycéens/collégiens de côte d’ivoire qui empruntent les bus. MonBus est une application multitâche en ce sens où elle permet : En premier lieu la recherche et la localisation en temps réel de bus ou de lignes de bus disponibles dans un secteur et une zone précise, depuis l’endroit où l’on se trouve. Plus d’inquiétude lorsque vous vous trouvez dans une commune peu familière. La communication des informations comme l’arrivée du prochain bus et le temps d’estimation du trajet. Ainsi, plus besoin de courir après les bus. Le temps d’attente se voit aussi réduit. Le paiement de tickets de bus à travers vos portefeuilles numériques. Vous n’aurez plus à vous inquiéter de problèmes de monnaies. Rechargement de vos cartes de bus. En fin de compte, plus besoin de vous tracasser concernant vos prochains trajets en bus. MonBus est là pour répondre à vos préoccupations.');


--
-- Structure de la table `votes_roi`
--
CREATE TABLE IF NOT EXISTS votes_roi
(
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL, -- L'utilisateur qui vote
    id_participant INT UNSIGNED NOT NULL, -- L'id du candidat roi (participant)
    date_vote      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (utilisateur_id),              -- L'utilisateur peut voter une seule fois
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON DELETE CASCADE,
    FOREIGN KEY (id_participant) REFERENCES participants (id_participant) ON DELETE CASCADE
);


--
-- Structure de la table `votes_reine`
--
CREATE TABLE IF NOT EXISTS votes_reine
(
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL, -- L'utilisateur qui vote
    id_participant INT UNSIGNED NOT NULL, -- L'id du candidat reine (participant)
    date_vote      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (utilisateur_id),              -- L'utilisateur peut voter une seule fois
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON DELETE CASCADE,
    FOREIGN KEY (id_participant) REFERENCES participants (id_participant) ON DELETE CASCADE
);

--
-- Structure de la table `participants`
--
CREATE TABLE IF NOT EXISTS participants
(
    id_participant   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(50) NOT NULL, -- Nom du participant
    prenom          VARCHAR(50) NOT NULL, -- Prénom du participant
    role             ENUM ('roi', 'reine') NOT NULL, -- Rôle (Roi ou Reine)
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Structure de la table `questions_posees`
--
CREATE TABLE IF NOT EXISTS questions_posees
(
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL,
    question       TEXT         NOT NULL,
    date_question  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON DELETE CASCADE
);

--
-- Structure de la table `repas`
--
CREATE TABLE IF NOT EXISTS repas
(
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(255) NOT NULL,    -- Nom du repas
    description TEXT,                    -- Description du repas
    statut     ENUM('disponible', 'indisponible') DEFAULT 'disponible',  -- Statut du repas
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Date de création
);


--
-- Structure de la table `commandes_repas`
--

CREATE TABLE IF NOT EXISTS commandes_repas
(
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL,  -- Utilisateur qui a commandé
    repas_id       INT UNSIGNED NOT NULL,  -- Référence au repas commandé
    quantite       INT UNSIGNED DEFAULT 1, -- Quantité de repas
    statut         ENUM('en_attente', 'en_preparation', 'livre') DEFAULT 'en_attente', -- Statut de la commande
    date_commande  TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de la commande
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (utilisateur_id) ON DELETE CASCADE,  -- Lien vers l'utilisateur
    FOREIGN KEY (repas_id) REFERENCES repas (id) ON DELETE CASCADE  -- Lien vers le repas
);




--
-- Contraintes pour les tables déchargées
--
-- Contraintes pour la table `options_questions`
ALTER TABLE `options_questions`
    ADD CONSTRAINT `options_questions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`) ON DELETE CASCADE;

-- Contraintes pour la table `questionnaire`
ALTER TABLE `questionnaire`
    ADD CONSTRAINT `fk_questionnaire` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_question` (`id_categorie`);

-- Contraintes pour la table `relations_parrainage`
ALTER TABLE `relations_parrainage`
    ADD CONSTRAINT `relations_parrainage_ibfk_1` FOREIGN KEY (`parrain_id`) REFERENCES `utilisateurs` (`utilisateur_id`),
    ADD CONSTRAINT `relations_parrainage_ibfk_2` FOREIGN KEY (`filleul_id`) REFERENCES `utilisateurs` (`utilisateur_id`);

-- Contraintes pour la table `reponses_utilisateurs`
ALTER TABLE `reponses_utilisateurs`
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`utilisateur_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questionnaire` (`question_id`),
    ADD CONSTRAINT `reponses_utilisateurs_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `options_questions` (`option_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;