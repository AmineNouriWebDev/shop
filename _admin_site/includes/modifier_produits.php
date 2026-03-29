<?php
if(isset($_GET['action']) && $_GET['action'] == 'del_color_img' && isset($_GET['img_id'])) {
    $img_id = intval($_GET['img_id']);
    $prod_id = intval($_GET['id']);
    
    $q_img = executeRequete("SELECT image_path FROM produit_images_couleurs WHERE id='$img_id'");
    if($r_img = mysqli_fetch_assoc($q_img)) {
        $file_path = "../media/products/" . $r_img['image_path'];
        if(file_exists($file_path)) {
            unlink($file_path);
        }
        executeRequete("DELETE FROM produit_images_couleurs WHERE id='$img_id'");
    }
    
    // Redirect back to avoid resubmission on refresh
    phpToastRedirect("Image supprimée avec succès !", "index.php?r=mproduits&id=$prod_id&start=" . ($_GET['start'] ?? 0), "success");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'mod' )
{
    $id                  = intval($_POST['id']);
    $titre               = FormChampSpeciaux(formReception($_POST['titre']));
    $court_contenu       = formReception($_POST['court_contenu']);
    $contenu             = formReception($_POST['contenu']);
    $categorie           = intval($_POST['categorie']);
    $prix_vente          = (float)str_replace(',', '.', formReception($_POST['prix_vente']));
    $prix_promo          = (float)str_replace(',', '.', formReception($_POST['prix_promo']));
    $quantite            = intval($_POST['quantite']);
    $etat_stock          = intval($_POST['etat_stock']);
    $marque              = intval($_POST['marque']);
    $duree               = formReception($_POST['duree']);
    $afficher_accueil    = intval($_POST['afficher_accueil']);
    $remarque            = formReception($_POST['remarque']);
    $video               = formReception($_POST['video']);
    $nbr_vod             = formReception($_POST['nbr_vod']);
    $nbr_chaine_hd       = formReception($_POST['nbr_chaine_hd']);
    $type                = formReception($_POST['type']);
    $ordre               = intval($_POST['ordre']);
    $etat                = intval($_POST['etat']);
    $titre_page          = FormChampSpeciaux(formReception($_POST['titre_page']));
    $keywords            = formReception($_POST['keywords']);
    $description         = formReception($_POST['description']);
    $ancre               = isset($_POST['ancre']) ? formReception($_POST['ancre']) : 'Commander';
    $note_avis           = round(min(5, max(0, floatval(str_replace(',','.',$_POST['note_avis'] ?? 0)))), 2);
    $nb_avis             = intval($_POST['nb_avis'] ?? 0);
    
    $link                = nett($titre);
    
    // Single optimized update query
    $query = "UPDATE `produits` SET 
                `titre` = '$titre', 
                `court_contenu` = '$court_contenu', 
                `categorie` = '$categorie', 
                `prix_vente` = '$prix_vente', 
                `prix_promo` = '$prix_promo', 
                `nbr_vod` = '$nbr_vod', 
                `nbr_chaine_hd` = '$nbr_chaine_hd', 
                `delai` = '$duree', 
                `afficher_accueil` = '$afficher_accueil', 
                `quantite` = '$quantite', 
                `marque` = '$marque', 
                `etat_stock` = '$etat_stock', 
                `type` = '$type', 
                `caracteristique` = '$contenu', 
                `ordre` = '$ordre', 
                `ancre` = '$ancre', 
                `etat` = '$etat', 
                `link` = '$link', 
                `titre_page` = '$titre_page', 
                `keywords` = '$keywords', 
                `description` = '$description', 
                `remarque` = '$remarque', 
                `video` = '$video',
                `note_avis` = '$note_avis',
                `nb_avis` = '$nb_avis'
              WHERE `id` = '$id'";
    
    executeRequete($query);
    
    // Convert Image to WebP Helper
    if (!function_exists('convertAndSaveWebP')) {
        function convertAndSaveWebP($source, $destination_base) {
            $info = @getimagesize($source);
            if ($info === false) return false;
            $mime = $info['mime'];
            $image = false;
            if ($mime == 'image/jpeg' && function_exists('imagecreatefromjpeg')) $image = @imagecreatefromjpeg($source);
            elseif ($mime == 'image/png' && function_exists('imagecreatefrompng')) {
                $image = @imagecreatefrompng($source);
                if($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            } elseif ($mime == 'image/webp' && function_exists('imagecreatefromwebp')) $image = @imagecreatefromwebp($source);
            elseif ($mime == 'image/gif' && function_exists('imagecreatefromgif')) $image = @imagecreatefromgif($source);
            
            if ($image !== false && function_exists('imagewebp')) {
                $final_dest = $destination_base . '.webp';
                imagewebp($image, $final_dest, 80);
                imagedestroy($image);
                return basename($final_dest);
            }
            return false;
        }
    }

    // Main Photos to WebP
	if (isset($_FILES['photos'])) {
	    $first_image_replaced = false;
	    $file_count = count($_FILES['photos']['name']);
        for($i = 0; $i < $file_count; $i++) {
            if($_FILES['photos']['error'][$i] == 0 && $_FILES['photos']['size'][$i] > 0) {
                $tmp_name = $_FILES['photos']['tmp_name'][$i];
                $orig_name = pathinfo($_FILES['photos']['name'][$i], PATHINFO_FILENAME);
                $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id."-produits-".time()."-".$i."-".$orig_name);
                $dest_base = "../media/products/" . $base_name;
                
                $webp_name = convertAndSaveWebP($tmp_name, $dest_base);
                $final_name = "";
                if($webp_name) {
                    $final_name = $webp_name;
                } else {
                    $ext = pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
                    copy($tmp_name, $dest_base . "." . $ext);
                    $final_name = $base_name.".".$ext;
                }
                
                if (!$first_image_replaced) {
                    executeRequete("UPDATE `produits` SET `photo` = '$final_name' WHERE `id` = '$id'");
                    $first_image_replaced = true;
                } else {
                    mysqli_query($connexion, "INSERT INTO images_produit (id_produit, image) VALUES ('$id', '$final_name')");
                }
            }
        }
	}
    
    // Couleurs & Multi Uploads WebP
    if(isset($_POST['couleurs_selected'])) {
        $couleurs_selected = $_POST['couleurs_selected'];
        executeRequete("DELETE FROM `produit_couleurs` WHERE `idproduit` = '$id'");
        foreach($couleurs_selected as $idcouleur) {
            $idcouleur = intval($idcouleur);
            mysqli_query($connexion, "INSERT INTO produit_couleurs (idproduit, idcouleur) VALUES ('$id', '$idcouleur')");
            
            $input_name = "photos_couleur_" . $idcouleur;
            if(isset($_FILES[$input_name])) {
                $file_count = count($_FILES[$input_name]['name']);
                for($i=0; $i<$file_count; $i++) {
                    if($_FILES[$input_name]['error'][$i] == 0 && $_FILES[$input_name]['size'][$i] > 0) {
                        $tmp_name = $_FILES[$input_name]['tmp_name'][$i];
                        $orig_name = pathinfo($_FILES[$input_name]['name'][$i], PATHINFO_FILENAME);
                        $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $id."-c".$idcouleur."-".time()."-".$i."-".$orig_name);
                        $dest_base = "../media/products/" . $base_name;
                        
                        $webp_name = convertAndSaveWebP($tmp_name, $dest_base);
                        $final_name = "";
                        if($webp_name) {
                            $final_name = $webp_name;
                        } else {
                            $ext = pathinfo($_FILES[$input_name]['name'][$i], PATHINFO_EXTENSION);
                            copy($tmp_name, $dest_base . "." . $ext);
                            $final_name = $base_name.".".$ext;
                        }

                        if($final_name) {
                            mysqli_query($connexion, "INSERT INTO produit_images_couleurs (idproduit, idcouleur, image_path) VALUES ('$id', '$idcouleur', '$final_name')");
                            if (!isset($first_image_replaced) || !$first_image_replaced) {
                                $check_photo = mysqli_fetch_array(executeRequete("SELECT photo FROM produits WHERE id='$id'"));
                                if (empty($check_photo['photo']) || $check_photo['photo'] == 'image_non_dispo.jpg') {
                                    executeRequete("UPDATE `produits` SET `photo` = '$final_name' WHERE `id` = '$id'");
                                    $first_image_replaced = true;
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        executeRequete("DELETE FROM `produit_couleurs` WHERE `idproduit` = '$id'");
    }

    // Characteristics — save selected values
    executeRequete("DELETE FROM `caracteristique_prod` WHERE `idproduit` = '$id'");
    $valeurs = isset($_POST['valeurs']) ? $_POST['valeurs'] : [];
    foreach ($valeurs as $valId) {
        $valId = intval($valId);
        $q = mysqli_query($connexion, "SELECT idcarac FROM valeur_caracteristique WHERE id='$valId'");
        if ($row = mysqli_fetch_assoc($q)) {
            $idcarac = $row['idcarac'];
            $req1 = "INSERT INTO `caracteristique_prod` (`idproduit`,`idcarac`,`valeur`) VALUES ('$id', '$idcarac', '$valId')";
            mysqli_query($connexion, $req1);
        }
    }
    
    // Combination-based prices (produit_variations)
    executeRequete("DELETE FROM `produit_variations` WHERE `idproduit` = '$id'");
    if (isset($_POST['variations']) && is_array($_POST['variations'])) {
        foreach ($_POST['variations'] as $var) {
            $vids_raw = isset($var['valeurs_ids']) ? trim($var['valeurs_ids']) : '';
            if ($vids_raw === '') continue;
            
            // Strictly sort IDs numerically to ensure key consistency
            $vids_arr = explode(',', $vids_raw);
            $vids_arr = array_map('intval', $vids_arr);
            sort($vids_arr, SORT_NUMERIC);
            $vids = implode(',', $vids_arr);

            $vlabel = isset($var['label']) ? mysqli_real_escape_string($connexion, $var['label']) : '';
            
            $pv = isset($var['prix_vente']) && $var['prix_vente'] !== '' ? floatval($var['prix_vente']) : 0;
            $pp = isset($var['prix_promo']) && $var['prix_promo'] !== '' ? floatval($var['prix_promo']) : 0;
            
            // Skip variations with no price defined
            if ($pv <= 0 && $pp <= 0) continue;

            $pv_val = ($pv > 0) ? "'$pv'" : 'NULL';
            $pp_val = ($pp > 0) ? "'$pp'" : 'NULL';
            
            $vids_esc = mysqli_real_escape_string($connexion, $vids);
            $q_var = "INSERT INTO `produit_variations` (`idproduit`,`valeurs_ids`,`label`,`prix_vente`,`prix_promo`) VALUES ('$id','$vids_esc','$vlabel',$pv_val,$pp_val)";
            mysqli_query($connexion, $q_var) or die(mysqli_error($connexion) . " in " . $q_var);
        }

        // Sync main product price with the lowest variation (as observed by user)
        $resMin = mysqli_query($connexion, "SELECT MIN(NULLIF(prix_vente, 0)) as min_v, MIN(NULLIF(prix_promo, 0)) as min_p FROM produit_variations WHERE idproduit = '$id'");
        if ($rowMin = mysqli_fetch_assoc($resMin)) {
            if ($rowMin['min_v'] > 0) {
                $min_v = floatval($rowMin['min_v']);
                $min_p = floatval($rowMin['min_p'] ?: 0);
                executeRequete("UPDATE `produits` SET `prix_vente` = '$min_v', `prix_promo` = '$min_p' WHERE `id` = '$id'");
            }
        }
    }

    // ── Badges de garantie (Mise à jour) ────────────────────────────
    executeRequete("DELETE FROM `produits_badges` WHERE `id_produit` = '$id'");
    if (isset($_POST['badges']) && is_array($_POST['badges'])) {
        foreach ($_POST['badges'] as $badge) {
            $b_txt = trim(formReception($badge['texte']));
            $b_ico = trim(formReception($badge['icone']));
            if ($b_txt !== '') {
                $b_txt_esc = mysqli_real_escape_string($connexion, $b_txt);
                $b_ico_esc = mysqli_real_escape_string($connexion, $b_ico);
                mysqli_query($connexion, "INSERT INTO `produits_badges` (`id_produit`, `texte`, `icone`) VALUES ('$id', '$b_txt_esc', '$b_ico_esc')");
            }
        }
    }
    
    // Success notification and redirect
    phpToastRedirect("Produit modifié avec succès !", 'index.php?r=produits&start=' . ($_GET['start'] ?? 0), 'success');
    exit();
}
?>

                <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
								<div class="admin-card-title">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
										<path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.158 3.71 3.71 1.159-1.159a2.625 2.625 0 0 0 0-3.71ZM19.513 8.199l-3.71-3.71-12.15 12.152a3 3 0 0 0-.853 1.5l-1.09 4.364a.75.75 0 0 0 .907.908l4.365-1.09a3 3 0 0 0 1.5-.853L19.513 8.2Z"/>
									</svg>
									Modifier le produit
								</div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="<?php echo titreProduits($_GET['id']); ?>" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Prix vente </label>
                                        <div class="controls">
                                            <input type="text" name="prix_vente" value="<?php echo prixVenteProduits($_GET['id'], true); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Prix promo </label>
                                        <div class="controls">
                                            <input type="text" name="prix_promo" value="<?php echo prixPromoProduits($_GET['id'], true); ?>" class="admin-input"> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>⭐ Note des avis <small style="color:var(--color-text-muted);font-weight:400;">(0 à 5, ex: 4.8)</small></label>
                                                <div class="controls">
                                                    <input type="number" name="note_avis" value="<?php echo noteAvisProduits($_GET['id']); ?>" min="0" max="5" step="0.1" class="admin-input" placeholder="ex: 4.8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>💬 Nombre d'avis <small style="color:var(--color-text-muted);font-weight:400;">(visiteurs)</small></label>
                                                <div class="controls">
                                                    <input type="number" name="nb_avis" value="<?php echo nbAvisProduits($_GET['id']); ?>" min="0" class="admin-input" placeholder="ex: 124">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Court contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="court_contenu" value="" class="admin-input" rows="3"><?php echo courtContenuProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>  
                                    
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenu" value="" class="admin-input" rows="5"><?php echo caracteristiqueProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>                             
                                    <div class="admin-form-group">
                                        <label>Remarque</label>
                                        <div class="controls">
                                          <textarea name="remarque" value="" class="admin-input" rows="3"><?php echo rqProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>

                                    <!-- ── Section Badges de garantie ── -->
                                    <div class="admin-card mb-4" style="border: 1px solid #e2e8f0; background: #fff;">
                                        <div class="admin-card-header" style="background: #f8f9fc; padding: 10px 15px; border-bottom: 1px solid #e2e8f0;">
                                            <div class="admin-card-title" style="font-size: 0.95rem; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                                                <i class="fa-solid fa-shield-halved" style="color: var(--color-primary);"></i>
                                                Badges de garantie (icône FontAwesome + texte)
                                            </div>
                                        </div>
                                        <div class="admin-card-body" style="padding: 15px;">
                                            <div id="badges-container">
                                                <?php
                                                $id_p = intval($_GET['id']);
                                                $q_badges = executeRequete("SELECT * FROM produits_badges WHERE id_produit='$id_p' ORDER BY id ASC");
                                                $b_idx = 0;
                                                while($b_row = mysqli_fetch_assoc($q_badges)) {
                                                ?>
                                                <div class="badge-row row mb-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <input type="text" name="badges[<?php echo $b_idx; ?>][icone]" value="<?php echo afficheChamp($b_row['icone']); ?>" class="admin-input" placeholder="ex: fa-solid fa-lock">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="badges[<?php echo $b_idx; ?>][texte]" value="<?php echo afficheChamp($b_row['texte']); ?>" class="admin-input" placeholder="Texte du badge">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa-solid fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                <?php
                                                    $b_idx++;
                                                }
                                                // If no badges exist, show the 3 default ones for ease of use
                                                if ($b_idx === 0) {
                                                    $defaults = [
                                                        ['ico' => 'fa-solid fa-rotate-left', 'txt' => 'Satisfait ou remboursé 30 jours'],
                                                        ['ico' => 'fa-solid fa-truck-fast', 'txt' => 'Livraison suivie et sécurisée'],
                                                        ['ico' => 'fa-solid fa-headset', 'txt' => 'Support client réactif 7j/7']
                                                    ];
                                                    foreach($defaults as $di => $dv) {
                                                ?>
                                                <div class="badge-row row mb-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <input type="text" name="badges[<?php echo $di; ?>][icone]" value="<?php echo $dv['ico']; ?>" class="admin-input" placeholder="ex: fa-solid fa-lock">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="badges[<?php echo $di; ?>][texte]" value="<?php echo $dv['txt']; ?>" class="admin-input" placeholder="Texte du badge">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa-solid fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                    $b_idx = 3;
                                                }
                                                ?>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addBadgeRow()">
                                                <i class="fa-solid fa-plus"></i> Ajouter un badge
                                            </button>
                                            <script>
                                                let badgeIndex = <?php echo $b_idx; ?>;
                                                function addBadgeRow() {
                                                    const container = document.getElementById('badges-container');
                                                    const div = document.createElement('div');
                                                    div.className = 'badge-row row mb-2 align-items-center';
                                                    div.innerHTML = `
                                                        <div class="col-md-4">
                                                            <input type="text" name="badges[${badgeIndex}][icone]" class="admin-input" placeholder="Icone (ex: fa-solid fa-star)">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="badges[${badgeIndex}][texte]" class="admin-input" placeholder="Texte du badge">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa-solid fa-trash"></i></button>
                                                        </div>
                                                    `;
                                                    container.appendChild(div);
                                                    badgeIndex++;
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="admin-form-group">
                                            <label>Couleurs disponibles</label>
                                            <div class="controls">
                                                <div id="couleurs-container" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 10px;">
                                                <?php
                                                // Fetch existing colors for this product
                                                $selected_colors = [];
                                                $q_sel_c = executeRequete("SELECT idcouleur FROM produit_couleurs WHERE idproduit='".$_GET['id']."'");
                                                while($r_sel = mysqli_fetch_assoc($q_sel_c)) {
                                                    $selected_colors[] = $r_sel['idcouleur'];
                                                }
                                                
                                                $q_colors = executeRequete("SELECT * FROM couleurs ORDER BY nom ASC");
                                                while($color = mysqli_fetch_assoc($q_colors)) {
                                                    $checked = in_array($color['id'], $selected_colors) ? 'checked' : '';
                                                    echo '<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; background: #f8f9fc; padding: 5px 15px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                                            <input type="checkbox" name="couleurs_selected[]" value="'.$color['id'].'" onchange="toggleColorUploads()" '.$checked.'>
                                                            <span style="display:inline-block; width:16px; height:16px; border-radius:50%; background-color:'.$color['code'].'; box-shadow: 0 0 0 1px #cbd5e1;"></span>
                                                            <span style="font-size: 0.9rem; font-weight: 500;">'.$color['nom'].'</span>
                                                          </label>';
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div id="couleurs-uploads-container"></div>
                                        <?php
                                        $existing_color_imgs = [];
                                        $q_img_c = executeRequete("SELECT * FROM produit_images_couleurs WHERE idproduit='".$_GET['id']."'");
                                        while($img_c = mysqli_fetch_assoc($q_img_c)) {
                                            if(!isset($existing_color_imgs[$img_c['idcouleur']])) {
                                                $existing_color_imgs[$img_c['idcouleur']] = [];
                                            }
                                            $existing_color_imgs[$img_c['idcouleur']][] = [
                                                'id' => $img_c['id'], 
                                                'path' => "media/products/" . $img_c['image_path']
                                            ];
                                        }
                                        ?>
                                        <script>
                                        const existingColorImages = <?php echo json_encode($existing_color_imgs); ?>;
                                        const prodId = <?php echo intval($_GET['id']); ?>;
                                        const startParam = "<?php echo isset($_GET['start']) ? intval($_GET['start']) : 0; ?>";
                                        function toggleColorUploads() {
                                            const container = document.getElementById('couleurs-uploads-container');
                                            container.innerHTML = '';
                                            const checkboxes = document.querySelectorAll('input[name="couleurs_selected[]"]:checked');
                                            checkboxes.forEach(cb => {
                                                const colorName = cb.nextElementSibling.nextElementSibling.textContent.trim();
                                                const colorId = cb.value;
                                                
                                                let existingHtml = '';
                                                if (existingColorImages[colorId] && existingColorImages[colorId].length > 0) {
                                                    existingHtml += '<div style="margin-bottom: 15px;">';
                                                    existingHtml += '<p style="font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Images actuelles :</p>';
                                                    existingHtml += '<div style="display: flex; gap: 10px; flex-wrap: wrap;">';
                                                    existingColorImages[colorId].forEach(img => {
                                                        existingHtml += `<div style="position:relative; width: 70px; height: 70px;">
                                                            <img src="../${img.path}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                            <a href="index.php?r=mproduits&id=${prodId}&start=${startParam}&action=del_color_img&img_id=${img.id}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');" style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: bold; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">&times;</a>
                                                        </div>`;
                                                    });
                                                    existingHtml += '</div></div>';
                                                }
                                                
                                                container.innerHTML += `<div class="admin-form-group" style="padding: 15px; border-left: 4px solid var(--color-primary); background: #f8f9fc; border-radius: 4px; margin-bottom: 10px;">
                                                    <label style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Images pour la couleur <span style="color: var(--color-primary);">${colorName}</span></label>
                                                    ${existingHtml}
                                                    <div class="controls">
                                                        <label style="font-size: 0.85rem; font-weight: 500; color: #475569;">Ajouter/Remplacer (<small>Laissez vide pour garder vos images actuelles</small>)</label>
                                                        <input type="file" name="photos_couleur_${colorId}[]" multiple class="admin-input" accept="image/jpeg, image/png, image/webp" style="margin-top: 5px;">
                                                    </div>
                                                </div>`;
                                            });
                                        }
                                        document.addEventListener("DOMContentLoaded", toggleColorUploads);
                                        </script>
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image</label>
                                        <?php if(ApercuProduits($_GET['id'])) { ?>
								         <div><img src="../<?php echo photoProduitsSite($_GET['id']); ?>" style="max-width:150px" /></div>
                                         <?php } ?>
                                        <div class="controls">
                                            <input type="file" name="photos[]" multiple class="admin-input" accept="image/jpeg, image/png, image/webp"> 
                                            <small style="display: block; margin-top: 5px; color: #64748b;">La première sélectionnée remplacera l'image principale, les autres seront ajoutées aux images secondaires. Elles seront optimisées (WebP).</small>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Catégorie</label>
											<div class="controls">
												<select name="categorie" id="select1" class="admin-input">
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>" <?php if( categorieProduits($_GET['id']) == $data1['id']) echo "selected"; ?> >--> <?php echo afficheChamp1($data1['titre']); ?></option>
        	                                      <?php 
        	                                       } 
        	                                     } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Marque</label>
											<div class="controls">
												<select name="marque" id="select2" class="admin-input">
												
													
													<option value="0">-- Selectionner --</option>
												
												<?php
            	                                 $req = 'SELECT * FROM `marques` WHERE `etat` = "1" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
													<option value="<?php echo $data['id']; ?>"  <?php if( marquesProduits($_GET['id']) == $data['id']) echo "selected"; ?>><?php echo afficheChamp($data['raison']); ?></option>
                                                <?php 
        	                                        } 
        	                                     ?> 
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-6">
                                            <div class="admin-form-group">
                								
                								<label>Caractéristiques</label>
                								<div class="controls">
                								    <select name="caracteristiques[]" class="select2 form-control custom-select" id="mySelect2" onChange="getCaracteristique()" multiple>
                								     <?php		
                                                    $req5 = "SELECT * FROM `caracteristiques` WHERE `etat`='1' ORDER BY `id`";	
                                                    $res5=executeRequete($req5);
                                                    while ($data5 = mysqli_fetch_array($res5))
                                                    {		
                                                      $idc=afficheChamp($data5['id']);
                                                      $titre=afficheChamp($data5['titre']);  
                                                    ?> 
                                                    <option value="<?php echo $idc; ?>"  <?php if(caracteristiques_prod($idc,$_GET['id'])==true) echo "selected";?>><?php echo $titre; ?></option>
                                                    <?php
                                                    }
                                                     ?>
                								    </select>
                								</div>
                							</div>
        							    </div>
        							</div>
        							               
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Valeurs</label>
											<div class="controls">
												<select name="valeurs[]" multiple class="select2 form-control custom-select" id="list-carac" style="width: 100%;">
												</select>
											</div>
											</div>
                                            <div id="carac-prices-container" style="margin-top: 15px; display: none;"></div>
										</div>
									</div> 
                                    
                                    <?php
                                    // Load existing combination variations for this product
                                    $existingVariations = [];
                                    $q_vars = mysqli_query($connexion, "SELECT valeurs_ids, prix_vente, prix_promo FROM produit_variations WHERE idproduit='".$_GET['id']."'");
                                    while($row_v = mysqli_fetch_assoc($q_vars)) {
                                        $existingVariations[$row_v['valeurs_ids']] = [
                                            'pv' => $row_v['prix_vente'],
                                            'pp' => $row_v['prix_promo']
                                        ];
                                    }
                                    ?>
                                    <script>
                                    var savedVariations = <?php echo json_encode($existingVariations); ?>;

                                    // ── Combination-based pricing UI (shared logic) ──
                                    var caracGroups = {};

                                    function buildCaracGroups(selectedOptions) {
                                        caracGroups = {};
                                        selectedOptions.each(function() {
                                            var opt = $(this);
                                            var fullText = opt.text();
                                            var valId = opt.val();
                                            var idcarac = opt.data('idcarac') || 0;
                                            var caracTitre = opt.data('caractitre') || fullText.split(':')[0].trim();
                                            var valText = opt.data('valtext') || (fullText.indexOf(':') !== -1 ? fullText.split(':').slice(1).join(':').trim() : fullText);
                                            if (!caracGroups[idcarac]) {
                                                caracGroups[idcarac] = { titre: caracTitre, values: [] };
                                            }
                                            caracGroups[idcarac].values.push({ id: valId, text: valText });
                                        });
                                    }

                                    function cartesianProduct(groups) {
                                        var keys = Object.keys(groups);
                                        if (keys.length === 0) return [];
                                        var result = [[]];
                                        keys.forEach(function(key) {
                                            var newResult = [];
                                            result.forEach(function(existing) {
                                                groups[key].values.forEach(function(val) {
                                                    newResult.push(existing.concat([{ idcarac: key, titre: groups[key].titre, id: val.id, text: val.text }]));
                                                });
                                            });
                                            result = newResult;
                                        });
                                        return result;
                                    }

                                    function makeCombinationKey(combo) {
                                        var ids = combo.map(function(item) { return parseInt(item.id); });
                                        ids.sort(function(a, b) { return a - b; });
                                        return ids.join(',');
                                    }

                                    function makeCombinationLabel(combo) {
                                        return combo.map(function(item) { return item.titre + ': ' + item.text; }).join(' / ');
                                    }

                                    var hasLoaded = false;
                                    function updateCaracPrices() {
                                        if (hasLoaded) return; // Prevent double trigger on initial load
                                        
                                        var $select = $('#list-carac');
                                        var selectedOptions = $select.find('option:selected');
                                        var container = $('#carac-prices-container');

                                        // If no options selected, or list not yet populated
                                        if (selectedOptions.length === 0) { 
                                            container.hide().empty(); 
                                            return; 
                                        }

                                        // Preserve current user input before rebuilding
                                        var currentValues = {};
                                        container.find('input[data-combo-key]').each(function() {
                                            var key = $(this).data('combo-key');
                                            var field = $(this).data('field');
                                            if (!currentValues[key]) currentValues[key] = {};
                                            currentValues[key][field] = $(this).val();
                                        });

                                        container.empty();
                                        buildCaracGroups(selectedOptions);
                                        var combinations = cartesianProduct(caracGroups);

                                        if (combinations.length === 0) { container.hide(); return; }

                                        container.show();
                                        var html = '<div style="background: #f8f9fc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">';
                                        html += '<h6 style="font-weight: 600; margin-bottom: 5px; color: var(--color-primary);">Prix par combinaison de caractéristiques</h6>';
                                        html += '<p style="font-size: 0.82rem; color: #64748b; margin-bottom: 12px;">Chaque ligne = une configuration précise du produit. Laissez vide pour hériter du prix global.</p>';
                                        html += '<table style="width:100%; text-align: left; border-collapse: collapse;">';
                                        html += '<thead style="border-bottom: 2px solid #e2e8f0;"><tr>';
                                        html += '<th style="padding: 8px; font-size:0.85rem;">Combinaison</th>';
                                        html += '<th style="padding: 8px; font-size:0.85rem;">Prix vente (TND)</th>';
                                        html += '<th style="padding: 8px; font-size:0.85rem;">Prix promo (TND)</th>';
                                        html += '</tr></thead><tbody>';

                                        combinations.forEach(function(combo) {
                                            var key = makeCombinationKey(combo);
                                            var label = makeCombinationLabel(combo);
                                            var saved = savedVariations[key] || {};
                                            
                                            // Priority: 1. Current user input (if any) > 2. Saved DB value > 3. Empty
                                            var pv = (currentValues[key] && currentValues[key].pv !== undefined) ? currentValues[key].pv : (saved.pv != null ? saved.pv : '');
                                            var pp = (currentValues[key] && currentValues[key].pp !== undefined) ? currentValues[key].pp : (saved.pp != null ? saved.pp : '');
                                            
                                            html += '<tr style="border-bottom: 1px solid #e2e8f0;">';
                                            html += '<td style="padding: 8px; font-weight: 500; font-size:0.85rem;">' + label + '</td>';
                                            html += '<td style="padding: 8px;"><input type="number" step="0.001" min="0" name="variations[' + key + '][prix_vente]" data-combo-key="' + key + '" data-field="pv" class="admin-input" value="' + (pv || '') + '" placeholder="Prix global" style="padding: 6px 10px; height: auto; min-width:100px;"></td>';
                                            html += '<td style="padding: 8px;"><input type="number" step="0.001" min="0" name="variations[' + key + '][prix_promo]" data-combo-key="' + key + '" data-field="pp" class="admin-input" value="' + (pp || '') + '" placeholder="Sans promo" style="padding: 6px 10px; height: auto; min-width:100px;"></td>';
                                            html += '</tr>';
                                            html += '<tr style="display:none;"><td colspan="3">';
                                            html += '<input type="hidden" name="variations[' + key + '][valeurs_ids]" value="' + key + '">';
                                            html += '<input type="hidden" name="variations[' + key + '][label]" value="' + label.replace(/"/g, '&quot;') + '">';
                                            html += '</td></tr>';
                                        });

                                        html += '</tbody></table></div>';
                                        container.html(html);
                                    }

                                    // Robust initialization
                                    function initVariationLogic() {
                                        if (!window.jQuery) return setTimeout(initVariationLogic, 50);
                                        
                                        // Handle manual change
                                        $('#list-carac').on('change', function() {
                                            hasLoaded = false; // Allow re-runs on user interaction
                                            updateCaracPrices();
                                        });

                                        // Listener for custom event from scripts_footer.php
                                        document.addEventListener('carac-list-ready', function() {
                                            updateCaracPrices();
                                        });

                                        // Fallback: check if already loaded or wait a bit
                                        setTimeout(updateCaracPrices, 1000);
                                        setTimeout(updateCaracPrices, 3000); // Safety check
                                    }
                                    
                                    initVariationLogic();
                                    </script>
									
									<div class="row">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Type</label>
											<div class="controls">
												<select name="type" class="admin-input" id="Type" onchange = "ShowHideDiv()">
													<option value="">-- Selectionner --</option>
													<option value="E" <?php if( typeProduits($_GET['id']) == "E") echo "selected"; ?>>Equipement</option>
													<option value="A" <?php if( typeProduits($_GET['id']) == "A") echo "selected"; ?>>Abonnement</option>
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div id="selectAbonnement" style="display:none;">
									    
                                    <div class="admin-form-group">
                                        <label>Durée </label>
										<div class="controls">
                                          <input type="text" name="duree" value="<?php echo delaiProduits($_GET['id']); ?>" class="admin-input" placeholder="Exp : Par 6 mois,...">
                                        </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Afficher accueil</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="afficher_accueil" type="radio" <?php if( afficheAccueilProduits($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="afficher_accueil" type="radio" <?php if( afficheAccueilProduits($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Nombre VOD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="<?php echo vodProduits($_GET['id']); ?>" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Nombre Chaine HD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="<?php echo chaineHdProduits($_GET['id']); ?>" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    </div>
									
                                    <div class="admin-form-group">
                                        <label>Video</label>
                                        <div class="controls">
                                          <textarea name="video" class="admin-input" rows="5"><?php echo videoProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
									
                                    <div class="admin-form-group">
                                        <label> Quantité </label>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="<?php echo quantiteProduits($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" <?php if( etatStockProduits($_GET['id']) == '1' ) echo "checked"; ?> value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" <?php if( etatStockProduits($_GET['id']) == '0' ) echo "checked"; ?> value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Rupture</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Ancre</label>
                                        <div class="controls">
                                            <input type="text" name="ancre" value="<?php echo ancreProduits($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo ordreProduits($_GET['id']); ?>" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                       <div class="admin-form-group">
                                        <label>Etat</label>
                                        <div class="controls">
                                            <select name="etat" id="select" class="admin-input">
                                                <option value="1" <?php if(statusProduits($_GET['id'])=="1") echo "selected"; ?>>Actif</option>
                                                <option value="0" <?php if(statusProduits($_GET['id'])=="0") echo "selected"; ?>>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Titre de la page </label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="<?php echo titrePageProduits($_GET['id']); ?>" class="admin-input"> </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Description</label>
                                        <div class="controls">
                                          <textarea name="description" class="admin-input" rows="5"><?php echo descriptionProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Keywords</label>
                                        <div class="controls">
                                          <textarea name="keywords" class="admin-input" rows="5"><?php echo keywordsProduits($_GET['id']); ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=produits&start=<?php echo $_GET['start']; ?>'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="mod">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


