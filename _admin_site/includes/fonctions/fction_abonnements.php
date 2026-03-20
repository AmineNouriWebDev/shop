<?php
function titreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function prixAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['prix']);
}
function caracteristiqueAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['caracteristique']);
}
function categorieAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}
function linkAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}
function ancreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function lienAncreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien_ancre']);
}

function ordreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}

function supprimerAbonnements($id){
    $requete = 'SELECT * FROM `abonnements` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    executeRequete("DELETE FROM `abonnements` WHERE `id` = '".$id."'");
    return true;
}

function vodAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_vod']);
}
function chaineHdAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_chaine_hd']);
}
function delaiAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['delai']);
}


?>