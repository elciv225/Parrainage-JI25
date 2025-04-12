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

// Page des concours
Route::get('/concours', function () {
    View::render('concours', [
        'title' => 'Journée d\'Integration 2025 - Concours',
        'utilisateur' => $_SESSION['utilisateur'] ?? null
    ]);
});
// Page des question
Route::get('/question', function () {
    View::render('question', [
        'title' => 'Journée d\'Integration 2025 - Concours',
        'utilisateur' => $_SESSION['utilisateur'] ?? null
    ]);
});

// Page des repas
Route::get('/repas', function () {
    View::render('repas', [
        'title' => 'Journée d\'Integration 2025 - Repas',
        'utilisateur' => $_SESSION['utilisateur'] ?? null
    ]);
});

// Page pour accéder aux pages admin manager eliel
Route::get('/eliel', function () {
    View::render('manager_dashboard', [
        'title' => 'Journée d\'Integration 2025 - Eliel Admin - Tableau de Bord',
    ]);
});

// Page pour ajouter tout ce qui est concours et autre
Route::get('eliel/repas', function () {
    View::render('manager_repas', [
        'title' => 'Journée d\'Integration 2025 - Eliel Admin - Repas',
    ]);
});
// Page pour ajouter tout ce qui est concours et autre
Route::get('eliel/concours', function () {
    View::render('manager_participants', [
        'title' => 'Journée d\'Integration 2025 - Eliel Admin - Concours',
    ]);
});
// Page pour ajouter tout ce qui est concours et autre
Route::get('eliel/questions', function () {
    View::render('manager_questions', [
        'title' => 'Journée d\'Integration 2025 - Eliel Admin - Questions',
    ]);
});

// Ajout des traitements des formulaires
require_once "traitements.php";

// Exécuter la route
Route::run();

