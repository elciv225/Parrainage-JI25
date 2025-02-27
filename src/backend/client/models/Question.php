<?php

namespace models;

use PDO;

class Question
{
    private ?int $question_id; // Peut être NULL si non défini avant l'insertion (ex : AUTO_INCREMENT)
    private string $texte_question;
    private ?string $img_question; // Peut être NULL dans la table
    private ?int $id_categorie; // Peut être NULL dans la table

    // Constructeur
    public function __construct(?int $question_id, string $texte_question, ?string $img_question = null, ?int $id_categorie = null)
    {
        $this->question_id = $question_id;
        $this->texte_question = $texte_question;
        $this->img_question = $img_question;
        $this->id_categorie = $id_categorie;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->question_id;
    }

    public function getText(): string
    {
        return $this->texte_question;
    }

    public function getImage(): ?string
    {
        return $this->img_question;
    }

    public function getCategoryId(): ?int
    {
        return $this->id_categorie;
    }

    // Setters
    public function setId(?int $question_id): void
    {
        $this->question_id = $question_id;
    }

    public function setText(string $texte_question): void
    {
        $this->texte_question = $texte_question;
    }

    public function setImage(?string $img_question): void
    {
        $this->img_question = $img_question;
    }

    public function setCategoryId(?int $id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    // Méthode pour récupérer les réponses de la question sous forme de tableau
    public function getResponses(PDO $pdo): array
    {
        // Vérifier que l'objet Question a un ID valide
        if (!$this->getId()) {
            throw new \Exception("Impossible de charger les réponses : l'ID de la question est null.");
        }

        // Requête SQL pour récupérer les réponses de la question
        $query = "SELECT option_id, texte_option, scores_personnalite
                  FROM parrainage.options_questions
                  WHERE question_id = :question_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':question_id', $this->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $responses = [];

        // Parcourir les résultats et les ajouter au tableau
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $responses[] = [
                'option_id' => $row['option_id'],
                'texte_option' => $row['texte_option'],
                'scores_personnalite' => $row['scores_personnalite']
            ];
        }

        return $responses;
    }
}