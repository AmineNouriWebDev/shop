<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	$titre  	 = formReception($_POST['titre']);
	$lien    	 = formReception($_POST['lien']);
	$type    	 = formReception($_POST['type']);
	if (isset($_POST['icone']) && $_POST['icone'] != '') { $icone  = formReception($_POST['icone']); } else { $icone =""; }
	$image    	 = formReception($_POST['image']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
		$requete = 'INSERT INTO `social_network` (`titre`,`lien`,`type`,`ordre`, `etat`,`icone`,`datecreation`,`auteur`) VALUES ("'. $titre .'", "'. $lien .'", "'. $type .'", "'. $ordre .'", "'. $etat .'", "'. $icone .'","'. $datec .'","'. $auteur .'")';
		/*$result  = executeRequete($requete);	
		$connexion=ouvrirCnx() or die("erreur cnx");*/
		$result  = mysqli_query($connexion, $requete);	
		$ids     = mysqli_insert_id($connexion);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-', $ids."-social-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination); 
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/social_network/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `social_network` set `image`="'. $photo .'"  WHERE `id`="'.$ids.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=social_network';
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
                                <h4 class="card-title">Ajouter</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Lien</h5>
                                        <div class="controls">
                                            <input type="text" name="lien" value="" class="form-control"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Type</h5>
                                        <div class="controls">
                                            <select name="type" id="select" class="form-control" onchange="showInput(this)">
                                              <option value="">-- Sélectionnez  --</option>
                                              <option value="1" selected="selected">Icône</option>
                                              <option value="2">Image</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <span id="input_icone">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Icône</h5>
                                        <div class="controls">
                                            <input type="text" name="icone" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    </span>
                                    <span id="input_image" style="display:none">
								<div class="col-sm-12">
                                 <label>Image</label>
                                    <div class="form-group row">
                                     <div class="col-md-6">
                                      <div class="form-line">
                                            <input type="file" class="form-control" name="photo" value="">
                                        </div>
                                       </div>
                                    </div>
                                </div>
								</span>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('social_network',1); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat <span class="text-danger">*</span></h5>
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
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=social_network'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<script type="text/javascript">
 function showInput(select){
   if(select.value==1){
    document.getElementById('input_icone').style.display = "block";
    document.getElementById('input_image').style.display = "none";
   } else if(select.value==2){
    document.getElementById('input_image').style.display = "block";
    document.getElementById('input_icone').style.display = "none";
   } else {
	 document.getElementById('input_image').style.display = "none";
	 document.getElementById('input_icone').style.display = "none";
   }
 } 
</script>