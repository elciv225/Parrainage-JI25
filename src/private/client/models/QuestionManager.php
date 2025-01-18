<?php

namespace models;

use PDO;

class QuestionManager
{
    private PDO $pdo;
    private array $questionsByCategory = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Charger les questions depuis la base de données
    public function loadQuestions(): void
    {
        $query = "SELECT question_id, texte_question, img_question, id_categorie
              FROM parrainage.questionnaire ORDER BY id_categorie";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $this->questionsByCategory = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question(
                $row['question_id'],
                $row['texte_question'],
                $row['img_question'],
                $row['id_categorie']
            );

            $this->questionsByCategory[$row['id_categorie']][] = $question;
        }
    }


    // Obtenir un ensemble équilibré de questions
    public function getBalancedQuestions(int $totalQuestions = 10): array
    {
        $balancedQuestions = [];
        $categoryCount = count($this->questionsByCategory);

        if ($categoryCount === 0) {
            return [];
        }

        $questionsPerCategory = intdiv($totalQuestions, $categoryCount);
        $remainingQuestions = $totalQuestions % $categoryCount;

        foreach ($this->questionsByCategory as $categoryId => $questions) {
            if (empty($questions) || !$questions[0] instanceof Question) {
                throw new \Exception("Les questions de la catégorie {$categoryId} ne sont pas des objets Question.");
            }

            shuffle($questions);

            $selectedQuestions = array_slice(
                $questions,
                0,
                $questionsPerCategory + ($remainingQuestions-- > 0 ? 1 : 0)
            );

            $balancedQuestions = array_merge($balancedQuestions, $selectedQuestions);
        }

        shuffle($balancedQuestions);

        return $balancedQuestions;
    }

    // Afficher les questions et leurs réponses en HTML
    public function displayQuestions(array $questions): void
    {
        echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Liste des Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .question-block {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .question-header {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .question-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        .responses {
            margin-left: 20px;
        }
        .response {
            margin: 5px 0;
            padding: 8px;
            background-color: #f1f8ff;
            border-radius: 4px;
        }
    </style>
</head>
<body>";

        foreach ($questions as $question) {
            echo "<div class='question-block'>";
            echo "<div class='question-header'>{$question->getText()}</div>";

            if ($question->getImage()) {
                echo "<img class='question-image' src='{$question->getImage()}' alt='Question relative à l'image'>";
            }

            echo "<div class='responses'><strong>Réponses :</strong>";

            try {
                $responses = $question->getResponses($this->pdo);

                foreach ($responses as $response) {
                    echo "<div class='response'>{$response['texte_option']}</div>";
                }
            } catch (\Exception $e) {
                echo "<div class='response'>Erreur lors du chargement des réponses : {$e->getMessage()}</div>";
            }

            echo "</div></div>";
        }

        echo "</body></html>";
    }
}