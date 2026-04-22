<?php
session_start();
include("../include.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recherche = isset($_POST['recherche']) ? formReception($_POST['recherche']) : '';
    $nom_produit = isset($_POST['nom_produit']) ? formReception($_POST['nom_produit']) : '';
    $telephone = isset($_POST['telephone']) ? formReception($_POST['telephone']) : '';

    if (!empty($nom_produit)) {
        $req = "INSERT INTO `demandes_produits` (`recherche`, `nom_client`, `telephone`, `traite`, `date_demande`) VALUES ('$recherche', '$nom_produit', '$telephone', '0', NOW())";
        $success = executeRequete($req);
        if($success) {
            echo "OK";
        } else {
            http_response_code(500);
            echo "Erreur lors de l'insertion en base de données";
        }
    } else {
        http_response_code(400);
        echo "Erreur";
    }
} else {
    http_response_code(405);
    echo "Methode non autorisée";
}
?>
