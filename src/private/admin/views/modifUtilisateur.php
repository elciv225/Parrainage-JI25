<div class="form-container">
    <h2>Modifier un Utilisateur</h2>
    <form action="../Controllers/UserController.php" method="POST">
        <div class="form-group">
            <label for="user_id">Sélectionner l'utilisateur</label>
            <select id="user_id" name="user_id" required>
                <!-- Liste des utilisateurs -->
            </select>
        </div>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom">
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <button type="submit" name="action" value="update">Modifier</button>
    </form>
</div>
