<?php

namespace controllers;

use models\Utilisateur;
use models\UtilisateurManager;
use config\Database;

class Authentification
{
    public static function inscription(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);

            $utilisateur = new Utilisateur(
                null,
                $_POST['prenoms'],
                $_POST['nom'],
                $_POST['niveau'],
                $_POST['email'],
                $_POST['motDePasse'],
                '',
                '',
                0,
                0
            );

            $utilisateur = $manager->inscription($utilisateur);

            header('Content-Type: application/json');
            if ($utilisateur) {
                self::setUtilisateurSession($utilisateur);
                echo json_encode([
                    "success"  => true,
                    "message"  => "Inscription réussie",
                    "redirect" => "/"  // rediriger vers la page d'accueil par exemple
                ]);
            } else {
                echo json_encode([
                    "success"  => false,
                    "message"  => "Erreur lors de l'inscription. Veuillez réessayer."
                ]);
            }
            exit;
        }
    }

    public static function connexion(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);

            $utilisateur = $manager->connexion($_POST['email'], $_POST['motDePasse']);

            header('Content-Type: application/json');
            if ($utilisateur) {
                self::setUtilisateurSession($utilisateur);
                echo json_encode([
                    "success"  => true,
                    "message"  => "Connexion réussie",
                    "redirect" => "/"  // rediriger vers la page d'accueil ou une autre page sécurisée
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Erreur sur l'email ou le mot de passe."
                ]);
            }
            exit;
        }
    }

    public static function deconnexion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        header('Location: /');
    }

    // Méthode commune pour gérer la session utilisateur après une inscription ou une connexion
    private static function setUtilisateurSession(Utilisateur $utilisateur): void
    {
        $_SESSION['utilisateur'] = [
            'id'                => $utilisateur->getUtilisateurId(),
            'prenom'            => $utilisateur->getPrenom(),
            'nom'               => $utilisateur->getNom(),
            'email'             => $utilisateur->getEmail(),
            'niveau'            => $utilisateur->getNiveau(),
            'photo'             => $utilisateur->getPhoto(),
            'score_personnalite'=> $utilisateur->getScorePersonnalite(),
            'id_profil'         => $utilisateur->getIdProfil(),
            'date_creation'     => $utilisateur->getDateCreation(),
        ];
    }
}
