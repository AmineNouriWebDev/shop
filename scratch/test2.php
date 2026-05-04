<?php
include("../connec.php");

$link = '90';
$min_p = '119.000';
$max_p = '119.000';

$eff_price_sql = "LEAST(
    IF(pr.prix_promo > 0, pr.prix_promo, pr.prix_vente),
    IFNULL((SELECT MIN(IF(v.prix_promo > 0, v.prix_promo, v.prix_vente)) FROM produit_variations v WHERE v.idproduit = pr.id AND v.prix_vente > 0), 999999)
)";

$query = "SELECT DISTINCT pr.id, pr.link, pr.categorie, pr.prix_vente, pr.type FROM produits pr WHERE pr.etat = '1'";
$query .= " AND (pr.categorie ='$link' OR pr.idparent_categ ='$link')";
$query .= " AND $eff_price_sql BETWEEN '$min_p' AND '$max_p'";
$query .= " GROUP BY pr.id";

echo $query."\n\n";

$res = mysqli_query($connexion, $query);
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
