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
  $url          = formReception($_POST['url_existante']); // keeping the old if no new one
  $etat         = formReception($_POST['etat']);
  
  if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
      $nomImage = $_FILES['logo']['name'];
      $nomImage = rand(0, 10000) . '_' . date('dmyhis') . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $nomImage);
      $uploadDir = dirname(__DIR__, 2) . '/media/paiement/';
      if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0777, true); }
      $chemin = $uploadDir . $nomImage;
      move_uploaded_file($_FILES['logo']["tmp_name"], $chemin);
      $url = $nomImage; // overwrite with new image
  }
  
  $verif=executeRequete("UPDATE `moyens_paiement` set `moyen`='".$moyen."', `frais`='".$frais."',`url`='".$url."', `texte`='".$texte."', `etat`='".$etat."' WHERE `id`='".$id."'");
  
  $msg="moyen de paiement modifié avec succès.";
  phpToastRedirect($msg, 'index.php?r=moyens_paiement', 'success');
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
                                    Modifier moyen paiement
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <label>Moyen de paiement <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="moyen" value="<?php echo moyen_paiement($id); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Frais</label>
                                        <div class="controls">
                                            <input type="text" name="frais" value="<?php echo frais_paiement($id); ?>" class="admin-input"> </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                            <label>Instructions</label>
                                            <div class="controls">
                                              <textarea id="textarea" name="texte" class="admin-input" rows='5' ><?php echo texte_paiement($id); ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Logo / Image du moyen <small>(remplace l'URL de l'image)</small></label>
                                        <div class="controls">
                                            <?php $cur_url = url_paiement($id); if($cur_url != ""): ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo strpos($cur_url, 'http') === 0 ? $cur_url : '../media/paiement/'.$cur_url; ?>" style="max-height:50px; background:#f9fafb; padding:5px; border-radius:4px; border:1px solid #e5e7eb;">
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" name="logo" class="admin-input" accept="image/*"> 
                                            <input type="hidden" name="url_existante" value="<?php echo htmlspecialchars(url_paiement($id)); ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" <?php if(etat_moyens_paiement($id)=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etat_moyens_paiement($id)=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   

                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=moyens_paiement'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
