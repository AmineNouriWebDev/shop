<!-- content / right -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$etat			= formReception($_POST['etat']);

    $requete = 'INSERT INTO `etat_commandes` (`etat`) VALUES ("'. $etat .'")';
	$result  = executeRequete($requete);	

	$msg="état ajouté avec succès.";
	
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $msg;?>');
		window.location = 'index.php?r=etat_commandes';
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
					<h4>Ajouter état </h4>
					<!-- end box / title -->
					<script language="JavaScript">
                    <!--
                    function verification(form)
                    	{
                    		var f = form;
                    		
                    			if (f.etat.value == "") {
                    			alert("Veuillez entrer un etat");
                    			return false;
                    		}  
                    				
                    	}
                    -->
                    </script>

					<form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">

							<div class="form-group">
								<div class="h5">
									<h5 for="input-medium">Etat <span class="text-danger">*</span></h5>
								</div>
								<div class="controls">
									<input type="text" id="input-small" name="etat" class="form-control" value="" />
								</div>
							</div>
							
                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-info">Enregistrer</button>
                                <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=etat_commandes'">Annuler</button>
                                <input name="action" type="hidden" id="action" value="ajt">
                            </div>
					</form>
				</div>
            </div>
		</div>
	</div>