<?php
function titreSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function titreEnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}
function titre1Slider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre1']);
}
function titreEn1Slider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen1']);
}


function textBtnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['textBouton']);
}


function textBtnEnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['textBoutonen']);
}

function contenuSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function contenuEnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenuen']);
}

function photoSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/sliders/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/sliders/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoSliderSite($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/sliders/'.afficheChamp($data['photo']);
	} else { return ''; }
}

function photoMobileSliderSite($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo_mobile']) && $data['photo_mobile']!=""){
	return 'media/sliders/'.afficheChamp($data['photo_mobile']);
	} else { return ''; }
}

function photoTabletSliderSite($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo_tablet']) && $data['photo_tablet']!=""){
	return 'media/sliders/'.afficheChamp($data['photo_tablet']);
	} else { return ''; }
}

function ApercuMobileSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo_mobile']);
}

function ApercuTabletSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo_tablet']);
}

function ApercuSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function OrdreSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}

function etatSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function lienSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien']);
}
function lienEnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lienen']);
}
function ancreSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function ancreEnSlider($id)
{
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancreen']);
}
function supprimerSlider($id){
    $requete = 'SELECT * FROM `sliders` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/sliders/".nett($image));
	
	$image_m = afficheChamp($data['photo_mobile']);
	if($image_m!="") unlink("../media/sliders/".nett($image_m));
	
	$image_t = afficheChamp($data['photo_tablet']);
	if($image_t!="") unlink("../media/sliders/".nett($image_t));

    executeRequete("DELETE FROM `sliders` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageSlider($id){
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/sliders/".$image); 
    executeRequete("UPDATE `sliders` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageMobileSlider($id){
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo_mobile']);
	if($image!="") unlink("../media/sliders/".$image); 
    executeRequete("UPDATE `sliders` SET `photo_mobile`='' WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageTabletSlider($id){
	$requete = "SELECT * FROM `sliders` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo_tablet']);
	if($image!="") unlink("../media/sliders/".$image); 
    executeRequete("UPDATE `sliders` SET `photo_tablet`='' WHERE `id` = '".$id."'");
    return true;
}
?>