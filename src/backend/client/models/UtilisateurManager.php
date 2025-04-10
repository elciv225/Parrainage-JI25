<?php

namespace models;

use PDOException;
use PDO;

class UtilisateurManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Vérifie si l'utilisateur existe
     *
     * @param string $email
     * @return true si l'utilisateur existe false sinon
     */

    public function utilisateurExiste(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM parrainage.utilisateurs WHERE email = :e";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':e', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Inscription d'un nouvel utilisateur
     *
     * @param Utilisateur $utilisateur
     * @return Utilisateur|null si l'inscription a réussi
     */
    public function inscription(Utilisateur $utilisateur): ?Utilisateur
    {
        if (!$this->utilisateurExiste($utilisateur->getEmail())) {
            try {
                // Vérifions si l'utilisateur existe ou non
                // Dans ce cas l'utilisateur n'existe pas donc on l'enregistre
                // On hash le mot de passe
                $mot_de_passe_hash = password_hash($utilisateur->getMotDePasseHash(), PASSWORD_DEFAULT);
                $utilisateur->setMotDePasseHash($mot_de_passe_hash);

                // Préparation de la requête d'insertion
                $sql = "INSERT INTO parrainage.utilisateurs (prenom, nom, niveau, email, mot_de_passe_hash, photo, score_personnalite, id_profil, date_creation) 
                        VALUES (:prenom, :nom, :niveau, :email, :motDePasseHash, :photo, :scorePersonnalite, (SELECT id_profil FROM parrainage.profil_personnalite 
                        WHERE :scorePersonnalite BETWEEN born_inf_score AND born_sup_score LIMIT 1), NOW())";

                $stmt = $this->pdo->prepare($sql);

                // Liaison des valeurs
                $stmt->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
                $stmt->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
                $stmt->bindValue(':photo', $utilisateur->getPhoto(), PDO::PARAM_STR);
                $stmt->bindValue(':niveau', $utilisateur->getNiveau(), PDO::PARAM_STR);
                $stmt->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
                $stmt->bindValue(':motDePasseHash', $utilisateur->getMotDePasseHash(), PDO::PARAM_STR);
                $stmt->bindValue(':scorePersonnalite', $utilisateur->getScorePersonnalite(), PDO::PARAM_INT);

                // Exécution de la requête
                $res = $stmt->execute();
                if ($res) {
                    // Récupérer l'ID généré
                    $utilisateur_id = (int)$this->pdo->lastInsertId();
                    $utilisateur->setUtilisateurId($utilisateur_id);
                    return $utilisateur;
                }
            } catch (PDOException $e) {
                echo "Erreur lors de l'inscription : " . $e->getMessage();
            }
        }
        return null;
    }

    /**
     * Connexion d'un utilisateur.
     *
     * @param string $email Email saisi par l'utilisateur
     * @param string $mot_de_passe Mot de passe saisi par l'utilisateur (non hashé)
     *
     * @return Utilisateur|null     Retourne un objet Utilisateur si la connexion réussit, null sinon
     */
    public function connexion(string $email, string $mot_de_passe): ?Utilisateur
    {
        try {
            // Recherche de l'utilisateur
            $sql = "SELECT * FROM parrainage.utilisateurs WHERE email = :email LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            // Récupérer les données utilisateur
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($mot_de_passe, $row['mot_de_passe_hash'])) {
                // Mot de passe valide, on retourne l'Utilisateur
                return new Utilisateur(
                    (int)$row['utilisateur_id'],
                    (string)$row['prenom'],
                    (string)$row['nom'],
                    (string)$row['niveau'],
                    (string)$row['email'],
                    (string)$row['mot_de_passe_hash'],
                    (string)$row['photo'],
                    (string)$row['date_creation'],
                    $row['score_personnalite'] !== null ? (float)$row['score_personnalite'] : null,
                    $row['id_profil'] !== null ? (int)$row['id_profil'] : null
                );
            }
        } catch (PDOException $e) {
            // Gestion d'erreur
            echo "Erreur lors de la connexion : " . $e->getMessage();
        }

        return null;
    }

    /**
     * Récupère tous les utilisateurs ayant un profil spécifique.
     *
     * @param int $id_profil L'ID du profil à rechercher.
     * @return array Un tableau d'objets Utilisateur.
     */
    public function getUtilisateursByProfil(int $id_profil): array
    {
        $utilisateurs = []; // Initialize an empty array to store users

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM parrainage.utilisateurs WHERE id_profil = :id_profil");
            $stmt->bindParam(':id_profil', $id_profil, PDO::PARAM_INT);
            $stmt->execute();

            // Récupérer les données utilisateur et créer des objets Utilisateur

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $utilisateur = new Utilisateur(
                    (int)$row['utilisateur_id'],
                    (string)$row['prenom'],
                    (string)$row['nom'],
                    (string)$row['niveau'],
                    (string)$row['email'],
                    (string)$row['mot_de_passe_hash'],
                    (string)$row['photo'],
                    (string)$row['date_creation'],
                    $row['score_personnalite'] !== null ? (float)$row['score_personnalite'] : null,
                    $row['id_profil'] !== null ? (int)$row['id_profil'] : null
                );
                $utilisateurs[] = $utilisateur; // Add the Utilisateur object to the array
            }

        } catch (PDOException $e) {
            // Gestion d'erreur
            echo "Erreur lors de la requête : " . $e->getMessage();
            return []; // Return an empty array in case of an error
        }

        return $utilisateurs; // Return the array of Utilisateur objects
    }


    /**
     * Vérifie si l'utilisateur a déjà voté pour un projet
     */
    public function aVoteProjet(int $id_utilisateur): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parrainage.votes_projet WHERE utilisateur_id = ?");
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Vote pour un projet
     *
     * @param int $id_utilisateur
     * @param int $id_projet
     * @return bool true si le vote a réussi, false sinon
     */
    public function voteProjet(int $id_utilisateur, int $id_projet): bool
    {
        if ($this->aVoteProjet($id_utilisateur)) {
            return false; // déjà voté
        }

        $stmt = $this->pdo->prepare("INSERT INTO parrainage.votes_projet (utilisateur_id, projet_id) VALUES (?, ?)");
        return $stmt->execute([$id_utilisateur, $id_projet]);
    }

    /**
     * Vérifie si l'utilisateur a déjà voté pour le roi
     */
    public function aVoteRoi(int $id_utilisateur): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parrainage.votes_roi WHERE utilisateur_id = ? LIMIT 1");
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchColumn() > 0;
    }
    /**
     * Vote pour le roi
     *
     * @param int $id_utilisateur
     * @param int $id_roi
     * @return bool true si le vote a réussi, false sinon
     */
    public function voteRoi(int $id_utilisateur, int $id_participant): bool
    {
        if ($this->aVoteRoi($id_utilisateur)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO parrainage.votes_roi (utilisateur_id, id_participant) VALUES (?, ?)");
        return $stmt->execute([$id_utilisateur, $id_participant]);
    }

    /**
     * Vérifie si l'utilisateur a déjà voté pour la reine
     */
    public function aVoteReine(int $id_utilisateur): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parrainage.votes_reine WHERE utilisateur_id = ? LIMIT 1");
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Vote pour la reine
     *
     * @param int $id_utilisateur
     * @param int $id_participant
     * @return bool true si le vote a réussi, false sinon
     */
    public function voteReine(int $id_utilisateur, int $id_participant): bool
    {
        if ($this->aVoteReine($id_utilisateur)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO parrainage.votes_reine (utilisateur_id, id_participant) VALUES (?, ?)");
        return $stmt->execute([$id_utilisateur, $id_participant]);
    }

    /**
     *  Enregistre une question posée
     * @param int $id_utilisateur
     * @param string $question
     * @return bool true si la question a été posée avec succès, false sinon
     */
    public function poserQuestion(int $id_utilisateur, string $question): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO parrainage.questions_posees (utilisateur_id, question) VALUES (?, ?)");
        return $stmt->execute([$id_utilisateur, $question]);
    }

    /**
     * Commandé un repas
     * @param int $id_utilisateur
     * @param string $repas Le nom du repas
     * @param int $quantite La quantité de repas
     * @return bool true si l'utilisateur a déjà commandé un repas, false sinon
     */
    public function commanderRepas(int $id_utilisateur, int $id_repas, int $quantite = 1): bool
    {
        // Vérifier si l'utilisateur a déjà une commande en cours
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parrainage.commandes_repas WHERE utilisateur_id = ? AND statut = 'en_attente'");
        $stmt->execute([$id_utilisateur]);
        if ($stmt->fetchColumn() > 0) {
            return false;  // L'utilisateur a déjà une commande en attente
        }

        // Ajouter la commande
        $stmt = $this->pdo->prepare("INSERT INTO parrainage.commandes_repas (utilisateur_id, repas_id, quantite) VALUES (?, ?, ?)");
        return $stmt->execute([$id_utilisateur, $id_repas, $quantite]);
    }


    /**
     * Modifie une commande existante
     *
     * @param int $id_commande L'identifiant de la commande à modifier
     * @param string $nouveau_repas Le nom du nouveau repas
     * @param int $nouvelle_quantite La nouvelle quantité
     * @return bool true si la mise à jour réussit
     */
    public function modifierCommande(int $id_commande, string $nouveau_repas, int $nouvelle_quantite): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE parrainage.commandes_repas
        SET repas = ?, quantite = ?
        WHERE id = ?
    ");
        return $stmt->execute([$nouveau_repas, $nouvelle_quantite, $id_commande]);
    }


}