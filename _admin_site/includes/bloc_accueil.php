<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
    <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerBloc($_GET['id']);
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=bloc_accueil';
	-->
	</script>
	<?php } ?>
                <div class="row">
				    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Bloc accueil</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                        <a href="index.php?r=nbloc_accueil" class="btn btn-info">Ajouter bloc accueil</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Intitulé</th>
                                                <th>Type bloc</th>
                                                <th>Créée par</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `bloc_accueil` ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td><?php echo titreListeSection($data['type_section']); ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mbloc_accueil&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <?php if(typeSectionBloc($data['id']) == '4'){ ?>
                                                    <a href="index.php?r=addproduits&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter produits"> <i class="fa fa-list text-inverse m-r-10"></i> </a>
                                                    <?php }else{ ?>
                                                    <a href="index.php?r=addSectionContent&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter section content"> <i class="fa fa-list text-inverse m-r-10"></i> </a>
                                                    <?php } ?>
                                                    <a href="index.php?r=bloc_accueil&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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