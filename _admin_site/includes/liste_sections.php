<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
    <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerListeSection($_GET['id']);
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=listeSection';
	-->
	</script>
	<?php } ?>
                <div class="row">
				    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Liste sections</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                        <a href="index.php?r=nlisteSection" class="btn btn-info">Ajouter section</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Intitulé</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `liste_sections` ORDER BY `id` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mlisteSection&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=listeSection&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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