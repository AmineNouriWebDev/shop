<?php
function titreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function caracteristiqueEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['caracteristique']);
}
function linkEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}

function categorieEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}
function ancreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function lienAncreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien_ancre']);
}
function ApercuEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function photoEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/equipements/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/equipements/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoEquipementsSite($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/equipements/'.afficheChamp($data['photo']);
	} else { return ''; }
}
function ordreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}
function etatEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}

function supprimerEquipements($id){
    $requete = 'SELECT * FROM `equipements` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/equipements/".nett($image));
    executeRequete("DELETE FROM `equipements` WHERE `id` = '".$id."'");
    return true;
}

function titre_pageEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre_page']);
}
function keywordsEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
function descriptionEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}


?>