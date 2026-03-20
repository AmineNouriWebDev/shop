<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$titre  	         = formReception($_POST['titre']);
	$titreen 	         = formReception($_POST['titreen']);
	$contenu  	         = formReception($_POST['contenu']);
	$contenuen    	     = formReception($_POST['contenuen']);
	$titre1              = formReception($_POST['titre1']);
	$titreen1            = formReception($_POST['titreen1']);
	$titre2              = formReception($_POST['titre2']);
	$titreen2            = formReception($_POST['titreen2']);
	$titre3              = formReception($_POST['titre3']);
	$titreen3            = formReception($_POST['titreen3']);
	$rate1               = formReception($_POST['rate1']);
	$rate2               = formReception($_POST['rate2']);
	$rate3               = formReception($_POST['rate3']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$datec               = timestampTD(date("d/m/Y H:i:s"));
	$auteur              = auteur_id();
	
		$requete = 'INSERT INTO `sections` (`titre`, `titreen`, `contenu`, `contenuen`, `titre1`, `titreen1`, `titre2`, `titreen2`, `titre3`, `titreen3`, `rate1`, `rate2`, `rate3`, `ordre`, `etat`, `auteur`, `datecreation`) VALUES ("'. $titre .'","'. $titreen .'", "'. $contenu .'", "'. $contenuen .'","'. $titre1 .'","'. $titreen1 .'","'. $titre2 .'","'. $titreen2 .'","'. $titre3 .'","'. $titreen3 .'","'. $rate1 .'","'. $rate2 .'","'. $rate3 .'",  "'. $ordre .'", "'. $etat .'","'. $auteur .'", "'. $datec .'")';
		
		$result  = executeRequete($requete);	
		
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=sectionpage';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' ) {
	$idsection           = formReception($_POST['idsection']);
	$titre  	         = formReception($_POST['titre']);
	$titreen 	         = formReception($_POST['titreen']);
	$contenu  	         = formReception($_POST['contenu']);
	$contenuen    	     = formReception($_POST['contenuen']);
	$titre1              = formReception($_POST['titre1']);
	$titreen1            = formReception($_POST['titreen1']);
	$titre2              = formReception($_POST['titre2']);
	$titreen2            = formReception($_POST['titreen2']);
	$titre3              = formReception($_POST['titre3']);
	$titreen3            = formReception($_POST['titreen3']);
	$rate1               = formReception($_POST['rate1']);
	$rate2               = formReception($_POST['rate2']);
	$rate3               = formReception($_POST['rate3']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	
	$requete = "UPDATE `sections` set `titre`='".$titre."', `titreen`='".$titreen."', `contenu`='".$contenu."',`contenuen`='".$contenuen."',`titre1`='".$titre1."',`titreen1`='".$titreen1."',`titre2`='".$titre2."',`titreen2`='".$titreen2."',`titre3`='".$titre3."',`titreen3`='".$titreen3."',`rate1`='".$rate1."',`rate2`='".$rate2."',`rate3`='".$rate3."', `ordre`='".$ordre."', `etat`='".$etat."' WHERE `id`='".$idsection."'";
	$resultat = executeRequete($requete);
	
	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=sectionpage';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                                    </svg>
                                    Sections de la page
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Titre</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `sections` ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=sectionpage&id=<?php echo $_GET['id']; ?>&idsection=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=sectionpage&id=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Pas de sections pour la page <?php echo titrePage($_GET['id']); ?></td>
                                        </tr>
                                        <?php } ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-body">
                                <h4 class="card-title">
                                   <?php if(isset($_GET['idsection'])) {?>Modifier Section<?php }else { ?>
                                   Ajouter Section<?php } ?>
                                 </h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php if(isset($_GET['idsection'])) echo titreSection($_GET['idsection']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <label>Titre anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="<?php if(isset($_GET['idsection'])) echo titreEnSection($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                     <div class="form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="admin-input" rows="5"><?php if(isset($_GET['idsection'])) echo contenuSection($_GET['idsection']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <label>Contenu anglais</label>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenuen" class="admin-input" rows="5"><?php if(isset($_GET['idsection'])) echo contenuEnSection($_GET['idsection']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Titre 1 <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre1" value="<?php if(isset($_GET['idsection'])) echo titre1Section($_GET['idsection']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <label>Titre 1 anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titreen1" value="<?php if(isset($_GET['idsection'])) echo titre1EnSection($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Rate titre 1</label>
                                        <div class="controls">
                                            <input type="text" name="rate1" value="<?php if(isset($_GET['idsection'])) echo rate1Section($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Titre 2 <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre2" value="<?php if(isset($_GET['idsection'])) echo titre2Section($_GET['idsection']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <label>Titre 2 anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titreen2" value="<?php if(isset($_GET['idsection'])) echo titre2EnSection($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Rate titre 2</label>
                                        <div class="controls">
                                            <input type="text" name="rate2" value="<?php if(isset($_GET['idsection'])) echo rate2Section($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Titre 3 <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre3" value="<?php if(isset($_GET['idsection'])) echo titre3Section($_GET['idsection']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <label>Titre 3 anglais</label>
                                        <div class="controls">
                                            <input type="text" name="titreen3" value="<?php if(isset($_GET['idsection'])) echo titre3EnSection($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Rate titre 3</label>
                                        <div class="controls">
                                            <input type="text" name="rate3" value="<?php if(isset($_GET['idsection'])) echo rate3Section($_GET['idsection']); ?>" class="admin-input"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php if(isset($_GET['idsection'])){ echo OrdreSection($_GET['idsection']);}else{ echo afficheMaxOrdre('sections',1);} ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" <?php if(isset($_GET['idsection'])) {if(StatutSection($_GET['idsection'])=="1") echo "selected";} ?>>Actif</option>
                                                <option value="0" <?php if(isset($_GET['idsection'])){ if(StatutSection($_GET['idsection'])=="0") echo "selected"; }?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <?php if(isset($_GET['idsection'])) {?>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="idsection" value="<?php echo $_GET['idsection']; ?>" />
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=sectionpage&id=<?php echo $_GET['id']; ?>'">Annuler</button>
                                        <?php } else { ?>
                                        <input name="action" type="hidden" id="action" value="ajt">
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=pages'">Annuler</button>
                                        <?php } ?>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
