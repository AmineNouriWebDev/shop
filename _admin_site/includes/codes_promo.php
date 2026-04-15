<?php
/**
 * codes_promo.php - Liste des codes promo
 */

// Traitement des actions
if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] == 'supp') {
        supprimerCodePromo($id);
        echo '<script>window.location="index.php?r=codes_promo&msg=supp_ok";</script>';
        exit;
    }
    if ($_GET['action'] == 'toggle') {
        toggleEtatCodePromo($id);
        echo '<script>window.location="index.php?r=codes_promo";</script>';
        exit;
    }
}

$codes = listCodesPromo();
?>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.608a18.166 18.166 0 0 0 5.198-3.86 3.398 3.398 0 0 0-.608-5.198L11.27 3.24a3 3 0 0 0-2.12-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd"/>
                    </svg>
                    Gestion des codes promo
                </div>
                <a href="index.php?r=ajouter_code_promo" class="admin-btn admin-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Nouveau code promo
                </a>
            </div>
            
            <div class="admin-card-body">
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'supp_ok'): ?>
                    <div class="alert alert-success" style="padding: 1rem; background: #f0fdf4; color: #16a34a; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
                        Le code promo a été supprimé avec succès.
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Valeur</th>
                                <th>Utilisations</th>
                                <th>Expiration</th>
                                <th>Jours restants</th>
                                <th>Statut</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($codes)): ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 2rem; color: #718096;">Aucun code promo trouvé.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($codes as $promo): ?>
                                    <tr>
                                        <td>
                                            <code style="background: #edf2f7; padding: 2px 6px; border-radius: 4px; font-weight: 700; color: #2d3748;"><?php echo htmlspecialchars($promo['code']); ?></code>
                                        </td>
                                        <td><span style="font-size: 0.875rem; color: #4a5568;"><?php echo htmlspecialchars($promo['libelle']); ?></span></td>
                                        <td><?php echo afficherValeurCodePromo($promo); ?></td>
                                        <td><?php echo utilisationsCodePromo($promo); ?></td>
                                        <td><?php echo $promo['date_expiration'] ? datefr($promo['date_expiration']) : '<span style="color:#a0aec0;">-</span>'; ?></td>
                                        <td><?php echo joursRestantsCodePromo($promo['date_expiration']); ?></td>
                                        <td>
                                            <a href="index.php?r=codes_promo&action=toggle&id=<?php echo $promo['id']; ?>" style="text-decoration: none;">
                                                <?php echo statutCodePromo($promo); ?>
                                            </a>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                                <a href="index.php?r=modifier_code_promo&id=<?php echo $promo['id']; ?>" class="admin-btn" style="padding: 0.4rem; background: #ebf4ff; color: #3182ce;" title="Modifier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                                        <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.885L17.5 5.5a2.121 2.121 0 1 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.344Z" />
                                                    </svg>
                                                </a>
                                                <a href="index.php?r=codes_promo&action=supp&id=<?php echo $promo['id']; ?>" class="admin-btn" style="padding: 0.4rem; background: #fff5f5; color: #e53e3e;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?')" title="Supprimer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
