<?php

	//session_start();
	include("include.php");
	
		
	$requete = "SELECT * FROM `site_menu` WHERE `id` = '14'";
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

	if(isset($_POST['action']) && $_POST['action']=="add" ){



		$nom=sanitize($_POST['nom']);
		
		$prenom=sanitize($_POST['prenom']);

		$email=sanitize($_POST['email']);

		$tel=sanitize($_POST['phone']);

		$password=sanitize($_POST['password']);

		$confirm_password=sanitize($_POST['confirm_password']);

		//exit;

		if($password!=$confirm_password){ // mot de passe non identiques erreur

			$erreur="Les mot de passe et sa confirmation ne sont pas identiques!";

		}else
		{ // mots de passes identiques c'est ok

			$req="SELECT * FROM `clients` where `email` ='".$email."'";    

			$res=executeRequete($req);

			$data1 = mysqli_fetch_array($res);

			if(isset($data1['id']) && $data1['id']!=""){ // compte existe avec l'adresse email 

			  $erreur="Un compte existe déjà avec cette adresse e-mail!";

			}

			else{ // inscription

			  $date_creation=time();

			  $confirm_key=random(40);

			  $req="INSERT INTO `clients`(`nom`,`prenom`,`email`,`tel`,`password`,`date_creation`,`etat`) VALUES('".$nom."','".$prenom."','".$email."','".$tel."','".$password."','".$date_creation."','1')";

      //echo $req; exit;

			  $connexion=ouvrirCnx() or die("erreur cnx");

			  $result  = mysqli_query($connexion, $req); 



			  // envoi email
            $email_contacts = explode(';',$email_contact);
            
		    foreach($email_contacts as $emc){
		        
			  $headers  = 'MIME-Version: 1.0' . "\r\n";

			  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			  $headers .= 'From: '.$nomSite.' <'.$emc.'>'. "\r\n";


			  $clientmail=$prenom." ".$nom;

			  $sujetmail=sujetEmail(4);

			  $linkconfirm=lienConfirminscription($confirm_key);

			  $messagemail=str_replace("%%NOMCLT%%",$clientmail,messageEmail(4));

			  //$messagemail=str_replace("%%LINKCONFIRM%%",$linkconfirm,$messagemail);
            
              if ($_SERVER['SERVER_NAME'] != 'localhost') {
			      @mail($email, $sujetmail, $messagemail, $headers, "-f ".$emc."");
              }
            

			  $sujetmailadmin=sujetEmail(7);

			  $detailsclt="Nom :".$prenom." ".$nom."<br />";

			  $detailsclt.="Tél :".$tel."<br />";

			  $detailsclt.="E-mail :".$email."<br />";

			  $messagemailadmin=str_replace("%%DETAILSCLT%%",$detailsclt,messageEmail(7));
		        
		        // Alerte client 
		    

              if ($_SERVER['SERVER_NAME'] != 'localhost') {
			      @mail($emc, $sujetmailadmin, $messagemailadmin, $headers, "-f ".$emc."");
              }

		    }



			  $new_id = mysqli_insert_id($connexion);
              $sess_id = md5(microtime());
              
              // Update sess_id in DB
              $strSQL1 = "UPDATE `clients` SET sess_id='".$sess_id."' WHERE id='".$new_id."'";
              executeRequete($strSQL1);

              // Set SESSION variables (Auto-login)
              $_SESSION['client_id'] = $new_id; 
              $_SESSION['client_login'] = $email;
              $_SESSION['client_nom'] = $nom;
              $_SESSION['sess_id'] = $sess_id;
              
              // Redirect
              ?>
                <script language="javascript">
                  window.location = '<?php echo lienCompte();?>';
                </script>
              <?php
              exit;


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
	$variable2='<li class="breadcrumb-item active" aria-current="page">'.titrePage(14).'</li>';
	include('includes/breadcrumb.php');
	
	?>
	
    <div class="container login-container mt-5 mb-5">
		<div class="row align-items-center" style="background: #29215a;">
        <div class="col-md-6 ads2">
		 
          <!--h1><span id="fl">Company</span><span id="sl">Name</span></h1-->
		  <span id="span">Si vous avez déjà un compte, connectez maintenant !</span>
		  <hr class="hr"/>
		  <a href="<?php echo lienConnexion();?>" class="btn btn-primary" id="btn">Connexion</a>
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

          <?php if(isset($success_msg) && $success_msg!="") { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $success_msg; ?> <br>
                <a href="<?php echo lienConnexion(); ?>" class="font-weight-bold">Cliquez ici pour vous connecter.</a>
            </div>
          <?php } ?>

          <h3>Informations client</h3>
          <form action="<?php echo lienInscription(); ?>" method="post" id="myform" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control" name="nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="E-mail" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="phone" placeholder="Téléphone" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="confirm_password" placeholder="Confirmer mot de passe" required>
            </div>
            <div class="form-group">
				<button type="submit" class="btn btn-primary btn-lg btn-block">S'inscrire</button>			  
				<input type="hidden" name="action" value="add">
            </div>
            <div class="form-group forget-password">
                <a href="<?php echo lienforget();?>">Mot de passe oublié !</a>
            </div>
          </form>
        </div>
      </div>
    </div>





      <!-- ======= Footer ======= -->
      <?php include('includes/footer.php');?>


 	 <?php include('includes/script-footer.php');?>

	
</body>

</html>