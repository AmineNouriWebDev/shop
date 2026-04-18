<?php
include("../include.php");
// Check the tablet specifically
$q = mysqli_query($connexion, "SELECT id, link, link_old FROM produits WHERE id=3964");
$r = mysqli_fetch_assoc($q);
echo "Final State for Tablet #3964:\n";
print_r($r);

// Check if any redirect exists for it
$q2 = mysqli_query($connexion, "SELECT * FROM produits_redirects WHERE id_produit=3964");
echo "\nRedirects found:\n";
while($r2 = mysqli_fetch_assoc($q2)) print_r($r2);
?>
