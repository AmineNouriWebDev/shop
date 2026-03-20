<?php
$_SERVER['SERVER_NAME'] = 'localhost';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "connec.php";
include "_admin_site/includes/fonctions/fction_db.php";

$conn = ouvrirCnx();
$res = mysqli_query($conn, "SELECT id, type_section, titre FROM `bloc_accueil`");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['id'] . " - Type: " . $row['type_section'] . " - Title: " . $row['titre'] . "\n";
}

$res2 = mysqli_query($conn, "SELECT id, titre FROM `liste_sections`");
echo "\nSections:\n";
while($row = mysqli_fetch_assoc($res2)) {
    echo $row['id'] . " - " . $row['titre'] . "\n";
}

?>
