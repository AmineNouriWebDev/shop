<?php 

define('CHEMIN',$chemin_absolu);

function lienAccueil(){
return CHEMIN;
}
function lienContenu($id){
    $requete = "SELECT * FROM `site_menu` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	if(afficheChamp($data['link']) == 'accueil' || afficheChamp($data['link']) == 'home')
	    return CHEMIN;
	else
	    return CHEMIN."contenu.php?link=".afficheChamp($data['link']);
	    //return "".afficheChamp($data['link'])."/";
}
function lienMentionslegales(){
    //return "contenu.php?link=mentions-legales";
	return lienContenu(13);
} 
function lienServices($id){
    $requete = "SELECT * FROM `services` WHERE `id` = '".$id."'";
	$resultat = executeRequete($requete);
	$data = mysqli_fetch_array($resultat);
	return "service.php?link=".afficheChamp($data['lien']);
}


function lienCategorie(){
    return CHEMIN."categorie.php";
    //return "boutique/";
} 
function lienApplications(){
    return CHEMIN."applications.php";
    //return "applications/";
    
}
function lienCategories($link){
    return CHEMIN."categorie.php?link=".$link;
    //return "boutique/".$link."/";
} 
function lienCategorieEquipements($link){
    
    return CHEMIN."categorie.php?link=".$link;
    //return "boutique/".$link."/";
} 
function idCategorieProduits($id){
    $requete = 'SELECT * FROM `categories_blog` WHERE `id` = "'.$id.'"';
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
} 
function lienProduits($link){
    return CHEMIN."produit.php?link=".$link;
    //return "boutique/".$link."/";
}
function liencontact(){
    return CHEMIN."contact.php";
    //return "contact/";
} 
function lienInscription(){
    return CHEMIN."inscription.php";
    //return "inscription/";
} 
function lienRegister(){
return "register.php";
} 
function lienConnexion(){
    return CHEMIN."connexion.php";
    //return "connexion/";
} 
function lienforget(){
    return CHEMIN."mdp-oublie.php";
    //return "mdp-oublie/";
}
function lienCompte(){
    return CHEMIN."compte.php";
    //return "compte/";
}
function lienDeconnexion(){
    return CHEMIN."deconnexion.php";    
    //return "deconnexion/";
}

function lienDeatilCommandes($id){
return CHEMIN."detail_commande.php?cmdId=".$id;
//return "commande/".$id.'/';
}
function lienCommandeExpress(){
    return CHEMIN."commande-express.php";
}
function lienPanier(){
    return CHEMIN."cart.php"; 
    //return "panier/";
}
function lienCommande(){
    return CHEMIN."checkout.php";
  //return "checkout/";
}
function lienCommandes($cmdId){
    return CHEMIN."checkout.php?cmdId=".$cmdId;
  //return "checkout/".$cmdId.'/';
}
function lienPaiement($tx_id){
return "paiement.php?tx_id=".$tx_id;
}
function lienConfirm($cmd){
return CHEMIN."confirm.php?cmd=".$cmd;
//return "confirm/".$cmd."/";
}
function lienConfirmInscription($cle){
return "confirm_inscription.php?key=".$cle;
}
function lienRecherche(){
return CHEMIN."recherche.php";
//return "recherche/";
}
function lienSearch($search){
return CHEMIN."recherche.php?search=".$search;
//return "recherche/".$search.'/';
}
function lienRechercheByCM($marque,$categorie){
return CHEMIN."recherche.php?categorie=".$categorie."&marque=".$marque;
//return "recherche/".$categorie.'/'.$marque.'/';
}

