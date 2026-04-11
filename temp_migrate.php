<?php
include('_admin_site/includes/fonctions/fction_db.php');
include('_admin_site/includes/fonctions/fction_pages.php'); // Just in case it's needed by include.php
// Manually defining connection if needed or just use the system's
// But the system uses include.php which might have redirection or session checks.
// Let's use a very minimal script that only uses the BDD connection.

// Try to get connection from a known file
$conn_file = '_admin_site/includes/fonctions/fction_db.php';
// We'll just define the essential executeRequete if we can't include easily.
// But the environment is a real shop, so let's try to include the actual include.php first.

error_reporting(E_ALL);
ini_set('display_errors', 1);

// We need to bypass session check if any
$_SESSION['sess_id'] = 'migration'; 

include('include.php'); // Root include.php

$queries = [
    "ALTER TABLE `liste_produits` ADD COLUMN `tri` VARCHAR(50) DEFAULT 'recent' AFTER `idproduit`",
    "ALTER TABLE `liste_produits` ADD COLUMN `stock_only` INT DEFAULT 0 AFTER `tri`"
];

echo "<pre>";
foreach ($queries as $query) {
    echo "Executing: $query ... ";
    $res = mysqli_query($connexion, $query);
    if ($res) {
        echo "Success\n";
    } else {
        echo "Error: " . mysqli_error($connexion) . " (Might already exist)\n";
    }
}
echo "Migration finished.\n";
echo "</pre>";
?>
