<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
    // Prevent VPS silent crashes on large image conversions
    ini_set('memory_limit', '512M');
    set_time_limit(300);

	$titre  	         = FormChampSpeciaux(formReception($_POST['titre']));
	$court_contenu       = formReception($_POST['court_contenu']);
	$contenu  	         = formReception($_POST['contenu']);
	$categorie 	         = formReception($_POST['categorie']);
    $idprt               = idparentCategBlog($categorie);
	$prix_vente	         = formReception($_POST['prix_vente']);
	$prix_promo	         = formReception($_POST['prix_promo']);
	$quantite	         = formReception($_POST['quantite']);
	$etat_stock	         = formReception($_POST['etat_stock']);
	$marque 	         = formReception($_POST['marque']);
	$type        	     = 'E';
	$afficher_accueil  	 = 0;
	$duree               = '';
	$nbr_vod             = 0;
	$nbr_chaine_hd       = 0;
	$remarque  	         = formReception($_POST['remarque']);
	$video	             = formReception($_POST['video']);
	$ordre 		         = formReception($_POST['ordre']);
	$etat 		         = formReception($_POST['etat']);
	$titre_page          = FormChampSpeciaux(formReception($_POST['titre_page']));
	$keywords 	         = formReception($_POST['keywords']);
	$description         = formReception($_POST['description']);
	$note_avis           = round(min(5, max(0, floatval(str_replace(',','.',$_POST['note_avis'] ?? 0)))), 2);
	$nb_avis             = intval($_POST['nb_avis'] ?? 0);
	
	$link    		     = nett(formReception($_POST['titre']));
	if(isset($_POST['ancre'])){ $ancre = formReception($_POST['ancre']); } else { $ancre = "Commander";}
	$datec        = timestampTD(date("d/m/Y H:i:s"));
	$auteur       = auteur_id();
	
	$connexion=ouvrirCnx() or die("erreur cnx");

    // Convert Image to WebP Helper has been moved to fction_db.php

	$requete = 'INSERT INTO `produits`
	(`titre`,`court_contenu`, `caracteristique`,`remarque`, `link`, `categorie`,`idparent_categ`, `prix_vente`, `prix_promo`, `etat_stock`, `quantite`, `marque`, `type`, `afficher_accueil`,
	`video`, `delai`, `nbr_vod`, `nbr_chaine_hd`, `ancre`, `ordre`, `etat`, `titre_page`, `description`, `keywords`, `auteur`, `datecreation`, `note_avis`, `nb_avis`) 
	VALUES
	("'. $titre .'","'. $court_contenu .'","'. $contenu .'","'. $remarque .'","'. $link .'","'. $categorie .'","'. $idprt .'","'. $prix_vente .'","'. $prix_promo .'","'. $etat_stock .'","'. $quantite .'","'. $marque .'","'. $type .'","'
	. $afficher_accueil .'","'.$video.'","'. $duree .'","'. $nbr_vod .'","'. $nbr_chaine_hd .'","'. $ancre .'","'. $ordre .'", "'. $etat .'","'. $titre_page .'","'. $description .'",
	"'. $keywords .'","'. $auteur .'","'. $datec .'","'.$note_avis.'","'.$nb_avis.'")';
		
    $result  = mysqli_query($connexion, $requete);	
    $idp     = mysqli_insert_id($connexion);
		
    // Main Photos to WebP
	if (isset($_FILES['photos'])) {
	    $first_image_saved = false;
	    $file_count = count($_FILES['photos']['name']);
        for($i = 0; $i < $file_count; $i++) {
            if($_FILES['photos']['error'][$i] == 0 && $_FILES['photos']['size'][$i] > 0) {
                $tmp_name = $_FILES['photos']['tmp_name'][$i];
                $orig_name = pathinfo($_FILES['photos']['name'][$i], PATHINFO_FILENAME);
                $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $idp."-produits-".time()."-".$i."-".$orig_name);
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
                
                if (!$first_image_saved) {
                    executeRequete('UPDATE `produits` set `photo`="'. $final_name .'"  WHERE `id`="'.$idp.'"');
                    $first_image_saved = true;
                } else {
                    mysqli_query($connexion, "INSERT INTO images_produit (id_produit, image) VALUES ('$idp', '$final_name')");
                }
            }
        }
	}

    // Caractéristiques — enregistrer les valeurs sélectionnées
	$valeurs = isset($_POST['valeurs']) ? $_POST['valeurs'] : [];
    foreach ($valeurs as $valId) {
        $valId = intval($valId);
        $q = mysqli_query($connexion, "SELECT idcarac FROM valeur_caracteristique WHERE id='$valId'");
        if ($row = mysqli_fetch_assoc($q)) {
            $idcarac = $row['idcarac'];
            $req1 = "INSERT INTO `caracteristique_prod` (`idproduit`,`idcarac`,`valeur`) VALUES ('$idp', '$idcarac', '$valId')";
            mysqli_query($connexion, $req1);
        }
    }

    // Prix par combinaison (produit_variations)
    if (isset($_POST['variations']) && is_array($_POST['variations'])) {
        foreach ($_POST['variations'] as $var) {
            $vids = isset($var['valeurs_ids']) ? trim($var['valeurs_ids']) : '';
            $vlabel = isset($var['label']) ? mysqli_real_escape_string($connexion, $var['label']) : '';
            if ($vids === '') continue;
            $pv = isset($var['prix_vente']) && $var['prix_vente'] !== '' ? floatval($var['prix_vente']) : null;
            $pp = isset($var['prix_promo']) && $var['prix_promo'] !== '' ? floatval($var['prix_promo']) : null;
            $pv_val = ($pv !== null) ? "'$pv'" : 'NULL';
            $pp_val = ($pp !== null) ? "'$pp'" : 'NULL';
            $vids_esc = mysqli_real_escape_string($connexion, $vids);
            mysqli_query($connexion, "INSERT INTO `produit_variations` (`idproduit`,`valeurs_ids`,`label`,`prix_vente`,`prix_promo`) VALUES ('$idp','$vids_esc','$vlabel',$pv_val,$pp_val)");
        }
    }

    // Couleurs & Multi Uploads WebP
    $couleurs_selected = isset($_POST['couleurs_selected']) ? $_POST['couleurs_selected'] : [];
    foreach($couleurs_selected as $idcouleur) {
        $idcouleur = intval($idcouleur);
        mysqli_query($connexion, "INSERT INTO produit_couleurs (idproduit, idcouleur) VALUES ('$idp', '$idcouleur')");
        
        $input_name = "photos_couleur_" . $idcouleur;
        if(isset($_FILES[$input_name])) {
            $file_count = count($_FILES[$input_name]['name']);
            for($i=0; $i<$file_count; $i++) {
                if($_FILES[$input_name]['error'][$i] == 0 && $_FILES[$input_name]['size'][$i] > 0) {
                    $tmp_name = $_FILES[$input_name]['tmp_name'][$i];
                    $orig_name = pathinfo($_FILES[$input_name]['name'][$i], PATHINFO_FILENAME);
                    $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $idp."-c".$idcouleur."-".time()."-".$i."-".$orig_name);
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
                   	mysqli_query($connexion, "INSERT INTO produit_images_couleurs (idproduit, idcouleur, image_path) VALUES ('$idp', '$idcouleur', '$final_name')");
                        if (!isset($first_image_saved) || !$first_image_saved) {
                            executeRequete('UPDATE `produits` set `photo`="'. $final_name .'"  WHERE `id`="'.$idp.'"');
                            $first_image_saved = true;
                        }
                    }
                }
            }
        }
    }

    // ── Badges de garantie ───────────────────────────────────────────
    if (isset($_POST['badges']) && is_array($_POST['badges'])) {
        foreach ($_POST['badges'] as $badge) {
            $b_txt = trim(formReception($badge['texte']));
            $b_ico = trim(formReception($badge['icone']));
            if ($b_txt !== '') {
                $b_txt_esc = mysqli_real_escape_string($connexion, $b_txt);
                $b_ico_esc = mysqli_real_escape_string($connexion, $b_ico);
                mysqli_query($connexion, "INSERT INTO `produits_badges` (`id_produit`, `texte`, `icone`) VALUES ('$idp', '$b_txt_esc', '$b_ico_esc')");
            }
        }
    }

	phpToastRedirect("Produit ajouté avec succès !", 'index.php?r=produits', 'success');
	exit;
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
									Ajouter un produit
								</div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="admin-form-group">
                                        <label>Titre <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="titre" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>Prix vente </label>
                                                <div class="controls">
                                                    <input type="text" name="prix_vente" value="" class="admin-input"> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:none;">
                                            <div class="admin-form-group">
                                                <label>Prix promo </label>
                                                <div class="controls">
                                                    <input type="text" name="prix_promo" value="" class="admin-input"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>⭐ Note des avis <small style="color:var(--color-text-muted);font-weight:400;">(0 à 5, ex: 4.8)</small></label>
                                                <div class="controls">
                                                    <input type="number" name="note_avis" value="0" min="0" max="5" step="0.1" class="admin-input" placeholder="ex: 4.8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="admin-form-group">
                                                <label>💬 Nombre d'avis <small style="color:var(--color-text-muted);font-weight:400;">(visiteurs)</small></label>
                                                <div class="controls">
                                                    <input type="number" name="nb_avis" value="0" min="0" class="admin-input" placeholder="ex: 124">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                        
                                    <div class="admin-form-group">
                                        <label>Court contenu</label>
                                        <div class="controls">
                                          <textarea id="editor1" name="court_contenu" value="" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>                             
                                    <div class="admin-form-group">
                                        <label>Contenu</label>
                                        <div class="controls">
                                          <textarea id="editor2" name="contenu" value="" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
                                                               
                                    <div class="admin-form-group">
                                        <label>Remarque</label>
                                        <div class="controls">
                                          <textarea name="remarque" value="" class="admin-input" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <!-- ── Section Badges de garantie ── -->
                                    <div class="admin-card mb-4" style="border: 1px solid rgba(0,0,0,0.1); background: rgba(0,0,0,0.02);">
                                        <div class="admin-card-header" style="background: rgba(0,0,0,0.05); padding: 10px 15px; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                            <div class="admin-card-title" style="font-size: 0.95rem; font-weight: 600; color: inherit; display: flex; align-items: center; gap: 8px;">
                                                <i class="fa fa-shield" style="color: var(--color-primary);"></i>
                                                Badges de garantie (icône FontAwesome + texte)
                                            </div>
                                        </div>
                                        <div class="admin-card-body" style="padding: 15px;">
                                            <div id="badges-container">
                                                <!-- Row 1 (Default) -->
                                                <div class="badge-row row mb-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <input type="text" name="badges[0][icone]" value="fa fa-rotate-left" class="admin-input" placeholder="ex: fa fa-lock">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="badges[0][texte]" value="Satisfait ou remboursé 30 jours" class="admin-input" placeholder="Texte du badge">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa fa-close"></i></button>
                                                    </div>
                                                </div>
                                                <!-- Row 2 (Default) -->
                                                <div class="badge-row row mb-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <input type="text" name="badges[1][icone]" value="fa fa-truck" class="admin-input" placeholder="ex: fa fa-truck">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="badges[1][texte]" value="Livraison suivie et sécurisée" class="admin-input" placeholder="Texte du badge">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa fa-close"></i></button>
                                                    </div>
                                                </div>
                                                <!-- Row 3 (Default) -->
                                                <div class="badge-row row mb-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <input type="text" name="badges[2][icone]" value="fa fa-headphones" class="admin-input" placeholder="ex: fa fa-headset">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="badges[2][texte]" value="Support client réactif 7j/7" class="admin-input" placeholder="Texte du badge">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa fa-close"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addBadgeRow()">
                                                <i class="fa fa-plus"></i> Ajouter un badge
                                            </button>
                                            <script>
                                                let badgeIndex = 3;
                                                function addBadgeRow() {
                                                    const container = document.getElementById('badges-container');
                                                    const div = document.createElement('div');
                                                    div.className = 'badge-row row mb-2 align-items-center';
                                                    div.innerHTML = `
                                                        <div class="col-md-4">
                                                            <input type="text" name="badges[${badgeIndex}][icone]" class="admin-input" placeholder="Icone (ex: fa fa-star)">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="badges[${badgeIndex}][texte]" class="admin-input" placeholder="Texte du badge">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-danger remove-badge" onclick="this.closest('.badge-row').remove()"><i class="fa fa-close"></i></button>
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
                                                $q_colors = executeRequete("SELECT * FROM couleurs ORDER BY nom ASC");
                                                while($color = mysqli_fetch_assoc($q_colors)) {
                                                    echo '<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; background: rgba(0,0,0,0.05); padding: 5px 15px; border-radius: 20px; border: 1px solid rgba(0,0,0,0.1);">
                                                            <input type="checkbox" name="couleurs_selected[]" value="'.$color['id'].'" onchange="toggleColorUploads()">
                                                            <span style="display:inline-block; width:16px; height:16px; border-radius:50%; background-color:'.$color['code'].'; box-shadow: 0 0 0 1px rgba(0,0,0,0.2);"></span>
                                                            <span style="font-size: 0.9rem; font-weight: 500; color: inherit;">'.$color['nom'].'</span>
                                                          </label>';
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="couleurs-uploads-container">
                                            <!-- JS will populate file inputs here based on checked colors -->
                                        </div>
                                        <script>
                                        function toggleColorUploads() {
                                            const container = document.getElementById('couleurs-uploads-container');
                                            container.innerHTML = '';
                                            const checkboxes = document.querySelectorAll('input[name="couleurs_selected[]"]:checked');
                                            checkboxes.forEach(cb => {
                                                const colorName = cb.nextElementSibling.nextElementSibling.textContent.trim();
                                                const colorId = cb.value;
                                                container.innerHTML += `<div class="admin-form-group" style="padding: 15px; border-left: 4px solid var(--color-primary); background: rgba(0,0,0,0.05); border-radius: 4px; margin-bottom: 10px;">
                                                    <label style="font-weight: 600; color: inherit; margin-bottom: 8px;">Images pour la couleur <span style="color: var(--color-primary);">${colorName}</span></label>
                                                    <div class="controls">
                                                        <input type="file" name="photos_couleur_${colorId}[]" multiple class="admin-input" accept="image/jpeg, image/png, image/webp">
                                                        <small style="display: block; margin-top: 5px; color: #64748b;">Sélectionnez plusieurs images. Celles-ci seront automatiquement compressées et converties en WebP lors de l'enregistrement pour un chargement plus rapide de votre boutique.</small>
                                                    </div>
                                                </div>`;
                                            });
                                        }
                                        </script>
                                      </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Image Principale du produit</label>
                                        <div class="controls">
                                            <input type="file" name="photos[]" multiple class="admin-input" accept="image/jpeg, image/png, image/webp"> 
                                            <small style="display: block; margin-top: 5px; color: #64748b;">La première sélectionnée sera l'image principale, les autres seront des images secondaires. Elles seront optimisées (WebP).</small>
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
            	                                 $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "E" ORDER BY `ordre` ASC';
            	                                 $res = executeRequete($req);
            	                                  while ($data = mysqli_fetch_array($res)) { ?>
        	                                    <option value="<?php echo $data['id']; ?>"><?php echo afficheChamp1($data['titre']); ?></option>
                                                 <?php
        	                                      $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" AND `type` = "E" ORDER BY `ordre` ASC';
        	                                      $res1 = executeRequete($req1);
        	                                       while ($data1 = mysqli_fetch_array($res1)) { ?>
        	                                      <option value="<?php echo $data1['id']; ?>">--> <?php echo afficheChamp1($data1['titre']); ?></option>
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
													<option value="<?php echo $data['id']; ?>"><?php echo afficheChamp($data['raison']); ?></option>
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
                                                    <option value="<?php echo $idc; ?>"><?php echo $titre; ?></option>
                                                    <?php
                                                    }
                                                     ?>
                								    </select>
                								</div>
                							</div>
        							    </div>
        							</div>
        							               
									<div class="row">
										<div class="col-md-12">
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
                                    <script>
                                    // ── Combination-based pricing UI ──────────────────────────────
                                    // Groups: { idcarac: { titre, values: [{id, text}, ...] } }
                                    var caracGroups = {}; // populated by getCaracteristique()
                                    var savedVariations = {}; // key: sorted ids string => {pv, pp}

                                    function buildCaracGroups(selectedOptions) {
                                        // Reset and rebuild from the current list-carac options
                                        caracGroups = {};
                                        selectedOptions.each(function() {
                                            var opt = $(this);
                                            // text format from getCaracteristique: "TitreCarac : Valeur"
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
                                                    newResult.push(existing.concat([{
                                                        idcarac: key,
                                                        titre: groups[key].titre,
                                                        id: val.id,
                                                        text: val.text
                                                    }]));
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

                                    function updateCaracPrices() {
                                        var selectedOptions = $('#list-carac').find('option:selected');
                                        var container = $('#carac-prices-container');

                                        // Preserve current input values
                                        var currentValues = {};
                                        container.find('input[data-combo-key]').each(function() {
                                            var key = $(this).data('combo-key');
                                            var field = $(this).data('field');
                                            if (!currentValues[key]) currentValues[key] = {};
                                            currentValues[key][field] = $(this).val();
                                        });

                                        container.empty();

                                        if (selectedOptions.length === 0) {
                                            container.hide();
                                            return;
                                        }

                                        buildCaracGroups(selectedOptions);
                                        var combinations = cartesianProduct(caracGroups);

                                        if (combinations.length === 0) {
                                            container.hide();
                                            return;
                                        }

                                        container.show();
                                        var html = '<div style="background: rgba(0,0,0,0.05); padding: 15px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.1);">';
                                        html += '<h6 style="font-weight: 600; margin-bottom: 5px; color: var(--color-primary);">Prix par combinaison de caractéristiques</h6>';
                                        html += '<p style="font-size: 0.82rem; color: var(--color-text-muted); margin-bottom: 12px; opacity: 0.8;">Chaque ligne = une configuration précise du produit. Laissez vide pour hériter du prix global.</p>';
                                        html += '<table style="width:100%; text-align: left; border-collapse: collapse;">';
                                        html += '<thead style="border-bottom: 2px solid rgba(0,0,0,0.1);"><tr>';
                                        html += '<th style="padding: 8px; font-size:0.85rem;">Combinaison</th>';
                                        html += '<th style="padding: 8px; font-size:0.85rem;">Prix vente (TND)</th>';
                                        html += '<th style="padding: 8px; font-size:0.85rem; display:none;">Prix promo (TND)</th>';
                                        html += '</tr></thead><tbody>';

                                        combinations.forEach(function(combo) {
                                            var key = makeCombinationKey(combo);
                                            var label = makeCombinationLabel(combo);
                                            var pv = (currentValues[key] && currentValues[key].pv !== undefined) ? currentValues[key].pv : (savedVariations[key] ? savedVariations[key].pv : '');
                                            var pp = (currentValues[key] && currentValues[key].pp !== undefined) ? currentValues[key].pp : (savedVariations[key] ? savedVariations[key].pp : '');
                                            html += '<tr style="border-bottom: 1px solid rgba(0,0,0,0.1);">';
                                            html += '<td style="padding: 8px; font-weight: 500; font-size:0.85rem;">' + label + '</td>';
                                            html += '<td style="padding: 8px;"><input type="number" step="0.001" min="0"';
                                            html += ' name="variations[' + key + '][prix_vente]"';
                                            html += ' data-combo-key="' + key + '" data-field="pv"';
                                            html += ' data-label="' + label.replace(/"/g, '&quot;') + '"';
                                            html += ' class="admin-input" value="' + (pv || '') + '" placeholder="Prix global" style="padding: 6px 10px; height: auto; min-width:100px;"></td>';
                                            html += '<td style="padding: 8px; display:none;"><input type="number" step="0.001" min="0"';
                                            html += ' name="variations[' + key + '][prix_promo]"';
                                            html += ' data-combo-key="' + key + '" data-field="pp"';
                                            html += ' class="admin-input" value="' + (pp || '') + '" placeholder="Sans promo" style="padding: 6px 10px; height: auto; min-width:100px;"></td>';
                                            html += '</tr>';
                                            // hidden fields for valeurs_ids and label
                                            html += '<tr style="display:none;">';
                                            html += '<td colspan="3">';
                                            html += '<input type="hidden" name="variations[' + key + '][valeurs_ids]" value="' + key + '">';
                                            html += '<input type="hidden" name="variations[' + key + '][label]" value="' + label.replace(/"/g, '&quot;') + '">';
                                            html += '</td></tr>';
                                        });

                                        html += '</tbody></table></div>';
                                        container.html(html);
                                    }

                                    document.addEventListener("DOMContentLoaded", function() {
                                        var checkJquery = setInterval(function() {
                                            if (window.jQuery) {
                                                clearInterval(checkJquery);
                                                $('#list-carac').on('change', updateCaracPrices);
                                                const observer = new MutationObserver(function() { updateCaracPrices(); });
                                                if (document.getElementById('list-carac')) {
                                                    observer.observe(document.getElementById('list-carac'), { childList: true });
                                                }
                                            }
                                        }, 100);
                                    });
                                    </script>
									
									<div class="row" style="display: none;">
										<div class="col-md-6">
											<div class="admin-form-group">
											<label>Type</label>
											<div class="controls">
												<select name="type" class="admin-input" id="Type" onchange = "ShowHideDiv()">
													<option value="E" selected>Equipement</option>
													<option value="A">Abonnement</option>
												</select>
											</div>
											</div>
										</div>
									</div>
									
									<div id="selectAbonnement" style="display:none;">
									    
                                    <div class="admin-form-group">
                                        <label>Durée </label>
										<div class="controls">
                                          <input type="text" name="duree" value="" class="admin-input" placeholder="Exp : Par 6 mois,...">
                                        </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Afficher accueil</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="afficher_accueil" type="radio" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Oui</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="afficher_accueil" type="radio" checked="" value="0" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Nombre VOD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_vod" value="" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Nombre Chaine HD</label>
                                        <div class="controls">
                                          <input type="text" name="nbr_chaine_hd" value="" class="admin-input">
                                        </div>
                                    </div>
                                    
                                    </div>
									
									
                                    <div class="admin-form-group">
                                        <label>Video</label>
                                        <div class="controls">
                                          <textarea name="video" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label> Quantité </label>
                                        <div class="controls">
                                            <input type="text" name="quantite" value="" class="admin-input"> </div>
                                    </div>
									<div class="admin-form-group">
                                        <label class="control-label">Etat stock</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input id="radio1" name="etat_stock" type="radio" checked="" value="1" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">En Stock</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input id="radio2" name="etat_stock" type="radio" value="0" class="custom-control-input">
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
                                            <input type="text" name="ancre" value="" class="admin-input"> 
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-2">
                                      <div class="admin-form-group">
                                        <label>Ordre</label>
                                        <div class="controls">
                                            <input type="text" name="ordre" value="<?php echo afficheMaxOrdre('produits',1); ?>" class="admin-input"> 
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
                                                <option value="1" selected="selected">Actif</option>
                                                <option value="0">Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="admin-form-group">
                                        <label>Titre de la page </label>
                                        <div class="controls">
                                            <input type="text" name="titre_page" value="" class="admin-input"> </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Description</label>
                                        <div class="controls">
                                          <textarea name="description" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label>Keywords</label>
                                        <div class="controls">
                                          <textarea name="keywords" class="admin-input" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs-right">
                                        <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=produits'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



