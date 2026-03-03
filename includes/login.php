
<?php
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
    if($data1['id']!=""){ // compte pas encore validé renvoi de mail vérif ??
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
      if (count($_SESSION['panier']['libelleProduit']) <= 0) $redir=lienCompte();
      else $redir=lienPanier();
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
    <div class="container login-container mt-5 mb-5">
      <div class="row">
        <div class="col-md-6 ads1">
		 
          <!--h1><span id="fl">Company</span><span id="sl">Name</span></h1-->
		  <span id="span">Si vous n'êtes pas déjà client, inscrivez-vous maintenant.</span>
		  <hr class="hr"/>
		  <a href="<?php echo lienInscription();?>" class="btn btn-primary" id="btn">Créer un compte</a>
        </div>
        <div class="col-md-6 login-form">
          <div class="profile-img text-center">
            <img src="media/site/<?php echo $logo;?>" alt="profile_img" class="img-fluid">
          </div>
          <h3>Accés clients</h3>
          <form action="" method="post" id="myform" enctype="multipart/form-data">
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
          </form>
        </div>
      </div>
    </div>