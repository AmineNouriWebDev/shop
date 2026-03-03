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

<html lang="en">

<head>

	<?php include('includes/script-header.php');?>	
	<link rel="stylesheet" href="dist/scss/style.css" />
    <?php include('includes/script_panier.php');?>
	
</head>

<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>

    <?php 
		$variable2='<li class="breadcrumb-item active" aria-current="page">'.titrePage(12).'</li>';
		include("includes/breadcrumb.php");     
        include("includes/cart_detail.php");
    ?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>