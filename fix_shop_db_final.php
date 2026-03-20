<?php
$connexion = mysqli_connect('localhost', 'root', '', 'shop');
if (!$connexion) { die("Connection failed: " . mysqli_connect_error()); }

function addColumn($conn, $table, $col, $after, $type = "VARCHAR(255) NULL") {
    $check = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$col'");
    if (mysqli_num_rows($check) == 0) {
        $q = "ALTER TABLE `$table` ADD COLUMN `$col` $type AFTER `$after`";
        if (mysqli_query($conn, $q)) {
            echo "SUCCESS: Added $col to $table\n";
        } else {
            echo "ERROR: Could not add $col to $table: " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "EXISTED: $col in $table\n";
    }
}

// site_configuration columns
addColumn($connexion, 'site_configuration', 'google_search_console', 'analytics');
addColumn($connexion, 'site_configuration', 'facebook_pixel', 'google_search_console');
addColumn($connexion, 'site_configuration', 'theme_color', 'facebook_pixel', "VARCHAR(20) DEFAULT '#ffffff'");
addColumn($connexion, 'site_configuration', 'developer_comment', 'theme_color', "TEXT NULL");

// Legal fields in case they were missed
addColumn($connexion, 'site_configuration', 'matricule_fiscale', 'n8n_webhook_url');
addColumn($connexion, 'site_configuration', 'rne', 'matricule_fiscale');
addColumn($connexion, 'site_configuration', 'registre_commerce', 'rne');
addColumn($connexion, 'site_configuration', 'banque', 'registre_commerce');
addColumn($connexion, 'site_configuration', 'rib', 'banque');
addColumn($connexion, 'site_configuration', 'swift', 'rib');
addColumn($connexion, 'site_configuration', 'code_douane', 'swift');

// optimisation_seo columns
addColumn($connexion, 'optimisation_seo', 'title_home', 'id');
addColumn($connexion, 'optimisation_seo', 'description_home', 'title_home', "TEXT NULL");
addColumn($connexion, 'optimisation_seo', 'keywords_home', 'description_home', "TEXT NULL");

echo "\nMigration for 'shop' DB completed.\n";
?>
