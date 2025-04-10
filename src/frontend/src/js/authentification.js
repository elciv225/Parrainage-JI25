/*
   Si vous utilisez un bundler ou avez installé GSAP localement :
   import { gsap } from "/node_modules/gsap/index.js";

   Sinon, retirez la ligne ci-dessus et
   chargez GSAP via un CDN (avant ce script).
*/
import {gsap} from "gsap";

/****************************************************
 * Lancement global au chargement du DOM
 ****************************************************/
document.addEventListener("DOMContentLoaded", function () {

    /********************************************
     * 1) LOGIQUE ET ANIMATIONS DU QUIZ
     ********************************************/
    const questions = document.querySelectorAll('.question-item');
    const options = document.querySelectorAll('.option');
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    const questionNumber = document.getElementById('question-number');
    const progressBarInner = document.querySelector('.progress-bar-inner');
    const totalScoreInput = document.getElementById('total-score');

    let currentQuestion = 0;
    let totalScore = 0;
    const selectedOptions = []; // Stocke les réponses sélectionnées

    // État initial des questions (sauf la première)
    questions.forEach((q, index) => {
        if (index !== 0) {
            gsap.set(q, {display: 'none', opacity: 0});
        }
        // Petite optimisation
        q.style.willChange = 'transform, opacity';
    });

    function updateNavigationButtons() {
        nextBtn.disabled = true;
        prevBtn.disabled = currentQuestion === 0;
    }

    function updateProgressBar() {
        const progressPercentage = ((currentQuestion + 1) / questions.length) * 100;
        progressBarInner.style.width = `${progressPercentage}%`;
    }

    // Gestion du clic sur les options
    options.forEach(option => {
        option.addEventListener('click', function () {
            const currentOptions = questions[currentQuestion].querySelectorAll('.option');
            currentOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');

            const score = parseInt(this.dataset.score, 10) || 0;

            // Enregistrer la réponse et son score
            selectedOptions[currentQuestion] = {
                question: questions[currentQuestion].querySelector('.question').textContent.trim(),
                response: this.textContent.trim(),
                score: score
            };


            nextBtn.disabled = false;
        });
    });

    function animateOut(currentElem, onComplete) {
        gsap.to(currentElem, {
            opacity: 0,
            x: -40,
            duration: 0.25,
            ease: "power2.in",
            onComplete: () => {
                currentElem.style.display = 'none';
                if (onComplete) onComplete();
            }
        });
    }

    function animateIn(nextElem, onComplete) {
        gsap.set(nextElem, {
            display: 'block',
            opacity: 0,
            x: 40
        });
        gsap.to(nextElem, {
            opacity: 1,
            x: 0,
            duration: 0.25,
            ease: "power2.out",
            onComplete: () => {
                if (onComplete) onComplete();
            }
        });
    }

    // Bouton "Suivant"
    nextBtn.addEventListener('click', function () {
        const currentOption = selectedOptions[currentQuestion];
        if (currentOption) {
            totalScore += currentOption.score;
        }

        // Mettre à jour l'input caché
        if (totalScoreInput) {
            totalScoreInput.value = totalScore;
        }

        nextBtn.disabled = true;
        prevBtn.disabled = true;

        const currentElem = questions[currentQuestion];

        animateOut(currentElem, function () {
            currentQuestion++;

            if (currentQuestion < questions.length) {
                const nextElem = questions[currentQuestion];
                questionNumber.innerText = currentQuestion + 1;
                updateProgressBar();

                animateIn(nextElem, function () {
                    updateNavigationButtons();
                });
            } else {
                switchForm(null, "ajout-photo");
            }
        });
    });

    // Bouton "Précédent"
    prevBtn.addEventListener('click', function () {
        if (currentQuestion > 0) {
            const currentOption = selectedOptions[currentQuestion];
            if (currentOption) {
                totalScore -= currentOption.score; // Retirer le score de la réponse précédente
            }

            // Mettre à jour l'input caché
            if (totalScoreInput) {
                totalScoreInput.value = totalScore;
            }


            nextBtn.disabled = true;
            prevBtn.disabled = true;

            const currentElem = questions[currentQuestion];

            animateOut(currentElem, function () {
                currentQuestion--;

                if (currentQuestion >= 0) {
                    const prevElem = questions[currentQuestion];
                    questionNumber.innerText = currentQuestion + 1;
                    updateProgressBar();

                    animateIn(prevElem, function () {
                        updateNavigationButtons();
                    });
                }
            });
        }
    });

    updateProgressBar();
    updateNavigationButtons();

    // Animation globale au chargement (pour le quiz-container)
    gsap.from(".quiz-container", {
        opacity: 0,
        scale: 0.95,
        duration: 0.5,
        ease: "power2.out"
    });


    /********************************************
     * 2) LOGIQUE ET ANIMATIONS DES FORMULAIRES
     ********************************************/
    const inscriptionDiv = document.getElementById("inscription");
    const connexionDiv = document.getElementById("connexion");
    const parrainageDiv = document.getElementById("parrainage");
    const ajoutPhotoDiv = document.getElementById("ajout-photo"); // NOUVEAU

    // Vérifier si on est sur mobile (max-width: 530px)
    const isMobile = window.matchMedia("(max-width: 530px)").matches;

    // Fonction switchForm : gère l'apparition/masquage
    function switchForm(e, targetId = null) {
        if (e) e.preventDefault();
        // ex: targetId = "connexion", "inscription", "parrainage", "ajout-photo"
        targetId = targetId || (e ? e.target.getAttribute("href").substring(1) : window.location.hash.substring(1));

        let elementToHide, elementToShow;

        if (targetId === "connexion") {
            elementToHide = inscriptionDiv;
            elementToShow = connexionDiv;
            document.body.classList.remove("parrainage-active");
        } else if (targetId === "inscription") {
            elementToHide = connexionDiv;
            elementToShow = inscriptionDiv;
            document.body.classList.remove("parrainage-active");
        } else if (targetId === "parrainage") {
            elementToHide = inscriptionDiv;
            elementToShow = parrainageDiv;
            document.body.classList.add("parrainage-active");
        } else if (targetId === "ajout-photo") {
            elementToHide = parrainageDiv;
            elementToShow = ajoutPhotoDiv;
            document.body.classList.add("parrainage-active");
        }

        // Masquer tous les éléments avant d'appliquer l'animation
        [inscriptionDiv, connexionDiv, parrainageDiv, ajoutPhotoDiv].forEach((div) => {
            gsap.set(div, {zIndex: -1, display: "none", opacity: 0});
        });

        // Déterminer la direction
        let showFromX = 150, showFromY = 0;
        let hideToX = -150, hideToY = 0;

        if ((targetId === "parrainage" || targetId === "ajout-photo") && isMobile) {
            // Sur mobile, on peut faire un effet bas→haut
            showFromX = 0;
            showFromY = 200;
        }

        // On anime la sortie
        gsap.to(elementToHide, {
            opacity: 0,
            x: hideToX,
            y: hideToY,
            scale: 0.95,
            duration: 0.3,
            ease: "power2.in",
            onComplete: () => {
                elementToHide.style.display = "none";
            },
        });

        // On anime l'entrée
        elementToShow.style.display = "block";
        gsap.fromTo(
            elementToShow,
            {
                opacity: 0,
                x: showFromX,
                y: showFromY,
                scale: 0.9,
            },
            {
                opacity: 1,
                x: 0,
                y: 0,
                scale: 1,
                duration: 0.4,
                ease: "power2.out",
                onStart: () => {
                    elementToShow.style.zIndex = 1;
                },
                onComplete: () => {
                    elementToShow.style.zIndex = 2;
                },
            }
        );
    }

    // Liens #connexion / #inscription
    document.querySelectorAll('a[href="#connexion"], a[href="#inscription"]').forEach((link) => {
        link.addEventListener("click", switchForm);
    });

    // Écouteur sur le formulaire inscription => On bascule vers parrainage si le input select est L1 ou L3
    const inscriptionForm = document.querySelector("#inscription form");
    const ajoutPhotoForm = document.querySelector("#ajout-photo form");

    if (inscriptionForm) {
        inscriptionForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Récupération des données du formulaire
            const formData = new FormData(inscriptionForm);

            // Sauvegarder les données dans le localStorage
            formData.forEach((value, key) => {
                localStorage.setItem(key, value);
            });

            // Basculer vers "parrainage" si L1 ou L3
            const niveau = formData.get("niveau");
            if (niveau === "L1" || niveau === "L3") {
                switchForm(null, "parrainage");
            } else {
                // Sinon, basculer vers "ajout-photo"
                switchForm(null, "ajout-photo");
            }
        });
    }

    // Pré-remplir les champs dans "ajout-photo" avec les données sauvegardées
    if (ajoutPhotoForm) {
        const inputs = ajoutPhotoForm.querySelectorAll("input, select");
        inputs.forEach((input) => {
            const value = localStorage.getItem(input.name);
            if (value) {
                input.value = value;
            }
        });

        // Remplir les champs cachés avant la soumission finale
        ajoutPhotoForm.addEventListener("submit", function () {
            const hiddenFields = ["nom", "prenoms", "niveau", "email", "motDePasse", "confirmMotDePasse"];
            hiddenFields.forEach((name) => {
                const value = localStorage.getItem(name);
                if (value) {
                    const hiddenInput = document.querySelector(`#hidden-${name}`);
                    if (hiddenInput) {
                        hiddenInput.value = value;
                    }
                }
            });
        });
    }


    // État initial : on masque tout sauf #inscription
    gsap.set(connexionDiv, {zIndex: -1, opacity: 0, display: "none"});
    gsap.set(parrainageDiv, {zIndex: -1, opacity: 0, display: "none"});
    gsap.set(ajoutPhotoDiv, {zIndex: -1, opacity: 0, display: "none"});
    gsap.set(inscriptionDiv, {zIndex: 1, opacity: 1, display: "block"});

    // Animation globale au chargement (pour la partie "principal-container")
    const pageLoadTl = gsap.timeline();
    pageLoadTl
        .from(".principal-container", {
            opacity: 0,
            scale: 0.9,
            y: 50,
            duration: 0.5,
            ease: "power3.out",
        })
        .from(
            ".section-droite",
            {
                opacity: 0,
                x: 40,
                duration: 0.5,
                ease: "power3.out",
            },
            "-=0.3"
        )
        // Champs du formulaire inscription (initial)
        .from(
            "#inscription .header-form h3",
            {
                opacity: 0,
                y: 20,
                duration: 0.4,
                ease: "power2.out",
                stagger: 0.1,
            },
            "-=0.2"
        )
        .from(
            "#inscription .body-form .input-group, #inscription .body-form .select-group",
            {
                opacity: 0,
                y: 20,
                duration: 0.4,
                ease: "power2.out",
                stagger: 0.1,
            },
            "-=0.2"
        )
        .from(
            "#inscription .footer-form button",
            {
                opacity: 0,
                y: 20,
                duration: 0.4,
                ease: "power2.out",
                stagger: 0.1,
            },
            "-=0.2"
        );

    // Effet “shake” au focus sur les inputs
    const inputs = document.querySelectorAll(".input-group input, .select-group select");
    inputs.forEach((input) => {
        input.addEventListener("focus", () => {
            const tl = gsap.timeline({defaults: {ease: "power2.inOut"}});
            tl.to(input, {x: -10, duration: 0.1})
                .to(input, {x: 10, duration: 0.2})
                .to(input, {x: -5, duration: 0.15})
                .to(input, {x: 5, duration: 0.15})
                .to(input, {
                    x: 0,
                    duration: 0.07,
                    onComplete: () => {
                        gsap.to(input, {
                            boxShadow: "0 4px 10px rgba(0, 0, 0, 0.15)",
                            duration: 0.2,
                            ease: "power2.out",
                        });
                    },
                });
        });

        // Animation au blur (perte du focus)
        input.addEventListener("blur", () => {
            gsap.to(input, {
                x: 0,
                boxShadow: "none",
                duration: 0.3,
                ease: "power2.in"
            });
        });
    });

    /*********************************************************
     * LOGIQUE ET ANIMATIONS DES VERIFICATIONS DES INPUTS
     ********************************************************/

    const inputNom = document.getElementById('inscription-nom');
    const inputPrenoms = document.getElementById('inscription-prenoms'); // Assumons "prenoms" au pluriel comme dans votre code original
    const suggestionsNom = document.createElement("ul");
    const suggestionsPrenoms = document.createElement("ul");

    // Ajout des classes
    suggestionsNom.className = 'suggestions-list';
    suggestionsPrenoms.className = 'suggestions-list';

    // Ajout des suggestions aux conteneurs (après l'input respectif)
    inputNom.parentNode.insertBefore(suggestionsNom, inputNom.nextSibling);
    inputPrenoms.parentNode.insertBefore(suggestionsPrenoms, inputPrenoms.nextSibling);


    let etudiantsData = {etudiants: []}; // Utiliser etudiantsData pour stocker les données

    // Charger le fichier JSON
    fetch("/etudiants.json") // Assurez-vous que ce chemin est correct
        .then(reponse => {
            if (!reponse.ok) throw new Error(`Erreur HTTP ${reponse.status} lors du chargement du JSON`);
            return reponse.json();
        })
        .then(jsonEtudiants => {
            if (!jsonEtudiants || !Array.isArray(jsonEtudiants.etudiants)) {
                throw new Error("Format JSON invalide : 'etudiants' doit être un tableau.");
            }
            etudiantsData = jsonEtudiants; // Stocker les données ici
        })
        .catch(error => {
            // Afficher une erreur à l'utilisateur si nécessaire
            afficherErreur(inputNom, "Erreur chargement données");
            afficherErreur(inputPrenoms, "Erreur chargement données");
        });

    // Gestionnaire de clic global pour fermer les suggestions
    document.addEventListener('click', (e) => {
        // Vérifie si le clic n'est ni sur un input pertinent ni sur une liste de suggestions
        const clickedInput = e.target === inputNom || e.target === inputPrenoms;
        const clickedSuggestionList = e.target.closest('.suggestions-list');

        if (!clickedInput && !clickedSuggestionList) {
            [suggestionsNom, suggestionsPrenoms].forEach(list => {
                if (list.style.display === 'block') {
                    gsap.to(list, {
                        opacity: 0,
                        y: -10,
                        duration: 0.2,
                        onComplete: () => list.style.display = 'none'
                    });
                }
            });
        }
    });


    // --- Fonctions de recherche spécifiques ---

    function rechercherNomsUniques(query) {
        if (!query || !etudiantsData.etudiants.length) return [];
        const lowerCaseQuery = query.toLowerCase();
        const noms = new Set();
        etudiantsData.etudiants.forEach(etudiant => {
            if (etudiant.nom && etudiant.nom.toLowerCase().includes(lowerCaseQuery)) {
                noms.add(etudiant.nom);
            }
        });
        return Array.from(noms);
    }

    function rechercherPrenomsPourNom(query, nomFiltre) {
        // Ne cherche que si un nom est fourni et qu'une requête prénom existe
        if (!nomFiltre || !query || !etudiantsData.etudiants.length) return [];

        const lowerCaseQuery = query.toLowerCase();
        const lowerCaseNomFiltre = nomFiltre.toLowerCase();
        const prenoms = new Set();

        etudiantsData.etudiants.forEach(etudiant => {
            // Vérifie la correspondance exacte du nom et l'inclusion du prénom
            if (etudiant.nom && etudiant.nom.toLowerCase() === lowerCaseNomFiltre &&
                etudiant.prenoms && etudiant.prenoms.toLowerCase().includes(lowerCaseQuery)) { // Utiliser 'prenoms' si c'est la clé dans votre JSON
                prenoms.add(etudiant.prenoms); // Ajouter le prénom correspondant
            }
            // SI votre JSON utilise 'prenom' (singulier) :
            // if (etudiant.nom && etudiant.nom.toLowerCase() === lowerCaseNomFiltre &&
            //     etudiant.prenom && etudiant.prenom.toLowerCase().includes(lowerCaseQuery)) {
            //     prenoms.add(etudiant.prenom);
            // }
        });
        return Array.from(prenoms);
    }

    // --- Fonction d'affichage des suggestions (Adaptée de votre code) ---
    function afficherSuggestions(input, suggestionsContainer, matches, onSelectCallback) {
        suggestionsContainer.innerHTML = "";

        if (matches.length === 0) {
            if (suggestionsContainer.style.display === 'block') {
                gsap.to(suggestionsContainer, {
                    opacity: 0,
                    y: -10,
                    duration: 0.2,
                    onComplete: () => suggestionsContainer.style.display = 'none'
                });
            }
            return;
        }

        matches.forEach(match => {
            const li = document.createElement("li");
            li.textContent = match;

            li.addEventListener('mouseenter', () => {
                gsap.to(li, {backgroundColor: 'var(--background-secondary)', duration: 0.2});
            });
            li.addEventListener('mouseleave', () => {
                gsap.to(li, {backgroundColor: 'var(--background-primary)', duration: 0.2});
            });

            li.addEventListener("click", () => {
                input.value = match;
                gsap.to(suggestionsContainer, {
                    opacity: 0, y: -10, duration: 0.2,
                    onComplete: () => suggestionsContainer.style.display = 'none'
                });
                // Exécute un callback si fourni (utile pour lier les champs)
                if (typeof onSelectCallback === 'function') {
                    onSelectCallback(match);
                }
            });
            suggestionsContainer.appendChild(li);
        });

        // Gérer l'affichage et l'animation d'apparition
        if (suggestionsContainer.style.display !== 'block') {
            suggestionsContainer.style.display = 'block';
            suggestionsContainer.style.opacity = '0';
            gsap.fromTo(suggestionsContainer,
                {opacity: 0, y: -10},
                {opacity: 1, y: 0, duration: 0.3}
            );
            gsap.fromTo(suggestionsContainer.children,
                {opacity: 0, y: -10},
                {opacity: 1, y: 0, duration: 0.3, stagger: 0.05}
            );
        } else {
            // Optionnel : Animer seulement les nouveaux items si la liste est déjà visible
        }
    }


    // --- Fonction d'affichage d'erreur (Votre code) ---
    function afficherErreur(input, message) {
        const existingError = input.parentNode.querySelector('.erreur-message');
        if (existingError) {
            gsap.to(existingError, {
                opacity: 0, y: 10, duration: 0.2,
                onComplete: () => existingError.remove()
            });
        }

        const erreur = document.createElement('span');
        erreur.className = 'erreur-message';
        erreur.textContent = message;
        // Insérer après l'input, avant la liste de suggestions si elle existe
        input.parentNode.insertBefore(erreur, input.nextSibling);
        input.classList.add('input-error'); // Ajouter une classe pour styler l'input en erreur

        gsap.timeline()
            .to(input, {x: -10, duration: 0.1})
            .to(input, {x: 10, duration: 0.1}) // Durées ajustées pour être plus rapide
            .to(input, {x: -5, duration: 0.08})
            .to(input, {x: 5, duration: 0.08})
            .to(input, {x: 0, duration: 0.05});

        gsap.fromTo(erreur,
            {opacity: 0, y: -10},
            {opacity: 1, y: 0, duration: 0.3}
        );

        // Supprimer l'erreur après 3 secondes
        setTimeout(() => {
            gsap.to(erreur, {
                opacity: 0, y: 10, duration: 0.3,
                onComplete: () => {
                    erreur.remove();
                    input.classList.remove('input-error');
                }
            });
        }, 3000);
    }

    // --- Écouteurs d'événements spécifiques ---

    // Pour l'input NOM
    inputNom.addEventListener("input", () => {
        const query = inputNom.value;
        const matches = rechercherNomsUniques(query);
        // Le callback ici efface le champ prénom et ses suggestions quand un nom est cliqué
        afficherSuggestions(inputNom, suggestionsNom, matches, () => {
            inputPrenoms.value = ''; // Effacer le prénom
            suggestionsPrenoms.innerHTML = ''; // Vider les suggestions prénom
            suggestionsPrenoms.style.display = 'none'; // Cacher la liste
        });
        // Si l'input nom est vidé, on cache aussi les suggestions prénom
        if (!query) {
            suggestionsPrenoms.innerHTML = '';
            suggestionsPrenoms.style.display = 'none';
        }
        inputNom.removeAttribute("invalid"); // Enlever l'état invalide en tapant
        const existingError = inputNom.parentNode.querySelector('.erreur-message');
        if (existingError) existingError.remove(); // Enlever message erreur
    });

    inputNom.addEventListener("focus", () => {
        const query = inputNom.value;
        // Afficher les suggestions même si le champ est vide (ou basé sur la valeur actuelle)
        const matches = rechercherNomsUniques(query);
        afficherSuggestions(inputNom, suggestionsNom, matches, () => {
            inputPrenoms.value = '';
            suggestionsPrenoms.innerHTML = '';
            suggestionsPrenoms.style.display = 'none';
        });
    });

    inputNom.addEventListener("blur", () => {
        // Laisser un délai pour permettre le clic sur une suggestion
        setTimeout(() => {
            // Ne pas masquer si le focus est maintenant sur la liste de suggestions
            if (document.activeElement === suggestionsNom || suggestionsNom.contains(document.activeElement)) {
                return;
            }

            const query = inputNom.value;
            // Vérifier si le nom entré existe EXACTEMENT dans la liste (après sélection/frappe complète)
            const nomExiste = etudiantsData.etudiants.some(e => e.nom && e.nom.toLowerCase() === query.toLowerCase());

            if (query && !nomExiste) {
                // On pourrait aussi vérifier si une suggestion correspond exactement
                const suggestionsExactes = rechercherNomsUniques(query).filter(n => n.toLowerCase() === query.toLowerCase());
                if (suggestionsExactes.length === 0) {
                    inputNom.setAttribute("invalid", "true");
                    afficherErreur(inputNom, "Ce nom est inconnu");
                } else {
                    inputNom.removeAttribute("invalid");
                }

            } else {
                inputNom.removeAttribute("invalid");
            }
            // Cacher les suggestions si non focus et pas d'erreur affichée immédiatement
            if (suggestionsNom.style.display === 'block' && !inputNom.hasAttribute('invalid')) {
                gsap.to(suggestionsNom, {
                    opacity: 0,
                    y: -10,
                    duration: 0.2,
                    onComplete: () => suggestionsNom.style.display = 'none'
                });
            }

        }, 200); // Délai de 200ms
    });


    // Pour l'input PRENOMS
    inputPrenoms.addEventListener("input", () => {
        const query = inputPrenoms.value;
        const nomSelectionne = inputNom.value; // Récupérer le nom actuel
        // Chercher les prénoms SEULEMENT si un nom est présent
        const matches = rechercherPrenomsPourNom(query, nomSelectionne);
        afficherSuggestions(inputPrenoms, suggestionsPrenoms, matches);

        inputPrenoms.removeAttribute("invalid");
        const existingError = inputPrenoms.parentNode.querySelector('.erreur-message');
        if (existingError) existingError.remove();
    });

    inputPrenoms.addEventListener("focus", () => {
        const query = inputPrenoms.value;
        const nomSelectionne = inputNom.value;
        // N'afficher les suggestions au focus que si un nom est sélectionné
        if (nomSelectionne) {
            const matches = rechercherPrenomsPourNom(query, nomSelectionne);
            afficherSuggestions(inputPrenoms, suggestionsPrenoms, matches);
        }
    });

    inputPrenoms.addEventListener("blur", () => {
        setTimeout(() => {
            if (document.activeElement === suggestionsPrenoms || suggestionsPrenoms.contains(document.activeElement)) {
                return;
            }

            const query = inputPrenoms.value;
            const nomSelectionne = inputNom.value;

            // Vérifier si le prénom existe POUR LE NOM DONNÉ
            if (query && nomSelectionne) {
                const prenomExistePourNom = etudiantsData.etudiants.some(e =>
                    e.nom && e.nom.toLowerCase() === nomSelectionne.toLowerCase() &&
                    e.prenoms && e.prenoms.toLowerCase() === query.toLowerCase() // Adapter 'prenoms' si besoin
                );
                // Ou vérifier si une suggestion exacte existe
                const suggestionsExactes = rechercherPrenomsPourNom(query, nomSelectionne).filter(p => p.toLowerCase() === query.toLowerCase());

                if (!prenomExistePourNom && suggestionsExactes.length === 0) {
                    inputPrenoms.setAttribute("invalid", "true");
                    afficherErreur(inputPrenoms, "Prénom inconnu pour ce nom");
                } else {
                    inputPrenoms.removeAttribute("invalid");
                }
            } else {
                inputPrenoms.removeAttribute("invalid"); // Pas d'erreur si champ vide ou nom vide
            }

            if (suggestionsPrenoms.style.display === 'block' && !inputPrenoms.hasAttribute('invalid')) {
                gsap.to(suggestionsPrenoms, {
                    opacity: 0,
                    y: -10,
                    duration: 0.2,
                    onComplete: () => suggestionsPrenoms.style.display = 'none'
                });
            }
        }, 200);
    });


    /********************************************
     * Gestion du mot de passe
     ********************************************/

    const inputMotDePasse = document.getElementById('inscription-mdp');
    const inputConfirmeMotDePasse = document.getElementById('inscription-confirm-mdp');

    inputConfirmeMotDePasse.addEventListener("blur", () => {
        setTimeout(() => {
            const valueConfirmeMdp = inputConfirmeMotDePasse.value;
            const valutMdp = inputMotDePasse.value;

            if (valutMdp !== valueConfirmeMdp) {
                inputConfirmeMotDePasse.setAttribute("invalid", "true");
                afficherErreur(inputConfirmeMotDePasse, "Les mots de passe ne correspondent pas");
            } else {
                inputConfirmeMotDePasse.removeAttribute("invalid");
            }
        }, 200)
    })

    // Section voir ou non le mot de passe.
    const inputGroups = document.querySelectorAll(".input-group");

    inputGroups.forEach(group => {
        // Sélectionner les éléments à l'intérieur de CE groupe spécifique
        const passwordInput = group.querySelector('input[type="password"]');
        const togglePassword = group.querySelector('.toggle-password');

        // Vérifier si les éléments existent
        if (passwordInput && togglePassword) {
            const eyeOpen = togglePassword.querySelector('.eye-open');
            const eyeClosed = togglePassword.querySelector('.eye-closed');

            // GSAP Timeline pour les animations coordonnées
            const tl = gsap.timeline({paused: true});

            // Animation pour l'icône
            tl.to(togglePassword, {
                duration: 0.4,
                rotation: 180,
                ease: "back.out(1.7)",
                transformOrigin: "center center"
            });

            tl.to(eyeClosed, {
                duration: 0.2,
                opacity: 0,
                scale: 0.5,
                ease: "power2.out"
            }, 0);

            tl.to(eyeOpen, {
                duration: 0.3,
                opacity: 1,
                scale: 1,
                ease: "power2.out"
            }, 0);

            const textTransitionEffect = () => {
                gsap.to(passwordInput, {
                    duration: 0.12,
                    filter: "blur(5px)",
                    ease: "power1.out",
                    onComplete: () => {
                        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                        passwordInput.type === 'text' ? tl.play() : tl.reverse();
                        gsap.to(passwordInput, {
                            duration: 0.3,
                            filter: "blur(0px)",
                            ease: "power1.out"
                        });
                    }
                });
            };

            // Ajouter l'événement de clic avec animation
            togglePassword.addEventListener('click', function () {
                textTransitionEffect();
            });
        }
    });

    /********************************************
     * 4) INPUT FILE AVEC APERCUS
     ********************************************/

    const uploadZone = document.querySelector('.upload-zone');
    const fileInput = document.getElementById('photo-profil');
    const previewContainer = document.querySelector('.preview-container');
    const previewImage = document.getElementById('preview-image');
    const removeButton = document.querySelector('.remove-preview');
    const errorMessage = document.querySelector('.error-message');

    // Fonction pour vérifier le type de fichier
    function isValidFileType(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return validTypes.includes(file.type);
    }

    // Fonction pour gérer la prévisualisation
    function handlePreview(file) {
        if (!isValidFileType(file)) {
            errorMessage.classList.add('active');
            fileInput.value = '';
            return;
        }

        errorMessage.classList.remove('active');
        const reader = new FileReader();

        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.classList.add('active');

            // Animation de la prévisualisation
            gsap.from(previewContainer, {
                opacity: 0,
                y: 20,
                duration: 0.3,
                ease: "power2.out"
            });
        }

        reader.readAsDataURL(file);
    }

    // Événements de drag & drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        uploadZone.classList.add('drag-over');
    }

    function unhighlight() {
        uploadZone.classList.remove('drag-over');
    }

    // Gestion du drop
    uploadZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handlePreview(file);
    }

    // Gestion du changement de fichier via le bouton
    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            handlePreview(this.files[0]);
        }
    });

    // Gestion du bouton de suppression
    removeButton.addEventListener('click', function () {
        fileInput.value = '';
        previewContainer.classList.remove('active');
        errorMessage.classList.remove('active');
    });
});
