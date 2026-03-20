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
	phpToastRedirect("Modèle modifié avec succès.", "index.php?r=templatesemail", "success");
    exit;
}
?>
                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Modifier un modèle email
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="sujet" value="<?php echo sujetEmail($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="message" class="admin-input" rows="5"><?php echo messageEmail($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email d'envoi <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="email_envoi" value="<?php echo envoiEmail($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                                                        
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=templatesemail'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
