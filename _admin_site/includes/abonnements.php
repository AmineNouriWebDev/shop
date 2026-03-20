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
                        <div class="admin-card">
                            <div class="admin-card-header">
								<div class="admin-card-title">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/>
									</svg>
									Gestion des abonnements
								</div>
								<a href="index.php?r=nabonnements" class="admin-btn admin-btn-primary">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
										<path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
									</svg>
									Nouvel abonnement
								</a>
                            </div>
                            
                            <div class="admin-card-body">
								<!-- ZONE FILTRE -->
								<div class="admin-card" style="margin-bottom: 2rem; background: var(--color-bg-secondary); border: 1px dashed var(--color-border); box-shadow: none;">
									<div class="admin-card-body" style="padding: 1rem;">
										<div style="font-size: 0.8125rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Filtres de recherche</div>
										<form method="post" enctype="multipart/form-data" novalidate="novalidate">
											<div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
												<div class="admin-form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
													<label>Catégorie</label>
													<input type="text" name="categorie" value="<?php echo isset($_POST['categorie']) ? htmlspecialchars($_POST['categorie']) : ''; ?>" placeholder="Saisir la catégorie..." class="admin-input"> 
												</div>
												<div style="flex-shrink: 0;">
													<button type="submit" class="admin-btn admin-btn-primary">Rechercher</button>
												</div>
											</div>
										</form>
									</div>   
								</div>
                                
                                <div class="table-responsive" style="overflow-x: auto;">
                                    <table id="tableProduit" class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Abonnement</th>
                                                <th>Prix vente</th>
                                                <th>Créée par / Date</th>
                                                <th class="text-nowrap" style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                          // Initialisation de la variable de filtre pour la catégorie
                                          $categ = '';
                                          $filtreCond = '';
                                          
								          if (isset($_POST['categorie']) && trim($_POST['categorie']) != '') {
                                              $categ = trim($_POST['categorie']);
                                            
                                              // On recherche d'abord l'ID de la catégorie dans la table categories_blog
                                              // (Attention l'ancien code cherchait par titre exact, on le maintient pour la correspondance)
                                              $reqCat = "SELECT id FROM `categories_blog` WHERE `type`='A' AND `titre` = '".addslashes($categ)."'";
                                              $resCat = executeRequete($reqCat);
                                              $dataCat = mysqli_fetch_array($resCat);
                                              
                                              if($dataCat && isset($dataCat['id'])) {
                                                  // Filtre sur l'id de catégorie renvoyé
                                                  $filtreCond = " AND `categorie` LIKE '%".$dataCat['id']."%'"; 
                                              } else {
                                                  // Force une condition fausse si la catégorie saisie n'existe pas, 
                                                  // pour ne rien renvoyer plutôt que tout.
                                                  $filtreCond = " AND 1=0";
                                              }
                                          }
										
								          $requete = "SELECT * FROM `abonnements` WHERE `categorie` != '' " . $filtreCond . " ORDER BY `ordre` ASC";
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
                                          
		                                  if ($num > 0) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td style="font-weight: 500;"><?php echo afficheChamp($data['titre']); ?></td>
                                                <td style="font-weight: 700; color: var(--color-primary);"><?php echo afficheChamp($data['prix_vente']).' DT'; ?></td>
                                                <td>
                                                    <span style="font-weight: 500;"><?php echo auteur_name($data['auteur']); ?></span><br/>
                                                    <span style="font-size: 0.75rem; color: var(--color-text-muted);"><?php echo timestampTDtodate($data['datecreation']); ?></span>
                                                </td>
                                                <td class="text-nowrap" style="text-align: right;">
                                                    <a href="index.php?r=mabonnements&id=<?php echo afficheChamp($data['id']); ?>" data-tippy-content="Modifier" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.158 3.71 3.71 1.159-1.159a2.625 2.625 0 0 0 0-3.71ZM19.513 8.199l-3.71-3.71-12.15 12.152a3 3 0 0 0-.853 1.5l-1.09 4.364a.75.75 0 0 0 .907.908l4.365-1.09a3 3 0 0 0 1.5-.853L19.513 8.2Z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="index.php?r=abonnements&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-tippy-content="Supprimer" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none; color: var(--color-error);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.442.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4" style="padding: 0; border: none;">
                                                    <div class="admin-empty-state">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        <p style="margin:0; font-size:0.875rem;">Aucun abonnement trouvé</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>