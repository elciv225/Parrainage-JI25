<?php

namespace controllers;

use config\Database;
use models\UtilisateurManager;

class Concours
{
    public static function voteProjet(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (!isset($_SESSION['utilisateur']['id'])) {
                    self::sendJson(false, "Vous devez être connecté pour voter.");
                }

                $idProjet = isset($_POST['idProjet']) ? (int)$_POST['idProjet'] : 0;
                if ($idProjet <= 0) {
                    self::sendJson(false, "Projet invalide.");
                }

                $pdo = Database::getConnection();
                $manager = new UtilisateurManager($pdo);
                $idUtilisateur = (int)$_SESSION['utilisateur']['id'];

                $result = $manager->voteProjet($idUtilisateur, $idProjet);

                if ($result) {
                    self::sendJson(true, "Vote enregistré avec succès.");
                } else {
                    self::sendJson(false, "Vous avez déjà voté ou une erreur est survenue.");
                }
            } catch (\Throwable $e) {
                self::sendJson(false, "Erreur serveur : " . $e->getMessage());
            }
        }
    }

    public static function voteRoi(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (!isset($_SESSION['utilisateur']['id'])) {
                    self::sendJson(false, "Vous devez être connecté pour voter.");
                }

                $idRoi = isset($_POST['idRoi']) ? (int)$_POST['idRoi'] : 0;
                if ($idRoi <= 0) {
                    self::sendJson(false, "Roi invalide.");
                }

                $pdo = Database::getConnection();
                $manager = new UtilisateurManager($pdo);
                $idUtilisateur = (int)$_SESSION['utilisateur']['id'];

                $result = $manager->voteRoi($idUtilisateur, $idRoi);

                if ($result) {
                    self::sendJson(true, "Vote pour le roi enregistré avec succès.");
                } else {
                    self::sendJson(false, "Vous avez déjà voté ou une erreur est survenue.");
                }
            } catch (\Throwable $e) {
                self::sendJson(false, "Erreur serveur : " . $e->getMessage());
            }
        }
    }

    public static function voteReine(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (!isset($_SESSION['utilisateur']['id'])) {
                    self::sendJson(false, "Vous devez être connecté pour voter.");
                }

                $idReine = isset($_POST['idReine']) ? (int)$_POST['idReine'] : 0;
                if ($idReine <= 0) {
                    self::sendJson(false, "Reine invalide.");
                }

                $pdo = Database::getConnection();
                $manager = new UtilisateurManager($pdo);
                $idUtilisateur = (int)$_SESSION['utilisateur']['id'];

                $result = $manager->voteReine($idUtilisateur, $idReine);

                if ($result) {
                    self::sendJson(true, "Vote pour la reine enregistré avec succès.");
                } else {
                    self::sendJson(false, "Vous avez déjà voté ou une erreur est survenue.");
                }
            } catch (\Throwable $e) {
                self::sendJson(false, "Erreur serveur : " . $e->getMessage());
            }
        }
    }

    private static function sendJson(bool $success, string $message, string $redirect = ''): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "redirect" => $redirect ?: null
        ]);
        exit;
    }
}
