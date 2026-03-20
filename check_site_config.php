<?php
include "connec.php";
$res = mysqli_query($connexion, "DESCRIBE site_configuration");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
?>
