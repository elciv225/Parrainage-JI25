<?php

namespace controllers;

use config\Database;
use models\UtilisateurManager;

class Concours
{

    public static function voteProjet($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);

            $idProjet = $id;

            // Récupérer l'ID de l'utilisateur connecté
            $idUtilisateur = $_SESSION['utilisateur']['id'];

            $result = $manager->voteProjet($idUtilisateur, $idProjet);

            if ($result) {
                $_SESSION['message_vote'] = "Vote enregistré avec succès";
                header('Location: /concours');
            } else {
                $_SESSION['erreur_vote'] = "Erreur lors du vote";
                header('Location: /concours');
            }
        }
    }

    public static function voteRoi($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $idRoi = $id;
            $result = $manager->voteRoi($idUtilisateur, $idRoi);
            if ($result) {
                $_SESSION['message_vote'] = "Vote enregistré avec succès";
                header('Location: /concours');
            } else {
                $_SESSION['erreur_vote'] = "Erreur lors du vote";
                header('Location: /concours');
            }
        }
    }

    public static function voteReine($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            $manager = new UtilisateurManager($pdo);
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $idReine = $id;
            $result = $manager->voteReine($idUtilisateur, $idReine);
            if ($result) {
                $_SESSION['message_vote'] = "Vote enregistré avec succès";
                header('Location: /concours');
            } else {
                $_SESSION['erreur_vote'] = "Erreur lors du vote";
                header('Location: /concours');
            }
        }
    }

}