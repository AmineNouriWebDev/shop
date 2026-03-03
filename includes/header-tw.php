<?php
/**
 * ============================================================
 * SHOP — Header 2026 (Tailwind v4)
 * ============================================================
 * Remplace progressivement top-bar.php + menu.php + banniere.php.
 * Stratégie : ce fichier est appelé à la place de banniere.php
 * sur les pages migrées. Les pages Bootstrap restent intactes.
 *
 * Usage : dans les pages PHP migrées, remplacer :
 *   <?php include('includes/top-bar.php'); ?>
 *   <?php include('includes/banniere.php'); ?>
 * Par :
 *   <?php include('includes/header-tw.php'); ?>
 * ============================================================
 */

// Récupérer le nombre d'articles du panier
$nbArticlesHeader = isset($nbArticles) ? intval($nbArticles) : 0;

// Récupérer les catégories parentes pour la nav
$nav_categories = [];
$req_nav = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent`='0' ORDER BY `ordre`";
$res_nav = executeRequete($req_nav);
while ($cat = mysqli_fetch_array($res_nav)) {
    $req_sub = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent`='".$cat['id']."' ORDER BY `ordre`";
    $res_sub = executeRequete($req_sub);
    $subs = [];
    while ($sub = mysqli_fetch_array($res_sub)) {
        $subs[] = $sub;
    }
    $cat['_subs'] = $subs;
    $nav_categories[] = $cat;
}

// Récupérer les pages de menu
$nav_pages = [];
$req_pages = "SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='0' ORDER BY `ordre`";
$res_pages = executeRequete($req_pages);
while ($page = mysqli_fetch_array($res_pages)) {
    $req_sub = "SELECT * FROM `site_menu` WHERE `etat` = '1' AND `affichage_menu`='1' AND `idparent`='".$page['id']."' ORDER BY `ordre`";
    $res_sub = executeRequete($req_sub);
    $sub_pages = [];
    while ($sp = mysqli_fetch_array($res_sub)) { $sub_pages[] = $sp; }
    $page['_subs'] = $sub_pages;
    $nav_pages[] = $page;
}

// Valeur de recherche courante
$search_val = (isset($_POST['action']) && $_POST['action'] == 'search') ? htmlspecialchars($_POST['recherche']) : '';
?>

<!-- ═══════════════════════════════════════════════════════════
     HEADER SHOP 2026 — Tailwind Version
     ═══════════════════════════════════════════════════════════ -->
