<?php
include('includes/include.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// We need to bypass session check if any
$_SESSION['sess_id'] = 'migration'; 

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
