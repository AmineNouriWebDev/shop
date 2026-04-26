<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout') {
    $titre       = formReception($_POST['titre']);
    $description = formReception($_POST['description']);
    $ordre       = formReception($_POST['ordre']);
    $etat        = formReception($_POST['etat']);

    $requete = 'INSERT INTO `conf_kits` (`titre`, `description`, `ordre`, `etat`) VALUES ("'. $titre .'","'. $description .'","'. $ordre .'","'. $etat .'")';
    $connexion = ouvrirCnx() or die("erreur cnx");
    $result  = mysqli_query($connexion, $requete);  
    $idp     = mysqli_insert_id($connexion);
    
    $photo = "";
    if(isset($_POST['icon_fa']) && trim($_POST['icon_fa']) != '') {
        $photo = formReception($_POST['icon_fa']);
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0 && $_FILES['photo']['type'] != '') {
        if ($_FILES['photo']['type']=="image/jpeg" || $_FILES['photo']['type']=="image/png" || $_FILES['photo']['type']=="image/gif" || $_FILES['photo']['type']=="image/webp"){
            $destination = str_replace(' ', '-', $idp."-kit-".$_FILES['photo']['name']);
            copy ($_FILES['photo']['tmp_name'], "../media/products/".$destination);
            $photo = $destination;
        }
    }
    
    if($photo !== "") {
        $requete = 'UPDATE `conf_kits` SET `photo`="'. $photo .'" WHERE `id`="'.$idp.'"';
        executeRequete($requete);   
    }

    // Redirige vers la modification pour ajouter les étapes
    ?>
    <script language="javascript">
        window.location = 'index.php?r=mconfigurateur&id=<?php echo $idp; ?>';
    </script>
    <?php
}
?>
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Ajouter un Kit (Système)
                </div>
            </div>
            <div class="admin-card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="admin-form-group">
                        <label>Titre du Kit <span class="text-danger">*</span></label>
                        <div class="controls">
                            <input type="text" name="titre" value="" class="admin-input" required placeholder="Ex: Système Filaire">
                        </div>
                    </div>
                    
                    <div class="admin-form-group">
                        <label>Description courte</label>
                        <div class="controls">
                            <textarea name="description" class="admin-input" rows="3" placeholder="Ex: Kit complet avec enregistreur et caméras filaires"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label>Icône FontAwesome (Ex: fa fa-camera)</label>
                                <div class="controls">
                                    <input type="text" name="icon_fa" class="admin-input" placeholder="fa fa-video-camera"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label>Ou Image (remplace l'icône)</label>
                                <div class="controls">
                                    <input type="file" name="photo" class="admin-input"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-2">
                            <div class="admin-form-group">
                                <label>Ordre</label>
                                <div class="controls">
                                    <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('conf_kits', 1); ?>" class="admin-input"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label>Etat</label>
                                <div class="controls">
                                    <select name="etat" class="admin-input">
                                        <option value="1" selected="selected">Actif</option>
                                        <option value="0">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-xs-right mt-4">
                        <button type="submit" class="admin-btn admin-btn-primary">Créer et ajouter des étapes</button>
                        <button type="button" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=configurateur'">Annuler</button>
                        <input name="action" type="hidden" value="ajout">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
