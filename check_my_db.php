<?php
include("connec.php");
$res = mysqli_query($connexion, "SHOW TABLES LIKE '%photo%'");
while($r=mysqli_fetch_array($res)) { echo "TABLE: ".$r[0]."\n"; }
$res = mysqli_query($connexion, "SHOW TABLES LIKE '%image%'");
while($r=mysqli_fetch_array($res)) { echo "TABLE: ".$r[0]."\n"; }
$res = mysqli_query($connexion, "SHOW COLUMNS FROM produits");
echo "\nCOLUMNS in produits:\n";
while($r=mysqli_fetch_assoc($res)) { echo $r['Field']." - ".$r['Type']."\n"; }
?>
