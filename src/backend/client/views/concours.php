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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
                <!-- IA PROFIL -->
                <article class="carte-mpc">
                    <img src="backend/client/assets/images/novBleu.webp" alt="Conférence Innovation & Tech"
                         class="carte-image-visible">
                    <div class="details-activite">
                        <h3>IA PROFIL</h3>
                        <p>Cliquez pour en voir plus</p>
                    </div>

                    <div class="overlay-details-content" style="display: none;">
                        <div class="detail-image-col">
                            <img src="backend/client/assets/images/novBleu_large.webp"
                                 alt="Image IA PROFIL">
                        </div>
                        <div class="detail-info-col">
                            <h2 class="detail-titre">IA PROFIL</h2>
                            <h3 class="detail-soustitre">Nom Projet Complet et Détaillé</h3>
                            <p class="detail-description">
                                Les demandeurs d'emploi ne sont plus des CV perdus, mais
                                des profils analysés et proposés aux bonnes entreprises. Les
                                employeurs ne recrutent plus au hasard : l'IA filtre et trouve
                                le talent idéal. Une expérience fluide et humaine, où chaque
                                candidature compte car derrière elles se cache
                                toujours une histoire.
                            </p>
                            <div class="detail-participants">
                                <h4>Participants au projet</h4>
                                <ul>
                                    <li>SERME Mohamed Sidik</li>
                                    <li>KONE Gningneri Jedidia</li>
                                    <li>KOFFI Johann Christ</li>
                                    <li>OYOU Kassi Nathan</li>
                                </ul>
                            </div>
                            <?php if ($utilisateur): ?>
                                <form action="/vote/projet/1" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $utilisateur['id'] ?? '' ?>">
                                    <button type="submit" class="btn-voter">Voter pour ce projet</button>
                                </form>
                            <?php else: ?>
                                <a href="/authentification" class="btn-voter">Connectez vous avant de voter</a>
                            <?php endif; ?>

                        </div>
                    </div>
                </article>
                <!-- ChezMoi -->
                <article class="carte-mpc">
                    <img src="backend/client/assets/images/novBleu.webp" alt="Conférence Innovation & Tech"
                         class="carte-image-visible">
                    <div class="details-activite">
                        <h3>ChezMoi</h3>
                        <p>Cliquez pour en voir plus</p>
                    </div>
                    <div class="overlay-details-content" style="display: none;">
                        <div class="detail-image-col">
                            <img src="backend/client/assets/images/novBleu_large.webp"
                                 alt="Image ChezMoi">
                        </div>
                        <div class="detail-info-col">
                            <h2 class="detail-titre">ChezMoi</h2>
                            <h3 class="detail-soustitre">Slogan...</h3>
                            <p class="detail-description">
                                Dans une COTE D¾IVOIRE
                                en pleine urbanisation et
                                croissance
                                démographique, trouver
                                un logement adapté
                                devient un défi pour
                                beaucoup.
                                Un logement est bien
                                plus qu'une simple
                                construction.
                                C'est un havre de paix,
                                un lieu de liens, de
                                réconfort et de chaleur
                                humaine.
                                C'est aussi un foyer où
                                naissent des idées et des
                                projets, où se construit
                                l'Avenir.
                                ChezMoi a pour but de
                                permettre à chacun de
                                trouver un logement
                                correspondant à ses
                                critères et à son budget.
                                ChezMoi est un site web
                                et une future application
                                où les agents immobiliers
                                peuvent publier leurs
                                offres, les rendant
                                accessibles à tous.
                                Avec ChezMoi, plus
                                besoin de prospecter
                                sans fin pour trouver
                                l'offre idéale.
                                Tout ce dont vous avez
                                besoin est à portée de
                                clic.
                            </p>
                            <div class="detail-participants">
                                <h4>Participants au projet</h4>
                                <ul>
                                    <li>KOUASSI N'Gouan Yannick</li>
                                    <li>KOUADIO Samuel</li>
                                    <li>AYRA Christ</li>
                                </ul>
                            </div>
                            <?php if ($utilisateur): ?>
                                <form action="/vote/projet/2" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $utilisateur['id'] ?? '' ?>">
                                    <button type="submit" class="btn-voter">Voter pour ce projet</button>
                                </form>
                            <?php else: ?>
                                <a href="/authentification" class="btn-voter">Connectez vous avant de voter</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <!-- WellMind -->
                <article class="carte-mpc">
                    <img src="backend/client/assets/images/novBleu.webp" alt="Conférence Innovation & Tech"
                         class="carte-image-visible">
                    <div class="details-activite">
                        <h3>WellMind</h3>
                        <p>Cliquez pour en voir plus</p>
                    </div>

                    <div class="overlay-details-content" style="display: none;">
                        <div class="detail-image-col">
                            <img src="backend/client/assets/images/novBleu_large.webp"
                                 alt="Image WellMind">
                        </div>
                        <div class="detail-info-col">
                            <h2 class="detail-titre">WellMind</h2>
                            <h3 class="detail-soustitre">Slogan...</h3>
                            <p class="detail-description">
                                WellMind est une application web de soutien à la santé mentale
                                offrant un chatbot thérapeutique disponible 24h/24. Face au taux
                                alarmant de suicides, elle propose un accompagnement immédiat basé
                                sur des approches scientifiques (TCC, pleine conscience), un suivi
                                professionnel à distance et un système d'intervention d'urgence pour
                                les personnes en crise. Son interface non stigmatisante rend les soins
                                psychologiques accessibles à tous.
                            </p>
                            <div class="detail-participants">
                                <h4>Participants au projet</h4>
                                <ul>
                                    <li>SERY Priscille</li>
                                    <li>SORO Emeric</li>
                                </ul>
                            </div>
                            <?php if ($utilisateur): ?>
                                <form action="/vote/projet/3" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $utilisateur['id'] ?? '' ?>">
                                    <button type="submit" class="btn-voter">Voter pour ce projet</button>
                                </form>
                            <?php else: ?>
                                <a href="/authentification" class="btn-voter">Connectez vous avant de voter</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <!-- MonBus -->
                <article class="carte-mpc">
                    <img src="backend/client/assets/images/novBleu.webp" alt="Conférence Innovation & Tech"
                         class="carte-image-visible">
                    <div class="details-activite">
                        <h3>MonBus</h3>
                        <p>Cliquez pour en voir plus</p>
                    </div>

                    <div class="overlay-details-content" style="display: none;">
                        <div class="detail-image-col">
                            <img src="backend/client/assets/images/novBleu_large.webp"
                                 alt="Image MonBus">
                        </div>
                        <div class="detail-info-col">
                            <h2 class="detail-titre">MonBus</h2>
                            <h3 class="detail-soustitre">Slogan...</h3>
                            <p class="detail-description">
                                MonBus est une application mobile dont le but est de pouvoir faciliter le quotidien des travailleurs, étudiants et lycéens/collégiens de côte d’ivoire qui empruntent les bus. MonBus est une application multitâche en ce sens où elle permet :
                                <br>
                                - En premier lieu la recherche et la localisation en temps réel de bus ou de lignes de bus disponibles dans un secteur et une zone précise, depuis l’endroit où l’on se trouve. Plus d’inquiétude lorsque vous vous trouvez dans une commune peu familière.
                                <br>
                                - La communication des informations comme l’arrivée du prochain bus et le temps d’estimation du trajet. Ainsi, plus besoin de courir après les bus. Le temps d’attente se voit aussi réduit.
                                <br>
                                - Le paiement de tickets de bus à travers vos portefeuilles numériques. Vous n’aurez plus à vos inquiéter de problèmes de monnaies.
                                <br>
                                - Rechargement de vos cartes de bus.
                                <br>
                                En fin de compte, plus besoin de vous tracasser concernant vos prochains trajets en bus. MonBus est là pour répondre à vos préoccupations.
                            </p>
                            <div class="detail-participants">
                                <h4>Participants au projet</h4>
                                <ul>
                                    <li>BAKAYOKO Segbe</li>
                                    <li>GABALA Mylène </li>
                                    <li>N'Guessan Priscille</li>
                                </ul>
                            </div>
                            <?php if ($utilisateur): ?>
                                <form action="/vote/projet/3" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $utilisateur['id'] ?? '' ?>">
                                    <button type="submit" class="btn-voter">Voter pour ce projet</button>
                                </form>
                            <?php else: ?>
                                <a href="/authentification" class="btn-voter">Connectez vous avant de voter</a>
                            <?php endif; ?>

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
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Quand et où se tiendra la Journée d'Intégration ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    La Journée d'Intégration se tiendra le 12 avril 2025 à la Salle-Caistab d'Abidjan Plateau. Consultez
                    notre
                    <a href="/programme">programme détaillé</a> pour plus d'informations!
                </p>
            </div>
        </div>
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Comment puis-je consulter le programme complet ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Vous pouvez consulter le <a href="/programme">programme complet</a> de la journée qui inclut
                    toutes les activités prévues avec leurs horaires. Le programme est mis à jour en temps réel!
                </p>
            </div>
        </div>
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Comment commander de la nourriture pour l'événement ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Consultez notre <a href="/menu">menu</a> et commandez directement en ligne via notre
                    plateforme de commande. Les commandes seront disponibles gratuitement lors de l'événement.
                </p>
            </div>
        </div>
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Comment voter pour les projets du MIAGE Project Challenge ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Pour voter, connectez-vous à votre compte sur notre plateforme et accédez à la section
                    <a href="/concours">Concours & Votes</a>. Vous pourrez voir tous les projets participants et voter
                    pour
                    votre favori. Chaque étudiant peut voter une seule fois par projet.
                </p>
            </div>
        </div>
        <div class="faq-item" tabindex="0">
            <button class="faq-question" aria-expanded="false">
                <span>Quels sont les plats disponibles lors de la journée ?</span>
                <i class="faq-icone">+</i>
            </button>
            <div class="faq-reponse">
                <p>
                    Notre menu propose une variété de plats traditionnels ivoiriens incluant Attiéké, Tchep, Frites et
                    Alloco,
                    tous accompagnés au choix de poulet, poisson ou porc. Consultez le <a href="/menu">menu complet</a>
                    pour
                    découvrir toutes les options disponibles.
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
<!-- Popup de message d'erreur/succès -->
<div id="popup-erreur" class="popup hidden">
    <div class="popup-content error-container">
        <h2 class="error-title" id="popup-title">Attention</h2>
        <p class="error-description" id="message-erreur">Votre message</p>
        <button id="fermer-popup" class="button button-primary">Fermer</button>
    </div>
</div>
<script type="module" src="backend/client/assets/js/concours.js"></script>
</body>
</html>
