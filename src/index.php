<?php
session_start();

require_once __DIR__ . "/vendor/autoload.php";

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Vérifie si l'utilisateur est connecté
$_SESSION['isConnect'] = true; // Simule une connexion utilisateur

// Récupération des paramètres GET
$verif_admin = $_GET['admin_login'] ?? ""; // Par défaut, vide
$admin_login = "JI";
$admin_key = "25";

/* === Connexion à l'admin === */
if ($verif_admin === $_ENV['ADMIN_LOGIN']) {
    $key = $_GET['admin_key'] ?? null; // Vérifie si la clé est fournie

    // Si la clé est correcte
    if ($key !== $_ENV['ADMIN_KEY']) {
        http_response_code(403); // Accès interdit
        echo "Tchrrr";
        require_once 'private/index.php'; // Charge la page par défaut
    } else { // C'est l'admin
        header('Location: private/admin/index.php'); // Redirige vers l'admin
        exit();
    }
}

// Afficher la page de connexion classique
require_once 'private/index.php';
?>
<a href="?admin_login=JI&admin_key=25" style="display: none">Admin Mode</a>
<a href="private/client/traitements/test.php"
    style="position: absolute; bottom: 50px;">
    Partir dans les tests du parrainage
</a>
