<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	$titre  	         = formReception($_POST['titre']);
	$contenu  	         = formReception($_POST['contenu']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$categorie	         = formReception($_POST['categorie']);
	$titre_page          = formReception($_POST['titre_page']);
	$keywords 	         = formReception($_POST['keywords']);
	$description         = formReception($_POST['description']);
	
	$link    		    = nett(formReception($_POST['titre']));

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
		$requete = 'INSERT INTO `articles` (`titre`,`contenu`, `ordre`, `etat`, `categorie`, `link`, `titre_page`, `keywords`,`description`,`datecreation`,`auteur`) VALUES ("'. $titre .'","'. $contenu .'", "'. $ordre .'", "'. $etat .'","'. $categorie .'", "'. $link .'", "'. $titre_page .'","'. $keywords .'","'. $description .'","'. $datec .'","'. $auteur .'")';
		
		/*$result  = executeRequete($requete);	*/
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idp     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ){
	
			$destination = str_replace(' ', '-', $idp."-article-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/blog/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `articles` set `photo`="'. $photo .'"  WHERE `id`="'.$idp.'"';
			$result = executeRequete($requete);	
		}
	}

	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=articles';
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
                                <h4 class="card-title">Ajouter un article</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" value="" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Catégorie <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="categorie" id="categorie" required class="form-control">
                                              <option value="0" selected="selected">-- Selectionnez  --</option>
                                              <?php
	                                 $req = 'SELECT * FROM `categories_blog` WHERE `etat` = "1" ORDER BY `ordre` ASC';
	                                 $res = executeRequete($req);
	                                  while ($data = mysqli_fetch_array($res)) { ?>
	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['titre']); ?></option>
	                                <?php } ?> 
                                            </select>
                                        </div>
                                      </div>
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
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('articles',1); ?>" class="form-control"> 
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
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=articles'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>