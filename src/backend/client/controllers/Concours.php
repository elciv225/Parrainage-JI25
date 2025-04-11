<?php

namespace controllers;

use config\Database;
use models\UtilisateurManager;

class Concours
{
    public static function voteProjet($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier que la session est démarrée et que l'utilisateur est connecté
            if (!isset($_SESSION['utilisateur']['id'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "Vous devez être connecté pour voter."
                ]);
                exit;
            }

            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);
            $idProjet = $id;

            // Récupérer l'ID de l'utilisateur connecté
            $idUtilisateur = $_SESSION['utilisateur']['id'];

            $result = $manager->voteProjet($idUtilisateur, $idProjet);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode([
                    "success"  => true,
                    "message"  => "Vote enregistré avec succès"
                ]);
            } else {
                echo json_encode([
                    "success"  => false,
                    "message"  => "Erreur lors du vote"
                ]);
            }
            exit;
        }
    }

    public static function voteRoi($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['utilisateur']['id'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "Vous devez être connecté pour voter."
                ]);
                exit;
            }

            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $idRoi = $id;

            $result = $manager->voteRoi($idUtilisateur, $idRoi);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode([
                    "success"  => true,
                    "message"  => "Vote enregistré avec succès"
                ]);
            } else {
                echo json_encode([
                    "success"  => false,
                    "message"  => "Erreur lors du vote"
                ]);
            }
            exit;
        }
    }

    public static function voteReine($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['utilisateur']['id'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "Vous devez être connecté pour voter."
                ]);
                exit;
            }

            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $idReine = $id;

            $result = $manager->voteReine($idUtilisateur, $idReine);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode([
                    "success"  => true,
                    "message"  => "Vote enregistré avec succès"
                ]);
            } else {
                echo json_encode([
                    "success"  => false,
                    "message"  => "Erreur lors du vote"
                ]);
            }
            exit;
        }
    }
}
