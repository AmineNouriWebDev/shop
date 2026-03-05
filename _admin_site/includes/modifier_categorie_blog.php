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
	
	$requete = "UPDATE `categories_blog` set `titre`='".$titre."',`link`='".$link."',`idparent`='".$idparent."',  `ordre`='".$ordre."', `type`='".$type."', `etat`='".$etat."', `titre_page`='".$titre_page."',`keywords`='".$keywords."', `description`='".$description."' WHERE `id`='".$id."'";
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
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Modifier une catégorie</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreCategBlog($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuCategBlog($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoCategBlog($_GET['id']); ?>" style="max-width:150px" /></div>
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
											<h5>Parent</h5>
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
                                      <div class="form-group">
                                        <h5>Link</h5>
                                        <div class="controls">
                                            <input type="text" name="link" value="<?php echo linkCategBlog($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                 <?php } ?>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo OrdreCategBlog($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(StatusCategBlog($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatusCategBlog($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
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
                                            <select name="type" id="select" class="form-control">
                                                <option value="A" <?php if(typeCategBlog($_GET['id'])=="A") echo "selected"; ?>>Abonnement</option>
                                                <option value="E" <?php if(typeCategBlog($_GET['id'])=="E") echo "selected"; ?>>Equipement</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   
                                    
                                     <div class="form-group">
                                        <h5>Titre de la page </h5>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pageCategBlog($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Description</h5>
                                        <div class="controls">
                                          <textarea name="description" class="form-control" rows="5"><?php echo descriptionCategBlog($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                        
                                    <div class="form-group">
                                        <h5>Keywords</h5>
                                        <div class="controls">
                                          <textarea name="keywords" class="form-control" rows="5"><?php echo keywordsCategBlog($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                                                                                        
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=categories_blog'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
