<div class="form-container">
    <h2>Lancer un Nouveau Parrainage</h2>
    <form action="../Controllers/ParrainageController.php" method="POST">
        <div class="form-group">
            <label for="promotion">Promotion concernée</label>
            <select id="promotion" name="promotion" required>
                <!-- Liste des promotions -->
            </select>
        </div>
        <div class="form-group">
            <label for="date_limite">Date limite</label>
            <input type="date" id="date_limite" name="date_limite" required>
        </div>
        <button type="submit" name="action" value="launch">Lancer le parrainage</button>
    </form>
</div>
