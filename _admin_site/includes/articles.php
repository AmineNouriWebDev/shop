<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerArticle($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=articles';
	-->
	</script>
	<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-4">
                                    <h4>Liste des articles du blog</h4>
                                </div>
                                <div class="col-8 text-right">
                                    <a href="index.php?r=ncategorie_blog" class="btn btn-info">Nouvel article</a>
                                </div>
                                <div class="col-8 text-right">
                                    
                                </div>
                                
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>titre</th>
                                                <th>Catégorie</th>
                                                <th>Créée par /Date</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `articles` ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td><?php echo titreCategBlog($data['categorie']); ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?><br/><?php echo timestampTDtodate($data['datecreation']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=marticle&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=articles&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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