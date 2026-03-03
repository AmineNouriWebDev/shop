<?php
	// Prevent any output before JSON
	ob_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 0); // Don't display errors in output
	
	include("../include.php");	
			

	/* On récupère l'identifiant de la région choisie. */
	
	$idr = isset($_GET['id_produit']) ? $_GET['id_produit'] : false;
	
	$action  = isset($_GET['action']) ? $_GET['action'] : '';
	/* Si on a une région, on procède à la requête */
	if(false !== $idr)
	{
		if($action == "add") {
			
			$qte_prd  =	$_GET['quantity'];
			if($idr!=0){ 

				if (creationPanier())
				
				{ 
				  //Si le produit existe déjà on ajoute seulement la quantité
				  $positionProduit = array_search($idr, $_SESSION['panier']['idcart']);
					if ($positionProduit !== false)
					{ 
						 $_SESSION['panier']['qte_prd'][$positionProduit] += $qte_prd ;
						 if($_SESSION['panier']['promo'][$positionProduit]) 
							 $_SESSION['panier']['total'][$positionProduit] = $_SESSION['panier']['promo'][$positionProduit]*$_SESSION['panier']['qte_prd'][$positionProduit]; 
							else $_SESSION['panier']['total'][$positionProduit] = $_SESSION['panier']['price'][$positionProduit]*$_SESSION['panier']['qte_prd'][$positionProduit];
					}
					else
					{
						  $datejour = timestamp(date("d/m/Y"));
						  $name     = titreProduits($idr);
						  
						  
						  if(prixPromoProduits($idr) !='0.000'){
						   $price  = prixPromoProduits($idr);
						   $promo  = prixPromoProduits($idr);
						  }
                            else{
						   $price  = PrixVenteProduits($idr);
						   $promo  = false;
                            }
						   //$promo  = prixpromoProduit(produitInventaire($idr),$datejour);
						   //echo 'pp'.$promo;
						   if($promo) $total_ligne = $promo*$qte_prd; else $total_ligne = $price*$qte_prd;
						 //Sinon on ajoute le produit
						 array_push( $_SESSION['panier']['idcart'],$idr);
						 array_push( $_SESSION['panier']['name'],$name);
						 array_push( $_SESSION['panier']['qte_prd'],$qte_prd);
						 array_push( $_SESSION['panier']['price'],$price);
						 array_push( $_SESSION['panier']['promo'],$promo);
						 array_push( $_SESSION['panier']['total'],$total_ligne);
					}
                    	$nbArticles=count($_SESSION['panier']['idcart']); 
				}
			}
		}elseif($action == "remove") {
			
			if (creationPanier())  {
				  //Nous allons passer par un panier temporaire
				  $panier_temporaire=array();
				  $panier_temporaire['idProduit'] = array();
				  $panier_temporaire['nameProduit'] = array();
				  $panier_temporaire['qteProduit'] = array();
				  $panier_temporaire['priceProduit'] = array();
				  $panier_temporaire['promoProduit'] = array();
				  $panier_temporaire['totalProduit'] = array();
				  
				  //echo count($_SESSION['panier']['idcart']); 
				  for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
				  { 
					 if ($_SESSION['panier']['idcart'][$i] !== $idr)
					 {
						if($_SESSION['panier']['promo'][$i]) $_SESSION['panier']['total'][$i] = $_SESSION['panier']['promo'][$i]*$_SESSION['panier']['qte_prd'][$i]; 
						else $_SESSION['panier']['total'][$i] = $_SESSION['panier']['price'][$i]*$_SESSION['panier']['qte_prd'][$i];
						array_push( $panier_temporaire['idProduit'],$_SESSION['panier']['idcart'][$i]);
						array_push( $panier_temporaire['nameProduit'],$_SESSION['panier']['name'][$i]);
						array_push( $panier_temporaire['qteProduit'],$_SESSION['panier']['qte_prd'][$i]);
						array_push( $panier_temporaire['priceProduit'],$_SESSION['panier']['price'][$i]);
						array_push( $panier_temporaire['promoProduit'],$_SESSION['panier']['promo'][$i]);
						array_push( $panier_temporaire['totalProduit'],$_SESSION['panier']['total'][$i]);
					 }
				  }
				   //echo count($panier_temporaire['idProduit']); exit; 
				  //On remplace le panier en session par notre panier temporaire à jour
				   $_SESSION['panier']['idcart']  = $panier_temporaire['idProduit'];
				   $_SESSION['panier']['name']    = $panier_temporaire['nameProduit'];
				   $_SESSION['panier']['qte_prd'] = $panier_temporaire['qteProduit'];
				   $_SESSION['panier']['price']   = $panier_temporaire['priceProduit'];
				   $_SESSION['panier']['promo']   = $panier_temporaire['promoProduit'];
				   $_SESSION['panier']['total']   = $panier_temporaire['totalProduit'];
				 if(count($_SESSION['panier']['idcart']) == 0) { 
				   unset($_SESSION['coupon']);
				   unset($_SESSION['payment']); 
				   unset($_SESSION['shipping']); 
				 }
                    	$nbArticles=count($_SESSION['panier']['idcart']); 
			}
		}elseif($action == "mod") {
			
			$qte = isset($_GET['quantity']) ? $_GET['quantity'] : false;
			
			if(false !== $idr) {
				
				if($idr!=0){
					
				 //Si le panier existe
					if (creationPanier()) {
						
					//Si la quantité est positive on modifie sinon on supprime l'article
						if ($qte > 0) {
							
						 //Recharche du produit dans le panier
						 $positionProduit = array_search($idr,  $_SESSION['panier']['idcart']);
						 
							if ($positionProduit !== false)
							{
								$_SESSION['panier']['qte_prd'][$positionProduit] = $qte ;
								if($_SESSION['panier']['promo'][$positionProduit]) 
								 $_SESSION['panier']['total'][$positionProduit] = $_SESSION['panier']['promo'][$positionProduit]*$_SESSION['panier']['qte_prd'][$positionProduit]; 
								else $_SESSION['panier']['total'][$positionProduit] = $_SESSION['panier']['price'][$positionProduit]*$_SESSION['panier']['qte_prd'][$positionProduit];
							}
						}
						else 
						{
						  //supprimerArticle($libelleProduit);
						  $panier_temporaire=array();
						  $panier_temporaire['idProduit'] = array();
						  $panier_temporaire['qteProduit'] = array();
						  $panier_temporaire['nameProduit'] = array();
						  $panier_temporaire['priceProduit'] = array();
						  $panier_temporaire['promoProduit'] = array();
						  $panier_temporaire['totalProduit'] = array();
						  
							  //echo count($_SESSION['panier']['idcart']); 
							for($i = 0; $i < count($_SESSION['panier']['idcart']); $i++)
							{ 
								 if ($_SESSION['panier']['idcart'][$i] !== $idr)
								 {
									if($_SESSION['panier']['promo'][$i]) $_SESSION['panier']['total'][$i] = $_SESSION['panier']['promo'][$i]*$_SESSION['panier']['qte_prd'][$i]; 
									else $_SESSION['panier']['total'][$i] = $_SESSION['panier']['price'][$i]*$_SESSION['panier']['qte_prd'][$i];
									array_push( $panier_temporaire['idProduit'],$_SESSION['panier']['idcart'][$i]);
									array_push( $panier_temporaire['nameProduit'],$_SESSION['panier']['name'][$i]);
									array_push( $panier_temporaire['qteProduit'],$_SESSION['panier']['qte_prd'][$i]);
									array_push( $panier_temporaire['priceProduit'],$_SESSION['panier']['price'][$i]);
									array_push( $panier_temporaire['promoProduit'],$_SESSION['panier']['promo'][$i]);
									array_push( $panier_temporaire['totalProduit'],$_SESSION['panier']['total'][$i]);
								 }
							}
							//  echo count($panier_temporaire['idProduit']); exit; 
							//On remplace le panier en session par notre panier temporaire à jour
						   $_SESSION['panier']['idcart'] = $panier_temporaire['idProduit'];
						   $_SESSION['panier']['name'] = $panier_temporaire['nameProduit'];
						   $_SESSION['panier']['qte_prd'] = $panier_temporaire['qteProduit'];
						   $_SESSION['panier']['price'] = $panier_temporaire['priceProduit'];
						   $_SESSION['panier']['promo'] = $panier_temporaire['promoProduit'];
						   $_SESSION['panier']['total'] = $panier_temporaire['totalProduit'];
						   
						   unset($panier_temporaire);
						}
					}
                    	$nbArticles=count($_SESSION['panier']['idcart']); 
				}
			}
		}
		
	}else if($action == "supp_coupon") { 
	
		unset($_SESSION['coupon']); 
		 
	}
	$panier_header ='';
	if ($nbArticles){ $nbre_article = $nbArticles; } else { $nbre_article="0"; }  
    if ($nbArticles) $panier_header .= $nbArticles; else $panier_header .= '0';
   
    $sous_total=0;
    $total=0;
    $total_ligne=0;
    $tva=0;
    for ($j=0 ;$j < $nbArticles ; $j++) { 
        $total_ligne = number_format($_SESSION['panier']['total'][$j], 3, '.', '');
        $sous_total = $sous_total + $total_ligne;  
        //$total_tva = $total_tva +$_SESSION['panier']['montanttva'][$j];
    }
        $total = $total + $sous_total;
   
	$ticket_panier ='<li><span>subtotal:</span> <span>'.number_format($sous_total, 3, ".", "").' DT</span></li>';
	$ticket_panier.='<li><span>total:</span> <span>'.number_format($total, 3, ".", "").' DT</span></li>';

    
     $panier = isset($panier) ? $panier : null;
     $erreur = isset($erreur) ? $erreur : false;
     
     $arr = array();
     $arr[0] = $panier_header;
     $arr[1] = $panier; 
     if($erreur) $arr[2] = $erreur; 
     $arr[3] = $ticket_panier; 
    
     // Clear any previous output (errors, warnings, etc.)
     ob_end_clean();
     
     // Set proper JSON headers
     header('Content-Type: application/json');
     
     echo json_encode($arr);
     exit;
