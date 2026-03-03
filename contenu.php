<?php
include("include.php");
if(isset($_GET['link']) && $_GET['link'] != '' ){
$link=sanitize($_GET['link']);
$type = isset($_GET['type']) ? sanitize($_GET['type']) : '';
$requete = "SELECT * FROM `site_menu` WHERE `link` = '".$link."'";
//echo $requete;
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if($data && isset($data['id']) && $data['id']!=""){
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
        include("includes/content.php");
    ?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>