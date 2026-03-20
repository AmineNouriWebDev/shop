<?php
include("include.php");

echo "<h3>Starting SEO & Tracking Database Migration...</h3>";

$connexion = ouvrirCnx() or die("Erreur de connexion à la base de données.");

$queries = [
    "ALTER TABLE `site_configuration` ADD COLUMN `google_search_console` VARCHAR(255) NULL AFTER `analytics`",
    "ALTER TABLE `site_configuration` ADD COLUMN `facebook_pixel` VARCHAR(255) NULL AFTER `google_search_console`",
    "ALTER TABLE `site_configuration` ADD COLUMN `theme_color` VARCHAR(20) DEFAULT '#ffffff' AFTER `facebook_pixel`"
];

foreach ($queries as $query) {
    if (mysqli_query($connexion, $query)) {
        echo "<p style='color:green;'>SUCCESS: $query</p>";
    } else {
        echo "<p style='color:orange;'>SKIPPED/ERROR (Might already exist): " . mysqli_error($connexion) . "</p>";
    }
}

echo "<h3>Migration Complete.</h3>";
?>
