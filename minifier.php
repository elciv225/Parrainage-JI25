<?php
function minifyHtml($buffer): array|string|null
{
    $search = [
        '/\>[^\S ]+/s',   // Supprime les espaces après les balises
        '/[^\S ]+\</s',   // Supprime les espaces avant les balises
        '/(\s)+/s'        // Supprime les espaces multiples
    ];
    $replace = ['>', '<', '\\1'];

    return preg_replace($search, $replace, $buffer);
}

$viewsDir = __DIR__ . '/src/backend/client/views/';
$outputDir = __DIR__ . '/src/backend/client/views-minified/';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$files = glob($viewsDir . '*.php');
$totalFiles = count($files);
$fileIndex = 0;

$stats = [];

foreach ($files as $file) {
    $fileIndex++;

    // Lire le contenu original
    $originalSize = filesize($file);
    $content = file_get_contents($file);

    // Minifier le contenu
    $minifiedContent = minifyHtml($content);

    // Calcul de la taille après minification
    $minifiedSize = strlen($minifiedContent);

    // Sauvegarder le fichier minifié
    file_put_contents($outputDir . basename($file), $minifiedContent);

    // Stocker les statistiques
    $stats[] = [
        'file' => basename($file),
        'original_size' => $originalSize,
        'minified_size' => $minifiedSize,
        'saved' => $originalSize - $minifiedSize,
        'saved_percent' => round((($originalSize - $minifiedSize) / $originalSize) * 100, 2)
    ];

    // Affichage de la progression
    echo "[ $fileIndex / $totalFiles ] Minification : " . basename($file) . " - Gain : " . ($originalSize - $minifiedSize) . " octets (" . round((($originalSize - $minifiedSize) / $originalSize) * 100, 2) . "%)\n";
}

// Affichage du résumé final
echo "\n=== 🚀 RÉCAPITULATIF DE LA MINIFICATION ===\n";
echo str_pad("Fichier", 30) . str_pad("Taille Initiale", 20) . str_pad("Taille Minifiée", 20) . str_pad("Gain", 15) . "Réduction (%)\n";
echo str_repeat("-", 100) . "\n";

foreach ($stats as $stat) {
    echo str_pad($stat['file'], 30) .
        str_pad($stat['original_size'] . " o", 20) .
        str_pad($stat['minified_size'] . " o", 20) .
        str_pad("-" . $stat['saved'] . " o", 15) .
        "-" . $stat['saved_percent'] . "%\n";
}

echo "\n✅ Minification terminée ! Fichiers optimisés dans : $outputDir\n";
?>
