<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerFraisLivraison($_GET['id']);
	
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

                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Tranches frais livraison</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                        <a class="btn btn-info" href="index.php?r=nfraislivraison">Ajouter une tranche</a>
                                    </div>
                                </div>
                                
					                <!-- debut table -->
					
                                    <div class="table-responsive">
                                        <table id="table" class="table color-table info-table table-bordered">
											<thead>
												<tr>
													<th>Tranches</th>
													<th>Frais</th>
													<th class="selected last">Actions</th>
												</tr>
											</thead>
											<tbody>
											<?php		
											$req = "SELECT * FROM `frais_livraison` ORDER BY `id`";
											$res = executeRequete($req);
											$numres = mysqli_num_rows($res);
											while ($data = mysqli_fetch_array($res))
											{
												
											  $id=afficheChamp($data['id']);
											?>   
												<tr>
													<td class="title"><?php echo trancheFraisLivraison($id);?></td>
													<td class="title"><?php echo valeurFraisLivraison($id);?> DT</td>
													<td class="text-nowrap">
                                                        <a href="index.php?r=mfraislivraison&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                        <a href="index.php?r=fraislivraison&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                    </td>
                                                </tr>
												
                                                <?php } ?>
            								
            							    </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>