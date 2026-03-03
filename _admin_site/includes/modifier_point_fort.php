<?php	if (isset($_GET['action']) && $_GET['action'] == 'supp_img' ) {
		supprimerPointFort($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=mpoint_fort&id=<?php echo $_GET['id']; ?>';
	-->
	</script>
	<?php
} ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	     = formReception($_POST['id']);
	$titre  	 = formReception($_POST['titre']);
	$ordre 		 = formReception($_POST['ordre']);
    $photo       = formReception($_POST['photo']);
	$etat 		 = formReception($_POST['etat']);
	
	
	    $requete = "UPDATE `points_forts` set `titre`='".$titre."',`ordre`='".$ordre."', `photo`='".$photo."', `etat`='".$etat."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);
		
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=points_forts';
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
                                <h4 class="card-title">Modifier point fort</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titrePointFort($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Icône (le code peut être récupéré <a href="https://icofont.com/icons" target="_blanck">ici</a>) </h5>
                                        <?php if(ApercuPointFort($_GET['id'])) { ?>
								         <div style="font-size: 28px"><?php echo photoPointFortSite($_GET['id']); ?></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="text" name="photo" class="form-control" value="<?php echo ApercuPointFort($_GET['id']);?>"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                   
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo OrdrePointFort($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat</h5>
                                        <div class="controls">
                                            <select name="select" id="select" class="form-control">
                                                <option value="1" <?php if(StatutPointFort($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(StatutPointFort($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>                                   
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=points_forts'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
