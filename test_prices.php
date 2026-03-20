<?php
include("connec.php");
$res = mysqli_query($connexion, "SELECT * FROM commandes WHERE id=6032");
$cmd = mysqli_fetch_assoc($res);
$res2 = mysqli_query($connexion, "SELECT * FROM ligne_commande WHERE idcommande=6032");
$lines = [];
while ($row = mysqli_fetch_assoc($res2)) {
    $lines[] = $row;
}
echo json_encode(['commande' => $cmd, 'lignes' => $lines], JSON_PRETTY_PRINT);
?>
echo json_encode($data, JSON_PRETTY_PRINT);
?>
