<?php
session_start();
include("includes/include.php");
include("includes/security.php"); // Ensure only admin can run this

echo "<h1>🔧 Migration UTF8MB4 - Support Emojis</h1>";

// 1. Tables et colonnes à convertir
$migration_map = [
    'produits' => [
        'titre', 'court_contenu', 'caracteristique', 'remarque', 'titre_page', 'description', 'keywords'
    ],
    'catalogue' => [
        'titre', 'titre_page', 'description', 'keywords'
    ],
    'site_configuration' => [
        'nom_site', 'slogan', 'titre_logo', 'titre_page', 'texte_footer', 'developer_comment'
    ],
    'optimisation_seo' => [
        'title_home', 'description_home', 'keywords_home', 
        'title_prod', 'description_prod', 'keywords_prod'
    ],
    'liste_produits' => ['nom']
];

// 2. Conversion de la base de données
$db_name = $conn['name_bdd']; // setup in includes/include.php which calls connec.php
echo "<p>Conversion de la base de données <strong>$db_name</strong>...</p>";
mysqli_query($connexion, "ALTER DATABASE `$db_name` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci");

// 3. Conversion des tables et colonnes
foreach ($migration_map as $table => $columns) {
    echo "<h3>Traitement de la table : $table</h3>";
    
    // Vérifier si la table existe
    $check = mysqli_query($connexion, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($check) == 0) {
        echo "<p style='color:orange;'>[SKIP] Table '$table' introuvable.</p>";
        continue;
    }

    foreach ($columns as $col) {
        $res = mysqli_query($connexion, "SHOW FULL COLUMNS FROM `$table` WHERE Field = '$col'");
        if ($row = mysqli_fetch_assoc($res)) {
            $type = $row['Type'];
            $null = ($row['Null'] === 'YES') ? 'NULL' : 'NOT NULL';
            $default_val = $row['Default'];
            $default = ($default_val !== null) ? "DEFAULT '" . mysqli_real_escape_string($connexion, $default_val) . "'" : "";
            
            echo "<li>$col ($type)... ";
            $sql = "ALTER TABLE `$table` MODIFY `$col` $type CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci $null $default";
            if (mysqli_query($connexion, $sql)) {
                echo "<span style='color:green;'>[OK]</span></li>";
            } else {
                echo "<span style='color:red;'>[ERR] " . mysqli_error($connexion) . "</span></li>";
            }
        }
    }

    // Conversion globale de la table
    mysqli_query($connexion, "ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>Table '$table' convertie globalement.</p>";
}

echo "<h2>Migration terminée avec succès !</h2>";
echo "<p>Vous pouvez maintenant tester l'ajout d'emojis 🚀 sur votre serveur.</p>";
echo "<p><strong style='color:red;'>IMPORTANT :</strong> Pensez à supprimer ce fichier <code>_admin_site/fix_utf8mb4.php</code> après exécution.</p>";
?>
