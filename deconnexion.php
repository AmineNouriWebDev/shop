<?php
session_start();
include("include.php");

// Unset specific shop session data
unset($_SESSION['client_id']); 
unset($_SESSION['client_login']); 
unset($_SESSION['client_nom']); 
unset($_SESSION['sess_id']); 
unset($_SESSION['userData']); 
 
// Destroy entire session data 
if(session_destroy()) {
    header("Location: ".lienConnexion());
}
?>