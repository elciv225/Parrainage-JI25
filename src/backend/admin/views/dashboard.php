<div class="dashboard-container">
    <h1>Tableau de bord administrateur</h1>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Utilisateurs</h3>
            <p class="stat-number"><?php echo $totalUtilisateurs; ?></p>
            <div class="stat-details">
                <p>Actifs: <?php echo $utilisateursActifs; ?></p>
                <p>Par génération: <?php echo $utilisateursParGeneration; ?></p>
            </div>
        </div>
        <div class="stat-card">
            <h3>Parrainages</h3>
            <p class="stat-number"><?php echo $totalParrainages; ?></p>
            <div class="stat-details">
                <p>Actifs: <?php echo $parrainagesActifs; ?></p>
                <p>Terminés: <?php echo $parrainagesTermines; ?></p>
            </div>
        </div>
        <div class="stat-card">
            <h3>Questions</h3>
            <p class="stat-number"><?php echo $totalQuestions; ?></p>
            <div class="stat-details">
                <p>Actives: <?php echo $questionsActives; ?></p>
                <p>Par catégorie: <?php echo $questionsParCategorie; ?></p>
            </div>
        </div>
        <div class="stat-card">
            <h3>Types de Personnalité</h3>
            <p class="stat-number"><?php echo $totalTypes; ?></p>
            <div class="stat-details">
                <p>Actifs: <?php echo $typesActifs; ?></p>
            </div>
        </div>
    </div>
</div>
