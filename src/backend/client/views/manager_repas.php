<?php
use config\Database;

// Connexion à la base de données
$pdo = Database::getConnection();

// Ajouter un repas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_repas'])) {
    $nom_repas = $_POST['nom_repas'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $statut = $_POST['statut'];

    $stmt = $pdo->prepare("INSERT INTO repas (nom, description, prix, statut) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_repas, $description, $prix, $statut]);
    echo "Repas ajouté avec succès !<br>";
}

// Supprimer un repas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_repas'])) {
    $id_repas_supprimer = $_POST['id_repas_supprimer'];
    $stmt = $pdo->prepare("DELETE FROM repas WHERE id = ?");
    $stmt->execute([$id_repas_supprimer]);
    echo "Repas supprimé avec succès !<br>";
}

// Modifier un repas (Affichage du formulaire de modification)
if (isset($_GET['modifier_repas'])) {
    $id_repas_modifier = $_GET['modifier_repas'];
    $stmt = $pdo->prepare("SELECT * FROM repas WHERE id = ?");
    $stmt->execute([$id_repas_modifier]);
    $repas_a_modifier = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Modifier un repas (Traitement du formulaire de modification)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_repas_submit'])) {
    $id_repas = $_POST['id_repas'];
    $nom_repas = $_POST['nom_repas'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $statut = $_POST['statut'];

    $stmt = $pdo->prepare("UPDATE repas SET nom = ?, description = ?, prix = ?, statut = ? WHERE id = ?");
    $stmt->execute([$nom_repas, $description, $prix, $statut, $id_repas]);
    echo "Repas modifié avec succès !<br>";
}

// Lister les repas
$stmt = $pdo->query("SELECT * FROM repas");
$repas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Repas</title>
</head>
<body>
<h1>Gestion des Repas</h1>

<h2>Ajouter un repas</h2>
<form method="POST">
    <label for="nom_repas">Nom du repas :</label>
    <input type="text" name="nom_repas" id="nom_repas" required><br>

    <label for="description">Description :</label>
    <textarea name="description" id="description" required></textarea><br>

    <label for="prix">Prix :</label>
    <input type="number" name="prix" id="prix" required><br>

    <label for="statut">Statut :</label>
    <select name="statut" id="statut">
        <option value="disponible">Disponible</option>
        <option value="indisponible">Indisponible</option>
    </select><br>

    <button type="submit" name="ajouter_repas">Ajouter Repas</button>
</form>

<h2>Liste des repas</h2>
<?php if (count($repas) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($repas as $repas_item): ?>
            <tr>
                <td><?php echo $repas_item['id']; ?></td>
                <td><?php echo $repas_item['nom']; ?></td>
                <td><?php echo $repas_item['description']; ?></td>
                <td><?php echo $repas_item['prix']; ?></td>
                <td><?php echo $repas_item['statut']; ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id_repas_supprimer" value="<?php echo $repas_item['id']; ?>">
                        <button type="submit" name="supprimer_repas">Supprimer</button>
                    </form>
                    <a href="?modifier_repas=<?php echo $repas_item['id']; ?>">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun repas n'a été trouvé.</p>
<?php endif; ?>

<?php if (isset($repas_a_modifier)): ?>
    <h2>Modifier le repas</h2>
    <form method="POST">
        <input type="hidden" name="id_repas" value="<?php echo $repas_a_modifier['id']; ?>">

        <label for="nom_repas">Nom du repas :</label>
        <input type="text" name="nom_repas" id="nom_repas" value="<?php echo $repas_a_modifier['nom']; ?>" required><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required><?php echo $repas_a_modifier['description']; ?></textarea><br>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" id="prix" value="<?php echo $repas_a_modifier['prix']; ?>" required><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut">
            <option value="disponible" <?php if ($repas_a_modifier['statut'] === 'disponible') echo 'selected'; ?>>Disponible</option>
            <option value="indisponible" <?php if ($repas_a_modifier['statut'] === 'indisponible') echo 'selected'; ?>>Indisponible</option>
        </select><br>

        <button type="submit" name="modifier_repas_submit">Enregistrer les modifications</button>
    </form>
<?php endif; ?>
</body>
</html>