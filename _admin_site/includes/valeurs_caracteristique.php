<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idc   = $_GET['idc'];
		executeRequete("DELETE DELETE FROM `valeur_caracteristique` WHERE id = '".$_GET['idv']."'");
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=valeurcaracteristiques&id=<?php echo $idc; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idcarac   = formReception($_POST['id']);
	$valeur    = formReception($_POST['valeur']);
	
		$requete = 'INSERT INTO `valeur_caracteristique` (`idcarac`,`valeur`) VALUES ("'. $idcarac .'","'. $valeur .'")';
		
		$result = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=valeurcaracteristiques&id=<?php echo $idcarac; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">Valeurs</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>valeur</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `valeur_caracteristique` WHERE `idcarac` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['valeur']); ?></td>
                                                <td class="text-nowrap">
                                                  <a href="index.php?r=valeurcaracteristiques&idv=<?php echo $data['id']; ?>&idc=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="2">Aucun valeur trouvé.</td>
                                        </tr>
                                        <?php } ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter valeur</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Valeur </h5>
                                        <div class="controls">
                                            <input type="text" name="valeur" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <input name="action" type="hidden" id="action" value="ajt">
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=caracteristiques'">Annuler</button>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>