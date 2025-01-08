/*
   Si vous utilisez un bundler ou avez installé GSAP localement :
   import { gsap } from "/node_modules/gsap/index.js";

   Sinon, retirez la ligne ci-dessus et
   chargez GSAP via un CDN (avant ce script).
*/
import {gsap} from "/node_modules/gsap/index.js";

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

            console.log(`Question: ${selectedOptions[currentQuestion].question}`);
            console.log(`Réponse: ${selectedOptions[currentQuestion].response}`);
            console.log(`Points: ${selectedOptions[currentQuestion].score}`);

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
                // On affiche la zone photo
                console.log(`Score total : ${totalScore}`);
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

            console.log(`Score après retour : ${totalScore}`);

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

    const sectionGauche = document.querySelector(".section-gauche");
    const sectionDroite = document.querySelector(".section-droite");

    // Vérifier si on est sur mobile (max-width: 530px)
    const isMobile = window.matchMedia("(max-width: 530px)").matches;

    // Fonction switchForm : gère l'apparition/masquage
    function switchForm(e, targetId = null) {
        if (e) e.preventDefault();
        // ex: targetId = "connexion", "inscription", "parrainage", "ajout-photo"
        targetId = targetId || (e ? e.target.getAttribute("href").substring(1) : null);

        let elementToHide, elementToShow;

        if (targetId === "connexion") {
            elementToHide = inscriptionDiv;
            elementToShow = connexionDiv;
            document.body.classList.remove("parrainage-active");
            sectionGauche.style.display = "";
        } else if (targetId === "inscription") {
            elementToHide = connexionDiv;
            elementToShow = inscriptionDiv;
            document.body.classList.remove("parrainage-active");
            sectionGauche.style.display = "";
        } else if (targetId === "parrainage") {
            elementToHide = inscriptionDiv;
            elementToShow = parrainageDiv;
            document.body.classList.add("parrainage-active");
            // Masquer la section gauche
            sectionGauche.style.display = "none";
        }
        // NOUVEAU : si on veut aller de #parrainage → #ajout-photo
        else if (targetId === "ajout-photo") {
            elementToHide = parrainageDiv;
            elementToShow = ajoutPhotoDiv;
            // On reste en mode "parrainage-active" ou pas, selon vos besoins
            document.body.classList.add("parrainage-active");
            sectionGauche.style.display = "none";
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
            ".section-gauche",
            {
                opacity: 0,
                x: -40,
                duration: 0.5,
                ease: "power3.out",
            },
            "-=0.3"
        )
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

    /********************************************
     * 3) INPUT FILE AVEC APERCUS
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
