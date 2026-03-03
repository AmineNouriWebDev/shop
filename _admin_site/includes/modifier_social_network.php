<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<style>
#input_icone, #input_image{ display:none; }
</style>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	     = formReception($_POST['id']);
	$titre  	 = formReception($_POST['titre']);
	$lien    	 = formReception($_POST['lien']);
	$type    	 = formReception($_POST['type']);
    if (isset($_POST['icone']) && $_POST['icone'] != '') { $icone  = formReception($_POST['icone']); } else { $icone =""; }
	$ordre 		 = formReception($_POST['ordre']);
	$etat 		 = formReception($_POST['etat']);
	
	     $requete = "UPDATE `social_network` set `titre`='".$titre."', `lien`='".$lien."', `ordre`='".$ordre."', `etat`='".$etat."',`icone`='".$icone."',`type`='".$type."' WHERE `id`='".$id."'";
		 $result  = executeRequete($requete);
		
		if (isset($_FILES['photo']) && $_FILES['photo']['type'] != '') {
		 if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" ) {
			$destination = str_replace(' ', '-', $id."-social-".$_FILES['photo']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['photo']['tmp_name'], "../media/social_network/".$destination);
			$photo = $destination;
			$requete1 = 'UPDATE `social_network` set `image`="'. $photo .'" WHERE `id`="'.$id.'"';
			$result1 = executeRequete($requete1);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=social_network';
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
                                <h4 class="card-title">Modifier</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreSocialNetwork($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Lien</h5>
                                        <div class="controls">
                                            <input type="text" name="lien" value="<?php echo lienSocialNetwork($_GET['id']); ?>" class="form-control"> </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Type</h5>
                                        <div class="controls">
                                            <select name="type" id="select" class="form-control" onchange="showInput(this)">
                                              <option value="">-- Sélectionnez  --</option>
                                              <option value="1" <?php if(typeSocialNetwork($_GET['id'])== '1') { ?>selected="selected"<?php } ?>>Icône</option>
                                              <option value="2" <?php if(typeSocialNetwork($_GET['id'])== '2') { ?>selected="selected"<?php } ?>>Image</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <span id="input_icone"  <?php if(typeSocialNetwork($_GET['id'])== '1') { ?>style="display:block;"<?php } ?>>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Icone</h5>
                                       
                                        <div class="controls">
                                            <input type="text" name="icone" class="form-control" value="<?php echo iconeSocialNetwork($_GET['id']); ?>"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    </span>
                                    
                                    <span id="input_image" <?php if(typeSocialNetwork($_GET['id'])== '2') { ?>style="display:block;"<?php } ?>>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Image</h5>
                                         <?php if(ApercuSocialNetwork($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoSocialNetworkSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photo" class="form-control" value=""> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    </span>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="form-group">
                                        <h5>Ordre</h5>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreSocialNetwork($_GET['id']); ?>" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <h5>Etat <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="etat" id="select" class="form-control">
                                                <option value="1" <?php if(etatSocialNetwork($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(etatSocialNetwork($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>   
                                                                                                        
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=social_network'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                function showInput(select){
                   if(select.value==1){
                    document.getElementById('input_icone').style.display = "block";
                    document.getElementById('input_image').style.display = "none";
                   } else if(select.value==2){
                    document.getElementById('input_image').style.display = "block";
                    document.getElementById('input_icone').style.display = "none";
                   } else {
                	 document.getElementById('input_image').style.display = "none";
                	 document.getElementById('input_icone').style.display = "none";
                   }
                } 
                </script>