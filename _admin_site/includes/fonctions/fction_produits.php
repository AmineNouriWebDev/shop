<?php
/*-------------------------------- Produits -------------------------------------------*/

function titreProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['titre']) ? afficheChamp1($data['titre']) : '';
}
function prixVenteProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['prix_vente']) ? afficheChamp($data['prix_vente']) : '';
}
function prixPromoProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['prix_promo']) ? afficheChamp($data['prix_promo']) : '';
}
function courtContenuProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['court_contenu']) ? afficheChamp($data['court_contenu']) : '';
}
function caracteristiqueProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['caracteristique']) ? afficheChamp($data['caracteristique']) : '';
}
function videoProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['video']) ? afficheChamp($data['video']) : '';
}
function quantiteProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['quantite']) ? afficheChamp($data['quantite']) : '';
}
function categorieProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['categorie']) ? afficheChamp($data['categorie']) : '';
}
function categorieBySearchProduits($search)
{
	$requete = "SELECT * FROM `produits` WHERE `titre` LIKE '%".$search."%' OR `link` LIKE '%".nett($search)."%'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}
function marquesProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['marque']) ? afficheChamp($data['marque']) : '';
}
function typeProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['type']) ? afficheChamp($data['type']) : '';
}
function MarqueProduits($categ)
{
	$requete = "SELECT * FROM `produits` WHERE `categorie` = '".$categ."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}
function etatStockProduits($id) 
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['etat_stock']) ? afficheChamp($data['etat_stock']) : '';
}
function afficheAccueilProduits($id) 
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['afficher_accueil']) ? afficheChamp($data['afficher_accueil']) : '';
}
function linkProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['link']) ? afficheChamp($data['link']) : '';
}
function ancreProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['ancre']) ? afficheChamp($data['ancre']) : '';
}

function vodProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_vod']);
}
function chaineHdProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_chaine_hd']);
}
function delaiProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['delai']);
}

function ApercuProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function photoProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/products/'.afficheChamp($data['photo']).'" border="0" width="60"  class="mr-2" />';
	}
	else{
	return '<img src="../media/products/image_non_dispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoProduitsSite($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/products/'.afficheChamp($data['photo']);
	} else { return 'media/products/image_non_dispo.jpg'; }
}

function ordreProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}
function auteurProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['auteur'];
}
function rqProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['remarque'];
}
function datecreationProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return timestampTDtodate($data['datecreation']);
}
function etatProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}

function supprimerProduits($id)
{
    $requete = 'SELECT * FROM `produits` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/products/".nett($image));
    executeRequete("DELETE FROM `produits` WHERE `id` = '".$id."'");
    return true;
}

function titrePageProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre_page']);
}
function keywordsProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
function descriptionProduits($id)
{
	$requete = "SELECT * FROM `produits` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}

function caracteristiques_prod($idcarac,$idproduit)
{
	$requete = "SELECT * FROM `caracteristique_prod` WHERE `idproduit` = '".$idproduit."' and `idcarac` = '".$idcarac."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['id']) && $data['id']!=""){
	return true;
	}
	else{
	return false;
	}
}
function caracteristiques_val_prod($idcarac,$idproduit,$valeur)
{
	$requete = "SELECT * FROM `caracteristique_prod` WHERE `idproduit` = '".$idproduit."' and `idcarac` = '".$idcarac."' and `valeur` = '".$valeur."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['id']) && $data['id']!=""){
	return true;
	}
	else{
	return false;
	}
}

/*-------------------------------- Abonnement -------------------------------------------*/

function titreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function prixVenteAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['prix_vente']);
}
function caracteristiqueAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['caracteristique']);
}
function quantiteAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['quantite']);
}
function categorieAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}
function marqueAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}
function MarqueAbonnement($categ)
{
	$requete = "SELECT * FROM `abonnements` WHERE `categorie` = '".$categ."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}
function etatStockAbonnements($id) 
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat_stock']);
}
function afficheAccueilAbonnements($id) 
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['afficher_accueil']);
}
function linkAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}
function ancreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}

function ordreAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}

function supprimerAbonnements($id){
    $requete = 'SELECT * FROM `abonnements` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    executeRequete("DELETE FROM `abonnements` WHERE `id` = '".$id."'");
    return true;
}

function vodAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_vod']);
}
function chaineHdAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['nbr_chaine_hd']);
}
function delaiAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['delai']);
}


function ApercuAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function photoAbonnements($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/products/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/products/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoAbonnementsSite($id)
{
	$requete = "SELECT * FROM `abonnements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/products/'.afficheChamp($data['photo']);
	} else { return 'media/products/image_non_dispo.jpg'; }
}

/*-------------------------------- Equipement -------------------------------------------*/
function titreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre']);
}
function caracteristiqueEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['caracteristique']);
}
function quantiteEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['quantite']);
}
function linkEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}
function PrixVenteEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['prix_vente']);
}
function etatStockEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['etat_stock']);
}

function categorieEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['categorie']);
}

function marqueEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}

function MarqueEquipement($categ)
{
	$requete = "SELECT * FROM `equipements` WHERE `categorie` = '".$categ."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['marque']);
}
function ancreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['ancre']);
}
function ApercuEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['photo']);
}

function photoEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return '<img src="../media/products/'.afficheChamp($data['photo']).'" border="0" width="60"  height="60" />';
	}
	else{
	return '<img src="../media/products/indispo.jpg" border="0" width="60"  height="60" />';
	}
}

function photoEquipementsSite($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['photo']) && $data['photo']!=""){
	return 'media/products/'.afficheChamp($data['photo']);
	} else { return 'media/products/image_non_dispo.jpg'; }
}
function ordreEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}
function etatEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['etat']) && $data['etat']=="1"){
	return '<img src="images/tick.gif" />';
	}
	else{
	return '<img src="images/del.png" />';
	}
}

function supprimerEquipements($id){
    $requete = 'SELECT * FROM `equipements` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	$image 	= afficheChamp($data['photo']);
	if($image!="") unlink("../media/products/".nett($image));
    executeRequete("DELETE FROM `equipements` WHERE `id` = '".$id."'");
    return true;
}

function titre_pageEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp1($data['titre_page']);
}
function keywordsEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['keywords']);
}
function descriptionEquipements($id)
{
	$requete = "SELECT * FROM `equipements` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['description']);
}



/*-------------------------------- Caracteristiques -------------------------------------------*/


function titreCaracteristiques($id)
{
	$requete = "SELECT * FROM `caracteristiques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['titre']);
}
function valeurCaracteristiques($id)
{
	$requete = "SELECT * FROM `valeur_caracteristique` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['valeur']);
}
function idvaleurCaracteristiques($id)
{
	$requete = "SELECT * FROM `valeur_caracteristique` WHERE `valeur` LIKE '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['id']);
}
function idcaracCaracteristiques($id)
{
	$requete = "SELECT * FROM `valeur_caracteristique` WHERE `valeur` LIKE '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['idcarac']);
}
function linkCaracteristiques($id)
{
	$requete = "SELECT * FROM `caracteristiques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
}

function ordreCaracteristiques($id)
{
	$requete = "SELECT * FROM `caracteristiques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['ordre'];
}
function statusCaracteristiques($id)
{
	$requete = "SELECT * FROM `caracteristiques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return $data['etat'];
}

function supprimerCaracteristiques($id){
    $requete = 'SELECT * FROM `caracteristiques` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
    executeRequete("DELETE FROM `caracteristiques` WHERE `id` = '".$id."'");
    return true;
}
/*-------------------------------- images produit -------------------------------------------*/


function supprimerimagessupplimentaires($id){
	$requete = 'SELECT * FROM `images_produit` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$image 	= $data['image'];
	if($image!="") unlink("../media/products/".nett($image));
	executeRequete("DELETE FROM `images_produit` WHERE `id` = '".$id."'");
    return true;
}

