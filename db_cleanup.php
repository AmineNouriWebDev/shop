<?php
include("connec.php");

echo "Before Cleanup:<br>";
$req = "SELECT tel, gsm, num_appel_vocale, whatsapp FROM site_configuration LIMIT 1";
$res = mysqli_query($connexion, $req);
if ($row = mysqli_fetch_assoc($res)) {
    echo "<pre>"; print_r($row); echo "</pre>";
}

// Clean up the fields
$req_update = "UPDATE site_configuration SET 
    tel = IF(tel LIKE '%Warning%', '', tel),
    gsm = IF(gsm LIKE '%Warning%', '', gsm),
    num_appel_vocale = IF(num_appel_vocale LIKE '%Warning%', '', num_appel_vocale),
    whatsapp = IF(whatsapp LIKE '%Warning%', '', whatsapp)";
mysqli_query($connexion, $req_update);

echo "<br>After Cleanup:<br>";
$res = mysqli_query($connexion, $req);
if ($row = mysqli_fetch_assoc($res)) {
    echo "<pre>"; print_r($row); echo "</pre>";
}
?>
