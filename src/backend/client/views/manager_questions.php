<?php
use config\Database;

// Connexion à la base de données
$pdo = Database::getConnection();

// Marquer une question comme lue
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marquer_comme_lue'])) {
    $id_question_lue = $_POST['id_question'];
    // Ici, vous pouvez ajouter une logique pour enregistrer que la question a été lue.
    // Par exemple, vous pourriez ajouter un champ `est_lue` à la table `questions_posees`
    // et le mettre à jour ici. Pour cet exemple simple, nous allons juste afficher un message.
    echo "Question ID " . $id_question_lue . " marquée comme lue.<br>";
    // Si vous aviez un champ 'est_lue', la requête SQL ressemblerait à :
    // $stmt = $pdo->prepare("UPDATE questions_posees SET est_lue = 1 WHERE id = ?");
    // $stmt->execute([$id_question_lue]);
}

// Récupérer toutes les questions posées
$stmt = $pdo->query("SELECT * FROM questions_posees ORDER BY date_question DESC");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Questions Posées</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 20px;
        }

        h1 {
            color: #337ab7;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        thead th {
            background-color: #337ab7;
            color: white;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        td label {
            margin-left: 5px;
        }

        button[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #4cae4c;
        }

        p {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
<h1>Questions Posées</h1>

<?php if (count($questions) > 0): ?>
    <form method="POST">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur ID</th>
                <th>Question</th>
                <th>Date de la question</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?php echo $question['id']; ?></td>
                    <td><?php echo $question['utilisateur_id']; ?></td>
                    <td><?php echo htmlspecialchars($question['question']); ?></td>
                    <td><?php echo $question['date_question']; ?></td>
                    <td>
                        <input type="checkbox" name="questions_lues[]" value="<?php echo $question['id']; ?>">
                        <label for="questions_lues_<?php echo $question['id']; ?>">Marquer comme lue</label>
                        <input type="hidden" name="id_question" value="<?php echo $question['id']; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="marquer_comme_lue">Enregistrer les lectures</button>
    </form>
<?php else: ?>
    <p>Aucune question n'a été posée pour le moment.</p>
<?php endif; ?>
</body>
</html>