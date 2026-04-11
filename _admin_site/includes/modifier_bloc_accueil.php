<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
// Migrations automatiques (s'exécutent si les colonnes manquent)
$res_mig1 = executeRequete("SHOW COLUMNS FROM liste_produits LIKE 'idproduit'");
if(mysqli_num_rows($res_mig1) == 0) executeRequete("ALTER TABLE liste_produits ADD idproduit INT(11) DEFAULT 0");

$res_mig2 = executeRequete("SHOW COLUMNS FROM bloc_accueil LIKE 'badge_titre'");
if(mysqli_num_rows($res_mig2) == 0) executeRequete("ALTER TABLE bloc_accueil ADD badge_titre VARCHAR(255) DEFAULT ''");

if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id			        = formReception($_POST['id']);
	$titre			    = formReception($_POST['titre']);
	$contenu			= formReception($_POST['contenu']);
	$ancre  			= formReception($_POST['ancre']);
	$lien    			= formReception($_POST['lien']);
	$icone              = formReception($_POST['icone'] ?? '');
	$badge_titre        = formReception($_POST['badge_titre'] ?? '');
	$affichage_titre 	= formReception($_POST['affichage_titre']);
	$affichage_accueil 	= formReception($_POST['affichage_accueil']);
	$num_col 	        = formReception($_POST['num_col']);
	$num_rows 	        = formReception($_POST['num_rows'] ?? 2);
	$type_section       = formReception($_POST['type_section']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
		
	$requete = "UPDATE `bloc_accueil` SET `titre`='".$titre."',`type_section`='".$type_section."',`contenu`='".$contenu."',`num_col`='".$num_col."', `num_rows`='".$num_rows."', `ancre`='".$ancre."',`lien`='".$lien."', `icone`='".$icone."', `badge_titre`='".$badge_titre."', `ordre`='".$ordre."',
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
                        <div class="admin-card">
                        <div class="admin-card-header">
                            <div class="admin-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                                </svg>
                                Modifier bloc accueil
                            </div>
                        </div>
                        <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreBloc($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="admin-input" rows="5"><?php echo contenuBloc($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <?php if(ApercuBloc($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoBlocSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
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
                                            <div class="admin-form-group">
                                                <label>Affichage accueil:</label>
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
                                    <div id="product-settings-container" <?php if(typeSectionBloc($_GET['id']) != '4' && typeSectionBloc($_GET['id']) != '6') echo 'style="display:none;"'; ?>>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="admin-form-group">
                                                    <label>Nombre d'éléments par ligne</label>
                                                    <div class="controls">
                                                        <select name="num_col" class="admin-input">
                                                            <option value="12" <?php if(numColBloc($_GET['id'])=="12") echo "selected"; ?>>1 produit</option>
                                                            <option value="6" <?php if(numColBloc($_GET['id'])=="6") echo "selected"; ?>>2 produits</option>
                                                            <option value="4" <?php if(numColBloc($_GET['id'])=="4") echo "selected"; ?>>3 produits</option>
                                                            <option value="3" <?php if(numColBloc($_GET['id'])=="3") echo "selected"; ?>>4 produits</option>
                                                            <option value="5" <?php if(numColBloc($_GET['id'])=="5") echo "selected"; ?>>5 produits</option>
                                                            <option value="2" <?php if(numColBloc($_GET['id'])=="2") echo "selected"; ?>>6 produits</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="admin-form-group">
                                                    <label>Nombre de rangées</label>
                                                    <div class="controls">
                                                        <?php $cur_rows = numRowsBloc($_GET['id']); ?>
                                                        <select name="num_rows" class="admin-input">
                                                            <?php for($i=1; $i<=10; $i++) { ?>
                                                                <option value="<?php echo $i; ?>" <?php if($cur_rows == $i) echo "selected"; ?>><?php echo $i; ?> rangée<?php echo ($i>1?'s':''); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Type section <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="type_section" id="type_section_select" onchange="toggleProductSettings()" required class="admin-input">
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

                                    <script>
                                    function toggleProductSettings() {
                                        var select = document.getElementById('type_section_select');
                                        var container = document.getElementById('product-settings-container');
                                        if (select.value == '4' || select.value == '6') {
                                            container.style.display = 'block';
                                        } else {
                                            container.style.display = 'none';
                                        }
                                    }
                                    </script>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Ancre</label>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="<?php echo ancreBloc($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Lien</label>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="<?php echo lienBloc($_GET['id']); ?>" class="admin-input"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                        $icone_actuelle = '';
                                        $badge_titre_actuel = '';
                                        $req_icon = mysqli_query($connexion, "SELECT icone, badge_titre FROM bloc_accueil WHERE id='".intval($_GET['id'])."'");
                                        if($row_icon = mysqli_fetch_assoc($req_icon)) {
                                            $icone_actuelle = $row_icon['icone'];
                                            $badge_titre_actuel = $row_icon['badge_titre'];
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Icône ou classe FontAwesome (ex: fa-solid fa-truck, fa-solid fa-bolt)</label>
                                                <div class="controls">
                                                    <input type="text" name="icone" value="<?php echo htmlspecialchars($icone_actuelle); ?>" placeholder="fa-brands fa-whatsapp, fa-solid fa-shield..." class="admin-input">
                                                    <small class="form-text text-muted" style="margin-top:0.25rem;">
                                                        <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" style="color:var(--color-primary); text-decoration:underline;">
                                                            Chercher une icône FontAwesome gratuite
                                                        </a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Titre du badge (ex: Promo, Offres Flash)</label>
                                                <div class="controls">
                                                    <input type="text" name="badge_titre" value="<?php echo htmlspecialchars($badge_titre_actuel); ?>" placeholder="Promo..." class="admin-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreBloc($_GET['id']); ?>" class="admin-input"> 
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
