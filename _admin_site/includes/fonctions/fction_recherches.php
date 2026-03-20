<?php

function supprimerRecherche($id){
    executeRequete("DELETE FROM `recherches` WHERE `id` = '".$id."'");
    return true;
}
function ajoutRecherche($search){
    if($search != ''){
    $datec        = timestampTD(date("d/m/Y H:i:s"));
    executeRequete("INSERT INTO `recherches`(`ville/commune`, `date`) VALUES ('".$search."','".$datec."' )");
    }
    return true;
}

?>