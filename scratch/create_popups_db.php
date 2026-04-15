<?php
include("../include.php");
$sql = "CREATE TABLE IF NOT EXISTS `site_popups` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(255) NOT NULL,
    `image_desktop` VARCHAR(255) DEFAULT NULL,
    `image_tablet` VARCHAR(255) DEFAULT NULL,
    `image_mobile` VARCHAR(255) DEFAULT NULL,
    `lien` VARCHAR(255) DEFAULT NULL,
    `bouton_texte` VARCHAR(100) DEFAULT NULL,
    `emplacement` ENUM('accueil', 'toutes') NOT NULL DEFAULT 'accueil',
    `etat` TINYINT(1) NOT NULL DEFAULT 1,
    `datecreation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if(mysqli_query($connexion, $sql)) {
    echo "Table site_popups créée avec succès.";
} else {
    echo "Erreur création table : " . mysqli_error($connexion);
}
