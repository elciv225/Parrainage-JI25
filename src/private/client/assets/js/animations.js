import {gsap} from "/node_modules/gsap/index.js";

document.addEventListener("DOMContentLoaded", function () {
    // Récupération des éléments
    const inscriptionDiv = document.getElementById("inscription");
    const connexionDiv = document.getElementById("connexion");
    const parrainageDiv = document.getElementById("parrainage");
    const sectionGauche = document.querySelector(".section-gauche");
    const sectionDroite = document.querySelector(".section-droite");

    // Vérifier si on est sur mobile (max-width: 530px)
    const isMobile = window.matchMedia("(max-width: 530px)").matches;

    function switchForm(e, targetId = null) {
        if (e) e.preventDefault();
        targetId = targetId || (e ? e.target.getAttribute("href").substring(1) : null);

        let elementToHide, elementToShow;

        if (targetId === "connexion") {
            elementToHide = inscriptionDiv;
            elementToShow = connexionDiv;
            document.body.classList.remove("parrainage-active");
            // Rendre la section gauche visible
            sectionGauche.style.display = "";
        } else if (targetId === "inscription") {
            elementToHide = connexionDiv;
            elementToShow = inscriptionDiv;
            document.body.classList.remove("parrainage-active");
            // Rendre la section gauche visible
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

        // Si on active le parrainage et on est sur mobile => du bas vers le haut
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
            filter: "blur(6px)",
            duration: 0.4,
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
                filter: "blur(6px)",
            },
            {
                opacity: 1,
                x: 0,
                y: 0,
                scale: 1,
                filter: "blur(0px)",
                duration: 0.5,
                ease: "power2.out",
                onStart: () => {
                    elementToShow.style.zIndex = 1;
                },
                onComplete: () => {
                    elementToShow.style.zIndex = 2;
                },
            }
        );

        // Animer les champs si c'est un formulaire
        if (targetId !== "parrainage") {
            gsap.from(`#${targetId} .body-form .input-group, #${targetId} .body-form .select-group`, {
                opacity: 0,
                y: 20,
                stagger: 0.08,
                duration: 0.4,
                delay: 0.15,
                ease: "power2.out",
            });
            gsap.from(`#${targetId} .footer-form button`, {
                opacity: 0,
                scale: 0.8,
                delay: 0.25,
                duration: 0.4,
                ease: "power2.out",
            });
        } else {
            // Parrainage => si besoin d'animer par exemple .quiz-container
            gsap.from(`#${targetId} .quiz-container`, {
                opacity: 0,
                y: 20,
                duration: 0.4,
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
    document.querySelector("#inscription form").addEventListener("submit", function (e) {
        e.preventDefault();
        switchForm(null, "parrainage");
    });

    // État initial
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
            duration: 0.6,
            ease: "power3.out",
        })
        .from(
            ".section-gauche",
            {
                opacity: 0,
                x: -50,
                duration: 0.6,
                ease: "power3.out",
            },
            "-=0.4"
        )
        .from(
            ".section-droite",
            {
                opacity: 0,
                x: 50,
                duration: 0.6,
                ease: "power3.out",
            },
            "-=0.4"
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

    // Effet focus sur les inputs
    const inputs = document.querySelectorAll(".input-group input, .select-group select");
    inputs.forEach((input) => {
        // Animation au focus
        input.addEventListener("focus", () => {
            // Timeline “shake” (vague)
            const tl = gsap.timeline({defaults: {ease: "power2.inOut"}});

            // On part de x=0, on va à x=-10, x=10, x=-5, x=5, puis x=0.
            // À la fin, on applique le boxShadow.
            tl.to(input, {x: -10, duration: 0.1})
                .to(input, {x: 10, duration: 0.2})
                .to(input, {x: -5, duration: 0.15})
                .to(input, {x: 5, duration: 0.15})
                .to(input, {
                    x: 0,
                    duration: 0.07,
                    // Une fois revenu au centre, on applique un léger halo
                    onComplete: () => {
                        gsap.to(input, {
                            boxShadow: "0 4px 10px rgba(0, 0, 0, 0.15)",
                            duration: 0.2,
                            ease: "power2.out",
                        });
                    },
                });
        });

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
