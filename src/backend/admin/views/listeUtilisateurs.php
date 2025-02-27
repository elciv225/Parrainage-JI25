<?php
// Récupération des données
require_once __DIR__ . "/../../../config/database.php";

$sql = "SELECT u.utilisateur_id, u.prenom, u.nom, u.email, u.date_creation, COALESCE(u.score_personnalite, 'non défini') AS score_personnalite, p.libelle_ji AS nom_promotion, COALESCE(pr.titre_profil, 'non définie') AS titre_profil
        FROM utilisateurs u
        LEFT JOIN promotion p ON u.id_promotion = p.id_promotion
        LEFT JOIN profil_personnalite pr ON u.id_profil = pr.id_profil
        ORDER BY u.utilisateur_id;
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-container">
    <h2>Liste des Utilisateurs</h2>
    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Date Création</th>
            <th>Promotion</th>
            <th>Score Personnalité</th>
            <th>Profil</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($utilisateurs)): ?>
            <tr>
                <td colspan="9" class="no-data">
                    <p>Aucun utilisateur trouvé.</p>
                    <button onclick="window.location.href='ajouter_utilisateur.php'">Ajouter un Utilisateur</button>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= $utilisateur['utilisateur_id'] ?></td>
                    <td><?= $utilisateur['nom'] ?></td>
                    <td><?= $utilisateur['prenom'] ?></td>
                    <td><?= $utilisateur['email'] ?></td>
                    <td><?= $utilisateur['date_creation'] ?></td>
                    <td><?= $utilisateur['nom_promotion'] ?></td>
                    <td><?= $utilisateur['score_personnalite'] ?></td>
                    <td><?= $utilisateur['titre_profil'] ?></td>
                    <td>
                        <!-- Ajoutez vos actions ici (ex: modifier, supprimer) -->
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>

    </table>
</div>