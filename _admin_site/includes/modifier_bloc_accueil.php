<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id			        = formReception($_POST['id']);
	$titre			    = formReception($_POST['titre']);
	$contenu			= formReception($_POST['contenu']);
	$ancre  			= formReception($_POST['ancre']);
	$lien    			= formReception($_POST['lien']);
	$affichage_titre 	= formReception($_POST['affichage_titre']);
	$affichage_accueil 	= formReception($_POST['affichage_accueil']);
	$num_col 	        = formReception($_POST['num_col']);
	$type_section       = formReception($_POST['type_section']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
		
	$requete = "UPDATE `bloc_accueil` SET `titre`='".$titre."',`type_section`='".$type_section."',`contenu`='".$contenu."',`num_col`='".$num_col."',`ancre`='".$ancre."',`lien`='".$lien."',`ordre`='".$ordre."',
	`affichage_titre`='".$affichage_titre."',`affichage_accueil`='".$affichage_accueil."',`etat`='".$etat."' WHERE `id`='".$id."'";
	$resultat = executeRequete($requete);
	
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ) {
	
			$destination = str_replace(' ', '-',  $id."-bloc-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `bloc_accueil` set `photo`="'. $photo .'" WHERE `id` ="'.$id.'"';
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
                                <h4 class="card-title">Bloc accueil</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreBloc($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"><?php echo contenuBloc($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuBloc($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoBlocSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
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
                                                        <input type="radio" value="1" name="affichage_titre" id="styled_radio1" class="custom-control-input" <?php if(affichageTitreBloc($_GET['id'])=="1") echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="affichage_titre" id="styled_radio2" class="custom-control-input" <?php if(affichageTitreBloc($_GET['id'])=="0") echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
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
                                                        <input type="radio" value="1" name="affichage_accueil" id="styled_radio1" class="custom-control-input" <?php if(affichageAccueilBloc($_GET['id'])=="1") echo "checked"; ?> > <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="affichage_accueil" id="styled_radio2" class="custom-control-input" <?php if(affichageAccueilBloc($_GET['id'])=="0") echo "checked"; ?> > <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
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
                                                <option value="12" <?php if(numColBloc($_GET['id'])=="12") echo "selected"; ?>>1</option>
                                                <option value="6" <?php if(numColBloc($_GET['id'])=="6") echo "selected"; ?>>2</option>
                                                <option value="4" <?php if(numColBloc($_GET['id'])=="4") echo "selected"; ?>>3</option>
                                                <option value="3" <?php if(numColBloc($_GET['id'])=="3") echo "selected"; ?>>4</option>
                                                <option value="5" <?php if(numColBloc($_GET['id'])=="5") echo "selected"; ?>>5</option>
                                                <option value="2" <?php if(numColBloc($_GET['id'])=="2") echo "selected"; ?>>6</option>
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
        	                                        <option value="<?php echo $data['id']; ?>" <?php if(typeSectionBloc($_GET['id'])==$data['id']) echo "selected"; ?>><?php echo afficheChamp($data['titre']); ?></option>
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
                                            <input type="text" name="ancre" value="<?php echo ancreBloc($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Lien</h5>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="<?php echo lienBloc($_GET['id']); ?>" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreBloc($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(etatBloc($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatBloc($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>