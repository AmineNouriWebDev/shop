<?php
include("../connec.php");

$q = "SELECT id, titre, link, type, categorie, idparent_categ, etat, prix_vente FROM produits WHERE type = 'A'";
$res = mysqli_query($connexion, $q);
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}

// Let's also check category
$q2 = "SELECT id, titre, link, idparent, type FROM categories_blog WHERE titre LIKE '%iptv%' OR titre LIKE '%abonnement%'";
$res2 = mysqli_query($connexion, $q2);
while ($row = mysqli_fetch_assoc($res2)) {
    print_r($row);
}
