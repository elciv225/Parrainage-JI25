<div class="form-container">
    <h2>Modifier un Profil</h2>
    <form action="../Controllers/ProfilController.php" method="POST">
        <div class="form-group">
            <label for="profil_id">Sélectionner le profil</label>
            <select id="profil_id" name="profil_id" required>
                <!-- Liste des profils -->
            </select>
        </div>
        <div class="form-group">
            <label for="nom">Nom du profil</label>
            <input type="text" id="nom" name="nom">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <button type="submit" name="action" value="update">Modifier</button>
    </form>
</div>
