<?php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="private/client/assets/css/styles.css">
    <title>JI 2025</title>
</head>
<body>

<div class="principal-container">
    <div class="section-gauche">

    </div>
    <div class="section-droite">
        <div class="inscription" id="inscription">
            <form method="post">
                <div class="header-form">
                    <h3>Inscrivez-vous</h3>
                    <h6>Vous avez déja un compte ? <a class="link" href="#connexion">Cliquez ici pour vous connecter</a>
                    </h6>
                </div>
                <div class="body-form">
                    <div class="input-group">
                        <input type="text" name="nom" id="inscription-nom" placeholder="Veuillez  écrire ici">
                        <label for="inscription-nom">Nom</label>
                    </div>
                    <div class="input-group">
                        <input type="text" name="nom" id="inscription-prenoms" placeholder="Veuillez  écrire ici">
                        <label for="inscription-prenoms">Prénoms</label>
                    </div>
                    <div class="select-group">
                        <select name="niveau" id="inscription-niveau" required>
                            <option value="" selected></option>
                            <option value="1">Licence 1</option>
                            <option value="2">Licence 2</option>
                            <option value="3">Licence 3</option>
                            <option value="4">Master 1</option>
                            <option value="5">Master 2</option>
                        </select>
                        <label for="inscription-niveau">Niveau</label>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" id="inscription-email" placeholder="Veuillez  écrire ici">
                        <label for="inscription-email">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="motDePasse" id="inscription-mdp"
                               placeholder="Veuillez  écrire ici">
                        <label for="inscription-mdp">Mot de Passe</label>
                        <!-- Conteneur du SVG “œil” pour toggler -->

                    </div>
                    <div class="input-group">
                        <input type="password" name="confirmMotDePasse" id="inscription-confirm-mdp"
                               placeholder="Veuillez  écrire ici">
                        <label for="inscription-confirm-mdp">Confirmer le mot de passe</label>
                        <!-- Conteneur du SVG “œil” pour toggler -->
                    </div>

                </div>
                <div class="footer-form">
                    <button class="button-sbumit" type="submit">
                        Inscription
                        <div class="arrow-wrapper">
                            <div class="arrow"></div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
        <div class="connexion" id="connexion">
            <form method="post">
                <div class="header-form">
                    <h3>Connectez-vous</h3>
                    <h6>Vous n'avez pas de compte ? <a href="#inscription">Cliquez ici pour vous inscrire</a></h6>
                </div>

                <div class="body-form">
                    <div class="input-group">
                        <input type="email" name="email" id="connexion-email" placeholder="Veuillez  écrire ici">
                        <label for="connexion-email">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="motDePasse" id="connexion-mdp" placeholder="Veuillez  écrire ici">
                        <label for="connexion-mdp">Mot de passe</label>
                    </div>
                </div>
                <div class="footer-form">
                    <button class="button-sbumit" type="submit">Connexion</button>
                </div>
            </form>
        </div>
        <div class="parrainage" id="parrainage">
            <?php include "private/client/views/parrainage.php" ?>
        </div>
    </div>
</div>
nklmsscoiskfld
<script type="module" src="private/client/assets/js/animations.js"></script>
</body>
</html>