<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	$titre  	         = formReception($_POST['titre']);
	$afficher_accueil  	 = formReception($_POST['afficher_accueil']);
	$prix_vente        	 = formReception($_POST['prix_vente']);
	$marque 	         = formReception($_POST['marque']);
	$etat_stock	         = formReception($_POST['etat_stock']);
	$quantite	         = formReception($_POST['quantite']);
	$duree  	         = formReception($_POST['duree']);
	$contenu  	         = formReception($_POST['contenu']);
	$categorie 	         = formReception($_POST['categorie']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$nbr_vod	         = formReception($_POST['nbr_vod']);
	$nbr_chaine_hd 	     = formReception($_POST['nbr_chaine_hd']);
	
	$link    		     = nett(formReception($_POST['titre']));
	if(isset($_POST['ancre'])) { $ancre = formReception($_POST['ancre']); }else{ $ancre = "S\'abonner"; }

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
		$requete = 'INSERT INTO `abonnements` (`titre`, `afficher_accueil`,`prix_vente`, `delai`, `nbr_vod`, `nbr_chaine_hd`, `caracteristique`, `categorie`,`etat_stock`,`quantite`, `marque`, `ancre`, `link`, `ordre`, `etat`, `auteur`, `datecreation`) VALUES ("'. $titre .'","'. $afficher_accueil .'","'. $prix_vente .'","'. $duree .'","'. $nbr_vod .'","'. $nbr_chaine_hd .'","'. $contenu .'","'. $categorie .'","'. $etat_stock .'","'. $quantite .'","'. $ancre .'", "'. $link .'", "'. $ordre .'", "'. $etat .'", "'. $auteur .'","'. $datec .'")';
				/*$result  = executeRequete($requete);	*/
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idp     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ){
	
			$destination = str_replace(' ', '-', $idp."-abonnement-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/products/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `abonnements` set `photo`="'. $photo .'"  WHERE `id`="'.$idp.'"';
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
                        <div class="admin-card">
                            <div class="admin-card-header">
								<div class="admin-card-title">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
									</svg>
									Ajouter un abonnement
								</div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Prix vente </label>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="" class="admin-input"> </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Durée </label>
										<div class="controls">
                                          <input type="text" name="duree" value="" class="admin-input" placeholder="Exp : Par 6 mois,...">
                                        </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Caractéristiques</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" value="" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Catégorie</label>
											<div class="controls">
												<select name="categorie" id="select1" class="admin-input">							
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "A" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `type` = "A" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>">--> <?php echo afficheChamp($data1['titre']); ?></option>
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
											<div class="admin-form-group">
											<label>Marque</label>
											<div class="controls">
												<select name="marque" id="select2" class="admin-input">
												
													
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
                                    <div class="admin-form-group">
                                        <label> Quantité </label>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="" class="admin-input"> </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" checked="" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Rupture</span>
                                            </label>
                                        </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Afficher accueil</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="afficher_accueil" type="radio" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="afficher_accueil" type="radio" checked="" value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Nombre VOD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Nombre Chaine HD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Ancre</label>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>				
                                    
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('abonnements',1); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=abonnements'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
