<?php
// Suppression d'une option
if (isset($_GET['action']) && $_GET['action'] === 'del_option' && isset($_GET['id'])) {
    executeRequete("DELETE FROM diagnostic_options WHERE id = " . intval($_GET['id']));
    echo "<script>window.location.href='index.php?r=diagnostic_etapes';</script>"; exit;
}
// Suppression d'une étape + ses options
if (isset($_GET['action']) && $_GET['action'] === 'del_etape' && isset($_GET['id'])) {
    $eid = intval($_GET['id']);
    executeRequete("DELETE FROM diagnostic_options WHERE id_etape = $eid");
    executeRequete("DELETE FROM diagnostic_etapes WHERE id = $eid");
    echo "<script>window.location.href='index.php?r=diagnostic_etapes';</script>"; exit;
}
// Ajout/modif ordre étape (up/down)
if (isset($_GET['action']) && in_array($_GET['action'], ['up', 'down']) && isset($_GET['id'])) {
    $eid = intval($_GET['id']);
    $res = executeRequete("SELECT ordre FROM diagnostic_etapes WHERE id=$eid");
    $row = mysqli_fetch_assoc($res);
    $ord = intval($row['ordre']);
    if ($_GET['action'] === 'up') {
        // Swap avec le précédent
        $res2 = executeRequete("SELECT id, ordre FROM diagnostic_etapes WHERE ordre < $ord ORDER BY ordre DESC LIMIT 1");
        $other = mysqli_fetch_assoc($res2);
        if ($other) {
            executeRequete("UPDATE diagnostic_etapes SET ordre={$other['ordre']} WHERE id=$eid");
            executeRequete("UPDATE diagnostic_etapes SET ordre=$ord WHERE id={$other['id']}");
        }
    } else {
        $res2 = executeRequete("SELECT id, ordre FROM diagnostic_etapes WHERE ordre > $ord ORDER BY ordre ASC LIMIT 1");
        $other = mysqli_fetch_assoc($res2);
        if ($other) {
            executeRequete("UPDATE diagnostic_etapes SET ordre={$other['ordre']} WHERE id=$eid");
            executeRequete("UPDATE diagnostic_etapes SET ordre=$ord WHERE id={$other['id']}");
        }
    }
    echo "<script>window.location.href='index.php?r=diagnostic_etapes';</script>"; exit;
}
// Toggle état étape
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $eid = intval($_GET['id']);
    executeRequete("UPDATE diagnostic_etapes SET etat = 1-etat WHERE id=$eid");
    echo "<script>window.location.href='index.php?r=diagnostic_etapes';</script>"; exit;
}

