<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<?php
if(isset($_GET['action']) && $_GET['action'] == 'del') {
    $id = intval($_GET['id']);
    executeRequete("DELETE FROM conf_kits WHERE id = $id");
    executeRequete("DELETE FROM conf_etapes WHERE id_kit = $id");
    echo "<script>window.location.href='index.php?r=configurateur';</script>";
    exit;
}
?>
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Kits Configurateur
                </div>
                <div class="admin-card-actions">
                    <a href="index.php?r=nconfigurateur" class="admin-btn admin-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Ajouter un Kit
                    </a>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Kit</th>
                                <th>Description</th>
                                <th>État</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $requete = 'SELECT * FROM `conf_kits` ORDER BY `ordre` ASC';
                            $resultat = executeRequete($requete);
                            $num = mysqli_num_rows($resultat);
                            if ($num > 0 ) { 
                            while ($data = mysqli_fetch_array($resultat))  {
                        ?>
                            <tr data-id="<?php echo $data['id']; ?>" style="cursor: grab;">
                                <td class="text-sm text-gray-500">
                                    <i class="fa fa-arrows-v text-muted m-r-10 drag-handle" style="cursor: grab;" aria-hidden="true"></i> 
                                    #<?php echo $data['id']; ?>
                                </td>
                                <td class="font-medium text-gray-900"><?php echo afficheChamp($data['titre']); ?></td>
                                <td class="text-sm text-gray-600"><?php echo afficheChamp($data['description']); ?></td>
                                <td>
                                    <?php if($data['etat'] == 1): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Actif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <div class="action-buttons">
                                        <a href="index.php?r=mconfigurateur&id=<?php echo $data['id']; ?>" class="p-1 text-blue-600 hover:text-blue-900 transition-colors" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=configurateur&action=del&id=<?php echo $data['id']; ?>')" class="p-1 text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400">
                                    Aucun kit configuré pour le moment.
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="text-blue-800 font-bold mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Note de développement
                    </h4>
                    <p class="text-sm text-blue-700">
                        Cette interface permettra de créer des "Kits" (ex: "Système Filaire" ou "Caméra WiFi") et d'y associer dynamiquement des étapes. 
                        Pour chaque étape, vous pourrez sélectionner une catégorie spécifique ou un produit exact (comme la Mémoire SD pour les caméras WiFi).
                    </p>
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
                    url: 'ajax_order_conf_kits.php',
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
