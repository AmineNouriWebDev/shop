<?php


/*---------------------------------------------------------------------------------*/
	session_start();
	include("include.php");
    require_once "User.class.php";

/*-----------------------------------------------------------------------------------------*/

    $requete = "SELECT * FROM `site_menu` WHERE `id` = '9'";
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


    }else{
        $url = current_url();
        $date = timestampTD(date("d/m/Y H:i:s"));
        executeRequete("INSERT INTO `pages_introuvables`(`url_page`, `date`) VALUES ('".$url."','".$date."')");
        ?>
	<script language="javascript">
	<!--
		window.location = '/error404.html';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
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
	
	


      <!-- ======= Footer ======= -->
    <?php include('includes/footer-tw.php');?>


 	<?php include('includes/script-footer.php');?>
	
</body>

</html>
<?php } else {
  header('Location: ' . lienConnexion()); exit;
} ?>