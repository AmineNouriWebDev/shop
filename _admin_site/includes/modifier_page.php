<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$titre  	 = formReception($_POST['titre']);
	$titreen  	 = formReception($_POST['titreen']);
	$contenu  	 = formReception($_POST['contenu']);
	$contenuen 	 = formReception($_POST['contenuen']);
	$idparent  	 = formReception($_POST['idparent']);
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	$affichage 	 = formReception($_POST['affichage']);
	$footer 	 = formReception($_POST['footer']);
	$titre_page  = formReception($_POST['titre_page']);
	$keywords 	 = formReception($_POST['keywords']);
	$description = formReception($_POST['description']);
	$titre_pageen= formReception($_POST['titre_pageen']);
	$keywordsen	 = formReception($_POST['keywordsen']);
	$descriptionen= formReception($_POST['descriptionen']);
	$style       = formReception($_POST['style']);
	
	if($_POST['link'] != '') $link = formReception($_POST['link']); else $link= nett(formReception($_POST['titre']));
	if($_POST['linken'] != '') $linken = formReception($_POST['linken']); else $linken= nett(formReception($_POST['titreen']));
	$link_externe = formReception($_POST['link_externe']);
	$id			        = formReception($_POST['id']);	
	
	if($footer == 1) {
	$requete = "SELECT * FROM `site_menu` WHERE `affichage_footer` = '1' AND `id` !='".$id."'";
	$resultat = executeRequete($requete);
	$num_footer = mysqli_num_rows($resultat);
	if($num_footer > 4) {
		$footer = 0;
	 } else {
		$footer = 1;
	 }
	}
	
		$requete = "UPDATE `site_menu` set `titre`='".$titre."', `titreen`='".$titreen."',`style`='".$style."', `contenu`='".$contenu."',`link_externe`='".$link_externe."',
		`contenuen`='".$contenuen."', `idparent`='".$idparent."', `ordre`='".$ordre."',`etat`='".$etat."', `affichage_menu`='".$affichage."', `affichage_footer`='".$footer."',
		`link`='".$link."', `linken`='".$linken."', `titre_page`='".$titre_page."',`titre_pageen`='".$titre_pageen."', `keywords`='".$keywords."', `keywordsen`='".$keywordsen."',
		`description`='".$description."' ,`descriptionen`='".$descriptionen."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-', $id."-banniere-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/pages/".$destination);
			$photo = $destination;
			$requete1 = 'UPDATE `site_menu` set `image`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result1 = executeRequete($requete1);	
		}
		}
		
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=pages';
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
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    Modifier une page
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titrePage($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Titre anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="<?php echo titrePageEn($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Niveau <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select name="idparent" id="select" required class="admin-input">
                                                <option value="0">-- Racine  --</option>
                                                 <?php
            	                                 $req = 'SELECT * FROM `site_menu` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
            	                                    <option value="<?php echo $data['id']; ?>" <?php if($data['id'] == parentPage($_GET['id']))  echo "selected"; ?>><?php echo afficheChamp($data['titre']); ?></option>
                                                     <?php
            	                                      $req1 = 'SELECT * FROM `site_menu` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
            	                                      $res1 = executeRequete($req1);
            	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
            	                                      <option value="<?php echo $data1['id']; ?>" <?php if($data1['id'] == parentPage($_GET['id']))  echo "selected"; ?>>--> <?php echo afficheChamp($data1['titre']); ?></option>
            	                                      <?php } ?>
            	                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Affichage menu:</label>
                                                <fieldset class="controls">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="1" name="affichage" id="styled_radio1" class="custom-control-input" <?php if(affichage_menuPage($_GET['id']) ==1)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="affichage" id="styled_radio2" class="custom-control-input"  <?php if(affichage_menuPage($_GET['id']) ==0)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Affichage footer:</label>
                                                <fieldset class="controls">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="1" name="footer" id="styled_radio1" class="custom-control-input" <?php if(affichage_footerPage($_GET['id']) ==1)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Oui</span> </label>
                                                </fieldset>
                                                <fieldset>
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" value="0" name="footer" id="styled_radio2" class="custom-control-input"  <?php if(affichage_footerPage($_GET['id']) ==0)  echo "checked"; ?>> <span class="custom-control-indicator"></span> <span class="custom-control-description">Non</span> </label>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordrePage($_GET['id']); ?>" class="admin-input"> 
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
                                                <option value="1" <?php if(etatPage($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatPage($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="admin-input" rows="5"><?php echo contenuPage($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Contenu anglais</label>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenuen" class="admin-input" rows="5"><?php echo contenuPageEn($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-7">
                                      <div class="admin-form-group">
                                        <label>Permalink</label>
                                        <div class="controls">
                                            <input type="text" name="link" value="<?php echo linkPage($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div> 
                                   <div class="row">
                                     <div class="col-md-7">
                                      <div class="admin-form-group">
                                        <label>Lien externe</label>
                                        <div class="controls">
                                            <input type="text" name="link_externe" value="<?php echo link_externePage($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Style</label>
                                        <div class="controls">
                                          <textarea name="style" class="admin-input" rows="2"><?php echo stylePage($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Titre de la page </label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titre_pagePage($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Titre anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titre_pageen" value="<?php echo titre_pagePageEn($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="admin-form-group">
                                        <label>Description</label>
                                        <div class="controls">
                                          <textarea name="description" class="admin-input" rows="5"><?php echo descriptionPage($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Description anglais</label>
                                        <div class="controls">
                                          <textarea name="descriptionen" class="admin-input" rows="5"><?php echo descriptionPageEn($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                   
                                    <div class="admin-form-group">
                                        <label>Keywords</label>
                                        <div class="controls">
                                          <textarea name="keywords" class="admin-input" rows="5"><?php echo keywordsPage($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="admin-form-group">
                                        <label>Keywords anglais</label>
                                        <div class="controls">
                                          <textarea name="keywordsen" class="admin-input" rows="5"><?php echo keywordsPageEn($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <?php if(ApercuPage($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoPageSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=pages'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
