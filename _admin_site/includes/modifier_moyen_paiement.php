<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php
 if(isset($_GET['id']) && $_GET['id']!=""){
$req = "SELECT * FROM `moyens_paiement` WHERE `id`='".$_GET['id']."'";
$res = executeRequete($req); 
$data = mysqli_fetch_array($res);
    $id      = $data['id'];
}
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{  
  $moyen        = formReception($_POST['moyen']);
  $frais       = formReception($_POST['frais']);
  $texte        = formReception($_POST['texte']);
  $id           = formReception($_POST['id']);
  $url          = formReception($_POST['url']);
  $etat         = formReception($_POST['etat']);
  
  
  $verif=executeRequete("UPDATE `moyens_paiement` set `moyen`='".$moyen."', `frais`='".$frais."',`url`='".$url."', `texte`='".$texte."', `etat`='".$etat."' WHERE `id`='".$id."'");
  
  $msg="moyen de paiement modifié avec succès.";
  
  ?>
  <script language="javascript">
  <!--
    alert('<?php echo $msg;?>');
    window.location = 'index.php?r=moyens_paiement';
  -->
  </script>
  <?php
  exit; 
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Modifier moyen paiement</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Moyen de paiement <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="moyen" value="<?php echo moyen_paiement($id); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Frais</h5>
                                        <div class="controls">
                                            <input type="text" name="frais" value="<?php echo frais_paiement($id); ?>" class="form-control"> </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                            <h5>Instructions</h5>
                                            <div class="controls">
                                              <textarea id="textarea" name="texte" class="form-control" rows='5' ><?php echo texte_paiement($id); ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>URL</h5>
                                        <div class="controls">
                                            <input type="text" name="url" value="<?php echo url_paiement($id); ?>" class="form-control"> </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="form-control">
                                                <option value="1" <?php if(etat_moyens_paiement($id)=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etat_moyens_paiement($id)=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   

                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=moyens_paiement'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>