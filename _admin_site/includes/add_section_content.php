<?php 
if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
    $idb   = $_GET['idb'];
    supprimerSectionContent($_GET['idsc']);
    ?>
    <script>window.location = 'index.php?r=addSectionContent&id=<?php echo $idb; ?>';</script>
    <?php exit;
}

if (isset($_GET['action']) && ($_GET['action'] == 'del_photo' || $_GET['action'] == 'del_photo_m' || $_GET['action'] == 'del_photo_t')) {
    $idsc_del = intval($_GET['idsc']);
    $idb_del  = intval($_GET['idb']);
    
    if($_GET['action'] == 'del_photo') {
        $r_del = executeRequete("SELECT photo FROM liste_section_content WHERE id='$idsc_del'");
        $d_del = mysqli_fetch_array($r_del);
        if (!empty($d_del['photo'])) @unlink('../media/site/' . $d_del['photo']);
        executeRequete("UPDATE liste_section_content SET photo='' WHERE id='$idsc_del'");
    } elseif($_GET['action'] == 'del_photo_m') {
        supprimerImageMobileSectionContent($idsc_del);
    } elseif($_GET['action'] == 'del_photo_t') {
        supprimerImageTabletSectionContent($idsc_del);
    }
    
    ?>
    <script>window.location = 'index.php?r=addSectionContent&id=<?php echo $idb_del; ?>';</script>
    <?php exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'ajt' ){
	// Prevent VPS silent crashes on large image conversions
	ini_set('memory_limit', '512M');
	set_time_limit(300);
	$idbloc   = formReception($_POST['id']);
	$titre    = isset($_POST['titre']) ? formReception($_POST['titre']) : '';
	$contenu  = isset($_POST['contenu']) ? formReception($_POST['contenu']) : '';
	$icone    = isset($_POST['icone']) ? formReception($_POST['icone']) : '';
	$lien     = isset($_POST['lien']) ? formReception($_POST['lien']) : '';
	$lien_url = isset($_POST['lien_url']) ? formReception($_POST['lien_url']) : '';
	$titre_bouton = isset($_POST['titre_bouton']) ? formReception($_POST['titre_bouton']) : '';
	
		$requete = 'INSERT INTO `liste_section_content` (`idbloc`,`lien`,`titre`,`contenu`,`icone`,`lien_url`,`titre_bouton`) VALUES ("'. $idbloc .'","'. $lien .'","'. $titre .'","'. $contenu .'","'. $icone .'","'. $lien_url .'","'. $titre_bouton .'")';
		
		$connexion = ouvrirCnx() or die("erreur cnx");
		$result    = mysqli_query($connexion, $requete);	
		$idc       = mysqli_insert_id($connexion);
		
	if (isset($_FILES['image']) && $_FILES['image']['type'] != '') {
		if ($_FILES['image']['type']=="image/jpeg" || $_FILES['image']['type']=="image/png" || $_FILES['image']['type']=="image/gif" || $_FILES['image']['type']=="image/webp" ){
            $orig_name = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
            $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $idc."-sc-".time()."-".$orig_name);
            $dest_base = "../media/site/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['image']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo = $webp_name;
            } else {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                copy($_FILES['image']['tmp_name'], $dest_base . "." . $ext);
                $photo = $base_name . "." . $ext;
            }
			executeRequete('UPDATE `liste_section_content` set `photo`="'. $photo .'"  WHERE `id`="'.$idc.'"');	
		}
	}
	if (isset($_FILES['photo_mobile']) && $_FILES['photo_mobile']['type'] != '') {
		if ($_FILES['photo_mobile']['type']=="image/jpeg" || $_FILES['photo_mobile']['type']=="image/png" || $_FILES['photo_mobile']['type']=="image/gif" || $_FILES['photo_mobile']['type']=="image/webp"){
            $orig_name = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_FILENAME);
            $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $idc."-scm-".time()."-".$orig_name);
            $dest_base = "../media/site/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_mobile']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_mobile = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_mobile']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['photo_mobile']['tmp_name'], $dest_base . "." . $ext);
                $photo_mobile = $base_name . "." . $ext;
            }
			executeRequete('UPDATE `liste_section_content` set `photo_mobile`="'. $photo_mobile .'"  WHERE `id`="'.$idc.'"');
		}
	}
	if (isset($_FILES['photo_tablet']) && $_FILES['photo_tablet']['type'] != '') {
		if ($_FILES['photo_tablet']['type']=="image/jpeg" || $_FILES['photo_tablet']['type']=="image/png" || $_FILES['photo_tablet']['type']=="image/gif" || $_FILES['photo_tablet']['type']=="image/webp"){
            $orig_name = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_FILENAME);
            $base_name = preg_replace('/[^A-Za-z0-9\-]/', '', $idc."-sct-".time()."-".$orig_name);
            $dest_base = "../media/site/" . $base_name;
            $webp_name = convertAndSaveWebP($_FILES['photo_tablet']['tmp_name'], $dest_base);
            
            if($webp_name) {
                $photo_tablet = $webp_name;
            } else {
                $ext = pathinfo($_FILES['photo_tablet']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['photo_tablet']['tmp_name'], $dest_base . "." . $ext);
                $photo_tablet = $base_name . "." . $ext;
            }
			executeRequete('UPDATE `liste_section_content` set `photo_tablet`="'. $photo_tablet .'"  WHERE `id`="'.$idc.'"');
		}
	}
	?>
	<script language="javascript">
	<!--
		window.location = 'index.php?r=addSectionContent&id=<?php echo $idbloc; ?>';
	-->
	</script>
	<?php
}
?>

