<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	         	 = formReception($_POST['id']);
	$titre  	         = formReception($_POST['titre']);
	$afficher_accueil 	 = formReception($_POST['afficher_accueil']);
	$prix_vente        	 = formReception($_POST['prix_vente']);
	$marque 	         = formReception($_POST['marque']);
	$quantite	         = formReception($_POST['quantite']);
	$etat_stock	         = formReception($_POST['etat_stock']);
	$duree  	         = formReception($_POST['duree']);
	$contenu  	         = formReception($_POST['contenu']);
	$categorie 	         = formReception($_POST['categorie']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$ancre          	 = formReception($_POST['ancre']);
	$nbr_vod	         = formReception($_POST['nbr_vod']);
	$nbr_chaine_hd 	     = formReception($_POST['nbr_chaine_hd']);
	
	$link    		     = nett(formReception($_POST['titre'])); 

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
		$requete = "UPDATE `abonnements` set `titre`='".$titre."',`afficher_accueil`='".$afficher_accueil."', `prix_vente`='".$prix_vente."', `delai`='".$duree."', `etat_stock`='".$etat_stock."', `marque`='".$marque."', `nbr_vod`='".$nbr_vod."', `nbr_chaine_hd`='".$nbr_chaine_hd."', `caracteristique`='".$contenu."', `categorie`='".$categorie."', `ancre`='".$ancre."', `link`='".$link."', `ordre`='".$ordre."', `etat`='".$etat."' WHERE `id`='".$id."'";		
		$result  = executeRequete($requete);	
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ){
	
			$destination = str_replace(' ', '-', $id."-abonnement-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/products/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `abonnements` set `photo`="'. $photo .'"  WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}


	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=abonnements';
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
                                <h4 class="card-title">Modifier une abonnement</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreAbonnements($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
										</div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Prix vente </h5>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="<?php echo prixVenteAbonnements($_GET['id']); ?>" class="form-control"> 
										</div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Durée </h5>
										<div class="controls">
                                          <input type="text" name="duree" value="<?php echo delaiAbonnements($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Caractéristiques</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" value="" class="form-control" rows="5"><?php echo caracteristiqueAbonnements($_GET['id']); ?></textarea>
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
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "A" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>" <?php if( categorieAbonnements($_GET['id']) == $data['id']) echo "selected"; ?>><?php echo afficheChamp($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `type` = "A" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" <?php if( categorieAbonnements($_GET['id']) == $data['id']) echo "selected"; ?>>--> <?php echo afficheChamp($data1['titre']); ?></option>
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
													<option value="<?php echo $data['id']; ?>"  <?php if( marqueAbonnements($_GET['id']) == $data1['id']) echo "selected"; ?> ><?php echo afficheChamp($data['raison']); ?></option>
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
                                            <input type="text" name="quantite" value="<?php echo quantiteAbonnements($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" <?php if( etatStockAbonnements($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" <?php if( etatStockAbonnements($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Rupture</span>
                                            </label>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="control-label">Afficher accueil</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="afficher_accueil" type="radio" <?php if( afficheAccueilAbonnements($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="afficher_accueil" type="radio" <?php if( afficheAccueilAbonnements($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuAbonnements($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoAbonnementsSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div> 
                                    <div class="form-group">
                                        <h5>Nombre VOD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="<?php echo vodAbonnements($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Nombre Chaine HD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="<?php echo chaineHdAbonnements($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="<?php echo ancreAbonnements($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
									
                                    
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreAbonnements($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(statusAbonnements($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(statusAbonnements($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=abonnements'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>