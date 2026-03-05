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
                        <div class="card">
                           <div class="card-body">
                               <div class="row">
                                   <div class="col-4"><h4>Liste des clients</h4></div>
                                   <div class="col-8 text-right"><a href="index.php?r=nclient" class="btn btn-info">Nouveau client</a></div>
                               </div>
               
                                   <table  id="myTableClient" class="table table-hover table-striped color-table info-table table-bordered mt-4" cellspacing="0" width="100%">
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
                                                <td><strong><?php echo afficheChamp($data['prenom']).' '.afficheChamp($data['nom']); ?></strong></td>
                                                <td>
                                                 <?php 
                                                   if(afficheChamp($data['adresse'])!=""){ echo afficheChamp($data['adresse'])."<br />"; }
                                                   if(afficheChamp($data['tel'])!="") { echo afficheChamp($data['tel'])."<br />"; }
                                                   if(afficheChamp($data['email'])!="") { echo afficheChamp($data['email'])."<br />"; }
                                                 ?>
                                                </td>
                                                <td><?php echo timestampTDtodate($data['date_creation']); ?></td>
                                                <td class="text-nowrap"><?php echo afficheChamp($data['last_cmd']); ?></td>
                                                <td class="text-nowrap">

                                                    <a href="index.php?r=mclient&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=commandes&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Commande"> <i class="fa fa-shopping-basket text-inverse m-r-10"></i> </a>
                                                    <a href="index.php?r=clients&id=<?php echo afficheChamp($data['id']); ?>&action=supp" onclick="return confirm('Vous confirmez cette suppression ?');" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
										  <?php } } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <?php renderPagination($currentPage, $totalPages, 'index.php?r=clients'); ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>