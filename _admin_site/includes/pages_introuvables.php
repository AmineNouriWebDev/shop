<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		
		executeRequete("DELETE FROM `pages_introuvables` WHERE `id` = '".$_GET['id']."'");
	
?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=pagesIntrouvables';
	-->
	</script>
	<?php
			
	exit;
	
	//echo $strSQL;
	
}
?>

                <div class="row">
				    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Pages introuvables</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                    </div>
                                </div>
                                
					                <!-- debut table -->
					
                                    <div class="table-responsive">
                                        <table id="table" class="table color-table info-table table-bordered">
											<thead>
												<tr>
													<th>URL page</th>
													<th>Date</th>
													<th class="selected last">Actions</th>
												</tr>
											</thead>
											<tbody>
											<?php		
											$req = "SELECT * FROM `pages_introuvables` ORDER BY `id` DESC";
											$res = executeRequete($req);
											$numres = mysqli_num_rows($res);
											while ($data = mysqli_fetch_array($res))
											{
												
											  $id=afficheChamp($data['id']);
											?>   
												<tr>
													<td class="title"><?php echo afficheChamp($data['url_page']);?></td>
													<td class="title"><?php echo timestampTDtodate($data['date']);?></td>
													<td class="text-nowrap">
                                                        <a href="index.php?r=pagesIntrouvables&id=<?php echo afficheChamp($data['id']); ?>&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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