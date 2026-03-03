<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
  $moyen    = formReception($_POST['moyen']);
  $texte    = formReception($_POST['texte']);
  $url      = formReception($_POST['url']);
  $etat     = formReception($_POST['etat']);
    
  $requete = 'INSERT INTO `moyens_paiement` (`moyen`,`texte`,`url`, `etat`, `type`) VALUES ("'. $moyen .'", "'. $texte .'", "'. $url .'", "'. $etat .'", "1")';
  $result  = executeRequete($requete);  
  
  $msg="moyen de paiement ajouté avec succès.";
  
  ?>
  <script language="javascript">
  <!--
    alert('<?php echo $msg;?>');
    window.location = 'index.php?r=moyens_paiement';
  -->
  </script>
  <?php
      
  exit;
  
  //echo $strSQL;
  
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter moyen paiement</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Moyen de paiement <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="moyen" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                
                                    <div class="row">
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>Instructions</h5>
                                                <div class="controls">
                                                  <textarea id="textarea" name="texte" class="form-control" rows='5' ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>URL</h5>
                                        <div class="controls">
                                            <input type="text" name="url" value="" class="form-control"> </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="form-control">
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   

                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=moyens_paiement'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajt">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>