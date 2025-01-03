<?php
require_once __DIR__ . "/../../../config/database.php";
if (isset($_POST['ajoutUtilisateur'])) {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $promotion = intval($_POST['annee_promotion']);

    // Vérification si l'email existe déjà
    $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->fetchColumn() > 0) {
        // L'email existe déjà
        $_SESSION['error'] = "Un utilisateur avec cet email existe déjà.";
    } else {
        // Insertion du nouvel utilisateur
        $query = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, id_promotion) VALUES (?, ?, ?, ?)");
        try {
            $query->execute([$nom, $prenom, $email, $promotion]);
            $_SESSION['success'] = "Utilisateur ajouté avec succès.";
            header("Location: index.php?page=ajoutUtilisateur");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'insertion de l'utilisateur\nErreur : " . $e;
        }
    }
}

// Récuperation des promotions
$sql = "SELECT id_promotion, libelle_ji FROM promotion ORDER BY libelle_ji DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="form-container">
    <h2>Ajouter un Utilisateur</h2>
    <form method="POST">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="100">
        </div>
        <div class="form-group">
            <label for="annee_promotion">Promotion</label>
            <select name="annee_promotion" id="annee_promotion" required>
                <option value="">Sélectionnez une promotion</option>
                <?php foreach ($promotions as $promotion): ?>
                    <option value="<?= $promotion['id_promotion'] ?>">
                        <?= $promotion['libelle_ji'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="ajoutUtilisateur">Ajouter</button>
    </form>
</div>