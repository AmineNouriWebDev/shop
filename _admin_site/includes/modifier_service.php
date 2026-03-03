<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id			        = formReception($_POST['id']);
	$titre			    = formReception($_POST['titre']);
	$titreen		    = formReception($_POST['titreen']);
	$contenu			= formReception($_POST['contenu']);
	$contenuen			= formReception($_POST['contenuen']);
	$ancre  			= formReception($_POST['ancre']);
	$ancreen			= formReception($_POST['ancreen']);
	$ordre 		        = formReception($_POST['ordre']);
	$etat 	            = formReception($_POST['etat']);
	$datec              = timestampTD(date("d/m/Y H:i:s"));
	if($_POST['lien'] != '') $lien = formReception($_POST['lien']); else $lien= nett(formReception($_POST['titre']));
	if($_POST['lienen'] != '') $lienen = formReception($_POST['lienen']); else $lienen= nett(formReception($_POST['titreen']));
		
	$requete = "UPDATE `services` SET `titre`='".$titre."',`titreen`='".$titreen."',`contenu`='".$contenu."',`contenuen`='".$contenuen."',`ancre`='".$ancre."',`ancreen`='".$ancreen."',`lien`='".$lien."',`lienen`='".$lienen."',`ordre`='".$ordre."',`etat`='".$etat."' WHERE `id`='".$id."'";
	$resultat = executeRequete($requete);
	
	if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
	
			$destination = str_replace(' ', '-',  $id."-Service-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/services/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `services` set `photo`="'. $photo .'" WHERE `id` ="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=services';
	-->
	</script>
	<?php
	//echo $strSQL;
	exit;
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Modifier service</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreService($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> 
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Titre anglais </h5>
                                        <div class="controls">
                                            <input type="text" name="titreen" value="<?php echo titreEnService($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="contenu" class="form-control" rows="5"><?php echo contenuService($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="form-group">
                                        <h5>Contenu anglais</h5>
                                        <div class="controls">
                                          <textarea id="editor11" name="contenuen" class="form-control" rows="5"><?php echo contenuEnService($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                        <?php if(ApercuService($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoServiceSite($_GET['id']); ?>" style="max-width:150px" /></div>
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
                                        <h5>Ancre</h5>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="<?php echo ancreService($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Ancre anglais</h5>
                                        <div class="controls">
                                            <input type="text" name="ancreen" value="<?php echo ancreEnService($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h5>Lien</h5>
                                                <div class="controls">
                                                    <input type="text" name="lien" value="<?php echo lienService($_GET['id']); ?>" class="form-control"> 
                                                </div>
                                            </div>
                                            <?php if(isset($_GET['admin']) && $_GET['admin'] == 'onlytech') { ?>  
                                            <div class="form-group">
                                                <h5>Lien anglais</h5>
                                                <div class="controls">
                                                    <input type="text" name="lienen" value="<?php echo lienEnService($_GET['id']); ?>" class="form-control"> 
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreService($_GET['id']); ?>" class="form-control"> 
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
                                                <option value="1" <?php if(etatService($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatService($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=services'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>