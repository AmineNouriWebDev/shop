<?php
$id = (int)$_GET['id'] ?? 0;
$popup = getPopup($id);
if(!$popup) {
    echo '<script>window.location.href="index.php?r=popups";</script>';
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titre = mysqli_real_escape_string($connexion, trim($_POST['titre'] ?? ''));
    $lien = mysqli_real_escape_string($connexion, trim($_POST['lien'] ?? ''));
    $bouton_texte = mysqli_real_escape_string($connexion, trim($_POST['bouton_texte'] ?? ''));
    $emplacement = mysqli_real_escape_string($connexion, $_POST['emplacement'] ?? 'accueil');
    
    $update_img_parts = [];

    // Upload files to replace existing ones
    if(isset($_FILES['image_desktop']) && $_FILES['image_desktop']['error'] === UPLOAD_ERR_OK) {
        $img_desktop = handleUploadPopupImage($_FILES['image_desktop'], 'd');
        if($img_desktop) {
            $update_img_parts[] = "`image_desktop` = '$img_desktop'";
            if(!empty($popup['image_desktop']) && file_exists('../media/popups/' . $popup['image_desktop'])) {
                @unlink('../media/popups/' . $popup['image_desktop']);
            }
        }
    }
    if(isset($_FILES['image_tablet']) && $_FILES['image_tablet']['error'] === UPLOAD_ERR_OK) {
        $img_tablet = handleUploadPopupImage($_FILES['image_tablet'], 't');
        if($img_tablet) {
            $update_img_parts[] = "`image_tablet` = '$img_tablet'";
            if(!empty($popup['image_tablet']) && file_exists('../media/popups/' . $popup['image_tablet'])) {
                @unlink('../media/popups/' . $popup['image_tablet']);
            }
        }
    }
    if(isset($_FILES['image_mobile']) && $_FILES['image_mobile']['error'] === UPLOAD_ERR_OK) {
        $img_mobile = handleUploadPopupImage($_FILES['image_mobile'], 'm');
        if($img_mobile) {
            $update_img_parts[] = "`image_mobile` = '$img_mobile'";
            if(!empty($popup['image_mobile']) && file_exists('../media/popups/' . $popup['image_mobile'])) {
                @unlink('../media/popups/' . $popup['image_mobile']);
            }
        }
    }

    $q_update = "UPDATE `site_popups` SET 
                 `titre` = '$titre', 
                 `lien` = '$lien', 
                 `bouton_texte` = '$bouton_texte', 
                 `emplacement` = '$emplacement'";
                 
    if (!empty($update_img_parts)) {
        $q_update .= ", " . implode(', ', $update_img_parts);
    }
    $q_update .= " WHERE `id` = $id";
    
    if(mysqli_query($connexion, $q_update)){
        echo '<script>window.location.href="index.php?r=popups";</script>';
    } else {
        echo '<div class="alert alert-danger">Erreur: '.mysqli_error($connexion).'</div>';
    }
}
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Modifier un PopUp</h3>
    </div>
    <div class="col-md-7 align-self-center text-right d-none d-md-block">
        <a href="index.php?r=popups" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Titre (Interne)</label>
                                <input type="text" name="titre" class="form-control" value="<?php echo afficheChamp($popup['titre']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Affichage (Emplacement)</label>
                                <select name="emplacement" class="form-control">
                                    <option value="accueil" <?php echo $popup['emplacement'] == 'accueil' ? 'selected' : ''; ?>>Uniquement page d'accueil</option>
                                    <option value="toutes" <?php echo $popup['emplacement'] == 'toutes' ? 'selected' : ''; ?>>Toutes les pages</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lien URL dynamique (Optionnel)</label>
                                <input type="text" name="lien" class="form-control" value="<?php echo afficheChamp($popup['lien']); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Texte du bouton (Optionnel)</label>
                                <input type="text" name="bouton_texte" class="form-control" value="<?php echo afficheChamp($popup['bouton_texte']); ?>" maxlength="50">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h4 class="card-title">Visuels du PopUp</h4>
                    <p class="text-muted text-sm">Laissez vide si vous ne souhaitez pas modifier l'image existante.</p>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Bureau (Desktop)</strong></label>
                                <?php if($popup['image_desktop']): ?>
                                    <div class="mb-2"><img src="../media/popups/<?php echo $popup['image_desktop']; ?>" style="max-width:100px; border-radius:4px;"></div>
                                <?php endif; ?>
                                <div class="custom-file">
                                    <input type="file" name="image_desktop" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label">Remplacer...</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Tablette</strong></label>
                                <?php if($popup['image_tablet']): ?>
                                    <div class="mb-2"><img src="../media/popups/<?php echo $popup['image_tablet']; ?>" style="max-width:100px; border-radius:4px;"></div>
                                <?php endif; ?>
                                <div class="custom-file">
                                    <input type="file" name="image_tablet" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label">Remplacer...</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Mobile</strong></label>
                                <?php if($popup['image_mobile']): ?>
                                    <div class="mb-2"><img src="../media/popups/<?php echo $popup['image_mobile']; ?>" style="max-width:100px; border-radius:4px;"></div>
                                <?php endif; ?>
                                <div class="custom-file">
                                    <input type="file" name="image_mobile" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label">Remplacer...</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('.custom-file-input').on('change', function() {
   var fileName = $(this).val().split('\\').pop();
   $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
});
</script>
