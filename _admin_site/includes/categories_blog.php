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
                        <div class="admin-card">
                            <div class="admin-card-header">
								<div class="admin-card-title">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path fill-rule="evenodd" d="M3 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 5.25Zm0 4.5A.75.75 0 0 1 3.75 9h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9.75Zm0 4.5a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Zm0 4.5a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
									</svg>
									Catégories du catalogue
								</div>
								<a href="index.php?r=ncategorie_blog" class="admin-btn admin-btn-primary">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
										<path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
									</svg>
									Nouvelle catégorie
								</a>
                            </div>
                            
                            <div class="admin-card-body">
                                <div class="table-responsive" style="overflow-x: auto;">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Titre de la catégorie</th>
                                                <th>Type</th>
                                                <th>Créée par / Date</th>
                                                <th class="text-nowrap" style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
										
                                        <tbody>
										
                                         <?php 
								          $requete = 'SELECT * FROM `categories_blog` WHERE `idparent`="0" ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td style="font-weight: 600; color: var(--color-primary);"><?php echo titreCategBlog($data['id']); ?></td>
												<td>
                                                    <span class="status-badge <?php echo typeCategBlog($data['id']) == 'A' ? 'confirmed' : 'pending'; ?>">
                                                        <?php echo typeCategBlog($data['id']) == 'A' ? 'Abonnement' : 'Equipement'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span style="font-weight: 500;"><?php echo auteur_name($data['auteur']); ?></span><br/>
                                                    <span style="font-size: 0.75rem; color: var(--color-text-muted);"><?php echo timestampTDtodate($data['datecreation']); ?></span>
                                                </td>
                                                <td class="text-nowrap" style="text-align: right; display: flex; justify-content: flex-end; gap: 0.25rem;">
                                                    <a href="index.php?r=mcategorie_blog&id=<?php echo afficheChamp($data['id']); ?>" data-tippy-content="Modifier" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.158 3.71 3.71 1.159-1.159a2.625 2.625 0 0 0 0-3.71ZM19.513 8.199l-3.71-3.71-12.15 12.152a3 3 0 0 0-.853 1.5l-1.09 4.364a.75.75 0 0 0 .907.908l4.365-1.09a3 3 0 0 0 1.5-.853L19.513 8.2Z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="index.php?r=categoriesMarques&id=<?php echo afficheChamp($data['id']); ?>" data-tippy-content="Associer Marques" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path fill-rule="evenodd" d="M10.5 3A1.5 1.5 0 0 0 9 4.5v6H4.5a1.5 1.5 0 0 0-1.5 1.5v6A1.5 1.5 0 0 0 4.5 19.5h6v-6h4.5a1.5 1.5 0 0 0 1.5-1.5v-6A1.5 1.5 0 0 0 15 4.5h-4.5ZM12 9V4.5H9v6h3V9ZM13.5 15v4.5h-3v-6h4.5v1.5H13.5ZM6 18v-6H4.5v6H6Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=categories_blog&id=<?php echo afficheChamp($data['id']); ?>&action=supp')" data-tippy-content="Supprimer" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none; color: var(--color-error);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.442.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                             
                                              <?php 
								          $requete1 = 'SELECT * FROM `categories_blog` WHERE `idparent`="'.$data['id'].'" ORDER BY `ordre` ASC ';
                                          $resultat1 = executeRequete($requete1);
	                                      $num1 = mysqli_num_rows($resultat1);
		                                  if ($num1 > 0) { 
			                               while ($data1 = mysqli_fetch_array($resultat1))  {
								         ?>
                                            <tr>                                                
                                                <td style="padding-left: 2rem; position: relative; font-weight: 500;">
                                                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-border-strong);">↳</span>
                                                    <?php echo titreCategBlog($data1['id']); ?>
                                                </td>
												<td>
                                                    <span class="status-badge <?php echo typeCategBlog($data1['id']) == 'A' ? 'confirmed' : 'pending'; ?>">
                                                        <?php echo typeCategBlog($data1['id']) == 'A' ? 'Abonnement' : 'Equipement'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span style="font-weight: 500;"><?php echo auteur_name($data1['auteur']); ?></span><br/>
                                                    <span style="font-size: 0.75rem; color: var(--color-text-muted);"><?php echo timestampTDtodate($data1['datecreation']); ?></span>
                                                </td>
                                                <td class="text-nowrap" style="text-align: right; display: flex; justify-content: flex-end; gap: 0.25rem;">
                                                    <a href="index.php?r=mcategorie_blog&id=<?php echo afficheChamp($data1['id']); ?>" data-tippy-content="Modifier" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.158 3.71 3.71 1.159-1.159a2.625 2.625 0 0 0 0-3.71ZM19.513 8.199l-3.71-3.71-12.15 12.152a3 3 0 0 0-.853 1.5l-1.09 4.364a.75.75 0 0 0 .907.908l4.365-1.09a3 3 0 0 0 1.5-.853L19.513 8.2Z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="index.php?r=categoriesMarques&id=<?php echo afficheChamp($data1['id']); ?>" data-tippy-content="Associer Marques" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path fill-rule="evenodd" d="M10.5 3A1.5 1.5 0 0 0 9 4.5v6H4.5a1.5 1.5 0 0 0-1.5 1.5v6A1.5 1.5 0 0 0 4.5 19.5h6v-6h4.5a1.5 1.5 0 0 0 1.5-1.5v-6A1.5 1.5 0 0 0 15 4.5h-4.5ZM12 9V4.5H9v6h3V9ZM13.5 15v4.5h-3v-6h4.5v1.5H13.5ZM6 18v-6H4.5v6H6Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=categories_blog&id=<?php echo afficheChamp($data1['id']); ?>&action=supp')" data-tippy-content="Supprimer" class="admin-btn admin-btn-sm admin-btn-ghost" style="padding: 0.4rem; border: none; color: var(--color-error);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.442.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } ?>
                                         <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="4" style="padding: 0; border: none;">
                                                    <div class="admin-empty-state">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.118 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                                        </svg>
                                                        <p style="margin:0; font-size:0.875rem;">Aucune catégorie trouvée</p>
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