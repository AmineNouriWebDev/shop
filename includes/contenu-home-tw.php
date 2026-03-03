<?php
/**
 * ============================================================
 * SHOP — Homepage Sections 2026 (Tailwind)
 * ============================================================
 * Remplace contenu.php sur la homepage.
 * Préserve toutes les requêtes SQL & fonctions PHP existantes.
 * Contenu alimenté depuis l'administration (aucun hard-code).
 *
 * Usage dans index.php (pages migrées) :
 *   <?php include('includes/contenu-home-tw.php'); ?>
 * ============================================================
 */
?>

<style>
/* ═══════════════════════════════════════════════════════════
   HOMEPAGE 2026 — Styles
   ═══════════════════════════════════════════════════════════ */

.hp-body {
  background: var(--shop-bg-base);
  color: var(--shop-text-primary);
  font-family: 'Inter', system-ui, sans-serif;
  transition: background 250ms ease, color 200ms ease;
}

/* ── Section wrapper ── */
.hp-section {
  padding: clamp(2.5rem, 5vw, 4rem) 0;
}
.hp-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 clamp(1rem, 3vw, 2rem);
}

/* ── Section header ── */
.hp-section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.hp-section-title {
  font-size: clamp(1.25rem, 1rem + 1.5vw, 1.75rem);
  font-weight: 800;
  color: var(--shop-text-primary);
  letter-spacing: -0.025em;
  line-height: 1.2;
  position: relative;
  padding-bottom: 0.75rem;
}
.hp-section-title::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0;
  width: 3rem; height: 3px;
  border-radius: 9999px;
  background: linear-gradient(90deg, var(--shop-primary), var(--shop-secondary));
}
.hp-see-all {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--shop-primary);
  text-decoration: none;
  white-space: nowrap;
  transition: gap 200ms ease;
}
.hp-see-all:hover { gap: 0.625rem; text-decoration: none; color: var(--shop-primary-hover); }
.hp-see-all svg { transition: transform 200ms ease; }
.hp-see-all:hover svg { transform: translateX(3px); }

/* ── Product Card (homepage version) ── */
.hp-card {
  position: relative;
  background: var(--shop-surface);
  border: 1px solid var(--shop-border);
  border-radius: 1.25rem;
  overflow: hidden;
  transition: transform 280ms ease, box-shadow 280ms ease, border-color 280ms ease;
  display: flex;
  flex-direction: column;
}
.hp-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shop-shadow-card-hover, 0 8px 32px rgba(90,49,244,0.18));
  border-color: color-mix(in srgb, var(--shop-primary) 30%, var(--shop-border));
}
.hp-card-img-wrap {
  position: relative;
  aspect-ratio: 1 / 1;
  overflow: hidden;
  background: var(--shop-bg-alt);
  flex-shrink: 0;
}
.hp-card-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center;
  padding: 0.75rem;
  transition: transform 400ms ease;
}
.hp-card:hover .hp-card-img-wrap img { transform: scale(1.06); }

