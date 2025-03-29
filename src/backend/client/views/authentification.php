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
        <div class="inscription" id="inscription">
            <form method="post">
                <div class="header-form">
                    <h3>Inscrivez-vous</h3>
                    <h6>Vous avez déja un compte ? <a class="link" href="#connexion">Cliquez ici pour vous connecter</a>
                    </h6>
                </div>
                <div class="body-form">
                    <div class="input-group" style="position: relative; z-index: 1000;">
                        <input
                                type="text"
                                name="nom"
                                id="inscription-nom"
                                placeholder="Veuillez  écrire ici"
                                autocomplete="off"
                        >
                        <label for="inscription-nom">Nom</label>
                    </div>
                    <div class="input-group" style="position: relative; z-index: 999;">
                        <input type="text" name="nom" id="inscription-prenoms" placeholder="Veuillez  écrire ici"
                               autocomplete="off">
                        <label for="inscription-prenoms">Prénoms</label>
                    </div>
                    <div class="select-group">
                        <select name="niveau" id="inscription-niveau" required>
                            <option value="" selected></option>
                            <option value="L1">Licence 1</option>
                            <option value="L2">Licence 2</option>
                            <option value="L3">Licence 3</option>
                            <option value="M1">Master 1</option>
                            <option value="M2">Master 2</option>
                        </select>
                        <label for="inscription-niveau">Niveau</label>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" id="inscription-email" placeholder="Veuillez  écrire ici"
                               autocomplete="off">
                        <label for="inscription-email">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="motDePasse" id="inscription-mdp"
                               placeholder="Veuillez  écrire ici" autocomplete="off">
                        <label for="inscription-mdp">Mot de Passe</label>
                        <div class="toggle-password">
                            <svg class="eye-open hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <path class="eyelid" d="M3 3l18 18"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirmMotDePasse" id="inscription-confirm-mdp"
                               placeholder="Veuillez  écrire ici" autocomplete="off">
                        <label for="inscription-confirm-mdp">Confirmer le mot de passe</label>
                        <div class="toggle-password">
                            <svg class="eye-open hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <path class="eyelid" d="M3 3l18 18"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>

                </div>
                <div class="footer-form">
                    <button class="button-submit" type="submit" name="btn-inscription">
                        Inscription
                        <div class="arrow-wrapper">
                            <div class="arrow"></div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
        <div class="connexion" id="connexion">
            <form method="post" action="/connexion">
                <div class="header-form">
                    <h3>Connectez-vous</h3>
                    <h6>Vous n'avez pas de compte ? <a class="link" href="#inscription">Cliquez ici pour vous
                            inscrire</a></h6>
                </div>
                <div class="body-form">
                    <div class="input-group">
                        <input type="email" name="email" id="connexion-email" placeholder="Veuillez  écrire ici"
                               autocomplete="off">
                        <label for="connexion-email">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="motDePasse" id="connexion-mdp" placeholder="Veuillez  écrire ici"
                               autocomplete="off">
                        <label for="connexion-mdp">Mot de passe</label>
                        <div class="toggle-password">
                            <svg class="eye-open hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <path class="eyelid" d="M3 3l18 18"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="footer-form">
                    <button class="button-submit" type="submit" name="btn-connexion">Connexion</button>
                </div>
            </form>
        </div>
        <div class="parrainage" id="parrainage">
            <?php include "backend/client/views/questionnaire.php" ?>
        </div>
        <div class="ajout-photo" id="ajout-photo">
            <form method="post" action="/inscription" enctype="multipart/form-data">
                <div class="header-form">
                    <h3>Ajouter votre photo de profil</h3>
                    <p>Attention ! Cette image sera affichée lors du parrainage, alors choisissez une photo qui vous
                        fait sourire, on ne sait jamais ! 😄</p>
                </div>
                <div class="body-form">
                    <input type="hidden" name="nom" id="hidden-nom">
                    <input type="hidden" name="prenoms" id="hidden-prenoms">
                    <input type="hidden" name="niveau" id="hidden-niveau">
                    <input type="hidden" name="email" id="hidden-email">
                    <input type="hidden" name="motDePasse" id="hidden-mdp">
                    <input type="hidden" name="confirmMotDePasse" id="hidden-confirm-mdp">
                    <input type="hidden" name="totalScore" id="total-score">
                    <div class="input-group photo">
                        <div class="upload-zone">
                            <div class="icon">📸</div>
                            <div class="text">
                                <strong>Glissez et déposez</strong> votre photo ici<br>
                                ou <strong>cliquez</strong> pour sélectionner
                            </div>
                            <input type="file" name="photo-profil" id="photo-profil" accept="image/*" required>
                        </div>
                        <div class="preview-container">
                            <img id="preview-image" src="" alt="Aperçu">
                            <button type="button" class="remove-preview">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </div>
                    </div>
                    <div class="error-message">
                        Format non supporté. Veuillez sélectionner une image (JPG, PNG ou GIF)
                    </div>
                </div>
                <div class="footer-form">
                    <button type="submit" class="button-submit" name="btn-inscription-complete">
                        S'inscrire
                        <div class="arrow-wrapper">
                            <div class="arrow"></div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="popup-erreur" class="popup hidden">
    <div class="popup-content">
        <p id="message-erreur"></p>
        <button id="fermer-popup">Fermer</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('popup-erreur');
        const messageErreur = document.getElementById('message-erreur');
        const boutonFermer = document.getElementById('fermer-popup');

        // Afficher la pop-up si une erreur est définie dans $_SESSION
        <?php if (isset($_SESSION['erreur_connexion'])): ?>
        popup.classList.remove('hidden');
        messageErreur.textContent = "<?php echo $_SESSION['erreur_connexion']; ?>";
        <?php unset($_SESSION['erreur_connexion']); ?>
        <?php endif; ?>

        // Fermer la pop-up lorsqu'on clique sur le bouton "Fermer"
        boutonFermer.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        // Masquer automatiquement la pop-up après 5 secondes (5000 ms)
        setTimeout(() => {
            popup.classList.add('hidden');
        }, 5000);

        // Fermer la pop-up lorsqu'on clique en dehors de son contenu
        window.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.classList.add('hidden');
            }
        });
    });
</script>
<script type="module" src="backend/client/assets/js/authentification.js"></script>
</body>
</html>