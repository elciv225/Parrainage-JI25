import {gsap} from "gsap";

/************************************************************
 * Initialisation globale dès que le DOM est prêt
 ************************************************************/
document.addEventListener('DOMContentLoaded', () => {
    App.init()
    new Carousel();
    // Header Scroll Animation
    const header = document.querySelector('.header');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        // Add/remove scrolled class for background color
        if (currentScroll > 680) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Hide/show header based on scroll direction
        if (currentScroll > lastScroll && currentScroll > 100) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }

        lastScroll = currentScroll;
    });
});

/************************************************************
 * Objet App : regroupe l’ensemble des initialisations
 ************************************************************/
const App = {
    /**
     * Fonction d'initialisation globale
     */
    init() {
        this.initSmoothScroll();
        this.initAnimationsScroll();
        this.initBurgerMenu();
        this.initFAQ();
    },
    /**
     * 2. Activation du scroll fluide pour les ancres (#)
     */
    initSmoothScroll() {
        const ancres = document.querySelectorAll('a[href^="#"]');
        ancres.forEach(anc => {
            anc.addEventListener('click', function (event) {
                event.preventDefault();
                const cible = document.querySelector(this.getAttribute('href'));
                if (cible) {
                    cible.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    },

    /**
     * 3. Animation des éléments au scroll (cartes, membres d'équipe, FAQ)
     */
    initAnimationsScroll() {
        const options = {threshold: 0.1};
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                    obs.unobserve(entry.target);
                }
            });
        }, options);

        const elementsAnimables = document.querySelectorAll('.carte-activite, .membre-equipe, .faq-item');
        elementsAnimables.forEach(el => observer.observe(el));
    },

    /**
     * 4. Menu burger (pour mobile)
     */
    initBurgerMenu() {
        const boutonHamburger = document.querySelector('.hamburger');
        const iconeHamburger = boutonHamburger ? boutonHamburger.querySelector('i') : null;
        const menuMobile = document.querySelector('.menu-mobile');

        if (boutonHamburger && menuMobile && iconeHamburger) {
            // Ouvrir/fermer le menu en cliquant sur l'hamburger
            boutonHamburger.addEventListener('click', (event) => {
                event.stopPropagation(); // Empêche le clic de se propager au document
                menuMobile.classList.toggle('open');
                const ouvert = menuMobile.classList.contains('open');
                iconeHamburger.className = ouvert ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
            });

            // Empêcher que les clics à l'intérieur du menu le ferment
            menuMobile.addEventListener('click', (event) => {
                event.stopPropagation();
            });

            // Fermer le menu quand on clique n'importe où sur le document
            document.addEventListener('click', () => {
                if (menuMobile.classList.contains('open')) {
                    menuMobile.classList.remove('open');
                    iconeHamburger.className = 'fa-solid fa-bars';
                }
            });
        }
    },

    /**
     * 5. FAQ : Gestion de l'ouverture/fermeture des items FAQ
     */
    initFAQ() {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            // Ciblage du bouton-question dans chaque item FAQ
            const btnQuestion = item.querySelector('.faq-question');
            if (btnQuestion) {
                btnQuestion.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Ferme les autres FAQ (mode exclusif)
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            // Mettez à jour l'attribut ARIA
                            const autreBtn = otherItem.querySelector('.faq-question');
                            if (autreBtn) autreBtn.setAttribute('aria-expanded', 'false');
                        }
                    });
                    // Bascule l'état actif sur l'item cliqué
                    item.classList.toggle('active');
                    btnQuestion.setAttribute('aria-expanded', item.classList.contains('active') ? 'true' : 'false');
                });
            }

            // Empêche les clics sur l'élément global d'entraîner des comportements inattendus
            item.addEventListener('click', e => e.stopPropagation());
        });
    },

};

/************************************************************
 * Classe Carrousel : gère le carrousel de la section hero
 ************************************************************/
class Carousel {
    constructor() {
        this.carousel = document.querySelector('.carousel');
        this.slides = Array.from(document.querySelectorAll('.slide'));
        this.dots = Array.from(document.querySelectorAll('.dot'));

        this.currentSlide = 0;
        this.slideInterval = null;

        this.init();
    }

    init() {
        // Add event listeners

        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Start automatic slideshow
        this.startSlideshow();

        // Pause slideshow on hover
        this.carousel.addEventListener('mouseenter', () => this.pauseSlideshow());
        this.carousel.addEventListener('mouseleave', () => this.startSlideshow());
    }

