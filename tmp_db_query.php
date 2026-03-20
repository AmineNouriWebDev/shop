<?php
include("connec.php");
$r = mysqli_query($connexion, "SELECT id, titre, auteur, datecreation, ordre FROM site_menu ORDER BY id DESC LIMIT 5");
$data = [];
while($row = mysqli_fetch_assoc($r)) $data[] = $row;
echo json_encode(['data' => $data]);
?>
