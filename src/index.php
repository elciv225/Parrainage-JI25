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

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.ico">
    <style>

        /* Loader */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--background-secondary);
            z-index: 9999;
            transition: opacity 0.8s ease-in-out, filter 0.8s ease-in-out;
        }

        .loader {
            color: var(--text-primary);
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-size: 25px;
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
            height: 40px;
            padding: 10px 10px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            border-radius: 8px;
        }

        .words {
            overflow: hidden;
            position: relative;
        }

        .word {
            display: block;
            height: 100%;
            padding-left: 6px;
            color: var(--primary-color);
            animation: spin_4991 4s infinite;
        }

        @keyframes spin_4991 {
            10% {
                -webkit-transform: translateY(-102%);
                transform: translateY(-102%);
            }
            25% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
            }
            35% {
                -webkit-transform: translateY(-202%);
                transform: translateY(-202%);
            }
            50% {
                -webkit-transform: translateY(-200%);
                transform: translateY(-200%);
            }
            60% {
                -webkit-transform: translateY(-302%);
                transform: translateY(-302%);
            }
            75% {
                -webkit-transform: translateY(-300%);
                transform: translateY(-300%);
            }
            85% {
                -webkit-transform: translateY(-402%);
                transform: translateY(-402%);
            }
            100% {
                -webkit-transform: translateY(-400%);
                transform: translateY(-400%);
            }
        }

        /* Classe pour l'effet de flou et disparition */
        .loader-container.hide {
            opacity: 0;
            filter: blur(15px);
            pointer-events: none;
        }
    </style>
</head>
<body>
<!-- Loader -->
<div class="loader-container" id="loaderContainer">
    <div class="loader">
        <p>Prêt ?</p>
        <div class="words">
            <span class="word">A réseauter  ?</span>
            <span class="word">A manger ?</span>
            <span class="word">A intégrer ?</span>
            <span class="word">A danser ?</span>
            <span class="word">A échanger ?</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loaderContainer = document.getElementById('loaderContainer');
        const contentContainer = document.getElementById('contentContainer');

        function hideLoader() {
            loaderContainer.classList.add('hide');
            setTimeout(() => {
                setTimeout(() => {
                    loaderContainer.style.display = 'none';
                }, 800);
            }, 400);
        }

        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', function () {
                setTimeout(hideLoader, 1000);
            });
            setTimeout(hideLoader, 5000);
        }
    });
</script>
</body>
</html>

