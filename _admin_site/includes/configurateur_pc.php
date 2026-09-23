<?php
/**
 * ===================================================================
 * Admin — Configurateur PC Builder
 * Gère automatiquement un kit spécial "__PC_BUILDER__" en BDD.
 * L'admin sélectionne simplement ses catégories de produits par étape.
 * ===================================================================
 */

// --- Nom interne du kit PC (ne pas changer après création) ---
define('PC_KIT_SLUG', '__PC_BUILDER__');

// --- Récupérer ou créer le kit PC en BDD ---
function getPcKitId() {
    $res = executeRequete("SELECT id FROM conf_kits WHERE titre = '".PC_KIT_SLUG."' LIMIT 1");
    if ($row = mysqli_fetch_assoc($res)) return intval($row['id']);
    // Créer automatiquement
    executeRequete("INSERT INTO conf_kits (titre, description, etat, ordre) VALUES ('".PC_KIT_SLUG."', 'Kit Configurateur PC', 1, 99)");
    $res2 = executeRequete("SELECT id FROM conf_kits WHERE titre = '".PC_KIT_SLUG."' LIMIT 1");
    if ($row2 = mysqli_fetch_assoc($res2)) return intval($row2['id']);
    return 0;
}

$kit_id = getPcKitId();

// ── Action : Supprimer une étape ────────────────────────────────────
if (isset($_GET['del_etape'])) {
    $id_etape = intval($_GET['del_etape']);
    executeRequete("DELETE FROM conf_etapes WHERE id = $id_etape AND id_kit = $kit_id");
    echo "<script>window.location.href='index.php?r=configurateur_pc';</script>"; exit;
}

// ── Action : Ajouter une étape ──────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'add_pc_etape') {
    $titre      = formReception($_POST['etape_titre'] ?? '');
    $role       = formReception($_POST['etape_role'] ?? '');
    $obligatoire = intval($_POST['etape_obligatoire'] ?? 1);
    $montant_fixe = floatval($_POST['etape_montant_fixe'] ?? 0);
    $cats_raw   = isset($_POST['etape_categories']) && is_array($_POST['etape_categories'])
                  ? array_map('intval', $_POST['etape_categories']) : [];
    $prods_raw  = isset($_POST['etape_produits']) && is_array($_POST['etape_produits'])
                  ? array_map('intval', $_POST['etape_produits']) : [];

    if (!empty($titre) && ($role === 'frais_installation' || !empty($cats_raw) || !empty($prods_raw))) {
        $cnx        = ouvrirCnx();
        $cats_json  = mysqli_real_escape_string($cnx, json_encode($cats_raw));
        $prods_json = mysqli_real_escape_string($cnx, json_encode($prods_raw));
        $type_lien  = !empty($cats_raw) ? 'categorie' : 'produit';
        $id_lien    = !empty($cats_raw) ? $cats_raw[0] : (!empty($prods_raw) ? $prods_raw[0] : 0);

        $res_cnt = executeRequete("SELECT COUNT(*) as nb FROM conf_etapes WHERE id_kit = $kit_id");
        $cnt_row = mysqli_fetch_assoc($res_cnt);
        $ordre   = intval($cnt_row['nb']) + 1;

        executeRequete("INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, categories_ids, produits_ids, ordre, choix_multiple, obligatoire, role, montant_fixe)
                        VALUES ('$kit_id', '".formReception($titre)."', '$type_lien', '$id_lien', '$cats_json', '$prods_json', '$ordre', '0', '$obligatoire', '".formReception($role)."', '$montant_fixe')");
    }
    echo "<script>window.location.href='index.php?r=configurateur_pc';</script>"; exit;
}

// ── Action : Modifier l'ordre (drag & drop) ─────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'reorder_pc') {
    $ids = isset($_POST['ids']) && is_array($_POST['ids']) ? array_map('intval', $_POST['ids']) : [];
    foreach ($ids as $i => $eid) {
        executeRequete("UPDATE conf_etapes SET ordre = " . ($i + 1) . " WHERE id = $eid AND id_kit = $kit_id");
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']); exit;
}

