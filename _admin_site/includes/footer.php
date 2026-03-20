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

<script>
function confirmGlobalDelete(url) {
    document.getElementById('confirmGlobalDeleteBtn').href = url;
    document.getElementById('globalDeleteModal').style.display = 'block';
}
function closeGlobalDeleteModal() {
    document.getElementById('globalDeleteModal').style.display = 'none';
}
// Fermer au clic extérieur
document.addEventListener('click', function(event) {
    var modal = document.getElementById('globalDeleteModal');
    if (event.target == modal) {
        closeGlobalDeleteModal();
    }
});
</script>