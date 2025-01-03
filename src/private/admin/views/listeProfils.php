<div class="content-container">
    <h2>Liste des Types de Personnalité</h2>
    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom du type</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($types as $type): ?>
            <tr>
                <td><?php echo htmlspecialchars($type['type_id']); ?></td>
                <td><?php echo htmlspecialchars($type['nom_type']); ?></td>
                <td><?php echo htmlspecialchars($type['description']); ?></td>
                <td><?php echo $type['est_actif'] ? 'Actif' : 'Inactif'; ?></td>
                <td>
                    <a href="modifProfil.php?id=<?php echo $type['type_id']; ?>" class="btn-edit">Modifier</a>
                    <a href="suppProfil.php?id=<?php echo $type['type_id']; ?>" class="btn-delete">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
