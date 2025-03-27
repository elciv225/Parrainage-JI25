import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';

const jsDir = path.resolve(__dirname, 'src/js');
const cssDir = path.resolve(__dirname, 'src/css');
const imgDir = path.resolve(__dirname, 'src/images'); // ✅ Ajout du dossier images

// 🔹 Lire les fichiers JS
const jsFiles = fs.existsSync(jsDir)
    ? fs.readdirSync(jsDir)
        .filter(file => file.endsWith('.js'))
        .reduce((entries, file) => {
            const name = `js/${file.replace('.js', '')}`; // ✅ Préserve le dossier js/
            entries[name] = path.resolve(jsDir, file);
            return entries;
        }, {})
    : {};

// 🔹 Lire les fichiers CSS
const cssFiles = fs.existsSync(cssDir)
    ? fs.readdirSync(cssDir)
        .filter(file => file.endsWith('.css'))
        .reduce((entries, file) => {
            const name = `css/${file.replace('.css', '')}`; // ✅ Préserve le dossier css/
            entries[name] = path.resolve(cssDir, file);
            return entries;
        }, {})
    : {};

// 🔹 Lire les fichiers images
const imgFiles = fs.existsSync(imgDir)
    ? fs.readdirSync(imgDir)
        .filter(file => /\.(png|jpe?g|svg|gif|webp)$/i.test(file)) // ✅ Sélectionner seulement les images
        .reduce((entries, file) => {
            const name = `images/${file.replace(/\.[^/.]+$/, '')}`; // ✅ Ajoute les images au bon dossier
            entries[name] = path.resolve(imgDir, file);
            return entries;
        }, {})
    : {};

// 🔹 Fusionner les entrées JS, CSS et Images
const inputFiles = { ...jsFiles, ...cssFiles, ...imgFiles };

export default defineConfig({
    root: '.',
    build: {
        outDir: '../backend/client/assets',
        emptyOutDir: true,
        rollupOptions: {
            input: inputFiles, // ✅ Inclure JS, CSS et images
            output: {
                entryFileNames: '[name].js', // ✅ Fichiers JS dans /js/
                chunkFileNames: '[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return '[name][extname]'; // ✅ CSS dans /css/
                    }
                    if (/\.(png|jpe?g|svg|gif|webp)$/i.test(assetInfo.name)) {
                        return 'images/[name][extname]'; // ✅ Images dans /images/
                    }
                    return 'assets/[name][extname]';
                },
            },
        },
    },
    server: {
        port: 5173,
        host: '0.0.0.0',
        strictPort: true,
        watch: {
            usePolling: true
        },
    }
});
