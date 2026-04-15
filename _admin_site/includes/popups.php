<?php
if(isset($_GET['delid'])) {
    $id = (int)$_GET['delid'];
    $popup = getPopup($id);
    if($popup) {
        deletePopupImages($popup);
        mysqli_query($connexion, "DELETE FROM `site_popups` WHERE `id` = $id");
        echo '<div class="alert alert-success">PopUp supprimé avec succès.</div>';
    }
}

if(isset($_GET['etatid'])) {
    $id = (int)$_GET['etatid'];
    $etat = (int)$_GET['etat'];
    // If setting to active (1), we might want to deactivate others. Or let multiple be active and display the latest one.
    // The user requirement hints at "possibilité de choisir un popup à afficher", meaning 1 active is best.
    if($etat == 1) {
        mysqli_query($connexion, "UPDATE `site_popups` SET `etat` = 0"); // disable all
        mysqli_query($connexion, "UPDATE `site_popups` SET `etat` = 1 WHERE `id` = $id"); // enable this one
    } else {
        mysqli_query($connexion, "UPDATE `site_popups` SET `etat` = 0 WHERE `id` = $id");
    }
    echo '<script>window.location.href="index.php?r=popups";</script>';
}

$popups = listPopups();
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">PopUps Marketing</h3>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">
        <a href="index.php?r=npopup" class="btn btn-info"><i class="fa fa-plus-circle"></i> Ajouter un PopUp</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des PopUps promotionnels</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Aperçu</th>
                                <th>Titre</th>
                                <th>Emplacement</th>
                                <th>Date Création</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($popups as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td>
                                    <?php if($p['image_desktop']): ?>
                                    <img src="../media/popups/<?php echo $p['image_desktop']; ?>" style="max-height: 50px; border-radius: 4px;">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo afficheChamp($p['titre']); ?></td>
                                <td>
                                    <?php if($p['emplacement'] == 'accueil'): ?>
                                        <span class="badge badge-primary">Accueil Uniquement</span>
                                    <?php else: ?>
                                        <span class="badge badge-info">Toutes les pages</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($p['datecreation'])); ?></td>
                                <td>
                                    <?php if($p['etat'] == 1): ?>
                                        <a href="index.php?r=popups&etatid=<?php echo $p['id']; ?>&etat=0" class="badge badge-success" title="Désactiver">Actif</a>
                                    <?php else: ?>
                                        <a href="index.php?r=popups&etatid=<?php echo $p['id']; ?>&etat=1" class="badge badge-danger" title="Activer">Inactif</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?r=mpopup&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-info" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="index.php?r=popups&delid=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce popup ?');"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($popups)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Aucun PopUp trouvé.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
