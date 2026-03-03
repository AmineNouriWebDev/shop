<?php
function titrePointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function photoPointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/points_forts/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/points_forts/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoPointFortSite($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<div class="icon"><i class="'.afficheChamp($data['photo']).'"></i></div>';
	} else { return ''; }
}

function ApercuPointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function OrdrePointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}

function etatPointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutPointFort($id)
{
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function supprimerPointFort($id){
    $requete = 'SELECT * FROM `points_forts` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/points_forts/".nett($image));
    executeRequete("DELETE FROM `points_forts` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImagePointFort($id){
	$requete = "SELECT * FROM `points_forts` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/points_forts/".$image); 
    executeRequete("UPDATE `points_forts` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}
?>