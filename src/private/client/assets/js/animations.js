/*
   Si vous utilisez un bundler ou avez installé GSAP localement :
   import { gsap } from "/node_modules/gsap/index.js";

   Sinon, retirez la ligne ci-dessus et
   chargez GSAP via un CDN (avant ce script).
*/
import { gsap } from "/node_modules/gsap/index.js";

/****************************************************
 * Lancement global au chargement du DOM
 ****************************************************/
document.addEventListener("DOMContentLoaded", function () {

    /********************************************
     * 1) LOGIQUE ET ANIMATIONS DU QUIZ
     ********************************************/
    const questions = document.querySelectorAll('.question-item');
    const options = document.querySelectorAll('.option');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const questionNumber = document.getElementById('question-number');
    const progressBarInner = document.querySelector('.progress-bar-inner');

    let currentQuestion = 0;

    // État initial des questions
    questions.forEach((q, index) => {
        if (index !== 0) {
            gsap.set(q, { display: 'none', opacity: 0 });
        }
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

    options.forEach(option => {
        option.addEventListener('click', function () {
            const currentOptions = questions[currentQuestion].querySelectorAll('.option');
            currentOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
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

    nextBtn.addEventListener('click', function () {
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
                alert("Quiz terminé !");
            }
        });
    });

    prevBtn.addEventListener('click', function () {
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
    });

    updateProgressBar();
    updateNavigationButtons();

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
    const sectionGauche = document.querySelector(".section-gauche");
    const sectionDroite = document.querySelector(".section-droite");

    // Vérifier si on est sur mobile (max-width: 530px)
    const isMobile = window.matchMedia("(max-width: 530px)").matches;

    // Fonction pour basculer entre formulaires
    function switchForm(e, targetId = null) {
        if (e) e.preventDefault();
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

        // Masquer tous les éléments avant d'appliquer les animations
        [inscriptionDiv, connexionDiv, parrainageDiv].forEach((div) => {
            gsap.set(div, {zIndex: -1, display: "none", opacity: 0});
        });

        // Déterminer la direction (droite→gauche) ou (bas→haut) pour le parrainage sur mobile
        let showFromX = 150, showFromY = 0;
        let hideToX = -150, hideToY = 0;

        if (targetId === "parrainage" && isMobile) {
            showFromX = 0;
            showFromY = 200;
        }

        // Animation de sortie
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

        // Animation d'entrée
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

        // Animer les champs si c'est un formulaire (inscription ou connexion)
        if (targetId !== "parrainage") {
            gsap.from(`#${targetId} .body-form .input-group, #${targetId} .body-form .select-group`, {
                opacity: 0,
                y: 20,
                stagger: 0.07,
                duration: 0.3,
                delay: 0.15,
                ease: "power2.out",
            });
            gsap.from(`#${targetId} .footer-form button`, {
                opacity: 0,
                scale: 0.8,
                delay: 0.25,
                duration: 0.3,
                ease: "power2.out",
            });
        } else {
            // Parrainage => si besoin d’animer d’autres éléments (ex. .quiz-container)
            gsap.from(`#${targetId} .quiz-container`, {
                opacity: 0,
                y: 20,
                duration: 0.3,
                delay: 0.15,
                ease: "power2.out",
            });
        }
    }

    // Écouteurs pour les liens de navigation
    document.querySelectorAll('a[href="#connexion"], a[href="#inscription"]').forEach((link) => {
        link.addEventListener("click", switchForm);
    });

    // Écouteur pour le formulaire d'inscription (basculer vers parrainage)
    const inscriptionForm = document.querySelector("#inscription form");
    if (inscriptionForm) {
        inscriptionForm.addEventListener("submit", function (e) {
            e.preventDefault();
            switchForm(null, "parrainage");
        });
    }

    // État initial pour les 3 blocs
    gsap.set(connexionDiv, {zIndex: -1, opacity: 0, display: "none"});
    gsap.set(parrainageDiv, {zIndex: -1, opacity: 0, display: "none"});
    gsap.set(inscriptionDiv, {zIndex: 1, opacity: 1, display: "block"});

    // Animation globale au chargement
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
            const tl = gsap.timeline({ defaults: { ease: "power2.inOut" } });
            tl.to(input, { x: -10, duration: 0.1 })
                .to(input, { x: 10, duration: 0.2 })
                .to(input, { x: -5, duration: 0.15 })
                .to(input, { x: 5, duration: 0.15 })
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
});
