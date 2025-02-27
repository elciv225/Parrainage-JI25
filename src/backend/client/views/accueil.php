<?php
// Vérifier si on est en mode développement
$devMode = isset($_ENV['VITE_DEV']) && $_ENV['VITE_DEV'] === 'true';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Métadonnées et informations de base -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Journée d'Intégration - Un événement inoubliable pour rencontrer, échanger et apprendre.">
    <title>Journée d'Intégration</title>

    <!-- Feuille de style principale -->
    <?php if ($devMode): ?>
        <link rel="stylesheet" href="http://localhost:5173/src/css/accueil.css">
    <?php else: ?>
        <link rel="stylesheet" href="backend/client/assets/css/accueil.css">
    <?php endif; ?>

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<!-- =======================================================
     EN-TÊTE
     =======================================================
     L'en-tête contient la barre de navigation principale.
     On utilise des balises sémantiques et des noms de classes en français.
-->
<header class="header">
    <nav class="nav-container">
        <a href="index.html" class="marque">
            <img class="logo-ji" src="assets/images/logo-02.svg" alt="Logo Journée d'Intégration">
            <div class="texte-marque">
                <div>JOURNÉE</div>
                <div>D'INTÉGRATION</div>
            </div>
        </a>

        <ul class="liens-navigation">
            <li><a href="#parrainage" class="lien">Parrainage</a></li>
            <li><a href="#competition" class="lien">Compétition</a></li>
            <li><a href="#evenement" class="lien">Évènement</a></li>
            <li><a href="#collaboration" class="lien">Collaboration</a></li>
            <li><a href="#apropos" class="lien">À propos</a></li>
        </ul>

        <div class="boutons-entete">
            <a href="#" class="bouton-action connexion">Connexion</a>
            <a href="#" class="bouton-action inscription">S'inscrire</a>
        </div>

        <div class="hamburger" role="button" tabindex="0" aria-label="Ouvrir le menu">
            <i class="fa-solid fa-bars"></i>
        </div>
    </nav>
    <!-- Menu burger (mobile) -->
    <nav class="menu-mobile" aria-label="Menu mobile">
        <ul>
            <li><a href="#parrainage" class="lien-mobile">Parrainage</a></li>
            <li><a href="#competition" class="lien-mobile">Compétition</a></li>
            <li><a href="#evenement" class="lien-mobile">Évènement</a></li>
            <li><a href="#collaboration" class="lien-mobile">Collaboration</a></li>
            <li><a href="#apropos" class="lien-mobile">À propos</a></li>
            <!-- Séparateur visuel -->
            <li class="separateur"></li>
            <li><a href="#" class="bouton-action connexion">Connexion</a></li>
            <li><a href="#" class="bouton-action inscription">S'inscrire</a></li>
            <!-- Bouton de basculement de thème transformé en icône -->
        </ul>
    </nav>
</header>


<!-- =======================================================
     CONTENU PRINCIPAL
     =======================================================
     On regroupe ici le contenu principal avec des sections clairement identifiées.
