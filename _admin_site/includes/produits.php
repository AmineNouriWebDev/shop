
<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerProduits($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=produits';
	-->
	</script>
	<?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="card">
                            <div class="card-body">
								<div class="row">
								
									<div class="col-4">
										<h4>Produits</h4>
									</div>
									<div class="col-8 text-right">
										<a href="index.php?r=nproduits" class="btn btn-info">Nouveau produit</a>
									</div>                               
                                </div>
                                
								<hr>
								<div class="row">
                                    <div class="col-12 mb-2">
                                        <h4 class="card-title">Filter par :</h4>
                                    </div>
                                    
                                    <div class="col-2 mb-2">
                                        <h5 class="card-title">Titre</h5>
                                    </div>
                                    <div class="col-10 mb-2">
                                        <input type="text" id="searchByTitle" name="titre" placeholder="Enter un titre" class="form-control">
                                    </div>
                                    
                                    <div class="col-2 mb-2">
                                        <h5 class="card-title">Catégorie</h5>
                                    </div>
                                    <div class="col-10 mb-2">
                                        <input type="text" id="searchByCateg" name="categorie" placeholder="Enter une catégorie" class="form-control">
                                    </div>
                                    
                                    <div class="col-2 mb-2">
                                        <h5 class="card-title">Marque</h5>
                                    </div>
                                    <div class="col-10 mb-2">
                                        <input type="text" id="searchByMarque" name="marque" placeholder="Enter une marque" class="form-control">
                                    </div>
								    
								</div>
                                <input type="hidden" id="startValue" name="startValue" value='' class="form-control">
								<hr>
								
								<button type="button" id="delButton" class="btn btn-danger delete_all" > <i class="fa fa-trash text-white"></i> Supprimer produit(s)</button>
                                
                                    
								<div class="table-responsive">
          
                                    <table  id="tableProduit" class="table color-table info-table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #1976d2;"></th>
                                                <th width="40%" style="background-color: #1976d2;">Produit</th>
                                                <th style="background-color: #1976d2;">Prix vente</th>
                                                <th style="background-color: #1976d2;">Catégorie</th>
                                                <th style="background-color: #1976d2;">Marque</th>
                                                <th style="background-color: #1976d2;">Type</th>
                                                <th style="background-color: #1976d2;">Créée par /Date</th>
                                                <th class="text-nowrap" style="background-color: #1976d2;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php   
										$req = "SELECT * FROM `produits` ORDER BY `id` DESC ";
										$res = executeRequete($req);
										$num = mysqli_num_rows($res);
										if ($num > 0 ) { 
										 while ($data = mysqli_fetch_array($res))  {
										 ?>
                                            <tr data-row-id="<?php echo afficheChamp($data['id']); ?>">
                                                <td><input type="checkbox" class="sub_chk" data-id="<?php echo afficheChamp($data['id']); ?>" style="position:relative;left:0;opacity:1"></td>
                                                <td><?php echo photoProduits($data['id']) ; echo afficheChamp($data['titre']); ?></td>
                                                <td><?php if($data['prix_promo'] != '0.000') { echo afficheChamp($data['prix_promo']).' DT <span style="text-decoration:line-through">'.afficheChamp($data['prix_vente']).' DT </span>'; }else{ echo afficheChamp($data['prix_vente']).' DT'; } ?></td>
                                                <td><?php echo titreCategBlog($data['categorie']); ?></td>
                                                <td><?php echo raisonMarque($data['marque']); ?></td>
                                                <td><?php if( afficheChamp($data['type']) == "E") echo "Equipement" ; else echo "Abonnement"; ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?><br/><?php echo timestampTDtodate($data['datecreation']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mproduits&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=produits&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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