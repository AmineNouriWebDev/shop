<?php
include("../include.php");
$r=mysqli_query($connexion, 'SHOW TABLES');
while($row=mysqli_fetch_array($r)) echo $row[0]."\n";
