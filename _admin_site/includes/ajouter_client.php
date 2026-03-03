<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
        $prenom              = formReception($_POST['prenom']);
        $nom                 = formReception($_POST['nom']);
        $email               = formReception($_POST['email']);
        $tel                 = formReception($_POST['tel']);
        $adresse             = formReception($_POST['adresse']);
        $ville               = formReception($_POST['ville']);
        $password            = formReception($_POST['password']);
        $etat                = formReception($_POST['etat']);
        $date                = time();

	    $confirm_key         = random(40);

    $sql  = 'SELECT count(*) FROM `clients` WHERE 1=2';
         if($email !="") $sql .=' OR email="'.$email.'"'; 
         if($tel !="") $sql .=' OR tel="'.$tel.'"'; 
        $res  = executeRequete($sql);
        $data = mysqli_fetch_array($res);
        //echo $sql; echo $data[0]; exit;
        if ($data[0] == 0) { 
             
        $requete = "INSERT INTO `clients` 
        (`nom`, `prenom`, `tel`, `email`, `adresse`, `ville`, `password`,`mpc`, `etat`, `confirm_key`, `date_creation`)
        VALUES
        ('". $nom ."', '". $prenom ."','". $tel ."','". $email ."', '". $adresse ."', '". $ville ."','". $password ."','".md5($password)."','". $etat ."','". $confirm_key ."','".$date."')";
        //echo $requete; exit();
        $result  = executeRequete($requete);  
  
  $msg="Client ajouté avec succès.";
    ?>
  <script language="javascript">
  <!--
    alert('<?php echo $msg;?>');
    window.location = 'index.php?r=clients';
  -->
  </script>
  <?php
        } else {
        ?>
         <script language="javascript">
          <!--
            alert('Un autre utilisateur posséde déja cet E-mail ou bien ce num téléphone');
            window.location = 'index.php?r=mclient';
          -->
         </script>
        <?php }  ?>
  <?php
      
  exit;
  
  //echo $strSQL;
  
}
?>
                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter client</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                  <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Nom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="nom" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                     <div class="form-group">
                                        <h5>Prénom<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="prenom" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                     </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <h5>E-mail</h5>
                                        <div class="controls">
                                            <input type="text" name="email" value="" class="form-control"> </div>
                                    </div>
                                  </div>
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <h5>Téléphone</h5>
                                        <div class="controls">
                                            <input type="text" name="tel" value="" class="form-control"> </div>
                                    </div>
                                  </div>
                                    </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>Adresse</h5>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="" class="form-control"> </div>
                                    </div>
                                  </div>
                                  </div>
                                   <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Ville</h5>
                                        <div class="controls">
                                            <input type="text" name="ville" value="" class="form-control"> 
                                        </div>
                                       </div>
                                     </div>
                                      <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Mot de passe</h5>

                                        <div class="controls d-inline-flex align-items-center w-100">

                                            <input type="password" name="password" id="pass" value="" class="form-control"> <button type="button" class="btn btn-default border border-info ml-2" onclick="changer()"><i class="fa fa-eye-slash" id="eye"></i></button>

                                        </div>
                                       </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-2">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" class="form-control">
                                                <option value="1">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>  
                                                                                                                                             
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=clients'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajt">
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                

                <script>

                    e=true;

                    function changer(){

                        if(e){

                            document.getElementById("pass").setAttribute("type","text");

                            document.getElementById("eye").className="fa fa-eye";

                            e=false;

                        }

                        else

                        {

                            

                            document.getElementById("pass").setAttribute("type","password");

                            document.getElementById("eye").className="fa fa-eye-slash";

                            e=true;

                        }

                    }

                    

                </script>