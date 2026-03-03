<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id  	     = formReception($_POST['id']);
	$prenom  	 = formReception($_POST['editor_surname']);
	$nom     	 = formReception($_POST['editor_name']);
	$login    	 = formReception($_POST['editor_user_name']);
	$mp 		 = formReception($_POST['editor_pass']);
	if($mp) $mpc = md5($mp); else $mpc ='';
	$editor_status = '1';
	$email 		 = formReception($_POST['editor_email']);
	
	     $requete = "UPDATE `editor` set `editor_user_name`='".$login."', `editor_surname`='".$prenom."', `editor_name`='".$nom."', `editor_email`='".$email."',`editor_pass`='".$mpc."',`mdp`='".$mp."',`editor_status`= '".$editor_status."' WHERE `editor_id`='".$id."'";
		//echo $requete;exit;
		 $result  = executeRequete($requete);
		
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=admins';
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
                                <h4 class="card-title">Modifier administrateur</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Prénom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_surname" value="<?php echo prenomClt($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Nom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_name" value="<?php echo nomClt($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Login <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_user_name" value="<?php echo loginClt($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Email <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_email" value="<?php echo emailClt($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Mot de passe <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="password" name="editor_pass" value="<?php echo mpClt($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                                                       
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=admins'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>