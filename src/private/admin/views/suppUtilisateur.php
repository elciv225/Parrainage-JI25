<div class="form-container">
    <h2>Supprimer un Utilisateur</h2>
    <form action="../Controllers/UserController.php" method="POST">
        <div class="form-group">
            <label for="user_id">Sélectionner l'utilisateur à supprimer</label>
            <select id="user_id" name="user_id" required>
                <!-- Liste des utilisateurs -->
            </select>
        </div>
        <button type="submit" name="action" value="delete" class="btn-danger">Supprimer</button>
    </form>
</div>
