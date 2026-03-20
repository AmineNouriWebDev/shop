<?php
/************* moyen de paiement ***********/
function moyen_paiement($id)
{
    $requete = 'SELECT * FROM `moyens_paiement` WHERE `id` = "'. $id .'"';
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['moyen']);	
}
function texte_paiement($id)
{
    $requete = 'SELECT * FROM `moyens_paiement` WHERE `id` = "'. $id .'"';
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['texte']);	
}

function frais_paiement($id)
{
    $requete = 'SELECT * FROM `moyens_paiement` WHERE `id` = "'. $id .'"';
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['frais']);	
}
function url_paiement($id)
{
    $requete = 'SELECT * FROM `moyens_paiement` WHERE `id` = "'. $id .'"';
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['url']);	
}
function etat_moyens_paiement($id)
{
    $requete = 'SELECT * FROM `moyens_paiement` WHERE `id` = "'. $id .'"';
	$res     = executeRequete($requete);
	$data    = mysqli_fetch_array($res);
	return afficheChamp($data['etat']);	
}


function supprimermoyen_paiement($id)
{
	executeRequete("DELETE FROM `moyens_paiement` WHERE `id` = '". $id ."'");
    return true;
}
/*-------------------------------------------------------------------------------*/

function supprimerFraisLivraison($id)
{
	executeRequete("DELETE FROM `frais_livraison` WHERE `id` = '". $id ."'");
    return true;
}
function trancheFraisLivraison($id){
	$requete = "SELECT * FROM `frais_livraison` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if($data['min'] == '0.000' ) $chaine = "Moins de ".afficheChamp($data['max']).' DT';
	else if($data['max'] == '0.000' ) $chaine = "Plus de ".afficheChamp($data['min']).' DT';
	else $chaine = afficheChamp($data['min']).' DT  à '.afficheChamp($data['max']).' DT';
	return $chaine;
}
function valeurFraisLivraison($id){
	$requete = "SELECT * FROM `frais_livraison` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['frais']);
}
function minFraisLivraison($id){
	$requete = "SELECT * FROM `frais_livraison` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['min']);
}

function maxFraisLivraison($id){
	$requete = "SELECT * FROM `frais_livraison` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['max']);
}


?>