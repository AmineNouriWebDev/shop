
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' ){
	$idbloc = formReception($_POST['id']);
	$idsc   = formReception($_POST['idsc']);
	$lien   = formReception($_POST['lien']);
	
		$requete = 'UPDATE `liste_section_content` SET `lien` = "'. $lien .'" WHERE `id`="'.$idsc.'"';
		$result = executeRequete($requete);	
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" ){
			$destination = str_replace(' ', '-', $idsc."-section-content-".$_FILES['image']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['image']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `liste_section_content` set `photo`="'. $photo .'"  WHERE `id`="'.$idsc.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addSectionContent&id=<?php echo $idbloc; ?>';
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
                                <h4 class="card-title">Modifier image</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image </h5>
                                        <img src="../<?php echo photoSectionContent($_GET['idsc']); ?>" style="max-width:150px">
                                        <div class="controls">
                                            <input type="file" name="image" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Lien </h5>
                                        <div class="controls">
                                            <input type="text" name="lien" value="<?php echo lienSectionContent($_GET['idsc']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <input name="action" type="hidden" id="action" value="mod">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=addSectionContent&id=<?php echo $_GET['idb']; ?>'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['idb']; ?>" />
                                        <input type="hidden" name="idsc" value="<?php echo $_GET['idsc']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>