<?php
if (isset($_POST['action']) && $_POST['action'] === 'ajout') {
    $question      = formReception($_POST['question']);
    $sous_titre    = formReception($_POST['sous_titre'] ?? '');
    $champ         = formReception($_POST['champ']);
    $choix_multiple = intval($_POST['choix_multiple'] ?? 0);
    $avance_auto   = intval($_POST['avance_auto'] ?? 1);
    $ordre         = intval($_POST['ordre'] ?? 0);
    $etat          = intval($_POST['etat'] ?? 1);

    $req = "INSERT INTO `diagnostic_etapes` (question, sous_titre, champ, choix_multiple, avance_auto, ordre, etat)
            VALUES ('$question','$sous_titre','$champ','$choix_multiple','$avance_auto','$ordre','$etat')";
    executeRequete($req);
    $newid = mysqli_insert_id($connexion);
    echo "<script>window.location.href='index.php?r=mdiagnostic_etape&id=$newid';</script>";
    exit;
}
// Default order
$res = executeRequete("SELECT MAX(ordre) as m FROM diagnostic_etapes");
$row = mysqli_fetch_assoc($res);
$next_ordre = ($row['m'] ?? 0) + 10;
?>
<div class="row">
  <div class="col-12">
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title">+ Ajouter une étape au formulaire Diagnostic</div>
      </div>
      <div class="admin-card-body">
        <form method="POST">
          <input type="hidden" name="action" value="ajout">
          <div class="admin-form-group">
            <label>Question <span class="text-danger">*</span></label>
            <input type="text" name="question" class="admin-input" required placeholder="Ex: Que souhaitez-vous protéger ?">
          </div>
          <div class="admin-form-group">
            <label>Sous-titre (optionnel)</label>
            <input type="text" name="sous_titre" class="admin-input" placeholder="Ex: Plusieurs choix possibles">
          </div>
          <div class="admin-form-group">
            <label>Nom du champ <span class="text-danger">*</span></label>
            <input type="text" name="champ" class="admin-input" required placeholder="Ex: type_batiment (sans espaces, minuscules)">
            <small style="color:var(--color-text-secondary);">
                <strong>Important :</strong> Ce nom identifie la question. <br>
                - Utilisez des noms existants (<code>type_batiment</code>, <code>type_camera</code>, <code>zones</code>, <code>raisons</code>, <code>alimentation</code>) pour remplir les colonnes spécifiques.<br>
                - Utilisez un nouveau nom (ex: <code>nombre_etages</code>) pour que la réponse soit stockée dans la colonne "Détails" globale.
            </small>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="admin-form-group">
                <label>Type de choix</label>
                <select name="choix_multiple" class="admin-input">
                  <option value="0">Choix unique</option>
                  <option value="1">Multi-choix</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="admin-form-group">
                <label>Avance automatique</label>
                <select name="avance_auto" class="admin-input">
                  <option value="1">Oui (après sélection)</option>
                  <option value="0">Non (bouton Valider)</option>
                </select>
                <small style="color:var(--color-text-secondary);">Ignoré si multi-choix.</small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="admin-form-group">
                <label>Ordre</label>
                <input type="number" name="ordre" class="admin-input" value="<?php echo $next_ordre; ?>">
              </div>
            </div>
            <div class="col-md-2">
              <div class="admin-form-group">
                <label>État</label>
                <select name="etat" class="admin-input">
                  <option value="1">Actif</option>
                  <option value="0">Inactif</option>
                </select>
              </div>
            </div>
          </div>
          <div class="text-xs-right mt-4">
            <button type="submit" class="admin-btn admin-btn-primary">Créer et ajouter les options</button>
            <a href="index.php?r=diagnostic_etapes" class="admin-btn admin-btn-ghost">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
