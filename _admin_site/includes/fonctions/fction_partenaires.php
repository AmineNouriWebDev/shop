<?php
function raisonPartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['raison']);
}
function photoPartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/partenaires/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/partenaires/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoPartenaireSite($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/partenaires/'.afficheChamp($data['photo']);
	} else { return ''; }
}

function ApercuPartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function OrdrePartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}

function etatPartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutPartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function typePartenaire($id)
{
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['type']);
}

function supprimerPartenaire($id){
    $requete = 'SELECT * FROM `partenaires` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/partenaires/".nett($image));
    executeRequete("DELETE FROM `partenaires` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImagePartenaire($id){
	$requete = "SELECT * FROM `partenaires` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/partenaires/".$image); 
    executeRequete("UPDATE `partenaires` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}

?>