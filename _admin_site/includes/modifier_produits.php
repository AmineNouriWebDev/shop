<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	             = formReception($_POST['id']);
	$titre  	         = FormChampSpeciaux(formReception($_POST['titre']));
	$court_contenu       = formReception($_POST['court_contenu']);
	$contenu  	         = formReception($_POST['contenu']);
	$categorie 	         = formReception($_POST['categorie']);
	$prix_vente	         = formReception($_POST['prix_vente']);
	$prix_promo	         = formReception($_POST['prix_promo']);
	$quantite	         = formReception($_POST['quantite']);
	$etat_stock	         = formReception($_POST['etat_stock']);
	$marque 	         = formReception($_POST['marque']);
	$duree  	         = formReception($_POST['duree']);
	$afficher_accueil  	 = formReception($_POST['afficher_accueil']);
	$remarque  	         = formReception($_POST['remarque']);
	$video	             = formReception($_POST['video']);
	$nbr_vod	         = formReception($_POST['nbr_vod']);
	$nbr_chaine_hd 	     = formReception($_POST['nbr_chaine_hd']);
	$type        	     = formReception($_POST['type']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$titre_page          = FormChampSpeciaux(formReception($_POST['titre_page']));
	$keywords 	         = formReception($_POST['keywords']);
	$description         = formReception($_POST['description']);
	
	$link    		     = nett(formReception($_POST['titre']));
	
	if(isset($_POST['ancre'])){ $ancre = formReception($_POST['ancre']); } else { $ancre = 'Commander';}

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
	$requete = "UPDATE `produits` set `titre`='".$titre."',`court_contenu`='".$court_contenu."', `categorie`='".$categorie."', `prix_vente`='".$prix_vente."',`prix_promo`='".$prix_promo."', `nbr_vod`='".$nbr_vod."',
	`nbr_chaine_hd`='".$nbr_chaine_hd."', `delai`='".$duree."',  `afficher_accueil`='".$afficher_accueil."',`quantite`='".$quantite."', `marque`='".$marque."', `etat_stock`='".$etat_stock."',
	`type`='".$type."',`caracteristique`='".$contenu."', `ordre`='".$ordre."', `ancre`='".$ancre."', `etat`='".$etat."', `categorie`='".$categorie."', `link`='".$link."',
	`titre_page`='".$titre_page."',`keywords`='".$keywords."', `description`='".$description."',`remarque`='".$remarque."', `video`='".$video."' WHERE `id`='".$id."'";
    //echo $requete;exit;
    $result  = executeRequete($requete);
	
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ){
	
			$destination = str_replace(' ', '-', $id."-produits-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/products/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `produits` set `photo`="'. $photo .'"  WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	
    // caracteristiques produit
	$ver1=executeRequete("DELETE from `caracteristique_prod` WHERE `idproduit`='".$id."'");
	//var_dump($carac);
	// caracteristiques produit
	$carac = $_POST['caracteristiques'];
	$valeurs = $_POST['valeurs'];
	foreach ($carac as $key => $idcarac){
		$requete1 = 'INSERT INTO `caracteristique_prod` (`idproduit`,`idcarac`) VALUES ("'. $id .'","'. $idcarac .'")';
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result1  = mysqli_query($connexion, $requete1);	
		$idcp     = mysqli_insert_id($connexion);
		
		executeRequete('UPDATE `caracteristique_prod` set `valeur`="'. $valeurs[$key] .'"  WHERE `id`="'.$idcp.'"');
	}	

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=produits&start=<?php echo $_GET['start']; ?>';
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
                                <h4 class="card-title">Modifier le produit</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreProduits($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Prix vente </h5>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="<?php echo prixVenteProduits($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Prix promo </h5>
                                        <div class="controls">
                                            <input type="text" name="prix_promo" value="<?php echo prixPromoProduits($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Court contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="court_contenu" value="" class="form-control" rows="3"><?php echo courtContenuProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>  
                                    
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenu" value="" class="form-control" rows="5"><?php echo caracteristiqueProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>                             
                                    <div class="form-group">
                                        <h5>Remarque</h5>
                                        <div class="controls">
                                          <textarea name="remarque" value="" class="form-control" rows="3"><?php echo rqProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuProduits($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoProduitsSite($_GET['id']); ?>" style="max-width:150px" /></div>
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
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" <?php if( categorieProduits($_GET['id']) == $data1['id']) echo "selected"; ?> >--> <?php echo afficheChamp1($data1['titre']); ?></option>
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
													<option value="<?php echo $data['id']; ?>"  <?php if( marquesProduits($_GET['id']) == $data['id']) echo "selected"; ?>><?php echo afficheChamp($data['raison']); ?></option>
                                                <?php 
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
                								
                								<h5>Caractéristiques</h5>
                								<div class="controls">
                								    <select name="caracteristiques[]" class="select2 form-control custom-select" id="mySelect2" onChange="getCaracteristique()" multiple>
                								     <?php		
                                                    $req5 = "SELECT * FROM `caracteristiques` WHERE `etat`='1' ORDER BY `id`";	
                                                    $res5=executeRequete($req5);
                                                    while ($data5 = mysqli_fetch_array($res5))
                                                    {		
                                                      $idc=afficheChamp($data5['id']);
                                                      $titre=afficheChamp($data5['titre']);  
                                                    ?> 
                                                    <option value="<?php echo $idc; ?>"  <?php if(caracteristiques_prod($idc,$_GET['id'])==true) echo "selected";?>><?php echo $titre; ?></option>
                                                    <?php
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
											<h5>Valeurs</h5>
											<div class="controls">
												<select name="valeurs[]" multiple class="select2 form-control custom-select" id="list-carac">
												</select>
											</div>
											</div>
										</div>
									</div> 
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
											<h5>Type</h5>
											<div class="controls">
												<select name="type" class="form-control" id="Type" onchange = "ShowHideDiv()">
													<option value="">-- Selectionner --</option>
													<option value="E" <?php if( typeProduits($_GET['id']) == "E") echo "selected"; ?>>Equipement</option>
													<option value="A" <?php if( typeProduits($_GET['id']) == "A") echo "selected"; ?>>Abonnement</option>
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div id="selectAbonnement" style="display:none;">
									    
                                    <div class="form-group">
                                        <h5>Durée </h5>
										<div class="controls">
                                          <input type="text" name="duree" value="<?php echo delaiProduits($_GET['id']); ?>" class="form-control" placeholder="Exp : Par 6 mois,...">
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label">Afficher accueil</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="afficher_accueil" type="radio" <?php if( afficheAccueilProduits($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="afficher_accueil" type="radio" <?php if( afficheAccueilProduits($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Nombre VOD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="<?php echo vodProduits($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Nombre Chaine HD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="<?php echo chaineHdProduits($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                    
                                    </div>
									
                                    <div class="form-group">
                                        <h5>Video</h5>
                                        <div class="controls">
                                          <textarea name="video" class="form-control" rows="5"><?php echo videoProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <h5> Quantité </h5>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="<?php echo quantiteProduits($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" <?php if( etatStockProduits($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" <?php if( etatStockProduits($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
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
                                            <input type="text" name="ancre" value="<?php echo ancreProduits($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreProduits($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(statusProduits($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(statusProduits($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Titre de la page </h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titrePageProduits($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Description</h5>
                                        <div class="controls">
                                          <textarea name="description" class="form-control" rows="5"><?php echo descriptionProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Keywords</h5>
                                        <div class="controls">
                                          <textarea name="keywords" class="form-control" rows="5"><?php echo keywordsProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=produits&start=<?php echo $_GET['start']; ?>'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

