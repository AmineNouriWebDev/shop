<?php
session_start();
include("includes/include.php");
include("includes/security.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
    $ids = $_POST['ids'];
    $ordre = 1;

    foreach ($ids as $id) {
        $id = intval($id);
        if ($id > 0) {
            $requete = "UPDATE `bloc_accueil` SET `ordre` = '$ordre' WHERE `id` = '$id'";
            executeRequete($requete);
            $ordre++;
        }
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
}
?>
