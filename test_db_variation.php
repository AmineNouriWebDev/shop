<?php
include('_admin_site/includes/include.php');
if(!$connexion) echo "No DB";

$id = 4136;
$q = mysqli_query($connexion, "SELECT * FROM produit_variations WHERE idproduit=$id");
while($r = mysqli_fetch_assoc($q)) {
    print_r($r);
}

// Show characteristics
$q2 = mysqli_query($connexion, "SELECT * FROM caracteristique_prod WHERE idproduit=$id");
while($r = mysqli_fetch_assoc($q2)) {
    print_r($r);
}
?>
