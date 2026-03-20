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
                        <div class="admin-card">
                            <div class="admin-card-header flex justify-between items-center">
                                <div class="admin-card-title flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    États des commandes
                                </div>
                                <a href="index.php?r=netatcommande" class="admin-btn admin-btn-primary flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Ajouter état
                                </a>
                            </div>
                            <div class="admin-card-body">

                    <div class="table-responsive">
                        <table  class="admin-table" cellspacing="0" width="100%">
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
 									<td class="text-right whitespace-nowrap">
 									    <div class="action-buttons">
 									        <a href="<?php echo 'index.php?r=metatcommande&id='.$id;?>" class="p-1 text-blue-600 hover:text-blue-900 transition-colors" title="Modifier">
 									            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
 									              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
 									            </svg>
 									        </a> 
 							        <a href="javascript:void(0);" class="p-1 text-red-600 hover:text-red-900 transition-colors" onclick="confirmGlobalDelete('<?php echo 'index.php?r=etat_commandes&id='.$id.'&amp;action=supp';?>')" title="Supprimer">
 									            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
 									              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
 									            </svg>
 									        </a>
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
