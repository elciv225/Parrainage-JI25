<?php

use config\Route;
use config\View;

/* === Gestion des routes === */

// Initialiser l'URL courante
Route::init($_GET['url'] ?? '/');

// Définir les routes
Route::get('/', function () {
    View::render('accueil', [
        'title' => 'Journée d\'Integration 2025 - Accueil',
        'utilisateur' => $_SESSION['utilisateur'] ?? null
    ]);
});

Route::get('/maintenance', function () {
    View::render('maintenance', [
        'title' => 'Journée d\'Integration 2025 - Page en maintenance veillez revenir plutard'
    ]);
});
Route::get('/test', function () {
    View::render('test', [
        'title' => 'Journée d\'Integration 2025 - Page en maintenance - test '
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
            header('Location: /backend/admin/index.php');
            exit();
        }
    } else {
        // Si le login est incorrect, rediriger vers la page d'accueil
        header('Location: /');
        exit();
    }
});

// Page authentification
Route::get('/authentification', function () {
    View::render('authentification', [
        'title' => 'Journée d\'Integration 2025 - Authentification'
    ]);
});

// Ajout des traitements des formulaires
require_once "traitements.php";

// Exécuter la route
Route::run();

