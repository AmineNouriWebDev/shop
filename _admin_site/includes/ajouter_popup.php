<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titre = mysqli_real_escape_string($connexion, trim($_POST['titre'] ?? ''));
    $lien = mysqli_real_escape_string($connexion, trim($_POST['lien'] ?? ''));
    $bouton_texte = mysqli_real_escape_string($connexion, trim($_POST['bouton_texte'] ?? ''));
    $emplacement = mysqli_real_escape_string($connexion, $_POST['emplacement'] ?? 'accueil');
    
    // Check if we want to auto-activate this popup
    $etat = 1;
    // Disable others if we activate this one
    mysqli_query($connexion, "UPDATE `site_popups` SET `etat` = 0");

    // Upload files
    $img_desktop = '';
    $img_tablet = '';
    $img_mobile = '';

    if(isset($_FILES['image_desktop']) && $_FILES['image_desktop']['error'] === UPLOAD_ERR_OK) {
        $img_desktop = handleUploadPopupImage($_FILES['image_desktop'], 'd');
    }
    if(isset($_FILES['image_tablet']) && $_FILES['image_tablet']['error'] === UPLOAD_ERR_OK) {
        $img_tablet = handleUploadPopupImage($_FILES['image_tablet'], 't');
    }
    if(isset($_FILES['image_mobile']) && $_FILES['image_mobile']['error'] === UPLOAD_ERR_OK) {
        $img_mobile = handleUploadPopupImage($_FILES['image_mobile'], 'm');
    }

    $q = "INSERT INTO `site_popups` (`titre`, `image_desktop`, `image_tablet`, `image_mobile`, `lien`, `bouton_texte`, `emplacement`, `etat`) 
          VALUES ('$titre', '$img_desktop', '$img_tablet', '$img_mobile', '$lien', '$bouton_texte', '$emplacement', $etat)";
    
    if(mysqli_query($connexion, $q)){
        echo '<script>window.location.href="index.php?r=popups";</script>';
    } else {
        echo '<div class="alert alert-danger">Erreur: '.mysqli_error($connexion).'</div>';
    }
}
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Ajouter un PopUp</h3>
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
                                <input type="text" name="titre" class="form-control" placeholder="Promos Hiver 2026..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Affichage (Emplacement)</label>
                                <select name="emplacement" class="form-control">
                                    <option value="accueil">Uniquement page d'accueil</option>
                                    <option value="toutes">Toutes les pages</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lien URL dynamique (Optionnel)</label>
                                <input type="text" name="lien" class="form-control" placeholder="https://votresite.com/categorie-en-promo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Texte du bouton (Optionnel)</label>
                                <input type="text" name="bouton_texte" class="form-control" placeholder="Découvrir l'offre" maxlength="50">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h4 class="card-title">Visuels du PopUp</h4>
                    <p class="text-muted text-sm">Fournissez les images pour différents tailles d'écrans. Elles seront converties automatiquement en WebP.</p>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Bureau (Desktop)</strong></label>
                                <div class="custom-file">
                                    <input type="file" name="image_desktop" class="custom-file-input" accept="image/*" required>
                                    <label class="custom-file-label">Choisir une image...</label>
                                </div>
                                <small class="form-text text-muted">Format recommandé : Paysage (ex: 800x600px)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Tablette</strong> (Optionnel)</label>
                                <div class="custom-file">
                                    <input type="file" name="image_tablet" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label">Choisir une image...</label>
                                </div>
                                <small class="form-text text-muted">Utilisera l'image Desktop si vide.</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Image Mobile</strong> (Optionnel)</label>
                                <div class="custom-file">
                                    <input type="file" name="image_mobile" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label">Choisir une image...</label>
                                </div>
                                <small class="form-text text-muted">Format recommandé : Portrait ou Carré.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Enregistrer et Activer</button>
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
