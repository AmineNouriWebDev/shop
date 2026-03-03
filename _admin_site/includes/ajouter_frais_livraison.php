<!-- content / right -->
<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajt' )
{
	$min			= formReception($_POST['min']);
	$max			= formReception($_POST['max']);
	$frais			= formReception($_POST['frais']);

        $requete = 'INSERT INTO `frais_livraison` (`min`,`max`,`frais`) VALUES ("'. $min .'","'. $max .'","'. $frais .'")';
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

						        <h4>Ajouter une tranche</h4>

					            <form action="" method="post" onSubmit="return verification(this)" enctype="multipart/form-data">
                                    <div class="form-group">
        								<div class="h5">
        									<h5 for="input-medium">Tranche *</h5>
        								</div>
        								<div class="input row">
        								 <div class="col-md-6"><h5>Min</h5><input type="text" name="min" class="form-control" required value="" /></div> 
                                         <div class="col-md-6"><h5>Max</h5> <input type="text" name="max" class="form-control" required value="" /></div>
        								</div>
        								
        							</div>
                                    <div class="form-group">
                                        <h5>Frais </h5>
                                        <div class="controls">
                                            <input type="text" name="frais" value="" class="form-control">
                                        </div>
                                    </div>
                                   
        							<div class="buttons">
        								<button type="submit" name="submit" class="btn btn-info" >Enregistrer</button>
        								<button type="reset" class="btn btn-inverse"  onclick="location.href='index.php?r=fraislivraison'" >Annuler</button>
        								<input type="hidden" name="action" value="ajt" />
        							</div>
        					    </form>
                            </div>
                        </div>
                    </div>
                </div>
			<!-- end content / right -->