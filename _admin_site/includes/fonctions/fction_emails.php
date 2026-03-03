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
	$requete = "SELECT * FROM `templates_email` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['email_envoi']);
}


?>