function imagesproduit($id)
{
	$requete = "SELECT * FROM `images_produit` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['image']);
}

function imagesproduitSite($id)
{
	$requete = "SELECT * FROM `images_produit` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['image']) && $data['image']!=""){
	return 'media/products/'.afficheChamp($data['image']);
	}else {
	return 'media/products/image_non_dispo.jpg';
	}
}

function imgproduit($id)
{
	$requete = "SELECT * FROM `images_produit` WHERE `id_produit` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return isset($data['image']) ? afficheChamp($data['image']) : '';
}

/*-------------------------------------------------------------------------*/


function countProduits($perPage){
	
	$per_page=$perPage;
	
	$requete  = "SELECT COUNT(id) AS NBP FROM `equipements` WHERE `etat` = 1 ";
	
	$res      = executeRequete($requete);	
	
	$data  	  = mysqli_fetch_array($res);
	
	$requete1 = "SELECT COUNT(id) AS NBP FROM `abonnements` WHERE `etat` = 1 ";
	
	$res1     = executeRequete($requete1);	
	
	$data1 	  = mysqli_fetch_array($res1);
	
	$nbTotalPage	= $data["NBP"] + $data1["NBP"];
	
	$nbPage= ceil($nbTotalPage / $per_page);
	
	return $nbPage;
}

function limitCount_1($count,$PerPage){
	
	$per_page=$PerPage;
	
	$nbPage= $count;
	
	$limit_starting = ($nbPage - 1 )* $per_page;
	
	return $limit_starting;
}
function limitCount_2($count,$PerPage){
	
	$per_page=$PerPage;
	
	$nbPage= $count;
	
	$limit_Ending = ($per_page )* $nbPage;
	
	return $limit_Ending;
}
/*--------------------------------- Marques -----------------------------------*/

function raisonMarque($id)
{
	$requete = "SELECT * FROM `marques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['raison']);
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
	return afficheChamp($data['photo']);
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


/*-------------------------------- Fiche technique produit -------------------------------------------*/

function supprimerFichesTechniques($id){
	$requete = 'SELECT * FROM `fichestechniques` WHERE `id` = "'.$id.'"';
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	
	$fiche 	= $data['fiche'];
	if($fiche!="") unlink("../media/fiches_techniques/".nett($fiche));
	executeRequete("DELETE FROM `fichestechniques` WHERE `id` = '".$id."'");
    return true;
}

function fichesTechniques($id)
{
	$requete = "SELECT * FROM `fichestechniques` WHERE `idproduit` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['fiche']);
}
function detailfichesTechniques($id)
{
	$requete = "SELECT * FROM `fichestechniques` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['detail']);
}
function detailfichesTechniquesSite($id)
{
	$requete = "SELECT * FROM `fichestechniques` WHERE `idproduit` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['detail']);
}

function fichesTechniquesSite($id)
{
	$requete = "SELECT * FROM `fichestechniques` WHERE `idproduit` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(isset($data['fiche']) && $data['fiche']!=""){
	return '../media/fiches_techniques/'.afficheChamp($data['fiche']);
	}else {
	return '';
	}
}

/*-------------------------------- Fiche technique produit -------------------------------------------*/

function supprimerfacilitePaiement($id){
	executeRequete("DELETE FROM `facilte_paiement` WHERE `id` = '".$id."'");
    return true;
}

function facilitePaiement($id)
{
	$requete = "SELECT * FROM `facilte_paiement` WHERE `idproduit` = '".$id."'";
	$resultat = executeRequete($requete);
	$numRows = mysqli_num_rows($resultat);
	return $numRows;
}
function detailfacilitePaiement($id)
{
	$requete = "SELECT * FROM `facilte_paiement` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['detail']);
}
function rqfacilitePaiement($id)
{
	$requete = "SELECT * FROM `facilte_paiement` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['remarque']);
}
function prixfacilitePaiement($id)
{
	$requete = "SELECT * FROM `facilte_paiement` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return afficheChamp($data['prix']);
}




?>