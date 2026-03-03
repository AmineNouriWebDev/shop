<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	if (isset($_POST['editor_name'])) 		{$editor_name=$_POST['editor_name'];}
	if (isset($_POST['editor_surname'])) 	{$editor_surname=$_POST['editor_surname'];}
	if (isset($_POST['editor_user_name'])) 	{$editor_user_name=$_POST['editor_user_name'];}
	if (isset($_POST['editor_pass']) && $_POST['editor_pass'] != '') 		{$editor_pass=md5($_POST['editor_pass']); $mdp = $_POST['editor_pass']; }
	if (isset($_POST['editor_email'])) 		{$editor_email=$_POST['editor_email'];}
	if (isset($_POST['editor_boutique'])) 		{$editor_boutique=$_POST['editor_boutique'];}
	
	$strSQL = "SELECT * FROM editor WHERE editor_user_name='$editor_user_name'";
		$result = executeRequete($strSQL); 
		if (mysqli_num_rows($result)==0) {
		    $editor_status = '1';
			$strSQL = "INSERT INTO editor (editor_group,editor_name,editor_surname,editor_user_name,editor_pass,editor_email,mdp,editor_status) VALUES ('$editor_group', '$editor_name', '$editor_surname', '$editor_user_name', '$editor_pass', '$editor_email', '$mdp','$editor_status')";
			$result = executeRequete($strSQL) or die("Can not insert supervisor ".mysqli_error());
			$message = 'Editeur Ajouté.';
		}	
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $message; ?>');
	window.location = 'index.php?r=admins';
	-->
	</script>
	<?php
			exit;
	
	
	//echo $strSQL;
	
}
?>    
 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter administrateur</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Prénom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_surname" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Nom <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_name" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Login <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_user_name" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Email <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="editor_email" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Mot de passe <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="password" name="editor_pass" value="" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                                                       
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=admins'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>