<!-- content / right -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$etat			= formReception($_POST['etat']);

    $requete = 'INSERT INTO `etat_commandes` (`etat`) VALUES ("'. $etat .'")';
	$result  = executeRequete($requete);	

	$msg="état ajouté avec succès.";
	phpToastRedirect($msg, 'index.php?r=etat_commandes', 'success');
}
?>

    <div class="row">
		<div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Ajouter état
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
									<input type="text" id="input-small" name="etat" class="admin-input" value="" />
								</div>
							</div>
							
                            <div class="text-xs-right">
                                <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=etat_commandes'">Annuler</button>
                                <input name="action" type="hidden" id="action" value="ajt">
                            </div>
					</form>
				</div>
            </div>
		</div>
	</div>
