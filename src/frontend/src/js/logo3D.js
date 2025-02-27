import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { gsap } from 'gsap';

/****************************************************
 * Lancement global au chargement du DOM
 ****************************************************/
document.addEventListener("DOMContentLoaded", function () {
    class InteractiveLogo {
        constructor() {
            this.container = document.querySelector('.logo-flottant');
            this.mouse = {x: 0, y: 0};
            this.targetRotation = {x: 0, y: 0};

            this.setupScene();
            this.loadLogo();
            this.setupInteraction();
            this.animate();
        }

        setupScene() {
            this.scene = new THREE.Scene();
            this.camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            this.renderer = new THREE.WebGLRenderer({alpha: true, antialias: true});

            this.updateSize();
            window.addEventListener('resize', () => this.updateSize());
            this.container.appendChild(this.renderer.domElement);

            this.camera.position.z = 5;

            const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(5, 5, 5);
            this.scene.add(ambientLight, directionalLight);
        }

        loadLogo() {
            const loader = new GLTFLoader();
            const logoPath = 'logo.glb';

            loader.load(
                logoPath,
                (gltf) => {
                    this.logo = gltf.scene;
                    this.logo.scale.set(1, 1, 1);
                    this.scene.add(this.logo);

                    gsap.from(this.logo.scale, {x: 0, y: 0, z: 0, duration: 1.5, ease: "elastic.out(1, 0.3)"});
                },
                (xhr) => {
                    console.log(`Chargement du modèle : ${(xhr.loaded / xhr.total) * 100}% terminé`);
                },
                (error) => {
                    console.error('Erreur lors du chargement du modèle', error);
                }
            );
        }

        setupInteraction() {
            window.addEventListener('mousemove', (e) => {
                this.mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
                this.mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
                this.targetRotation.x = this.mouse.y * 0.5;
                this.targetRotation.y = this.mouse.x * 0.5;
            });

            this.container.addEventListener('click', () => {
                if (this.logo) {
                    gsap.to(this.logo.rotation, {
                        z: this.logo.rotation.z + Math.PI * 2,
                        duration: 1.5,
                        ease: "elastic.out(1, 0.3)"
                    });
                    gsap.to(this.logo.scale, {x: 1.2, y: 1.2, z: 1.2, duration: 0.2, yoyo: true, repeat: 1});
                }
            });
        }

        updateSize() {
            const width = window.innerWidth;
            const height = window.innerHeight;
            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(width, height);
            this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        }

        animate() {
            requestAnimationFrame(() => this.animate());
            if (this.logo) {
                this.logo.rotation.x += (this.targetRotation.x - this.logo.rotation.x) * 0.05;
                this.logo.rotation.y += (this.targetRotation.y - this.logo.rotation.y) * 0.05;
                this.logo.position.y = Math.sin(Date.now() * 0.001) * 0.1;
            }
            this.renderer.render(this.scene, this.camera);
        }
    }

    new InteractiveLogo();
});