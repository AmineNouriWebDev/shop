<?php
	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimeretatcommande($_GET['id']);
	
?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=etat_commandes';
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
                       <div class="col-4"><h4>États des commandes</h4></div>
                       <div class="col-8 text-right"><a href="index.php?r=netatcommande" class="btn btn-info">Ajouter etat commande</a></div>
                   </div>

                    <div class="table-responsive">
                        <table  class="table table-hover color-table info-table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="left">Etat commande</th>
									<th class="selected last">Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php		

                                $req = "SELECT * FROM `etat_commandes` ORDER BY `id`";
                                $res = executeRequete($req);
                                $total= mysqli_num_rows($res);
                                
                                while ($data = mysqli_fetch_array($res))
                                {
                                	
                                  $id= $data['id'];
                                  
                                  
                                ?>   
							    <tr>
									<td class="price"><?php echo etat_commandes($id); ?> </td>
									<td class="selected last">
									    <a href="<?php echo 'index.php?r=metatcommande&id='.$id;?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a> 
                                        <a href="<?php echo 'index.php?r=etat_commandes&id='.$id.'&amp;action=supp';?>" onclick="return confirm('Vous confirmez cette suppression ?');" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
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