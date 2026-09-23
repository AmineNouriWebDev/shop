<?php
/**
 * Formulaire d'ajout d'une étape PC — inclus par configurateur_pc.php
 * Les variables $allCats, $pc_roles, $catProdCount sont disponibles depuis le parent.
 */
// Récupérer tous les produits pour la liste de sélection directe (limité à 300)
$allProds = [];
$resP = executeRequete("SELECT id, titre, categorie FROM produits WHERE etat='1' ORDER BY titre ASC LIMIT 300");
while ($p = mysqli_fetch_assoc($resP)) {
    $allProds[] = [
        'id'    => $p['id'],
        'titre' => html_entity_decode(afficheChamp($p['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        'cat'   => $p['categorie']
    ];
}
?>
<form method="POST" action="index.php?r=configurateur_pc">
  <input type="hidden" name="action" value="add_pc_etape">
  <h6 style="font-weight:700;color:#374151;margin-bottom:12px;">
    <i class="fa fa-plus-circle text-primary"></i> Nouvelle étape PC
  </h6>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label class="admin-label">Nom de l'étape <span style="color:red">*</span></label>
        <input type="text" name="etape_titre" class="admin-input" placeholder="Ex: Processeur" required autocomplete="off">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label class="admin-label">Rôle (comportement)</label>
        <select name="etape_role" class="admin-select" onchange="document.getElementById('pc-prix-div').style.display = (this.value === 'frais_installation' ? 'block' : 'none');">
          <?php foreach ($pc_roles as $rk => $rl): ?>
          <option value="<?php echo htmlspecialchars($rk); ?>"><?php echo htmlspecialchars($rl); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="admin-label">Obligatoire ?</label>
        <select name="etape_obligatoire" class="admin-select">
          <option value="1">Oui</option>
          <option value="0">Non</option>
        </select>
      </div>
    </div>
    <div class="col-md-2" id="pc-prix-div" style="display:none;">
      <div class="form-group">
        <label class="admin-label">Prix (DT)</label>
        <input type="number" step="0.001" name="etape_montant_fixe" class="admin-input" placeholder="Ex: 50.000" autocomplete="off">
      </div>
    </div>
  </div>

  <div class="row mt-2">
    <!-- Catégories de produits -->
    <div class="col-md-6">
      <div class="form-group">
        <label class="admin-label">
          <i class="fa fa-folder text-primary"></i>
          Catégories de produits à inclure
          <small class="text-muted">(recommandé)</small>
        </label>
        <p style="font-size:0.76rem;color:#6b7280;margin-bottom:6px;">Tous les produits de ces catégories seront disponibles à cette étape.</p>
        <select name="etape_categories[]" multiple class="admin-select" style="height:200px;" id="pc-cats-select">
          <?php
          $lastParent = null;
          foreach ($allCats as $cat):
            $nb = $catProdCount[$cat['id']] ?? 0;
            if ($cat['parent'] == 0 && $lastParent !== 0) {
              if ($lastParent !== null) echo '</optgroup>';
              echo '<optgroup label="' . htmlspecialchars($cat['titre'], ENT_QUOTES, 'UTF-8') . '">';
              $lastParent = 0;
            } elseif ($cat['parent'] == 0) {
              // root category shown directly
            }
          ?>
          <option value="<?php echo $cat['id']; ?>"
            <?php echo $nb === 0 ? 'style="color:#d1d5db;"' : ''; ?>>
            <?php echo ($cat['parent'] > 0 ? '  → ' : '') . htmlspecialchars($cat['titre'], ENT_QUOTES, 'UTF-8'); ?>
            (<?php echo $nb; ?> produit<?php echo $nb > 1 ? 's' : ''; ?>)
          </option>
          <?php endforeach; ?>
        </select>
        <small class="text-muted">Ctrl+Click pour sélectionner plusieurs catégories</small>
      </div>
    </div>

    <!-- OU : Produits spécifiques -->
    <div class="col-md-6">
      <div class="form-group">
        <label class="admin-label">
          <i class="fa fa-cube text-success"></i>
          Produits spécifiques (optionnel)
        </label>
        <input type="text" placeholder="🔍 Filtrer les produits..." class="admin-input" style="margin-bottom:6px;" oninput="filterPcProduits(this.value)">
        <p style="font-size:0.76rem;color:#6b7280;margin-bottom:6px;">Alternative : sélectionnez des produits précis (sans passer par une catégorie).</p>
        <select name="etape_produits[]" multiple class="admin-select" style="height:200px;" id="pc-produits-select">
          <?php foreach ($allProds as $prod): ?>
          <option value="<?php echo $prod['id']; ?>"
                  data-titre="<?php echo strtolower(htmlspecialchars($prod['titre'], ENT_QUOTES, 'UTF-8')); ?>">
            <?php echo htmlspecialchars(mb_strimwidth($prod['titre'], 0, 55, '…'), ENT_QUOTES, 'UTF-8'); ?>
          </option>
          <?php endforeach; ?>
        </select>
        <small class="text-muted">Ctrl+Click pour sélectionner plusieurs produits</small>
      </div>
    </div>
  </div>

  <div style="display:flex;gap:10px;margin-top:10px;">
    <button type="submit" class="admin-btn admin-btn-primary">
      <i class="fa fa-check"></i> Enregistrer l'étape
    </button>
    <?php if (isset($etapes) && count($etapes) > 0): ?>
    <button type="button" class="admin-btn" onclick="toggleAddForm()">Annuler</button>
    <?php endif; ?>
  </div>
</form>