<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
  $moyen    = formReception($_POST['moyen']);
  $texte    = formReception($_POST['texte']);
  $etat     = formReception($_POST['etat']);
  
  $url = "";
  if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
      $nomImage = $_FILES['logo']['name'];
      $nomImage = rand(0, 10000) . '_' . date('dmyhis') . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $nomImage);
      $uploadDir = dirname(__DIR__, 2) . '/media/paiement/';
      if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0777, true); }
      $chemin = $uploadDir . $nomImage;
      move_uploaded_file($_FILES['logo']["tmp_name"], $chemin);
      $url = $nomImage;
  }
    
  $requete = 'INSERT INTO `moyens_paiement` (`moyen`,`texte`,`url`, `etat`, `type`) VALUES ("'. $moyen .'", "'. $texte .'", "'. $url .'", "'. $etat .'", "1")';
  $msg="moyen de paiement ajouté avec succès.";
  phpToastRedirect($msg, 'index.php?r=moyens_paiement', 'success');
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Ajouter moyen paiement
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <label>Moyen de paiement <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="moyen" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                
                                    <div class="row">
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Instructions</label>
                                                <div class="controls">
                                                  <textarea id="editor1" name="texte" class="admin-input" rows='5' ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Logo / Image du moyen <small>(remplace l'URL de l'image)</small></label>
                                        <div class="controls">
                                            <input type="file" name="logo" class="admin-input" accept="image/*"> 
                                        </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   

                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=moyens_paiement'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajt">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
