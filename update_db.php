<?php
require_once 'config.php';
$connexion = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connexion) die("Connection failed: " . mysqli_connect_error());

// Ajouter idproduit à liste_produits
$res1 = mysqli_query($connexion, "SHOW COLUMNS FROM liste_produits LIKE 'idproduit'");
if(mysqli_num_rows($res1) == 0) {
    if(mysqli_query($connexion, "ALTER TABLE liste_produits ADD idproduit INT(11) DEFAULT 0")) {
        echo "Added idproduit to liste_produits.\n";
    } else {
        echo "Error adding idproduit: " . mysqli_error($connexion) . "\n";
    }
} else {
    echo "idproduit already exists.\n";
}

// Ajouter badge_titre à bloc_accueil
$res2 = mysqli_query($connexion, "SHOW COLUMNS FROM bloc_accueil LIKE 'badge_titre'");
if(mysqli_num_rows($res2) == 0) {
    if(mysqli_query($connexion, "ALTER TABLE bloc_accueil ADD badge_titre VARCHAR(255) DEFAULT ''")) {
        echo "Added badge_titre to bloc_accueil.\n";
    } else {
        echo "Error adding badge_titre: " . mysqli_error($connexion) . "\n";
    }
} else {
    echo "badge_titre already exists.\n";
}
?>
