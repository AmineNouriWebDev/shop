<?php
include("../connec.php");

if (isset($_POST['status'])) {
    $status = $_POST['status'] == '1' ? '1' : '0';
    
    // Check if column exists, create if not
    $checkCol = mysqli_query($connexion, "SHOW COLUMNS FROM site_configuration LIKE 'afficher_abonnements'");
    if(mysqli_num_rows($checkCol) == 0) {
        mysqli_query($connexion, "ALTER TABLE site_configuration ADD COLUMN afficher_abonnements enum('0','1') NOT NULL DEFAULT '1'");
    }
    
    $query = "UPDATE site_configuration SET afficher_abonnements = '$status'";
    if (mysqli_query($connexion, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connexion)]);
    }
}
?>
