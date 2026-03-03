<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
   <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerRecherche($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=recherches';
	-->
	</script>
	<?php } ?>

                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Dernières recherches</h4>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Recherche</th>
                                                <th>Date</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `recherches` ORDER BY `date` DESC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['ville/commune']); ?></td>
                                                <td><?php echo timestamptodate(afficheChamp($data['date'])); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=recherches&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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