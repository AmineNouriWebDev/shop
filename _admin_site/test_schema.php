<?php
include('includes/include.php');
if(!$connexion) echo "No DB";

$q = mysqli_query($connexion, "DESCRIBE produit_variations");
while($r = mysqli_fetch_assoc($q)) {
    print_r($r);
}

// Show indexes
$q2 = mysqli_query($connexion, "SHOW INDEX FROM produit_variations");
while($r = mysqli_fetch_assoc($q2)) {
    print_r($r);
}
?>
