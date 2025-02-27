<div class="form-container">
    <h2>Ajouter un Type de Personnalité</h2>
    <form action="../Controllers/TypePersonnaliteController.php" method="POST">
        <div class="form-group">
            <label for="nom_type">Nom du type</label>
            <input type="text" id="nom_type" name="nom_type" required maxlength="50">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="est_actif">Statut</label>
            <select id="est_actif" name="est_actif">
                <option value="1">Actif</option>
                <option value="0">Inactif</option>
            </select>
        </div>
        <button type="submit" name="action" value="create">Ajouter</button>
    </form>
</div>
