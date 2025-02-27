<?php
require_once __DIR__ . "/../../../config/database.php";

// Modification de la requête pour inclure les scores
$query = $pdo->query("
    SELECT q.question_id, q.texte_question, q.img_question, cq.titre_categorie as categorie,
           GROUP_CONCAT(CONCAT(oq.texte_option, '|', COALESCE(oq.scores_personnalite, 0)) SEPARATOR '||') as options
    FROM questionnaire q
    LEFT JOIN categorie_question cq ON q.id_categorie = cq.id_categorie 
    LEFT JOIN options_questions oq ON q.question_id = oq.question_id
    GROUP BY q.question_id, q.texte_question, cq.titre_categorie
");

$questions = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    if ($row['options']) {
        $optionsArray = explode('||', $row['options']);
        $row['options'] = array_map(function($option) {
            list($texte, $score) = explode('|', $option);
            return [
                'texte_option' => $texte,
                'score' => $score
            ];
        }, $optionsArray);
    } else {
        $row['options'] = [];
    }
    $questions[] = $row;
}
?>

<div class="content-container">
    <h2>Liste des Questions</h2>
    <div class="questions-grid">
        <?php foreach($questions as $question): ?>
            <div class="question-card">
                <?php if(!empty($question['img_question'])): ?>
                    <div class="question-image">
                        <?php echo $question['img_question']; ?>
                        <img src="<?=$question['img_question'] ?>" alt="Image de la question">
                    </div>
                <?php endif; ?>

                <div class="question-content">
                    <h3 class="question-title"><?php echo htmlspecialchars($question['texte_question']); ?></h3>
                    <div class="question-category">
                        Catégorie: <?php echo htmlspecialchars($question['categorie']); ?>
                    </div>

                    <div class="options-container">
                        <h4>Options de réponse:</h4>
                        <?php if(!empty($question['options'])): ?>
                            <ul class="options-list">
                                <?php foreach($question['options'] as $option): ?>
                                    <li>
                                        <span class="option-text"><?php echo htmlspecialchars($option['texte_option']); ?></span>
                                        <span class="option-score">(Score: <?php echo htmlspecialchars($option['score']); ?>)</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Aucune option disponible</p>
                        <?php endif; ?>
                    </div>

                    <div class="question-actions">
                        <a href="modifQuestion.php?id=<?php echo $question['question_id']; ?>" class="btn-edit">Modifier</a>
                        <a href="suppQuestion.php?id=<?php echo $question['question_id']; ?>" class="btn-delete">Supprimer</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .questions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .question-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.2s;
    }

    .question-card:hover {
        transform: translateY(-5px);
    }

    .question-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .question-content {
        padding: 15px;
    }

    .question-title {
        font-size: 1.2em;
        margin-bottom: 10px;
        color: #333;
    }

    .question-category {
        color: #666;
        font-size: 0.9em;
        margin-bottom: 15px;
    }

    .options-list {
        list-style: none;
        padding: 0;
    }

    .options-list li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }

    .option-score {
        color: #666;
        font-size: 0.9em;
    }

    .question-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-edit, .btn-delete {
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
    }

    .btn-edit {
        background-color: #4CAF50;
    }

    .btn-delete {
        background-color: #f44336;
    }
</style>
