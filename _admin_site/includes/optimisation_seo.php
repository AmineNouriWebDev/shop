<?php
// ─── 1. Lecture des données existantes en base ───────────────────────────────
$req  = "SELECT * FROM `optimisation_seo` WHERE 1 LIMIT 1";
$res  = executeRequete($req);
$numR = mysqli_num_rows($res);
$row  = ($numR > 0) ? mysqli_fetch_assoc($res) : [];

// Initialisation des variables d'affichage (depuis la BDD ou vides)
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
            (`title_categ`,`description_categ`,`keywords_categ`,
             `title_scateg`,`description_scateg`,`keywords_scateg`,
             `title_prod`,`description_prod`,`keywords_prod`,
             `title_marque`,`description_marque`,`keywords_marque`)
            VALUES
            ('$title_categ','$description_categ','$keywords_categ',
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="fa fa-search me-2" style="color:#2196f3;"></i>
                    Optimisations SEO
                </h4>
                <p class="text-muted" style="font-size:0.9em;">
                    Ces informations sont utilisées comme balises <code>&lt;title&gt;</code>,
                    <code>&lt;meta description&gt;</code> et <code>&lt;meta keywords&gt;</code>
                    pour chaque type de page de votre site.
                </p>
                <form method="POST" enctype="multipart/form-data">
                    <input name="action" type="hidden" value="mod">

                    <!-- ══ Catégorie ══════════════════════════════════════════ -->
                    <div class="seo-section">
                        <h5 class="seo-section-title">
                            <i class="fa fa-tag"></i> Catégorie
                        </h5>

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
                            <textarea name="keywords_categ" class="form-control"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2, mot-clé3..."><?php echo htmlspecialchars($keywords_categ, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Sous-catégorie ═════════════════════════════════════ -->
                    <div class="seo-section">
                        <h5 class="seo-section-title">
                            <i class="fa fa-tags"></i> Sous-catégorie
                        </h5>

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
                            <textarea name="keywords_scateg" class="form-control"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_scateg, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Produit ════════════════════════════════════════════ -->
                    <div class="seo-section">
                        <h5 class="seo-section-title">
                            <i class="fa fa-cube"></i> Produit
                        </h5>

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
                            <textarea name="keywords_prod" class="form-control"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_prod, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- ══ Marque ══════════════════════════════════════════════ -->
                    <div class="seo-section">
                        <h5 class="seo-section-title">
                            <i class="fa fa-trademark"></i> Marque
                        </h5>

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
                            <textarea name="keywords_marque" class="form-control"
                                      rows="2"
                                      placeholder="mot-clé1, mot-clé2..."><?php echo htmlspecialchars($keywords_marque, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>

                    <!-- ══ Boutons ═════════════════════════════════════════════ -->
                    <div class="form-group mt-4 text-right">
                        <button type="submit" class="btn btn-info">
                            <i class="fa fa-save me-1"></i> Enregistrer
                        </button>
                        <a href="index.php?r=optimisationSeo" class="btn btn-secondary ml-2">
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
