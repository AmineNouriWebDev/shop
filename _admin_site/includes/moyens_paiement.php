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
                        <div class="card">
                            <div class="card-body">
                                                         
                             <div class="row">
                                <div class="col-4">
                                    <h4>Moyen de paiement</h4>
                                </div>
                                <div class="col-8 text-right">
                                    <a href="index.php?r=nmoyenpaiement" class="btn btn-info">Nouvelle moyen</a>
                                </div>
                                <div class="col-8 text-right"></div>
                                
                                </div>
                                <div class="table-responsive">
                                    <table class="table color-table info-table table-bordered">
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
                                                    
                                                    <a href="<?php echo 'index.php?r=moyens_paiement&id='.$id.'&amp;action=supp';?>" data-toggle="tooltip" data-original-title="Supprimer"  onclick="return confirm('Vous confirmez cette suppression ?');"> <i class="fa fa-close text-danger"></i></a> 
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