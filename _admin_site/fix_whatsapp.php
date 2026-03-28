<?php
session_start();
include('../connec.php');
include('includes/fonctions/fction_db.php');
$connexion = ouvrirCnx() or die("Erreur BD");
mysqli_query($connexion, "ALTER TABLE `clients` ADD `whatsapp` VARCHAR(50) NULL DEFAULT NULL AFTER `tel`");
mysqli_query($connexion, "ALTER TABLE `commandes` ADD `whatsapp` VARCHAR(50) NULL DEFAULT NULL AFTER `tel`");
echo "OKDB";
?>
