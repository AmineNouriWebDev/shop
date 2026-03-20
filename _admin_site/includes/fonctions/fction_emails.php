<?php
function sujetEmail($id)
{
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['sujet']);
}
function messageEmail($id)
{
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['message']);
}
function envoiEmail($id)
{
    global $email_contact;
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    $email = afficheChamp($data['email_envoi']);
    
    // Default system emails to replace dynamically
    $defaults = ['contact@technoplus.tn', 'info@technoplus.tn', 'no_reply@technoplus.tn', 'info@technoplus.io'];
    
    if(empty($email) || in_array(strtolower($email), $defaults)) {
        if(!empty($email_contact)) {
            return explode(';', $email_contact)[0];
        }
    }
	return $email;
}


?>