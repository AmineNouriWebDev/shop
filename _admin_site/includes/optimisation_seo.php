<?php
// ─── 1. Lecture des données existantes en base ───────────────────────────────
$req  = "SELECT * FROM `optimisation_seo` WHERE 1 LIMIT 1";
$res  = executeRequete($req);
$numR = mysqli_num_rows($res);
$row  = ($numR > 0) ? mysqli_fetch_assoc($res) : [];

// Initialisation des variables d'affichage (depuis la BDD ou vides)
$title_home         = $row['title_home']         ?? '';
$description_home   = $row['description_home']   ?? '';
$keywords_home      = $row['keywords_home']      ?? '';
$title_categ        = $row['title_categ']        ?? '';
$description_categ  = $row['description_categ']  ?? '';
$keywords_categ     = $row['keywords_categ']     ?? '';
$title_scateg       = $row['title_scateg']       ?? '';
$description_scateg = $row['description_scateg'] ?? '';
$keywords_scateg    = $row['keywords_scateg']    ?? '';
$title_prod         = $row['title_prod']         ?? '';
$description_prod   = $row['description_prod']   ?? '';
$keywords_prod      = $row['keywords_prod']      ?? '';
$title_marque       = $row['title_marque']       ?? '';
$description_marque = $row['description_marque'] ?? '';
$keywords_marque    = $row['keywords_marque']    ?? '';

$msg     = '';
$msgType = 'success';

// ─── 2. Traitement du formulaire ─────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'mod') {

    $title_home         = formReception($_POST['title_home']         ?? '');
    $description_home   = formReception($_POST['description_home']   ?? '');
    $keywords_home      = formReception($_POST['keywords_home']      ?? '');
    $title_categ        = formReception($_POST['title_categ']        ?? '');
    $description_categ  = formReception($_POST['description_categ']  ?? '');
    $keywords_categ     = formReception($_POST['keywords_categ']     ?? '');
    $title_scateg       = formReception($_POST['title_scateg']       ?? '');
    $description_scateg = formReception($_POST['description_scateg'] ?? '');
    $keywords_scateg    = formReception($_POST['keywords_scateg']    ?? '');
    $title_prod         = formReception($_POST['title_prod']         ?? '');
    $description_prod   = formReception($_POST['description_prod']   ?? '');
    $keywords_prod      = formReception($_POST['keywords_prod']      ?? '');
    $title_marque       = formReception($_POST['title_marque']       ?? '');
    $description_marque = formReception($_POST['description_marque'] ?? '');
    $keywords_marque    = formReception($_POST['keywords_marque']    ?? '');

    if ($numR > 0) {
        // Mise à jour — utilise l'id de la ligne existante pour cibler la bonne entrée
        $id_row  = (int)($row['id'] ?? 0);
        $requete = "UPDATE `optimisation_seo` SET
            `title_home`         = '$title_home',
            `description_home`   = '$description_home',
            `keywords_home`      = '$keywords_home',
            `title_categ`        = '$title_categ',
            `description_categ`  = '$description_categ',
            `keywords_categ`     = '$keywords_categ',
            `title_scateg`       = '$title_scateg',
            `description_scateg` = '$description_scateg',
            `keywords_scateg`    = '$keywords_scateg',
            `title_prod`         = '$title_prod',
            `description_prod`   = '$description_prod',
            `keywords_prod`      = '$keywords_prod',
            `title_marque`       = '$title_marque',
            `description_marque` = '$description_marque',
            `keywords_marque`    = '$keywords_marque'
            " . ($id_row > 0 ? "WHERE `id` = '$id_row'" : "WHERE 1") . "";
    } else {
        // Insertion — toutes les colonnes incluses
        $requete = "INSERT INTO `optimisation_seo`
            (`title_home`,`description_home`,`keywords_home`,
             `title_categ`,`description_categ`,`keywords_categ`,
             `title_scateg`,`description_scateg`,`keywords_scateg`,
             `title_prod`,`description_prod`,`keywords_prod`,
             `title_marque`,`description_marque`,`keywords_marque`)
            VALUES
            ('$title_home','$description_home','$keywords_home',
             '$title_categ','$description_categ','$keywords_categ',
             '$title_scateg','$description_scateg','$keywords_scateg',
             '$title_prod','$description_prod','$keywords_prod',
             '$title_marque','$description_marque','$keywords_marque')";
    }

    $resultat = executeRequete($requete);
    $msg      = 'Optimisations SEO mises à jour avec succès.';
}
?>

