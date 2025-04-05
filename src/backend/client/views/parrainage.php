<?php

use config\Database;
use models\UtilisateurManager;
use models\Parrainage;

try {
    // Connexion à la base de données via PDO
    $pdo = Database::getConnection();

    // Créer une instance de QuestionManager
    $manager = new UtilisateurManager($pdo);

    $parrainageModel = new Parrainage();

    $profilId = 5; // Exemple d'ID de profil

    $utilisateursDuProfil = $manager->getUtilisateursByProfil($profilId);

    echo "Tentative de liaison aléatoire pour le profil ID " . $profilId . ":\n";
    $utilisateursRestants = $parrainageModel->lierUtilisateursParProfil($utilisateursDuProfil);

    echo "\nUtilisateurs restants après tentative de liaison pour le profil ID " . $profilId . ":\n";
    print_r($utilisateursRestants);

} catch (Exception $e) {
    // Gérer les exceptions potentielles
    echo '<div class="error">Erreur : ' . $e->getMessage() . '</div>';
}