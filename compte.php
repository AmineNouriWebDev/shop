<?php


/*---------------------------------------------------------------------------------*/
	session_start();
	include("include.php");
    //require_once "config_google_facebook.php";
    require_once "User.class.php";

/*--------------------------------------- Google ------------------------------------------*/
/*
if(isset($_SESSION['token'])){ 
    $gClient->setAccessToken($_SESSION['token']); 
}
  
if($gClient->getAccessToken()){ 
    // Get user profile data from google 
    $gpUserProfile = $google_oauthV2->userinfo->get(); 
     
    // Initialize User class 
    $user = new User(); 
     
    // Getting user profile info 
	$sess_id = md5(microtime());
	$etat = 1;
	
    $gpUserData = array(); 
    $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:''; 
    $gpUserData['nom'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:''; 
    $gpUserData['prenom']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:''; 
    $gpUserData['email']       = !empty($gpUserProfile['email'])?$gpUserProfile['email']:''; 
    $gpUserData['sess_id']       = !empty($sess_id)?$sess_id:''; 
    $gpUserData['etat']       = !empty($etat)?$etat:''; 
     
    // Insert or update user data to the database 
    $gpUserData['oauth_provider'] = 'google'; 
    $userData = $user->checkUser($gpUserData); 
    
    // Storing user data in the session 
    $_SESSION['userData'] = $userData; 
    //print_r($_SESSION['userData']);
    //print_r($_SESSION['userData']['id']);
			  $_SESSION['client_id']=$_SESSION['userData']['id']; 
			  $_SESSION['client_login']=$_SESSION['userData']['email'];
			  $_SESSION['client_nom']=$_SESSION['userData']['nom'];
			  $_SESSION['sess_id'] = $sess_id;
    if($gClient->isAccessTokenExpired()){
      header('Location: /deconnexion.php');
      exit;
    }
}
*/

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
<?php if(isset($_SESSION['client_id']) || isset($_SESSION['userData'])) {?>
<!DOCTYPE html>

<html lang="en">

<head>

	<?php include('includes/script-header.php');?>
    <?php include('includes/script_panier.php');?>
	
	<link rel="stylesheet" href="dist/scss/style.css" />
	<!--script>

	$(document).ready(function() {

	   $("input[name='paiement']").click(function () {
			$('#payement_card').css('display', ($(this).attr('id') == 'card_bank') ? 'block':'none');
		});
	});
	</script-->
	
</head>

<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>
	
	
	<?php include('includes/compte.php');?>




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