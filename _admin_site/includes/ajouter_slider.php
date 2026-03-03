<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
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
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
			$destination = str_replace(' ', '-', $ids."-sliders-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination); 
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/sliders/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `sliders` set `photo`="'. $photo .'" WHERE `id`="'.$ids.'"';
			$result = executeRequete($requete);	
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
                                <h4 class="card-title">Ajouter une image slider</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="" class="form-control"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Sous titre</h5>
                                        <div class="controls">
                                            <input type="text" name="titre1" value="" class="form-control"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Sous titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titre1en" value="" class="form-control"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Text boutton </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtn" value="" class="form-control"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Text boutton anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="textBtnen" value="" class="form-control"> </div>
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
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('sliders',1); ?>" class="form-control"> 
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
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=sliders'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>