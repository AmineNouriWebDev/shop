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
	    return CHEMIN.afficheChamp($data['link'])."/";
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
    return CHEMIN."boutique/";
} 
function lienApplications(){
    return CHEMIN."applications.php";
    //return "applications/";
    
}
function lienCategories($link){
    return CHEMIN."boutique/".$link."/";
} 
function lienCategorieEquipements($link){
    return CHEMIN."boutique/".$link."/";
} 
function idCategorieProduits($id){
    $requete = 'SELECT * FROM `categories_blog` WHERE `id` = "'.$id.'"';
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
	return afficheChamp($data['link']);
} 
function lienProduits($link){
    return CHEMIN."produit/".$link."/";
}
function liencontact(){
    return CHEMIN."contact/";
} 
function lienInscription(){
    return CHEMIN."inscription/";
} 
function lienRegister(){
    return CHEMIN."register/";
} 
function lienConnexion(){
    return CHEMIN."connexion/";
} 
function lienforget(){
    return CHEMIN."mdp-oublie/";
}
function lienCompte(){
    return CHEMIN."compte/";
}
function lienDeconnexion(){
    return CHEMIN."deconnexion/";    
}

function lienDeatilCommandes($id){
    return CHEMIN."commande/".$id.'/';
}
function lienCommandeExpress(){
    return CHEMIN."commande-express.php";
}
function lienPanier(){
    return CHEMIN."panier/";
}
function lienCommande(){
    return CHEMIN."checkout/";
}
function lienCommandes($cmdId){
    return CHEMIN."checkout/".$cmdId.'/';
}
function lienPaiement($tx_id){
return "paiement.php?tx_id=".$tx_id;
}
function lienConfirm($cmd){
    return CHEMIN."confirm/".$cmd."/";
}
function lienRecherche(){
    return CHEMIN."recherche/";
}
function lienSearch($search){
    return CHEMIN."recherche/".$search.'/';
}
function lienRechercheByCM($marque,$categorie){
return CHEMIN."recherche.php?categorie=".$categorie."&marque=".$marque;
//return "recherche/".$categorie.'/'.$marque.'/';
}


function fixLien($url) {
    if (empty($url) || $url === '#') return '#';
    // Si c'est déjà une URL absolue ou un lien spécial, on ne touche à rien
    if (preg_match('/^(https?:\/\/|tel:|mailto:|javascript:)/', $url)) {
        return $url;
    }
    // On retire le slash au début s'il existe pour éviter les doubles slashes avec CHEMIN
    $url = ltrim($url, '/');
    return CHEMIN . $url;
}
