<?php
session_start();
include("includes/include.php");
// Check session without redirect (AJAX context)
if (!isset($_SESSION['sess_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non autorisé']);
    exit;
}

if(isset($_POST['ids']) && is_array($_POST['ids'])) {
    $ids = $_POST['ids'];
    $order = 1;
    
    foreach($ids as $id) {
        $id = intval($id);
        $req = "UPDATE conf_etapes SET ordre = $order WHERE id = $id";
        executeRequete($req);
        $order++;
    }
    
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
}
?>
