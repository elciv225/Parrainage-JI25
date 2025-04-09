<?php
$utilisateur = $_SESSION['utilisateur'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Journée d'Intégration - Un événement inoubliable pour rencontrer, échanger et apprendre.">
    <title>Journée d'Intégration</title>
    <link rel="stylesheet" href="backend/client/assets/css/concours.css">
    <title><?= $title ?? "Journée d'intégration" ?></title>
</head>
<body>
<header class="header">
    <nav class="nav-container">
        <a href="/" class="marque">
            <img class="logo-ji" src="backend/client/assets/images/logo.webp" alt="Logo Journée d'Intégration">
            <div class="texte-marque">JOURNÉE D'INTEGRATION</div>
        </a>
        <ul class="liens-navigation">
            <li><a href="/" class="lien">Accueil</a></li>
            <li><a href="#mpc" class="lien">MPC</a></li>
            <li><a href="#kq" class="lien">King & Queen</a></li>
        </ul>
        <div class="modal-overlay" id="timerModal">
            <div class="modal-content">
                <button class="modal-close" id="closeModal">&times;</button>
                <h2 class="modal-title">Compte à rebours</h2>
                <div class="big-timer" id="modalCountdown">--j --:--:--</div>
            </div>
        </div>
        <div class="boutons-entete">
            <?php if ($utilisateur): ?>
                <form action="/deconnexion" method="GET">
                    <button type="submit" class="bouton-action">Bye ! <?= $utilisateur['nom'] ?></button>
                </form>
            <?php else: ?>
                <a href="/authentification" class="bouton-action inscription">Se Connecter</a>
            <?php endif; ?>
        </div>
        <div class="hamburger" role="button" tabindex="0" aria-label="Ouvrir le menu">
            <i class="fa-solid fa-bars"></i>
        </div>
    </nav>
    <nav class="menu-mobile" aria-label="Menu mobile">
        <ul>
            <li><a href="/" class="lien-mobile">Accueil</a></li>
            <li><a href="#mpc" class="lien-mobile">Activités</a></li>
            <li><a href="#kp" class="lien-mobile">Compétition</a></li>
            <li class="separateur"></li>
            <?php if ($utilisateur): ?>
                <form action="/deconnexion" method="GET">
                    <button type="submit" class="bouton-action">Bye ! <?= $utilisateur['nom'] ?></button>
                </form>
            <?php else: ?>
                <a href="/authentification" class="bouton-action inscription">Se Connecter</a>
            <?php endif; ?>
        </ul>
        <div class="modal-overlay" id="timerModal">
            <div class="modal-content">
                <button class="modal-close" id="closeModal">&times;</button>
                <h2 class="modal-title">Compte à rebours</h2>
                <div class="big-timer" id="modalCountdown">--j --:--:--</div>
            </div>
        </div>
    </nav>
</header>
<main>
    <section id="mpc" class="activites" aria-label="Activités Phare">
        <div class="conteneur-activites">
            <header class="entete-section">
                <h1>Miage Project Challenge 2025</h1>
                <p>Découvrez nos finalistes </p>
            </header>
            <div class="grille-activites">

                <article class="carte-mpc">
                    <img src="backend/client/assets/images/novBleu.webp" alt="Conférence Innovation & Tech" class="carte-image-visible">
                    <div class="details-activite">
                        <h2>MPC 25</h2>
                        <h3>Nom Projet ...</h3>
                        <p>Description projet ..............</p>
                    </div>

                    <div class="overlay-details-content" style="display: none;">
                        <div class="detail-image-col">
                            <img src="backend/client/assets/images/novBleu_large.webp" alt="Conférence Innovation & Tech - Détail">
                        </div>
                        <div class="detail-info-col">
                            <h2 class="detail-titre">MPC 25</h2>
                            <h3 class="detail-soustitre">Nom Projet Complet et Détaillé</h3>
                            <p class="detail-description">
                                Ceci est la description complète et détaillée du projet MPC 25 qui sera affichée
                                dans l'overlay. Elle peut être beaucoup plus longue que celle de la carte.
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.
                                Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.
                            </p>
                            <div class="detail-participants">
                                <h4>Participants au projet</h4>
                                <ul>
                                    <li>Jean Dupont (Rôle)</li>
                                    <li>Marie Martin (Rôle)</li>
                                    <li>Luc Bernard (Rôle)</li>
                                    <li>Autre Participant</li>
                                </ul>
                            </div>
                            <button class="btn-voter">Voter pour ce projet</button>
                        </div>
                    </div>
                </article>
            </div>
            <div class="overlay"></div>
        </div>
    </section>
    <section id="kq" class="activites" aria-label="Activités Phare">
        <div class="conteneur-activites">
            <header class="entete-section">
                <h1>King & Queen</h1>
                <p>Il est temps de marque l'histoire de cette édition de la JI pr votre élégance.</p>
            </header>
            <div class="grille-activites">
                <article class="carte-activite">
                    <img src="backend/client/assets/images/fashionWeek.webp" alt="Compétition Hackathon">
                    <div class="details-activite">
                        <h2>Concours d'élégance</h2>
                        <h3>King</h3>
                        <p>Marquer l'histoire de MIAGE</p>
                    </div>
                </article>
                <article class="carte-activite">
                    <img src="backend/client/assets/images/fashionWeek.webp" alt="Journée Black & White">
                    <div class="details-activite">
                        <h2>Concours d'élégance</h2>
                        <h3>Queen</h3>
                        <p>Marquer l'histoire de MIAGE</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section id="faq" class="faq" aria-label="Questions Fréquentes">
        <h2 class="titre-faq">Questions Fréquentes</h2>
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                <span>Quand et où se tiendra la Journée d'Intégration ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    La Journée d'Intégration se tiendra le 12 avril à la Caistab du Plateau. Restez connectés pour le
                    programme détaillé !
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                <span>Quels seront les temps forts de la Journée d'Intégration ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    L’événement comprendra des panels de discussion, des conférences et le Miage Project Challenge, un
                    concours mettant en avant les talents des étudiants en MIAGE.
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                <span>Y a-t-il des frais de participation pour les étudiants ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Oui, les étudiants de L2, M1 et M2 doivent s’acquitter de leurs droits de participation à la vie
                    estudiantine, d’un montant de 15 000 FCFA, avant de pouvoir assister à la Journée d’Intégration.
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" aria-expanded="false">
                <span>Comment puis-je m’inscrire et obtenir plus d’informations ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Suivez nos canaux de communication officiels pour vous inscrire et recevoir les dernières mises à
                    jour sur l’événement. Vous pouvez également contacter l’équipe organisatrice pour toute question.
                </p>
            </div>
        </div>
    </section>
</main>
<footer class="pied-de-page" role="contentinfo">
    <div class="pied-haut">
        <div class="conteneur-pied">
            <div class="marque-pied">
                <a href="#" class="lien-marque">
                    <img class="logo-ji" src="backend/client/assets/images/logo.webp" alt="Logo Journée d’Intégration">
                    <span class="titre-marque">JOURNÉE D’INTÉGRATION</span>
                </a>
                <p class="description-marque">
                    Rejoignez-nous pour un événement unique de networking, de partage et de découverte.
                </p>
            </div>
        </div>
    </div>
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
<script type="module" src="backend/client/assets/js/concours.js"></script>
</body>
</html>
