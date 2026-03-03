<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	             = formReception($_POST['id']);
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
			
		$requete = "UPDATE `articles` set `titre`='".$titre."', `contenu`='".$contenu."', `ordre`='".$ordre."', `etat`='".$etat."', `categorie`='".$categorie."', `link`='".$link."', `titre_page`='".$titre_page."',`keywords`='".$keywords."', `description`='".$description."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);

		
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ){
			$destination = str_replace(' ', '-', $id."-article-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/blog/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `articles` set `photo`="'. $photo .'"  WHERE `id`="'.$id.'"';
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
                                <h4 class="card-title">Modifier un article</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreArticle($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"><?php echo ContenuArticle($_GET['id']); ?></textarea>
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
	                                    <option value="<?php echo $data['id']; ?>"<?php if($data['id'] == CategArticle($_GET['id']))  echo "selected"; ?>><?php echo afficheChamp($data['titre']); ?></option>
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
                                        <?php if(ApercuArticle($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoArticleSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
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
                                            <input type="text" name="ordre" value="<?php echo OrdreArticle($_GET['id']); ?>" class="form-control"> 
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
                                            <option value="1" <?php if(StatusArticle($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                            <option value="0" <?php if(StatusArticle($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                          </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Titre de la page </h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pageArticle($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Description</h5>
                                        <div class="controls">
                                          <textarea name="description" class="form-control" rows="5"><?php echo descriptionArticle($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Keywords</h5>
                                        <div class="controls">
                                          <textarea name="keywords" class="form-control" rows="5"><?php echo keywordsArticle($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                       
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=articles'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>