<?php if ($msg): ?>
<div class="alert alert-<?php echo ($msgType === 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle me-2"></i>
    <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
                        <div class="admin-card-header">
                            <div class="admin-card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                Optimisations SEO
                            </div>
                        </div>
                        <div class="admin-card-body">
                <p class="text-muted" style="font-size:0.9em;">
                    Ces informations sont utilisées comme balises <code>&lt;title&gt;</code>,
                    <code>&lt;meta description&gt;</code> et <code>&lt;meta keywords&gt;</code>
                    pour chaque type de page de votre site.
                </p>
                <form method="POST" enctype="multipart/form-data">
                    <input name="action" type="hidden" value="mod">

                    <!-- ══ Page d'Accueil ══════════════════════════════════════════ -->
                    <div class="seo-section">
                        <div class="admin-card-title mt-6 mb-4 text-lg border-b pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Page d'Accueil
                        </div>

                        <div class="form-group">
                            <label>Title <span class="text-muted">(recommandé : 50–60 caractères)</span></label>
                            <input type="text" name="title_home" maxlength="80"
                                   value="<?php echo htmlspecialchars($title_home, ENT_QUOTES, 'UTF-8'); ?>"
                                   class="form-control seo-counter-input"
                                   data-max="60" placeholder="Ex : Technoplus | L'expert de la téléphonie...">
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-muted">(recommandé : 150–160 caractères)</span></label>
                            <textarea name="description_home" class="form-control seo-counter-input"
                                      rows="3" maxlength="300"
                                      data-max="160"
                                      placeholder="Description de la page d'accueil..."><?php echo htmlspecialchars($description_home, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Mots-clés <span class="text-muted">(séparés par des virgules)</span></label>
                            <textarea name="keywords_home" class="admin-input"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2, mot-clé3..."><?php echo htmlspecialchars($keywords_home, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Catégorie ══════════════════════════════════════════ -->
                    <div class="seo-section">
                        <div class="admin-card-title mt-6 mb-4 text-lg border-b pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.659A2.25 2.25 0 0 0 9.568 3Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Catégorie
                        </div>

                        <div class="form-group">
                            <label>Title <span class="text-muted">(recommandé : 50–60 caractères)</span></label>
                            <input type="text" name="title_categ" maxlength="80"
                                   value="<?php echo htmlspecialchars($title_categ, ENT_QUOTES, 'UTF-8'); ?>"
                                   class="form-control seo-counter-input"
                                   data-max="60" placeholder="Ex : Téléphones portables - Technoplus">
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-muted">(recommandé : 150–160 caractères)</span></label>
                            <textarea name="description_categ" class="form-control seo-counter-input"
                                      rows="3" maxlength="300"
                                      data-max="160"
                                      placeholder="Description de la catégorie pour les moteurs de recherche..."><?php echo htmlspecialchars($description_categ, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Mots-clés <span class="text-muted">(séparés par des virgules)</span></label>
                            <textarea name="keywords_categ" class="admin-input"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2, mot-clé3..."><?php echo htmlspecialchars($keywords_categ, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Sous-catégorie ═════════════════════════════════════ -->
                    <div class="seo-section">
                        <div class="admin-card-title mt-8 mb-4 text-lg border-b pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                            Sous-catégorie
                        </div>

                        <div class="form-group">
                            <label>Title <span class="text-muted">(recommandé : 50–60 caractères)</span></label>
                            <input type="text" name="title_scateg" maxlength="80"
                                   value="<?php echo htmlspecialchars($title_scateg, ENT_QUOTES, 'UTF-8'); ?>"
                                   class="form-control seo-counter-input"
                                   data-max="60" placeholder="Ex : Téléphones Samsung - Technoplus">
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-muted">(recommandé : 150–160 caractères)</span></label>
                            <textarea name="description_scateg" class="form-control seo-counter-input"
                                      rows="3" maxlength="300"
                                      data-max="160"
                                      placeholder="Description de la sous-catégorie..."><?php echo htmlspecialchars($description_scateg, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Mots-clés <span class="text-muted">(séparés par des virgules)</span></label>
                            <textarea name="keywords_scateg" class="admin-input"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_scateg, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Produit ════════════════════════════════════════════ -->
                    <div class="seo-section">
                        <div class="admin-card-title mt-8 mb-4 text-lg border-b pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                            Produit
                        </div>

                        <div class="form-group">
                            <label>Title <span class="text-muted">(recommandé : 50–60 caractères)</span></label>
                            <input type="text" name="title_prod" maxlength="80"
                                   value="<?php echo htmlspecialchars($title_prod, ENT_QUOTES, 'UTF-8'); ?>"
                                   class="form-control seo-counter-input"
                                   data-max="60" placeholder="Ex : {nom_produit} - Technoplus">
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-muted">(recommandé : 150–160 caractères)</span></label>
                            <textarea name="description_prod" class="form-control seo-counter-input"
                                      rows="3" maxlength="300"
                                      data-max="160"
                                      placeholder="Description du produit pour les moteurs de recherche..."><?php echo htmlspecialchars($description_prod, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Mots-clés <span class="text-muted">(séparés par des virgules)</span></label>
                            <textarea name="keywords_prod" class="admin-input"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_prod, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Marque ══════════════════════════════════════════════ -->
                    <div class="seo-section">
                        <div class="admin-card-title mt-8 mb-4 text-lg border-b pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                            Marque
                        </div>

                        <div class="form-group">
                            <label>Title <span class="text-muted">(recommandé : 50–60 caractères)</span></label>
                            <input type="text" name="title_marque" maxlength="80"
                                   value="<?php echo htmlspecialchars($title_marque, ENT_QUOTES, 'UTF-8'); ?>"
                                   class="form-control seo-counter-input"
                                   data-max="60" placeholder="Ex : Samsung - Technoplus">
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-muted">(recommandé : 150–160 caractères)</span></label>
                            <textarea name="description_marque" class="form-control seo-counter-input"
                                      rows="3" maxlength="300"
                                      data-max="160"
                                      placeholder="Description de la marque pour les moteurs de recherche..."><?php echo htmlspecialchars($description_marque, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <small class="seo-counter text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label>Mots-clés <span class="text-muted">(séparés par des virgules)</span></label>
                            <textarea name="keywords_marque" class="admin-input"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_marque, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <!-- ══ Boutons ═════════════════════════════════════════════ -->
                    <div class="form-group mt-4 text-right">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fa fa-save me-1"></i> Enregistrer
                        </button>
                        <a href="index.php?r=optimisationSeo" class="admin-btn admin-btn-ghost ml-2">
                            <i class="fa fa-times me-1"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.seo-section { margin-bottom: 1rem; }
.seo-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    font-weight: 600;
    color: #2196f3;
    margin-bottom: 1rem;
    padding-bottom: 6px;
    border-bottom: 2px solid #e9ecef;
}
.seo-section-title i { font-size: 0.95rem; }
.seo-counter {
    display: block;
    text-align: right;
    font-size: 0.78rem;
    margin-top: 3px;
}
.seo-counter.over-limit { color: #dc3545 !important; }
.seo-counter.near-limit { color: #fd7e14 !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.seo-counter-input').forEach(function (el) {
        var counter = el.nextElementSibling;
        var max     = parseInt(el.dataset.max || 160, 10);

        function update() {
            var len = el.value.length;
            counter.textContent = len + ' / ' + max + ' caractères';
            counter.classList.remove('over-limit', 'near-limit');
            if (len > max)              counter.classList.add('over-limit');
            else if (len > max * 0.85)  counter.classList.add('near-limit');
        }

        el.addEventListener('input', update);
        update(); // initialisation
    });
});
</script>

