<?php
include("connec.php");
$res = mysqli_query($connexion, "SHOW CREATE TABLE caracteristique_prod");
if ($res) {
    $row = mysqli_fetch_row($res);
    echo $row[1];
} else {
    echo mysqli_error($connexion);
}
?>
