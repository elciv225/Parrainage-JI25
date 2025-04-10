<?php
use config\Database;

// Connexion à la base de données
$pdo = Database::getConnection();

// Ajouter un participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_participant'])) {
    $role_participant = $_POST['role_participant'];

    $stmt = $pdo->prepare("INSERT INTO participants (role) VALUES (?)");
    $stmt->execute([$role_participant]);
    echo "Participant ajouté avec succès !<br>";
}

// Supprimer un participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_participant'])) {
    $id_participant_supprimer = $_POST['id_participant_supprimer'];
    $stmt = $pdo->prepare("DELETE FROM participants WHERE id_participant = ?");
    $stmt->execute([$id_participant_supprimer]);
    echo "Participant supprimé avec succès !<br>";
}

// Modifier un participant (Affichage du formulaire de modification)
if (isset($_GET['modifier_participant'])) {
    $id_participant_modifier = $_GET['modifier_participant'];
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE id_participant = ?");
    $stmt->execute([$id_participant_modifier]);
    $participant_a_modifier = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Modifier un participant (Traitement du formulaire de modification)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_participant_submit'])) {
    $id_participant = $_POST['id_participant'];
    $role_participant = $_POST['role_participant'];

    $stmt = $pdo->prepare("UPDATE participants SET role = ? WHERE id_participant = ?");
    $stmt->execute([$role_participant, $id_participant]);
    echo "Participant modifié avec succès !<br>";
}

// Lister les participants
$stmt = $pdo->query("SELECT * FROM participants");
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Participants</title>
</head>
<body>
<h1>Gestion des Participants</h1>

<h2>Ajouter un participant</h2>
<form method="POST">
    <label for="role_participant">Rôle :</label>
    <select name="role_participant" id="role_participant" required>
        <option value="roi">Roi</option>
        <option value="reine">Reine</option>
    </select><br>

    <button type="submit" name="ajouter_participant">Ajouter Participant</button>
</form>

<h2>Liste des participants</h2>
<?php if (count($participants) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Rôle</th>
            <th>Date d'inscription</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?php echo $participant['id_participant']; ?></td>
                <td><?php echo $participant['role']; ?></td>
                <td><?php echo $participant['date_inscription']; ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id_participant_supprimer" value="<?php echo $participant['id_participant']; ?>">
                        <button type="submit" name="supprimer_participant">Supprimer</button>
                    </form>
                    <a href="?modifier_participant=<?php echo $participant['id_participant']; ?>">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun participant n'a été trouvé.</p>
<?php endif; ?>

<?php if (isset($participant_a_modifier)): ?>
    <h2>Modifier le participant</h2>
    <form method="POST">
        <input type="hidden" name="id_participant" value="<?php echo $participant_a_modifier['id_participant']; ?>">

        <label for="role_participant">Rôle :</label>
        <select name="role_participant" id="role_participant" required>
            <option value="roi" <?php if ($participant_a_modifier['role'] === 'roi') echo 'selected'; ?>>Roi</option>
            <option value="reine" <?php if ($participant_a_modifier['role'] === 'reine') echo 'selected'; ?>>Reine</option>
        </select><br>

        <button type="submit" name="modifier_participant_submit">Enregistrer les modifications</button>
    </form>
<?php endif; ?>
</body>
</html>