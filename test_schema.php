<?php
include("connec.php");
$res = mysqli_query($connexion, "DESCRIBE site_configuration");
$cols = [];
while($row = mysqli_fetch_assoc($res)) {
    $cols[] = $row;
}
header('Content-Type: application/json');
echo json_encode($cols, JSON_PRETTY_PRINT);
?>
