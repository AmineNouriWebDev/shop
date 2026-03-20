<?php
function supprimerBonReduction($id){
executeRequete("DELETE FROM `bon_reduction` WHERE `id` = '". $id ."'");
return true;
}

function dateDebutBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['date_debut']);
}

function dateFinBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['date_expire']);
}

function libelleBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['libelle']);
}

function codeBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['code']);
}

function ValeurBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['valeur']);
}

function TypeBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['type']);
}
function fideliteBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['fidelite']);
}

function TotalBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['total']);
}

function NbreUtilisationBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['nbre_utilisation']);
}

function ClientBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['id_client']);
}

function GroupeBonReduction($id)
{
	$requete = 'SELECT * FROM `bon_reduction` WHERE `id` = "'. $id .'"';
	$res = executeRequete($requete);
	$data = mysqli_fetch_array($res);
	 return afficheChamp($data['group_id']);
}

function etatBonReduction($id)
{
	$requete = "SELECT * FROM `bon_reduction` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}

function StatutBonReduction($id)
{
	$requete = "SELECT * FROM `bon_reduction` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}
function NbreBonByGroupId($id)
{
	$requete = "SELECT * FROM `bon_reduction` WHERE `group_id` = '".$id."'";
	$resultat = executeRequete($requete);
	$num = mysqli_num_rows($resultat);
	return $num;
}
function doublonBonReduction($bon){
	$req = "SELECT * FROM `bon_reduction` WHERE `code`='".$bon."'";
	$res = executeRequete($req);
	$nb = mysqli_num_rows($res);
	if($nb!=0) return true;
	else return false;
}
?>