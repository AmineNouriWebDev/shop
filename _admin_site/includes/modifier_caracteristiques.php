<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	             = formReception($_POST['id']);
	$titre  	         = formReception($_POST['titre']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);	
	
	$link    		     = nett(formReception($_POST['titre']));
		$requete = "UPDATE `caracteristiques` set `titre`='".$titre."' ,`link`='".$link."' ,`ordre`='".$ordre."',`etat`='".$etat."' WHERE `id`='".$id."'";
		
		$result  = executeRequete($requete);


	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=caracteristiques';
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
                                <h4 class="card-title">Modifier une caractéristique </h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreCaracteristiques($_GET['id']);?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>         
									
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreCaracteristiques($_GET['id']);?>" class="form-control"> 
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
												<option value="1" <?php if(statusCaracteristiques($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
												<option value="0" <?php if(statusCaracteristiques($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
											  </select>
											</div>
											</div>
										</div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=caracteristiques'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>