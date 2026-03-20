<?php
include("includes/include.php");
include("includes/security.php");
include("includes/fonctions/fction_produits.php");

header('Content-Type: application/json');

$q = formReception($_GET['q'] ?? '');
$results = [];

if(strlen($q) >= 2) {
    $q_safe = mysqli_real_escape_string($connexion, $q);
    $req = "SELECT id, titre, type, link FROM produits WHERE (titre LIKE '%$q_safe%' OR id = '$q_safe') AND etat='1' ORDER BY titre ASC LIMIT 15";
    $res = executeRequete($req);
    while($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $results[] = [
            'id' => $id,
            'titre' => htmlspecialchars($row['titre']),
            'type' => $row['type'],
            'photo' => photoProduitsSite($id),
            'prix' => prixVenteProduits($id) . ' DT'
        ];
    }
}

echo json_encode($results);
exit;
?>

