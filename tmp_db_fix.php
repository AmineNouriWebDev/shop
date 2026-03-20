<?php
include("connec.php");
$r = mysqli_query($connexion, "UPDATE site_menu SET auteur='34', datecreation='".time()."' WHERE datecreation='' OR datecreation IS NULL");
if($r) echo "Fixed ".mysqli_affected_rows($connexion)." rows.";
else echo "Failed: ".mysqli_error($connexion);
?>
