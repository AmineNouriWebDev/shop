<?php
// ─── Ajouter la colonne 'ordre' si elle n'existe pas encore ───────────────────
$chk_ordre = @executeRequete("SHOW COLUMNS FROM `valeur_caracteristique` LIKE 'ordre'");
if ($chk_ordre && mysqli_num_rows($chk_ordre) == 0) {
    executeRequete("ALTER TABLE `valeur_caracteristique` ADD COLUMN `ordre` INT(11) NOT NULL DEFAULT 0 AFTER `valeur`");
    // Initialiser l'ordre existant avec l'id
    executeRequete("UPDATE `valeur_caracteristique` SET `ordre` = `id` WHERE `ordre` = 0");
}

// ─── Sauvegarde ordre via AJAX ─────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'save_order' && isset($_POST['ids'])) {
    $ids = array_map('intval', explode(',', $_POST['ids']));
    foreach ($ids as $position => $id) {
        executeRequete("UPDATE `valeur_caracteristique` SET `ordre` = " . ($position + 1) . " WHERE `id` = " . $id);
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// ─── Suppression ───────────────────────────────────────────────────────────────
if (isset($_GET['action']) && $_GET['action'] == 'supp') {
    $idc = (int)$_GET['idc'];
    executeRequete("DELETE FROM `valeur_caracteristique` WHERE id = '" . (int)$_GET['idv'] . "'");
    echo '<script>window.location = "index.php?r=valeurcaracteristiques&id=' . $idc . '";</script>';
    exit;
}

// ─── Ajout valeur ──────────────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] == 'ajt') {
    $idcarac = formReception($_POST['id']);
    $valeur  = formReception($_POST['valeur']);
    // Calculer le prochain ordre
    $res_max = executeRequete("SELECT MAX(`ordre`) as max_ord FROM `valeur_caracteristique` WHERE `idcarac` = '$idcarac'");
    $row_max = mysqli_fetch_assoc($res_max);
    $next_ordre = ($row_max['max_ord'] ?? 0) + 1;
    executeRequete("INSERT INTO `valeur_caracteristique` (`idcarac`,`valeur`,`ordre`) VALUES ('$idcarac','$valeur','$next_ordre')");
    echo '<script>window.location = "index.php?r=valeurcaracteristiques&id=' . $idcarac . '";</script>';
    exit;
}

// ─── Récupération des valeurs ──────────────────────────────────────────────────
$idcarac_page = (int)$_GET['id'];
$requete = "SELECT * FROM `valeur_caracteristique` WHERE `idcarac` = '$idcarac_page' ORDER BY `ordre` ASC, `id` ASC";
$resultat = executeRequete($requete);
$valeurs  = [];
while ($row = mysqli_fetch_assoc($resultat)) {
    $valeurs[] = $row;
}

// Nom de la caractéristique parente
$res_carac = executeRequete("SELECT * FROM `caracteristiques` WHERE `id` = '$idcarac_page' LIMIT 1");
$carac_name = '';
if ($res_carac && $row_c = mysqli_fetch_assoc($res_carac)) {
    $carac_name = afficheChamp($row_c['titre'] ?? $row_c['nom'] ?? '');
}
?>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z"/>
                    </svg>
                    Valeurs de : <strong style="color:var(--color-primary); margin-left:6px;"><?php echo htmlspecialchars($carac_name ?: 'Caractéristique #'.$idcarac_page); ?></strong>
                </div>
                <a href="index.php?r=caracteristiques" class="admin-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/>
                    </svg>
                    Retour
                </a>
            </div>

            <div class="admin-card-body">

                <?php if (empty($valeurs)): ?>
                <div style="text-align:center; padding:2rem; color:var(--color-text-muted); opacity:0.6;">
                    Aucune valeur définie. Ajoutez-en ci-dessous.
                </div>
                <?php else: ?>

                <!-- Info drag & drop -->
                <div style="margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; font-size:0.8125rem; color:var(--color-text-muted); background:rgba(var(--color-primary-rgb,99,102,241),0.06); padding:0.625rem 1rem; border-radius:0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;flex-shrink:0;color:var(--color-primary);">
                        <path fill-rule="evenodd" d="M10 1a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 1Zm0 15.5a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75ZM1 10a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 1 10Zm15.5 0a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
                    </svg>
                    Glissez-déposez les lignes pour changer l'ordre. L'ordre est sauvegardé automatiquement.
                    <span id="sortSaveStatus" style="margin-left:auto; font-weight:600; color:#10b981; display:none;">✓ Sauvegardé</span>
                </div>

                <!-- Tableau triable -->
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width:36px;"></th>
                                <th>Valeur</th>
                                <th style="width:80px; text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortableCaracValues">
                            <?php foreach ($valeurs as $data): ?>
                            <tr class="carac-row" data-id="<?php echo (int)$data['id']; ?>" style="cursor:grab;">
                                <td style="width:36px; padding:0.75rem 0.5rem; text-align:center; color:var(--color-text-muted); opacity:0.5;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                                        <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm0 10.5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd"/>
                                    </svg>
                                </td>
                                <td style="font-weight:500;"><?php echo htmlspecialchars(afficheChamp($data['valeur'])); ?></td>
                                <td style="text-align:right;">
                                    <a href="javascript:void(0);"
                                       onclick="confirmGlobalDelete('index.php?r=valeurcaracteristiques&idv=<?php echo $data['id']; ?>&idc=<?php echo $idcarac_page; ?>&action=supp');"
                                       class="admin-btn"
                                       style="padding:0.35rem 0.6rem; background:#fff5f5; color:#e53e3e;"
                                       title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Formulaire Ajouter une valeur -->
