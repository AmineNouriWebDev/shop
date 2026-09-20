<?php
require 'includes/database.php';
$id = 4055;
$q = executeRequete('SELECT stock_label_texte, stock_label_couleur, badges_droite_json FROM produits WHERE id='.$id);
$d = mysqli_fetch_assoc($q);
print_r($d);
?>
