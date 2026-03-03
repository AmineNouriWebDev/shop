<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	= formReception($_POST['id']);
	$nom  	= formReception($_POST['nom']);
	$ordre 	= formReception($_POST['ordre']);
	$etat 	= formReception($_POST['etat']);
	
		$requete = 'UPDATE `applications` SET `nom`="'. $nom .'", `ordre`="'. $ordre .'",`etat`="'. $etat .'" WHERE `id`="'.$id.'"'; 
        $result = executeRequete($requete);	
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" ) {
			$destination = str_replace(' ', '-', $id."-image-".$_FILES['image']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination); 
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['image']['tmp_name'], "../media/applications/".$destination);
			$image = $destination;
			$requete = 'UPDATE `applications` set `image`="'. $image .'" WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	
    $extension = array("application/octet-stream","application/vnd.android.package-archive");
	
	if (isset($_FILES['application']) && $_FILES['application']['type'] != '') {
		if (in_array($_FILES["application"]["type"],$extension )) {
			$destination = str_replace(' ', '-', $id."-application-".$_FILES['application']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination); 
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);
			move_uploaded_file ($_FILES['application']['tmp_name'], "../media/applications/".$destination);
			$file = $destination;
			$requete = 'UPDATE `applications` set `file`="'. $file .'" WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=applications';
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
                                <h4 class="card-title">Ajouter un partenaire</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Nom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="nom" value="<?php echo nomApplications($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <img src="../<?php echo ImageApplications($_GET['id']); ?>" class="img-fluid" style="max-width:100px" />
                                        <div class="controls">
                                            <input type="file" name="image" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Application (.APK)</h5>
                                        <a href="../<?php echo fileApplications($_GET['id']); ?>" target="_blank">Lien application .apk</a>
                                        <div class="controls">
                                            <input type="file" name="application" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreApplications($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-2">
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
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=applications'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>