import { defineConfig } from 'vite';

export default defineConfig({
    root: '.',  // Dossier où sont les fichiers sources
    build: {
        outDir: '../backend/client/assets',  // Dossier où seront générés les fichiers optimisés
        emptyOutDir: true,  // Supprime les anciens fichiers avant de rebuild
        rollupOptions: {
            input: {
                main: './js/main.js', // Fichier JS principal
            },
            output: {
                entryFileNames: 'js/[name].js', // Les fichiers JS seront dans assets/js/
                chunkFileNames: 'js/[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return 'css/[name][extname]'; // Les fichiers CSS seront dans assets/css/
                    }
                    return 'assets/[name][extname]';
                },
            },
        },
    },
    server: {
        port: 5173,
        host: '0.0.0.0',  // 🔹 Permet d'accéder au serveur depuis Docker
        strictPort: true,
        watch: {
            usePolling: true  // 🔹 Important pour Docker
        },
    }
});
