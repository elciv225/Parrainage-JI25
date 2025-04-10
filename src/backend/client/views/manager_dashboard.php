<?php
use config\Database;

// Connexion à la base de données
$pdo = Database::getConnection();

// Récupérer les statistiques pour les repas
$totalRepas = $pdo->query("SELECT COUNT(*) FROM repas")->fetchColumn();
$repasDisponibles = $pdo->query("SELECT COUNT(*) FROM repas WHERE statut = 'disponible'")->fetchColumn();
$repasIndisponibles = $pdo->query("SELECT COUNT(*) FROM repas WHERE statut = 'indisponible'")->fetchColumn();
$commandesEnAttente = $pdo->query("SELECT COUNT(*) FROM commandes_repas WHERE statut = 'en_attente'")->fetchColumn();
$commandesLivrees = $pdo->query("SELECT COUNT(*) FROM commandes_repas WHERE statut = 'livre'")->fetchColumn();

// Récupérer les statistiques pour les participants
$totalParticipants = $pdo->query("SELECT COUNT(*) FROM participants")->fetchColumn();
$nombreDeRois = $pdo->query("SELECT COUNT(*) FROM participants WHERE role = 'roi'")->fetchColumn();
$nombreDeReines = $pdo->query("SELECT COUNT(*) FROM participants WHERE role = 'reine'")->fetchColumn();

// Récupérer les statistiques pour les votes
$totalVotesProjet = $pdo->query("SELECT COUNT(*) FROM votes_projet")->fetchColumn();
$totalVotesRoi = $pdo->query("SELECT COUNT(*) FROM votes_roi")->fetchColumn();
$totalVotesReine = $pdo->query("SELECT COUNT(*) FROM votes_reine")->fetchColumn();

// Récupérer les statistiques pour les questions
$totalQuestionsPosees = $pdo->query("SELECT COUNT(*) FROM questions_posees")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Journée d'Intégration 2025</title>
</head>
<body>
<h1>Tableau de Bord - Administration</h1>

<section>
    <h2>Statistiques des Repas</h2>
    <ul>
        <li><strong>Total des repas enregistrés :</strong> <?php echo $totalRepas; ?></li>
        <li><strong>Repas disponibles :</strong> <?php echo $repasDisponibles; ?></li>
        <li><strong>Repas indisponibles :</strong> <?php echo $repasIndisponibles; ?></li>
        <li><strong>Commandes de repas en attente :</strong> <?php echo $commandesEnAttente; ?></li>
        <li><strong>Commandes de repas livrées :</strong> <?php echo $commandesLivrees; ?></li>
    </ul>
</section>

<section>
    <h2>Statistiques des Participants au Concours</h2>
    <ul>
        <li><strong>Total des participants :</strong> <?php echo $totalParticipants; ?></li>
        <li><strong>Nombre de rois inscrits :</strong> <?php echo $nombreDeRois; ?></li>
        <li><strong>Nombre de reines inscrites :</strong> <?php echo $nombreDeReines; ?></li>
    </ul>
</section>

<section>
    <h2>Statistiques des Votes</h2>
    <ul>
        <li><strong>Total des votes pour les projets :</strong> <?php echo $totalVotesProjet; ?></li>
        <li><strong>Total des votes pour le roi :</strong> <?php echo $totalVotesRoi; ?></li>
        <li><strong>Total des votes pour la reine :</strong> <?php echo $totalVotesReine; ?></li>
    </ul>
</section>

<section>
    <h2>Statistiques des Questions</h2>
    <ul>
        <li><strong>Total des questions posées :</strong> <?php echo $totalQuestionsPosees; ?></li>
    </ul>
</section>

<p><a href="eliel/repas">Gérer les Repas</a></p>
<p><a href="eliel/concours">Gérer les Participants au Concours</a></p>
<p><a href="eliel/questions">Gérer les Questions</a></p>

</body>
</html>