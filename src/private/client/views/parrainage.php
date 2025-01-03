<?php

// Inclusion des dépendances nécessaires
require_once __DIR__ . '/../../../vendor/autoload.php'; // Charger l'autoloader pour les classes configurées

use config\Database;
use client\traitements\QuestionManager;

$balancedQuestions = [];
try {
    // Connexion à la base de données via PDO
    $pdo = Database::getConnection();

    // Créer une instance de QuestionManager
    $manager = new QuestionManager($pdo);

    // Charger les questions depuis la base de données
    $manager->loadQuestions();

    // Obtenir 10 questions équilibrées
    $balancedQuestions = $manager->getBalancedQuestions(10);
} catch (Exception $e) {
    // Gérer les exceptions potentielles
    echo '<div class="error">Erreur : ' . $e->getMessage() . '</div>';
}
?>


<div class="quiz-container">
    <header class="quiz-header">
        <nav class="quiz-nav">
            <button class="back-btn" onclick="location.href='index.php';">← Retour</button>
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
                                    echo '<button class="option" data-index="' . $responseIndex . '">' . htmlspecialchars($response['texte_option']) . '</button>';
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
        <button class="prev-btn" disabled>← Précédent</button>
        <button class="next-btn" disabled>Suivant →</button>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = document.querySelectorAll('.question-item');
        const options = document.querySelectorAll('.option');
        const nextBtn = document.querySelector('.next-btn');
        const prevBtn = document.querySelector('.prev-btn');
        const questionNumber = document.getElementById('question-number');
        const progressBarInner = document.querySelector('.progress-bar-inner');

        let currentQuestion = 0;

        // Fonction pour mettre à jour l'affichage des boutons suivant/précédent
        function updateNavigationButtons() {
            nextBtn.disabled = true; // Toujours désactivé tant qu'aucune réponse n'est sélectionnée
            prevBtn.disabled = currentQuestion === 0; // Désactive "Précédent" si on est à la première question
        }

        // Fonction pour mettre à jour la barre de progression
        function updateProgressBar() {
            const totalQuestions = questions.length;
            const progressPercentage = ((currentQuestion + 1) / totalQuestions) * 100; // Calcul de la progression
            progressBarInner.style.width = `${progressPercentage}%`; // Mise à jour de la largeur
        }

        // Sélection de réponse
        options.forEach(option => {
            option.addEventListener('click', function () {
                // Retirer la classe 'selected' des autres options de la même question
                const currentOptions = questions[currentQuestion].querySelectorAll('.option');
                currentOptions.forEach(opt => opt.classList.remove('selected'));

                // Ajouter la classe 'selected' à l'option cliquée
                this.classList.add('selected');
                nextBtn.disabled = false;
            });
        });

        // Gérer le bouton "Suivant"
        nextBtn.addEventListener('click', function () {
            // Cacher la question actuelle
            questions[currentQuestion].style.display = 'none';

            // Passer à la question suivante
            currentQuestion++;

            if (currentQuestion < questions.length) {
                // Afficher la prochaine question
                questions[currentQuestion].style.display = 'block';
                questionNumber.innerText = currentQuestion + 1;

                // Mettre à jour la barre de progression
                updateProgressBar();

                // Mettre à jour les états des boutons
                updateNavigationButtons();
            } else {
                // Lorsque c'est la dernière question
                alert("Quiz terminé !");
            }
        });

        // Gérer le bouton "Précédent"
        prevBtn.addEventListener('click', function () {
            // Cacher la question actuelle
            questions[currentQuestion].style.display = 'none';

            // Revenir à la question précédente
            currentQuestion--;

            if (currentQuestion >= 0) {
                // Afficher la question précédente
                questions[currentQuestion].style.display = 'block';
                questionNumber.innerText = currentQuestion + 1;

                // Mettre à jour la barre de progression
                updateProgressBar();

                // Mettre à jour les états des boutons
                updateNavigationButtons();
            }
        });

        // Initialiser la barre de progression au chargement
        updateProgressBar();
        // Initialisation des boutons au chargement de la page
        updateNavigationButtons();
    });
</script>
c