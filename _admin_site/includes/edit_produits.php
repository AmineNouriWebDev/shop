
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' ){
	$idsc      = formReception($_POST['idsc']);
	$idbloc    = formReception($_POST['id']);
	$en_promo  = formReception($_POST['en_promo']);
	$categorie = formReception($_POST['categorie']);
	$marque    = formReception($_POST['marque']);
		
	
		$requete = 'UPDATE `liste_produits` SET `en_promo` = "'. $en_promo .'",`categorie` = "'. $categorie .'",`marque` = "'. $marque .'" WHERE `id`="'.$idsc.'"';
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
                                <h4 class="card-title">Modifier détail</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
									<div class="form-group">
                                        <label class="control-label">En promo</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="en_promo" type="radio" value="1" class="custom-control-input" <?php if(EnPromoListeProduits($_GET['idsc']) == 1) echo 'checked'; ?>>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="en_promo" type="radio" value="0" class="custom-control-input" <?php if(EnPromoListeProduits($_GET['idsc']) == 0) echo 'checked'; ?>>
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
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>" <?php if(categorieListeProduits($_GET['idsc']) == $data['id']) echo 'selected'; ?>><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" <?php if(categorieListeProduits($_GET['idsc']) == $data1['id']) echo 'selected'; ?>>--> <?php echo afficheChamp1($data1['titre']); ?></option>
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
												
													
													<option value="">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `marques` WHERE `etat` = "1" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['link']; ?>"  <?php if( marqueListeProduits($_GET['idsc']) == $data['link']) echo "selected"; ?>><?php echo afficheChamp($data['raison']); ?></option>
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
                                       <input name="action" type="hidden" id="action" value="mod">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=addproduits&id=<?php echo $_GET['idb']; ?>'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['idb']; ?>" />
                                        <input type="hidden" name="idsc" value="<?php echo $_GET['idsc']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>