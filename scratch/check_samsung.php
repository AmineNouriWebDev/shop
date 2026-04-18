<?php
include("../include.php");
$q = mysqli_query($connexion, "SELECT id, titre, link, link_old FROM produits WHERE titre LIKE '%SAMSUNG Galaxy Tab A9%'");
while($r = mysqli_fetch_assoc($q)) {
    echo "ID: " . $r['id'] . " | Titre: " . $r['titre'] . " | Link: " . $r['link'] . " | Link_old: " . $r['link_old'] . "<br>";
}
?>
