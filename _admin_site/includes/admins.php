<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerAdmin($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=admins';
	-->
	</script>
	<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                               <div class="row">
                                <div class="col-4">
                                    <h4>Liste des administrateurs</h4>
                                </div>
                                <div class="col-8 text-right mb-2">
                                    <a href="index.php?r=nadmin" class="btn btn-info">Ajouter un accès</a>
                                </div>
                                <div class="col-8 text-right">
                                    
                                </div>
                                
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nom & prénom</th>
                                                <th>Login</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `editor` ORDER BY `editor_id` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['editor_surname']).' '.afficheChamp($data['editor_name']); ?></td>
                                                <td><?php echo afficheChamp($data['editor_user_name']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=madmin&id=<?php echo afficheChamp($data['editor_id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=admins&id=<?php echo afficheChamp($data['editor_id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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