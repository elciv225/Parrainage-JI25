<?php

namespace client\traitements;

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
        $sql = "SELECT COUNT(*) FROM parrainage.utilisateurs WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Inscription d'un nouvel utilisateur
     *
     * @param Utilisateur $utilisateur
     * @return Utilisateur si l'inscription a réussi
     */
    public function inscription(Utilisateur $utilisateur): ?Utilisateur
    {
        try {
            // Vérifions si l'utilisateur existe ou non
            if ($this->utilisateurExiste($utilisateur->getEmail())) {
                return null;
            }

            // Dans ce cas l'utilisateur n'existe pas donc on l'enregistre
            // On hash le mot de passe
            $mot_de_passe_hash = password_hash($utilisateur->getMotDePasseHash(), PASSWORD_DEFAULT);
            $utilisateur->setMotDePasseHash($mot_de_passe_hash);

            // Préparation de la requête d'insertion
            $sql = "INSERT INTO parrainage.utilisateurs
                    (prenom, nom, niveau, email, mot_de_passe_hash, photo, score_personnalite, id_profil, date_creation) 
                    VALUES
                    (:prenom, :nom, :niveau, :email, :motDePasseHash, :photo, :scorePersonnalite, :idProfil, NOW())";

            $stmt = $this->pdo->prepare($sql);

            // Liaison des valeurs
            $stmt->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
            $stmt->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
            $stmt->bindValue(':photo', $utilisateur->getPhoto(), PDO::PARAM_STR);
            $stmt->bindValue(':niveau', $utilisateur->getNiveau(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':motDePasseHash', $utilisateur->getMotDePasseHash(), PDO::PARAM_STR);
            $stmt->bindValue(':scorePersonnalite', $utilisateur->getScorePersonnalite(), PDO::PARAM_STR);
            $stmt->bindValue(':idProfil', $utilisateur->getIdProfil(), PDO::PARAM_INT);

            // Exécution de la requête
            $res = $stmt->execute();
            if ($res) {
                // Récupérer l'ID généré
                $utilisateur_id = (int)$this->pdo->lastInsertId();
                $utilisateur->setUtilisateurId($utilisateur_id);
                echo "Inscription réussie avec l'ID utilisateur : $utilisateur_id";
                return $utilisateur;
            }

            return null;
        } catch (PDOException $e) {
            echo "Erreur lors de l'inscription : " . $e->getMessage();
            return null;
        }
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

            // L'utilisateur n'existe pas
            return null;
        } catch (PDOException $e) {
            // Gestion d'erreur
            echo "Erreur lors de la connexion : " . $e->getMessage();
            return null;
        }

    }


}