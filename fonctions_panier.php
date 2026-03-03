<?php
//session_start();
/**
 * Verifie si le panier existe, le créé sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['idcart'] = array();
      $_SESSION['panier']['name'] = array();
      $_SESSION['panier']['price'] = array();
      $_SESSION['panier']['total'] = array();
      $_SESSION['panier']['promo'] = array();
      $_SESSION['panier']['nbre_prd'] = array();
      $_SESSION['panier']['qte_prd'] = array();
      $_SESSION['panier']['frais'] = array();
      $_SESSION['panier']['typeCMD'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}


/**
 * Ajoute un article dans le panier
 * @param string $libelleProduit
 * @param int $qteProduit
 * @param float $prixProduit
 * @return void
 */
function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){

   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}



/**
 * Modifie la quantité d'un article
 * @param $libelleProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($libelleProduit,$qteProduit){
   //Si le panier éxiste
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else
      supprimerArticle($libelleProduit);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

function supprimerArticlePanier($idProduit){
   //Si le panier existe
   echo 'verr'.$_SESSION['panier']['verrou']; exit;
   if (creationPanier() && !isVerrouille())
   {
	   
      //Nous allons passer par un panier temporaire
      $temp=array();
      $temp['idProduit'] = array();
      $temp['qteProduit'] = array();
      $temp['prixProduit'] = array();
      $temp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
      { 
	  echo $i; 
         if ($_SESSION['panier']['idcart'][$i] !== $idProduit)
         {
			 $_SESSION['panier']['idcart'][$i]; exit;
            array_push( $temp['idProduit'],$_SESSION['panier']['idcart'][$i]);
            array_push( $temp['qteProduit'],$_SESSION['panier']['qte_prd'][$i]);
            array_push( $temp['prixProduit'],$_SESSION['panier']['price'][$i]);
         }

      }
      echo 'prd'.$idProduit; 
	  //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $temp;
	  //echo $_SESSION['panier']['idcart']['0'];
	//  echo $temp['idProduit']['0'];exit;
      //On efface notre panier temporaire
      unset($temp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
   {
	   $prix_commande1 = str_replace(',','.',$_SESSION['panier']['price'][$i]);
	   $prix_commande  = number_format($prix_commande1, 3, '.', '');	
      $total          += $_SESSION['panier']['qte_prd'][$i] * $prix_commande;
   }
   $prix_total = str_replace('.',',',$total);
   return $prix_total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['libelleProduit']);
   else
   return 0;

}

?>