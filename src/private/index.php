<?php

use config\Database;
use client\traitements\UtilisateurManager;
use client\traitements\Utilisateur;


if (isset($_POST['btn-inscription-complete'])) {

    // Gestion de la photo
    $photoPath = null; // Initialisation du chemin
    if (isset($_FILES['photo-profil']) && is_uploaded_file($_FILES['photo-profil']['tmp_name'])) {
        $photo = $_FILES['photo-profil']; // Récupérer les informations du fichier

        // Définir un chemin de stockage absolu
        $uploadDir = __DIR__ . '/client/uploads/photos/'; // Répertoire absolu
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Créer le répertoire si inexistant
        }

        // Nettoyer les données utilisateur pour le nom du fichier
        $prenom = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['prenoms']); // Retirer les caractères non valides
        $nom = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['nom']);

        // Générer un nom unique basé sur les données utilisateur
        $uniqueName = "user_{$prenom}_{$nom}_" . uniqid() . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
        $photoPath = $uploadDir . $uniqueName; // Chemin absolu complet

        // Déplacement du fichier
        if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
            echo "Erreur lors de l'enregistrement de la photo.";
            $photoPath = null; // Réinitialisation en cas d'erreur
        }
    }

    $utilisateur_post = new Utilisateur(
        null,
        $_POST['prenoms'],
        $_POST['nom'],
        $_POST['niveau'],
        $_POST['email'],
        $_POST['motDePasse'],
        $photoPath,
        '',
        (int)$_POST['totalScore'],
        null
    );

    // Connexion à la ase de données
    $pdo = Database::getConnection();

    // Instance de UtilisateurManger
    $manager = new UtilisateurManager($pdo);

    $utilisateur = $manager->inscription($utilisateur_post);

    if ($utilisateur === null) {
        $_SESSION['erreur_connexion'] = "Erreur lors de la connexion";
    } else {
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur->getUtilisateurId(),
            'prenom' => $utilisateur->getPrenom(),
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'niveau' => $utilisateur->getNiveau(),
            'photo' => $utilisateur->getPhoto(),
            'score_personnalite' => $utilisateur->getScorePersonnalite(),
            'id_profil' => $utilisateur->getIdProfil(),
            'date_creation' => $utilisateur->getDateCreation(),
        ];
        // Rediriger vers la page actuelle (ou une page spécifique)
        echo "<script>window.location.href = window.location.href;</script>";
    }
}


if (isset($_POST['btn-connexion'])) {
    // Connexion à la ase de données
    $pdo = Database::getConnection();

    // Instance de UtilisateurManger
    $manager = new UtilisateurManager($pdo);

    $utilisateur = $manager->connexion($_POST['email'], $_POST['motDePasse']);

    if ($utilisateur === null) {
        $_SESSION['erreur_connexion'] = "Erreur lors de la connexion";
    } else {
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur->getUtilisateurId(),
            'prenom' => $utilisateur->getPrenom(),
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'niveau' => $utilisateur->getNiveau(),
            'photo' => $utilisateur->getPhoto(),
            'score_personnalite' => $utilisateur->getScorePersonnalite(),
            'id_profil' => $utilisateur->getIdProfil(),
            'date_creation' => $utilisateur->getDateCreation(),
        ];
        // Rediriger vers la page actuelle (ou une page spécifique)
        echo "<script>window.location.href = window.location.href;</script>";
    }
}

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
                            <option value="L1">Licence 1</option>
                            <option value="L2">Licence 2</option>
                            <option value="L3">Licence 3</option>
                            <option value="M1">Master 1</option>
                            <option value="M2">Master 2</option>
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
            <form method="post">
                <div class="header-form">
                    <h3>Connectez-vous</h3>
                    <h6>Vous n'avez pas de compte ? <a class="link" href="#inscription">Cliquez ici pour vous
                            inscrire</a></h6>
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
                    <button class="button-submit" type="submit" name="btn-connexion">Connexion</button>
                </div>
            </form>
        </div>
        <div class="parrainage" id="parrainage">
            <?php include "private/client/views/parrainage.php" ?>
        </div>
        <div class="ajout-photo" id="ajout-photo">

            <form method="post" enctype="multipart/form-data">
                <div class="header-form">
                    <h3>Ajouter votre photo de profil</h3>
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
<!-- Pop-up d'erreur -->
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
<script type="module" src="private/client/assets/js/animations.js"></script>
</body>
</html>