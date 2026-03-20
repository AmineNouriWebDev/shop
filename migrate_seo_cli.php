<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Manual DB Connection bypassing environment vars that might fail in CLI
$host = "localhost";
$user = "root";
$pass = ""; // Assumption based on local XAMPP
$db = "technopl_db";

$connexion = @mysqli_connect($host, $user, $pass, $db);
if(!$connexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$queries = [
    "ALTER TABLE `site_configuration` ADD COLUMN `google_search_console` VARCHAR(255) NULL AFTER `analytics`",
    "ALTER TABLE `site_configuration` ADD COLUMN `facebook_pixel` VARCHAR(255) NULL AFTER `google_search_console`",
    "ALTER TABLE `site_configuration` ADD COLUMN `theme_color` VARCHAR(20) DEFAULT '#ffffff' AFTER `facebook_pixel`"
];

foreach ($queries as $query) {
    if (mysqli_query($connexion, $query)) {
        echo "SUCCESS: $query\n";
    } else {
        echo "SKIPPED/ERROR (Might already exist): " . mysqli_error($connexion) . "\n";
    }
}
?>
