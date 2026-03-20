<head>
    <style>
        .detail-table img{max-height:200px;width:100%;object-fit:contain;}
    </style>
</head>
<!-- ============================================================== -->
                <!-- Start Page Content -->
<!-- ============================================================== -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		$idpr   = $_GET['idpr'];
		supprimerFichesTechniques($_GET['ids']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=fichesTechniques&id=<?php echo $idpr; ?>';
	-->
	</script>
	<?php } ?>
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	$idproduit        = formReception($_POST['id']);
	$detail           = formReception($_POST['detail']);
    $datec            = timestampTD(date("d/m/Y H:i:s"));
	$auteur           = auteur_id();
	
		$requete = 'INSERT INTO `fichestechniques` (`idproduit`,`detail`, `auteur`, `datecreation`) VALUES ("'. $idproduit .'","'. $detail .'","'. $auteur .'", "'. $datec .'")';
		//echo $requete; exit;
		
		$connexion=ouvrirCnx() or die("erreur cnx");
		$result  = mysqli_query($connexion, $requete);	
		$idp     = mysqli_insert_id($connexion);
		
	if (isset($_FILES['fiche']) && $_FILES['fiche']['type'] != '') {
		if ($_FILES['fiche']['type']=="application/pdf" || $_FILES['fiche']['type']=="image/jpeg" || $_FILES['fiche']['type']=="image/gif"  ){
			$destination = str_replace(' ', '-', $idp."-".$idproduit."-".$_FILES['fiche']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['fiche']['tmp_name'], "../media/fiches_techniques/".$destination);
			$fiche = $destination;
			$requete = 'UPDATE `fichestechniques` set `fiche`="'. $fiche .'"  WHERE `id`="'.$idp.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=fichesTechniques&id=<?php echo $idproduit; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}elseif (isset($_POST['action']) && $_POST['action'] == 'mod' ){
	$id         = formReception($_POST['id']);
	$idproduit  = formReception($_POST['idpr']);
	$detail     = formReception($_POST['detail']);
	
		$requete = 'UPDATE `fichestechniques` SET `idproduit`="'. $idproduit .'",`detail`="'. $detail .'" WHERE id="'.$id.'"';
		$result = executeRequete($requete);	
		
	if (isset($_FILES['fiche']) && $_FILES['fiche']['type'] != '') {
		if ($_FILES['fiche']['type']=="application/pdf" || $_FILES['fiche']['type']=="image/jpeg" || $_FILES['fiche']['type']=="image/gif"  ){
			$destination = str_replace(' ', '-', $id."-".$idproduit."-".$_FILES['fiche']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['fiche']['tmp_name'], "../media/fiches_techniques/".$destination);
			$fiche = $destination;
			$requete = 'UPDATE `fichestechniques` set `fiche`="'. $fiche .'"  WHERE `id`="'.$id.'"';
			$result = executeRequete($requete);	
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=fichesTechniques&id=<?php echo $idproduit; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">Fiches techniques</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Vignette</th>
                                                <th>Détail</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `fichestechniques` WHERE `idproduit` ="'.$_GET['id'].'"';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php if(fichesTechniquesSite($data['id'])){ ?><span class="apercup"><embed src="<?php echo fichesTechniquesSite($data['id']); ?>" width=200 height=150 type='application/pdf' /></span><?php } ?> </td>
                                                <td class="detail-table"><?php echo $data['detail']; ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=fichesTechniques&ids=<?php echo $data['id']; ?>&idpr=<?php echo $_GET['id']; ?>&action=mod" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse"></i></a>
                                                    <a href="index.php?r=fichesTechniques&ids=<?php echo $data['id']; ?>&idpr=<?php echo $_GET['id']; ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                          <td colspan="3">Aucune fiche trouvée .</td>
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
                                <h4 class="card-title"><?php if(isset($_GET['action']) && $_GET['action'] == 'mod'){ ?>Modifier<?php }else{ ?>Ajouter<?php } ?>  fiche technique</h4>
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="form-group">
                                        <h5>Fiche technique</h5>
                                        <div class="controls">
                                            <input type="file" name="fiche" class="form-control"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-12">
                                      <div class="form-group">
                                        <h5>Détail Fiche technique</h5>
                                        <div class="controls">
                                            <textarea id="editor1" name="detail" class="form-control"><?php echo isset($_GET['ids']) ? detailfichesTechniques($_GET['ids']) : ''; ?></textarea>
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