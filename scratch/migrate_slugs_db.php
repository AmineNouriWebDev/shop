<?php
include("../include.php");

// 1. Create a table for redirects to store all historical slugs
$sql1 = "CREATE TABLE IF NOT EXISTS `produits_redirects` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `id_produit` INT(11) NOT NULL,
    `old_link` VARCHAR(255) NOT NULL,
    `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX (`old_link`),
    INDEX (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if(mysqli_query($connexion, $sql1)) {
    echo "Table produits_redirects créée ou déjà existante.<br>";
} else {
    echo "Erreur SQL (Table) : " . mysqli_error($connexion) . "<br>";
}

// 2. Also add the column for a second layer of safety directly in products table
$sql2 = "ALTER TABLE `produits` ADD COLUMN `link_old` VARCHAR(255) DEFAULT NULL AFTER `link` ";
// We use @ to suppress error if column already exists
if(@mysqli_query($connexion, $sql2)) {
    echo "Colonne link_old ajoutée à la table produits.<br>";
} else {
    echo "Info : La colonne link_old existe peut-être déjà (ou erreur de structure).<br>";
}
?>
