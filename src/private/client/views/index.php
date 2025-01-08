<?php
// Récupérer les informations de l'utilisateur
$nom = htmlspecialchars($_SESSION['utilisateur']['nom']);
$prenom = htmlspecialchars($_SESSION['utilisateur']['prenom']);
?>

<div class="welcome-container">
    <h1>Bienvenue, <?php echo $prenom . ' ' . $nom; ?>!</h1>
    <p>Nous sommes ravis de vous voir ici.</p>
    <form method="post">
        <button type="submit" name="deconnexion" formmethod="post" >Se déconnecter</button>
    </form>
</div>