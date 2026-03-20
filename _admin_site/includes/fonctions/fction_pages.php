<?php

function supprimerPages($id)
{
    $requete = 'SELECT * FROM `site_menu` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/pages/".nett($image));
    executeRequete("DELETE FROM `site_menu` WHERE `id` = '".$id."'");
    return true;
}

function idPage($link)
{
	$requete = "SELECT * FROM `site_menu` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}

function idPageEn($link)
{
	$requete = "SELECT * FROM `site_menu` WHERE `linken` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}

function titrePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
	//return $requete;
}
function stylePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['style']);
	//return $requete;
}
function intitulePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(afficheChamp($data['intitule_menu'])!="")
	return afficheChamp($data['intitule_menu']);
	else afficheChamp($data['titre']);
	//return $requete;
}

function titrePageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}
function contenuPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function contenuPageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenuen']);
}
function parentPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['idparent']);
}
function ordrePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function affichage_menuPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['affichage_menu']);
}
function affichage_footerPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['affichage_footer']);
}
function linkPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}
function linkPageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['linken']);
}
function link_externePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link_externe']);
}
function titre_pagePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre_page']);
}
function titre_pagePageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre_pageen']);
}
function keywordsPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
function keywordsPageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywordsen']);
}
function descriptionPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}
function descriptionPageEn($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['descriptionen']);
}
function targetPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['target']);
}
function etatPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function auteurPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['auteur']);
}
function imagePage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}
function imageContenuPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image_contenu']);
}
function photoPageSite($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return 'media/pages/'.afficheChamp($data['image']);
}
function photoContenuPageSite($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return 'media/pages/'.afficheChamp($data['image_contenu']);
}
function ApercuPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}
function ApercuContenuPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image_contenu']);
}
function datecreationPage($id)
{
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['datecreation']);
}
function supprimerImagePage($id){
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/pages/".$image); 
    executeRequete("UPDATE `site_menu` SET `image`='' WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageContenuPage($id){
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image_contenu']);
	if($image!="") unlink("../media/pages/".$image); 
    executeRequete("UPDATE `site_menu` SET `image_contenu`='' WHERE `id` = '".$id."'");
    return true;
}


/****** Section pages ***************/
function titreSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function titreEnSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}
function contenuSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function contenuEnSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenuen']);
}
function titre1Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre1']);
}
function titre1EnSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen1']);
}
function titre2Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre2']);
}
function titre2EnSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen2']);
}
function titre3Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre3']);
}
function titre3EnSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen3']);
}

function rate1Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['rate1']);
}

function rate2Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['rate2']);
}

function rate3Section($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['rate3']);
}

function OrdreSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function etatSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutSection($id)
{
	$requete = "SELECT * FROM `sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}


?>