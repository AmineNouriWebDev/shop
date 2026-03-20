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
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                    </svg>
                                    Modifier un article
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreArticle($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="admin-input" rows="5"><?php echo ContenuArticle($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Catégorie <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="categorie" id="categorie" required class="admin-input">
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
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <?php if(ApercuArticle($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoArticleSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div> 
                                                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo OrdreArticle($_GET['id']); ?>" class="admin-input"> 
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
                                            <option value="1" <?php if(StatusArticle($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                            <option value="0" <?php if(StatusArticle($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                          </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Titre de la page </label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pageArticle($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Description</label>
                                        <div class="controls">
                                          <textarea name="description" class="admin-input" rows="5"><?php echo descriptionArticle($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Keywords</label>
                                        <div class="controls">
                                          <textarea name="keywords" class="admin-input" rows="5"><?php echo keywordsArticle($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                       
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=articles'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