// Chargement des étapes
$etapes = [];
$res = executeRequete("SELECT * FROM diagnostic_etapes ORDER BY ordre ASC");
while ($e = mysqli_fetch_assoc($res)) {
    $resOpts = executeRequete("SELECT * FROM diagnostic_options WHERE id_etape={$e['id']} ORDER BY ordre ASC");
    $e['options'] = [];
    while ($o = mysqli_fetch_assoc($resOpts)) $e['options'][] = $o;
    $etapes[] = $e;
}
?>
<div class="row">
  <div class="col-12">
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
          </svg>
          Formulaire Diagnostic Sécurité — Gestion des étapes
        </div>
        <a href="index.php?r=ndiagnostic_etape" class="admin-btn admin-btn-primary" style="font-size:0.8rem;">
          + Ajouter une étape
        </a>
      </div>
      <div class="admin-card-body">
        <p style="color:var(--color-text-secondary); font-size:0.875rem; margin-bottom:1rem;">
          Ces étapes constituent les questions du formulaire <strong>diagnostic-securite/</strong>. 
          L'étape finale "Coordonnées" est fixe et non modifiable. Modifiez l'ordre avec les flèches.
        </p>

        <?php if (empty($etapes)): ?>
          <p class="text-center p-4">Aucune étape configurée.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="admin-table">
              <thead>
                <tr>
                  <th style="width:50px;">Ordre</th>
                  <th>Question</th>
                  <th>Champ</th>
                  <th>Type</th>
                  <th style="width:80px;">État</th>
                  <th class="text-nowrap" style="width:140px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($etapes as $idx => $etape): ?>
                <tr style="<?php echo !$etape['etat'] ? 'opacity:0.5;' : ''; ?>">
                  <td>
                    <div style="display:flex; flex-direction:column; gap:2px; align-items:center;">
                      <a href="index.php?r=diagnostic_etapes&action=up&id=<?php echo $etape['id']; ?>" title="Monter"
                         style="color:var(--color-text-secondary); text-decoration:none; line-height:1;">▲</a>
                      <span style="font-weight:700; color:var(--color-primary);"><?php echo $idx+1; ?></span>
                      <a href="index.php?r=diagnostic_etapes&action=down&id=<?php echo $etape['id']; ?>" title="Descendre"
                         style="color:var(--color-text-secondary); text-decoration:none; line-height:1;">▼</a>
                    </div>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($etape['question']); ?></strong>
                    <?php if ($etape['sous_titre']): ?>
                      <br><small style="color:var(--color-text-secondary);"><?php echo htmlspecialchars($etape['sous_titre']); ?></small>
                    <?php endif; ?>
                    <!-- Options -->
                    <div style="margin-top:0.5rem; display:flex; flex-wrap:wrap; gap:0.3rem;">
                      <?php foreach ($etape['options'] as $opt): ?>
                        <span style="display:inline-flex; align-items:center; gap:4px; background:color-mix(in srgb,var(--color-primary) 8%,transparent); padding:2px 8px; border-radius:999px; font-size:0.75rem;">
                          <?php if ($opt['icone']): ?><i class="<?php echo htmlspecialchars($opt['icone']); ?>"></i><?php endif; ?>
                          <?php echo htmlspecialchars($opt['label']); ?>
                          <a href="index.php?r=diagnostic_etapes&action=del_option&id=<?php echo $opt['id']; ?>" 
                             onclick="return confirm('Supprimer cette option ?')"
                             style="color:#ef4444; text-decoration:none; font-weight:700; margin-left:2px;">×</a>
                        </span>
                      <?php endforeach; ?>
                      <a href="index.php?r=mdiagnostic_etape&id=<?php echo $etape['id']; ?>"
                         style="display:inline-flex; align-items:center; gap:4px; background:var(--color-border); padding:2px 8px; border-radius:999px; font-size:0.75rem; text-decoration:none; color:var(--color-text-primary);">
                        + option
                      </a>
                    </div>
                  </td>
                  <td><code><?php echo htmlspecialchars($etape['champ']); ?></code></td>
                  <td>
                    <?php if ($etape['choix_multiple']): ?>
                      <span class="badge" style="background:#f59e0b; color:#fff; padding:2px 8px; border-radius:999px; font-size:0.72rem;">Multi-choix</span>
                    <?php else: ?>
                      <span class="badge" style="background:#3b82f6; color:#fff; padding:2px 8px; border-radius:999px; font-size:0.72rem;">Choix unique</span>
                    <?php endif; ?>
                    <?php if ($etape['avance_auto'] && !$etape['choix_multiple']): ?>
                      <br><small style="color:var(--color-text-secondary);">Auto-avance</small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="index.php?r=diagnostic_etapes&action=toggle&id=<?php echo $etape['id']; ?>"
                       style="display:inline-block; width:36px; height:20px; border-radius:10px; background:<?php echo $etape['etat'] ? '#10b981' : '#9ca3af'; ?>; position:relative; cursor:pointer; transition:0.2s; text-decoration:none;">
                      <span style="position:absolute; top:2px; <?php echo $etape['etat'] ? 'right:2px' : 'left:2px'; ?>; width:16px; height:16px; border-radius:50%; background:#fff;"></span>
                    </a>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="index.php?r=mdiagnostic_etape&id=<?php echo $etape['id']; ?>" 
                         class="p-1 text-blue-600 hover:text-blue-900 transition-colors" title="Modifier">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                      </a>
                      <a href="javascript:void(0);" 
                         onclick="confirmGlobalDelete('index.php?r=diagnostic_etapes&action=del_etape&id=<?php echo $etape['id']; ?>')"
                         class="p-1 text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                <!-- Étape fixe: Coordonnées -->
                <tr style="background:color-mix(in srgb,var(--color-border) 30%,transparent);">
                  <td style="text-align:center;">
                    <strong style="color:var(--color-text-secondary);"><?php echo count($etapes)+1; ?></strong>
                  </td>
                  <td>
                    <strong>Vos coordonnées</strong>
                    <br><small style="color:var(--color-text-secondary);">Étape fixe — Nom, Prénom, Téléphone, Adresse</small>
                  </td>
                  <td><code>coordonnees</code></td>
                  <td><span style="background:#6b7280; color:#fff; padding:2px 8px; border-radius:999px; font-size:0.72rem;">Formulaire fixe</span></td>
                  <td>—</td>
                  <td>—</td>
                </tr>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
