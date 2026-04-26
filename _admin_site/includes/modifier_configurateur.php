<?php
$id = intval($_GET['id']);

// Suppression d'une étape
if (isset($_GET['del_etape'])) {
    $id_etape = intval($_GET['del_etape']);
    executeRequete("DELETE FROM conf_etapes WHERE id = $id_etape AND id_kit = $id");
    echo "<script>window.location.href='index.php?r=mconfigurateur&id=$id';</script>";
    exit;
}

// Modif du kit
if (isset($_POST['action']) && $_POST['action'] == 'modif_kit') {
    $titre       = formReception($_POST['titre']);
    $description = formReception($_POST['description']);
    $ordre       = formReception($_POST['ordre']);
    $etat        = formReception($_POST['etat']);

    $requete = 'UPDATE `conf_kits` SET `titre`="'.$titre.'", `description`="'.$description.'", `ordre`="'.$ordre.'", `etat`="'.$etat.'" WHERE `id`="'.$id.'"';
    $connexion = ouvrirCnx() or die("erreur cnx");
    mysqli_query($connexion, $requete);

    $photo = "";
    if(isset($_POST['icon_fa']) && trim($_POST['icon_fa']) != '') {
        $photo = formReception($_POST['icon_fa']);
    }
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0 && $_FILES['photo']['type'] != '') {
        if (in_array($_FILES['photo']['type'], ['image/jpeg','image/png','image/gif','image/webp'])) {
            $destination = str_replace(' ', '-', $id."-kit-".$_FILES['photo']['name']);
            copy($_FILES['photo']['tmp_name'], "../media/products/".$destination);
            $photo = $destination;
        }
    }
    if($photo !== "") {
        executeRequete('UPDATE `conf_kits` SET `photo`="'.$photo.'" WHERE `id`="'.$id.'"');
    }
    echo "<script>window.location.href='index.php?r=mconfigurateur&id=$id';</script>";
    exit;
}

// Ajout d'une étape (multi-sources)
if (isset($_POST['action']) && $_POST['action'] == 'add_etape') {
    $titre         = formReception($_POST['etape_titre']);
    $ordre         = intval($_POST['etape_ordre']);
    $obligatoire   = intval($_POST['etape_obligatoire']);
    $role          = formReception($_POST['etape_role'] ?? '');

    // Multi-catégories
    $cats_raw = isset($_POST['etape_categories']) && is_array($_POST['etape_categories'])
        ? array_map('intval', $_POST['etape_categories'])
        : [];
    // Multi-produits spécifiques
    $prods_raw = isset($_POST['etape_produits']) && is_array($_POST['etape_produits'])
        ? array_map('intval', $_POST['etape_produits'])
        : [];

    if (!empty($titre) && (!empty($cats_raw) || !empty($prods_raw))) {
        $cats_json  = mysqli_real_escape_string(ouvrirCnx(), json_encode($cats_raw));
        $prods_json = mysqli_real_escape_string(ouvrirCnx(), json_encode($prods_raw));

        // Déterminer type_lien et id_lien pour rétro-compatibilité
        if (!empty($cats_raw)) {
            $type_lien = 'categorie';
            $id_lien   = $cats_raw[0];
        } else {
            $type_lien = 'produit';
            $id_lien   = $prods_raw[0];
        }

        $req = "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, categories_ids, produits_ids, ordre, choix_multiple, obligatoire, role)
                VALUES ('$id', '$titre', '$type_lien', '$id_lien', '$cats_json', '$prods_json', '$ordre', '0', '$obligatoire', '$role')";
        executeRequete($req);
    }
    echo "<script>window.location.href='index.php?r=mconfigurateur&id=$id';</script>";
    exit;
}

// Chargement des données du kit
$req = "SELECT * FROM conf_kits WHERE id = $id";
$res = executeRequete($req);
$kit = mysqli_fetch_array($res);
if(!$kit) { die("Kit introuvable."); }

