<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) { 
		supprimerCategBlog($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=categories_blog';
	-->
	</script>
<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Liste des catégories du blog</h4>
                                </div>
                                <div class="col-8 text-right">
                                    <a href="index.php?r=ncategorie_blog" class="btn btn-info">Nouvelle catégorie</a>
                                </div>
                                <div class="col-8 text-right">
                                    
                                </div>
                                
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Titre</th>
                                                <th>Type</th>
                                                <th>Créée par /Date</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
										
                                        <tbody>
										
                                         <?php 
								          $requete = 'SELECT * FROM `categories_blog` WHERE `idparent`="0" ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo titreCategBlog($data['id']); ?></td>
												<td><?php if(typeCategBlog($data['id'])=="A"){ echo 'Abonnement'; }else{ echo 'Equipement'; }  ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?><br/><?php echo timestampTDtodate($data['datecreation']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mcategorie_blog&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=categoriesMarques&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter marques"> <i class="fa fa-list text-inverse mr-2"></i> </a>
                                                    <a href="index.php?r=categories_blog&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                             
                                             
                                              <?php 
								          $requete1 = 'SELECT * FROM `categories_blog` WHERE `idparent`="'.$data['id'].'" ORDER BY `ordre` ASC ';
                                          $resultat1 = executeRequete($requete1);
	                                      $num1 = mysqli_num_rows($resultat1);
		                                  if ($num1 > 0 ) { 
			                               while ($data1 = mysqli_fetch_array($resultat1))  {
								         ?>
                                            <tr>                                                
                                                <td> --- <?php echo titreCategBlog($data1['id']); ?></td>
												<td><?php if(typeCategBlog($data1['id'])=="A"){ echo 'Abonnement'; }else{ echo 'Equipement'; }  ?></td>
                                                <td><?php echo auteur_name($data1['auteur']); ?><br/><?php echo timestampTDtodate($data1['datecreation']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mcategorie_blog&id=<?php echo afficheChamp($data1['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=categoriesMarques&id=<?php echo afficheChamp($data1['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter marques"> <i class="fa fa-list text-inverse mr-2"></i> </a>
                                                    <a href="index.php?r=categories_blog&id=<?php echo afficheChamp($data1['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } ?>
                                         <?php } ?>
                                        <?php } ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>