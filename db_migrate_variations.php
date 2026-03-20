<?php
include("connec.php");

$queries = [
    "CREATE TABLE IF NOT EXISTS `couleurs` (
      `id` int(20) NOT NULL AUTO_INCREMENT,
      `nom` varchar(255) NOT NULL,
      `code_hexa` varchar(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

    "CREATE TABLE IF NOT EXISTS `produit_couleurs` (
      `id` int(20) NOT NULL AUTO_INCREMENT,
      `idproduit` int(20) NOT NULL,
      `idcouleur` int(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

    "CREATE TABLE IF NOT EXISTS `produit_images_couleurs` (
      `id` int(20) NOT NULL AUTO_INCREMENT,
      `idproduit` int(20) NOT NULL,
      `idcouleur` int(20) DEFAULT NULL,
      `image_path` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",

    "ALTER TABLE `caracteristique_prod` ADD COLUMN `prix_vente` DECIMAL(10,3) DEFAULT NULL;",
    "ALTER TABLE `caracteristique_prod` ADD COLUMN `prix_promo` DECIMAL(10,3) DEFAULT NULL;"
];

foreach($queries as $q) {
    if(mysqli_query($connexion, $q)) {
        echo "Success: $q<br>";
    } else {
        echo "Error: " . mysqli_error($connexion) . " on query $q<br>";
    }
}

// Insert some default colors so the user has something to work with initially
$colors = [
    ['Noir', '#000000'],
    ['Blanc', '#ffffff'],
    ['Bleu', '#0000ff'],
    ['Rouge', '#ff0000'],
    ['Gris', '#808080'],
    ['Titane', '#878681'],
    ['Or', '#FFD700']
];

foreach ($colors as $c) {
    $nom = mysqli_real_escape_string($connexion, $c[0]);
    $hex = mysqli_real_escape_string($connexion, $c[1]);
    $check = mysqli_query($connexion, "SELECT id FROM couleurs WHERE nom='$nom'");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($connexion, "INSERT INTO couleurs (nom, code_hexa) VALUES ('$nom', '$hex')");
    }
}
echo "Default colors inserted.";
?>
