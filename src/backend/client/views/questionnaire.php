<?php

// Inclusion des dépendances nécessaires
require_once __DIR__ . '/../../../vendor/autoload.php'; // Charger l'autoloader pour les classes configurées

use config\Database;
use models\QuestionManager;

$balancedQuestions = [];
try {
    // Connexion à la base de données via PDO
    $pdo = Database::getConnection();

    // Créer une instance de QuestionManager
    $manager = new QuestionManager($pdo);

    // Charger les questions depuis la base de données
    $manager->loadQuestions();

    // Obtenir 10 questions équilibrées
    $balancedQuestions = $manager->getBalancedQuestions(3);
} catch (Exception $e) {
    // Gérer les exceptions potentielles
    echo '<div class="error">Erreur : ' . $e->getMessage() . '</div>';
}
?>


<div class="quiz-container">
    <header class="quiz-header">
        <nav class="quiz-nav">
            <button class="back-btn" onclick="location.href='/authentification';">← Retour</button>
            <div>
                <div class="quiz-title">Aptitude Test</div>
                <div class="question-counter">Question <span id="question-number">1</span>
                    sur <?php echo count($balancedQuestions); ?></div>
            </div>
        </nav>
        <div class="progress-bar" >
            <div class="progress-bar-inner"></div>
        </div>
    </header>

    <main class="quiz-content">
        <div class="questions-wrapper">
            <div class="questions-slider">
                <?php foreach ($balancedQuestions as $index => $question): ?>
                    <div class="question-item" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>"
                         data-question-index="<?php echo $index; ?>">
                        <h2 class="question">
                            <?php echo htmlspecialchars($question->getText()); ?>
                        </h2>

                        <?php if ($question->getImage()): ?>
                            <img src="<?php echo htmlspecialchars($question->getImage()); ?>" alt="Image question"
                                 style="max-width: 100%; height: auto; margin-bottom: 15px;">
                        <?php endif; ?>

                        <div class="options">
                            <?php
                            try {
                                $responses = $question->getResponses($pdo);
                                foreach ($responses as $responseIndex => $response) {
                                    echo '<button class="option" data-index="' . $responseIndex . '" data-score="' . htmlspecialchars($response['scores_personnalite']) . '">' . htmlspecialchars($response['texte_option']) . '</button>';
                                }
                            } catch (Exception $e) {
                                echo '<div class="error">Aucune réponse trouvée.</div>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="quiz-footer">
        <button class="button-submit reverse" id="prev-btn" disabled>
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
            Précédent
        </button>
        <button class="button-submit" id="next-btn" disabled>
            Suivant
            <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </button>
    </footer>
</div>