<style>
  /* Inline styles spécifiques au header — évite de polluer le CSS global */
  #main-header {
    font-family: 'Inter', system-ui, sans-serif;
  }

  /* Top bar */
  .sh-topbar {
    background: var(--shop-primary);
    color: rgba(255,255,255,0.95);
    font-size: 0.8125rem;
    padding: 0.4rem 0;
    position: relative;
    z-index: 51;
  }
  html.dark .sh-topbar {
    background: color-mix(in srgb, var(--shop-primary) 60%, var(--shop-bg-alt-dark));
  }
  .sh-topbar a { color: rgba(255,255,255,0.9); text-decoration: none; }
  .sh-topbar a:hover { color: white; }

  /* Main header */
  .sh-header {
    position: sticky;
    top: 0;
    z-index: 50;
    background: color-mix(in srgb, var(--shop-surface) 92%, transparent);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--shop-border);
    transition: background 250ms ease, border-color 200ms ease;
  }
  html.dark .sh-header {
    background: color-mix(in srgb, var(--shop-surface) 88%, transparent);
    border-color: var(--shop-border);
  }

  .sh-header-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
    height: 68px;
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  /* Logo */
  .sh-logo img { max-height: 48px; width: auto; object-fit: contain; }

  /* Search */
  .sh-search {
    flex: 1;
    max-width: 540px;
    position: relative;
  }
  .sh-search-input {
    width: 100%;
    height: 42px;
    padding: 0 3rem 0 1rem;
    border-radius: 0.75rem;
    border: 1.5px solid var(--shop-border);
    background: var(--shop-bg-base);
    color: var(--shop-text-primary);
    font-family: inherit;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 200ms ease, box-shadow 200ms ease;
  }
  .sh-search-input::placeholder { color: var(--shop-text-disabled); }
  .sh-search-input:focus {
    border-color: var(--shop-primary);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--shop-primary) 15%, transparent);
  }
  .sh-search-btn {
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 42px;
    display: flex; align-items: center; justify-content: center;
    background: var(--shop-primary);
    border: none;
    border-radius: 0 0.75rem 0.75rem 0;
    color: white;
    cursor: pointer;
    transition: background 200ms ease;
  }
  .sh-search-btn:hover { background: var(--shop-primary-hover); }

  /* Actions (icons) */
  .sh-actions { display: flex; align-items: center; gap: 0.5rem; margin-left: auto; }

  /* Cart button */
  .sh-cart {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    background: var(--shop-primary);
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 200ms ease;
    white-space: nowrap;
  }
  .sh-cart:hover { background: var(--shop-primary-hover); transform: translateY(-1px); box-shadow: var(--shop-shadow-glow); color: white; text-decoration: none; }
  .sh-cart-badge {
    position: absolute;
    top: -6px; right: -6px;
    min-width: 20px; height: 20px;
    padding: 0 5px;
    background: var(--shop-accent);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: 9999px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--shop-surface);
  }

  /* Login btn */
  .sh-login {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    border: 1.5px solid var(--shop-border);
    color: var(--shop-text-primary);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 200ms ease;
    white-space: nowrap;
  }
  .sh-login:hover { border-color: var(--shop-primary); color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 5%, transparent); text-decoration: none; }

  /* Dark mode toggle */
  .sh-dark-toggle {
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 0.625rem;
    border: 1.5px solid var(--shop-border);
    background: transparent;
    color: var(--shop-text-secondary);
    cursor: pointer;
    transition: all 200ms ease;
    flex-shrink: 0;
  }
  .sh-dark-toggle:hover { border-color: var(--shop-primary); color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 6%, transparent); }
  .sh-dark-toggle .icon-sun,
  .sh-dark-toggle .icon-moon {
    position: absolute; transition: all 300ms ease;
  }
  .sh-dark-toggle { position: relative; }
  .sh-dark-toggle .icon-sun  { opacity: 1; transform: rotate(0deg)   scale(1); }
  .sh-dark-toggle .icon-moon { opacity: 0; transform: rotate(-90deg) scale(0.7); }
  html.dark .sh-dark-toggle .icon-sun  { opacity: 0; transform: rotate(90deg) scale(0.7); }
  html.dark .sh-dark-toggle .icon-moon { opacity: 1; transform: rotate(0deg)   scale(1); }

  /* ── NAV BAR ── */
  .sh-navbar {
    background: var(--shop-surface);
    border-bottom: 1px solid var(--shop-border);
    position: sticky;
    top: 68px;
    z-index: 49;
    transition: background 250ms ease;
  }
  html.dark .sh-navbar { background: var(--shop-surface); }

  .sh-navbar-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    height: 48px;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .sh-navbar-inner::-webkit-scrollbar { display: none; }

  /* Nav items */
  .sh-nav-item {
    position: relative;
  }
  .sh-nav-link {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.5rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--shop-text-primary);
    text-decoration: none;
    white-space: nowrap;
    transition: all 150ms ease;
    border: none;
    background: none;
    cursor: pointer;
    font-family: inherit;
  }
  .sh-nav-link:hover { background: color-mix(in srgb, var(--shop-primary) 8%, transparent); color: var(--shop-primary); text-decoration: none; }
  .sh-nav-link.active { color: var(--shop-primary); background: color-mix(in srgb, var(--shop-primary) 8%, transparent); }

  /* Dropdown */
  .sh-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    min-width: 200px;
    background: var(--shop-surface);
    border: 1px solid var(--shop-border);
    border-radius: 0.875rem;
    box-shadow: var(--shop-shadow-card-hover);
    padding: 0.5rem;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-6px);
    transition: all 200ms ease;
    z-index: 100;
  }
  .sh-nav-item:hover .sh-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
  .sh-dropdown-item {
    display: block;
    padding: 0.5rem 0.875rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--shop-text-secondary);
    text-decoration: none;
    transition: all 150ms ease;
  }
  .sh-dropdown-item:hover { background: color-mix(in srgb, var(--shop-primary) 8%, transparent); color: var(--shop-primary); text-decoration: none; }

  /* Chevron */
  .sh-chevron { transition: transform 250ms ease; }
  .sh-nav-item:hover .sh-chevron { transform: rotate(180deg); }

  /* ── MOBILE ── */
  .sh-mobile-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: var(--shop-surface);
    border-bottom: 1px solid var(--shop-border);
  }

  .sh-hamburger {
    width: 38px; height: 38px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    background: none;
    border: 1.5px solid var(--shop-border);
    border-radius: 0.625rem;
    padding: 8px;
    cursor: pointer;
    transition: all 200ms ease;
  }
  .sh-hamburger:hover { border-color: var(--shop-primary); }
  .sh-hamburger span {
    display: block;
    height: 1.5px;
    background: var(--shop-text-primary);
    border-radius: 9999px;
    transition: all 250ms ease;
  }
  .sh-hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4.5px, 4.5px); }
  .sh-hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
  .sh-hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4.5px, -4.5px); }

  /* Mobile drawer */
  .sh-mobile-drawer {
    position: fixed;
    top: 0; left: 0; bottom: 0;
    width: 300px;
    background: var(--shop-surface);
    z-index: 200;
    padding: 1.5rem;
    transform: translateX(-100%);
    transition: transform 300ms cubic-bezier(0.22, 1, 0.36, 1);
    overflow-y: auto;
    box-shadow: 4px 0 32px rgba(0,0,0,0.15);
  }
  .sh-mobile-drawer.open { transform: translateX(0); }
  .sh-drawer-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 199;
    opacity: 0;
    visibility: hidden;
    transition: all 300ms ease;
    backdrop-filter: blur(2px);
  }
  .sh-drawer-overlay.open { opacity: 1; visibility: visible; }

  .sh-mobile-search {
    display: flex;
    gap: 0.5rem;
    background: var(--shop-bg-alt);
    border: 1.5px solid var(--shop-border);
    border-radius: 0.75rem;
    overflow: hidden;
    flex: 1;
  }
  .sh-mobile-search input {
    flex: 1;
    padding: 0.5rem 0.75rem;
    background: none;
    border: none;
    outline: none;
    color: var(--shop-text-primary);
    font-size: 0.9rem;
    font-family: inherit;
  }
  .sh-mobile-search button {
    padding: 0 0.875rem;
    background: var(--shop-primary);
    border: none;
    color: white;
    cursor: pointer;
  }

  .sh-drawer-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0.5rem;
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--shop-text-primary);
    border-bottom: 1px solid var(--shop-border);
    text-decoration: none;
  }
  .sh-drawer-nav-link:hover { color: var(--shop-primary); text-decoration: none; }
  .sh-drawer-sub-link {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: var(--shop-text-secondary);
    text-decoration: none;
    border-radius: 0.5rem;
  }
  .sh-drawer-sub-link:hover { background: color-mix(in srgb, var(--shop-primary) 8%, transparent); color: var(--shop-primary); text-decoration: none; }

  .sh-drawer-subs { display: none; }
  .sh-drawer-subs.open { display: block; }

  /* ── RESPONSIVE ── */
  @media (max-width: 1023px) {
    .sh-search { display: none; }
    .sh-login  { display: none; }
    .sh-navbar { display: none; }
    .sh-mobile-bar { display: flex; }
    .sh-desktop-cart { display: none; }
  }
  @media (min-width: 1024px) {
    .sh-mobile-bar { display: none; }
    .sh-mobile-drawer { display: none !important; }
    .sh-drawer-overlay { display: none !important; }
  }
