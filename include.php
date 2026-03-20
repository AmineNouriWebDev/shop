<?php
// Start session
if (!session_id()) {
    session_start();
}

include("connec.php");
include("lien.php");
include("fonctions_panier.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_db.php");
include($chemin_admin . "includes/" . $chemin_functions . "/functions.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_social_network.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_pages.php");
// include($chemin_admin."includes/".$chemin_functions."/fction_activites.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_blogs.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_sliders.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_bloc_accueil.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_services.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_clients.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_commandes.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_moyens_paiement.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_recherches.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_emails.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_produits.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_partenaires.php");
include($chemin_admin . "includes/" . $chemin_functions . "/fction_applications.php");

function current_url()
{
    $current_url  = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on') ? 'https://' . $_SERVER["SERVER_NAME"] :  'http://' . $_SERVER["SERVER_NAME"];
    $current_url .= $_SERVER["REQUEST_URI"];

    return $current_url;
}
