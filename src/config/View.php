<?php

namespace config;


class View
{
    private static string $baseDir = 'backend/client/views/'; // Répertoire des vues

    /**
     * Rend une vue.
     *
     * @param string $view Le nom de la vue (par exemple 'accueil').
     * @param array $data Les données à passer à la vue.
     *
     * @throws \Exception Si le fichier de la vue n'existe pas.
     */
    public static function render(string $view, array $data = [])
    {
        $file = self::$baseDir . $view . '.php';

        if (!file_exists($file)) {
            throw new \Exception("Le fichier de vue '{$view}' est introuvable dans " . self::$baseDir);
        }

        extract($data); // Rendre les données disponibles dans la vue
        require_once $file; // Inclure le fichier de vue
    }
}