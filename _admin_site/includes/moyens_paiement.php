<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
  <?php if (isset($_GET['action']) && $_GET['action'] == 'supp' ) { 
		supprimermoyen_paiement($_GET['id']);
  ?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=moyens_paiement';
	-->
	</script> 
   <?php } ?>
                <div class="row">
				<div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header flex justify-between items-center">
                                <div class="admin-card-title flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 5.25v.75m0 5.25v.75m15-12v.75m0 5.25v.75m0 5.25v.75M5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H5.25a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 5.25 4.5Z" />
                                    </svg>
                                    Moyens de paiement
                                </div>
                                <a href="index.php?r=nmoyenpaiement" class="admin-btn admin-btn-primary flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Nouveau moyen
                                </a>
                            </div>
                            <div class="admin-card-body">
                                <div class="table-responsive">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Moyen de paiement</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php       
										$req = "SELECT * FROM `moyens_paiement`  WHERE `type` ='1' ORDER BY `id`";
										$res = executeRequete($req);
										$total= mysqli_num_rows($res);
										
										while ($data = mysqli_fetch_array($res))
										{										
										  $id= $data['id'];										  
										?>
											<tr>
                                                <td><?php echo moyen_paiement($data['id']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mmoyenpaiement&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    
                                                    <a href="javascript:void(0);" onclick="confirmGlobalDelete('<?php echo 'index.php?r=moyens_paiement&id='.$id.'&amp;action=supp';?>')" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a> 
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
