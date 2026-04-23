<?php
/*-------------------------------- Marques -------------------------------------------*/

function raisonMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data) {
		return afficheChamp($data['raison']);
	}
	return '';
}

function raisonByLinkMarque($link)
{
	$requete = "SELECT * FROM `marques` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data) {
		return afficheChamp($data['raison']);
	}
	return '';
}

function linkMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}

function idraisonMarque($link)
{
	$requete = "SELECT * FROM `marques` WHERE `link` = '".$link."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}

function photoMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);

    if(isset($data['photo']) && $data['photo']!=""){
        return '<img src="../media/marques/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
    }
    else{
        return '<img src="../media/marques/indispo.jpg" border="0" width="60"  height="60" />';
    }
}

function photoMarqueSite($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
		return 'media/marques/'.afficheChamp($data['photo']);
	} else { return ''; }
}

function ApercuMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data) {
        return afficheChamp($data['photo']);
    }
    return '';
}

function OrdreMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}

function etatMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	    return '<img src="images/tick.gif" />';
	}
	else{
	    return '<img src="images/del.png" />';
	}
}

function StatutMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}

function supprimerMarque($id){
    $requete = 'SELECT * FROM `marques` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/marques/".nett($image));
    executeRequete("DELETE FROM `marques` WHERE `id` = '".$id."'");
    return true;
}

function supprimerImageMarque($id){
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/marques/".$image); 
    executeRequete("UPDATE `marques` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}
?>