-->
<main>
    <!-- ===================================================
         SECTION HERO / CARROUSEL
         ===================================================
         Utilisation d'articles pour chaque diapositive et d'un contrôle ARIA
    -->
    <section class="hero">
        <div class="carousel">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="slide active">
                    <div class="slide-content">
                        <h1 class="slide-title">Bienvenue à la Journée d'Intégration</h1>
                        <p class="slide-description">Vivez une expérience inoubliable lors de cet événement de rencontre
                            et de partage.</p>
                        <div class="slide-buttons">
                            <button class="btn primary">Rejoignez-nous</button>
                            <button class="btn secondary">En savoir plus</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slide">
                    <div class="slide-content">
                        <h1 class="slide-title">Découvrez nos Activités</h1>
                        <p class="slide-description">Des ateliers, des conférences et bien plus encore pour enrichir
                            votre expérience.</p>
                        <div class="slide-buttons">
                            <button class="btn primary">Programme</button>
                            <button class="btn secondary">S'inscrire</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slide">
                    <div class="slide-content">
                        <h1 class="slide-title">Rencontrez vos Parrains</h1>
                        <p class="slide-description">Un accompagnement personnalisé tout au long de votre cursus.</p>
                        <div class="slide-buttons">
                            <button class="btn primary">Parrainage</button>
                            <button class="btn secondary">Témoignages</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dots -->
            <div class="carousel-dots">
                <button class="dot active" aria-label="Slide 1"></button>
                <button class="dot" aria-label="Slide 2"></button>
                <button class="dot" aria-label="Slide 3"></button>
            </div>
        </div>
    </section>

    <!-- ===================================================
         SECTION ACTIVITÉS
         ===================================================
         Une section dédiée aux activités phares avec un en-tête de section.
    -->
    <section id="parrainage" class="activites" aria-label="Activités Phare">
        <div class="conteneur-activites">
            <header class="entete-section">
                <h1>Nos Activités</h1>
                <p>Découvrez notre sélection d’événements pour rythmer l'année avant et après la journée
                    d’intégration.</p>
            </header>
            <div class="grille-activites">
                <!-- Carte Activité 1 -->
                <article class="carte-activite" tabindex="0">
                    <img src="assets/images/activites/JAP X2 JI.jpg" alt="Atelier Rencontre & Échange">
                    <div class="details-activite">
                        <h2>Compétition</h2>
                        <h3>Collaboration Inédite</h3>
                        <p>Nous n'en dirons pas plus....</p>
                    </div>
                </article>
                <!-- Carte Activité 2 -->
                <article class="carte-activite" tabindex="0">
                    <img src="assets/images/activites/novembre bleu.png" alt="Conférence Innovation & Tech">
                    <div class="details-activite">
                        <h2>Journée à thème</h2>
                        <h3>NOVEMBRE BLEU</h3>
                        <p>Organisation d'une journée pour soutenir le lutte contre le cancer de la prostate chez
                            l'Homme.</p>
                    </div>
                </article>
                <!-- Carte Activité 3 -->
                <article class="carte-activite" tabindex="0">
                    <img src="assets/images/activites/Oct rose2.png" alt="Compétition Hackathon">
                    <div class="details-activite">
                        <h2>Journée à Thème</h2>
                        <h3>OCTOBRE ROSE</h3>
                        <p>Organisation d'une journée pour soutenir le lutte contre le cancer du sein chez la Femme</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ===================================================
        SECTION PARTENAIRES
        ===================================================
        Affichage des logos des partenaires en grille.
    -->
    <section class="partenaires" aria-label="Ils nous font confiance">
        <div class="conteneur-partenaires">
            <h2>Ils nous font confiance</h2>
            <div class="container">
                <div class="marquee">
                    <div class="marquee-content" id="firstRow"></div>
                </div>
                <div class="marquee reverse">
                    <div class="marquee-content" id="secondRow"></div>
                </div>
                <div class="gradient-overlay gradient-left"></div>
                <div class="gradient-overlay gradient-right"></div>

            </div>
        </div>
    </section>

    <!-- ===================================================
         SECTION ÉQUIPE
         ===================================================
         Présentation des membres de l’équipe.
    -->
    <section id="collaboration" class="team" aria-label="Nos Comités">
        <h2>Notre Équipe</h2>
        <div class="container">
            <div class="testimonials-grid">
                <div class="image-container" id="imageContainer"></div>
                <div class="content-container">
                    <div>
                        <h3 class="name" id="name"></h3>
                        <p class="designation" id="designation"></p>
                        <p class="quote" id="quote"></p>
                    </div>
                    <div class="controls">
                        <div class="controls-btn">
                            <button class="control-button" id="prevButton">
                                <svg class="btn" width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                     stroke="currentColor" fill="none">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M15 6l-6 6l6 6"/>
                                </svg>
                            </button>
                            <button class="control-button" id="nextButton">
                                <svg class="btn" width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                     stroke="currentColor" fill="none">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 6l6 6l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <a href="equipe.html">
                            <button>Voir Plus</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===================================================
         SECTION FAQ
         ===================================================
         Liste des questions fréquentes sous forme d'accordéon.
    -->
    <section id="faq" class="faq" aria-label="Questions Fréquentes">
        <h2 class="titre-faq">Questions Fréquentes</h2>

        <!-- FAQ Item 1 -->
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Comment débuter avec vos services ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Contactez notre équipe via le formulaire de contact ou appelez-nous directement.
                    Nous organiserons une consultation gratuite pour discuter de vos besoins.
                </p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Quels sont vos délais moyens ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Nos délais varient en fonction de la complexité du projet. Généralement, nous livrons les projets
                    dans un délai de 2 à 8 semaines.
                </p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Comment se déroule le suivi du projet ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Nous restons en contact régulier via emails, appels ou réunions virtuelles, et vous recevez des
                    points d’avancement clairs et détaillés à chaque étape.
                </p>
            </div>
        </div>
    </section>
