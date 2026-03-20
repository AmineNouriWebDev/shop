<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerApplications($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=applications';
	-->
	</script>
	<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <h4>Liste des applications</h4>
                                    </div>
                                    <div class="col-8 text-right">
                                        <a href="index.php?r=napplications" class="btn btn-info">Ajouter application</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tableG" class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #1976d2;">Image</th>
                                                <th style="background-color: #1976d2;">Nom</th>
                                                <th class="text-nowrap" style="background-color: #1976d2;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `applications` ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><span class="apercup"><img src="../<?php echo ImageApplications($data['id']); ?>" class="img-fluid" style="max-width:100px" /></span></td>
                                                <td><?php echo nomApplications($data['id']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mapplications&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=applications&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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