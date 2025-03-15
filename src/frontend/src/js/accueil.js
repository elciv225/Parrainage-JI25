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
     * 1. Initialisation du carrousel
     */


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
            boutonHamburger.addEventListener('click', () => {
                menuMobile.classList.toggle('open');
                const ouvert = menuMobile.classList.contains('open');
                iconeHamburger.className = ouvert ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
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
        src: "backend/client/assets/images/Emeric.jpg"
    },
    {
        quote: "Charger d'assister le président, le remplace en son absence et supervise des projets ou sous-comités spécifiques.",
        name: "ADJE Aude-esther",
        designation: "Vice président du comité d'organisation (Vice-PCO)",
        src: "backend/client/assets/images/default.jpg"
    },
    {
        quote: "Charger de gèrer la documentation, rédige les procès-verbaux, prépare les ordres du jour et assure la communication interne.",
        name: "TRA Lou Océane",
        designation: "Sécrétaire et Responsable du comité logiciel",
        src: "backend/client/assets/images/default.jpg"
    },
    {
        quote: "Charger de gèrer les finances, prépare les budgets, suit les dépenses/recettes et veille à la transparence financière.",
        name: "IRIE Anne Jemima",
        designation: "Trésorier",
        src: "backend/client/assets/images/Jemima.jpg"
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
        img: "assets/images/partenaires/logo1.jpeg"
    },
    {
        img: "assets/images/partenaires/logo2.jpg"
    },
    {
        img: "assets/images/partenaires/logo3.png"
    },
    {
        img: "assets/images/partenaires/logo3.jpg"
    },
    {
        img: "assets/images/partenaires/logo3.png"
    },
    {
        img: "assets/images/partenaires/logo1.jpeg"
    }
];

function createReviewCard(review) {
    return `<img src="${review.img}" alt="" />`;
}

function duplicateContent(element) {
    const content = element.innerHTML;
    element.innerHTML = content + content;
}

const firstRow = reviews.slice(0, reviews.length / 2);
const secondRow = reviews.slice(reviews.length / 2);

const firstRowElement = document.getElementById('firstRow');
const secondRowElement = document.getElementById('secondRow');

firstRowElement.innerHTML = firstRow.map(createReviewCard).join('');
secondRowElement.innerHTML = secondRow.map(createReviewCard).join('');

// Duplicate content for seamless scrolling
duplicateContent(firstRowElement);
duplicateContent(secondRowElement);
