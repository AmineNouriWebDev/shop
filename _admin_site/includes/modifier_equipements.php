<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	             = formReception($_POST['id']);
	$titre  	         = FormChampSpeciaux(formReception($_POST['titre']));
	$categorie 	         = formReception($_POST['categorie']);
	$prix_vente	         = formReception($_POST['prix_vente']);
	$marque 	         = formReception($_POST['marque']);
	$quantite	         = formReception($_POST['quantite']);
	$etat_stock	         = formReception($_POST['etat_stock']);
	$contenu  	         = formReception($_POST['contenu']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$ancre          	 = formReception($_POST['ancre']);
	$titre_page          = FormChampSpeciaux(formReception($_POST['titre_page'])); 
	$keywords 	         = formReception($_POST['keywords']);
	$description         = formReception($_POST['description']);
	
	$link    		     = nett(formReception($_POST['titre']));
	
	$requete = "UPDATE `equipements` set `titre`='".$titre."', `categorie`='".$categorie."', `prix_vente`='".$prix_vente."', `marque`='".$marque."', `etat_stock`='".$etat_stock."',`caracteristique`='".$contenu."', `ordre`='".$ordre."', `ancre`='".$ancre."', `etat`='".$etat."', `categorie`='".$categorie."', `link`='".$link."', `titre_page`='".$titre_page."',`keywords`='".$keywords."', `description`='".$description."' WHERE `id`='".$id."'";
	
	$result  = executeRequete($requete);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ){
	
			$destination = str_replace(' ', '-', $id."-equipement-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/equipements/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `equipements` set `photo`="'. $photo .'"  WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}


	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=equipements';
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
                                <h4 class="card-title">Modifier un équipement</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreEquipements($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Prix vente </h5>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="<?php echo PrixVenteEquipements($_GET['id']); ?>" class="form-control"> </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <h5>Caractéristiques</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"><?php echo caracteristiqueEquipements($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuEquipements($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoEquipementsSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
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
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "E" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['id']; ?>" <?php if( categorieEquipements($_GET['id']) == $data['id']) echo "selected"; ?>><?php echo afficheChamp($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `type` = "E" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" <?php if( categorieEquipements($_GET['id']) == $data1['id']) echo "selected"; ?> >--> <?php echo afficheChamp($data1['titre']); ?></option>
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
													<option value="<?php echo $data['id']; ?>"  <?php if( marqueEquipements($_GET['id']) == $data['id']) echo "selected"; ?> ><?php echo afficheChamp($data['raison']); ?></option>
                                                <?php 
        	                                        } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
                                    <div class="form-group">
                                        <h5> Quantité </h5>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="<?php echo quantiteEquipements($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" <?php if( etatStockEquipements($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" <?php if( etatStockEquipements($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Rupture</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="<?php echo ancreEquipements($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
									                                    
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreEquipements($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Etat</h5>
											<div class="controls">
											  <select name="etat" id="select" class="form-control">
												<option value="1" <?php if(statusEquipements($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
												<option value="0" <?php if(statusEquipements($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
											  </select>
											</div>
											</div>
										</div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Titre de la page </h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pageEquipements($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Description</h5>
                                        <div class="controls">
                                          <textarea name="description" class="form-control" rows="5"><?php echo descriptionEquipements($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Keywords</h5>
                                        <div class="controls">
                                          <textarea name="keywords" class="form-control" rows="5"><?php echo keywordsEquipements($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=equipements'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>