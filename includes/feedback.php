<?php
$nbArticles = (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart'])) ? count($_SESSION['panier']['idcart']) : 0;
?>
<!-- ── Cart Toast Notification ──────────────────────────── -->
<div id="feedback" role="alert" aria-live="polite" aria-atomic="true">
  <div class="fb-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
  </div>
  <div class="fb-body">
    <?php if ($nbArticles): ?>
      <span class="fb-msg">
        Succès ! votre produit à été ajouté au panier.
        <a href="<?php echo lienPanier(); ?>" class="fb-link">Voir votre panier</a>
      </span>
    <?php else: ?>
      <span class="fb-msg">
        votre panier est vide !
        <a href="<?php echo lienCategorie(); ?>" class="fb-link">voir catalogue</a>
      </span>
    <?php endif; ?>
  </div>
  <button class="fb-close" onclick="document.getElementById('feedback').classList.add('fb-hidden')" aria-label="Fermer">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
</div>

<style>
  #feedback {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.125rem;
    background: var(--shop-surface, #fff);
    border: 1px solid var(--shop-border, #e5e7eb);
    border-left: 4px solid var(--shop-primary, #5A31F4);
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(90,49,244,.1);
    max-width: 340px;
    animation: fb-slide-in 350ms cubic-bezier(0.22,1,0.36,1) both;
    transition: opacity 300ms ease, transform 300ms ease;
  }
  #feedback.fb-hidden {
    opacity: 0;
    transform: translateX(120%);
    pointer-events: none;
  }
  @keyframes fb-slide-in {
    from { opacity: 0; transform: translateX(120%); }
    to   { opacity: 1; transform: translateX(0); }
  }
  .fb-icon {
    width: 38px; height: 38px;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: color-mix(in srgb, var(--shop-primary, #5A31F4) 12%, transparent);
    color: var(--shop-primary, #5A31F4);
    border-radius: 0.625rem;
  }
  .fb-body { flex: 1; min-width: 0; }
  .fb-msg {
    display: block;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--shop-text-primary, #1a1a2e);
    line-height: 1.4;
  }
  .fb-link {
    display: inline-block;
    margin-top: 0.25rem;
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--shop-primary, #5A31F4);
    text-decoration: none;
  }
  .fb-link:hover { text-decoration: underline; color: var(--shop-primary, #5A31F4); }
  .fb-close {
    flex-shrink: 0;
    background: none;
    border: none;
    color: var(--shop-text-disabled, #9ca3af);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 0.375rem;
    display: flex; align-items: center; justify-content: center;
    transition: background 150ms ease, color 150ms ease;
  }
  .fb-close:hover { background: var(--shop-bg-alt, #f3f4f6); color: var(--shop-text-primary, #1a1a2e); }

  /* Dark mode */
  [data-theme="dark"] #feedback {
    box-shadow: 0 8px 32px rgba(0,0,0,.3), 0 2px 8px rgba(90,49,244,.2);
  }

  /* Mobile */
  @media (max-width: 480px) {
    #feedback { left: 1rem; right: 1rem; max-width: none; bottom: 1rem; }
  }
</style>

<script>
  // Auto-dismiss after 5 seconds
  (function() {
    var fb = document.getElementById('feedback');
    if (fb) {
      setTimeout(function() {
        fb.classList.add('fb-hidden');
      }, 5000);
    }
  })();
</script>