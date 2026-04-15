<?php
/**
 * modifier_code_promo.php - Formulaire de modification
 */

$id = (int)$_GET['id'];
$promo = getCodePromoById($id);

if (!$promo) {
    echo '<script>window.location="index.php?r=codes_promo";</script>';
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'save') {
    if (modifierCodePromo($id, $_POST)) {
        echo '<script>window.location="index.php?r=codes_promo";</script>';
        exit;
    } else {
        $error = "Erreur lors de la modification du code promo.";
    }
}
?>

<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.885L17.5 5.5a2.121 2.121 0 1 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.344Z" />
                    </svg>
                    Modifier le code promo : <?php echo htmlspecialchars($promo['code']); ?>
                </div>
                <a href="index.php?r=codes_promo" class="admin-btn">Retour à la liste</a>
            </div>
            
            <div class="admin-card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" style="padding: 1rem; background: #fef2f2; color: #dc2626; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?r=modifier_code_promo&id=<?php echo $id; ?>" method="post" class="admin-form">
                    <input type="hidden" name="action" value="save">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="admin-form-group">
                                <label for="code">Code promo</label>
                                <input type="text" name="code" id="code" class="admin-input" value="<?php echo htmlspecialchars($promo['code']); ?>" required style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="admin-form-group">
                                <label for="etat">Statut</label>
                                <select name="etat" id="etat" class="admin-input">
                                    <option value="1" <?php if ($promo['etat'] == 1) echo 'selected'; ?>>Actif</option>
                                    <option value="0" <?php if ($promo['etat'] == 0) echo 'selected'; ?>>Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <label for="libelle">Description <small>(Usage interne ou affichage client)</small></label>
                        <input type="text" name="libelle" id="libelle" class="admin-input" value="<?php echo htmlspecialchars($promo['libelle']); ?>" placeholder="Ex: Remise de bienvenue 10%">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label for="type">Type de remise</label>
                                <select name="type" id="type" class="admin-input" onchange="updateSuffix(this.value)">
                                    <option value="percent" <?php if ($promo['type'] == 'percent') echo 'selected'; ?>>Pourcentage (%)</option>
                                    <option value="fixed" <?php if ($promo['type'] == 'fixed') echo 'selected'; ?>>Montant fixe (DT)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label for="valeur">Valeur de la remise</label>
                                <div style="position: relative;">
                                    <input type="number" step="0.001" name="valeur" id="valeur" class="admin-input" value="<?php echo (float)$promo['valeur']; ?>" required placeholder="0.000">
                                    <span id="val_suffix" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #a0aec0; font-weight: 600;">
                                        <?php echo ($promo['type'] == 'percent') ? '%' : 'DT'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 2rem 0; border: none; border-top: 1px solid #edf2f7;">
                    <div style="font-size: 0.8125rem; font-weight: 700; color: #4a5568; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Conditions d'utilisation</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label for="max_utilisations">Nombre d'utilisations max <small>(Vide = illimité)</small></label>
                                <input type="number" name="max_utilisations" id="max_utilisations" class="admin-input" value="<?php echo $promo['max_utilisations']; ?>" placeholder="∞">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-form-group">
                                <label for="date_expiration">Date d'expiration <small>(Optionnel)</small></label>
                                <input type="date" name="date_expiration" id="date_expiration" class="admin-input" value="<?php echo $promo['date_expiration']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="admin-form-group">
                                <label for="montant_min">Montant minimum du panier (DT)</label>
                                <input type="number" step="0.001" name="montant_min" id="montant_min" class="admin-input" value="<?php echo (float)$promo['montant_min']; ?>">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="admin-form-group">
                                <label for="montant_min_type">Appliqué sur</label>
                                <select name="montant_min_type" id="montant_min_type" class="admin-input">
                                    <option value="total" <?php if ($promo['montant_min_type'] == 'total') echo 'selected'; ?>>Le total global</option>
                                    <option value="eligible" <?php if ($promo['montant_min_type'] == 'eligible') echo 'selected'; ?>>Les articles éligibles</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <label for="categories">Catégories applicables <small>(Optionnel - Vide = toutes)</small></label>
                        <select name="categories[]" id="categories" class="admin-input select2" multiple="multiple" style="width: 100%;">
                            <?php
                            $selected_ids = getPromoCategories($id);
                            
                            $req = 'SELECT * FROM `categories_blog` WHERE `idparent` = "0" ORDER BY `ordre` ASC';
                            $res = executeRequete($req);
                            while ($data = mysqli_fetch_array($res)) {
                                $sel = in_array($data['id'], $selected_ids) ? 'selected' : '';
                                echo '<option value="'.$data['id'].'" '.$sel.'>'.afficheChamp1($data['titre']).'</option>';
                                
                                $req1 = 'SELECT * FROM `categories_blog` WHERE `idparent` = "'.$data['id'].'" ORDER BY `ordre` ASC';
                                $res1 = executeRequete($req1);
                                while ($data1 = mysqli_fetch_array($res1)) {
                                    $sel1 = in_array($data1['id'], $selected_ids) ? 'selected' : '';
                                    echo '<option value="'.$data1['id'].'" '.$sel1.'> -- '.afficheChamp1($data1['titre']).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                        <button type="submit" class="admin-btn admin-btn-primary" style="flex: 1; padding: 0.75rem;">
                            Enregistrer les modifications
                        </button>
                        <a href="index.php?r=codes_promo" class="admin-btn" style="padding: 0.75rem;">Annuler</a>
                    </div>
                </form>
                
                <div style="margin-top: 2rem; padding: 1rem; background: #f7fafc; border-radius: 0.5rem; border: 1px solid #edf2f7;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: #718096; text-transform: uppercase; margin-bottom: 0.5rem;">Statistiques actuelles</div>
                    <div style="display: flex; gap: 2rem;">
                        <div>
                            <div style="font-size: 0.75rem; color: #a0aec0;">Utilisations</div>
                            <div style="font-size: 1.125rem; font-weight: 700; color: #2d3748;"><?php echo $promo['utilisations']; ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: #a0aec0;">Créé le</div>
                            <div style="font-size: 1.125rem; font-weight: 700; color: #2d3748;"><?php echo datehtfr($promo['created_at']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateSuffix(val) {
    document.getElementById('val_suffix').innerText = (val === 'percent') ? '%' : 'DT';
}
</script>
