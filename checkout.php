<?php

	session_start();
	include("include.php");
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '10'";
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
<?php 
if(isset($_SESSION['client_id'])) {
	
	$id_client = $_SESSION['client_id'];
	
	?>
<!DOCTYPE html>

<html lang="en">

<head>

	<?php include('includes/script-header.php');?>
    <?php include('includes/script_panier.php');?>
	
	<link rel="stylesheet" href="dist/scss/style.css" />

</head>

<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>
	
	<?php 
	$variable2='<li class="breadcrumb-item active" aria-current="page">'.titrePage(10).'</li>';
	include('includes/breadcrumb.php');
	
	?>
    <?php 
     
        include("includes/checkout.php");
    ?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>
<?php } else { ?>
    <script language="javascript">
	 <!--
	  window.location = '<?php echo lienConnexion(); ?>';
	 -->
	</script>
<?php } ?>