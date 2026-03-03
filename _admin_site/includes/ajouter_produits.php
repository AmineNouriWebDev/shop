<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	$titre  	         = FormChampSpeciaux(formReception($_POST['titre']));
	$court_contenu       = formReception($_POST['court_contenu']);
	$contenu  	         = formReception($_POST['contenu']);
	$categorie 	         = formReception($_POST['categorie']);
    $idprt               = idparentCategBlog($categorie);
	$prix_vente	         = formReception($_POST['prix_vente']);
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
	
	if(isset($_POST['ancre'])){ $ancre = formReception($_POST['ancre']); } else { $ancre = "Commander";}

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
	$requete = 'INSERT INTO `produits`
	(`titre`,`court_contenu`, `caracteristique`,`remarque`, `link`, `categorie`,`idparent_categ`, `prix_vente`, `etat_stock`, `quantite`, `marque`, `type`, `afficher_accueil`,
	`video`, `delai`, `nbr_vod`, `nbr_chaine_hd`, `ancre`, `ordre`, `etat`, `titre_page`, `description`, `keywords`, `auteur`, `datecreation`) 
	VALUES
	("'. $titre .'","'. $court_contenu .'","'. $contenu .'","'. $remarque .'","'. $link .'","'. $categorie .'","'. $idprt .'","'. $prix_vente .'","'. $etat_stock .'","'. $quantite .'","'. $marque .'","'. $type .'","'
	. $afficher_accueil .'","'.$video.'","'. $duree .'","'. $ancre .'","'. $nbr_vod .'","'. $nbr_chaine_hd .'","'. $ordre .'", "'. $etat .'","'. $titre_page .'","'. $keywords .'",
	"'. $description .'","'. $auteur .'","'. $datec .'")';
		
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idp     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ){
	
			$destination = str_replace(' ', '-', $idp."-produits-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/products/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `produits` set `photo`="'. $photo .'"  WHERE `id`="'.$idp.'"';
			$result = executeRequete($requete);	
		}
	}
    // caracteristiques produit
	$carac = $_POST['caracteristiques'];
	$valeurs = $_POST['valeurs'];
	foreach ($carac as $key => $idcarac){
		$requete1 = 'INSERT INTO `caracteristique_prod` (`idproduit`,`idcarac`) VALUES ("'. $idp .'","'. $idcarac .'")';
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result1  = mysqli_query($connexion, $requete1);	
		$idcp     = mysqli_insert_id($connexion);
		
		executeRequete('UPDATE `caracteristique_prod` set `valeur`="'. $valeurs[$key] .'"  WHERE `id`="'.$idcp.'"');
	}	

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=produits';
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
                                <h4 class="card-title">Ajouter un produit</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Prix vente </h5>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="" class="form-control"> </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Court contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="court_contenu" value="" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>                             
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenu" value="" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                                               
                                    <div class="form-group">
                                        <h5>Remarque</h5>
                                        <div class="controls">
                                          <textarea name="remarque" value="" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
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
													<option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['raison']); ?></option>
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
                                                    <option value="<?php echo $idc; ?>"><?php echo $titre; ?></option>
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
													<option value="E">Equipement</option>
													<option value="A">Abonnement</option>
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div id="selectAbonnement" style="display:none;">
									    
                                    <div class="form-group">
                                        <h5>Durée </h5>
										<div class="controls">
                                          <input type="text" name="duree" value="" class="form-control" placeholder="Exp : Par 6 mois,...">
                                        </div>
                                    </div>
									<div class="form-group">
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
                                    <div class="form-group">
                                        <h5>Nombre VOD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Nombre Chaine HD</h5>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="" class="form-control">
                                        </div>
                                    </div>
                                    
                                    </div>
									
									
                                    <div class="form-group">
                                        <h5>Video</h5>
                                        <div class="controls">
                                          <textarea name="video" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5> Quantité </h5>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="" class="form-control"> </div>
                                    </div>
									<div class="form-group">
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
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('produits',1); ?>" class="form-control"> 
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
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Titre de la page </h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="" class="form-control"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Description</h5>
                                        <div class="controls">
                                          <textarea name="description" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Keywords</h5>
                                        <div class="controls">
                                          <textarea name="keywords" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=produits'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

