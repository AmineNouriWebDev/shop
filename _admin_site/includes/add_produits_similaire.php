<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idps   = $_GET['idps'];
		$idp   = $_GET['idp'];
		$start   = $_GET['start'];
	    executeRequete("DELETE FROM `produits_similaire` WHERE `id` = '". $idps ."'");
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduitssimilaire&id=<?php echo $idp; ?>&start=<?php echo $start; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$id         = formReception($_POST['id']);
	$idcateg    = formReception($_POST['idcateg']);
	
		$requete = 'INSERT INTO `produits_similaire`(`id_produit`, `id_categ`) VALUES ("'. $id .'","'. $idcateg .'")';
		$result = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduitssimilaire&id=<?php echo $id; ?>&start=<?php echo $_GET['start']; ?>';
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
                                <h4 class="card-title">Produits similaire : " <?php echo titreProduits($_GET['id']); ?> "</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Titre</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `produits_similaire` WHERE `id_produit` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo titreCategBlog($data['id_categ']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=addproduitssimilaire&idps=<?php echo $data['id']; ?>&idp=<?php echo $_GET['id']; ?>&action=supp&start=<?php echo $_GET['start']; ?>" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="3">Aucun produit trouvé</td>
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
                                <h4 class="card-title">Ajouter produits similaire</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Produits</h5>
											<div class="controls">
												<select name="idcateg" id="select2" class="form-control">
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "E" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `type` = "E" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>">--> <?php echo afficheChamp1($data1['titre']); ?></option>
        	                                      <?php 
        	                                       } 
        	                                     } 
        	                                     ?>
												</select>
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