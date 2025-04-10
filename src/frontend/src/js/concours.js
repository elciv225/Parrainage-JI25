import {gsap} from "gsap";

document.addEventListener('DOMContentLoaded', () => {
    App.init()
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

    const cartes = document.querySelectorAll('.carte-mpc');
    let carteActive = null;
    let overlay = document.querySelector('.overlay');

    let detailContainer = overlay.querySelector('.detail-container');
    let closeBtn;
    let detailContent;

    if (!detailContainer) {
        detailContainer = document.createElement('div');
        detailContainer.className = 'detail-container';

        closeBtn = document.createElement('button');
        closeBtn.className = 'close-btn';
        closeBtn.innerHTML = '&times;';
        detailContainer.appendChild(closeBtn);

        detailContent = document.createElement('div');
        detailContent.className = 'detail-content';
        detailContainer.appendChild(detailContent);

        overlay.appendChild(detailContainer);
    } else {
        closeBtn = detailContainer.querySelector('.close-btn');
        detailContent = detailContainer.querySelector('.detail-content');

        if (!closeBtn) {
            closeBtn = document.createElement('button');
            closeBtn.className = 'close-btn';
            closeBtn.innerHTML = '&times;';
            if (detailContent) {
                detailContainer.insertBefore(closeBtn, detailContent);
            } else {
                detailContainer.appendChild(closeBtn);
            }
        }
        if (!detailContent) {
            detailContent = document.createElement('div');
            detailContent.className = 'detail-content';
            detailContainer.appendChild(detailContent);
        }
    }


    cartes.forEach(carte => {
        carte.addEventListener('click', function () {
            ouvrirCarte(carte);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', fermerOverlay);
    }

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            fermerOverlay();
        }
    });


    function ouvrirCarte(carte) {
        if (!overlay || !detailContent || !detailContainer) return;

        carteActive = carte;

        const hiddenDetailsSource = carte.querySelector('.overlay-details-content');

        detailContent.innerHTML = '';

        if (hiddenDetailsSource) {
            Array.from(hiddenDetailsSource.children).forEach(child => {
                detailContent.appendChild(child.cloneNode(true));
            });
        } else {
            detailContent.innerHTML = '<p>Détails non disponibles.</p>';
            const titre = carte.querySelector('h2')?.textContent || 'Titre';
            const description = carte.querySelector('p')?.textContent || 'Description non fournie.';
            detailContent.innerHTML = `<h2>${titre}</h2><p>${description}</p>`;
        }

        gsap.set(overlay, { display: 'block' });

        const tl = gsap.timeline();
        tl.to(overlay, { duration: 0.3, autoAlpha: 1 })
            .to(detailContainer, {
                duration: 0.5,
                autoAlpha: 1,
                y: 0,
                scale: 1,
                ease: "back.out(1.2)"
            }, "-=0.1");
    }

    function fermerOverlay() {
        if (!overlay || !carteActive || !detailContainer) return;

        const tl = gsap.timeline({
            onComplete: () => {
                gsap.set(overlay, { display: 'none' });
                carteActive = null;
            }
        });

        tl.to(detailContainer, {
            duration: 0.3,
            autoAlpha: 0,
            y: -20,
            scale: 0.95,
            ease: "power2.in"
        })
            .to(overlay, {
                duration: 0.2,
                autoAlpha: 0
            }, "-=0.1");
    }
});

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