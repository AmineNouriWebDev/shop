<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	     = formReception($_POST['id']);
	$titre  	 = formReception1($_POST['titre']);
	$idparent 	 = formReception($_POST['parent']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	$type 		 = formReception($_POST['type']);
	$titre_page  = formReception1($_POST['titre_page']);
	$keywords 	 = formReception1($_POST['keywords']);
	$description = formReception1($_POST['description']);
	if($_POST['link'] != '') $link = formReception($_POST['link']); else $link= nett(formReception($_POST['titre']));

	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
	$affichage_menu = formReception($_POST['affichage_menu']);
	
	$requete = "UPDATE `categories_blog` set `titre`='".$titre."',`link`='".$link."',`idparent`='".$idparent."',  `ordre`='".$ordre."', `type`='".$type."', `etat`='".$etat."', `affichage_menu`='".$affichage_menu."', `titre_page`='".$titre_page."',`keywords`='".$keywords."', `description`='".$description."' WHERE `id`='".$id."'";
	$resultat = executeRequete($requete);	
			
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp" ) {
			$destination = str_replace(' ', '-', $id."-categ-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination); 
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/blog/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `categories_blog` set `image`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=categories_blog';
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
										<path opacity="0.4" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8Z" />
										<path d="M11 7h2v4h4v2h-4v4h-2v-4H7v-2h4V7Z" />
									</svg>
									Modifier une catégorie
								</div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreCategBlog($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <?php if(ApercuCategBlog($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoCategBlog($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Parent</label>
											<div class="controls">
											<?php
            	                                 $req1 = 'SELECT idparent FROM `categories_blog` WHERE `id` = "'.$_GET['id'].'" ORDER BY `ordre` ASC';
            	                                 $res1 = executeRequete($req1);
												 $d	   = mysqli_fetch_array($res1);
												 
											?>
												<select name="parent" id="<?php echo $d['idparent']; ?>" class="form-control select-parent">
												
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { $idcat=$_GET['id']; ?>
													<option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `idparent` !="0" ORDER BY `ordre` ASC';
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
                                    
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>   
                                   <div class="row">
                                     <div class="col-md-7">
                                      <div class="admin-form-group">
                                        <label>Link</label>
                                        <div class="controls">
                                            <input type="text" name="link" value="<?php echo linkCategBlog($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                 <?php } ?>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo OrdreCategBlog($_GET['id']); ?>" class="admin-input"> 
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
                                                 <option value="1" <?php if(StatusCategBlog($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                 <option value="0" <?php if(StatusCategBlog($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                             </select>
                                         </div>
                                     </div>
                                      </div>
                                    <div class="col-md-6">
                                       <div class="admin-form-group">
                                         <label>Affichage menu</label>
                                         <div class="controls">
                                             <select name="affichage_menu" id="select" class="admin-input">
                                                 <option value="1" <?php if(StatusMenuCategBlog($_GET['id'])=="1") echo "selected"; ?>>Oui</option>
                                                 <option value="0" <?php if(StatusMenuCategBlog($_GET['id'])=="0") echo "selected"; ?>>Non (Catégorie Virtuelle)</option>
                                             </select>
                                         </div>
                                     </div>
                                      </div>
                                    </div> 
  
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Type</label>
                                        <div class="controls">
                                            <select name="type" id="select" class="admin-input">
                                                <option value="A" <?php if(typeCategBlog($_GET['id'])=="A") echo "selected"; ?>>Abonnement</option>
                                                <option value="E" <?php if(typeCategBlog($_GET['id'])=="E") echo "selected"; ?>>Equipement</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   
                                    
                                     <div class="admin-form-group">
                                        <label>Titre de la page </label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pageCategBlog($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Description</label>
                                        <div class="controls">
                                          <textarea name="description" class="admin-input" rows="5"><?php echo descriptionCategBlog($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Keywords</label>
                                        <div class="controls">
                                          <textarea name="keywords" class="admin-input" rows="5"><?php echo keywordsCategBlog($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                                                        
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=categories_blog'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

