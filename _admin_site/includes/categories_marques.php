<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idcateg   = $_GET['idcateg'];
		$idmr = $_GET['idmr'];
		executeRequete("DELETE FROM `categories_marques` WHERE `id` = '$idmr' ");
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=categoriesMarques&id=<?php echo $idcateg; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idcategorie   = formReception($_POST['id']);
	$idmarque      = formReception($_POST['marque']);
	
            		$requete = 'INSERT INTO `categories_marques` (`idcategorie`,`idmarque`) VALUES ("'. $idcategorie .'","'. $idmarque .'")';
            		$result = executeRequete($requete);	
            		//echo $requete; exit;
    	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=categoriesMarques&id=<?php echo $idcategorie; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">Marques catégorie</h4>
                                <div class="table-responsive">
                                    <table id="myTable" class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="background-color: rgb(25, 118, 210);">Titre</th>
                                                <th style="background-color: rgb(25, 118, 210);">Image</th>
                                                <th style="background-color: rgb(25, 118, 210);" class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `categories_marques` WHERE `idcategorie` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo raisonMarque($data['idmarque']); ?> </td>
                                                <td><span class="apercup"><img src="../<?php echo photoMarqueSite($data['idmarque']); ?>" style="max-height:70px" /></span> </td>
                                                <td class="text-nowrap">
                                                  <a href="index.php?r=categoriesMarques&idmr=<?php echo $data['id']; ?>&idcateg=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucune marque trouvée</td>
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
                                <h4 class="card-title">Ajouter marque catégorie</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Nos marques</h5>
                                        <div class="controls">
                                            <select name="marque" class="form-control">
                                                <option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `marques` WHERE `etat` = "1" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['raison']); ?></option>
                                                <?php 
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
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=categories_blog'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>