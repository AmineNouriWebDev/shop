<!-- content / right -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
	$id			= formReception($_POST['id']);
	$min		= formReception($_POST['min']);
	$max		= formReception($_POST['max']);
	$frais		= formReception($_POST['frais']);

        $requete = 'UPDATE `frais_livraison` SET `min`="'. $min .'",`max`="'. $max .'",`frais`="'. $frais .'" WHERE `id` = "'.$id.'"';
		$result  = executeRequete($requete);	
	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=fraislivraison';
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

						        <h4>Modifier une tranche</h4>

					            <form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">
                                    <div class="form-group">
        								<div class="h5">
        									<h5 for="input-medium">Tranche *</h5>
        								</div>
        								<div class="input row">
        								 <div class="col-md-6"><h5>Min</h5><input type="text" name="min" class="form-control" required value="<?php echo minFraisLivraison($_GET['id']); ?>" /></div> 
                                         <div class="col-md-6"><h5>Max</h5> <input type="text" name="max" class="form-control" required value="<?php echo maxFraisLivraison($_GET['id']); ?>" /></div>
        								</div>
        								
        							</div>
                                    <div class="form-group">
                                        <h5>Frais </h5>
                                        <div class="controls">
                                            <input type="text" name="frais" value="<?php echo valeurFraisLivraison($_GET['id']); ?>" class="form-control">
                                        </div>
                                    </div>
                                   
        							<div class="buttons">
        								<button type="submit" name="submit" class="btn btn-info" >Enregistrer</button>
        								<button type="reset" class="btn btn-inverse"  onclick="location.href='index.php?r=fraislivraison'" >Annuler</button>
        								<input type="hidden" name="action" value="mod" />
        								<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        							</div>
        					    </form>
                            </div>
                        </div>
                    </div>
                </div>
			<!-- end content / right -->