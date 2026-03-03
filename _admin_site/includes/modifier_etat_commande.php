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
	
	?>
	<script language="javascript">
	<!--
		alert('<?php echo $msg;?>');
		window.location = 'index.php?r=etat_commandes';
	-->
	</script>
	<?php
	exit;	
}
?>

    <div class="row">
		<div class="col-12">
            <div class="card">
                <div class="card-body">
					<h4>Modifier état </h4>
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
									<input type="text" id="input-small" name="etat" class="form-control" value="<?php echo etat_commandes($id); ?>" />
								</div>
							</div>
							
                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-info">Enregistrer</button>
                                <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=etat_commandes'">Annuler</button>
								<input type="hidden" name="action" value="mod" />
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
					</form>
				</div>
            </div>
		</div>
	</div>