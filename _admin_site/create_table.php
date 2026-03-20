<?php
include("includes/include.php");
$conn = ouvrirCnx();

$sql = "CREATE TABLE IF NOT EXISTS `produit_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `idproduit` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `ordre` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if (mysqli_query($conn, $sql)) {
    echo "Table produit_images created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>
