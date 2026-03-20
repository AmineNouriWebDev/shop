
<!-- ============================================================== -->
                <!-- Start Page Content -->
                
    <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerPages($_GET['id']);
		  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=pages';
	-->
	</script>
	<?php } ?>
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
				<div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-body">
                                <h4 class="card-title">Pages</h4>
                                <div class="table-responsive">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Intitulé</th>
                                                <th>Créée par /Date</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `site_menu` WHERE `idparent`="0" ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr>
                                                <td><?php echo afficheChamp($data['titre']); ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?><br/><?php echo timestampTDtodate($data['datecreation']); ?></td>
                                                <td class="text-right">
                                                    <div class="action-buttons">
                                                        <a href="index.php?r=mpage&id=<?php echo afficheChamp($data['id']); ?>" class="p-1 text-blue-600 hover:text-blue-900 transition-colors" title="Modifier">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=pages&id=<?php echo afficheChamp($data['id']); ?>&action=supp')" class="p-1 text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                             
                                             
                                              <?php 
								          $requete1 = 'SELECT * FROM `site_menu` WHERE `idparent`="'.$data['id'].'" ORDER BY `ordre` ASC ';
                                          $resultat1 = executeRequete($requete1);
	                                      $num1 = mysqli_num_rows($resultat1);
		                                  if ($num1 > 0 ) { 
			                               while ($data1 = mysqli_fetch_array($resultat1))  {
								         ?>
                                            <tr>
                                                <td> --- <?php echo afficheChamp($data1['titre']); ?></td>
                                                <td><?php echo auteur_name($data1['auteur']); ?><br/><?php echo timestampTDtodate($data1['datecreation']); ?></td>
                                                <td class="text-right whitespace-nowrap">
                                                    <div class="action-buttons">
                                                        <a href="index.php?r=mpage&id=<?php echo afficheChamp($data1['id']); ?>" class="p-1 text-blue-600 hover:text-blue-900 transition-colors" title="Modifier">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=pages&id=<?php echo afficheChamp($data1['id']); ?>&action=supp')" class="p-1 text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </a>
                                                    </div>
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
