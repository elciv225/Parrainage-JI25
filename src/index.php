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

require_once __DIR__ . "/vendor/autoload.php";

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Chargement du fichier du routeur
require_once 'backend/client/routes/web.php';

// Gestion du site en maintenance
// Vérifier si maintenance.lock existe
if (file_exists(__DIR__ . '/maintenance.lock')) {
    if ($_SERVER['REQUEST_URI'] !== '/maintenance') {
        header("Location: /maintenance");
        exit;
    }
}


