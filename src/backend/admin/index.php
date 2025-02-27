<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Parrainage - Administration</title>
</head>

<body>

<nav class="sidebar">
    <div class="menu-item">
        <button class="menu-button active">
            <div class="menu-button-content">
                <!-- Icone -->
                <span>Dashboard</span>
            </div>
            <!-- Icone -->
        </button>
    </div>

    <div class="menu-item">
        <button class="menu-button">
            <div class="menu-button-content">
                <!-- Icone -->
                <span>Utilisateurs</span>
            </div>
            <!-- Icone -->
        </button>
        <div class="submenu">
            <a href="?page=listeUtilisateur">Liste des utilisateurs</a>
            <a href="?page=ajoutUtilisateur">Ajouter un utilisateur</a>
            <a href="?page=suppUtilisateur">Supprimer un utilisateur</a>
            <a href="?page=modifUtilisateur">Modifier un utilisateur</a>
        </div>
    </div>
    <div class="menu-item">
        <button class="menu-button">
            <div class="menu-button-content">
                <!-- Icone -->
                <span>Question</span>
            </div>
            <!-- Icone -->
        </button>
        <div class="submenu">
            <a href="?page=listeQuestion">Afficher question</a>
            <a href="?page=ajoutQuestion">Ajouter question</a>
            <a href="?page=modifQuestion">Modifier question</a>
            <a href="?page=suppQuestion">Supprimer question</a>
        </div>
    </div>
    <div class="menu-item">
        <button class="menu-button">
            <div class="menu-button-content">
                <!-- Icone -->
                <span>Profil Personnalité</span>
            </div>
            <!-- Icone -->
        </button>
        <div class="submenu">
            <a href="?page=listProfil">Afficher profils</a>
            <a href="?page=ajoutProfil">Ajouter profil</a>
            <a href="?page=modifProfil">Modifier profil</a>
            <a href="?page=suppProfil">Supprimer profil</a>
        </div>
    </div>
    <div class="menu-item">
        <button class="menu-button">
            <div class="menu-button-content">
                <!-- Icone -->
                <span>Parrainages</span>
            </div>
            <!-- Icone -->
        </button>
        <div class="submenu">
            <a href="?page=resultParrainage">Afficher parrainage</a>
            <a href="?page=lancerParrainage">Lancer parrainage</a>
        </div>
    </div>
</nav>

<main class="zone-dynamique">
    <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'listeUtilisateur':
                include 'views/listeUtilisateurs.php';
                break;
            case 'ajoutUtilisateur':
                include 'views/ajoutUtilisateur.php';
                break;
            case 'suppUtilisateur':
                include 'views/suppUtilisateur.php';
                break;
            case 'modifUtilisateur':
                include 'views/modifUtilisateur.php';
                break;
            case 'listeQuestion':
                include 'views/listeQuestions.php';
                break;
            case 'ajoutQuestion':
                include 'views/ajoutQuestion.php';
                break;
            case 'modifQuestion':
                include 'views/modifQuestion.php';
                break;
            case 'suppQuestion':
                include 'views/suppQuestion.php';
                break;
            case 'listProfil':
                include 'views/listeProfils.php';
                break;
            case 'ajoutProfil':
                include 'views/ajoutProfil.php';
                break;
            case 'modifProfil':
                include 'views/modifProfil.php';
                break;
            case 'suppProfil':
                include 'views/suppProfil.php';
                break;
            case 'resultParrainage':
                include 'views/resultatParrainage.php';
                break;
            case 'lancerParrainage':
                include 'views/lancerParrainage.php';
                break;
            default:
                include 'views/dashboard.php';
        }
    } else {
        include 'views/dashboard.php';
    }
    ?>
</main>
<script>
    // Fonction pour la notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.classList.add('notification', type);
        notification.textContent = message;

        document.body.appendChild(notification);

        // Animation d'entrée
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);


        // Suppression automatique après 3 secondes
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);

    }
</script>

<!-- Pop notification -->
<?php
if (isset($_SESSION['success'])) {
    // Utilisation de json_encode pour s'assurer que le texte est correctement échappé
    echo "<script>showNotification(" . json_encode($_SESSION['success']) . ", 'success');</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>showNotification(" . json_encode($_SESSION['error']) . ", 'error');</script>";
    unset($_SESSION['error']);
}
?>


</body>
<!-- Déplacer le script sidebar.js après le script de notification -->
<script src="assets/js/sidebar.js"></script>

</html>