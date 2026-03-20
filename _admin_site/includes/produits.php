
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
                        <div class="admin-card">
                            <div class="admin-card-header">
								<div class="admin-card-title">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
										<path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
									</svg>
									Gestion des produits
								</div>
								<a href="index.php?r=nproduits" class="admin-btn admin-btn-primary">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
										<path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
									</svg>
									Nouveau produit
								</a>
                            </div>
                            <div class="admin-card-body">
                                <!-- ZONE FILTRES -->
								<div class="admin-card" style="margin-bottom: 2rem; background: var(--color-bg-secondary); border: 1px dashed var(--color-border); box-shadow: none;">
									<div class="admin-card-body" style="padding: 1rem;">
										<div style="font-size: 0.8125rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Filtres de recherche</div>
										<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
											<div class="admin-form-group" style="margin-bottom: 0;">
												<label for="searchByTitle">Titre</label>
												<input type="text" id="searchByTitle" name="titre" placeholder="Entrer un titre" class="admin-input">
											</div>
											<div class="admin-form-group" style="margin-bottom: 0;">
												<label for="searchByCateg">Catégorie</label>
												<input type="text" id="searchByCateg" name="categorie" placeholder="Entrer une catégorie" class="admin-input">
											</div>
											<div class="admin-form-group" style="margin-bottom: 0;">
												<label for="searchByMarque">Marque</label>
												<input type="text" id="searchByMarque" name="marque" placeholder="Entrer une marque" class="admin-input">
											</div>
										</div>
									</div>
								</div>
                                <input type="hidden" id="startValue" name="startValue" value='' class="admin-input">
								
                                <div style="margin-bottom: 1.5rem;">
								    <button type="button" id="delButton" class="admin-btn admin-btn-danger delete_all">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                                          <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                        </svg>
                                        Supprimer sélection
                                    </button>
                                </div>
                                    
								<div class="table-responsive" style="overflow-x: auto;">
                                    <table id="tableProduit" class="admin-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px; text-align: center;"></th>
                                                <th width="40%">Produit</th>
                                                <th>Prix vente</th>
                                                <th>Catégorie</th>
                                                <th>Marque</th>
                                                <th>Type</th>
                                                <th>Créée par / Date</th>
                                                <th class="text-nowrap" style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- DataTables will populate this table via AJAX -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th width="40%">Produit</th>
                                                <th>Prix vente</th>
                                                <th>Catégorie</th>
                                                <th>Marque</th>
                                                <th>Type</th>
                                                <th>Créée par / Date</th>
                                                <th class="text-nowrap" style="text-align: right;">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>