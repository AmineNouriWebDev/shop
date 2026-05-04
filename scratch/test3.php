<?php
include("../connec.php");

$query = "SELECT id, prix_vente, prix_promo, 
LEAST(
    IF(prix_promo > 0, prix_promo, prix_vente),
    IFNULL((SELECT MIN(IF(v.prix_promo > 0, v.prix_promo, v.prix_vente)) FROM produit_variations v WHERE v.idproduit = produits.id AND v.prix_vente > 0), 999999)
) as eff_price
FROM produits WHERE id = 4050";

$res = mysqli_query($connexion, $query);
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
    var_dump($row['eff_price']);
}
