<?php

namespace client\traitements;

require_once __DIR__ . '/../../../vendor/autoload.php'; // Charger l'autoloader de Composer

use config\Database;
use models\QuestionManager;

try {
    // Obtenir la connexion PDO
    $pdo = Database::getConnection();

    // Créer une instance de QuestionManager
    $manager = new QuestionManager($pdo);

    // Charger les questions depuis la base de données
    $manager->loadQuestions();

    // Obtenir 10 questions équilibrées
    $balancedQuestions = $manager->getBalancedQuestions(10);

    // Afficher les questions en HTML
    $manager->displayQuestions($balancedQuestions);
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}