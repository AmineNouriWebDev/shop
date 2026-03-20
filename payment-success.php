<?php
include("include.php");
$requete = "SELECT * FROM `site_menu` WHERE `id` = '24'";
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

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include('includes/script-header.php');?>
	<link rel="stylesheet" href="dist/scss/style.css" />
	
</head>
<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>

    <?php 
	$variable2='<li class="breadcrumb-item active" aria-current="page">'.$titre.'</li>';
	include('includes/breadcrumb.php');  
        include("includes/paiement-reussi.php");
    ?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>