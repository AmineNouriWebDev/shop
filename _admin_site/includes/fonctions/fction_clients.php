<?php
function supprimerClient($id){
    executeRequete("DELETE FROM `clients` WHERE `id` = '".$id."'");
    return true;
}

function nomClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['nom'])) {
		return afficheChamp($data['nom']);
	}
	return '';
}

function prenomClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['prenom'])) {
		return afficheChamp($data['prenom']);
	}
	return '';
}

function telClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['tel'])) {
		return afficheChamp($data['tel']);
	}
	return '';
}

function emailClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['email'])) {
		return afficheChamp($data['email']);
	}
	return '';
}

function adresseClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['adresse'])) {
		return afficheChamp($data['adresse']);
	}
	return '';
}

function villeClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['ville'])) {
		return afficheChamp($data['ville']);
	}
	return '';
}

function cpClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['code_postale'])) {
		return afficheChamp($data['code_postale']);
	}
	return '';
}

function commentaireClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['commentaire'])) {
		return afficheChamp($data['commentaire']);
	}
	return '';
}

function num_carte_fideliteClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['num_carte_fidelite'])) {
		return afficheChamp($data['num_carte_fidelite']);
	}
	return '';
}
function date_inscriptionClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['date_inscription'])) {
		return afficheChamp($data['date_inscription']);
	}
	return '';
}
function passwordClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['password'])) {
		return afficheChamp($data['password']);
	}
	return '';
}

function OrdreClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['ordre'])) {
		return afficheChamp($data['ordre']);
	}
	return '';
}

function etatClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutClient($id)
{
	$requete = "SELECT * FROM `clients` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['etat'])) {
		return afficheChamp($data['etat']);
	}
	return '';
}

function GenererPassword($longueur=8) { 
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    $Chaine = str_shuffle($Chaine);
    $Chaine = substr($Chaine,0,$longueur);
    return $Chaine;
}


/**** Enfants client ****/
function supprimerEnfant($id)
{
	executeRequete("DELETE FROM `enfants_client` WHERE `id` = '".$id."'");
    return true;
}

function prenomEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['prenom'])) {
		return afficheChamp($data['prenom']);
	}
	return '';
} 
function sexeEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['sexe'])) {
		return afficheChamp($data['sexe']);
	}
	return '';
}
function switch_sexeEnfant($sexe)
{
   switch ($sexe){
	case "1":
	return "Fille";
	break;
	case "2":
	return "Garçon";
	break;
	}
}
function date_naissanceEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['date_naissance'])) {
		return afficheChamp($data['date_naissance']);
	}
	return '';
}
function ordreEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['ordre'])) {
		return afficheChamp($data['ordre']);
	}
	return '';
}
function etatEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}
function StatutEnfant($id)
{
	$requete = "SELECT * FROM `enfants_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['etat'])) {
		return afficheChamp($data['etat']);
	}
	return '';
}

/**** Fidélité client ****/
function clientFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['id_client'])) {
		return afficheChamp($data['id_client']);
	}
	return '';
}
function bonReductionFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['id_bon_reduction'])) {
		return afficheChamp($data['id_bon_reduction']);
	}
	return '';
}
function date_generationFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['date_generation'])) {
		return afficheChamp($data['date_generation']);
	}
	return '';
}
function date_expirationFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['date_expiration'])) {
		return afficheChamp($data['date_expiration']);
	}
	return '';
}
function date_applicationFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['date_application'])) {
		return afficheChamp($data['date_application']);
	}
	return '';
}
function point_convertirFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['point_convertir'])) {
		return afficheChamp($data['point_convertir']);
	}
	return '';
}
function valeur_reductionFidelite($id)
{
	$requete = "SELECT * FROM `fidelite_client` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['valeur_reduction'])) {
		return afficheChamp($data['valeur_reduction']);
	}
	return '';
}


function derniereCommandeClient($id)
{
	$requete = "SELECT * FROM `commandes` WHERE `idclient` = '".$id."' ORDER BY id DESC";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if ($data && isset($data['code'])) {
		return afficheChamp($data['code']);
	}
	return '';
}

?>