<?php
include("connec.php");

echo "All config rows:<br>";
$req = "SELECT id, tel, gsm, num_appel_vocale, whatsapp FROM site_configuration";
$res = mysqli_query($connexion, $req);
while ($row = mysqli_fetch_assoc($res)) {
    echo "<pre>"; print_r($row); echo "</pre>";
}

// Clean ALL rows
$req_update = "UPDATE site_configuration SET 
    tel = '' WHERE tel LIKE '%Warning%';";
mysqli_query($connexion, $req_update);

$req_update2 = "UPDATE site_configuration SET 
    num_appel_vocale = '' WHERE num_appel_vocale LIKE '%Warning%';";
mysqli_query($connexion, $req_update2);

$req_update3 = "UPDATE bloc_accueil SET 
    titre = '' WHERE titre LIKE '%Warning%' OR titre LIKE '%disponibles%';";
mysqli_query($connexion, $req_update3);

$req_update4 = "UPDATE site_configuration SET 
    whatsapp = '' WHERE whatsapp LIKE '%Warning%';";
mysqli_query($connexion, $req_update4);

echo "<br>After complete Cleanup:<br>";
$res2 = mysqli_query($connexion, $req);
while ($row = mysqli_fetch_assoc($res2)) {
    echo "<pre>"; print_r($row); echo "</pre>";
}
?>
