<?php

namespace controllers;

use models\Utilisateur;
use models\UtilisateurManager;
use config\Database;
use config\View;

class Authentification
{

    public static function inscription(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);

            // Gestion de la photo
            $photoPath = self::uploadPhoto($_FILES['photo-profil'], $_POST['prenoms'], $_POST['nom']);

            $utilisateur = new Utilisateur(
                null,
                $_POST['prenoms'],
                $_POST['nom'],
                $_POST['niveau'],
                $_POST['email'],
                $_POST['motDePasse'],
                $photoPath,
                '',
                (int)$_POST['totalScore'],
                null
            );

            $utilisateur = $manager->inscription($utilisateur);
            if ($utilisateur) {
                self::setUtilisateurSession($utilisateur);
                header('Location: /');
            } else {
                $_SESSION['erreur_connexion'] = "Erreur lors de la connexion";
                header('Location: /authentification');
            }
        }
    }

    public static function connexion(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);


            $utilisateur = $manager->connexion($_POST['email'], $_POST['motDePasse']);

            if ($utilisateur) {
                self::setUtilisateurSession($utilisateur);
                header('Location: /');
            } else {
                $_SESSION['erreur_connexion'] = "Erreur sur l'email/mot de passe";
                header('Location: /authentification');
            }
        }

    }

    public static function uploadPhoto($inputFile, $inputPrenoms, $inputNom): string|null
    {
        if (isset($inputFile) && is_uploaded_file($inputFile['tmp_name'])) {
            $photo = $inputFile; // Récupérer les informations du fichier

            // Définir un chemin de stockage absolu
            $uploadDir = __DIR__ . '/../../client/uploads/photos/'; // Répertoire absolu
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Créer le répertoire si inexistant
            }

            // Nettoyer les données utilisateur pour le nom du fichier
            $prenom = preg_replace('/[^a-zA-Z0-9_-]/', '', $inputPrenoms); // Retirer les caractères non valides
            $nom = preg_replace('/[^a-zA-Z0-9_-]/', '', $inputNom);

            // Générer un nom unique basé sur les données utilisateur
            $uniqueName = "user_{$prenom}_{$nom}_" . uniqid() . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
            $destinationPath = $uploadDir . $uniqueName;

            if (move_uploaded_file($inputFile['tmp_name'], $destinationPath)) {
                return $uniqueName; // Retourne le nom du fichier, pas le chemin complet
            }
        }

        return null;
    }

// Méthode commune pour gérer la session utilisateur après une inscription ou une connexion
    private static function setUtilisateurSession(Utilisateur $utilisateur): void
    {
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur->getUtilisateurId(),
            'prenom' => $utilisateur->getPrenom(),
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'niveau' => $utilisateur->getNiveau(),
            'photo' => $utilisateur->getPhoto(),
            'score_personnalite' => $utilisateur->getScorePersonnalite(),
            'id_profil' => $utilisateur->getIdProfil(),
            'date_creation' => $utilisateur->getDateCreation(),
        ];
    }
}
