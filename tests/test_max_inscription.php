<?php
function simulate_inscription(int $nombres_test): void
{
    // URL de l'inscription
    $url = "http://localhost:8081/"; // Remplacez par l'URL réelle de votre formulaire d'inscription

    // Simulation des inscriptions
    for ($i = 0; $i < $nombres_test; $i++) {
        // Générer un email unique pour chaque inscription
        $uniqueEmail = "testuser" . $i . "@example.com";

        // Données d'inscription simulées
        $data = [
            'prenoms' => 'Test-' . $i,
            'nom' => 'User-' . $i,
            'niveau' => 'L2',
            'email' => $uniqueEmail,
            'motDePasse' => 'MotDePasse123',
            'totalScore' => 0,
            'photo-profil' => 'fakephoto.jpg', // Fichier photo simulé
            'btn-inscription-complete' => 'true', // Bouton d'envoi
        ];

        // Crée un contexte pour la requête POST
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data), // Convertit le tableau associatif en query string
            ]
        ];

        $context = stream_context_create($options);

        // Effectue la requête HTTP
        $response = file_get_contents($url, false, $context);

        // Affichage de la barre de progression dans la console
        $progress = (int)(($i + 1) / $nombres_test * 100);
        $bar = "[" . str_repeat("=", intval($progress / 2)) . str_repeat(" ", 50 - intval($progress / 2)) . "] $progress%";
        echo "\rInscription #$i: $bar"; // Affichage de la barre de progression

        // Optionnel: vous pouvez loguer la réponse si nécessaire
        // echo "\nResponse #$i: " . $response . "\n";
    }

    echo "\nSimulation terminée après $nombres_test inscriptions simulées.\n";
}

// Exemple d'appel de la fonction
simulate_inscription(150);
?>
