
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
                                        <!-- DataTables will populate this table via AJAX from arrays.php -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th width="40%">Produit</th>
                                                <th>Prix vente</th>
                                                <th>Catégorie</th>
                                                <th>Marque</th>
                                                <th>Type</th>
                                                <th>Créée par /Date</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>