<!-- ── Page Header ── -->
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:0.75rem;">
    <div style="display:flex; align-items:center; gap:0.75rem;">
        <a href="index.php?r=bloc_accueil" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; background:var(--color-surface); border:1px solid var(--color-border); border-radius:0.625rem; color:var(--color-text-secondary); text-decoration:none; font-size:0.875rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Blocs Accueil
        </a>
        <div class="admin-card-title" style="margin:0; font-size:1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;display:inline;vertical-align:middle;color:var(--color-primary);margin-right:6px;"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="21 15 16 10 5 21"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>
            Contenu du bloc : <strong><?php echo titreListeSection(typeSectionBloc($_GET['id'])); ?></strong>
        </div>
    </div>
</div>

<!-- ── Current Content List ── -->
<div class="admin-card" style="margin-bottom:1.5rem;">
    <div class="admin-card-body">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <h5 style="margin:0; font-weight:700; font-size:1rem;">Éléments actuels</h5>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Aperçu</th>
                        <th>Titre / Icône</th>
                        <th>Lien</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $requete = 'SELECT * FROM `liste_section_content` WHERE `idbloc` ="'.$_GET['id'].'"';
                $resultat = executeRequete($requete);
                $num = mysqli_num_rows($resultat);
                if ($num > 0 ) { 
                    while ($data = mysqli_fetch_array($resultat)) {
                        // Determine image for preview
                        $preview = '';
                        if (!empty($data['photo']) && file_exists("../media/site/".$data['photo'])) {
                            $preview = '../media/site/' . $data['photo'];
                        } elseif(!empty($data['lien_url'])) {
                            $preview = '../' . $data['lien_url'];
                        }
                ?>
                    <tr>
                        <td>
                            <?php if($preview): ?>
                                <div style="position:relative; display:inline-block;">
                                    <img src="<?php echo htmlspecialchars($preview); ?>" width="70" height="50" 
                                         style="object-fit:cover; border-radius:0.4rem; border:1px solid var(--color-border);"
                                         onerror="this.style.display='none'">
                                    
                                    <?php if(!empty($data['photo'])): ?>
                                    <a href="index.php?r=addSectionContent&id=<?php echo $_GET['id']; ?>&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>&action=del_photo"
                                       onclick="return confirm('Supprimer l\'image desktop ?')"
                                       style="position:absolute; top:-5px; right:-5px; width:18px; height:18px; background:#ef4444; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; text-decoration:none; box-shadow:0 1px 3px rgba(0,0,0,0.3);" title="Supprimer l'image">×</a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span style="color:var(--color-text-muted); font-size:0.75rem;">–</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($data['titre']); ?></strong>
                            <?php if(!empty($data['icone'])): ?>
                            <br><small style="color:var(--color-text-secondary);"><i class="<?php echo $data['icone']; ?>"></i> <?php echo htmlspecialchars($data['icone']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:0.8125rem; max-width:200px; overflow:hidden; text-overflow:ellipsis;">
                            <?php echo htmlspecialchars(lienSectionContent($data['id'])); ?>
                        </td>
                        <td class="text-nowrap">
                            <a href="index.php?r=editSectionContent&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>" 
                               class="admin-btn admin-btn-ghost" style="padding:0.35rem 0.75rem; font-size:0.8rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifier
                            </a>
                            <a href="index.php?r=addSectionContent&idsc=<?php echo $data['id']; ?>&idb=<?php echo $_GET['id']; ?>&action=supp" 
                               class="admin-btn" style="padding:0.35rem 0.75rem; font-size:0.8rem; background:color-mix(in srgb, #ef4444 10%, transparent); color:#ef4444; border:1px solid color-mix(in srgb, #ef4444 30%, transparent);"
                               onclick="return confirm('Supprimer cet élément ?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                Supprimer
                            </a>
                        </td>
                    </tr>
                 <?php } ?>
                 <?php } else { ?>
                 <tr>
                   <td colspan="4" style="text-align:center; color:var(--color-text-muted); padding:2rem;">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="display:block; margin:0 auto 0.5rem;"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="21 15 16 10 5 21"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>
                       Aucun élément — Ajoutez-en un ci-dessous
                   </td>
                 </tr>
                 <?php } ?>   
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── Add New Element Form ── -->
<div class="admin-card">
    <div class="admin-card-body">
        <div class="admin-card-title mb-4" style="font-size:0.9375rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;display:inline;vertical-align:middle;color:var(--color-primary);margin-right:6px;"><path d="M12 5v14M5 12h14"/></svg>
            Ajouter un nouvel élément
        </div>

        <!-- Tip for Virtual Categories -->
        <div style="background:color-mix(in srgb, var(--color-primary) 5%, transparent); border-left:4px solid var(--color-primary); padding:1rem; border-radius:0.5rem; margin-bottom:1.5rem; font-size:0.875rem;">
            <div style="font-weight:700; color:var(--color-primary); margin-bottom:0.25rem; display:flex; align-items:center; gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Catégorie Virtuelle ?
            </div>
            Vous souhaitez ajouter une catégorie qui n'apparaît **pas** dans le menu principal ? <br>
            Créez-la dans <a href="index.php?r=ncategorie_blog" style="color:var(--color-primary); font-weight:600; text-decoration:underline;">Gestion des Catégories</a> en décochant l'option <strong>"Affichage menu"</strong>.
        </div>

        <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
            <!-- IMAGE BLOCK -->
            <div style="background:color-mix(in srgb, var(--color-primary) 4%, transparent); border:1px dashed color-mix(in srgb, var(--color-primary) 35%, transparent); border-radius:0.75rem; padding:1.25rem; margin-bottom:1.5rem;">
                <label style="font-weight:700; font-size:0.875rem; color:var(--color-primary); display:block; margin-bottom:1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Image / Visuel
                </label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size:0.8125rem; font-weight:600; display:flex; align-items:center; gap:6px; margin-bottom:0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Option 1 : Télécharger depuis votre PC
                            </label>
                            <div style="margin-bottom:10px;">
                                <label style="font-size:0.75rem; font-weight:600;">Image Desktop <span style="color:var(--color-text-muted)">(Défaut)</span></label>
                                <input type="file" name="image" accept="image/*" class="admin-input" style="padding:0.4rem;">
                            </div>
                            <div style="margin-bottom:10px;">
                                <label style="font-size:0.75rem; font-weight:600;">Image Tablette <span style="color:var(--color-text-muted)">(Optionnel)</span></label>
                                <input type="file" name="photo_tablet" accept="image/*" class="admin-input" style="padding:0.4rem;">
                            </div>
                            <div style="margin-bottom:10px;">
                                <label style="font-size:0.75rem; font-weight:600;">Image Mobile <span style="color:var(--color-text-muted)">(Optionnel)</span></label>
                                <input type="file" name="photo_mobile" accept="image/*" class="admin-input" style="padding:0.4rem;">
                            </div>
                            <small style="color:var(--color-text-muted); font-size:0.75rem;">JPG, PNG, GIF, WEBP</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size:0.8125rem; font-weight:600; display:flex; align-items:center; gap:6px; margin-bottom:0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                Option 2 : Chemin relatif de l'image
                            </label>
                            <input type="text" name="lien_url" class="admin-input" placeholder="media/products/nom-image.jpg">
                            <small style="color:var(--color-text-muted); font-size:0.75rem; display:block; margin-top:4px;">
                                ✅ Fonctionne en localhost ET en production.<br>
                                Ex: <code>media/products/image.jpg</code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT FIELDS -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Titre / Texte principal</label>
                        <input type="text" name="titre" class="admin-input" placeholder="Ex: Nos Smartphones">
                        <small style="color:var(--color-text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                            Affiché sur la bannière en page d'accueil.
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contenu / Sous-titre <small style="color:var(--color-text-muted)">(Pour Trust)</small></label>
                        <textarea name="contenu" class="admin-input" rows="2" placeholder="Description courte..."></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Lien de destination <small style="color:var(--color-text-muted)">(Optionnel)</small></label>
                        <input type="text" name="lien" class="admin-input" placeholder="categorie.php?link=smartphones">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Texte du bouton (Optionnel)</label>
                        <input type="text" name="titre_bouton" class="admin-input" placeholder="Ex: Découvrez, Acheter, Voir plus...">
                        <small style="color:var(--color-text-muted); font-size:0.75rem; margin-top:4px; display:block;">
                            S'affichera sur le bouton. Si vide et qu'un lien est présent, affiche "Découvrir".
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icône FontAwesome <small style="color:var(--color-text-muted)">(ex: fa-solid fa-truck)</small></label>
                        <input type="text" name="icone" class="admin-input" placeholder="fa-brands fa-whatsapp">
                        <small style="margin-top:0.25rem; display:block;">
                            <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" style="color:var(--color-primary); text-decoration:underline; font-size:0.75rem;">
                                Chercher une icône
                            </a>
                        </small>
                    </div>
                </div>
            </div>
                                
            <div class="text-xs-right" style="margin-top:0.75rem;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle; margin-right:4px;"><path d="M12 5v14M5 12h14"/></svg>
                    Ajouter
                </button>
                <input name="action" type="hidden" value="ajt">
                <button type="reset" class="admin-btn admin-btn-ghost">Vider le formulaire</button>
                <input type="hidden" name="id" value="<?php echo intval($_GET['id']); ?>" />
            </div>
        </form>
    </div>
</div>