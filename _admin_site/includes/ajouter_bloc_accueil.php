<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$titre			    = formReception($_POST['titre']);
	$contenu			= formReception($_POST['contenu']);
	$ancre  			= formReception($_POST['ancre']);
	$ancreen			= formReception($_POST['ancreen']);
	$lien    			= formReception($_POST['lien']);
	$icone              = formReception($_POST['icone'] ?? '');
	$affichage_titre 	= formReception($_POST['affichage_titre']);
	$affichage_accueil 	= formReception($_POST['affichage_accueil']);
	$num_col 	        = formReception($_POST['num_col']);
	$num_rows 	        = formReception($_POST['num_rows'] ?? 2);
	$type_section       = formReception($_POST['type_section']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
	$auteur             = auteur_id();
	
	$requete = 'INSERT INTO `bloc_accueil` 
	(`titre`,  `contenu`,  `ancre`, `lien`, `icone`, `affichage_titre`, `affichage_accueil`, `num_col`, `num_rows`, `type_section`, `ordre`, `etat`, `auteur`, `datecreation`) 
	VALUES
	("'. $titre .'", "'. $contenu .'","'. $ancre .'", "'. $lien .'", "'. $icone .'","'. $affichage_titre .'","'. $affichage_accueil .'", "'. $num_col .'", "'. $num_rows .'", "'. $type_section .'",   "'. $ordre .'",  "'. $etat .'","'. $auteur .'", "'. $datec .'")';
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
                <div class="admin-card">
                        <div class="admin-card-header">
                            <div class="admin-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                                </svg>
                                Ajouter bloc accueil
                            </div>
                        </div>
                        <div class="admin-card-body">
                          <form id="form_validation" method="POST" enctype="multipart/form-data">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
								         <div><img src="" style="max-width:150px" /></div>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Affichage titre:</label>
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
                                            <div class="admin-form-group">
                                                <label>Affichage accueil:</label>
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
                                            <div class="admin-form-group">
                                                <label>Nombre de produits par ligne</label>
                                                <div class="controls">
                                                    <select name="num_col" class="admin-input">
                                                        <option value="12">1 produit</option>
                                                        <option value="6">2 produits</option>
                                                        <option value="4" selected>3 produits</option>
                                                        <option value="3">4 produits</option>
                                                        <option value="5">5 produits</option>
                                                        <option value="2">6 produits</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Nombre de rangées</label>
                                                <div class="controls">
                                                    <select name="num_rows" class="admin-input">
                                                        <?php for($i=1; $i<=10; $i++) { ?>
                                                            <option value="<?php echo $i; ?>" <?php if($i==2) echo "selected"; ?>><?php echo $i; ?> rangée<?php echo ($i>1?'s':''); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Type section <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="type_section" required class="admin-input">
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
                                      <div class="admin-form-group">
                                        <label>Ancre</label>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Lien</label>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="" class="admin-input"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Icône ou classe FontAwesome (ex: fa-solid fa-truck)</label>
                                                <div class="controls">
                                                    <input type="text" name="icone" placeholder="fa-brands fa-whatsapp, fa-solid fa-shield..." class="admin-input">
                                                    <small class="form-text text-muted" style="margin-top:0.25rem;">
                                                        <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" style="color:var(--color-primary); text-decoration:underline;">
                                                            Chercher une icône FontAwesome gratuite
                                                        </a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('bloc_accueil',1); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="admin-form-group">
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
                             
                                <div class="col-sm-12">
                                    <button class="admin-btn admin-btn-primary" type="submit">Enregistrer</button>
                                    <button class="admin-btn admin-btn-primary" type="reset" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
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
