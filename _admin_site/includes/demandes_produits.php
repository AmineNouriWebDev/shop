                <!-- Row -->
   <?php	
   if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
       $id = intval($_GET['id']);
       executeRequete("DELETE FROM `demandes_produits` WHERE id='$id'");
       ?>
	<script language="javascript">
		window.location = 'index.php?r=demandes_produits';
	</script>
	<?php 
    } 
    
    if (isset($_GET['action']) && $_GET['action'] == 'traite' ) {
       $id = intval($_GET['id']);
       executeRequete("UPDATE `demandes_produits` SET traite='1' WHERE id='$id'");
       ?>
	<script language="javascript">
		window.location = 'index.php?r=demandes_produits';
	</script>
	<?php 
    } 
    ?>

                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Propositions et Demandes de Produits</h4>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Recherche initiale</th>
                                                <th>Produit souhaité</th>
                                                <th>Téléphone</th>
                                                <th>État</th>
                                                <th class="text-nowrap" style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `demandes_produits` ORDER BY `id` DESC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr style="<?php echo ($data['traite'] == '0') ? 'font-weight:bold; background-color:#f8f9fa;' : ''; ?>">
                                                <td><?php echo afficheChamp($data['date_demande']); ?></td>
                                                <td><?php echo afficheChamp($data['recherche']); ?></td>
                                                <td><?php echo afficheChamp($data['nom_client']); ?></td>
                                                <td><?php echo afficheChamp($data['telephone']) ? afficheChamp($data['telephone']) : '-'; ?></td>
                                                <td>
                                                    <?php if($data['traite'] == '0'){ ?>
                                                        <span class="label label-danger">Nouveau</span>
                                                    <?php } else { ?>
                                                        <span class="label label-success">Traité</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-nowrap" style="text-align: right;">
                                                    <?php if($data['traite'] == '0'){ ?>
                                                    <a href="index.php?r=demandes_produits&id=<?php echo afficheChamp($data['id']); ?>&action=traite" class="btn btn-sm btn-success text-white" data-toggle="tooltip" data-original-title="Marquer comme traité" style="padding:4px 8px; font-size:12px;"> <i class="fa fa-check"></i> Traité</a>
                                                    <?php } ?>
                                                    <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=demandes_produits&id=<?php echo afficheChamp($data['id']); ?>&action=supp')" class="btn btn-sm btn-danger text-white" data-toggle="tooltip" data-original-title="Supprimer" style="padding:4px 8px; font-size:12px; margin-left: 5px;"> <i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