    goToSlide(index) {
        // Remove active classes
        this.slides[this.currentSlide].classList.remove('active');
        this.dots[this.currentSlide].classList.remove('active');

        // Set new current slide
        this.currentSlide = index;

        // Add active classes
        this.slides[this.currentSlide].classList.add('active');
        this.dots[this.currentSlide].classList.add('active');
    }

    nextSlide() {
        const next = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(next);
    }

    prevSlide() {
        const prev = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(prev);
    }

    startSlideshow() {
        if (this.slideInterval) return;
        this.slideInterval = setInterval(() => this.nextSlide(), 5000);
    }

    pauseSlideshow() {
        if (!this.slideInterval) return;
        clearInterval(this.slideInterval);
        this.slideInterval = null;
    }
}

const testimonials = [
    {
        quote: "Charger de supervise et coordonne les activités du comité, représente officiellement le groupe et prend les décisions stratégiques.",
        name: "SORO Eméric Jamel",
        designation: "Président du comité d'organisation (PCO)",
        src: "backend/client/assets/images/Emeric.webp"
    },
    {
        quote: "Charger d'assister le président, le remplace en son absence et supervise des projets ou sous-comités spécifiques.",
        name: "ADJE Aude-esther",
        designation: "Vice président du comité d'organisation (Vice-PCO)",
        src: "backend/client/assets/images/Aude.webp"
    },
    {
        quote: "Charger de gèrer la documentation, rédige les procès-verbaux, prépare les ordres du jour et assure la communication interne.",
        name: "TRA Lou Océane",
        designation: "Sécrétaire et Responsable du comité logiciel",
        src: "backend/client/assets/images/oceane.webp"
    },
    {
        quote: "Charger de gèrer les finances, prépare les budgets, suit les dépenses/recettes et veille à la transparence financière.",
        name: "IRIE Anne Jemima",
        designation: "Trésorier",
        src: "backend/client/assets/images/Jemima.webp"
    }
];

let activeIndex = 0;
let autoplayInterval;

function setupImages() {
    const container = document.getElementById('imageContainer');
    testimonials.forEach((testimonial, index) => {
        const img = document.createElement('img');
        img.src = testimonial.src;
        img.alt = testimonial.name;
        img.className = `testimonial-image ${index === 0 ? 'active' : 'inactive'}`;
        img.id = `image-${index}`;
        container.appendChild(img);
    });
}

function updateContent(index) {
    document.getElementById('name').textContent = testimonials[index].name;
    document.getElementById('designation').textContent = testimonials[index].designation;
    const quoteElement = document.getElementById('quote');
    quoteElement.textContent = testimonials[index].quote;
    quoteElement.classList.remove('active');
    setTimeout(() => quoteElement.classList.add('active'), 50);

    document.querySelectorAll('.testimonial-image').forEach((img, i) => {
        img.className = `testimonial-image ${i === index ? 'active' : 'inactive'}`;
    });
}

function handleNext() {
    activeIndex = (activeIndex + 1) % testimonials.length;
    updateContent(activeIndex);
}

function handlePrev() {
    activeIndex = (activeIndex - 1 + testimonials.length) % testimonials.length;
    updateContent(activeIndex);
}

function startAutoplay() {
    autoplayInterval = setInterval(handleNext, 5000);
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    setupImages();
    updateContent(0);
    document.getElementById('nextButton').addEventListener('click', handleNext);
    document.getElementById('prevButton').addEventListener('click', handlePrev);
    startAutoplay();
});

const reviews = [
    {
        img: "backend/client/assets/images/ufhb.webp"
    },
    {
        img: "backend/client/assets/images/mi.webp"
    },
    {
        img: "backend/client/assets/images/pmd.webp"
    },
    {
        img: "backend/client/assets/images/paytou.webp"
    },
    {
        img: "backend/client/assets/images/zaki.webp"
    }
];
function createReviewCard(review) {
    return `<img src="${review.img}" alt="" />`;
}

function duplicateContent(element) {
    const content = element.innerHTML;
    element.innerHTML = content + content;
}

// Utiliser tous les logos au lieu de diviser le tableau
const firstRowElement = document.getElementById('firstRow');

// Afficher tous les logos
firstRowElement.innerHTML = reviews.map(createReviewCard).join('');

// Dupliquer le contenu pour un défilement sans interruption
duplicateContent(firstRowElement);

/************************************************************
 * Modal fun
 ************************************************************/
