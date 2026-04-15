<?php
include("../include.php");
$r=mysqli_query($connexion, "SHOW COLUMNS FROM produits");
while($row=mysqli_fetch_assoc($r)) echo $row['Field']."\n";
