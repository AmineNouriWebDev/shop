<?php
include("connec.php");

// Fetch table definitions related to products
$tables = ['produits', 'produit_images', 'caracteristiques', 'valeurs_caracteristique', 'produits_caracteristiques', 'site_menu'];

$schema = [];
foreach ($tables as $t) {
    try {
        $res = mysqli_query($connexion, "SHOW CREATE TABLE $t");
        if ($res) {
            $row = mysqli_fetch_row($res);
            $schema[$t] = $row[1];
        }
    } catch (Exception $e) {}
}

echo json_encode($schema, JSON_PRETTY_PRINT);
?>
