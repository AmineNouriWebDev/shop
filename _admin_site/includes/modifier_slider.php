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
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
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
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-', $id."-sliders-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/sliders/".$destination);
			$photo = $destination;
			$requete1 = 'UPDATE `sliders` set `photo`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result1 = executeRequete($requete1);	
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
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Modifier slider</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreSlider($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="<?php echo titreEnSlider($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <?php } ?>
                                     <div class="form-group">
                                        <h5>Sous titre</h5>
                                        <div class="controls">
                                            <input type="text" name="titre1" value="<?php echo titre1Slider($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Sous titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titre1en" value="<?php echo titreEn1Slider($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Text boutton </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtn" value="<?php echo textBtnSlider($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Text boutton anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtnen" value="<?php echo textBtnEnSlider($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Lien slider </h5>
                                        <div class="controls">
                                            <input type="text" name="lien" value="" class="form-control"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuSlider($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoSliderSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreSlider($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(etatSlider($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatSlider($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>                                   
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=sliders'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
