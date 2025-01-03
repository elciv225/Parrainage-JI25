<div class="form-container">
    <h2>Supprimer un Profil</h2>
    <form action="../Controllers/ProfilController.php" method="POST">
        <div class="form-group">
            <label for="profil_id">Sélectionner le profil à supprimer</label>
            <select id="profil_id" name="profil_id" required>
                <!-- Liste des profils -->
            </select>
        </div>
        <button type="submit" name="action" value="delete" class="btn-danger">Supprimer</button>
    </form>
</div>