// ── Charger les catégories pour les selects ─────────────────────────
$allCats = [];
$reqCat  = 'SELECT * FROM `categories_blog` WHERE `etat` = "1" ORDER BY `idparent` ASC, `ordre` ASC';
$resCat  = executeRequete($reqCat);
while ($c = mysqli_fetch_array($resCat)) {
    $allCats[] = [
        'id'     => $c['id'],
        'titre'  => html_entity_decode(afficheChamp($c['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        'parent' => intval($c['idparent'])
    ];
}
// Index par ID pour lookup rapide
$catIndex = [];
foreach ($allCats as $c) $catIndex[$c['id']] = $c;

// ── Charger les étapes existantes ───────────────────────────────────
$etapes = [];
$resE   = executeRequete("SELECT * FROM conf_etapes WHERE id_kit = $kit_id ORDER BY ordre ASC");
while ($e = mysqli_fetch_assoc($resE)) $etapes[] = $e;

// ── Rôles PC disponibles ────────────────────────────────────────────
$pc_roles = [
    ''            => '-- Aucun (choix multiple libre) --',
    'cpu'         => '🔲 Processeur (CPU) — choix unique',
    'motherboard' => '🖥️ Carte mère — choix unique',
    'ram'         => '💾 Mémoire RAM — choix unique',
    'ssd'         => '💿 SSD — choix unique',
    'hdd'         => '🗄️ Disque Dur HDD — choix unique',
    'gpu'         => '🎮 Carte Graphique — choix unique',
    'psu'         => '⚡ Alimentation PSU — choix unique',
    'case'        => '📦 Boîtier PC — choix unique',
    'cooling'     => '❄️ Refroidissement — choix unique',
    'monitor'     => '🖥️ Écran — choix unique',
    'accessoire'  => '🔌 Accessoire — choix multiple',
    'frais_installation' => '🛠️ Frais d\'installation (sans produit)',
];

// Compter produits par catégorie (pour afficher le nb de produits dispo)
$catProdCount = [];
$resCount = executeRequete("SELECT categorie, COUNT(*) as nb FROM produits WHERE etat='1' GROUP BY categorie");
while ($pc = mysqli_fetch_assoc($resCount)) {
    $catProdCount[intval($pc['categorie'])] = intval($pc['nb']);
}
?>

<div class="row">

  <!-- ═══════════════════════════════════ -->
  <!-- BLOC GAUCHE : Étapes configurées   -->
  <!-- ═══════════════════════════════════ -->
  <div class="col-md-7">
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.4rem;height:1.4rem;color:var(--color-primary);">
            <rect x="2" y="3" width="20" height="14" rx="2" stroke-width="1.5" fill="none"/>
            <line x1="8" y1="21" x2="16" y2="21"/>
            <line x1="12" y1="17" x2="12" y2="21"/>
          </svg>
          Étapes du Configurateur PC
          <span style="background:#dbeafe;color:#1e40af;font-size:0.75rem;padding:2px 8px;border-radius:999px;font-weight:600;"><?php echo count($etapes); ?> étape(s)</span>
        </div>
        <div style="display:flex;gap:8px;">
          <a href="<?php echo (isset($chemin_absolu)?$chemin_absolu:'/').'configurateur-pc/'; ?>" target="_blank" class="admin-btn" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;font-size:0.82rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
            Prévisualiser
          </a>
          <button type="button" class="admin-btn admin-btn-primary" onclick="toggleAddForm()">
            + Ajouter une étape
          </button>
        </div>
      </div>
      <div class="admin-card-body">

        <?php if (count($etapes) === 0): ?>
        <div style="text-align:center;padding:3rem 1rem;color:#94a3b8;">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;margin:0 auto 1rem;display:block;opacity:0.4;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0H3" />
          </svg>
          <p style="font-weight:600;font-size:1rem;margin-bottom:0.5rem;">Aucune étape configurée</p>
          <p style="font-size:0.85rem;">Ajoutez des étapes en cliquant sur le bouton ci-dessus.<br>Chaque étape correspond à un composant PC (Processeur, RAM, etc.)</p>
        </div>
        <?php else: ?>

        <!-- Formulaire caché pour l'ajout -->
        <div id="add-etape-form" style="display:none; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:16px;">
          <?php include __DIR__ . '/configurateur_pc_form.php'; ?>
        </div>

        <table class="admin-table" id="pc-etapes-table">
          <thead>
            <tr>
              <th style="width:50px;">Ordre</th>
              <th>Étape / Rôle</th>
              <th>Sources (catégories / produits)</th>
              <th style="width:70px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($etapes as $e): ?>
              <?php
                // Sources
                $srcHtml = '';
                $cats_ids = !empty($e['categories_ids']) ? (json_decode($e['categories_ids'], true) ?: []) : ($e['type_lien'] === 'categorie' && $e['id_lien'] ? [$e['id_lien']] : []);
                $prod_ids = !empty($e['produits_ids']) ? (json_decode($e['produits_ids'], true) ?: []) : ($e['type_lien'] === 'produit' && $e['id_lien'] ? [$e['id_lien']] : []);
                foreach ($cats_ids as $cid) {
                    $cid = intval($cid);
                    $cat = $catIndex[$cid] ?? null;
                    $nb  = $catProdCount[$cid] ?? 0;
                    if ($cat) {
                        $srcHtml .= '<span style="display:inline-block;background:#dbeafe;color:#1e40af;border-radius:4px;padding:2px 7px;font-size:0.72rem;margin:1px;">'
                            . '<i class="fa fa-folder"></i> ' . htmlspecialchars($cat['titre'], ENT_QUOTES, 'UTF-8')
                            . '<span style="margin-left:4px;background:#bfdbfe;border-radius:3px;padding:0 4px;font-size:0.65rem;">' . $nb . ' prod.</span>'
                            . '</span>';
                    }
                }
                foreach ($prod_ids as $pid) {
                    $pid = intval($pid);
                    $rp = executeRequete("SELECT titre FROM produits WHERE id=$pid");
                    if ($pp = mysqli_fetch_assoc($rp)) {
                        $t = html_entity_decode(afficheChamp($pp['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $srcHtml .= '<span style="display:inline-block;background:#dcfce7;color:#166534;border-radius:4px;padding:2px 7px;font-size:0.72rem;margin:1px;">'
                            . '<i class="fa fa-cube"></i> ' . htmlspecialchars(mb_strimwidth($t, 0, 35, '…'), ENT_QUOTES, 'UTF-8')
                            . '</span>';
                    }
                }
                $roleBadge = !empty($e['role']) ? '<span style="display:inline-block;background:#fef3c7;color:#92400e;border-radius:4px;padding:1px 6px;font-size:0.7rem;margin-top:2px;"><i class="fa fa-tag"></i> '.$e['role'].'</span>' : '';
              ?>
              <tr data-id="<?php echo $e['id']; ?>">
                <td>
                  <i class="fa fa-arrows-v drag-handle" style="cursor:grab;color:#94a3b8;margin-right:6px;"></i>
                  <strong><?php echo $e['ordre']; ?></strong>
                </td>
                <td>
                  <div style="font-weight:600;font-size:0.88rem;"><?php echo htmlspecialchars(afficheChamp($e['titre'])); ?></div>
                  <?php echo $roleBadge; ?>
                  <div style="font-size:0.75rem;margin-top:2px;">
                    <?php if($e['obligatoire']==1): ?>
                      <span style="color:#dc2626;font-weight:600;">● Obligatoire</span>
                    <?php else: ?>
                      <span style="color:#6b7280;">○ Optionnel</span>
                    <?php endif; ?>
                  </div>
                </td>
                <td style="font-size:0.78rem;max-width:250px;"><?php echo $srcHtml ?: '<span class="text-muted">Aucune source</span>'; ?></td>
                <td>
                  <a href="javascript:void(0);"
                     onclick="confirmGlobalDelete('index.php?r=configurateur_pc&del_etape=<?php echo $e['id']; ?>')"
                     class="p-1 text-red-600" title="Supprimer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php endif; ?>

        <!-- Formulaire d'ajout (si aucune étape, toujours visible) -->
        <?php if (count($etapes) === 0): ?>
        <div id="add-etape-form" style="margin-top:1rem;">
          <?php include __DIR__ . '/configurateur_pc_form.php'; ?>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════ -->
  <!-- BLOC DROIT : Guide & Info           -->
  <!-- ═══════════════════════════════════ -->
  <div class="col-md-5">
    <!-- Aperçu des étapes -->
    <div class="admin-card mb-3" style="border-left:4px solid #6366f1;">
      <div class="admin-card-body" style="padding:14px;">
        <h6 style="font-weight:700;color:#4338ca;margin-bottom:10px;">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;vertical-align:-2px;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
          Comment ça marche ?
        </h6>
        <ol style="font-size:0.82rem;color:#374151;margin:0;padding-left:1.2rem;line-height:1.8;">
          <li>Ajoutez une étape (ex: <strong>Processeur</strong>)</li>
          <li>Sélectionnez la (ou les) <strong>catégorie(s)</strong> de produits correspondante(s)</li>
          <li>Le client voit tous les produits de ces catégories dans cette étape</li>
          <li>Il choisit son composant et passe à l'étape suivante</li>
          <li>À la fin, il ajoute tout au panier en un clic</li>
        </ol>
      </div>
    </div>

    <!-- Rôles PC -->
    <div class="admin-card mb-3">
      <div class="admin-card-body" style="padding:14px;">
        <h6 style="font-weight:700;color:#374151;margin-bottom:10px;">
          <i class="fa fa-tag text-primary"></i> Rôles PC disponibles
        </h6>
        <p style="font-size:0.78rem;color:#6b7280;margin-bottom:8px;">Le rôle détermine le comportement de l'étape (choix unique ou multiple) :</p>
        <table style="width:100%;font-size:0.78rem;border-collapse:collapse;">
          <?php foreach ($pc_roles as $roleKey => $roleLabel): if(empty($roleKey)) continue; ?>
          <tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:4px 6px;"><code><?php echo $roleKey; ?></code></td>
            <td style="padding:4px 6px;color:#64748b;"><?php echo $roleLabel; ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <!-- Catégories disponibles avec nb produits -->
    <div class="admin-card">
      <div class="admin-card-body" style="padding:14px;">
        <h6 style="font-weight:700;color:#374151;margin-bottom:10px;">
          <i class="fa fa-folder-open text-primary"></i> Catégories disponibles
          <small class="text-muted">(avec stock)</small>
        </h6>
        <div style="max-height:300px;overflow-y:auto;font-size:0.8rem;">
          <?php foreach ($allCats as $cat): $nb = $catProdCount[$cat['id']] ?? 0; if($nb === 0) continue; ?>
          <div style="display:flex;justify-content:space-between;padding:4px 0;border-bottom:1px solid #f8fafc;">
            <span style="color:#374151;"><?php echo $cat['parent'] > 0 ? '&nbsp;&nbsp;→&nbsp;' : ''; ?><?php echo htmlspecialchars($cat['titre'], ENT_QUOTES, 'UTF-8'); ?></span>
            <span style="background:#dbeafe;color:#1e40af;border-radius:9999px;padding:0 7px;font-size:0.7rem;font-weight:600;"><?php echo $nb; ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Formulaire d'ajout flottant (quand des étapes existent déjà) -->
<?php if (count($etapes) > 0): ?>
<div style="margin-top:1.5rem;">
  <div id="add-etape-form" style="display:none; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:20px;">
    <?php include __DIR__ . '/configurateur_pc_form.php'; ?>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
function toggleAddForm() {
    var f = document.getElementById('add-etape-form');
    if (!f) return;
    f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'block' : 'none';
}

function filterPcProduits(q) {
    var sel = document.getElementById('pc-produits-select');
    if (!sel) return;
    q = q.toLowerCase();
    Array.from(sel.options).forEach(function(opt) {
        opt.style.display = (q === '' || (opt.getAttribute('data-titre') || '').includes(q)) ? '' : 'none';
    });
}

// Drag & Drop réordonnement
document.addEventListener('DOMContentLoaded', function() {
    var tbody = document.querySelector('#pc-etapes-table tbody');
    if (tbody && typeof Sortable !== 'undefined') {
        Sortable.create(tbody, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function() {
                var rows = tbody.querySelectorAll('tr[data-id]');
                var ids  = Array.from(rows).map(function(r) { return r.getAttribute('data-id'); });
                $.ajax({
                    url: 'index.php?r=configurateur_pc',
                    method: 'POST',
                    data: { action: 'reorder_pc', ids: ids },
                    success: function(resp) {
                        try {
                            var res = JSON.parse(resp);
                            if (res.status === 'success' && typeof showToast === 'function') showToast('Ordre mis à jour ✓', 'success');
                        } catch(e) {}
                    }
                });
            }
        });
    }
});
</script>
