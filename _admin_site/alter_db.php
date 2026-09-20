<?php
include('../include.php');
executeRequete("ALTER TABLE produits MODIFY etat_stock enum('0','1','2') NOT NULL DEFAULT '1'");
executeRequete("ALTER TABLE abonnements MODIFY etat_stock enum('0','1','2') NOT NULL DEFAULT '1'");
executeRequete("ALTER TABLE equipements MODIFY etat_stock enum('0','1','2') NOT NULL DEFAULT '1'");
echo "Success";
?>
