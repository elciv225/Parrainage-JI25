<?php

// Démarrer une session sécurisée
session_start([
    'cookie_lifetime' => 0,            // Expire à la fermeture du navigateur
    'cookie_httponly' => true,         // Rend les cookies accessibles uniquement par HTTP
    'cookie_secure' => isset($_SERVER['HTTPS']), // Active les cookies sécurisés si HTTPS est activé
    'use_strict_mode' => true,         // Empêche le vol d'ID de session
    'use_only_cookies' => true,        // Utilise uniquement les cookies pour stocker les sessions
    'sid_length' => 48,                // Longueur de l'ID de session
    'sid_bits_per_character' => 6,     // Augmente l'entropie de l'ID de session
]);

use config\Route;
use config\View;

require_once __DIR__ . "/vendor/autoload.php";


// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Protection contre les attaques CSRF (générer un token si nécessaire)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* === Gestion des routes === */

// Initialiser l'URL courante
Route::init($_GET['url'] ?? '/');


// Définir les routes
Route::get('/', function () {
    View::render('accueil',[
            'title'=>'Journée d\'Integration 2025 - Accueil'
    ]);
});

// Page admin
Route::get('/admin', function () {
    // Récupération sécurisée des paramètres GET
    $login = isset($_GET['admin_login']) ? htmlspecialchars($_GET['admin_login'], ENT_QUOTES, 'UTF-8') : "";
    $key = isset($_GET['admin_key']) ? htmlspecialchars($_GET['admin_key'], ENT_QUOTES, 'UTF-8') : "";

    // Vérification des paramètres
    if ($login === $_ENV['ADMIN_LOGIN']) {
        if ($key !== $_ENV['ADMIN_KEY']) {
            http_response_code(403);
            // Page accès interdit
            View::render('403');
        } else {
            // Redirection vers l'administration pour un utilisateur valide
            header('Location: /private/admin/index.php');
            exit();
        }
    } else {
        // Si le login est incorrect, rediriger vers la page d'accueil
        header('Location: /');
        exit();
    }
});

// Page authentification
Route::get('/authentification', function (){
    View::render('authentification',[
        'title'=>'Journée d\'Integration 2025 - Authentification'
    ]);
});

require_once 'private/client/routes/traitements.php';

// Exécuter la route
Route::run();
