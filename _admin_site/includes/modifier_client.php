<?php
 if(isset($_GET['id']) && $_GET['id']!=""){
$req = "SELECT * FROM `clients` WHERE `id`='".$_GET['id']."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
    $id            = afficheChamp($data['id']);
}
if (isset($_POST['action']) && $_POST['action'] == 'mod' ) {
        $prenom              = formReception($_POST['prenom']);
        $nom                 = formReception($_POST['nom']);
        $email               = formReception($_POST['email']);
        $tel                 = formReception($_POST['tel']);
        $adresse             = formReception($_POST['adresse']);
        $ville               = formReception($_POST['ville']);
        $password            = formReception($_POST['password']);
        $etat                = formReception($_POST['etat']);

        $sql  = 'SELECT count(*) FROM `clients` WHERE id != "'.$id.'" AND email="'.$email.'" AND tel="'.$tel.'"'; 
        //echo $sql; exit;
        $res  = executeRequete($sql);
        $data = mysqli_fetch_array($res);
        if ($data[0] == 0) {       
          $verif = executeRequete("UPDATE `clients` set `nom`='".$nom."', `prenom`='".$prenom."',`mpc`='".md5($password)."',`password`='".$password."', `tel`='".$tel."', `email`='".$email."', `adresse`='".$adresse."', `ville`='".$ville."', `etat`='".$etat."' WHERE `id`='".$id."'");
          $msg="Client modifié avec succès.";
  
  ?>
         <script language="javascript">
          <!--
            alert('Client modifié avec succès');
            window.location = 'index.php?r=clients';
          -->
         </script>
        <?php
        } else {
        ?>
         <script language="javascript">
          <!--
            alert('Un autre utilisateur posséde déja cet E-mail ou bien ce num téléphone');
            window.location = 'index.php?r=mclient&id=<?php echo $id; ?>';
          -->
         </script>
  <?php
  }
  exit;
  //echo $strSQL;
}
?>

                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Modifier client</h4>
                                  <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                  <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Nom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="nom" value="<?php echo nomClient($id); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                     <div class="form-group">
                                        <h5>Prénom<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="prenom" value="<?php echo prenomClient($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                     </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <h5>E-mail</h5>
                                        <div class="controls">
                                            <input type="text" name="email" value="<?php echo emailClient($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                  </div>
                                     <div class="col-md-6">
                                    <div class="form-group">
                                        <h5>Téléphone</h5>
                                        <div class="controls">
                                            <input type="text" name="tel" value="<?php echo telClient($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                  </div></div>
                                  <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <h5>Adresse</h5>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="<?php echo adresseClient($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                  </div>
                                   </div>
                                   <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Ville</h5>
                                        <div class="controls">
                                            <input type="text" name="ville" value="<?php echo villeClient($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                       </div>
                                     </div>
                                      <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Mot de passe</h5>

                                        <div class="controls d-inline-flex align-items-center w-100">

                                            <input type="password" name="password" id="pass" value="<?php echo passwordClient($_GET['id']); ?>" class="form-control"> <button type="button" class="btn btn-default border border-info ml-2" onclick="changer()"><i class="fa fa-eye-slash" id="eye"></i></button>

                                        </div>
                                       </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" class="form-control">
                                                <option value="1" <?php if(StatutClient($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatutClient($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   
                                                                                                                                             
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=clients'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                                
                            </div>
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