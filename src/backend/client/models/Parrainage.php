<?php

namespace models;

class Parrainage
{

    /**
     * Lie aléatoirement les utilisateurs du même profil. Un L3 prend 2 autres utilisateurs.
     * Affiche les liens au fur et à mesure de leur création.
     * Les utilisateurs liés sont retirés de la liste des disponibles pour ce profil.
     *
     * @param array $utilisateurs Un tableau d'objets Utilisateur du même profil.
     * @return array Un tableau des Utilisateurs qui n'ont pas été liés.
     */
    public function liasonsParrainage(array $utilisateurs): array
    {
        $l3Utilisateurs = [];
        $autresUtilisateurs = [];

        // Séparer les utilisateurs L3 des autres
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur->getNiveau() === 'L3') {
                $l3Utilisateurs[] = $utilisateur;
            } else {
                $autresUtilisateurs[] = $utilisateur;
            }
        }

        // Mélanger aléatoirement les autres utilisateurs pour une liaison aléatoire
        shuffle($autresUtilisateurs);

        $utilisateursRestants = [...$autresUtilisateurs]; // Créer une copie pour suivre les utilisateurs disponibles
        $indicesRestantsToRemove = [];

        // Tenter de lier chaque utilisateur L3 avec deux autres utilisateurs disponibles
        foreach ($l3Utilisateurs as $l3Utilisateur) {
            $partenaires = [];
            $indicesToRemove = [];

            // Rechercher deux partenaires pour l'utilisateur L3 parmi les restants
            for ($i = 0; $i < count($utilisateursRestants); $i++) {
                if (count($partenaires) < 2) {
                    $partenaires[] = $utilisateursRestants[$i];
                    $indicesToRemove[] = $i;
                } else {
                    break; // Deux partenaires trouvés
                }
            }

            // Si deux partenaires ont été trouvés, afficher le lien et marquer les partenaires pour suppression
            if (count($partenaires) === 2) {
                echo "Lien créé : " . $l3Utilisateur->getPrenom() . " " . $l3Utilisateur->getNom() . " (L3) est lié avec ";
                echo $partenaires[0]->getPrenom() . " " . $partenaires[0]->getNom() . " et ";
                echo $partenaires[1]->getPrenom() . " " . $partenaires[1]->getNom() . "\n";

                // Ajouter les indices à supprimer (en ordre décroissant pour éviter les problèmes d'index)
                rsort($indicesToRemove);
                foreach ($indicesToRemove as $index) {
                    $indicesRestantsToRemove[] = array_search($index, array_keys($utilisateursRestants));
                }
            }
            // Si l'utilisateur L3 n'a pas trouvé deux partenaires, il sera considéré comme restant
        }

        // Supprimer les utilisateurs qui ont été liés de la liste des restants
        $restantsApresLiaison = [];
        foreach (array_keys($utilisateursRestants) as $index) {
            if (!in_array($index, $indicesRestantsToRemove)) {
                $restantsApresLiaison[] = $utilisateursRestants[$index];
            }
        }

        // Les L3 qui n'ont pas été liés sont également considérés comme restants
        return array_merge($restantsApresLiaison, $l3Utilisateurs);
    }
}