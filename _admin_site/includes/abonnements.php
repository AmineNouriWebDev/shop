<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerAbonnements($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=abonnements';
	-->
	</script>
	<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
								<div class="row">
									<div class="col-4">
										<h4>Abonnements</h4>
									</div>
									<div class="col-8 text-right">
										<a href="index.php?r=nabonnements" class="btn btn-info">Nouveau abonnement</a>
									</div>
                                  
									<div class="col-12">
										<form method="post" enctype="multipart/form-data" novalidate="novalidate" style="margin-top:30px;margin-bottom:30px;">
											<div class="form-group">
												<h5>Catégorie</h5>
												<div class="controls">
													<input type="text" name="categorie" value="" class="form-control"> 
												</div>
											</div>
											<div class="text-xs-right">
												<button type="submit" class="btn btn-info">Rechercher</button>
											</div>
										</form>
									</div>   
                                
                                </div>
                                <div class="table-responsive">
                                    <table  id="tableProduit" class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #1976d2;">Abonnement</th>
                                                <th style="background-color: #1976d2;">Prix vente</th>
                                                <th style="background-color: #1976d2;">Créée par /Date</th>
                                                <th class="text-nowrap" style="background-color: #1976d2;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          if (isset($_POST['categorie']) && $_POST['categorie'] != '' ) $categ = $_POST['categorie'];
											$req = "SELECT * FROM `categories_blog`  WHERE `type`='A' AND `titre` = '".$categ."'";
											$res = executeRequete($req);
											$data1 = mysqli_fetch_array($res);
										
								          $requete = "SELECT * FROM `abonnements`  WHERE `categorie` !='' ";
										  $requete .= " AND `categorie` LIKE '%".$data1['id']."%'"; 
										  $requete .="ORDER BY `ordre` ASC ";										  
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td><?php echo afficheChamp($data['prix_vente']).' DT'; ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?><br/><?php echo timestampTDtodate($data['datecreation']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mabonnements&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=abonnements&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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