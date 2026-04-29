<?php
$id = intval($_GET['id']);

// Ajout d'une option
if (isset($_POST['action']) && $_POST['action'] === 'add_option') {
    $label  = formReception($_POST['label']);
    $valeur = formReception($_POST['valeur'] ?: $_POST['label']);
    $icone  = formReception($_POST['icone'] ?? '');
    $ordre  = intval($_POST['ordre'] ?? 10);
    executeRequete("INSERT INTO `diagnostic_options` (id_etape, label, valeur, icone, ordre) VALUES ('$id','$label','$valeur','$icone','$ordre')");
    echo "<script>window.location.href='index.php?r=mdiagnostic_etape&id=$id';</script>"; exit;
}

// Modification de l'étape
if (isset($_POST['action']) && $_POST['action'] === 'modif') {
    $question       = formReception($_POST['question']);
    $sous_titre     = formReception($_POST['sous_titre'] ?? '');
    $champ          = formReception($_POST['champ']);
    $choix_multiple = intval($_POST['choix_multiple'] ?? 0);
    $avance_auto    = intval($_POST['avance_auto'] ?? 1);
    $ordre          = intval($_POST['ordre'] ?? 0);
    $etat           = intval($_POST['etat'] ?? 1);
    executeRequete("UPDATE `diagnostic_etapes` SET
        question='$question', sous_titre='$sous_titre', champ='$champ',
        choix_multiple='$choix_multiple', avance_auto='$avance_auto',
        ordre='$ordre', etat='$etat'
        WHERE id='$id'");
    echo "<script>window.location.href='index.php?r=diagnostic_etapes';</script>"; exit;
}

// Modification d'une option inline (AJAX)
if (isset($_POST['action']) && $_POST['action'] === 'update_option') {
    $oid  = intval($_POST['oid']);
    $f    = formReception($_POST['field']);
    $val  = formReception($_POST['value']);
    $allowed = ['label','valeur','icone','ordre'];
    if (in_array($f, $allowed)) {
        executeRequete("UPDATE `diagnostic_options` SET `$f`='$val' WHERE id=$oid AND id_etape=$id");
        echo json_encode(['ok'=>true]); exit;
    }
}

// Chargement étape
$res = executeRequete("SELECT * FROM diagnostic_etapes WHERE id=$id");
$etape = mysqli_fetch_assoc($res);
if (!$etape) { echo "<p>Étape introuvable.</p>"; exit; }

// Options
$options = [];
$resO = executeRequete("SELECT * FROM diagnostic_options WHERE id_etape=$id ORDER BY ordre ASC");
while ($o = mysqli_fetch_assoc($resO)) $options[] = $o;

// Ordre pour next option
$next_opt_ordre = empty($options) ? 10 : (max(array_column($options,'ordre')) + 10);
?>
<div class="row">
  <div class="col-12">
    <!-- Modifier l'étape -->
    <div class="admin-card" style="margin-bottom:1.5rem;">
      <div class="admin-card-header">
        <div class="admin-card-title">Modifier l'étape — Diagnostic Sécurité</div>
        <a href="index.php?r=diagnostic_etapes" class="admin-btn admin-btn-ghost" style="font-size:0.8rem;">← Retour</a>
      </div>
      <div class="admin-card-body">
        <form method="POST">
          <input type="hidden" name="action" value="modif">
          <div class="admin-form-group">
            <label>Question <span class="text-danger">*</span></label>
            <input type="text" name="question" class="admin-input" required value="<?php echo htmlspecialchars($etape['question']); ?>">
          </div>
          <div class="admin-form-group">
            <label>Sous-titre</label>
            <input type="text" name="sous_titre" class="admin-input" value="<?php echo htmlspecialchars($etape['sous_titre'] ?? ''); ?>" placeholder="Ex: Plusieurs choix possibles">
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="admin-form-group">
                <label>Nom du champ</label>
                <input type="text" name="champ" class="admin-input" value="<?php echo htmlspecialchars($etape['champ']); ?>">
                <small style="font-size:0.7rem; color:var(--color-text-secondary);">Identifiant unique (ex: <code>type_batiment</code>)</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="admin-form-group">
                <label>Type</label>
                <select name="choix_multiple" class="admin-input">
                  <option value="0" <?php echo !$etape['choix_multiple'] ? 'selected' : ''; ?>>Choix unique</option>
                  <option value="1" <?php echo $etape['choix_multiple'] ? 'selected' : ''; ?>>Multi-choix</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="admin-form-group">
                <label>Auto-avance</label>
                <select name="avance_auto" class="admin-input">
                  <option value="1" <?php echo $etape['avance_auto'] ? 'selected' : ''; ?>>Oui</option>
                  <option value="0" <?php echo !$etape['avance_auto'] ? 'selected' : ''; ?>>Non</option>
                </select>
              </div>
            </div>
            <div class="col-md-1">
              <div class="admin-form-group">
                <label>Ordre</label>
                <input type="number" name="ordre" class="admin-input" value="<?php echo $etape['ordre']; ?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="admin-form-group">
                <label>État</label>
                <select name="etat" class="admin-input">
                  <option value="1" <?php echo $etape['etat'] ? 'selected' : ''; ?>>Actif</option>
                  <option value="0" <?php echo !$etape['etat'] ? 'selected' : ''; ?>>Inactif</option>
                </select>
              </div>
            </div>
          </div>
          <div class="text-xs-right">
            <button type="submit" class="admin-btn admin-btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Options de cette étape -->
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">Options / Réponses de cette étape</div>
      </div>
      <div class="admin-card-body">
        <?php if (!empty($options)): ?>
        <div class="table-responsive" style="margin-bottom:2rem;">
          <table class="admin-table">
            <thead>
              <tr>
                <th style="width:40px;">Ordre</th>
                <th>Label (texte affiché)</th>
                <th>Valeur stockée</th>
                <th>Icône FontAwesome</th>
                <th>Preview</th>
                <th style="width:50px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($options as $opt): ?>
              <tr>
                <td>
                  <input type="number" value="<?php echo $opt['ordre']; ?>" 
                         style="width:55px; padding:4px; border:1px solid var(--color-border); border-radius:6px; text-align:center;"
                         onchange="updateOption(<?php echo $opt['id']; ?>,'ordre',this.value)">
                </td>
                <td>
                  <input type="text" value="<?php echo htmlspecialchars($opt['label']); ?>"
                         style="width:100%; padding:6px 8px; border:1px solid var(--color-border); border-radius:6px;"
                         onchange="updateOption(<?php echo $opt['id']; ?>,'label',this.value)">
                </td>
                <td>
                  <input type="text" value="<?php echo htmlspecialchars($opt['valeur']); ?>"
                         style="width:100%; padding:6px 8px; border:1px solid var(--color-border); border-radius:6px;"
                         onchange="updateOption(<?php echo $opt['id']; ?>,'valeur',this.value)">
                </td>
                <td>
                  <input type="text" value="<?php echo htmlspecialchars($opt['icone'] ?? ''); ?>"
                         placeholder="fa fa-home"
                         style="width:100%; padding:6px 8px; border:1px solid var(--color-border); border-radius:6px;"
                         onchange="updateOption(<?php echo $opt['id']; ?>,'icone',this.value)">
                </td>
                <td style="text-align:center;">
                  <?php if ($opt['icone']): ?>
                    <i class="<?php echo htmlspecialchars($opt['icone']); ?>" style="font-size:1.5rem; color:var(--color-primary);"></i>
                  <?php else: ?>—<?php endif; ?>
                </td>
                <td>
                  <a href="index.php?r=diagnostic_etapes&action=del_option&id=<?php echo $opt['id']; ?>"
                     onclick="return confirm('Supprimer cette option ?')"
                     class="p-1 text-red-600 hover:text-red-900" title="Supprimer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>

        <!-- Ajouter une option -->
        <div style="border:1px dashed var(--color-border); border-radius:0.75rem; padding:1.25rem;">
          <h5 style="font-weight:700; margin-bottom:1rem; color:var(--color-primary);">+ Ajouter une option</h5>
          <form method="POST">
            <input type="hidden" name="action" value="add_option">
            <div class="row">
              <div class="col-md-4">
                <div class="admin-form-group">
                  <label>Label (texte affiché) *</label>
                  <input type="text" name="label" class="admin-input" required placeholder="Ex: Ma maison">
                </div>
              </div>
              <div class="col-md-3">
                <div class="admin-form-group">
                  <label>Valeur stockée</label>
                  <input type="text" name="valeur" class="admin-input" placeholder="Laisser vide = même que label">
                </div>
              </div>
              <div class="col-md-3">
                <div class="admin-form-group">
                  <label>Icône FontAwesome</label>
                  <input type="text" name="icone" class="admin-input" placeholder="fa fa-home">
                </div>
              </div>
              <div class="col-md-2">
                <div class="admin-form-group">
                  <label>Ordre</label>
                  <input type="number" name="ordre" class="admin-input" value="<?php echo $next_opt_ordre; ?>">
                </div>
              </div>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Ajouter l'option</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function updateOption(oid, field, value) {
    var fd = new FormData();
    fd.append('action','update_option');
    fd.append('oid', oid);
    fd.append('field', field);
    fd.append('value', value);
    fetch(window.location.href, {method:'POST', body:fd})
      .then(r => r.json())
      .then(d => { if(d.ok) { /* silent save */ } });
}
</script>
