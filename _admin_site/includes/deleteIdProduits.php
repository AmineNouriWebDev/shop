<?php

include('../../include.php');
if(isset($_POST['ids'])){
    $idp = explode(',',$_POST['ids']);
    foreach($idp as $idpv){
        supprimerProduits($idpv);
    }
}

?>