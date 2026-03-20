<?php
$nbArticles = (isset($_SESSION['panier']['idcart']) && is_array($_SESSION['panier']['idcart'])) ? count($_SESSION['panier']['idcart']) : 0;
?>
<!-- ── Floating Cart Icon ──────────────────────────── -->
<a href="<?php echo lienPanier(); ?>" id="floating-cart" aria-label="Voir votre panier">
  <div class="fc-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    <span class="fc-badge" id="floatingCartCount"><?php echo $nbArticles; ?></span>
  </div>
  <span class="fc-text">Voir votre panier</span>
</a>

<style>
  #floating-cart {
    position: fixed;
    bottom: 1.5rem;
    left: 1.5rem;
    z-index: 8000;
    display: flex;
    align-items: center;
    background: var(--shop-surface, #fff);
    border: 1px solid var(--shop-border, #e5e7eb);
    border-radius: 2rem;
    padding: 0.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,.12);
    text-decoration: none;
    transition: all 400ms cubic-bezier(0.22, 1, 0.36, 1);
    white-space: nowrap;
    overflow: hidden;
    max-width: 56px; /* Collapse to icon size initially */
  }
  
  #floating-cart:hover {
    max-width: 250px;
    padding-right: 1.25rem;
    box-shadow: 0 12px 40px color-mix(in srgb, var(--shop-primary, #5A31F4) 20%, transparent);
    border-color: var(--shop-primary, #5A31F4);
    text-decoration: none;
  }

  .fc-icon {
    width: 38px; height: 38px;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    background: var(--shop-primary, #5A31F4);
    color: white;
    border-radius: 50%;
    position: relative;
    transition: transform 300ms ease;
  }
  
  #floating-cart:hover .fc-icon {
    transform: scale(1.05) rotate(-5deg);
  }
  
  .fc-badge {
    position: absolute;
    top: -4px; right: -4px;
    background: #ef4444;
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    min-width: 18px; height: 18px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--shop-surface, #fff);
    padding: 0 4px;
    transition: transform 200ms ease;
  }

  .fc-text {
    margin-left: 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--shop-text-primary, #1a1a2e);
    opacity: 0;
    transform: translateX(-10px);
    transition: all 400ms cubic-bezier(0.22, 1, 0.36, 1);
  }

  #floating-cart:hover .fc-text {
    opacity: 1;
    transform: translateX(0);
    color: var(--shop-primary, #5A31F4);
  }

  /* Dark mode */
  [data-theme="dark"] #floating-cart { box-shadow: 0 8px 32px rgba(0,0,0,.4); }
  [data-theme="dark"] .fc-badge { border-color: var(--shop-surface, #1e1e2d); }

  /* Mobile */
  @media (max-width: 480px) {
    #floating-cart { bottom: 1rem; left: 1rem; }
  }
</style>