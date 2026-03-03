<?php
// Test cart.php directly
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include.php");

$idr = isset($_GET['id_produit']) ? $_GET['id_produit'] : false;
$action  = isset($_GET['action']) ? $_GET['action'] : '';

echo "Product ID: " . $idr . "<br>";
echo "Action: " . $action . "<br>";
echo "Quantity: " . (isset($_GET['quantity']) ? $_GET['quantity'] : 'not set') . "<br>";

if($action == "add" && $idr) {
    echo "Attempting to add product...<br>";
    $qte_prd  = $_GET['quantity'];
    
    if($idr != 0){ 
        echo "Product ID is not 0<br>";
        
        if (creationPanier()) {
            echo "Cart created successfully<br>";
            echo "Session cart: ";
            print_r($_SESSION['panier']);
        } else {
            echo "Failed to create cart<br>";
        }
    }
}
?>