/* Quick-view overlay */
.hp-card-overlay {
  position: absolute;
  inset: 0;
  background: rgba(13,11,26,0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.625rem;
  opacity: 0;
  transition: opacity 250ms ease;
  backdrop-filter: blur(2px);
}
.hp-card:hover .hp-card-overlay { opacity: 1; }
.hp-card-overlay-btn {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.5rem 1rem;
  border-radius: 0.625rem;
  font-size: 0.8125rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: all 200ms ease;
}
.hp-card-overlay-btn.primary {
  background: var(--shop-primary);
  color: white;
}
.hp-card-overlay-btn.primary:hover {
  background: var(--shop-primary-hover);
  color: white;
  text-decoration: none;
  transform: scale(1.03);
}
.hp-card-overlay-btn.ghost {
  background: rgba(255,255,255,0.15);
  color: white;
  border: 1px solid rgba(255,255,255,0.3);
}
.hp-card-overlay-btn.ghost:hover {
  background: rgba(255,255,255,0.25);
  color: white;
  text-decoration: none;
}

.hp-card-body { padding: 1rem 1.125rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
.hp-card-brand { font-size: 0.6875rem; font-weight: 600; color: var(--shop-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem; }
.hp-card-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--shop-text-primary);
  line-height: 1.45;
  margin-bottom: 0.75rem;
  flex: 1;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
.hp-card-name a { color: inherit; text-decoration: none; }
.hp-card-name a:hover { color: var(--shop-primary); }

.hp-card-footer { margin-top: auto; }
.hp-price-row { display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 0.875rem; flex-wrap: wrap; }
.hp-price-main { font-size: 1.1875rem; font-weight: 800; color: var(--shop-primary); }
.hp-price-old  { font-size: 0.8125rem; color: var(--shop-text-disabled); text-decoration: line-through; }
.hp-price-saving { font-size: 0.7rem; font-weight: 700; background: var(--shop-accent); color: white; padding: 0.125rem 0.5rem; border-radius: 9999px; }

.hp-card-btn-row { display: flex; gap: 0.5rem; }
.hp-btn-cart {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
  padding: 0.625rem 0.75rem;
  border-radius: 0.625rem;
  background: var(--shop-primary);
  color: white;
  font-size: 0.8125rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: all 200ms ease;
  font-family: inherit;
}
.hp-btn-cart:hover { background: var(--shop-primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(90,49,244,0.3); }
.hp-btn-cart:active { transform: scale(0.97); }
.hp-btn-cart:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }

.hp-btn-detail {
  width: 38px; height: 38px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.625rem;
  border: 1.5px solid var(--shop-border);
  color: var(--shop-text-secondary);
  text-decoration: none;
  transition: all 200ms ease;
}
.hp-btn-detail:hover { border-color: var(--shop-primary); color: var(--shop-primary); text-decoration: none; }

/* Badge absolute */
.hp-badge-abs {
  position: absolute;
  top: 0.75rem;
  z-index: 2;
}
.hp-badge-abs.left  { left: 0.75rem; }
.hp-badge-abs.right { right: 0.75rem; }
.hp-badge {
  display: inline-flex;
  align-items: center;
  padding: 0.2rem 0.625rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}
.hp-badge-promo { background: var(--shop-accent); color: white; }
.hp-badge-new   { background: var(--shop-primary); color: white; }
.hp-badge-stock-ok   { background: color-mix(in srgb, #10B981 12%, transparent); color: #10B981; }
.hp-badge-stock-no   { background: color-mix(in srgb, #6b6b6b 12%, transparent); color: #6b6b6b; }

/* ── Product Grids — per numColBloc value (Bootstrap col-lg-X mapping) ── */

/* num_cols = 2 → col-lg-2 → 6 per row desktop, 3 mobile */
.hp-grid-2 {
  display: grid;
  gap: 0.75rem;
  grid-template-columns: repeat(3, 1fr); /* mobile */
}
@media (min-width: 640px)  { .hp-grid-2 { grid-template-columns: repeat(4, 1fr); gap: 1rem; } }
@media (min-width: 1024px) { .hp-grid-2 { grid-template-columns: repeat(6, 1fr); gap: 1rem; } }

/* num_cols = 3 → col-lg-3 → 4 per row desktop, 2 mobile */
.hp-grid-3 {
  display: grid;
  gap: 0.875rem;
  grid-template-columns: repeat(2, 1fr); /* mobile */
}
@media (min-width: 640px)  { .hp-grid-3 { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1024px) { .hp-grid-3 { grid-template-columns: repeat(4, 1fr); gap: 1.25rem; } }

/* num_cols = 4 → col-lg-4 → 4 per row desktop, 3 mobile */
.hp-grid-4 {
  display: grid;
  gap: 0.75rem;
  grid-template-columns: repeat(3, 1fr); /* mobile */
}
@media (min-width: 640px)  { .hp-grid-4 { grid-template-columns: repeat(3, 1fr); gap: 1rem; } }
@media (min-width: 1024px) { .hp-grid-4 { grid-template-columns: repeat(4, 1fr); gap: 1.25rem; } }

/* num_cols = 5 → col-lg-5 (5 per row) → 3 mobile */
.hp-grid-5 {
  display: grid;
  gap: 0.75rem;
  grid-template-columns: repeat(3, 1fr); /* mobile */
}
@media (min-width: 640px)  { .hp-grid-5 { grid-template-columns: repeat(4, 1fr); gap: 1rem; } }
@media (min-width: 1024px) { .hp-grid-5 { grid-template-columns: repeat(5, 1fr); gap: 1rem; } }
@media (min-width: 1280px) { .hp-grid-5 { grid-template-columns: repeat(6, 1fr); } }

/* num_cols = 6 → col-lg-6 → 2 per row desktop, 1 mobile */
.hp-grid-6 {
  display: grid;
  gap: 1rem;
  grid-template-columns: 1fr;
}
@media (min-width: 640px)  { .hp-grid-6 { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .hp-grid-6 { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; } }

/* Fallback */
.hp-grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat(2, 1fr);
}
@media (min-width: 640px)  { .hp-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1024px) { .hp-grid { grid-template-columns: repeat(4, 1fr); gap: 1.25rem; } }

/* ── Trust bar ── */
.hp-trust {
  background: var(--shop-surface);
  border-top:    1px solid var(--shop-border);
  border-bottom: 1px solid var(--shop-border);
  padding: 1.25rem 0;
}
.hp-trust-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
@media (min-width: 640px)  { .hp-trust-grid { grid-template-columns: repeat(4, 1fr); } }
.hp-trust-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  transition: background 200ms ease;
}
.hp-trust-item:hover { background: color-mix(in srgb, var(--shop-primary) 5%, transparent); }
.hp-trust-icon {
  width: 42px; height: 42px;
  border-radius: 0.75rem;
  background: color-mix(in srgb, var(--shop-primary) 10%, transparent);
  color: var(--shop-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.hp-trust-label { font-size: 0.875rem; font-weight: 700; color: var(--shop-text-primary); }
.hp-trust-sub   { font-size: 0.75rem;  color: var(--shop-text-secondary); margin-top: 1px; }

/* ── Category cards ── */
.hp-categ-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0.875rem;
}
@media (min-width: 640px)  { .hp-categ-grid { grid-template-columns: repeat(4, 1fr); } }
@media (min-width: 1024px) { .hp-categ-grid { grid-template-columns: repeat(7, 1fr); } }

.hp-categ-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.625rem;
  padding: 1.25rem 0.5rem 1rem;
  border-radius: 1rem;
  background: var(--shop-surface);
  border: 1px solid var(--shop-border);
  text-decoration: none;
  color: var(--shop-text-primary);
  transition: all 250ms ease;
  text-align: center;
}
.hp-categ-card:hover {
  border-color: var(--shop-primary);
  background: color-mix(in srgb, var(--shop-primary) 5%, var(--shop-surface));
  transform: translateY(-3px);
  box-shadow: var(--shop-shadow-card);
  color: var(--shop-primary);
  text-decoration: none;
}
.hp-categ-icon {
  width: 56px; height: 56px;
  border-radius: 1rem;
  background: color-mix(in srgb, var(--shop-primary) 10%, transparent);
  display: flex; align-items: center; justify-content: center;
  color: var(--shop-primary);
  font-size: 1.75rem;
  transition: background 250ms ease;
}
.hp-categ-card:hover .hp-categ-icon {
  background: color-mix(in srgb, var(--shop-primary) 18%, transparent);
}
.hp-categ-name {
  font-size: 0.7875rem;
  font-weight: 600;
  line-height: 1.3;
}

/* ── Promo Banner ── */
.hp-promo-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}
@media (min-width: 768px) { .hp-promo-grid { grid-template-columns: 1fr 1fr; } }

.hp-promo-card {
  border-radius: 1.5rem;
  overflow: hidden;
  position: relative;
  min-height: 180px;
  display: flex;
  align-items: stretch;
  text-decoration: none;
  transition: transform 300ms ease, box-shadow 300ms ease;
}
.hp-promo-card:hover {
  transform: scale(1.015);
  box-shadow: var(--shop-shadow-soft-lg, 0 8px 40px rgba(18,11,46,0.12));
}
.hp-promo-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}
.hp-promo-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(13,11,26,0.6) 0%, rgba(13,11,26,0.1) 65%, transparent 100%);
  display: flex;
  align-items: center;
  padding: 2rem;
}
.hp-promo-badge { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 0.375rem; }
.hp-promo-title { font-size: clamp(1.125rem, 1rem + 1vw, 1.5rem); font-weight: 800; color: white; line-height: 1.25; margin-bottom: 0.5rem; letter-spacing: -0.015em; }
.hp-promo-cta { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 1.125rem; background: white; color: var(--shop-primary); border-radius: 0.625rem; font-size: 0.8125rem; font-weight: 700; transition: all 200ms ease; }
.hp-promo-card:hover .hp-promo-cta { background: var(--shop-primary); color: white; }

/* ── Horizontal product scroller (Equipements) ── */
.hp-scroller {
  display: flex;
  gap: 1rem;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 0.5rem;
  scrollbar-width: none;
}
.hp-scroller::-webkit-scrollbar { display: none; }
.hp-scroller-item {
  scroll-snap-align: start;
  flex-shrink: 0;
  width: clamp(180px, 22vw, 240px);
}

/* ── Divider ── */
.hp-divider {
  height: 1px;
  background: linear-gradient(to right, transparent, var(--shop-border), transparent);
  margin: 0;
}

/* ── Section alt bg (dark-tint) ── */
.hp-section-alt { background: var(--shop-bg-alt); }

/* ── Flash sale countdown look ── */
.hp-flash-header {
  display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
  margin-bottom: 2rem;
}
.hp-flash-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.875rem;
  background: var(--shop-accent);
  color: white;
  border-radius: 0.5rem;
  font-size: 0.8125rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  animation: glow-pulse 2s ease-in-out infinite;
}

/* ── Announce ticker ── */
.hp-ticker {
  background: var(--shop-primary);
  color: white;
  padding: 0.625rem 0;
  overflow: hidden;
  font-size: 0.875rem;
  font-weight: 500;
  letter-spacing: 0.01em;
}
.hp-ticker-inner {
  display: flex;
  width: max-content;
  animation: ticker-scroll 30s linear infinite;
}
.hp-ticker-inner:hover { animation-play-state: paused; }
.hp-ticker-item { padding: 0 3rem; white-space: nowrap; }
.hp-ticker-sep { opacity: 0.5; }
@keyframes ticker-scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>

<div class="hp-body">

  <!-- ════════════════════════════════════════════════
       TICKER ANNOUNCEMENT BAR
       ════════════════════════════════════════════════ -->
  <div class="hp-ticker" aria-hidden="true">
    <div class="hp-ticker-inner">
      <?php
      // Repeat content twice for seamless loop
      for ($t = 0; $t < 2; $t++): ?>
        <span class="hp-ticker-item">🔥 Offres Flash du Jour</span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
        <span class="hp-ticker-item">📦 Livraison offerte dès 100 DT</span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
        <span class="hp-ticker-item">🛡️ Garantie constructeur 12 mois</span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
        <span class="hp-ticker-item">💳 Paiement sécurisé</span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
        <span class="hp-ticker-item">🔄 Retour sous 30 jours</span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
        <span class="hp-ticker-item">📞 Support <?php echo $gsm ?? ''; ?></span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ════════════════════════════════════════════════
       TRUST BARS (Livraison, Garantie, Retour, Paiement)
       ════════════════════════════════════════════════ -->
  <div class="hp-trust">
    <div class="hp-container">
      <div class="hp-trust-grid">
        <div class="hp-trust-item">
          <div class="hp-trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h6l2 5v3h-8V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
          </div>
          <div>
            <div class="hp-trust-label">Livraison rapide</div>
            <div class="hp-trust-sub">Offerte dès 100 DT</div>
          </div>
        </div>
        <div class="hp-trust-item">
          <div class="hp-trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div>
            <div class="hp-trust-label">Garantie officielle</div>
            <div class="hp-trust-sub">12 mois constructeur</div>
          </div>
        </div>
        <div class="hp-trust-item">
          <div class="hp-trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
          </div>
          <div>
            <div class="hp-trust-label">Retour facile</div>
            <div class="hp-trust-sub">30 jours sans frais</div>
          </div>
        </div>
        <div class="hp-trust-item">
          <div class="hp-trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <div>
            <div class="hp-trust-label">Paiement sécurisé</div>
            <div class="hp-trust-sub">SSL 256-bit</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ════════════════════════════════════════════════
       CATEGORIES RAPIDES
       ════════════════════════════════════════════════ -->
  <?php
  $req_cats = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent`='0' ORDER BY `ordre` LIMIT 14";
  $res_cats = executeRequete($req_cats);
  $cats_list = [];
  while ($c = mysqli_fetch_array($res_cats)) $cats_list[] = $c;

  // Category icons mapping by keyword
  $catIconMap = [
    'television' => '📺', 'tv' => '📺', 'téléviseur' => '📺',
    'smartphone' => '📱', 'telephone' => '📱', 'téléphonie' => '📱', 'mobile' => '📱',
    'pc' => '💻', 'ordinateur' => '💻', 'laptop' => '💻', 'informatique' => '💻',
    'tablette' => '📟', 'tablet' => '📟',
    'accessoire' => '🎧', 'audio' => '🎧',
    'montre' => '⌚', 'watch' => '⌚', 'smartwatch' => '⌚',
    'camera' => '📷', 'photo' => '📷',
    'gaming' => '🎮', 'jeux' => '🎮', 'gamer' => '🎮',
    'récepteur' => '📡', 'parabole' => '📡', 'sat' => '📡',
    'abonnement' => '🔔', 'iptv' => '🔔', 'vod' => '🎬',
    'composant' => '⚙️', 'processeur' => '⚙️',
    'imprimante' => '🖨️',
    'drone' => '✈️',
    'default' => '🔌',
  ];

  function getCategIcon($titre, $map) {
    $t = strtolower($titre);
    foreach ($map as $kw => $icon) {
      if ($kw !== 'default' && strpos($t, $kw) !== false) return $icon;
    }
    return $map['default'];
  }
  ?>

  <?php if (!empty($cats_list)): ?>
  <div class="hp-section" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="hp-container">
      <div class="hp-categ-grid">
        <?php foreach ($cats_list as $cat): ?>
          <a href="<?php echo lienCategories($cat['link']); ?>" class="hp-categ-card">
            <div class="hp-categ-icon"><?php echo getCategIcon($cat['titre'], $catIconMap); ?></div>
            <span class="hp-categ-name"><?php echo htmlspecialchars($cat['titre']); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="hp-divider"></div>
  <?php endif; ?>


  <!-- ════════════════════════════════════════════════
       PRODUCT BLOCS (depuis bloc_accueil DB)
       ════════════════════════════════════════════════ -->
  <?php
  $req_blocs = "SELECT * FROM `bloc_accueil` WHERE `etat` = '1' AND `affichage_accueil`='1' ORDER BY `ordre`";
  $res_blocs = executeRequete($req_blocs);
  $bloc_idx  = 0;

  while ($bloc = mysqli_fetch_array($res_blocs)):
    $bloc_id   = $bloc['id'];
    $type_bloc = typeSectionBloc($bloc_id);
    $num_cols  = intval(numColBloc($bloc_id));
    $is_promo  = false;

    // Section alt background on even blocs
    $section_class = ($bloc_idx % 2 === 1) ? 'hp-section hp-section-alt' : 'hp-section';
    $bloc_idx++;
  ?>

  <?php if ($type_bloc == '4'): // ── Produits (promo ou normal) ──
    // Detect promo
    $en_promo = "SELECT en_promo FROM `liste_produits` WHERE idbloc='$bloc_id' LIMIT 1";
    $r_p = executeRequete($en_promo);
    $d_p = mysqli_fetch_array($r_p);
    $is_promo = ($d_p && $d_p['en_promo'] == '1');

    // numColBloc() = direct columns per row (e.g. 6 = 6 per row, 4 = 4 per row)
    // Limit = 2 rows of products (matching original bloc_accueil.php logic)
    $limit_map = [2=>4, 3=>6, 4=>8, 5=>10, 6=>12];
    $limit = $limit_map[$num_cols] ?? ($num_cols * 2);

    if ($is_promo) {
      $req_products = "SELECT DISTINCT pr.id, pr.link FROM `produits` pr, `liste_produits` lpr
        WHERE lpr.idbloc='$bloc_id' AND pr.etat='1'
        AND (pr.prix_promo != '0.000' AND lpr.en_promo='1')
        AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
        AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = '')
        ORDER BY pr.prix_vente ASC LIMIT 0,$limit";
    } else {
      $req_products = "SELECT DISTINCT pr.id, pr.link FROM `produits` pr, `liste_produits` lpr
        WHERE lpr.idbloc='$bloc_id' AND pr.etat='1'
        AND (pr.prix_promo = '0.000' AND lpr.en_promo='0')
        AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
        AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = '')
        ORDER BY pr.id DESC, pr.prix_vente ASC LIMIT 0,$limit";
    }
    $res_products = executeRequete($req_products);
    $num_products = mysqli_num_rows($res_products);
  ?>
  <?php if ($num_products > 0): ?>
  <div class="<?php echo $section_class; ?>">
    <div class="hp-container">
      <!-- Section header -->
      <div class="hp-section-header">
        <div>
          <?php if ($is_promo): ?>
            <div class="hp-flash-badge" style="display:inline-flex; margin-bottom:0.625rem;">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
              Offres Flash
            </div>
          <?php endif; ?>
          <?php if (affichageTitreBloc($bloc_id) == '1'): ?>
            <h2 class="hp-section-title"><?php echo titreBloc($bloc_id); ?></h2>
          <?php endif; ?>
        </div>
        <a href="<?php echo lienCategorie(); ?>" class="hp-see-all">
          Voir tout
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <!-- Product grid — numColBloc = DIRECT columns per row (admin-controlled) -->
      <?php
        // numColBloc() = number of cols per row set in admin (directly)
        $cols_desktop = max(1, $num_cols); // e.g. 6 → 6 cols desktop
        $cols_tablet  = max(2, (int)ceil($cols_desktop / 2)); // half on tablet, min 2
        $cols_mobile  = min(3, max(2, (int)ceil($cols_desktop / 3))); // ~1/3 on mobile, between 2-3
        $grid_id      = 'grid-bloc-' . $bloc_id;
        $grid_style   = "display:grid; gap:0.75rem; grid-template-columns:repeat({$cols_mobile},1fr);";
      ?>
      <style>
        @media (min-width: 640px)  { #<?php echo $grid_id; ?> { grid-template-columns: repeat(<?php echo $cols_tablet; ?>, 1fr) !important; gap: 0.875rem !important; } }
        @media (min-width: 1024px) { #<?php echo $grid_id; ?> { grid-template-columns: repeat(<?php echo $cols_desktop; ?>, 1fr) !important; gap: 1rem !important; } }
      </style>
      <div id="<?php echo $grid_id; ?>" style="<?php echo $grid_style; ?>">
        <?php while ($prod = mysqli_fetch_array($res_products)):
          $pid   = $prod['id'];
          $plink = $prod['link'];
          $prix_vente = prixVenteProduits($pid);
          $prix_promo = prixPromoProduits($pid);
          $in_stock   = (etatStockProduits($pid) == '1');

          // Compute discount %
          $discount = 0;
          if ($prix_promo && $prix_promo != '0.000' && $prix_vente) {
            $discount = round((($prix_vente - $prix_promo) / $prix_vente) * 100);
          }
        ?>
        <article class="hp-card">

          <!-- Badges -->
          <?php if ($discount > 0): ?>
            <div class="hp-badge-abs left"><span class="hp-badge hp-badge-promo">-<?php echo $discount; ?>%</span></div>
          <?php elseif (strtotime($prod['datecrea'] ?? '') > strtotime('-30 days')): ?>
            <div class="hp-badge-abs left"><span class="hp-badge hp-badge-new">Nouveau</span></div>
          <?php endif; ?>

          <!-- Image + Quick view overlay -->
          <div class="hp-card-img-wrap">
            <a href="<?php echo lienProduits($plink); ?>" tabindex="-1">
              <img src="<?php echo photoProduitsSite($pid); ?>" alt="<?php echo htmlspecialchars(titreProduits($pid)); ?>" loading="lazy">
            </a>
            <div class="hp-card-overlay">
              <?php if ($in_stock): ?>
                <button class="hp-card-overlay-btn primary" onclick="addToCart(<?php echo intval($pid); ?>, '1')">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                  Panier
                </button>
              <?php endif; ?>
              <a href="<?php echo lienProduits($plink); ?>" class="hp-card-overlay-btn ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Voir
              </a>
            </div>
          </div>

          <!-- Card body -->
          <div class="hp-card-body">
            <!-- Brand -->
            <?php if (marquesProduits($pid) != '0' && ApercuMarque(marquesProduits($pid)) != ''): ?>
              <div class="hp-card-brand">
                <img src="<?php echo photoMarqueSite(marquesProduits($pid)); ?>" alt="" style="max-height:18px; max-width:70px; object-fit:contain; vertical-align:middle;">
              </div>
            <?php endif; ?>

            <!-- Name -->
            <div class="hp-card-name">
              <a href="<?php echo lienProduits($plink); ?>"><?php echo titreProduits($pid); ?></a>
            </div>

            <!-- Price + actions -->
            <div class="hp-card-footer">
              <div class="hp-price-row">
                <?php if ($prix_promo && $prix_promo != '0.000'): ?>
                  <span class="hp-price-main"><?php echo $prix_promo; ?> DT</span>
                  <span class="hp-price-old"><?php echo $prix_vente; ?> DT</span>
                  <?php if ($discount > 0): ?>
                    <span class="hp-price-saving">-<?php echo $discount; ?>%</span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="hp-price-main"><?php echo $prix_vente; ?> DT</span>
                <?php endif; ?>
              </div>

              <div class="hp-card-btn-row">
                <button
                  class="hp-btn-cart"
                  onclick="addToCart(<?php echo intval($pid); ?>, '1')"
                  <?php echo (!$in_stock ? 'disabled' : ''); ?>
                  title="<?php echo ($in_stock ? 'Ajouter au panier' : 'Rupture de stock'); ?>"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                  <?php echo ($in_stock ? 'Ajouter' : 'Rupture'); ?>
                </button>
                <a href="<?php echo lienProduits($plink); ?>" class="hp-btn-detail" title="Voir le produit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
              </div>
            </div>
          </div>
        </article>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  <div class="hp-divider"></div>
  <?php endif; ?>

  <?php elseif ($type_bloc == '6'): // ── Promo image banners ──
    $req_bnr = "SELECT * FROM `liste_section_content` WHERE idbloc='$bloc_id'";
    $res_bnr = executeRequete($req_bnr);
    $bnrs    = [];
    while ($b = mysqli_fetch_array($res_bnr)) $bnrs[] = $b;
    $main_img = photoBlocSite($bloc_id);
  ?>
  <?php if (!empty($bnrs) || $main_img): ?>
  <div class="<?php echo $section_class; ?>">
    <div class="hp-container">
      <?php if (affichageTitreBloc($bloc_id) == '1'): ?>
        <div class="hp-section-header">
          <h2 class="hp-section-title"><?php echo titreBloc($bloc_id); ?></h2>
        </div>
      <?php endif; ?>

      <?php
        // numColBloc() = direct columns per row (same logic as type 4)
        $bnr_cols_desktop = max(1, $num_cols);
        $bnr_cols_tablet  = max(2, (int)ceil($bnr_cols_desktop / 2));
        $bnr_cols_mobile  = min(2, max(1, (int)ceil($bnr_cols_desktop / 3)));
        $bnr_grid_id      = 'bnr-bloc-' . $bloc_id;
        $bnr_style        = "display:grid; gap:0.875rem; grid-template-columns:repeat({$bnr_cols_mobile},1fr);";
      ?>
      <style>
        @media (min-width: 640px)  { #<?php echo $bnr_grid_id; ?> { grid-template-columns: repeat(<?php echo $bnr_cols_tablet; ?>, 1fr) !important; } }
        @media (min-width: 1024px) { #<?php echo $bnr_grid_id; ?> { grid-template-columns: repeat(<?php echo $bnr_cols_desktop; ?>, 1fr) !important; gap: 1rem !important; } }
      </style>
      <div id="<?php echo $bnr_grid_id; ?>" style="<?php echo $bnr_style; ?>">
        <!-- Optional main bloc image -->
        <?php if ($main_img && ApercuBloc($bloc_id)): ?>
          <a href="<?php echo lienBloc($bloc_id); ?>" class="hp-promo-card">
            <img src="<?php echo $main_img; ?>" alt="" loading="lazy">
            <div class="hp-promo-card-overlay">
              <div>
                <div class="hp-promo-title">Voir la sélection</div>
                <span class="hp-promo-cta">Découvrir →</span>
              </div>
            </div>
          </a>
        <?php endif; ?>

        <!-- Sub banners -->
        <?php foreach ($bnrs as $bnr): ?>
          <a href="<?php echo lienSectionContent($bnr['id']); ?>" class="hp-promo-card">
            <img src="<?php echo photoSectionContent($bnr['id']); ?>" alt="" loading="lazy">
            <div class="hp-promo-card-overlay">
              <div>
                <div class="hp-promo-cta">Voir l'offre →</div>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="hp-divider"></div>
  <?php endif; ?>

  <?php elseif ($type_bloc == '1'): // ── Section carousel (inner) ──
    $req_sc = "SELECT * FROM `liste_section_content` WHERE idbloc='$bloc_id'";
    $res_sc = executeRequete($req_sc);
    $sc_items = []; $sc_i = 0;
    while ($sc = mysqli_fetch_array($res_sc)) $sc_items[] = $sc;
  ?>
  <?php if (!empty($sc_items)): ?>
  <div class="<?php echo $section_class; ?>">
    <div class="hp-container">
      <?php if (affichageTitreBloc($bloc_id) == '1'): ?>
        <div class="hp-section-header">
          <h2 class="hp-section-title"><?php echo titreBloc($bloc_id); ?></h2>
        </div>
      <?php endif; ?>
      <!-- Reuse the hero carousel layout for section carousel -->
      <div style="position:relative; overflow:hidden; border-radius:1.5rem; background:var(--shop-bg-alt);">
        <div id="sc-track-<?php echo $bloc_id; ?>" style="display:flex; transition:transform 600ms cubic-bezier(0.77,0,0.175,1);">
          <?php foreach ($sc_items as $sci): ?>
            <a href="<?php echo lienSectionContent($sci['id']); ?>" style="min-width:100%; display:block; flex-shrink:0;">
              <img src="<?php echo photoSectionContent($sci['id']); ?>" alt="" loading="lazy" style="width:100%; max-height:420px; object-fit:cover; border-radius:1.5rem;">
            </a>
          <?php endforeach; ?>
        </div>
        <?php if (count($sc_items) > 1): ?>
          <button onclick="scGo('<?php echo $bloc_id; ?>', -1)" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); z-index:5; width:42px; height:42px; border-radius:50%; background:rgba(0,0,0,0.4); border:none; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(8px);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
          </button>
          <button onclick="scGo('<?php echo $bloc_id; ?>', 1)" style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); z-index:5; width:42px; height:42px; border-radius:50%; background:rgba(0,0,0,0.4); border:none; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(8px);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="hp-divider"></div>
  <?php endif; ?>

  <?php endif; // end type checks
  endwhile; // end blocs loop
  ?>

  <!-- ════════════════════════════════════════════════
       ÉQUIPEMENTS — Horizontal Scroller
       ════════════════════════════════════════════════ -->
  <?php if (affichageAccueilBloc(7) == '1'):
    $req_eq = "SELECT * FROM `produits` WHERE `type`='E' AND `etat`='1' ORDER BY `id` ASC LIMIT 10";
    $res_eq = executeRequete($req_eq);
    $eq_count = mysqli_num_rows($res_eq);
    if ($eq_count > 0):
  ?>
  <div class="hp-section hp-section-alt">
    <div class="hp-container">
      <div class="hp-section-header">
        <h2 class="hp-section-title"><?php echo (affichageTitreBloc(7) == '1') ? titreBloc(7) : 'Nos Équipements'; ?></h2>
        <a href="<?php echo lienCategorie(); ?>" class="hp-see-all">
          Tous les produits
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      <div class="hp-scroller">
        <?php while ($eq = mysqli_fetch_array($res_eq)): ?>
          <div class="hp-scroller-item">
            <article class="hp-card">
              <div class="hp-card-img-wrap">
                <a href="<?php echo lienProduits($eq['link']); ?>">
                  <img src="<?php echo photoProduitsSite($eq['id']); ?>" alt="<?php echo htmlspecialchars(titreProduits($eq['id'])); ?>" loading="lazy">
                </a>
              </div>
              <div class="hp-card-body">
                <div class="hp-card-name" style="-webkit-line-clamp:2;">
                  <a href="<?php echo lienProduits($eq['link']); ?>"><?php echo titreProduits($eq['id']); ?></a>
                </div>
                <div class="hp-card-footer">
                  <div class="hp-price-row">
                    <?php if (prixPromoProduits($eq['id']) != '0.000'): ?>
                      <span class="hp-price-main"><?php echo prixPromoProduits($eq['id']); ?> DT</span>
                      <span class="hp-price-old"><?php echo prixVenteProduits($eq['id']); ?> DT</span>
                    <?php else: ?>
                      <span class="hp-price-main"><?php echo prixVenteProduits($eq['id']); ?> DT</span>
                    <?php endif; ?>
                  </div>
                  <?php $ancre = ancreProduits($eq['id']) ?: 'Commander'; ?>
                  <button class="hp-btn-cart" onclick="addToCart1(<?php echo $eq['id']; ?>, '1')" style="width:100%; font-size:0.8rem;">
                    <?php echo htmlspecialchars($ancre); ?>
                  </button>
                </div>
              </div>
            </article>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  <div class="hp-divider"></div>
  <?php endif; endif; ?>

</div><!-- hp-body -->

<!-- Section Carousel JS helper -->
<script>
(function() {
  var tracks = {};
  var cursors = {};
  window.scGo = function(id, dir) {
    if (!tracks[id]) {
      tracks[id] = document.getElementById('sc-track-' + id);
      cursors[id] = 0;
    }
    var total = tracks[id].children.length;
    cursors[id] = ((cursors[id] + dir) % total + total) % total;
    tracks[id].style.transform = 'translateX(-' + (cursors[id] * 100) + '%)';
  };
})();
</script>
