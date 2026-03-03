<?php
include("include.php");

// Initialize all variables to prevent undefined variable warnings
$titre = '';
$categorie_link = '';
$categorie_title = '';
$categorie_link2 = '';
$categorie_title2 = '';
$id = '';
$PrixVente = '';
$PrixPromo = '';
$photo = '';
$caracteristique = '';
$etatStock = '';
$contenu = '';
$title_page = '';
$id_categ = '';
$video = '';
$idp_categ = '';
$keywords_page = '';
$description_page = '';

if(isset($_GET['link']) && $_GET['link'] != '' ){
$link=sanitize($_GET['link']);
$type= isset($_GET['type']) ? sanitize($_GET['type']) : '';

	$requete = "SELECT * FROM `produits` WHERE `link` = '".$link."'";
    $resultat = executeRequete($requete);
    $num_rows = mysqli_num_rows($resultat);
    $data = mysqli_fetch_array($resultat);
	if($num_rows <> 0){
		if($data['id']!=""){
			$id				  = afficheChamp($data['id']);
			$titre			  = afficheChamp($data['titre']);		        
			$PrixVente	      = afficheChamp($data['prix_vente']);		        
			$PrixPromo	      = afficheChamp($data['prix_promo']);	        
			$photo		      = afficheChamp($data['photo']);		        
			if(empty($photo)) $photo = 'image_non_dispo.jpg';		        
			$caracteristique  = afficheChamp($data['caracteristique']);		        
			$etatStock		  = afficheChamp($data['etat_stock']);
			$contenu		  = isset($data['contenu']) ? afficheChamp($data['contenu']) : '';
			$title_page		  = afficheChamp($data['titre_page']);
			$id_categ		  = afficheChamp($data['categorie']);
			$video		      = isset($data['video']) ? afficheChamp($data['video']) : '';
			$idp_categ		  = afficheChamp($data['idparent_categ']);
				$req1 = "SELECT * FROM `categories_blog` WHERE `id` = '".$id_categ."'";
				$res1 = executeRequete($req1);				
				$data1 = mysqli_fetch_array($res1);
				$categorie_title = afficheChamp1($data1['titre']);
				$categorie_link = $data1['link'];
				$categorie_title2 = titreCategBlog(afficheChamp($data1['idparent']));
				$categorie_link2 = linkCategBlog(afficheChamp($data1['idparent']));
				$typeOg = "Product";
				$imgOg = 'media/products/'.$photo;
				$urlOg = lienAccueil().''.lienProduits($link);

				if($PrixPromo != '0.000') $price=$PrixPromo; else $price=$PrixVente;
				if ($etatStock == '1') $availability="in stock"; else $availability="out of stock";

            
            // Fix SEO Variables Initialization
            $titre_db = afficheChamp($data['titre_page']);
            $keywords_db = afficheChamp($data['keywords']);
            $desc_db = afficheChamp($data['description']);

            if($titre_db != '') { 
                $title_page = $titre_db; 
            } else { 
                $title_page = str_replace("%%PRODUIT%%",$titre,$title_prod); 
                $title_page = str_replace("%%CATEGORIE%%",$categorie_title,$title_page); 
            }
            
            if($keywords_db != '') { 
                $keywords_page = $keywords_db; 
            } else { 
                $keywords_page = str_replace("%%PRODUIT%%",$titre,$keywords_prod); 
                $keywords_page = str_replace("%%CATEGORIE%%",$categorie_title,$keywords_page); 
            }
            
            if($desc_db != '') { 
                $description_page = $desc_db; 
            } else { 
                $description_page = str_replace("%%PRODUIT%%",$titre,$description_prod); 
                $description_page = str_replace("%%CATEGORIE%%",$categorie_title,$description_page); 
            }
            
            // Convert Youtube Link to Embed
            if($video != "") {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $video, $match)) {
                    $video_id = $match[1];
                    $video = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                }
            }
		}
    }else{
        $url = current_url();
        $date = timestampTD(date("d/m/Y H:i:s"));
        executeRequete("INSERT INTO `pages_introuvables`(`url_page`, `date`) VALUES ('".$url."','".$date."')");
    header('Location: /error404.html'); exit;
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
	$variable2='<li class="breadcrumb-item " aria-current="page"><a href="'.lienCategorie().'">Catalogue</a></li>';
	$variable3='<li class="breadcrumb-item " aria-current="page"><a href="'.lienCategories($categorie_link2).'">'.$categorie_title2.'</a></li>';
	$variable4='<li class="breadcrumb-item " aria-current="page"><a href="'.lienCategorieEquipements($categorie_link).'">'.$categorie_title.'</a></li>';
	$variable5='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
	include('includes/breadcrumb.php'); 
	
	?>
    <?php 
     
        include("includes/detail_produit.php");
    ?>


  <?php include('includes/footer-tw.php'); ?>
  <?php include('includes/script-footer.php'); ?>
</body>
</html>