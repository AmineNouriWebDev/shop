<?php
include("include.php");
if(isset($_POST['action']) && $_POST['action']=="forget" ){
  //print_r($_POST);exit;
  if($_POST['login']=="" ){
    $erreur ="Le champs Adresse e-mail est obligatoire.";
  }else{
    $login=sanitize($_POST['login']);
    
    $req="SELECT * FROM `clients` where `email` ='".$login."'";
    //echo $req; exit;
    $res=executeRequete($req);
    $data1 = mysqli_fetch_array($res);
    if($data1['id']!=""){ // compte existe
    
        $email_contacts = explode(';',$email_contact);
    		    
    	foreach($email_contacts as $emc){
          //envoi mail de mot de passe oublié
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    		$headers .= 'From:'.$nomSite.' <info@technoplus.tn>' . "\r\n";
    
          $clientmail=$data1['prenom']." ".$data1['nom'];
          $pass=$data1['password'];
          $sujetmail=sujetEmail(5);
          $messagemail=str_replace("%%NOMCLT%%",$clientmail,messageEmail(5));
          $messagemail=str_replace("%%PASS%%",$pass,$messagemail);
          $messagemail=str_replace("%%LOGIN%%",$login,$messagemail);
    
          mail($data1['email'], $sujetmail, $messagemail, $headers, "-f ".$emc."");
    	}
      $msg="Votre mot de passe a été envoyé par e-mail.";
      ?>
  <script language="javascript">
  <!--
    alert('<?php echo $msg;?>');
    window.location = '<?php echo lienConnexion();?>';
  -->
  </script>
  <?php
      
      }else{ // compte n'existe pas 
      
      $erreur ="Il n'existe aucun compte avec cette adresse e-mail!";
      
      }
  }
}
$requete = "SELECT * FROM `site_menu` WHERE `id` = '15'";
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
<html lang="en">
<head>

	<?php include('includes/script-header.php');?>
	<link rel="stylesheet" href="dist/scss/style.css" />
	
</head>

<body>
	<?php include('includes/feedback.php');?>
	
	<?php include('includes/top-bar.php');?>
	
	<?php include('includes/banniere.php');?>

	
	<?php include('includes/mdp-oublie.php');?>


      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>
	
</body>

</html>