<div class="content-container">
    <h2>Résultats des Parrainages</h2>
    <table class="data-table">
        <thead>
        <tr>
            <th>ID Relation</th>
            <th>Parrain</th>
            <th>Filleul</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Statut</th>
            <th>Score de compatibilité</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($parrainages as $parrainage): ?>
            <tr>
                <td><?php echo htmlspecialchars($parrainage['relation_id']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['parrain_nom']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['filleul_nom']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['date_debut']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['date_fin']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['statut']); ?></td>
                <td><?php echo htmlspecialchars($parrainage['score_compatibilite']); ?></td>
                <td>
                    <a href="modifParrainage.php?id=<?php echo $parrainage['relation_id']; ?>" class="btn-edit">Modifier</a>
                    <a href="suppParrainage.php?id=<?php echo $parrainage['relation_id']; ?>" class="btn-delete">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
