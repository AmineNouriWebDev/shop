<?php


/*---------------------------------------------------------------------------------*/
	session_start();
	include("include.php");
    require_once "User.class.php";

/*-----------------------------------------------------------------------------------------*/
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '13'";
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

	if(isset($_POST['action']) && $_POST['action']=="login" ){
		 // print_r($_POST);exit;
		if($_POST['login']=="" || $_POST['password']=="" ){
			$erreur ="Les champs Adresse e-mail et mot de passe sont obligatoires.";		
		}else{
			$login=sanitize($_POST['login']);
			$password=sanitize($_POST['password']);

			$req="SELECT * FROM `clients` where `email` ='".$login."' AND `password`='".$password."'";
		   // echo $req; exit;
			$res=executeRequete($req);
			$data1 = mysqli_fetch_array($res);
			if(isset($data1['id']) && $data1['id']!=""){ // compte pas encore validé renvoi de mail vérif ??
			  if($data1['etat']==0) $erreur ="Vous n'avez pas encore validé votre compte!<br /> Cliquez ici pour renvoyer le lien de vérification.";
			  else{
			  $sess_id = md5(microtime());
			  $idclient=$data1['id'];
			  $_SESSION['client_id']=$data1['id']; 
			  $_SESSION['client_login']=$data1['email'];
			  $_SESSION['client_nom']=$data1['nom'];
			  $_SESSION['sess_id'] = $sess_id;
			  $strSQL1 = "UPDATE `clients` SET sess_id='".$sess_id."' WHERE id='".$idclient."'";
			  $resSQL1=executeRequete($strSQL1);
			  if (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart']) && count($_SESSION['panier']['idcart']) > 0 ) $redir=lienPanier();  else $redir=lienCompte();
  ?>		
		<script language="javascript">
		  <!--
		  window.location = '<?php echo $redir;?>';
		  -->
		</script>
  <?php
				}
			}else{
			  // acces invalides 
			  $erreur="Vos accès sont invalides! Merci de réessayer.";
			}
		}
	}
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
	$variable2='<li class="breadcrumb-item active" aria-current="page">'.titrePage(13).'</li>';
	include('includes/breadcrumb.php');
	
	?>
    <div class="container login-container mt-5 mb-5">
		<div class="row align-items-center" style="background: #29215a;">
			<div class="col-md-6 ads1">
			 
			  <span id="span">Si vous n'êtes pas déjà client, inscrivez-vous maintenant.</span>
			  <hr class="hr"/>
			  <a href="<?php echo lienInscription();?>" class="btn btn-primary" id="btn">Créer un compte</a>
			</div>
			<div class="col-md-6 login-form">
			  <div class="profile-img text-center">
                <img src="media/site/<?php echo $logo;?>" alt="profile_img" class="img-fluid">
              </div>
              
              <?php if(isset($erreur) && $erreur!="") { ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $erreur; ?>
                </div>
              <?php } ?>

			  <h3>Accès clients</h3>
			  <form action="<?php echo lienConnexion();?>" method="post" id="myform" enctype="multipart/form-data">
				<div class="form-group">
				  <input type="email" class="form-control" name="login" placeholder="Email">
				</div>
				<div class="form-group">
				  <input type="password" class="form-control" name="password" placeholder="Mot de passe">
				</div>
				<div class="form-group">
				  <button type="submit" class="btn btn-primary btn-lg btn-block">Connexion</button>
				  <input type="hidden" name="action" value="login">
				</div>
				<div class="form-group forget-password">
					<a href="<?php echo lienforget();?>">Mot de passe oublié !</a>
				</div>
                <!-- Social login removed -->
			  </form>
			</div>
		</div>
    </div>

      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>

	
</body>

</html>