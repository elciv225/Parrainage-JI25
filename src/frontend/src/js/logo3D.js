import * as THREE from 'three';
import {GLTFLoader} from 'three/examples/jsm/loaders/GLTFLoader';
import {gsap} from 'gsap';

/****************************************************
 * Lancement global au chargement du DOM
 ****************************************************/
document.addEventListener("DOMContentLoaded", function () {
    class InteractiveLogo {
        constructor() {
            this.container = document.querySelector('.logo-flottant');
            this.mouse = {x: 0, y: 0};
            this.targetRotation = {y: 0};
            this.autoRotationSpeed = 0.01; // Rotation automatique autour de l'axe Y seulement
            this.raycaster = new THREE.Raycaster();
            this.pointer = new THREE.Vector2();
            this.isLogoClicked = false;

            // Vérifier si le conteneur existe
            if (!this.container) {
                console.error("Conteneur .logo-flottant non trouvé");
                return;
            }

            this.setupScene();
            this.loadLogo();
            this.setupInteraction();
            this.animate();
        }

        setupScene() {
            this.scene = new THREE.Scene();

            // Adapter la caméra pour correspondre au ratio de la section hero
            const heroElement = document.querySelector('.hero');
            const aspectRatio = heroElement ?
                heroElement.clientWidth / heroElement.clientHeight :
                window.innerWidth / window.innerHeight;

            this.camera = new THREE.PerspectiveCamera(75, aspectRatio, 0.1, 1000);
            this.renderer = new THREE.WebGLRenderer({
                alpha: true,
                antialias: true,
                powerPreference: "high-performance"
            });

            // Configurer le Z-index pour que le logo reste derrière les textes
            this.renderer.domElement.style.position = 'absolute';
            this.renderer.domElement.style.zIndex = '1';

            // Configurer le container du logo pour qu'il ne bloque pas les interactions
            this.container.style.position = 'absolute';
            this.container.style.zIndex = '1';
            this.container.style.pointerEvents = 'none'; // Les clics traversent par défaut

            // Seul le canvas accepte les interactions
            this.renderer.domElement.style.pointerEvents = 'auto';

            this.updateSize();
            window.addEventListener('resize', () => this.updateSize());
            this.container.appendChild(this.renderer.domElement);

            // Positionner la caméra plus loin pour un logo plus grand
            this.camera.position.z = 10;

            // Éclairage amélioré pour un meilleur rendu
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(5, 5, 5);

            const backLight = new THREE.DirectionalLight(0xffffff, 0.5);
            backLight.position.set(-5, -5, -5);

            this.scene.add(ambientLight, directionalLight, backLight);
        }

        loadLogo() {
            const loader = new GLTFLoader();
            const logoPath = 'logo.glb';

            loader.load(
                logoPath,
                (gltf) => {
                    this.logo = gltf.scene;

                    // Trouver le centre du modèle
                    const box = new THREE.Box3().setFromObject(this.logo);
                    const center = box.getCenter(new THREE.Vector3());

                    // Centrer le modèle sur son centre de gravité
                    this.logo.position.sub(center);

                    // Créer un groupe pour contenir le logo
                    this.logoGroup = new THREE.Group();
                    this.logoGroup.add(this.logo);
                    this.scene.add(this.logoGroup);

                    // Augmenter davantage la taille du logo
                    this.logoGroup.scale.set(15.0, 15.0, 15.0);

                    // Animation d'entrée
                    gsap.from(this.logoGroup.scale, {
                        x: 0, y: 0, z: 0,
                        duration: 1.8,
                        ease: "elastic.out(1, 0.3)",
                        onComplete: () => {
                            // Animation continue de flottement
                            this.setupFloatingAnimation();
                        }
                    });

                    // Position initiale du groupe - ajustée pour le centre de l'écran
                    this.logoGroup.position.y = 0;

                    // Ajouter un volume bounding pour la détection des clics
                    this.logoBoundingBox = box;
                },
                (xhr) => {
                },
                (error) => {
                    console.error('Erreur lors du chargement du modèle', error);
                }
            );
        }

        setupFloatingAnimation() {
            // Animation continue de flottement plus subtile
            gsap.to(this.logoGroup.position, {
                y: '+=0.3',
                duration: 2,
                yoyo: true,
                repeat: -1,
                ease: "sine.inOut"
            });
        }

        setupInteraction() {
            // Variables pour le suivi de l'interaction
            this.isDragging = false;
            this.previousMousePosition = {x: 0};
            this.rotationSpeed = {y: 0}; // Pour l'effet d'inertie

            // Utiliser le renderer.domElement directement pour les interactions
            const canvas = this.renderer.domElement;

            // Fonction pour vérifier si un clic est sur le logo en utilisant raycaster
            const checkLogoClick = (clientX, clientY) => {
                if (!this.logoGroup) return false;

                // Convertir les coordonnées de l'écran en coordonnées normalisées (-1 à 1)
                const rect = canvas.getBoundingClientRect();
                this.pointer.x = ((clientX - rect.left) / rect.width) * 2 - 1;
                this.pointer.y = -((clientY - rect.top) / rect.height) * 2 + 1;

                this.raycaster.setFromCamera(this.pointer, this.camera);

                // Vérifier l'intersection avec le logo de façon précise
                const intersects = this.raycaster.intersectObject(this.logoGroup, true);
                return intersects.length > 0;
            };

            // Fonction pour gérer le début du drag
            const onMouseDown = (e) => {
                const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);

                // Vérifier si le clic est sur le logo
                const clickedOnLogo = checkLogoClick(clientX, clientY);

                if (clickedOnLogo) {
                    e.preventDefault();
                    e.stopPropagation();

                    this.isDragging = true;
                    this.isLogoClicked = true;

                    // Stocker la position initiale (uniquement X pour rotation horizontale)
                    this.previousMousePosition = {
                        x: clientX
                    };

                    // Désactiver temporairement la rotation automatique
                    this.tempAutoRotationSpeed = this.autoRotationSpeed;
                    this.autoRotationSpeed = 0;
                }
            };

            // Fonction pour gérer le mouvement
            const onMouseMove = (e) => {
                if (!this.isDragging) return;

                const clientX = e.clientX || (e.touches && e.touches[0].clientX);

                e.preventDefault();
                e.stopPropagation();

                // Calcul du mouvement pour la rotation (uniquement horizontale)
                const deltaX = clientX - this.previousMousePosition.x;

                if (this.logoGroup) {
                    // Appliquer uniquement la rotation horizontale (axe Y)
                    this.logoGroup.rotation.y += deltaX * 0.02;
                    this.rotationSpeed.y = deltaX * 0.01;
                }

                this.previousMousePosition = {x: clientX};
            };

            // Fonction pour terminer le drag
            const onMouseUp = (e) => {
                if (!this.isDragging) return;

                if (this.isLogoClicked) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                this.isDragging = false;
                this.isLogoClicked = false;

                // Appliquer l'inertie à la fin du drag pour un effet plus naturel
                if (this.logoGroup) {
                    // Conserver la vitesse de rotation pour l'inertie
                    gsap.to(this.rotationSpeed, {
                        y: 0,
                        duration: 1,
                        ease: "power2.out"
                    });
                }

                // Restaurer la rotation automatique après un délai
                setTimeout(() => {
                    this.autoRotationSpeed = this.tempAutoRotationSpeed || 0.01;
                }, 500);
            };

            // Ajouter les écouteurs d'événements directement au canvas
            canvas.addEventListener('mousedown', onMouseDown);
            canvas.addEventListener('touchstart', onMouseDown, {passive: false});

            // Pour les mouvements et fins, nous devons utiliser le document pour capturer
            // les événements même si la souris sort du canvas pendant le drag
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('touchmove', onMouseMove, {passive: false});

            document.addEventListener('mouseup', onMouseUp);
            document.addEventListener('touchend', onMouseUp);

            // Double-clic sur le logo pour faire tourner rapidement
            canvas.addEventListener('dblclick', (e) => {
                const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);

                // Vérifier si le double-clic est sur le logo
                if (!checkLogoClick(clientX, clientY)) return;

                e.preventDefault();
                e.stopPropagation();

                if (this.logoGroup) {
                    // Animation de rotation complète autour de l'axe Y (tour complet)
                    gsap.to(this.logoGroup.rotation, {
                        y: this.logoGroup.rotation.y + Math.PI * 2,
                        duration: 1.2,
                        ease: "power2.inOut"
                    });

                    // Animation d'échelle pour effet "bounce"
                    gsap.to(this.logoGroup.scale, {
                        x: 5.5, y: 5.5, z: 5.5,  // Augmenté pour correspondre à la nouvelle échelle
                        duration: 0.3,
                        yoyo: true,
                        repeat: 1,
                        ease: "back.out(1.5)"
                    });
                }
            });
        }

        updateSize() {
            const heroElement = document.querySelector('.hero');

            let width, height;
            if (heroElement) {
                width = heroElement.clientWidth;
                height = heroElement.clientHeight;
            } else {
                width = window.innerWidth;
                height = window.innerHeight;
            }

            // Ajuster la position de la caméra en fonction de la taille de l'écran
            if (width < 768) { // Mobile
                this.camera.position.z = 12; // Plus loin pour voir le logo complet
            } else {
                this.camera.position.z = 10;
            }

            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(width, height);
            this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        }

        animate() {
            requestAnimationFrame(() => this.animate());

            if (this.logoGroup) {
                // Appliquer la rotation automatique (uniquement sur Y)
                this.logoGroup.rotation.y += this.autoRotationSpeed;

                // Appliquer l'inertie après le drag (uniquement sur Y)
                if (!this.isDragging) {
                    this.logoGroup.rotation.y += this.rotationSpeed.y;
                }
            }

            this.renderer.render(this.scene, this.camera);
        }
    }

    // Initialiser le logo et le stocker dans une variable globale
    window.interactiveLogo = new InteractiveLogo();
});