<?php /* ── historique_commandes.php ── Tableau + Timeline de suivi ── */ ?>

<?php
// ── CSS du stepper (inlined une seule fois) ──────────────────────────────────
if (!defined('TRK_CSS_LOADED')) {
    define('TRK_CSS_LOADED', true);
    ?>
<style>
/* ═══════════════════════════════════════════
   ORDER TRACKING TIMELINE — STEPPER CSS
   ═══════════════════════════════════════════ */

/* --- Table overrides --- */
#commandes { border-collapse: separate; border-spacing: 0; }
#commandes thead th {
    background: color-mix(in srgb, var(--shop-primary,#5A31F4) 8%, transparent);
    color: var(--shop-text-secondary,#6b7280);
    font-size: 0.72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
    padding: 0.75rem 1rem; border-bottom: 2px solid var(--shop-border,#e5e7eb);
}
#commandes tbody td { padding: 0.9rem 1rem; vertical-align: middle; font-size: 0.875rem; }
#commandes tbody tr:not(.trk-row):hover > td { background: color-mix(in srgb, var(--shop-primary,#5A31F4) 4%, transparent); }

/* --- Tracking row --- */
.trk-row { background: transparent !important; }
.trk-row > td { padding: 0 !important; border-top: none !important; }
.trk-panel {
    display: none;
    padding: 1.25rem 1.25rem 1.5rem;
    background: var(--shop-bg-alt, #f9fafb);
    border-top: 1px dashed var(--shop-border,#e5e7eb);
    border-bottom: 2px solid var(--shop-border,#e5e7eb);
    border-radius: 0 0 1rem 1rem;
}
.trk-panel.is-open { display: block; }

/* --- Bouton Suivi --- */
.btn-suivi {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.35rem 0.75rem; border-radius: 0.6rem;
    font-size: 0.75rem; font-weight: 600; cursor: pointer;
    background: color-mix(in srgb, var(--shop-primary,#5A31F4) 10%, transparent);
    color: var(--shop-primary,#5A31F4);
    border: 1.5px solid color-mix(in srgb, var(--shop-primary,#5A31F4) 30%, transparent);
    transition: all 200ms ease; text-decoration: none;
}
.btn-suivi:hover {
    background: var(--shop-primary,#5A31F4); color: #fff;
    transform: translateY(-1px);
}
.btn-suivi.is-open {
    background: var(--shop-primary,#5A31F4); color: #fff;
}
.btn-suivi .trk-chevron {
    transition: transform 300ms ease;
    font-size: 0.7rem;
}
.btn-suivi.is-open .trk-chevron { transform: rotate(180deg); }

/* --- Loading spinner --- */
.trk-loading {
    display: flex; align-items: center; gap: 0.6rem;
    color: var(--shop-text-secondary,#6b7280); font-size: 0.85rem; padding: 0.5rem 0;
}
.trk-spinner {
    width: 18px; height: 18px; border: 2px solid var(--shop-border,#e5e7eb);
    border-top-color: var(--shop-primary,#5A31F4); border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* --- Timeline stepper vertical --- */
.trk-timeline {
    display: flex; flex-direction: column; gap: 0;
    position: relative; padding-left: 2.5rem; margin-top: 0.25rem;
}
.trk-step {
    position: relative; display: flex; gap: 0.875rem;
    padding-bottom: 1.5rem; min-height: 52px;
}
.trk-step:last-child { padding-bottom: 0; }

/* Ligne de connexion verticale */
.trk-line {
    position: absolute;
    left: -1.8rem;
    top: 22px;
    bottom: -4px;
    width: 2px;
    background: linear-gradient(to bottom, var(--shop-border,#d1d5db), color-mix(in srgb, var(--shop-border,#d1d5db) 40%, transparent));
}

/* Cercle icône */
.trk-dot {
    position: absolute;
    left: -2.5rem;
    top: 0;
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 2.5px solid;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
    z-index: 1;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 200ms ease;
}
.trk-step--active .trk-dot {
    transform: scale(1.12);
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}

/* Texte */
.trk-content { padding-left: 0.25rem; }
.trk-label {
    font-weight: 700; font-size: 0.875rem; line-height: 1.35;
    margin-bottom: 0.15rem;
}
.trk-step--active .trk-label { font-size: 0.9rem; }
.trk-date {
    font-size: 0.75rem; color: var(--shop-text-secondary,#6b7280);
    margin-bottom: 0.15rem;
}
.trk-comment {
    font-size: 0.78rem; color: var(--shop-text-secondary,#4b5563);
    background: var(--shop-surface,#fff);
    border-left: 3px solid var(--shop-primary,#5A31F4);
    padding: 0.3rem 0.6rem; border-radius: 0 0.375rem 0.375rem 0;
    margin-top: 0.3rem; font-style: italic;
}
.trk-error { color: #ef4444; font-size: 0.85rem; }

/* Dark mode */
html.dark .trk-panel, body.dark-mode .trk-panel {
    background: #1a1a2e;
}
html.dark .trk-comment, body.dark-mode .trk-comment {
    background: #1e1e2d;
}
</style>
<?php } ?>

<table class="table table-bordered table-responsive-lg table-hover" id="commandes">
  <thead>
    <tr>
      <th style="width:15%">N° commande</th>
      <th style="width:22%">Date commande</th>
      <th style="width:18%">Total</th>
      <th style="width:20%">État</th>
      <th style="width:25%"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $idclient = $_SESSION['client_id'];
    $requete11 = 'SELECT * FROM `commandes` WHERE `idclient`="'.$idclient.'" ORDER BY `ID` DESC';
    $resultat11 = executeRequete($requete11);
    $num11 = mysqli_num_rows($resultat11);
    if ($num11 == 0): ?>
      <tr><td colspan="5" class="text-center py-4 text-muted"><i class="fa fa-inbox fa-2x mb-2 d-block"></i>Aucune commande pour le moment</td></tr>
    <?php endif;
    while ($data11 = mysqli_fetch_array($resultat11)): ?>

      <!-- Ligne principale de commande -->
      <tr class="order-row" data-cmdid="<?php echo intval($data11['id']); ?>">
        <td><strong>#CMD-<?php echo afficheChamp($data11['id']); ?></strong></td>
        <td><?php echo timestampTDtodate($data11['date']); ?></td>
        <td><strong><?php echo afficheChamp($data11['total']); ?> TND</strong></td>
        <td style="text-align:center"><?php echo etatCommande($data11['id'])."</span>"; ?></td>
        <td>
          <div style="display:flex; gap:0.4rem; align-items:center; flex-wrap:wrap;">
            <!-- Bouton Suivi Timeline -->
            <button class="btn-suivi trk-toggle"
                    data-id="<?php echo intval($data11['id']); ?>"
                    aria-expanded="false"
                    title="Suivi de livraison">
              <i class="fa fa-map-marker"></i> Suivi
              <i class="fa fa-angle-down trk-chevron"></i>
            </button>

            <?php if ($data11['etat'] != 9 && $data11['moyen_paiement'] == 10):
              $urlOg  = "";
              $urlOg .= qteCommande($data11['id']).' x '.produitCommande($data11['id'])." / ";
              $urlOg  = rtrim($urlOg, " / ");
              $payment_link = "https://wa.me/".$cmd_num_whatsapp."?text=".urlencode(str_replace('%%lien_produit%%', $urlOg, $message_cmd_whatsapp)); ?>
              <button class="btn btn-sm btn-danger"
                      style="margin-top:0;"
                      title="Finaliser le paiement"
                      onclick="window.open('<?php echo $payment_link; ?>', '_blank');">
                <i class="fa fa-credit-card"></i>
              </button>
            <?php endif; ?>

            <!-- Bouton Détails -->
            <a class="btn btn-sm btn-infos"
               title="Détails commande"
               href="<?php echo lienDeatilCommandes($data11['id']); ?>">
              <i class="fa fa-search text-inverse m-r-10"></i>
            </a>
          </div>
        </td>
      </tr>

      <!-- Ligne du panel de tracking (cachée par défaut) -->
      <tr class="trk-row" id="trk-row-<?php echo intval($data11['id']); ?>">
        <td colspan="5">
          <div class="trk-panel" id="trk-panel-<?php echo intval($data11['id']); ?>">
            <div class="trk-loading">
              <div class="trk-spinner"></div>
              Chargement du suivi…
            </div>
          </div>
        </td>
      </tr>

    <?php endwhile; ?>
  </tbody>
</table>

<!-- Modal bancaire -->
<div class="modal fade" id="bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paiement par virement bancaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"><?php echo messageEmail(8); ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
    // Endpoint AJAX — URL absolue générée dynamiquement par PHP (fonctionne en local et en production)
    var endpoint = '<?php echo rtrim(htmlspecialchars($chemin_absolu ?? ''), '/'); ?>/includes/get_tracking.php';

    // Cache : ne pas refetcher deux fois la même commande
    var fetched = {};

    document.querySelectorAll('.trk-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id     = btn.dataset.id;
            var panel  = document.getElementById('trk-panel-' + id);
            var isOpen = panel.classList.contains('is-open');

            // Toggle open/close
            panel.classList.toggle('is-open', !isOpen);
            btn.classList.toggle('is-open', !isOpen);
            btn.setAttribute('aria-expanded', String(!isOpen));

            // Charger le contenu une seule fois
            if (!isOpen && !fetched[id]) {
                fetched[id] = true;
                fetch(endpoint + '?id=' + encodeURIComponent(id))
                    .then(function (r) { return r.text(); })
                    .then(function (html) { panel.innerHTML = html; })
                    .catch(function () {
                        panel.innerHTML = '<p class="trk-error"><i class="fa fa-exclamation-circle me-1"></i>Impossible de charger le suivi.</p>';
                    });
            }
        });
    });
})();
</script>
