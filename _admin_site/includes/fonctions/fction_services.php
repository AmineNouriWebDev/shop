<?php
function supprimerService($id){
    $requete = 'SELECT * FROM `services` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$image 	= afficheChamp($data['image']);
	$photo 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/services/".nett($image));
	if($photo!="") unlink("../media/services/".nett($photo));
    executeRequete("DELETE FROM `services` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageService($id){
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/services/".$image);
    executeRequete("UPDATE `services` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}

function supprimerBackgroundService($id){
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/services/".$image);
    executeRequete("UPDATE `services` SET `image`='' WHERE `id` = '".$id."'");
    return true;
}

function titreService($id) 
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function titreEnService($id) 
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}

function contenuService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function contenuEnService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenuen']);
}

function photoBackgroundService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	 return '<img src="../media/services/'.afficheChamp($data['image']).'" border="0" width="60"  height="60" />';
	}
	else{
	 return '<img src="../media/services/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoBackgroundServiceSite($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'"; 
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/services/'.afficheChamp($data['image']);
	}else {
	return '';
	}
}

function ApercuBackgroundService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}
function photoService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	 return '<img src="../media/services/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	 return '<img src="../media/services/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoServiceSite($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'"; 
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/services/'.afficheChamp($data['photo']);
	}else {
	return '';
	}
}

function ApercuService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}
function ancreService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function ancreEnService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancreen']);
}
function lienService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien']);
}
function lienEnService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lienen']);
}


function ordreService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function etatService($id)
{
	$requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
?>