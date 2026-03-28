<?php
include('../include.php');

header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(array('success' => false, 'message' => 'Paramètres manquants'));
    exit;
}

$id = intval($_POST['id']);
$status = intval($_POST['status']);

// Validate status
if ($status !== 0 && $status !== 1) {
    echo json_encode(array('success' => false, 'message' => 'Statut invalide'));
    exit;
}

// Update the database
$requete = "UPDATE `produits` SET `etat_stock` = '".$status."' WHERE `id` = '".$id."'";
$result = executeRequete($requete);

if ($result) {
    echo json_encode(array('success' => true, 'message' => 'Stock mis à jour'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Erreur lors de la mise à jour de la base de données'));
}
?>
