<?php 
// ── Action: supprimer l'image uploadée (photo) ──────────────────────────
if (isset($_GET['action']) && $_GET['action'] == 'del_photo') {
    $idsc_del = intval($_GET['idsc']);
    $idb_del  = intval($_GET['idb']);
    $r_del = executeRequete("SELECT photo FROM liste_section_content WHERE id='$idsc_del' LIMIT 1");
    $d_del = mysqli_fetch_array($r_del);
    if (!empty($d_del['photo'])) {
        @unlink('../media/site/' . $d_del['photo']);
    }
    executeRequete("UPDATE liste_section_content SET photo='' WHERE id='$idsc_del'");
    ?>
    <script>window.location = 'index.php?r=editSectionContent&idsc=<?php echo $idsc_del; ?>&idb=<?php echo $idb_del; ?>';</script>
    <?php exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'del_photo_m') {
    $idsc_del = intval($_GET['idsc']);
    $idb_del  = intval($_GET['idb']);
    supprimerImageMobileSectionContent($idsc_del);
    ?>
    <script>window.location = 'index.php?r=editSectionContent&idsc=<?php echo $idsc_del; ?>&idb=<?php echo $idb_del; ?>';</script>
    <?php exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'del_photo_t') {
    $idsc_del = intval($_GET['idsc']);
    $idb_del  = intval($_GET['idb']);
    supprimerImageTabletSectionContent($idsc_del);
    ?>
    <script>window.location = 'index.php?r=editSectionContent&idsc=<?php echo $idsc_del; ?>&idb=<?php echo $idb_del; ?>';</script>
    <?php exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'mod' ){
	$idbloc = formReception($_POST['id']);
	$idsc   = formReception($_POST['idsc']);
	$lien   = formReception($_POST['lien']);
	$titre  = isset($_POST['titre']) ? formReception($_POST['titre']) : '';
	$contenu= isset($_POST['contenu']) ? formReception($_POST['contenu']) : '';
	$icone  = isset($_POST['icone']) ? formReception($_POST['icone']) : '';
	$lien_url = isset($_POST['lien_url']) ? formReception($_POST['lien_url']) : '';
	$titre_bouton = isset($_POST['titre_bouton']) ? formReception($_POST['titre_bouton']) : '';
	
		$requete = 'UPDATE `liste_section_content` SET `lien` = "'. $lien .'", `titre` = "'.$titre.'", `contenu` = "'.$contenu.'", `icone` = "'.$icone.'", `lien_url` = "'.$lien_url.'", `titre_bouton` = "'.$titre_bouton.'" WHERE `id`="'.$idsc.'"';
		$result = executeRequete($requete);	
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" || $_FILES['image']['type']=="image/webp"){
			$destination = str_replace(' ', '-', $idsc."-section-content-".$_FILES['image']['name']);
			$destination = str_replace('é', 'e', $destination);
			$destination = str_replace('è', 'e', $destination);
			$destination = str_replace('à', 'a', $destination);
			$destination = str_replace('ù', 'u', $destination);
			$destination = str_replace('ç', 'c', $destination);

			copy ($_FILES['image']['tmp_name'], "../media/site/".$destination);
			$photo = $destination;
			$requete = 'UPDATE `liste_section_content` set `photo`="'. $photo .'"  WHERE `id`="'.$idsc.'"';
			$result = executeRequete($requete);	
		}
	}
	if (isset($_FILES['photo_mobile']) && $_FILES['photo_mobile']['type'] != '') {
		if ($_FILES['photo_mobile']['type']=="image/jpeg" || $_FILES['photo_mobile']['type']=="image/png" || $_FILES['photo_mobile']['type']=="image/gif" || $_FILES['photo_mobile']['type']=="image/webp"){
			$destination = str_replace(' ', '-', $idsc."-section-content-mobile-".$_FILES['photo_mobile']['name']);
			$destination = str_replace(['é','è','à','ù','ç'], ['e','e','a','u','c'], $destination);
			copy ($_FILES['photo_mobile']['tmp_name'], "../media/site/".$destination);
			$photo_mobile = $destination;
			executeRequete('UPDATE `liste_section_content` set `photo_mobile`="'. $photo_mobile .'"  WHERE `id`="'.$idsc.'"');
		}
	}
	if (isset($_FILES['photo_tablet']) && $_FILES['photo_tablet']['type'] != '') {
		if ($_FILES['photo_tablet']['type']=="image/jpeg" || $_FILES['photo_tablet']['type']=="image/png" || $_FILES['photo_tablet']['type']=="image/gif" || $_FILES['photo_tablet']['type']=="image/webp"){
			$destination = str_replace(' ', '-', $idsc."-section-content-tablet-".$_FILES['photo_tablet']['name']);
			$destination = str_replace(['é','è','à','ù','ç'], ['e','e','a','u','c'], $destination);
			copy ($_FILES['photo_tablet']['tmp_name'], "../media/site/".$destination);
			$photo_tablet = $destination;
			executeRequete('UPDATE `liste_section_content` set `photo_tablet`="'. $photo_tablet .'"  WHERE `id`="'.$idsc.'"');
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addSectionContent&id=<?php echo $idbloc; ?>';
	-->
	</script>
	<?php
	//echo $strSQL
}
?>
                
                <?php
                $req_sc = executeRequete("SELECT * FROM liste_section_content WHERE id='".intval($_GET['idsc'])."'");
                $data_sc = mysqli_fetch_array($req_sc);
                $current_img = '';
                if (!empty($data_sc['photo']) && file_exists("../".'media/site/'.$data_sc['photo'])) {
                    $current_img = 'media/site/' . $data_sc['photo'];
                } elseif (!empty($data_sc['lien_url'])) {
                    $current_img = $data_sc['lien_url'];
                }
                ?>

<div class="row">
    <div class="col-12">
        <!-- Page header -->
        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem;">
            <a href="index.php?r=addSectionContent&id=<?php echo intval($_GET['idb']); ?>" 
               style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; background:var(--color-surface); border:1px solid var(--color-border); border-radius:0.625rem; color:var(--color-text-secondary); text-decoration:none; font-size:0.875rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Retour à la liste
            </a>
            <div class="admin-card-title" style="margin:0;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;display:inline;vertical-align:middle;color:var(--color-primary);margin-right:6px;">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Modifier l'élément de section
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-body">
                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">

                    <!-- IMAGE SECTION -->
                    <div style="background:color-mix(in srgb, var(--color-primary) 4%, transparent); border:1px dashed color-mix(in srgb, var(--color-primary) 35%, transparent); border-radius:0.75rem; padding:1.25rem; margin-bottom:1.5rem;">
                        <label style="font-weight:700; font-size:0.875rem; color:var(--color-primary); display:block; margin-bottom:1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Image / Visuel
                        </label>

                        <div class="row">
                            <div class="col-md-4">
                                <?php if ($current_img): ?>
                                <div style="margin-bottom:1rem; text-align:center; position:relative; display:inline-block;">
                                    <img id="img-preview" src="../<?php echo htmlspecialchars($current_img); ?>" 
                                         style="max-height:100px; max-width:180px; object-fit:contain; border-radius:0.5rem; border:1px solid var(--color-border); display:block;"
                                         onerror="this.style.display='none'">
                                    <div style="font-size:0.75rem; color:var(--color-text-muted); margin-top:0.5rem;">Image Desktop <br>(Défaut)</div>
                                    <?php if (!empty($data_sc['photo'])): ?>
                                    <a href="index.php?r=editSectionContent&action=del_photo&idsc=<?php echo intval($_GET['idsc']); ?>&idb=<?php echo intval($_GET['idb']); ?>"
                                       onclick="return confirm('Supprimer cette image ?')"
                                       style="position:absolute; top:-8px; right:-8px; width:22px; height:22px; background:#ef4444; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; text-decoration:none; line-height:1; box-shadow:0 1px 4px rgba(0,0,0,0.3);" title="Supprimer l'image">×</a>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div style="margin-bottom:1rem; text-align:center;">
                                    <img id="img-preview" src="" style="max-height:100px; max-width:180px; object-fit:contain; border-radius:0.5rem; border:1px solid var(--color-border); display:none;" onerror="this.style.display='none'">
                                    <div id="img-preview-label" style="font-size:0.75rem; color:var(--color-text-muted); margin-top:0.5rem; display:none;">Image Desktop <br>(Défaut)</div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label style="font-size:0.75rem; font-weight:600;">Modifier Image Desktop</label>
                                    <input type="file" name="image" accept="image/*" class="admin-input" style="padding:0.4rem;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <?php if (!empty($data_sc['photo_tablet']) && file_exists("../media/site/".$data_sc['photo_tablet'])): ?>
                                <div style="margin-bottom:1rem; text-align:center; position:relative; display:inline-block;">
                                    <img src="../media/site/<?php echo htmlspecialchars($data_sc['photo_tablet']); ?>" 
                                         style="max-height:100px; max-width:180px; object-fit:contain; border-radius:0.5rem; border:1px solid var(--color-border); display:block;">
                                    <div style="font-size:0.75rem; color:var(--color-text-muted); margin-top:0.5rem;">Image Tablette<br>(Optionnel)</div>
                                    <a href="index.php?r=editSectionContent&action=del_photo_t&idsc=<?php echo intval($_GET['idsc']); ?>&idb=<?php echo intval($_GET['idb']); ?>"
                                       onclick="return confirm('Supprimer cette image ?')"
                                       style="position:absolute; top:-8px; right:-8px; width:22px; height:22px; background:#ef4444; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; text-decoration:none; line-height:1; box-shadow:0 1px 4px rgba(0,0,0,0.3);" title="Supprimer l'image">×</a>
                                </div>
                                <?php else: ?>
                                <div style="margin-bottom:1rem; text-align:center;">
                                    <div style="font-size:0.75rem; color:var(--color-text-muted); padding:30px; border:1px dashed var(--color-border); border-radius:0.5rem;">Aucune image<br>tablette</div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label style="font-size:0.75rem; font-weight:600;">Modifier Image Tablette</label>
                                    <input type="file" name="photo_tablet" accept="image/*" class="admin-input" style="padding:0.4rem;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <?php if (!empty($data_sc['photo_mobile']) && file_exists("../media/site/".$data_sc['photo_mobile'])): ?>
                                <div style="margin-bottom:1rem; text-align:center; position:relative; display:inline-block;">
                                    <img src="../media/site/<?php echo htmlspecialchars($data_sc['photo_mobile']); ?>" 
                                         style="max-height:100px; max-width:180px; object-fit:contain; border-radius:0.5rem; border:1px solid var(--color-border); display:block;">
                                    <div style="font-size:0.75rem; color:var(--color-text-muted); margin-top:0.5rem;">Image Mobile<br>(Optionnel)</div>
                                    <a href="index.php?r=editSectionContent&action=del_photo_m&idsc=<?php echo intval($_GET['idsc']); ?>&idb=<?php echo intval($_GET['idb']); ?>"
                                       onclick="return confirm('Supprimer cette image ?')"
                                       style="position:absolute; top:-8px; right:-8px; width:22px; height:22px; background:#ef4444; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; text-decoration:none; line-height:1; box-shadow:0 1px 4px rgba(0,0,0,0.3);" title="Supprimer l'image">×</a>
                                </div>
                                <?php else: ?>
                                <div style="margin-bottom:1rem; text-align:center;">
                                    <div style="font-size:0.75rem; color:var(--color-text-muted); padding:30px; border:1px dashed var(--color-border); border-radius:0.5rem;">Aucune image<br>mobile</div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label style="font-size:0.75rem; font-weight:600;">Modifier Image Mobile</label>
                                    <input type="file" name="photo_mobile" accept="image/*" class="admin-input" style="padding:0.4rem;">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="font-size:0.8125rem; font-weight:600; display:flex; align-items:center; gap:6px; margin-bottom:0.5rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                        OU : Chemin relatif de l'image (Desktop)
                                    </label>
                                    <input type="text" name="lien_url" id="lien_url_input" class="admin-input" 
                                           value="<?php echo htmlspecialchars($data_sc['lien_url'] ?? ''); ?>"
                                           placeholder="media/products/nom-produit.jpg"
                                           oninput="updateImgPreview(this.value)">
                                    <small style="color:var(--color-text-muted); font-size:0.75rem; display:block; margin-top:4px;">
                                        ✅ Compatible localhost & serveur de production — ne pas mettre l'adresse du site.
                                        <br>Exemple : <code>media/products/image.jpg</code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT SECTION -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Titre / Texte principal</label>
                                <div class="controls">
                                    <input type="text" name="titre" value="<?php echo htmlspecialchars($data_sc['titre'] ?? ''); ?>" class="admin-input" placeholder="Ex: Nos Smartphones">
                                    <small style="color:var(--color-text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                                        Ce titre sera affiché sur la bannière dans la page d'accueil.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contenu / Sous-titre <small style="color:var(--color-text-muted)">(Pour Trust)</small></label>
                                <div class="controls">
                                    <textarea name="contenu" class="admin-input" rows="2"><?php echo htmlspecialchars($data_sc['contenu'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Lien de destination</label>
                                <div class="controls">
                                    <input type="text" name="lien" value="<?php echo htmlspecialchars($data_sc['lien'] ?? ''); ?>" class="admin-input" placeholder="categorie.php?link=smartphones">
                                    <small style="color:var(--color-text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                                        Lien relatif (ex: <code>categorie.php?link=smartphones</code>) ou lien absolu.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Texte du bouton (Optionnel)</label>
                                <div class="controls">
                                    <input type="text" name="titre_bouton" value="<?php echo htmlspecialchars($data_sc['titre_bouton'] ?? ''); ?>" class="admin-input" placeholder="Ex: Découvrez, Acheter, Voir plus...">
                                    <small style="color:var(--color-text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                                        S'affichera sur le bouton. Si vide et qu'un lien est présent, affiche "Découvrir".
                                    </small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Icône FontAwesome <small style="color:var(--color-text-muted)">(ex: fa-solid fa-truck)</small></label>
                                <div class="controls">
                                    <input type="text" name="icone" value="<?php echo htmlspecialchars($data_sc['icone'] ?? ''); ?>" class="admin-input" placeholder="fa-brands fa-whatsapp">
                                    <small style="margin-top:0.25rem; display:block;">
                                        <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" style="color:var(--color-primary); text-decoration:underline; font-size:0.75rem;">
                                            Chercher une icône
                                        </a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs-right" style="margin-top:1rem;">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle; margin-right:4px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Enregistrer
                        </button>
                        <input name="action" type="hidden" id="action" value="mod">
                        <button type="button" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=addSectionContent&id=<?php echo intval($_GET['idb']); ?>'">
                            Annuler
                        </button>
                        <input type="hidden" name="id" value="<?php echo intval($_GET['idb']); ?>" />
                        <input type="hidden" name="idsc" value="<?php echo intval($_GET['idsc']); ?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateImgPreview(val) {
    var img = document.getElementById('img-preview');
    var lbl = document.getElementById('img-preview-label');
    if (!img) return;
    if (val.trim() === '') {
        img.style.display = 'none';
        if (lbl) lbl.style.display = 'none';
        return;
    }
    // Try relative path from site root (admin is one level deeper)
    img.src = '../' + val.trim();
    img.style.display = 'block';
    img.onerror = function() { this.src = val.trim(); }; // fallback: try as-is
    if (lbl) lbl.style.display = 'block';
}
// Init preview if lien_url is pre-filled and there is no uploaded photo
(function(){
    var hasPhoto = <?php echo (!empty($data_sc['photo'])) ? 'true' : 'false'; ?>;
    if (!hasPhoto) {
        var inp = document.getElementById('lien_url_input');
        if (inp && inp.value) updateImgPreview(inp.value);
    }
})();
</script>