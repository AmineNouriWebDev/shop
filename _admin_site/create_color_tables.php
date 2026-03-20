<?php
include("includes/include.php");
$conn = ouvrirCnx();

$q1 = "CREATE TABLE IF NOT EXISTS `produit_couleurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduit` int(11) NOT NULL,
  `idcouleur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$q2 = "CREATE TABLE IF NOT EXISTS `produit_images_couleurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduit` int(11) NOT NULL,
  `idcouleur` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if(mysqli_query($conn, $q1)) {
    echo "produit_couleurs created or exists.\n";
} else {
    echo "Error creating produit_couleurs: " . mysqli_error($conn) . "\n";
}

if(mysqli_query($conn, $q2)) {
    echo "produit_images_couleurs created or exists.\n";
} else {
    echo "Error creating produit_images_couleurs: " . mysqli_error($conn) . "\n";
}

?>
