<?php

function nomApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nom']);
}



function fileApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['file']) && $data['file']!=""){
	return 'media/applications/'.afficheChamp($data['file']);
	} else { return ''; }
}

function apercuFileApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['file']);
}

function ImageApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/applications/'.afficheChamp($data['image']);
	} else { return ''; }
}

function ApercuImageApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}

function OrdreApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function etatApplications($id)
{
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function supprimerApplications($id){
    $requete = 'SELECT * FROM `applications` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	$file 	= afficheChamp($data['file']);
	if($image!="") unlink("../media/applications/".nett($image));
	if($file!="") unlink("../media/applications/".nett($file));
    executeRequete("DELETE FROM `applications` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageApplications($id){
	$requete = "SELECT * FROM `applications` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/applications/".$image); 
    executeRequete("UPDATE `applications` SET `image`='' WHERE `id` = '".$id."'");
    return true;
}
?>