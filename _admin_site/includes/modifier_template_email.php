<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$sujet  	 = formReception($_POST['sujet']);
    $message       = formReception($_POST['message']);
    $email_envoi       = formReception($_POST['email_envoi']);
	$id = formReception($_POST['id']);

	$requete = "UPDATE `templates_email` set `sujet`='".$sujet."',`message`='".$message."',`email_envoi`='".$email_envoi."' WHERE `id`='".$id."'";
		$result  = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=templatesemail';
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
                                <h4 class="card-title">Modifier un modèle email</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <h5>Titre <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="sujet" value="<?php echo sujetEmail($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h5>Contenu</h5>
                                        <div class="controls">
                                          <textarea id="editor1" name="message" class="form-control" rows="5"><?php echo messageEmail($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Email d'envoi <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="email_envoi" value="<?php echo envoiEmail($_GET['id']); ?>" class="form-control" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                                                        
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                        <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=templatesemail'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>