</style>

<div id="main-header">

  <!-- ── TOP BAR ── -->
  <div class="sh-topbar">
    <div style="max-width:1400px; margin:0 auto; padding:0 1.5rem; display:flex; align-items:center; justify-content:space-between;">
      <span>
        🚀 Vente Abonnement IPTV, VOD et Sharing aux meilleurs prix
      </span>
      <div style="display:flex; align-items:center; gap:1.25rem;">
        <a href="tel:<?php echo $gsm; ?>" style="display:flex; align-items:center; gap:0.375rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
          <?php echo $gsm; ?>
        </a>
      </div>
    </div>
  </div>

  <!-- ── MAIN HEADER ── -->
  <header class="sh-header">
    <div class="sh-header-inner">

      <!-- Logo -->
      <a href="<?php echo lienAccueil(); ?>" class="sh-logo" style="flex-shrink:0; text-decoration:none;">
        <img src="media/site/<?php echo $logo; ?>" alt="<?php echo $nom_site ?? 'Shop'; ?>" loading="eager">
      </a>

      <!-- Search (desktop) -->
      <form action="<?php echo lienRecherche(); ?>" method="POST" class="sh-search">
        <input
          type="text"
          class="sh-search-input"
          name="recherche"
          placeholder="Rechercher smartphones, PC, accessoires..."
          value="<?php echo $search_val; ?>"
          autocomplete="off"
        >
        <input type="hidden" name="action" value="search">
        <button type="submit" class="sh-search-btn" aria-label="Rechercher">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
      </form>

      <!-- Actions -->
      <div class="sh-actions">

        <!-- Dark mode toggle -->
        <button class="sh-dark-toggle" id="dark-mode-toggle" onclick="window.__toggleTheme()" aria-label="Toggle dark mode">
          <!-- Soleil -->
          <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg>
          <!-- Lune -->
          <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>

        <!-- Login / Mon compte -->
        <?php if (isset($_SESSION['client_id'])): ?>
          <a href="<?php echo lienCompte(); ?>" class="sh-login">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Mon compte
          </a>
          <a href="<?php echo lienDeconnexion(); ?>" class="sh-login" title="Déconnexion" style="padding:0.5rem 0.625rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </a>
        <?php else: ?>
          <a href="<?php echo lienConnexion(); ?>" class="sh-login">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Connexion
          </a>
        <?php endif; ?>

        <!-- Panier -->
        <a href="<?php echo lienPanier(); ?>" class="sh-cart sh-desktop-cart">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          Panier
          <?php if ($nbArticlesHeader > 0): ?>
            <span class="sh-cart-badge"><?php echo $nbArticlesHeader; ?></span>
          <?php endif; ?>
        </a>

      </div>
    </div>
  </header>

  <!-- ── NAVBAR (Desktop) ── -->
  <nav class="sh-navbar" aria-label="Navigation principale">
    <div class="sh-navbar-inner">

      <?php foreach ($nav_categories as $cat): ?>
        <div class="sh-nav-item">
          <a href="<?php echo lienCategories($cat['link']); ?>" class="sh-nav-link">
            <?php echo htmlspecialchars($cat['titre']); ?>
            <?php if (!empty($cat['_subs'])): ?>
              <svg class="sh-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            <?php endif; ?>
          </a>
          <?php if (!empty($cat['_subs'])): ?>
            <div class="sh-dropdown">
              <?php foreach ($cat['_subs'] as $sub): ?>
                <a href="<?php echo lienCategorieEquipements($sub['link']); ?>" class="sh-dropdown-item">
                  <?php echo htmlspecialchars($sub['titre']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <?php foreach ($nav_pages as $page): ?>
        <div class="sh-nav-item">
          <a href="<?php echo (link_externePage($page['id']) != '') ? link_externePage($page['id']) : lienContenu($page['id']); ?>" class="sh-nav-link">
            <?php echo titrePage($page['id']); ?>
            <?php if (!empty($page['_subs'])): ?>
              <svg class="sh-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            <?php endif; ?>
          </a>
          <?php if (!empty($page['_subs'])): ?>
            <div class="sh-dropdown">
              <?php foreach ($page['_subs'] as $sp): ?>
                <a href="<?php echo (link_externePage($sp['id']) != '') ? link_externePage($sp['id']) : lienContenu($sp['id']); ?>" class="sh-dropdown-item">
                  <?php echo titrePage($sp['id']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

    </div>
  </nav>

  <!-- ── MOBILE BAR ── -->
  <div class="sh-mobile-bar">

    <!-- Hamburger -->
    <button class="sh-hamburger" id="sh-hamburger-btn" onclick="shToggleDrawer()" aria-label="Menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Logo mobile -->
    <a href="<?php echo lienAccueil(); ?>" style="flex-shrink:0; text-decoration:none;">
      <img src="media/site/<?php echo $logo; ?>" alt="Shop" style="max-height:38px; width:auto;">
    </a>

    <!-- Search mobile -->
    <form action="<?php echo lienRecherche(); ?>" method="POST" class="sh-mobile-search">
      <input type="text" name="recherche" placeholder="Rechercher..." value="<?php echo $search_val; ?>">
      <input type="hidden" name="action" value="search">
      <button type="submit" aria-label="Rechercher">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </button>
    </form>

    <!-- Panier mobile -->
    <a href="<?php echo lienPanier(); ?>" style="position:relative; color:var(--shop-primary); text-decoration:none; padding:0.25rem;">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <?php if ($nbArticlesHeader > 0): ?>
        <span style="position:absolute; top:-4px; right:-4px; min-width:16px; height:16px; background:var(--shop-accent); color:white; font-size:0.625rem; font-weight:700; border-radius:9999px; display:flex; align-items:center; justify-content:center; padding:0 3px;">
          <?php echo $nbArticlesHeader; ?>
        </span>
      <?php endif; ?>
    </a>

    <!-- Dark toggle mobile -->
    <button class="sh-dark-toggle" onclick="window.__toggleTheme()" aria-label="Dark mode" style="flex-shrink:0;">
      <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg>
      <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    </button>

  </div>

  <!-- ── OVERLAY ── -->
  <div class="sh-drawer-overlay" id="sh-overlay" onclick="shToggleDrawer()"></div>

  <!-- ── MOBILE DRAWER ── -->
  <div class="sh-mobile-drawer" id="sh-drawer" role="navigation" aria-label="Menu mobile">

    <!-- Drawer header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
      <a href="<?php echo lienAccueil(); ?>" style="text-decoration:none;">
        <img src="media/site/<?php echo $logo; ?>" alt="Shop" style="max-height:40px;">
      </a>
      <button onclick="shToggleDrawer()" style="background:none; border:none; color:var(--shop-text-secondary); cursor:pointer; padding:0.25rem;" aria-label="Fermer">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    <!-- Drawer account -->
    <div style="margin-bottom:1rem; padding:0.75rem; background:color-mix(in srgb, var(--shop-primary) 8%, transparent); border-radius:0.75rem;">
      <?php if (isset($_SESSION['client_id'])): ?>
        <a href="<?php echo lienCompte(); ?>" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--shop-primary); text-decoration:none; font-size:0.9rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Mon compte
        </a>
      <?php else: ?>
        <a href="<?php echo lienConnexion(); ?>" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--shop-primary); text-decoration:none; font-size:0.9rem;">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Se connecter
        </a>
      <?php endif; ?>
    </div>

    <!-- Drawer nav — catégories -->
    <?php if (!empty($nav_categories)): ?>
      <p style="font-size:0.6875rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:var(--shop-text-secondary); margin-bottom:0.5rem;">Catégories</p>
      <?php foreach ($nav_categories as $i => $cat): ?>
        <div>
          <?php if (!empty($cat['_subs'])): ?>
            <button onclick="shToggleSub('cat-<?php echo $i; ?>')" class="sh-drawer-nav-link" style="width:100%; background:none; border:none; cursor:pointer; font-family:inherit;">
              <?php echo htmlspecialchars($cat['titre']); ?>
              <svg id="chevron-cat-<?php echo $i; ?>" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transition:transform 250ms ease;"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="sh-drawer-subs" id="cat-<?php echo $i; ?>">
              <?php foreach ($cat['_subs'] as $sub): ?>
                <a href="<?php echo lienCategorieEquipements($sub['link']); ?>" class="sh-drawer-sub-link">
                  → <?php echo htmlspecialchars($sub['titre']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <a href="<?php echo lienCategories($cat['link']); ?>" class="sh-drawer-nav-link">
              <?php echo htmlspecialchars($cat['titre']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <!-- Drawer nav — pages -->
    <?php if (!empty($nav_pages)): ?>
      <p style="font-size:0.6875rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:var(--shop-text-secondary); margin:1rem 0 0.5rem;">Pages</p>
      <?php foreach ($nav_pages as $i => $page): ?>
        <div>
          <?php $plink = (link_externePage($page['id']) != '') ? link_externePage($page['id']) : lienContenu($page['id']); ?>
          <?php if (!empty($page['_subs'])): ?>
            <button onclick="shToggleSub('page-<?php echo $i; ?>')" class="sh-drawer-nav-link" style="width:100%; background:none; border:none; cursor:pointer; font-family:inherit;">
              <?php echo titrePage($page['id']); ?>
              <svg id="chevron-page-<?php echo $i; ?>" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transition:transform 250ms ease;"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="sh-drawer-subs" id="page-<?php echo $i; ?>">
              <?php foreach ($page['_subs'] as $sp): ?>
                <a href="<?php echo (link_externePage($sp['id']) != '') ? link_externePage($sp['id']) : lienContenu($sp['id']); ?>" class="sh-drawer-sub-link">
                  → <?php echo titrePage($sp['id']); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <a href="<?php echo $plink; ?>" class="sh-drawer-nav-link">
              <?php echo titrePage($page['id']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>

</div><!-- #main-header -->

<!-- ── HEADER JAVASCRIPT ── -->
<script>
(function() {
  // Highlight nav link actif
  var url = window.location.href;
  document.querySelectorAll('.sh-nav-link, .sh-drawer-nav-link').forEach(function(el) {
    if (el.href && el.href === url) {
      el.classList.add('active');
    }
  });

  // Mobile drawer toggle
  window.shToggleDrawer = function() {
    var drawer  = document.getElementById('sh-drawer');
    var overlay = document.getElementById('sh-overlay');
    var burger  = document.getElementById('sh-hamburger-btn');
    var isOpen  = drawer.classList.contains('open');
    drawer.classList.toggle('open', !isOpen);
    overlay.classList.toggle('open', !isOpen);
    burger.classList.toggle('open', !isOpen);
    document.body.style.overflow = isOpen ? '' : 'hidden';
  };

  // Mobile sub-menu toggle
  window.shToggleSub = function(id) {
    var el      = document.getElementById(id);
    var chevron = document.getElementById('chevron-' + id);
    var isOpen  = el.classList.contains('open');
    el.classList.toggle('open', !isOpen);
    if (chevron) chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
  };

  // Close drawer on resize to desktop
  var mq = window.matchMedia('(min-width: 1024px)');
  mq.addEventListener('change', function(e) {
    if (e.matches) {
      var drawer  = document.getElementById('sh-drawer');
      var overlay = document.getElementById('sh-overlay');
      var burger  = document.getElementById('sh-hamburger-btn');
      if (drawer)  drawer.classList.remove('open');
      if (overlay) overlay.classList.remove('open');
      if (burger)  burger.classList.remove('open');
      document.body.style.overflow = '';
    }
  });
})();
</script>
