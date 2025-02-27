<div class="form-container">
    <h2>Modifier une Question</h2>
    <form action="../Controllers/QuestionController.php" method="POST">
        <div class="form-group">
            <label for="question_id">Sélectionner la question</label>
            <select id="question_id" name="question_id" required>
                <!-- Liste des questions -->
            </select>
        </div>
        <div class="form-group">
            <label for="question">Question</label>
            <textarea id="question" name="question"></textarea>
        </div>
        <button type="submit" name="action" value="update">Modifier</button>
    </form>
</div>
