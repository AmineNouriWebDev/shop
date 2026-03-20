<!-- content / right -->
<?php
 if(isset($_GET['id']) && $_GET['id']!=""){
$req = "SELECT * FROM `etat_commandes` WHERE `id`='".$_GET['id']."'";
$res = executeRequete($req);
$data = mysqli_fetch_array($res);
    $id      = $data['id'];
}
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{  
	$etat   	    	= formReception($_POST['etat']);
	$id			        = formReception($_POST['id']);
	
	$verif=executeRequete("UPDATE `etat_commandes` set `etat`='".$etat."' WHERE `id`='".$id."'");
	
	$msg="Etat modifié avec succès.";
	phpToastRedirect($msg, 'index.php?r=etat_commandes', 'success');
}
?>

    <div class="row">
		<div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Modifier état
                                </div>
                            </div>
                            <div class="admin-card-body">
					<!-- end box / title -->
					<script language="JavaScript">
                    <!--
                    function verification(form)
                    	{
                    		var f = form;
                    		
                    			if (f.etat.value == "") {
                    			showToast("Veuillez entrer un état", "error");
                    			return false;
                    		}  
                    				
                    	}
                    -->
                    </script>

					<form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">

							<div class="form-group">
								<label>Etat <span class="text-danger">*</span></label>
								<div class="controls">
									<input type="text" id="input-small" name="etat" class="admin-input" value="<?php echo etat_commandes($id); ?>" />
								</div>
							</div>
							
                            <div class="text-xs-right">
                                <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=etat_commandes'">Annuler</button>
								<input type="hidden" name="action" value="mod" />
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
					</form>
				</div>
            </div>
		</div>
	</div>