<div class="row" style="margin-top:1.5rem;">
    <div class="col-12 col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;color:var(--color-primary);">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z"/>
                    </svg>
                    Ajouter une valeur
                </div>
            </div>
            <div class="admin-card-body">
                <form method="POST" enctype="multipart/form-data" class="admin-form">
                    <div class="admin-form-group">
                        <label for="valeurInput">Valeur <small style="opacity:0.6;">(ex: i9, 16Go, 6.5"...)</small></label>
                        <div style="display:flex; gap:0.75rem;">
                            <input type="text" name="valeur" id="valeurInput" class="admin-input" placeholder="Nouvelle valeur..." required style="flex:1;">
                            <button type="submit" class="admin-btn admin-btn-primary" style="flex-shrink:0;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
                                </svg>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                    <input name="action" type="hidden" value="ajt">
                    <input type="hidden" name="id" value="<?php echo $idcarac_page; ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SortableJS CDN (léger, zero dépendance) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
(function(){
    var tbody = document.getElementById('sortableCaracValues');
    if (!tbody) return;

    var saveStatus = document.getElementById('sortSaveStatus');
    var saveTimer  = null;

    // Init Sortable
    Sortable.create(tbody, {
        animation: 180,
        handle: 'tr',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        onEnd: function() {
            saveOrder();
        }
    });

    function saveOrder() {
        var rows = tbody.querySelectorAll('tr.carac-row');
        var ids  = Array.from(rows).map(function(r){ return r.dataset.id; }).join(',');

        // Afficher "Sauvegarde..."
        saveStatus.style.display = 'inline';
        saveStatus.style.color = '#f59e0b';
        saveStatus.textContent = '⏳ Sauvegarde...';

        var formData = new FormData();
        formData.append('action', 'save_order');
        formData.append('ids', ids);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(function(r){
            if (r.ok) {
                saveStatus.style.color = '#10b981';
                saveStatus.textContent = '✓ Ordre sauvegardé';
                clearTimeout(saveTimer);
                saveTimer = setTimeout(function(){
                    saveStatus.style.display = 'none';
                }, 3000);
            } else {
                saveStatus.style.color = '#ef4444';
                saveStatus.textContent = '✗ Erreur (HTTP ' + r.status + ')';
            }
        })
        .catch(function(){
            saveStatus.style.color = '#ef4444';
            saveStatus.textContent = '✗ Erreur réseau';
        });
    }
})();
</script>

<style>
/* Drag & drop feedback */
.sortable-ghost  { opacity: 0.35; background: rgba(var(--color-primary-rgb,99,102,241), 0.08); }
.sortable-chosen { box-shadow: 0 4px 20px rgba(var(--color-primary-rgb,99,102,241), 0.2); background: var(--color-card, #fff); }
.sortable-drag   { opacity: 0.9; }
.carac-row:hover .fa-bars, .carac-row:hover svg { opacity: 1 !important; }
.carac-row { transition: background 0.15s; }
.carac-row:active { cursor: grabbing; }
</style>