</main>

<!-- =======================================================
     PIED DE PAGE
     =======================================================
     La section pied de page contient les informations de contact, liens rapides et réseaux sociaux.
-->
<footer class="pied-de-page" role="contentinfo">
    <!-- Partie supérieure du pied de page -->
    <div class="pied-haut">
        <div class="conteneur-pied">
            <div class="marque-pied">
                <a href="#" class="lien-marque">
                    <img class="logo-ji" src="assets/images/logo-02.svg" alt="Logo Journée d’Intégration">
                    <span class="titre-marque">JOURNÉE D’INTÉGRATION</span>
                </a>
                <p class="description-marque">
                    Rejoignez-nous pour un événement unique de networking, de partage et de découverte.
                </p>
            </div>
            <div class="liens-pied">
                <div class="colonne-liens">
                    <h2>Activités</h2>
                    <ul>
                        <li><a href="#parrainage">Parrainage</a></li>
                        <li><a href="#competition">Compétition</a></li>
                        <li><a href="#evenement">Évènements</a></li>
                        <li><a href="#collaboration">Collaboration</a></li>
                    </ul>
                </div>
                <div class="colonne-liens">
                    <h2>À propos</h2>
                    <ul>
                        <li><a href="#apropos">Notre équipe</a></li>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#">Mentions légales</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                    </ul>
                </div>
                <div class="colonne-liens">
                    <h2>Ressources</h2>
                    <ul>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Guides</a></li>
                        <li><a href="#">Témoignages</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="colonne-liens">
                    <h2>Infos pratiques</h2>
                    <ul>
                        <li><a href="#">Plan du site</a></li>
                        <li><a href="#">Accès &amp; Transports</a></li>
                        <li><a href="#">Hébergements</a></li>
                        <li><a href="#">Sponsors</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Partie inférieure du pied de page -->
    <div class="pied-bas">
        <p class="texte-bas">© 2025 Journée d’Intégration — Tous droits réservés</p>
        <div class="reseaux-sociaux">
            <a href="#" class="icone-reseau" aria-label="Facebook">
                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     class="icone-svg" viewBox="0 0 24 24">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                </svg>
            </a>
            <a href="#" class="icone-reseau" aria-label="Twitter">
                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     class="icone-svg" viewBox="0 0 24 24">
                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                </svg>
            </a>
            <a href="#" class="icone-reseau" aria-label="Instagram">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="2" class="icone-svg" viewBox="0 0 24 24">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"/>
                </svg>
            </a>
            <a href="#" class="icone-reseau" aria-label="LinkedIn">
                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="0" class="icone-svg" viewBox="0 0 24 24">
                    <path stroke="none"
                          d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                    <circle cx="4" cy="4" r="2" stroke="none"/>
                </svg>
            </a>
        </div>
    </div>
</footer>

<!-- =======================================================
     SCRIPTS
     =======================================================
     Inclusion du fichier JavaScript principal.
-->
<?php if ($devMode): ?>
    <script type="module" src="http://localhost:5173/src/js/accueil.js"></script>
<?php else: ?>
    <script src="backend/client/assets/js/accueil.js"></script>
<?php endif ?>
</body>
</html>
