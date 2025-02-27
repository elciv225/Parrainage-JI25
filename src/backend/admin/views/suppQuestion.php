<div class="form-container">
    <h2>Supprimer une Question</h2>
    <form action="../Controllers/QuestionController.php" method="POST">
        <div class="form-group">
            <label for="question_id">Sélectionner la question à supprimer</label>
            <select id="question_id" name="question_id" required>
                <!-- Liste des questions -->
            </select>
        </div>
        <button type="submit" name="action" value="delete" class="btn-danger">Supprimer</button>
    </form>
</div>
