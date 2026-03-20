<!-- ============================================================== -->
                <!-- Start Page Content -->
             <!-- ============================================================== -->
                <!-- Row -->
    <?php	if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
		supprimerBloc($_GET['id']);
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=bloc_accueil';
	-->
	</script>
	<?php } ?>
                <div class="row">
				    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-body">
                                
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <h4 class="card-title">Bloc accueil</h4>
                                    </div>
                                    <div class="col-8 text-right mb-2">
                                        <a href="index.php?r=nbloc_accueil" class="admin-btn admin-btn-primary">Ajouter bloc accueil</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Intitulé</th>
                                                <th>Type bloc</th>
                                                <th>Créée par</th>
                                                <th class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
								          $requete = 'SELECT * FROM `bloc_accueil` ORDER BY `ordre` ASC ';
                                          $resultat = executeRequete($requete);
	                                      $num = mysqli_num_rows($resultat);
		                                  if ($num > 0 ) { 
			                               while ($data = mysqli_fetch_array($resultat))  {
								         ?>
                                            <tr data-id="<?php echo afficheChamp($data['id']); ?>" style="cursor: grab;">
                                                <td><i class="fa fa-arrows-v text-muted m-r-10 drag-handle" style="cursor: grab;" aria-hidden="true"></i> <?php echo afficheChamp($data['titre']); ?></td>
                                                <td><?php echo titreListeSection($data['type_section']); ?></td>
                                                <td><?php echo auteur_name($data['auteur']); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="index.php?r=mbloc_accueil&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <?php if(typeSectionBloc($data['id']) == '4'){ ?>
                                                    <a href="index.php?r=addproduits&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter produits"> <i class="fa fa-list text-inverse m-r-10"></i> </a>
                                                    <?php }else{ ?>
                                                    <a href="index.php?r=addSectionContent&id=<?php echo afficheChamp($data['id']); ?>" data-toggle="tooltip" data-original-title="Ajouter section content"> <i class="fa fa-list text-inverse m-r-10"></i> </a>
                                                    <?php } ?>
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Supprimer" onclick="confirmGlobalDelete('index.php?r=bloc_accueil&id=<?php echo afficheChamp($data['id']); ?>&action=supp')"> <i class="fa fa-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                         <?php } ?>
                                        <?php } ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.querySelector('.admin-table tbody');
    if (el) {
        var sortable = Sortable.create(el, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function (evt) {
                var rows = el.querySelectorAll('tr[data-id]');
                var ids = [];
                rows.forEach(function(row) {
                    ids.push(row.getAttribute('data-id'));
                });
                
                $.ajax({
                    url: 'ajax_order_bloc_accueil.php',
                    method: 'POST',
                    data: { ids: ids },
                    success: function(response) {
                        try {
                            var res = JSON.parse(response);
                            if(res.status === 'success') {
                                if(typeof showToast === 'function') {
                                    showToast('Ordre mis à jour avec succès', 'success');
                                }
                            } else {
                                if(typeof showToast === 'function') {
                                    showToast('Erreur: ' + res.message, 'error');
                                }
                            }
                        } catch(e) {}
                    },
                    error: function() {
                        if(typeof showToast === 'function') {
                            showToast('Erreur serveur lors de la mise à jour', 'error');
                        }
                    }
                });
            }
        });
    }
});
</script>
