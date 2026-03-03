<?php
	session_start();
	include("include.php");

	if(isset($_GET['link']) && $_GET['link'] != '' ){
	$link=sanitize($_GET['link']);
	$type=sanitize($_GET['type']);

		$requete = "SELECT * FROM `equipements` WHERE `link` = '".$link."'";
		//echo $requete;
		$resultat = executeRequete($requete);
		$num_rows = mysqli_num_rows($resultat);
		$data = mysqli_fetch_array($resultat);
		if($num_rows <> 0){
			if($data['id']!=""){
				$id				  = afficheChamp($data['id']);
				$titre			  = afficheChamp($data['titre']);		        
				$PrixVente	      = afficheChamp($data['prix_vente']);		        
				$photo		      = afficheChamp($data['photo']);		        
				$caracteristique  = afficheChamp($data['caracteristique']);		        
				$etatStock		  = afficheChamp($data['etat_stock']);
				$contenu		  = afficheChamp($data['contenu']);
				$title_page		  = afficheChamp($data['titre_page']);
			}
		}else{
		
			$requete = "SELECT * FROM `abonnements` WHERE `link` = '".$link."'";
			//echo $requete;
			$resultat = executeRequete($requete);
			$data = mysqli_fetch_array($resultat);
			if($data['id']!=""){
				$id				  = afficheChamp($data['id']);
				$titre			  = afficheChamp($data['titre']);		        
				$PrixVente	      = afficheChamp($data['prix']);		        
				$photo		      = afficheChamp($data['photo']);		        
				$caracteristique  = afficheChamp($data['caracteristique']);		        
				$etatStock		  = afficheChamp($data['etat_stock']);
				$contenu		  = afficheChamp($data['contenu']);
				$title_page		  = afficheChamp($data['titre_page']);
			}
		}
	}else{
		
		
    	$requete = "SELECT * FROM `site_menu` WHERE `id` = '12'";
        //echo $requete;
        $resultat = executeRequete($requete);
        $data = mysqli_fetch_array($resultat);
        if($data['id']!=""){
            $id=afficheChamp($data['id']);
            $titre=afficheChamp($data['titre']);		        
            $contenu=afficheChamp($data['contenu']);
            $description_page=afficheChamp($data['description']);
            $title_page=afficheChamp($data['titre_page']);
            $keywords_page=afficheChamp($data['keywords']);
    
    
        }
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/script-header.php'); ?>
  <?php include('includes/script_panier.php'); ?>
  <style>*, *::before, *::after{box-sizing:border-box;} body{margin:0;font-family:'Inter',system-ui,sans-serif;background:var(--shop-bg-base);color:var(--shop-text-primary);}</style>
</head>
<body>
  <?php include('includes/feedback.php'); ?>
  <?php include('includes/header-tw.php'); ?>

    <?php 
		$titre = str_ireplace('Technoplus.tn', $nomSite ?? 'notre boutique', titrePage(12));
		$variable2='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
		include("includes/breadcrumb.php");     
        include("includes/cart_detail.php");
    ?>


  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>