document.addEventListener('DOMContentLoaded', function() {
    // Date cible: 12 Avril 2025 à 17h00 GMT (inchangée)
    const dateFinale = new Date('2025-04-12T17:00:00').getTime();

    // --- Éléments DOM (simplifiés) ---
    const modalCountdownElement = document.getElementById('modalCountdown'); // Affichage DANS la modale
    const modalOverlay = document.getElementById('timerModal');
    const modalContent = modalOverlay?.querySelector('.modal-content');
    const timerBoxes = document.querySelectorAll('.cache'); // Déclencheurs
    const closeModalBtn = document.getElementById('closeModal');

    // --- Vérification des éléments essentiels (simplifiée) ---
    if (!modalOverlay || !modalContent || timerBoxes.length === 0 || !modalCountdownElement || !closeModalBtn) {
        console.error("Erreur critique : Éléments essentiels pour la modale non trouvés.");
        console.error("Vérifiez : #timerModal, .modal-content, .cache (au moins 1), #modalCountdown, #closeModal.");
        return; // Arrêter
    }

    // --- Variables globales (simplifiées) ---
    // Plus besoin de clickCount, clickTimer
    let modalAutoCloseTimer;
    let timerInterval;
    let lastClickedElement = null;
    let isModalOpen = false; // Toujours utile pour éviter les ouvertures multiples

    // --- Fonction Minuteur (met à jour SEULEMENT la modale) ---
    function mettreAJourMinuteurModal() {
        const maintenant = new Date().getTime();
        const tempsRestant = dateFinale - maintenant;
        let timerText = "--j --:--:--"; // Valeur par défaut si calcul impossible

        if (!modalCountdownElement) return; // Sécurité si l'élément disparaît

        if (tempsRestant <= 0) {
            timerText = "Expiré";
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
        } else {
            const jours = Math.floor(tempsRestant / (1000 * 60 * 60 * 24));
            const heures = Math.floor((tempsRestant % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((tempsRestant % (1000 * 60 * 60)) / (1000 * 60));
            const secondes = Math.floor((tempsRestant % (1000 * 60)) / 1000);

            const joursF = String(jours).padStart(2, '0');
            const heuresF = String(heures).padStart(2, '0');
            const minutesF = String(minutes).padStart(2, '0');
            const secondesF = String(secondes).padStart(2, '0');

            timerText = `${joursF}j ${heuresF}:${minutesF}:${secondesF}`;
        }

        // Mettre à jour UNIQUEMENT l'affichage dans la modale
        modalCountdownElement.innerHTML = timerText;
    }

    // --- Fonction Confettis (inchangée) ---
    function createConfetti() {
        // ... (code des confettis inchangé) ...
        const colors = ['#fff', '#74b9ff', '#00cec9', '#fdcb6e', '#e84393', '#55efc4'];
        modalContent.querySelectorAll('.confetti').forEach(el => el.remove());
        for (let i = 0; i < 15; i++) {
            const confetti = document.createElement('div');
            confetti.classList.add('confetti');
            confetti.style.cssText = `position:absolute; width:8px; height:8px; background-color:${colors[Math.floor(Math.random() * colors.length)]}; left:${Math.random() * 100}%; top:-10px; border-radius: 50%; opacity: 0.8;`;
            modalContent.appendChild(confetti);
            gsap.to(confetti, {
                y: modalContent.offsetHeight + 20, x: (Math.random() - 0.5) * 60,
                rotation: Math.random() * 360, duration: 1.2 + Math.random() * 0.8,
                ease: "power1.out", onComplete: () => confetti.remove()
            });
        }
    }

    // --- Fonction Ouvrir Modale (inchangée dans sa logique interne) ---
    function openModalFromElement(element) {
        if (isModalOpen) return; // Sécurité anti-réouverture rapide
        isModalOpen = true;

        lastClickedElement = element;
        if (!lastClickedElement) { isModalOpen = false; return; }

        // Mettre à jour l'heure dans la modale juste avant de l'ouvrir
        mettreAJourMinuteurModal();

        const boxRect = lastClickedElement.getBoundingClientRect();
        const boxCenterX = boxRect.left + boxRect.width / 2;
        const boxCenterY = boxRect.top + boxRect.height / 2;

        modalOverlay.style.display = 'flex';
        modalOverlay.style.pointerEvents = 'auto';
        void modalContent.offsetHeight;

        const overlayPaddingTop = parseFloat(getComputedStyle(modalOverlay).paddingTop || '10px');
        const initialY = boxCenterY - (modalContent.offsetHeight / 2) - overlayPaddingTop;
        const initialX = boxCenterX - (window.innerWidth / 2);

        gsap.set(modalContent, {
            opacity: 0, scale: 0.1, x: initialX, y: initialY,
            transformOrigin: "center center", visibility: 'visible',
            maxWidth: 'calc(100vw - 20px)', maxHeight: 'calc(100vh - 40px)'
        });

        const tl = gsap.timeline({
            onComplete: () => { createConfetti(); modalAutoCloseTimer = setTimeout(closeModalToElement, 4000); }
        });

        tl.to(modalContent, { opacity: 1, scale: 1, x: 0, y: 0, duration: 0.6, ease: "power2.out" });
        tl.from(modalContent.querySelectorAll('.modal-title, .big-timer'), {
            opacity: 0, y: 15, stagger: 0.1, duration: 0.4
        }, "-=0.3");
    }

    // --- Fonction Fermer Modale (inchangée) ---
    function closeModalToElement() {
        if (!isModalOpen || !lastClickedElement || !modalContent || modalContent.style.visibility === 'hidden') {
            isModalOpen = false; return;
        }
        clearTimeout(modalAutoCloseTimer);

        const boxRect = lastClickedElement.getBoundingClientRect();
        const boxCenterX = boxRect.left + boxRect.width / 2;
        const boxCenterY = boxRect.top + boxRect.height / 2;
        const overlayPaddingTop = parseFloat(getComputedStyle(modalOverlay).paddingTop || '10px');
        const targetY = boxCenterY - (modalContent.offsetHeight / 2) - overlayPaddingTop;
        const targetX = boxCenterX - (window.innerWidth / 2);
        const internalElements = modalContent.querySelectorAll('.modal-title, .big-timer');

        const tl = gsap.timeline({
            onComplete: () => {
                modalOverlay.style.display = 'none'; modalOverlay.style.pointerEvents = 'none';
                modalContent.style.visibility = 'hidden';
                gsap.set(modalContent, { clearProps: "all" });
                gsap.set(internalElements, { clearProps: "opacity,transform" });
                modalContent.querySelectorAll('.confetti').forEach(el => el.remove());
                lastClickedElement = null; isModalOpen = false;
            }
        });
        tl.to(internalElements, { opacity: 0, y: -10, stagger: 0.05, duration: 0.25 });
        tl.to(modalContent, { opacity: 0, scale: 0.1, x: targetX, y: targetY, duration: 0.5, ease: "power1.in" }, "-=0.1");
    }

    // --- Gestionnaires d'événements (simplifiés) ---

    // Attacher le listener de SIMPLE clic à CHAQUE élément .cache
    timerBoxes.forEach(box => {
        box.addEventListener('click', function(e) {
            // Ouvre sur un simple clic, seulement si la modale n'est pas déjà ouverte/en cours
            if (!isModalOpen) {
                openModalFromElement(e.currentTarget); // 'this' ou 'e.currentTarget' réfère au 'box' cliqué
            }
        });
        // Plus besoin des listeners mouseenter/mouseleave pour l'effet de survol sur le texte du décompte
    });

    // Fermeture via bouton 'X' (inchangé)
    closeModalBtn.addEventListener('click', function(e) { e.stopPropagation(); closeModalToElement(); });

    document.addEventListener('click', function(e) {
        // Ne rien faire si la modale n'est pas ouverte
        if (!isModalOpen) {
            return;
        }

        // Vérifier si la cible du clic (e.target) est le contenu de la modale ou un de ses enfants
        const isClickInsideModalContent = modalContent.contains(e.target);

        // Si le clic est EN DEHORS du contenu de la modale, fermer.
        if (!isClickInsideModalContent) {
            closeModalToElement();
        }
        // Si le clic est à l'intérieur (sur le titre, le timer, etc.), l'écouteur du bouton 'X' (avec stopPropagation)
        // ou l'absence d'autre action feront que la modale reste ouverte.
    });
    // --- Initialisation ---
    // Calculer l'heure une fois pour la modale (même si elle est cachée)
    mettreAJourMinuteurModal();

    // Démarrer l'intervalle seulement si la date n'est pas passée
    // et seulement s'il n'est pas déjà en cours (sécurité)
    if (dateFinale > new Date().getTime() && !timerInterval) {
        timerInterval = setInterval(mettreAJourMinuteurModal, 1000);
    }

    // Assurer l'état initial caché de l'overlay
    modalOverlay.style.display = 'none';
    modalOverlay.style.pointerEvents = 'none';

});