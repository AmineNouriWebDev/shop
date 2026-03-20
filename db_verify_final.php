<?php
include("connec.php");
$res = mysqli_query($connexion, "SELECT tel, num_appel_vocale, whatsapp FROM site_configuration");
while ($r = mysqli_fetch_assoc($res)) {
    echo "tel: [" . $r['tel'] . "]<br>";
    echo "num_appel_vocale: [" . $r['num_appel_vocale'] . "]<br>";
    echo "whatsapp: [" . $r['whatsapp'] . "]<br>";
}
?>
