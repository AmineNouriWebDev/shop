<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$titre			    = formReception($_POST['titre']);
	$contenu			= formReception($_POST['contenu']);
	$ancre  			= formReception($_POST['ancre']);
	$ancreen			= formReception($_POST['ancreen']);
	$lien    			= formReception($_POST['lien']);
	$affichage_titre 	= formReception($_POST['affichage_titre']);
	$affichage_accueil 	= formReception($_POST['affichage_accueil']);
	$num_col 	        = formReception($_POST['num_col']);
	$type_section       = formReception($_POST['type_section']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
	$auteur             = auteur_id();
	
	$requete = 'INSERT INTO `bloc_accueil` 
	(`titre`,  `contenu`,  `ancre`, `lien`,`affichage_titre`, `affichage_accueil`, `num_col`, `type_section`, `ordre`, `etat`, `auteur`, `datecreation`) 
	VALUES
	("'. $titre .'", "'. $contenu .'","'. $ancre .'", "'. $lien .'","'. $affichage_titre .'","'. $affichage_accueil .'", "'. $num_col .'", "'. $type_section .'",   "'. $ordre .'",  "'. $etat .'","'. $auteur .'", "'. $datec .'")';
	//echo $requete; exit;
	$result  = mysqli_query($connexion, $requete);	
	$idb     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ) {
			$destination = str_replace(' ', '-',  $idb."-bloc-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `bloc_accueil` set `image`="'. $photo .'" WHERE `id` ="'.$idb.'"';
			$result = executeRequete($requete);	
		}
	}

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=bloc_accueil';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
}
?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter bloc accueil</h4>
                          <form id="form_validation" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
								         <div><img src="" style="max-width:150px" /></div>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Affichage titre:</h5>
                                                <fieldset class="controls">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="1" name="affichage_titre" id="styled_radio1" class="custom-control-input" > <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="affichage_titre" id="styled_radio2" class="custom-control-input" checked> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Affichage accueil:</h5>
                                                <fieldset class="controls">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="1" name="affichage_accueil" id="styled_radio1" class="custom-control-input" > <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="affichage_accueil" id="styled_radio2" class="custom-control-input" checked> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Nombre des colonnes</h5>
                                        <div class="controls">
                                            <select name="num_col" class="form-control">
                                                <option value="12">1</option>
                                                <option value="6">2</option>
                                                <option value="4">3</option>
                                                <option value="3">4</option>
                                                <option value="5">5</option>
                                                <option value="2">6</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                     </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Type section <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="type_section" required class="form-control">
                                                <option value="0" selected="selected">-- Selectionnez  --</option>
                                                 <?php
            	                                 $req = 'SELECT * FROM `liste_sections` ORDER BY `id` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                        <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['titre']); ?></option>
        	                                      <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Lien</h5>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('bloc_accueil',1); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
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
                             
                                <div class="col-sm-12">
                                    <button class="btn btn-primary waves-effect" type="submit">Enregistrer</button>
                                    <button class="btn btn-primary waves-effect" type="reset" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
							     	<input name="action" type="hidden" id="action" value="ajt">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
      $(document).ready(function(){
	   $("#leftsidebar .menu .list li#contenu").addClass('active');
      });
   </script>