<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
    <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerIcones($_GET['id']);
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=icones';
	-->
	</script>
	<?php } ?>
                <div class="row">
				    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Liste des icones</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                        <a href="index.php?r=nicones" class="btn btn-info">Ajouter icone</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Icone</th>
                                                <th>Intitulé</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `icones` ORDER BY `id` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><img src="../<?php echo photoIcones($data['id']); ?>" style="max-width:60px"></td>
                                                <td><?php echo titreIcones($data['id']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=micones&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=icones&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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