// Chargement des catégories pour les selects
$allCats = [];
$reqCat = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" AND `type` = "E" ORDER BY `ordre` ASC';
$resCat = executeRequete($reqCat);
while ($datCat = mysqli_fetch_array($resCat)) {
    $allCats[] = ['id' => $datCat['id'], 'titre' => afficheChamp($datCat['titre']), 'level' => 0];
    $reqSub = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$datCat['id'].'" AND `type` = "E" ORDER BY `ordre` ASC';
    $resSub = executeRequete($reqSub);
    while ($datSub = mysqli_fetch_array($resSub)) {
        $allCats[] = ['id' => $datSub['id'], 'titre' => afficheChamp($datSub['titre']), 'level' => 1];
    }
}
?>

<div class="row">
    <!-- BLOC GAUCHE : Modifier le Kit -->
    <div class="col-md-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <i class="fa fa-cog" style="color:var(--color-primary);"></i>
                    Paramètres du Système (Kit)
                </div>
            </div>
            <div class="admin-card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="admin-form-group">
                        <label>Titre du Kit <span class="text-danger">*</span></label>
                        <input type="text" name="titre" value="<?php echo afficheChamp($kit['titre']); ?>" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Description courte</label>
                        <textarea name="description" class="admin-input" rows="3"><?php echo afficheChamp($kit['description']); ?></textarea>
                    </div>

                    <?php if($kit['photo']): ?>
                    <div class="mb-3 p-2 border rounded" style="display:inline-block;">
                        <?php if (strpos($kit['photo'], 'fa-') !== false || substr($kit['photo'], 0, 3) === 'fa '): ?>
                            <i class="<?php echo htmlspecialchars($kit['photo']); ?>" style="font-size: 32px; color: var(--color-primary);"></i>
                        <?php else: ?>
                            <img src="../media/products/<?php echo htmlspecialchars($kit['photo']); ?>" style="max-width:80px; border-radius:6px;">
                        <?php endif; ?>
                        <span class="text-xs text-gray-500 d-block mt-1"><?php echo htmlspecialchars($kit['photo']); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="admin-form-group">
                        <label><i class="fa fa-flag text-primary"></i> Icône FontAwesome <small class="text-muted">(ex: fa fa-video-camera)</small></label>
                        <input type="text" name="icon_fa" class="admin-input" placeholder="fa fa-video-camera" value="">
                    </div>
                    <div class="admin-form-group">
                        <label><i class="fa fa-image text-primary"></i> Ou uploader une image</label>
                        <input type="file" name="photo" class="admin-input">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="admin-form-group">
                                <label>Ordre</label>
                                <input type="number" name="ordre" value="<?php echo $kit['ordre']; ?>" class="admin-input">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="admin-form-group">
                                <label>État</label>
                                <select name="etat" class="admin-input">
                                    <option value="1" <?php if($kit['etat']==1) echo 'selected'; ?>>Actif</option>
                                    <option value="0" <?php if($kit['etat']==0) echo 'selected'; ?>>Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs-right mt-3">
                        <button type="submit" class="admin-btn admin-btn-primary w-100">
                            <i class="fa fa-save"></i> Enregistrer les modifications
                        </button>
                        <input name="action" type="hidden" value="modif_kit">
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box Rôles Intelligents -->
        <div class="admin-card mt-3" style="border-left: 4px solid #f59e0b;">
            <div class="admin-card-body" style="padding: 14px;">
                <h6 style="font-weight:700; color:#92400e; margin-bottom:8px;">
                    <i class="fa fa-lightbulb-o"></i> Validation intelligente DVR/Caméras
                </h6>
                <p style="font-size:0.82rem; color:#78350f; margin-bottom:8px;">
                    Assignez un <strong>Rôle</strong> à chaque étape. Le frontend vérifiera automatiquement la compatibilité :
                </p>
                <table style="width:100%; font-size:0.78rem; border-collapse:collapse;">
                    <tr style="background:#fef3c7;">
                        <th style="padding:4px 8px; text-align:left;">Rôle à saisir</th>
                        <th style="padding:4px 8px; text-align:left;">Signification</th>
                    </tr>
                    <tr><td style="padding:3px 8px;"><code>dvr</code></td><td style="padding:3px 8px;">Enregistreur DVR filaire</td></tr>
                    <tr style="background:#fef9ee;"><td style="padding:3px 8px;"><code>nvr</code></td><td style="padding:3px 8px;">Enregistreur NVR IP</td></tr>
                    <tr><td style="padding:3px 8px;"><code>camera_filaire</code></td><td style="padding:3px 8px;">Caméras filaires (AHD/HDCVI)</td></tr>
                    <tr style="background:#fef9ee;"><td style="padding:3px 8px;"><code>camera_wifi</code></td><td style="padding:3px 8px;">Caméras WiFi IP</td></tr>
                    <tr><td style="padding:3px 8px;"><code>hdd</code></td><td style="padding:3px 8px;">Disque dur</td></tr>
                    <tr style="background:#fef9ee;"><td style="padding:3px 8px;"><code>cable</code></td><td style="padding:3px 8px;">Câbles / Alimentation</td></tr>
                </table>
                <p style="font-size:0.75rem; color:#78350f; margin-top:8px;">
                    <strong>Règle :</strong> Si une étape <code>dvr</code> ou <code>nvr</code> est choisie, 
                    le nombre de caméras (<code>camera_filaire</code> ou <code>camera_wifi</code>) ne peut pas dépasser 
                    le nombre de canaux.<br>
                    <strong>Détection canaux :</strong> Via la caractéristique produit nommée <em>"Nombre de Canaux"</em> 
                    ou depuis le titre (ex: "4 canaux", "8CH", "16 voies").
                </p>
            </div>
        </div>
    </div>

    <!-- BLOC DROIT : Gestion des étapes -->
    <div class="col-md-7">
        <div class="admin-card">
            <div class="admin-card-header" style="justify-content: space-between;">
                <div class="admin-card-title">
                    <i class="fa fa-list-ol" style="color:var(--color-primary);"></i>
                    Étapes de configuration
                </div>
                <button type="button" class="admin-btn admin-btn-primary" onclick="toggleAddForm()">
                    + Ajouter une étape
                </button>
            </div>
            <div class="admin-card-body">

                <!-- Formulaire d'ajout -->
                <div id="add-etape-form" style="display:none; background: var(--color-bg-alt, #f8fafc); border: 1px solid var(--color-border, #e2e8f0); border-radius: 8px; padding: 16px; margin-bottom: 16px;">
                    <h5 style="font-weight:700; margin-bottom:12px; color:var(--color-primary);">
                        <i class="fa fa-plus-circle"></i> Nouvelle étape
                    </h5>
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="admin-form-group">
                                    <label>Titre de l'étape <span class="text-danger">*</span></label>
                                    <input type="text" name="etape_titre" class="admin-input" placeholder="Ex: Enregistreur DVR, Caméras..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="admin-form-group">
                                    <label>Rôle intelligent</label>
                                    <select name="etape_role" class="admin-input">
                                        <option value="">-- Aucun --</option>
                                        <option value="dvr">dvr (Enregistreur DVR)</option>
                                        <option value="nvr">nvr (Enregistreur NVR)</option>
                                        <option value="camera_filaire">camera_filaire</option>
                                        <option value="camera_wifi">camera_wifi</option>
                                        <option value="hdd">hdd (Disque Dur)</option>
                                        <option value="cable">cable</option>
                                        <option value="switch">switch</option>
                                        <option value="alimentation">alimentation</option>
                                        <option value="accessoire">accessoire</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="admin-form-group">
                                    <label>Obligatoire ?</label>
                                    <select name="etape_obligatoire" class="admin-input">
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Catégories multiples -->
                        <div class="admin-form-group">
                            <label>
                                <i class="fa fa-folder text-primary"></i>
                                Catégories / Sous-catégories <small class="text-muted">(sélection multiple avec Ctrl+Clic)</small>
                            </label>
                            <select name="etape_categories[]" class="admin-input" multiple style="height: 130px;">
                                <?php foreach($allCats as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo $cat['level'] === 1 ? '--> ' : ''; ?><?php echo $cat['titre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted d-block mt-1">
                                <i class="fa fa-info-circle"></i> Tous les produits des catégories sélectionnées seront proposés au client.
                            </small>
                        </div>

                        <!-- Produits spécifiques multiples -->
                        <div class="admin-form-group">
                            <label>
                                <i class="fa fa-cube text-primary"></i>
                                Produits spécifiques <small class="text-muted">(optionnel, en plus des catégories)</small>
                            </label>
                            <div style="position:relative;">
                                <input type="text" id="produit-search" class="admin-input" placeholder="Rechercher un produit..." style="margin-bottom:6px;" oninput="filterProduits(this.value)">
                                <select name="etape_produits[]" id="produits-select" class="admin-input" multiple style="height: 130px;">
                                    <?php
                                    $reqProd = 'SELECT id, titre FROM `produits` WHERE `etat` = "1" ORDER BY `titre` ASC';
                                    $resProd = executeRequete($reqProd);
                                    while ($prod = mysqli_fetch_array($resProd)) {
                                        // Decode HTML entities first to avoid double-encoding (e.g. Cam&eacute;ra)
                                        $titre_clean = html_entity_decode(afficheChamp($prod['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        echo '<option value="'.$prod['id'].'" data-titre="'.htmlspecialchars(strtolower($titre_clean), ENT_QUOTES, 'UTF-8').'">';
                                        echo htmlspecialchars($titre_clean, ENT_QUOTES, 'UTF-8');
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="fa fa-info-circle"></i> Ces produits seront <strong>ajoutés en plus</strong> de ceux des catégories.
                            </small>
                        </div>

                        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:10px;">
                            <?php
                            $res_cnt = executeRequete('SELECT COUNT(*) as nb FROM conf_etapes WHERE id_kit=' . $id);
                            $cnt_row = mysqli_fetch_assoc($res_cnt);
                            $next_ordre = intval($cnt_row['nb']) + 1;
                            ?>
                            <input type="number" name="etape_ordre" class="admin-input" value="<?php echo $next_ordre; ?>" style="width:80px;" placeholder="Ordre">
                        </div>

                        <div class="mt-2" style="display:flex; gap:8px; flex-wrap:wrap;">
                            <button type="submit" class="admin-btn admin-btn-primary">
                                <i class="fa fa-save"></i> Enregistrer l'étape
                            </button>
                            <button type="button" class="admin-btn admin-btn-ghost" onclick="toggleAddForm()">
                                Annuler
                            </button>
                            <input name="action" type="hidden" value="add_etape">
                        </div>
                    </form>
                </div>

                <!-- Liste des étapes (drag & drop) -->
                <div class="table-responsive">
                    <table class="admin-table" id="etapes-table">
                        <thead>
                            <tr>
                                <th style="width:60px;">Ordre</th>
                                <th>Titre / Rôle</th>
                                <th>Sources</th>
                                <th style="width:80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $reqE = "SELECT * FROM conf_etapes WHERE id_kit = $id ORDER BY ordre ASC";
                        $resE = executeRequete($reqE);
                        if(mysqli_num_rows($resE) > 0) {
                            while($e = mysqli_fetch_array($resE)) {
                                // Construire le résumé des sources
                                $sources_html = '';

                                // Catégories (nouvelle colonne JSON)
                                $cats_ids = [];
                                if (!empty($e['categories_ids'])) {
                                    $cats_ids = json_decode($e['categories_ids'], true) ?: [];
                                } elseif ($e['type_lien'] == 'categorie' && $e['id_lien']) {
                                    $cats_ids = [$e['id_lien']];
                                }
                                foreach ($cats_ids as $cid) {
                                    $cid = intval($cid);
                                    if ($cid <= 0) continue;
                                    $rc = executeRequete("SELECT titre FROM categories_blog WHERE id = $cid");
                                    if ($c = mysqli_fetch_array($rc)) {
                                        $t = html_entity_decode(afficheChamp($c['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        $sources_html .= '<span style="display:inline-block; background:#dbeafe; color:#1e40af; border-radius:4px; padding:1px 6px; font-size:0.72rem; margin:1px;">'
                                            .'<i class="fa fa-folder"></i> '.htmlspecialchars($t, ENT_QUOTES, 'UTF-8').'</span>';
                                    }
                                }

                                // Produits spécifiques (nouvelle colonne JSON)
                                $prods_ids = [];
                                if (!empty($e['produits_ids'])) {
                                    $prods_ids = json_decode($e['produits_ids'], true) ?: [];
                                } elseif ($e['type_lien'] == 'produit' && $e['id_lien']) {
                                    $prods_ids = [$e['id_lien']];
                                }
                                foreach ($prods_ids as $pid) {
                                    $pid = intval($pid);
                                    if ($pid <= 0) continue;
                                    $rp = executeRequete("SELECT titre FROM produits WHERE id = $pid");
                                    if ($p = mysqli_fetch_array($rp)) {
                                        $t = html_entity_decode(afficheChamp($p['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        $sources_html .= '<span style="display:inline-block; background:#dcfce7; color:#166534; border-radius:4px; padding:1px 6px; font-size:0.72rem; margin:1px;">'
                                            .'<i class="fa fa-cube"></i> '.htmlspecialchars($t, ENT_QUOTES, 'UTF-8').'</span>';
                                    }
                                }

                                $role_badge = '';
                                if (!empty($e['role'])) {
                                    $role_badge = '<span style="display:inline-block; background:#fef3c7; color:#92400e; border-radius:4px; padding:1px 6px; font-size:0.7rem; margin-top:3px;">'
                                        .'<i class="fa fa-tag"></i> '.$e['role'].'</span>';
                                }
                        ?>
                            <tr data-id="<?php echo $e['id']; ?>">
                                <td>
                                    <i class="fa fa-arrows-v drag-handle" style="cursor:grab; color:#94a3b8; margin-right:6px;"></i>
                                    <strong><?php echo $e['ordre']; ?></strong>
                                </td>
                                <td>
                                    <div style="font-weight:600; font-size:0.88rem;"><?php echo htmlspecialchars(afficheChamp($e['titre'])); ?></div>
                                    <?php echo $role_badge; ?>
                                    <div style="font-size:0.75rem; margin-top:2px;">
                                        <?php if($e['obligatoire']==1): ?>
                                            <span style="color:#dc2626; font-weight:600;">● Obligatoire</span>
                                        <?php else: ?>
                                            <span style="color:#6b7280;">○ Optionnel</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td style="font-size:0.78rem; max-width:200px;">
                                    <?php echo $sources_html ?: '<span class="text-muted">Aucune source</span>'; ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="confirmGlobalDelete('index.php?r=mconfigurateur&id=<?php echo $id; ?>&del_etape=<?php echo $e['id']; ?>')"
                                       class="p-1 text-red-600" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr><td colspan="4" class="text-center p-4 text-gray-500">Aucune étape. Cliquez sur "+ Ajouter une étape".</td></tr>
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
function toggleAddForm() {
    var f = document.getElementById('add-etape-form');
    f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'block' : 'none';
}

function filterProduits(query) {
    var select = document.getElementById('produits-select');
    var q = query.toLowerCase().trim();
    Array.from(select.options).forEach(function(opt) {
        var titre = opt.getAttribute('data-titre') || '';
        opt.style.display = (q === '' || titre.includes(q)) ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var tbody = document.querySelector('#etapes-table tbody');
    if (tbody && typeof Sortable !== 'undefined') {
        Sortable.create(tbody, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-blue-50',
            onEnd: function () {
                var rows = tbody.querySelectorAll('tr[data-id]');
                var ids = Array.from(rows).map(function(r) { return r.getAttribute('data-id'); });

                $.ajax({
                    url: 'ajax_order_conf_etapes.php',
                    method: 'POST',
                    data: { ids: ids },
                    success: function(response) {
                        try {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                if (typeof showToast === 'function') showToast('Ordre mis à jour ✓', 'success');
                                // Update displayed numbers
                                rows.forEach(function(r, i) {
                                    var strong = r.querySelector('td:first-child strong');
                                    if (strong) strong.textContent = (i + 1);
                                });
                            } else {
                                if (typeof showToast === 'function') showToast('Erreur: ' + res.message, 'error');
                            }
                        } catch(e) {
                            if (typeof showToast === 'function') showToast('Erreur de communication', 'error');
                        }
                    },
                    error: function() {
                        if (typeof showToast === 'function') showToast('Erreur serveur', 'error');
                    }
                });
            }
        });
    }
});
</script>
