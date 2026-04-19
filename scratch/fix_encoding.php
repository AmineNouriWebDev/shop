<?php
include '../connec.php';

$tables = [
    'site_menu',
    'site_configuration',
    'optimisation_seo',
    'produits',
    'categories_blog',
    'caracteristiques',
    'valeur_caracteristique',
    'sliders',
    'articles',
    'bloc_accueil'
];

echo "<h2>Migration vers utf8mb4_unicode_ci</h2>";

foreach ($tables as $table) {
    echo "Traitement de la table <strong>$table</strong>... ";
    
    // Convert table and all its columns
    $sql = "ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    if (mysqli_query($connexion, $sql)) {
        echo "<span style='color:green'>SUCCESS</span><br>";
    } else {
        echo "<span style='color:red'>FAILED: " . mysqli_error($connexion) . "</span><br>";
    }
}

echo "<br><strong>Migration terminée.</strong><br>";
echo "Note: Les caractères '?' déjà enregistrés resteront des '?'. Vous devez éditer et ré-enregistrer les pages concernées.";
?>
