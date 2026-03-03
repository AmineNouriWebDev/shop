<?php
ob_start(); // Buffer output to prevent "headers already sent" errors
session_start();
include("includes/include.php");
$erreur = false;
$msg = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
 //print_r($_POST);
      $login = formReception($_POST['editor_user']);
      $pass = md5(formReception($_POST['editor_pass']));
    //  echo $login;
	$strSQL  ='SELECT * FROM editor WHERE editor_user_name="'.$login.'" AND editor_pass="'.$pass.'" AND `editor_status`=1';
   // echo $strSQL;
	$result = executeRequete($strSQL);
	$erreur=false;
	//echo $strSQL; //exit;
    //echo mysqli_num_rows($result); exit;
		if (mysqli_num_rows($result)==0)
		{
		$erreur=true;
		$msg="Les accès saisies sont invalides. Merci de vérifier et réessayer!"; 
        //header("location: login.php"); //echo 'Pas erreur'; exit;
        //exit;

		}
			else
			{
				$row = mysqli_fetch_array($result);
			$erreur=false;
			$sess_id = md5(microtime());
			//setcookie('ses_id',$ses_id);
			//setcookie('groupe_id',$row['editor_group']);
			//@setcookie("ses_id",$ses_id);
			//@setcookie("",$row['editor_group']);
			//echo "ok"; exit;
			//$_SESSION['sess_id'] = $sess_id;
			$_SESSION['editor_id']=$row['editor_id'];
			$_SESSION['editor_login']=$row['editor_user_name'];
			$_SESSION['editor_group']=$row['editor_group'];
			$_SESSION['editor_name']=$row['editor_name'];
			$_SESSION['editor_surname']=$row['editor_surname'];
			$_SESSION['sess_id'] = $sess_id;
//			echo $row['editor_group'];
			$strSQL1 = "UPDATE `editor` SET ses_id='$sess_id' WHERE editor_id='$row[editor_id]' ";
				//echo $strSQL; exit;
			$result1 = mysqli_query($connexion,$strSQL1) or die($strSQL1.' '.mysqli_error($connexion));
			$entree = time();
			
            $ip_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
			$rq = 'INSERT INTO `editor_state` ( `editor_id`, `entree`, `sess_id`, `ip`) VALUES ( "'. $row['editor_id'] .'", "'. $entree .'", "'. $sess_id .'", "'. $ip_addr .'" ) ';
			$rs = mysqli_query($connexion,$rq); // Removed die() to prevent blocking
						

			 // Robust redirection
             if (!headers_sent()) {
                 header("location: index.php");
             } else {
                 echo '<script>window.location.href="index.php";</script>';
                 echo '<meta http-equiv="refresh" content="0;url=index.php">';
             }
			 exit();
			}
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin</title>
    <?php include("includes/scripts.php"); ?>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="" method="post">
                        <h3 class="box-title m-b-20">Connexion</h3>
                        <?php
                        if($erreur!="" && $msg!=""){
                            echo '<div class="alert alert-danger">'.$msg.'</div>';
                        }
                        ?>
                        <div class="form-group ">
                            <div class="col-xs-12"> 
                                <input class="form-control" type="text" name="editor_user" required placeholder="Nom utilisateur">                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="editor_pass" required placeholder="Mot de passe"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">Se souvenir de moi</label>
                                </div> <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><!-- <i class="fa fa-lock m-r-5"></i> --> Mot de passe oublié?</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">

                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Connexion</button>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center"> 
							<a href="<?php echo $chemin_absolu;?>"><i class="fa fa-arrow-left"> </i> Retour à <?php echo $nom_site;?></a>
                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" action="">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Récupérer votre mot de passe</h3>
                                <p class="text-muted">Veuillez saisir votre adresse email </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required placeholder="Email"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Récupérer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
     <?php include("includes/scripts_footer.php"); ?>
</body>

</html>