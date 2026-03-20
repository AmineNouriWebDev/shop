<?php
include("include.php");
$req15 = "SELECT * FROM `produits` WHERE  `etat` ='1' ORDER BY id DESC";//dateajout DESC limit ".$limite.",".$nombre;
//echo $req1;

$res15 = executeRequete($req15);
$numres15 = mysqli_num_rows($res15);
$k=1;
echo "id;title;description;availability;condition;price;link;image_link;gtin;brand;sale_price;\n";
while ($data15 = mysqli_fetch_array($res15))
{
     $sale_price="";
     $id=afficheChamp($data15['id']);
     $title=html_entity_decode($data15['titre']);
     $link=lienProduits($data15['link']);
     $description="";
     //$description=str_replace(";",",",strip_tags(descritpionProduitParaharm($data15['idproduit_parapharm'])));
     //$description=str_replace("\n\n","",$description);
     //$description=str_replace("\n","",$description);
     if ($description=="") $description=$title;
     $availability="in stock";
     $condition="new";
     $price=substr($data15['prix_vente'],0,-1);
     $price=str_replace(",",".",$price);
     $price.=" TND";
     if($data15['prix_promo']!="" && $data15['prix_promo']!="0.000"){
     $sale_price=substr($data15['prix_promo'],0,-1);
     $sale_price=str_replace(",",".",$sale_price);
     $sale_price.=" TND";
     }
     $link="https://technoplus.tn/".$link;
     $image_link="https://technoplus.tn/".photoProduitsSite($id);
     $gtin=$id;
     $marque=raisonMarque(marquesProduits($id));
echo $id.";\"".$title."\";\"".$description."\";".$availability.";".$condition.";\"".$price."\";".$link.";".$image_link.";".$gtin.";".$marque.";".$sale_price.";\n";
}
?>