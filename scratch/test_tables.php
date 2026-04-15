<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../include.php");
// Check what tables exist for categories
$res = mysqli_query($connexion, "SHOW TABLES LIKE '%categ%'");
while($row = mysqli_fetch_array($res)) {
    echo "Table: " . $row[0] . "\n";
}
// check 'produits' fields
$res2 = mysqli_query($connexion, "SELECT id, titre, categorie, idparent_categ FROM produits LIMIT 5");
while($row2 = mysqli_fetch_assoc($res2)) {
    var_dump($row2);
}
// check 'categories_blog' fields vs 'categories_marques'
$res3 = mysqli_query($connexion, "SELECT * FROM categories_blog LIMIT 2");
while($row3 = mysqli_fetch_assoc($res3)) {
    var_dump($row3);
}
