<?php
if (isset($_GET['action']) && $_GET['action'] == 'supp' && isset($_GET['id'])) {
    $id_diag = intval($_GET['id']);
    executeRequete("DELETE FROM diagnostic_demandes WHERE id = $id_diag");
    echo '<script>window.location = "index.php?r=diagnostic_demandes";</script>';
    exit;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="card-title mb-0">📋 Demandes de Diagnostics Sécurité</h4>
                    <span class="badge badge-info"><?php 
                        $res_count = executeRequete("SELECT COUNT(*) as nb FROM diagnostic_demandes");
                        $row_count = mysqli_fetch_assoc($res_count);
                        echo $row_count['nb'];
                    ?> demande(s)</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered color-table info-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Type Bâtiment / Caméra</th>
                                <th>Zones & Raisons</th>
                                <th>Alim.</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $requete = 'SELECT * FROM `diagnostic_demandes` ORDER BY `date_creation` DESC';
                        $resultat = executeRequete($requete);
                        if (mysqli_num_rows($resultat) > 0) { 
                            while ($data = mysqli_fetch_array($resultat)) {
                                $zones = json_decode($data['zones'], true) ?: [$data['zones']];
                                $raisons = json_decode($data['raisons'], true) ?: [$data['raisons']];
                                ?>
                                <tr>
                                    <td style="font-size:0.85rem;">
                                        <?php echo date('d/m/Y H:i', strtotime($data['date_creation'])); ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($data['nom'] . ' ' . $data['prenom']); ?></strong><br>
                                        <span class="text-muted small"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($data['telephone']); ?></span>
                                        <?php if($data['whatsapp']): ?>
                                            <span class="badge badge-success" style="font-size:0.65rem;">WhatsApp</span>
                                        <?php endif; ?>
                                        <?php if($data['adresse']): ?>
                                            <br><span class="text-muted small"><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($data['adresse']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary"><?php echo htmlspecialchars($data['type_batiment']); ?></span><br>
                                        <span class="badge badge-secondary"><?php echo htmlspecialchars($data['type_camera']); ?></span>
                                    </td>
                                    <td style="font-size:0.85rem;">
                                        <div class="mb-1"><strong>Zones:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $zones)); ?></div>
                                        <div><strong>Raisons:</strong> <?php echo implode(', ', array_map('htmlspecialchars', $raisons)); ?></div>
                                    </td>
                                    <td>
                                        <?php if($data['alimentation'] == 'Batterie'): ?>
                                            <span class="badge badge-warning"><i class="fa fa-battery-full"></i> Batterie</span>
                                        <?php else: ?>
                                            <span class="badge badge-info"><i class="fa fa-plug"></i> Secteur</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="javascript:void(0);" onclick="confirmGlobalDelete('index.php?r=diagnostic_demandes&id=<?php echo $data['id']; ?>&action=supp')" class="btn btn-sm btn-danger" title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } 
                        } else { ?>
                            <tr><td colspan="6" class="text-center p-4">Aucune demande pour le moment.</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
