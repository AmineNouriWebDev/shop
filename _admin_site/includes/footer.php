<footer style="text-align:center;font-size:0.75rem;color:var(--color-text-muted,#9B96BB);padding:1.5rem;border-top:1px solid var(--color-border,#E8E4FF);margin-top:auto;">
    © <?php echo date('Y'); ?> <?php echo htmlspecialchars($nom_site ?? 'TechnoPlus'); ?> — Administration
</footer>

<!-- Modal Global de Confirmation de Suppression -->
<div id="globalDeleteModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div style="background-color:var(--color-bg, #fff); margin:15% auto; padding:20px; border-radius:12px; width:90%; max-width:400px; box-shadow:0 10px 30px rgba(0,0,0,0.5); border:1px solid var(--color-border, #eee); text-align:center;">
        <div style="font-size:3rem; color:#EF4444; margin-bottom:15px;"><i class="fa fa-exclamation-triangle"></i></div>
        <h2 style="margin-top:0; font-size:1.25rem; color:var(--shop-text-primary, #333); margin-bottom:10px;">Confirmer la suppression</h2>
        <p style="color:var(--shop-text-muted, #666); margin-bottom:20px;">Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>
        <div style="display:flex; justify-content:center; gap:10px;">
            <button onclick="closeGlobalDeleteModal()" class="admin-btn admin-btn-ghost btn btn-inverse" style="padding:0.6rem 1.2rem; cursor:pointer;">Annuler</button>
            <a id="confirmGlobalDeleteBtn" href="#" class="admin-btn admin-btn-primary btn btn-danger" style="padding:0.6rem 1.2rem; text-decoration:none;">Oui, supprimer</a>
        </div>
    </div>
</div>

<!-- Modal Global de Confirmation d'Acceptation de Commande -->
<div id="globalAcceptModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div style="background-color:var(--color-bg, #fff); margin:15% auto; padding:24px; border-radius:12px; width:90%; max-width:420px; box-shadow:0 10px 30px rgba(0,0,0,0.4); border:1px solid var(--color-border, #eee); text-align:center;">
        <div style="width:52px; height:52px; border-radius:50%; background:rgba(16,185,129,0.12); color:#10b981; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <h2 style="margin-top:0; font-size:1.25rem; font-weight:700; color:var(--shop-text-primary, #1e293b); margin-bottom:8px;">Accepter la commande <span id="acceptModalCmdNum"></span></h2>
        <p style="color:var(--shop-text-muted, #64748b); font-size:0.875rem; margin-bottom:20px; line-height:1.5;">Voulez-vous accepter directement cette commande ? Son statut passera à <strong>« Traitement en cours »</strong>.</p>
        <div style="display:flex; justify-content:center; gap:10px;">
            <button type="button" onclick="closeGlobalAcceptModal()" class="admin-btn admin-btn-ghost" style="padding:0.6rem 1.2rem; cursor:pointer;">Annuler</button>
            <button type="button" id="confirmGlobalAcceptBtn" class="admin-btn" style="background:#10b981; color:#fff; padding:0.6rem 1.4rem; border:none; border-radius:6px; font-weight:600; cursor:pointer;">Oui, accepter</button>
        </div>
    </div>
</div>

<!-- Modal Global de Confirmation d'Expédition de Commande -->
<div id="globalExpedieModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
    <div style="background-color:var(--color-bg, #fff); margin:15% auto; padding:24px; border-radius:12px; width:90%; max-width:420px; box-shadow:0 10px 30px rgba(0,0,0,0.4); border:1px solid var(--color-border, #eee); text-align:center;">
        <div style="width:52px; height:52px; border-radius:50%; background:rgba(59,130,246,0.12); color:#3b82f6; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <h2 style="margin-top:0; font-size:1.25rem; font-weight:700; color:var(--shop-text-primary, #1e293b); margin-bottom:8px;">Expédier la commande <span id="expedieModalCmdNum"></span></h2>
        <p style="color:var(--shop-text-muted, #64748b); font-size:0.875rem; margin-bottom:20px; line-height:1.5;">Voulez-vous marquer cette commande comme expédiée ? Son statut passera à <strong>« Commande Expédiée »</strong>.</p>
        <div style="display:flex; justify-content:center; gap:10px;">
            <button type="button" onclick="closeGlobalExpedieModal()" class="admin-btn admin-btn-ghost" style="padding:0.6rem 1.2rem; cursor:pointer;">Annuler</button>
            <button type="button" id="confirmGlobalExpedieBtn" class="admin-btn" style="background:#3b82f6; color:#fff; padding:0.6rem 1.4rem; border:none; border-radius:6px; font-weight:600; cursor:pointer;">Oui, expédier</button>
        </div>
    </div>
</div>

<script>
function confirmGlobalDelete(url) {
    document.getElementById('confirmGlobalDeleteBtn').href = url;
    document.getElementById('globalDeleteModal').style.display = 'block';
}
function closeGlobalDeleteModal() {
    document.getElementById('globalDeleteModal').style.display = 'none';
}
function closeGlobalAcceptModal() {
    var modal = document.getElementById('globalAcceptModal');
    if (modal) modal.style.display = 'none';
    if (typeof pendingAcceptCmdId !== 'undefined') pendingAcceptCmdId = null;
}
function closeGlobalExpedieModal() {
    var modal = document.getElementById('globalExpedieModal');
    if (modal) modal.style.display = 'none';
    if (typeof pendingExpedieCmdId !== 'undefined') pendingExpedieCmdId = null;
}
// Fermer au clic extérieur
document.addEventListener('click', function(event) {
    var delModal = document.getElementById('globalDeleteModal');
    if (event.target == delModal) {
        closeGlobalDeleteModal();
    }
    var accModal = document.getElementById('globalAcceptModal');
    if (event.target == accModal) {
        closeGlobalAcceptModal();
    }
    var expModal = document.getElementById('globalExpedieModal');
    if (event.target == expModal) {
        closeGlobalExpedieModal();
    }
});
</script>