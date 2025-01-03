<?php
require_once __DIR__ . "/../../../config/database.php";
if (isset($_POST['ajoutQuestion'])) {
    // Récupération des données du formulaire
    $texteQuestion = htmlspecialchars($_POST['texte_question']);
    $categorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : null;
    $reponses = json_decode($_POST['reponses'], true);

    // Gestion de l'upload d'image
    $imgQuestion = null;
    if(isset($_FILES['img_question']) && $_FILES['img_question']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['img_question']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if(in_array(strtolower($filetype), $allowed)) {
            // Créer un nom de fichier basé sur le texte de la question
            $questionSlug = preg_replace('/[^a-z0-9]+/', '-', strtolower($texteQuestion));
            $questionSlug = substr($questionSlug, 0, 50); // Limiter la longueur
            $newName = $questionSlug . '-' . time() . '.' . $filetype;

            $uploadDir = __DIR__ . '/../../uploads/';

            // Créer le répertoire s'il n'existe pas
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadPath = $uploadDir . $newName;

            if(move_uploaded_file($_FILES['img_question']['tmp_name'], $uploadPath)) {
                $imgQuestion = '../../src/uploads/' . $newName;
            } else {
                $_SESSION['error'] = "Erreur lors du téléchargement de l'image";
            }
        }
    }

    // Insertion de la question
    $queryQuestion = $pdo->prepare("INSERT INTO questionnaire (texte_question, id_categorie, img_question) VALUES (?, ?, ?)");

    try {
        $pdo->beginTransaction();

        // Insertion de la question
        $queryQuestion->execute([$texteQuestion, $categorie, $imgQuestion]);
        $questionId = $pdo->lastInsertId();

        // Insertion des réponses
        if (!empty($reponses)) {
            $queryReponses = $pdo->prepare("INSERT INTO options_questions (question_id, texte_option, scores_personnalite) VALUES (?, ?, ?)");

            foreach ($reponses as $reponse) {
                $scoresJson = json_encode(['score' => floatval($reponse['score_personnalite'])]);
                $queryReponses->execute([
                    $questionId,
                    htmlspecialchars($reponse['texte']),
                    $scoresJson
                ]);
            }
        }

        $pdo->commit();
        $_SESSION['success'] = "Question et réponses ajoutées avec succès.";
        header("Location: index.php?page=ajoutQuestion");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors de l'ajout de la question : " . $e->getMessage();
    }
}

// Ajouter cette requête avant le formulaire HTML
$queryCategories = $pdo->query("SELECT id_categorie, titre_categorie FROM categorie_question ORDER BY titre_categorie");
$categories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="form-container">
    <h2>Ajouter une Question</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="texte_question">Question</label>
            <textarea id="texte_question" name="texte_question" required></textarea>
        </div>
        <div class="form-group">
            <label for="img_question">Image (optionnelle)</label>
            <input type="file" id="img_question" name="img_question" accept="image/*">
            <small>Formats acceptés: JPG, JPEG, PNG, GIF</small>
        </div>
        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select id="categorie" name="categorie" required>
                <option value="">Veuillez choisir une catégorie</option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie['id_categorie'] ?>"><?= htmlspecialchars($categorie['titre_categorie']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Réponses</label>
            <div id="reponses-container">
                <div class="reponse-item">
                    <input type="text" class="reponse-input" placeholder="Entrez une réponse">
                    <input type="number" step="0.01" class="score-input" placeholder="Score personnalité" min="0" max="100">
                    <button type="button" class="btn-remove-reponse">-</button>
                </div>
            </div>
            <button type="button" id="btn-add-reponse">+</button>
            <input type="hidden" name="reponses" id="reponses-json">
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById('reponses-container');
                const addButton = document.getElementById('btn-add-reponse');
                const reponsesInput = document.getElementById('reponses-json');

                function updateReponsesJson() {
                    const reponses = [];
                    document.querySelectorAll('.reponse-item').forEach(item => {
                        const texte = item.querySelector('.reponse-input').value.trim();
                        const score = item.querySelector('.score-input').value;
                        if (texte) {
                            reponses.push({
                                texte: texte,
                                score_personnalite: parseFloat(score)
                            });
                        }
                    });
                    reponsesInput.value = JSON.stringify(reponses);
                }

                function createReponseItem() {
                    const div = document.createElement('div');
                    div.className = 'reponse-item';
                    div.innerHTML = `
                        <input type="text" class="reponse-input" placeholder="Entrez une réponse">
                        <input type="number" step="0.01" class="score-input" placeholder="Score personnalité" min="0" max="100">
                        <button type="button" class="btn-remove-reponse">-</button>
                    `;

                    div.querySelector('.btn-remove-reponse').addEventListener('click', function () {
                        div.remove();
                        updateReponsesJson();
                    });

                    div.querySelector('.reponse-input').addEventListener('input', updateReponsesJson);
                    div.querySelector('.score-input').addEventListener('input', updateReponsesJson);

                    return div;
                }

                addButton.addEventListener('click', function () {
                    container.appendChild(createReponseItem());
                });

                // Initialize first input listeners
                document.querySelector('.reponse-input').addEventListener('input', updateReponsesJson);
                document.querySelector('.score-input').addEventListener('input', updateReponsesJson);
                document.querySelector('.btn-remove-reponse').addEventListener('click', function (e) {
                    e.target.closest('.reponse-item').remove();
                    updateReponsesJson();
                });
            });
        </script>
        <button type="submit" name="ajoutQuestion" value="create">Ajouter</button>
    </form>
</div>