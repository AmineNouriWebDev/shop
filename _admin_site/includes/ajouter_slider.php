<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	// Prevent VPS silent crashes on large image conversions
	ini_set('memory_limit', '512M');
	set_time_limit(300);

	$titre  	 = formReception($_POST['titre']);
	$titreen  	 = formReception($_POST['titreen']);
	$titre1  	 = formReception($_POST['titre1']);
	$titre1en  	 = formReception($_POST['titre1en']);
	$textBtn  	 = formReception($_POST['textBtn']);
	$textBtnen 	 = formReception($_POST['textBtnen']);
	$lien 		 = formReception($_POST['lien']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	
	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
		$requete = 'INSERT INTO `sliders` 
		(`titre`, `titreen`, `titre1`, `titreen1`, `textBouton`, `textBoutonen`, `lien`, `ordre`,`etat`,`datecreation`,`auteur`) 
		VALUES
		("'. $titre .'","'. $titreen .'", "'. $titre1 .'","'. $titre1en .'","'. $textBtn .'","'. $textBtnen .'","'. $lien .'", "'. $ordre .'","'. $etat .'","'. $datec .'","'. $auteur .'")'; 

		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$ids     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $ids."-sliders-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo']['tmp_name'], $dest_base . "." . $ext);
                $photo = $base_name . "." . $ext;
            }
			$requete = 'UPDATE `sliders` set `photo`="'. $photo .'" WHERE `id`="'.$ids.'"';
			$result = executeRequete($requete);	
		}
	}

		if (isset($_FILES['photo_mobile']) && $_FILES['photo_mobile']['type'] != '') {
		if ($_FILES['photo_mobile']['type']=="image/jpeg" || $_FILES['photo_mobile']['type']=="image/png" || $_FILES['photo_mobile']['type']=="image/gif" || $_FILES['photo_mobile']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $ids."-sliders-mobile-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_mobile']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_mobile = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo_mobile']['tmp_name'], $dest_base . "." . $ext);
                $photo_mobile = $base_name . "." . $ext;
            }
			$requete_m = 'UPDATE `sliders` set `photo_mobile`="'. $photo_mobile .'" WHERE `id`="'.$ids.'"';
			$result_m = executeRequete($requete_m);	
		}
	}

		if (isset($_FILES['photo_tablet']) && $_FILES['photo_tablet']['type'] != '') {
		if ($_FILES['photo_tablet']['type']=="image/jpeg" || $_FILES['photo_tablet']['type']=="image/png" || $_FILES['photo_tablet']['type']=="image/gif" || $_FILES['photo_tablet']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $ids."-sliders-tablet-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_tablet']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_tablet = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo_tablet']['tmp_name'], $dest_base . "." . $ext);
                $photo_tablet = $base_name . "." . $ext;
            }
			$requete_t = 'UPDATE `sliders` set `photo_tablet`="'. $photo_tablet .'" WHERE `id`="'.$ids.'"';
			$result_t = executeRequete($requete_t);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=sliders';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    Ajouter une image slider
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Titre anglais </label>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <label>Sous titre</label>
                                        <div class="controls">
                                            <input type="text" name="titre1" value="" class="admin-input"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Sous titre anglais </label>
                                        <div class="controls">
                                            <input type="text" name="titre1en" value="" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <label>Text boutton </label>
                                        <div class="controls">
                                            <input type="text" name="textBtn" value="" class="admin-input"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Text boutton anglais </label>
                                        <div class="controls">
                                            <input type="text" name="textBtnen" value="" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <label>Lien slider </label>
                                        <div class="controls">
                                            <input type="text" name="lien" value="" class="admin-input"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <label>Image Desktop <span class="text-muted">(Défaut)</span></label>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <label>Image Tablette <span class="text-muted">(Optionnel)</span></label>
                                        <div class="controls">
                                            <input type="file" name="photo_tablet" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <label>Image Smartphone <span class="text-muted">(Optionnel)</span></label>
                                        <div class="controls">
                                            <input type="file" name="photo_mobile" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('sliders',1); ?>" class="admin-input"> 
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
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=sliders'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
