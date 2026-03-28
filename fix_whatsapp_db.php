<?php
include('connec.php');

$connexion = ouvrirCnx() or die("Erreur connexion BD");

$queries = [
    "ALTER TABLE `clients` ADD `whatsapp` VARCHAR(50) NULL DEFAULT NULL AFTER `tel`",
    "ALTER TABLE `commandes` ADD `whatsapp` VARCHAR(50) NULL DEFAULT NULL AFTER `tel`"
];

foreach ($queries as $q) {
    if (mysqli_query($connexion, $q)) {
        echo "Succès: $q<br>";
    } else {
        echo "Erreur ou déjà existant: $q<br>" . mysqli_error($connexion) . "<br>";
    }
}
echo "Terminé.";
?>
