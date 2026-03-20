<?php
include("connec.php");
// Check for cycles or bad parent combos
$r = mysqli_query($connexion, "SELECT id, idparent, titre FROM site_menu WHERE idparent=id OR (idparent != 0 AND idparent NOT IN (SELECT id FROM site_menu))");
$data = [];
while($row = mysqli_fetch_assoc($r)) $data[] = $row;
echo json_encode(['data' => $data]);
?>
