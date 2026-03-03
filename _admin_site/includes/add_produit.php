<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idpr   = $_GET['idpr'];
		supprimerimagessupplimentaires($_GET['ids']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduit&id=<?php echo $idpr; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idproduit           = formReception($_POST['id']);
	
		$requete = 'INSERT INTO `images_produit` (`id_produit`) VALUES ("'. $idproduit .'")';
		//echo $requete; exit;
		
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idp     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" || $_FILES['image']['type']=="image/webp" ){
			$destination = str_replace(' ', '-', $idp."-".$idproduit."-".$_FILES['image']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['image']['tmp_name'], "../media/products/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `images_produit` set `image`="'. $photo .'"  WHERE `id`="'.$idp.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduit&id=<?php echo $idproduit; ?>&start=<?php echo $_GET['start']; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">Images Produit</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Vignette</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `images_produit` WHERE `id_produit` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><span class="apercup"><img src="<?php echo imagesProduitSite($data['id']); ?>" /></span> </td>
                                                <td class="text-nowrap">
                                                  <a href="index.php?r=addproduit&ids=<?php echo $data['id']; ?>&idpr=<?php echo $_GET['id']; ?>&start=<?php echo $_GET['start']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucune image suppl&eacute;mentaire</td>
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
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <input name="action" type="hidden" id="action" value="ajt">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=produits&start=<?php echo $_GET['start']; ?>'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>