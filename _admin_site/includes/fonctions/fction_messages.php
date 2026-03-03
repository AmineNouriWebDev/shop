<?php
function supprimerMessage($id){
    executeRequete("DELETE FROM `messages` WHERE `id` = '".$id."'");
    return true;
}
?>