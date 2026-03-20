<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
 <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerClient($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=clients';
	-->
	</script>
	<?php } ?>
                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    Liste des clients
                                </div>
                                <div class="admin-card-actions">
                                    <a href="index.php?r=nclient" class="admin-btn admin-btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.25rem; height:1.25rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Nouveau client
                                    </a>
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table id="myTableClient" class="admin-table" cellspacing="0" width="100%">
                                         <thead>
                                             <tr>
                                                 <th>Nom & prénom</th>
                                                 <th>Coordonnées</th>
                                                 <th>Inscription</th>
                                                 <th>Dernière Commande</th>
                                                 <th class="text-nowrap">Actions</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                         <?php
                                         include("includes/pagination_ui.php");

                                         $itemsPerPage = 20;
                                         $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
                                         if ($currentPage < 1) $currentPage = 1;
                                         $offset = ($currentPage - 1) * $itemsPerPage;

                                         $countReq = 'SELECT COUNT(*) as total FROM `clients`';
                                         $countRes = executeRequete($countReq);
                                         $countData = mysqli_fetch_array($countRes);
                                         $totalItems = $countData['total'];
                                         $totalPages = ceil($totalItems / $itemsPerPage);

                                         $req = 'SELECT c.*, (SELECT code FROM `commandes` WHERE `idclient` = c.id ORDER BY id DESC LIMIT 1) as last_cmd FROM `clients` c ORDER BY `date_creation` DESC LIMIT ' . $itemsPerPage . ' OFFSET ' . $offset;
                                         $res = executeRequete($req);
                                         $numres = mysqli_num_rows($res); 
                                         
                                         if ($numres > 0 ) {    
                                         while ($data = mysqli_fetch_array($res))
                                         {
                                         ?>
                                             <tr>
                                                 <td>
                                                     <div class="font-bold text-primary"><?php echo afficheChamp($data['prenom']).' '.afficheChamp($data['nom']); ?></div>
                                                 </td>
                                                 <td>
                                                     <div class="text-sm space-y-1">
                                                         <?php if(afficheChamp($data['adresse'])!=""){ ?>
                                                            <div class="flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 opacity-50">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                                </svg>
                                                                <?php echo afficheChamp($data['adresse']); ?>
                                                            </div>
                                                         <?php } ?>
                                                         <?php if(afficheChamp($data['tel'])!=""){ ?>
                                                            <div class="flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 opacity-50">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                                                </svg>
                                                                <?php echo afficheChamp($data['tel']); ?>
                                                            </div>
                                                         <?php } ?>
                                                         <?php if(afficheChamp($data['email'])!=""){ ?>
                                                            <div class="flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 opacity-50">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                                </svg>
                                                                <?php echo afficheChamp($data['email']); ?>
                                                            </div>
                                                         <?php } ?>
                                                     </div>
                                                 </td>
                                                 <td><span class="status-badge status-badge-info"><?php echo timestampTDtodate($data['date_creation']); ?></span></td>
                                                 <td class="text-nowrap"><?php echo $data['last_cmd'] ? '<span class="status-badge status-badge-success">#' . afficheChamp($data['last_cmd']) . '</span>' : '<span class="opacity-40 italic text-sm">Aucune</span>'; ?></td>
                                                 <td class="text-nowrap">
                                                     <div class="action-buttons">
                                                        <a href="index.php?r=mclient&id=<?php echo afficheChamp($data['id']); ?>" class="action-btn edit-btn" data-tippy-content="Modifier">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <a href="index.php?r=commandes&id=<?php echo afficheChamp($data['id']); ?>" class="action-btn view-btn" data-tippy-content="Commandes">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                            </svg>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=clients&id=<?php echo afficheChamp($data['id']); ?>&action=supp')" class="action-btn delete-btn" data-tippy-content="Supprimer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </a>
                                                     </div>
                                                 </td>
                                             </tr>
                                          <?php } } ?>

                                         </tbody>
                                         <tfoot>
                                             <tr>
                                                 <td colspan="5">
                                                     <div class="mt-4">
                                                        <?php renderPagination($currentPage, $totalPages, 'index.php?r=clients'); ?>
                                                     </div>
                                                 </td>
                                             </tr>
                                         </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
