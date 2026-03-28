<?php	if (isset($_GET['action']) && $_GET['action'] == 'supp_img' ) {
		supprimerImageSlider($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=mslider&id=<?php echo $_GET['id']; ?>';
	-->
	</script>
	<?php
} ?>
<?php	if (isset($_GET['action']) && $_GET['action'] == 'supp_img_m' ) {
		supprimerImageMobileSlider($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=mslider&id=<?php echo $_GET['id']; ?>';
	-->
	</script>
	<?php
} ?>
<?php	if (isset($_GET['action']) && $_GET['action'] == 'supp_img_t' ) {
		supprimerImageTabletSlider($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=mslider&id=<?php echo $_GET['id']; ?>';
	-->
	</script>
	<?php
} ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	// Prevent VPS silent crashes on large image conversions
	ini_set('memory_limit', '512M');
	set_time_limit(300);

	$id  	     = formReception($_POST['id']);
	$titre  	 = formReception($_POST['titre']);
	$titreen  	 = formReception($_POST['titreen']);
	$titre1  	 = formReception($_POST['titre1']);
	$titre1en  	 = formReception($_POST['titre1en']);
	$textBtn  	 = formReception($_POST['textBtn']);
	$textBtnen 	 = formReception($_POST['textBtnen']);
	$lien 		 = formReception($_POST['lien']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	
	
	    $requete = "UPDATE `sliders` set `titre`='".$titre."',`titreen`='".$titreen."',`titre1`='".$titre1."',`lien`='".$lien."',`titreen1`='".$titre1en."',`textBouton`='".$textBtn."',`textBoutonen`='".$textBtnen."', `ordre`='".$ordre."', `etat`='".$etat."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id."-sliders-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo']['tmp_name'], $dest_base . "." . $ext);
                $photo = $base_name . "." . $ext;
            }
			$requete1 = 'UPDATE `sliders` set `photo`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result1 = executeRequete($requete1);	
		}
	}

		if (isset($_FILES['photo_mobile']) && $_FILES['photo_mobile']['type'] != '') {
		if ($_FILES['photo_mobile']['type']=="image/jpeg" || $_FILES['photo_mobile']['type']=="image/png" || $_FILES['photo_mobile']['type']=="image/gif" || $_FILES['photo_mobile']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id."-sliders-mobile-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_mobile']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_mobile = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo_mobile']['tmp_name'], $dest_base . "." . $ext);
                $photo_mobile = $base_name . "." . $ext;
            }
			$requete_m = 'UPDATE `sliders` set `photo_mobile`="'. $photo_mobile .'" WHERE `id`="'.$id.'"';
			$result_m = executeRequete($requete_m);	
		}
	}

		if (isset($_FILES['photo_tablet']) && $_FILES['photo_tablet']['type'] != '') {
		if ($_FILES['photo_tablet']['type']=="image/jpeg" || $_FILES['photo_tablet']['type']=="image/png" || $_FILES['photo_tablet']['type']=="image/gif" || $_FILES['photo_tablet']['type']=="image/webp" ) {
            $orig_name = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_FILENAME);
			$base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id."-sliders-tablet-".time()."-".$orig_name);
            $dest_base = "../media/sliders/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_tablet']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_tablet = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_EXTENSION);
                copy($_FILES['photo_tablet']['tmp_name'], $dest_base . "." . $ext);
                $photo_tablet = $base_name . "." . $ext;
            }
			$requete_t = 'UPDATE `sliders` set `photo_tablet`="'. $photo_tablet .'" WHERE `id`="'.$id.'"';
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
                            <div class="admin-card-body">
                                <h4 class="card-title">Modifier slider</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreSlider($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <h5>Titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="<?php echo titreEnSlider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                     <div class="admin-form-group">
                                        <h5>Sous titre</h5>
                                        <div class="controls">
                                            <input type="text" name="titre1" value="<?php echo titre1Slider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <h5>Sous titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titre1en" value="<?php echo titreEn1Slider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <h5>Text boutton </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtn" value="<?php echo textBtnSlider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <h5>Text boutton anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtnen" value="<?php echo textBtnEnSlider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <h5>Lien slider </h5>
                                        <div class="controls">
                                            <input type="text" name="lien" value="<?php echo lienSlider($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <h5>Image Desktop <span class="text-muted">(Défaut)</span></h5>
                                        <?php if(ApercuSlider($_GET['id'])) { ?>
								         <div class="mb-2" style="position:relative; display:inline-block;">
                                             <img src="../<?php echo photoSliderSite($_GET['id']); ?>" style="max-width:150px; border:1px solid #ddd; padding:2px;" />
                                             <a href="index.php?r=mslider&id=<?php echo $_GET['id']; ?>&action=supp_img" class="btn btn-danger btn-circle btn-sm" style="position:absolute; top:-10px; right:-10px;" title="Supprimer l'image"><i class="fa fa-times"></i></a>
                                         </div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <h5>Image Tablette <span class="text-muted">(Optionnel)</span></h5>
                                        <?php if(ApercuTabletSlider($_GET['id'])) { ?>
								         <div class="mb-2" style="position:relative; display:inline-block;">
                                             <img src="../<?php echo photoTabletSliderSite($_GET['id']); ?>" style="max-width:150px; border:1px solid #ddd; padding:2px;" />
                                             <a href="index.php?r=mslider&id=<?php echo $_GET['id']; ?>&action=supp_img_t" class="btn btn-danger btn-circle btn-sm" style="position:absolute; top:-10px; right:-10px;" title="Supprimer l'image"><i class="fa fa-times"></i></a>
                                         </div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo_tablet" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                     <div class="col-md-4">
                                      <div class="admin-form-group">
                                        <h5>Image Smartphone <span class="text-muted">(Optionnel)</span></h5>
                                        <?php if(ApercuMobileSlider($_GET['id'])) { ?>
								         <div class="mb-2" style="position:relative; display:inline-block;">
                                             <img src="../<?php echo photoMobileSliderSite($_GET['id']); ?>" style="max-width:150px; border:1px solid #ddd; padding:2px;" />
                                             <a href="index.php?r=mslider&id=<?php echo $_GET['id']; ?>&action=supp_img_m" class="btn btn-danger btn-circle btn-sm" style="position:absolute; top:-10px; right:-10px;" title="Supprimer l'image"><i class="fa fa-times"></i></a>
                                         </div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo_mobile" class="admin-input"> 
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreSlider($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" <?php if(StatutSlider($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatutSlider($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>                                   
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=sliders'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

