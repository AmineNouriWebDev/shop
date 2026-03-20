<?php
function idSocialNetwork($link)
{
	$requete = "SELECT * FROM `social_network` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}
function titreSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function typeSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['type']);
}
function iconeSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['icone']);
}

function ordreSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function lienSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien']);
}
function etatSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function auteurSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['auteur']);
}
function photoSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	 return '<img src="../media/social_network/'.afficheChamp($data['image']).'" border="0" width="60"  height="60" />';
	}
	else{
	 return '<img src="../media/social_network/indispo.jpg" border="0" width="60"  height="60" />';
	}
}
function photoSocialNetworkSite($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/social_network/'.afficheChamp($data['image']);
	}else {
	return '';
	}
}
function ApercuSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}
function datecreationSocialNetwork($id)
{
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['datecreation']);
}
function supprimerSocialNetwork($id){
    $requete = 'SELECT * FROM `social_network` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/social_network/".nett($image));
    executeRequete("DELETE FROM `social_network` WHERE `id` = '".$id."'");
    return true;
}

function supprimerImageSocialNetwork($id){
	$requete = "SELECT * FROM `social_network` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/social_network/".$image); 
    executeRequete("UPDATE `social_network` SET `image`='' WHERE `id` = '".$id."'");
    return true;
}
?>