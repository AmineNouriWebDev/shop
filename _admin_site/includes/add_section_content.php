<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idb   = $_GET['idb'];
		supprimerSectionContent($_GET['idsc']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addSectionContent&id=<?php echo $idb; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idbloc = formReception($_POST['id']);
	$lien = formReception($_POST['lien']);
	
		$requete = 'INSERT INTO `liste_section_content` (`idbloc`,`lien`) VALUES ("'. $idbloc .'","'. $lien .'")';
		//echo $requete; exit;
		
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idc     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" || $_FILES['image']['type']=="image/webp" ){
			$destination = str_replace(' ', '-', $idc."-section-content-".$_FILES['image']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['image']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `liste_section_content` set `photo`="'. $photo .'"  WHERE `id`="'.$idc.'"';
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
                                <h4 class="card-title">Images section : <?php echo titreListeSection(typeSectionBloc($_GET['id'])); ?></h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Lien</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `liste_section_content` WHERE `idbloc` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><span class="apercup"><img src="../<?php echo photoSectionContent($data['id']); ?>" /></span> </td>
                                                <td><?php echo lienSectionContent($data['id']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=editSectionContent&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=addSectionContent&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucune image trouvée</td>
                                        </tr>
                                        <?php } ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter image</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image </h5>
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
                                            <input type="text" name="lien" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <input name="action" type="hidden" id="action" value="ajt">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>