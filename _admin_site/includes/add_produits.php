<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idb   = $_GET['idb'];
		supprimerListeProduits($_GET['idsc']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduits&id=<?php echo $idb; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idbloc    = formReception($_POST['id']);
	$en_promo  = formReception($_POST['en_promo']);
	$categorie = formReception($_POST['categorie']);
	$marque    = formReception($_POST['marque']);
	
		$requete = 'INSERT INTO `liste_produits` (`idbloc`,`en_promo`, `categorie`, `marque`) VALUES ("'. $idbloc .'","'. $en_promo .'","'. $categorie .'","'. $marque .'")';
		$result = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addproduits&id=<?php echo $idbloc; ?>';
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
                                <h4 class="card-title">Détails section : <?php echo titreListeSection(typeSectionBloc($_GET['id'])); ?></h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>En promo</th>
                                                <th>Catégorie</th>
                                                <th>Marque</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `liste_produits` WHERE `idbloc` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php if($data['en_promo'] == 0) echo 'Non'; else echo 'Oui'; ?></td>
                                                <td><?php echo titreCategBlog($data['categorie']); ?></td>
                                                <td><?php echo raisonByLinkMarque($data['marque']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=editproduits&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=addproduits&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucune détail trouvée</td>
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
                                <h4 class="card-title">Ajouter détail</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
									<div class="form-group">
                                        <label class="control-label">En promo</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="en_promo" type="radio" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="en_promo" type="radio" checked value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Catégorie</h5>
											<div class="controls">
												<select name="categorie" id="select1" class="form-control">
												
													
													<option value="">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" >--> <?php echo afficheChamp1($data1['titre']); ?></option>
        	                                      <?php 
        	                                       } 
        	                                     } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Marque</h5>
											<div class="controls">
												<select name="marque" id="select2" class="form-control">
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `marques` WHERE `etat` = "1" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['link']; ?>"><?php echo afficheChamp($data['raison']); ?></option>
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
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=bloc_accueil'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>