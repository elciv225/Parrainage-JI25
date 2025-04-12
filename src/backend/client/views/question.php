<?php
$utilisateur = $_SESSION['utilisateur'] ?? null;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="backend/client/assets/css/authentification.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
</head>
<body>
<div class="principal-container">
    <div class="section-droite">
        <div class="inscription" id="poserQ">
            <form method="post">
                <div class="header-form">
                    <h3>Posez votre question</h3>
                </div>
                <div class="body-form">
                    <div class="textarea-group" style="position: relative; z-index: 1000;">
                        <textarea placeholder="Veuillez  écrire ici"
                                  autocomplete="off" name="question"></textarea>
                        <label for="inscription-nom">Question</label>
                    </div

                </div>
                <div class="footer-form">
                    <?php if ($utilisateur): ?>
                        <button class="button-submit" type="submit" name="btn-inscription">
                            Soumettre
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button>
                    <?php else: ?>
                        <a href="/authentification" class="btn-voter">Connectez vous avant de voter</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Popup de message d'erreur/succès -->
<div id="popup-erreur" class="popup hidden">
    <div class="popup-content error-container">
        <h2 class="error-title" id="popup-title">Attention</h2>
        <p class="error-description" id="message-erreur">Votre message</p>
        <button id="fermer-popup" class="button button-primary">Fermer</button>
    </div>
</div>
<script type="module" src="backend/client/assets/js/authentification.js"></script>
</body>
</html>