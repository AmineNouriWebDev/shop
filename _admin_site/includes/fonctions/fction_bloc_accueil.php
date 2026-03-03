<?php
function supprimerBloc($id){
    $requete = 'SELECT * FROM `bloc_accueil` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$image 	= afficheChamp($data['image']);
	$photo 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/site/".nett($image));
	if($photo!="") unlink("../media/site/".nett($photo));
    executeRequete("DELETE FROM `bloc_accueil` WHERE `id` = '".$id."'");
    return true;
}
function supprimerImageBloc($id){
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/site/".$image);
    executeRequete("UPDATE `bloc_accueil` SET `photo`='' WHERE `id` = '".$id."'");
    return true;
}

function supprimerBackgroundBloc($id){
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['image']);
	if($image!="") unlink("../media/site/".$image);
    executeRequete("UPDATE `bloc_accueil` SET `image`='' WHERE `id` = '".$id."'");
    return true;
}

function titreBloc($id) 
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function titreEnBloc($id) 
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titreen']);
}

function contenuBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenu']);
}
function contenuEnBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['contenuen']);
}
function affichageTitreBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['affichage_titre']);
}
function affichageAccueilBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return ($data && isset($data['affichage_accueil'])) ? afficheChamp($data['affichage_accueil']) : '';
}
function numColBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['num_col']);
}
function typeSectionBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['type_section']);
}

function photoBackgroundBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	 return '<img src="../media/site/'.afficheChamp($data['image']).'" border="0" width="60"  height="60" />';
	}
	else{
	 return '<img src="../media/site/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoBackgroundBlocSite($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'"; 
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/site/'.afficheChamp($data['image']);
	}else {
	return '';
	}
}

function ApercuBackgroundBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}
function photoBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	 return '<img src="../media/site/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	 return '<img src="../media/site/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoBlocSite($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'"; 
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/site/'.afficheChamp($data['photo']);
	}else {
	return '';
	}
}

function ApercuBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}
function ancreBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function ancreEnBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancreen']);
}
function lienBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien']);
}
function lienEnBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lienen']);
}


function ordreBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ordre']);
}
function etatBloc($id)
{
	$requete = "SELECT * FROM `bloc_accueil` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}

/*----------------------------  liste_sections ----------------------------------------*/

function supprimerListeSection($id){
    executeRequete("DELETE FROM `liste_sections` WHERE `id` = '".$id."'");
    return true;
}

function titreListeSection($id)
{
	$requete = "SELECT * FROM `liste_sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function etatListeSection($id)
{
	$requete = "SELECT * FROM `liste_sections` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat']);
}

/*--------------------------------- liste_section_content ---------------------------------------*/

function supprimerSectionContent($id){
    executeRequete("DELETE FROM `liste_section_content` WHERE `id` = '".$id."'");
    return true;
}

function photoSectionContent($id)
{
	$requete = "SELECT * FROM `liste_section_content` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/site/'.afficheChamp($data['photo']);
	}else {
	return '';
	}
}
function lienSectionContent($id)
{
	$requete = "SELECT * FROM `liste_section_content` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['lien']);
}

/*--------------------------------- liste_produits ---------------------------------------*/

function supprimerListeProduits($id){
    executeRequete("DELETE FROM `liste_produits` WHERE `id` = '".$id."'");
    return true;
}

function EnPromoListeProduits($id)
{
	$requete = "SELECT * FROM `liste_produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['en_promo']);
}
function categorieListeProduits($id)
{
	$requete = "SELECT * FROM `liste_produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}
function marqueListeProduits($id)
{
	$requete = "SELECT * FROM `liste_produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}


/*--------------------------------- Icones ---------------------------------------*/

function supprimerIcones($id){
    executeRequete("DELETE FROM `icones` WHERE `id` = '".$id."'");
    return true;
}

function photoIcones($id)
{
	$requete = "SELECT * FROM `icones` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/icones/'.afficheChamp($data['photo']);
	}else {
	return '';
	}
}
function titreIcones($id)
{
	$requete = "SELECT * FROM `icones` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}

?>