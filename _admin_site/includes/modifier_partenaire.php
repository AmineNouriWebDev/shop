<?php	if (isset($_GET['action']) && $_GET['action'] == 'supp_img' ) {
		supprimerImagePartenaire($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=mpartenaire&id=<?php echo $_GET['id']; ?>';
	-->
	</script>
	<?php
} ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	     = formReception($_POST['id']);
	$raison  	 = formReception($_POST['raison']);
	$type    	 = formReception($_POST['type']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	
	
	    $requete = "UPDATE `partenaires` set `raison`='".$raison."',`type`='".$type."', `ordre`='".$ordre."', `etat`='".$etat."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-', $id."-partenaire-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/partenaires/".$destination);
			$photo = $destination;
			$requete1 = 'UPDATE `partenaires` set `photo`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result1 = executeRequete($requete1);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=partenaires';
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
                                <h4 class="card-title">Modifier partenaire</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Raison <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="raison" value="<?php echo raisonPartenaire($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                     <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Type <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="type" id="select" required class="form-control">
                                                <option value="0" selected="selected">-- Selectionnez  --</option>
                                                <option value="1" <?php if(typePartenaire($_GET['id']) == 1)  echo "selected"; ?>>En tunisie</option>
                                                <option value="2" <?php if(typePartenaire($_GET['id']) == 2)  echo "selected"; ?>>À l'étranger</option>
                                            </select>
                                        </div>
                                      </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuPartenaire($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoPartenaireSite($_GET['id']); ?>" style="max-width:150px" /></div>
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
                                            <input type="text" name="ordre" value="<?php echo OrdrePartenaire($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="select" id="select" class="form-control">
                                                <option value="1" <?php if(StatutPartenaire($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatutPartenaire($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>                                   
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=partenaires'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
