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
          phpToastRedirect($msg, 'index.php?r=clients', 'success');
        } else {
          phpToastRedirect("Un autre utilisateur possède déjà cet E-mail ou bien ce numéro de téléphone", 'index.php?r=mclient&id='.$id, 'error');
        }
  exit;
  //echo $strSQL;
}
?>

                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Modifier client
                                </div>
                            </div>
                            <div class="admin-card-body">
                                  <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                  <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Nom <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="nom" value="<?php echo nomClient($id); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                     <div class="admin-form-group">
                                        <label>Prénom<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="prenom" value="<?php echo prenomClient($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                     </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                     <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label>E-mail</label>
                                        <div class="controls">
                                            <input type="text" name="email" value="<?php echo emailClient($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                  </div>
                                     <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label>Téléphone</label>
                                        <div class="controls">
                                            <input type="text" name="tel" value="<?php echo telClient($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                  </div></div>
                                  <div class="row">
                                    <div class="col-md-12">
                                    <div class="admin-form-group">
                                        <label>Adresse</label>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="<?php echo adresseClient($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                  </div>
                                   </div>
                                   <div class="row">
                                   <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Ville</label>
                                        <div class="controls">
                                            <input type="text" name="ville" value="<?php echo villeClient($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                       </div>
                                     </div>
                                      <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Mot de passe</label>

                                        <div class="relative w-full">
                                            <input type="password" name="password" id="pass" value="<?php echo passwordClient($_GET['id']); ?>" class="admin-input pr-10">
                                            <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary transition-colors" onclick="changer()">
                                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                </svg>
                                            </button>
                                        </div>
                                       </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" class="admin-input">
                                                <option value="1" <?php if(StatutClient($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatutClient($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   
                                                                                                                                             
                                    <div class="flex gap-3 mt-6">
                                        <button type="submit" class="admin-btn admin-btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Enregistrer
                                        </button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=clients'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                

                <script>
                    let e = true;
                    function changer() {
                        const passInput = document.getElementById("pass");
                        const eyeOpen = document.getElementById("eye-open");
                        const eyeClosed = document.getElementById("eye-closed");

                        if (e) {
                            passInput.setAttribute("type", "text");
                            eyeOpen.classList.remove("hidden");
                            eyeClosed.classList.add("hidden");
                            e = false;
                        } else {
                            passInput.setAttribute("type", "password");
                            eyeOpen.classList.add("hidden");
                            eyeClosed.classList.remove("hidden");
                            e = true;
                        }
                    }
                </script>
