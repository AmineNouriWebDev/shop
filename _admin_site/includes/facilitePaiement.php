<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idpr   = $_GET['idpr'];
		supprimerfacilitePaiement($_GET['ids']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=facilitePaiement&id=<?php echo $idpr; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idproduit        = formReception($_POST['id']);
	$detail           = formReception($_POST['detail']);
	$remarque         = formReception($_POST['remarque']);
	$prix             = formReception($_POST['prix']);
    $datec            = timestampTD(date("d/m/Y H:i:s"));
	$auteur           = auteur_id();
	
		$requete = 'INSERT INTO `facilte_paiement` 
		(`idproduit`,`detail`,`remarque`,`prix`, `auteur`, `datecreation`) 
		VALUES
		("'. $idproduit .'","'. $detail .'","'. $remarque .'","'. $prix .'","'. $auteur .'", "'. $datec .'")';
		$result = executeRequete($requete);	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=facilitePaiement&id=<?php echo $idproduit; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}elseif (isset($_POST['action']) && $_POST['action'] == 'mod' ){
	$id         = formReception($_POST['id']);
	$idproduit  = formReception($_POST['idpr']);
	$detail     = formReception($_POST['detail']);
	$remarque   = formReception($_POST['remarque']);
	$prix       = formReception($_POST['prix']);
	
		$requete = 'UPDATE `facilte_paiement` SET `idproduit`="'. $idproduit .'",`detail`="'. $detail .'",`remarque`="'. $remarque .'",`prix`="'. $prix .'" WHERE id="'.$id.'"';
		$result = executeRequete($requete);	
	
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=facilitePaiement&id=<?php echo $idproduit; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">Détail paiement</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Détail</th>
                                                <th>Prix</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `facilte_paiement` WHERE `idproduit` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo $data['detail']; ?><br/><span class="badge badge-success"><?php echo $data['remarque']; ?></span></td>
                                                <td><?php echo $data['prix']; ?> DT</td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=facilitePaiement&ids=<?php echo $data['id']; ?>&idpr=<?php echo $_GET['id']; ?>&action=mod" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse"></i></a>
                                                    <a href="index.php?r=facilitePaiement&ids=<?php echo $data['id']; ?>&idpr=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="3">Aucun détail trouvé.</td>
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
                                <h4 class="card-title"><?php if(isset($_GET['action']) && $_GET['action'] == 'mod'){ ?>Modifier<?php }else{ ?>Ajouter<?php } ?>  détail paiement</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Détail paiement</h5>
                                        <div class="controls">
                                            <textarea name="detail" class="form-control"><?php echo isset($_GET['ids']) ? detailfacilitePaiement($_GET['ids']) : ''; ?></textarea>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Remarque</h5>
                                        <div class="controls">
                                            <input type="text" name="remarque" class="form-control" value="<?php echo isset($_GET['ids']) ? rqfacilitePaiement($_GET['ids']) : ''; ?>" >
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Prix</h5>
                                        <div class="controls">
                                            <input type="text" name="prix" class="form-control" value="<?php echo isset($_GET['ids']) ? prixfacilitePaiement($_GET['ids']) : ''; ?>" >
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                       <button type="submit" class="btn btn-info">Enregistrer</button>
                                       <button type="reset" class="btn btn-inverse" onclick="location.href='index.php?r=produits&start=<?php echo isset($_GET['start']) ? $_GET['start'] : ''; ?>'">Annuler</button>
                                       <?php if(isset($_GET['action']) && $_GET['action'] == 'mod'){ ?>
                                        <input type="hidden" name="id" value="<?php echo $_GET['ids']; ?>" />
                                        <input type="hidden" name="idpr" value="<?php echo $_GET['idpr']; ?>" />
                                        <input name="action" type="hidden" id="action" value="mod">
                                       <?php }else{ ?>
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                       <input name="action" type="hidden" id="action" value="ajt">
                                       <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>