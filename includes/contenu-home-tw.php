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

/* Styles globaux déplacés vers dist/css/shop-cards.css */


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
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.875rem;
}
.hp-categ-card {
    flex: 0 0 calc(33.333% - 0.875rem);
    min-width: 100px;
}
@media (min-width: 640px) {
    .hp-categ-card { flex: 0 0 calc(25% - 0.875rem); }
}
@media (min-width: 1024px) {
    .hp-categ-card { flex: 0 0 calc(14.28% - 0.875rem); }
}

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
.hp-promo-ribbon {
  position: absolute;
  top: 1.5rem;
  left: 0;
  background: var(--shop-primary);
  color: white;
  padding: 0.5rem 1rem;
  font-size: clamp(0.875rem, 0.8rem + 0.4vw, 1rem); /* Reduced font size */
  font-weight: 700;
  letter-spacing: 0;
  border-top-right-radius: 9999px;
  border-bottom-right-radius: 9999px;
  box-shadow: 0 4px 15px rgba(90,49,244,0.4);
  z-index: 10;
  max-width: 85%;
  line-height: 1.2;
  transform: translateX(-100%);
  opacity: 0;
  transition: transform 600ms cubic-bezier(0.16, 1, 0.3, 1), opacity 600ms ease;
  white-space: nowrap;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.hp-promo-ribbon-text {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  transition: opacity 300ms ease, max-width 400ms ease;
}
.hp-promo-ribbon-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: transform 300ms ease, opacity 300ms ease, width 300ms ease, margin 300ms ease;
  flex-shrink: 0;
}
.hp-promo-card.reveal-active .hp-promo-ribbon {
  /* Show only the icon part initially (calc based on padding + icon width) */
  transform: translateX(calc(-100% + 44px));
  opacity: 1;
}
.hp-promo-card.reveal-active:not(:hover):not(.hover-active) .hp-promo-ribbon-text {
  opacity: 0;
  max-width: 0;
  padding-left: 0 !important;
}
.hp-promo-card.reveal-active:hover .hp-promo-ribbon,
.hp-promo-card.reveal-active.hover-active .hp-promo-ribbon {
  /* Slide out fully on hover or active mobile tap */
  transform: translateX(0);
}
.hp-promo-card.reveal-active:hover .hp-promo-ribbon-text,
.hp-promo-card.reveal-active.hover-active .hp-promo-ribbon-text {
  opacity: 1;
  max-width: 100vw; /* Allow it to naturally expand up to the container's max-width constraints */
}
.hp-promo-card.reveal-active:hover .hp-promo-ribbon-icon,
.hp-promo-card.reveal-active.hover-active .hp-promo-ribbon-icon {
    /* Hide the icon when fully opened */
    transform: rotate(180deg) scale(0);
    width: 0;
    margin: 0;
    opacity: 0;
}

.hp-promo-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(13,11,26,0.6) 0%, transparent 60%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: center;
  padding: 1.5rem;
  opacity: 0;
  transition: opacity 300ms ease;
  z-index: 5;
}
.hp-promo-card:hover .hp-promo-card-overlay,
.hp-promo-card.hover-active .hp-promo-card-overlay {
  opacity: 1;
}
.hp-promo-badge { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 0.375rem; }
.hp-promo-title { 
    font-size: clamp(1.125rem, 1rem + 1vw, 1.5rem); 
    font-weight: 800; 
    color: white; 
    line-height: 1.25; 
    margin-bottom: 0.75rem; 
    letter-spacing: -0.015em; 
}
.hp-promo-cta { 
  display: inline-flex; 
  align-items: center; 
  gap: 0.375rem; 
  padding: 0.625rem 1.5rem; 
  background: white; 
  color: var(--shop-primary); 
  border-radius: 9999px;
  font-size: 0.875rem; 
  font-weight: 800; 
  transition: all 400ms cubic-bezier(0.16, 1, 0.3, 1); 
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
  transform: translateY(20px);
  width: fit-content;
}
.hp-promo-cta svg {
    transition: transform 250ms ease;
}
.hp-promo-card:hover .hp-promo-cta,
.hp-promo-card.hover-active .hp-promo-cta { 
  transform: translateY(0);
}
.hp-promo-card .hp-promo-cta:hover { 
  background: var(--shop-primary); 
  color: white; 
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(90,49,244,0.4);
}
.hp-promo-card .hp-promo-cta:hover svg {
    transform: translateX(4px);
}

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
  .hp-ticker-item a { color: inherit; text-decoration: none; }
  .hp-ticker-item a:hover { text-decoration: underline; }
</style>

<div class="hp-body">

  <!-- ════════════════════════════════════════════════
       TICKER ANNOUNCEMENT BAR
       ════════════════════════════════════════════════ -->
  <div class="hp-ticker" aria-hidden="true">
    <div class="hp-ticker-inner">
      <?php
      $req_ticker_p = executeRequete("SELECT b.id FROM bloc_accueil b JOIN liste_sections s ON b.type_section = s.id WHERE s.titre = 'Texte Ticker' AND b.etat = 1 ORDER BY b.ordre LIMIT 1");
      $tickers = [];
            if ($req_ticker_p && $row_parent = mysqli_fetch_assoc($req_ticker_p)) {
          $req_items = executeRequete("SELECT titre, icone, lien FROM liste_section_content WHERE idbloc = " . $row_parent['id']);
          while($row_item = mysqli_fetch_assoc($req_items)) {
              $str = '';
              if(!empty($row_item['icone'])) {
                  $str .= '<i class="' . htmlspecialchars($row_item['icone']) . '" style="margin-right: 6px;"></i> ';
              }
              $str .= htmlspecialchars($row_item['titre']);
              $tickers[] = [
                  'html' => $str,
                  'link' => !empty($row_item['lien']) ? $row_item['lien'] : ''
              ];
          }
      }
      if(empty($tickers)) {
          $default_titles = [
              "🔥 Offres Flash du Jour",
              "📦 Livraison offerte dès 100 DT",
              "🛡️ Garantie constructeur 12 mois",
              "💳 Paiement sécurisé",
              "🔄 Retour sous 30 jours",
              "📞 Support " . ($gsm ?? '')
          ];
          foreach($default_titles as $dt) {
              $tickers[] = ['html' => $dt, 'link' => ''];
          }
      }
      // Repeat content twice for seamless loop
      for ($t = 0; $t < 2; $t++): 
        foreach($tickers as $ticker):
      ?>
        <span class="hp-ticker-item">
            <?php if(!empty($ticker['link'])): ?>
                <a href="<?php echo htmlspecialchars($ticker['link']); ?>"><?php echo $ticker['html']; ?></a>
            <?php else: ?>
                <?php echo $ticker['html']; ?>
            <?php endif; ?>
        </span>
        <span class="hp-ticker-item hp-ticker-sep">·</span>
      <?php 
        endforeach;
      endfor; 
      ?>
    </div>
  </div>

  <?php if(basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == ''): ?>

  <!-- ── BANDEAU DE CONFIANCE (Trust) ── -->
  <div class="hp-trust">
    <div class="hp-container">
      <div class="hp-trust-grid">
        <?php
        $req_trust_p = executeRequete("SELECT b.id FROM bloc_accueil b JOIN liste_sections s ON b.type_section = s.id WHERE s.titre = 'Icônes Confiance (Trust)' AND b.etat = 1 ORDER BY b.ordre LIMIT 1");
        $has_trust_items = false;
        
        if($req_trust_p && $row_parent = mysqli_fetch_assoc($req_trust_p)) {
            $req_items = executeRequete("SELECT titre, contenu, icone FROM liste_section_content WHERE idbloc = " . $row_parent['id']);
            if ($req_items && mysqli_num_rows($req_items) > 0) {
                $has_trust_items = true;
                while($row_trust = mysqli_fetch_assoc($req_items)):
                    $icon_svg = '';
                    $icon_val = trim($row_trust['icone'] ?? '');
                    
                    // Si la valeur ressemble à une classe FontAwesome (ex: fa-solid fa-truck, fas fa-star)
                    if (strpos($icon_val, 'fa-') !== false || strpos($icon_val, 'fas ') !== false || strpos($icon_val, 'fab ') !== false || strpos($icon_val, 'far ') !== false || strpos($icon_val, 'fa ') !== false) {
                        $icon_svg = '<i class="' . htmlspecialchars($icon_val) . '" style="font-size:24px;"></i>';
                    } else {
                        switch($icon_val) {
                            case 'truck': $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h6l2 5v3h-8V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'; break;
                            case 'shield': $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'; break;
                            case 'refresh': $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>'; break;
                            case 'credit-card': $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>'; break;
                            case 'phone': $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>'; break;
                            default: $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'; break;
                        }
                    }
        ?>
          <div class="hp-trust-item">
            <div class="hp-trust-icon">
              <?php echo $icon_svg; ?>
            </div>
            <div>
              <div class="hp-trust-label"><?php echo htmlspecialchars($row_trust['titre']); ?></div>
              <div class="hp-trust-sub"><?php echo strip_tags($row_trust['contenu']); ?></div>
            </div>
          </div>
        <?php 
                endwhile;
            }
        } 
        
        if(!$has_trust_items) { 
        ?>
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
        <?php } ?>
      </div>
    </div>
  </div>

  <?php endif; ?>

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

    // Vérifier si la colonne idproduit existe (safe check)
    $has_idproduit = false;
    $chk = executeRequete("SHOW COLUMNS FROM liste_produits LIKE 'idproduit'");
    if($chk && mysqli_num_rows($chk) > 0) $has_idproduit = true;

    if ($is_promo) {
      if ($has_idproduit) {
        $req_products = "
          SELECT inner_q.id, inner_q.link, inner_q.prix_vente FROM (
            (SELECT pr.id, pr.link, pr.prix_vente, 1 AS is_manual
             FROM `produits` pr JOIN `liste_produits` lpr ON lpr.idproduit = pr.id
             WHERE lpr.idbloc='$bloc_id' AND pr.etat='1' AND lpr.idproduit > 0)
            UNION
            (SELECT pr.id, pr.link, pr.prix_vente, 0 AS is_manual
             FROM `produits` pr JOIN `liste_produits` lpr ON lpr.idbloc='$bloc_id'
             WHERE pr.etat='1' AND (lpr.idproduit IS NULL OR lpr.idproduit = 0)
             AND (pr.prix_promo != '0.000' AND lpr.en_promo='1')
             AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
             AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = ''))
          ) AS inner_q
          ORDER BY inner_q.is_manual DESC, inner_q.prix_vente ASC
          LIMIT 0,$limit
        ";
      } else {
        $req_products = "SELECT DISTINCT pr.id, pr.link FROM `produits` pr, `liste_produits` lpr
          WHERE lpr.idbloc='$bloc_id' AND pr.etat='1'
          AND (pr.prix_promo != '0.000' AND lpr.en_promo='1')
          AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
          AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = '')
          ORDER BY pr.prix_vente ASC LIMIT 0,$limit";
      }
    } else {
      if ($has_idproduit) {
        $req_products = "
          SELECT inner_q.id, inner_q.link, inner_q.prix_vente FROM (
            (SELECT pr.id, pr.link, pr.prix_vente, 1 AS is_manual
             FROM `produits` pr JOIN `liste_produits` lpr ON lpr.idproduit = pr.id
             WHERE lpr.idbloc='$bloc_id' AND pr.etat='1' AND lpr.idproduit > 0)
            UNION
            (SELECT pr.id, pr.link, pr.prix_vente, 0 AS is_manual
             FROM `produits` pr JOIN `liste_produits` lpr ON lpr.idbloc='$bloc_id'
             WHERE pr.etat='1' AND (lpr.idproduit IS NULL OR lpr.idproduit = 0)
             AND (pr.prix_promo = '0.000' AND lpr.en_promo='0')
             AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
             AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = ''))
          ) AS inner_q
          ORDER BY inner_q.is_manual DESC, inner_q.id DESC, inner_q.prix_vente ASC
          LIMIT 0,$limit
        ";
      } else {
        $req_products = "SELECT DISTINCT pr.id, pr.link FROM `produits` pr, `liste_produits` lpr
          WHERE lpr.idbloc='$bloc_id' AND pr.etat='1'
          AND (pr.prix_promo = '0.000' AND lpr.en_promo='0')
          AND (lpr.categorie = pr.categorie OR pr.idparent_categ = lpr.categorie)
          AND ((lpr.marque != '' AND pr.titre LIKE CONCAT('%', lpr.marque, '%')) OR lpr.marque = '')
          ORDER BY pr.id DESC, pr.prix_vente ASC LIMIT 0,$limit";
      }
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
          <?php if ($is_promo): 
             $badge_text = !empty($bloc['badge_titre']) ? htmlspecialchars($bloc['badge_titre']) : 'Offres Flash';
             $badge_icon = !empty($bloc['icone']) ? '<i class="'.htmlspecialchars($bloc['icone']).'"></i>' : '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>';
          ?>
            <div class="hp-flash-badge" style="display:inline-flex; align-items:center; margin-bottom:0.625rem;">
              <?php echo $badge_icon; ?>
              <span style="margin-left:0.375rem;"><?php echo $badge_text; ?></span>
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
          if ($prix_promo && $prix_promo != '0.000' && floatval($prix_vente) > 0) {
            $discount = round(((floatval($prix_vente) - floatval($prix_promo)) / floatval($prix_vente)) * 100);
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
              <button class="hp-card-overlay-btn compare-ol"
                data-compare-id="<?php echo intval($pid); ?>"
                onclick='compareToggle(<?php echo intval($pid); ?>, <?php echo htmlspecialchars(json_encode(titreProduits($pid)), ENT_QUOTES); ?>, <?php echo htmlspecialchars(json_encode(photoProduitsSite($pid)), ENT_QUOTES); ?>)'
                title="Comparer">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 0-2-2V9m0 0h18"/></svg>
                <span class="cmp-btn-txt">Comparer</span>
              </button>
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
                <?php if (hasVariationPrices($pid)): ?>
                  <span style="font-size:0.7rem; color:var(--shop-text-secondary,#6b7280); font-weight:400; display:block; margin-bottom:-2px;">À partir de</span>
                <?php endif; ?>
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
                <button class="hp-btn-compare-mobile compare-ol" 
                  data-compare-id="<?php echo intval($pid); ?>"
                  onclick='compareToggle(<?php echo intval($pid); ?>, <?php echo htmlspecialchars(json_encode(titreProduits($pid)), ENT_QUOTES); ?>, <?php echo htmlspecialchars(json_encode(photoProduitsSite($pid)), ENT_QUOTES); ?>)'
                  title="Comparer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 0-2-2V9m0 0h18"/></svg>
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
  <?php if (!empty($bnrs)): ?>
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

        <!-- Sub banners -->
        <?php foreach ($bnrs as $bnr):
          // Resolve image: priority 1 = uploaded file, priority 2 = lien_url
          $bnr_img = '';
          if (!empty($bnr['photo'])) {
            $bnr_img = 'media/site/' . $bnr['photo'];
          } elseif (!empty($bnr['lien_url'])) {
            $bnr_img = $bnr['lien_url'];
          }
          $bnr_titre = !empty($bnr['titre']) ? $bnr['titre'] : '';
          $bnr_lien  = !empty($bnr['lien']) ? $bnr['lien'] : '#';
          $bnr_btn   = !empty($bnr['titre_bouton']) ? $bnr['titre_bouton'] : 'Découvrir';
        ?>
          <a href="<?php echo htmlspecialchars($bnr_lien); ?>" class="hp-promo-card hp-reveal-item">
            <?php if($bnr_img): ?>
            <img src="<?php echo htmlspecialchars($bnr_img); ?>" alt="<?php echo htmlspecialchars($bnr_titre); ?>" loading="lazy" style="width:100%; height:100%; object-fit:cover; object-position:center;">
            <?php else: ?>
            <div style="width:100%; height:100%; min-height:160px; background:var(--shop-bg-alt);"></div>
            <?php endif; ?>
            
            <?php if($bnr_titre): ?>
              <div class="hp-promo-ribbon">
                <span class="hp-promo-ribbon-icon" style="margin-right: 0.25rem;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="hp-promo-ribbon-text" style="padding-left: 0.25rem;" title="<?php echo htmlspecialchars($bnr_titre); ?>"><?php echo htmlspecialchars($bnr_titre); ?></span>
              </div>
            <?php endif; ?>

            <div class="hp-promo-card-overlay">
                <?php if($bnr_lien !== '#'): ?>
                  <span class="hp-promo-cta">
                    <?php echo htmlspecialchars($bnr_btn); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                  </span>
                <?php endif; ?>
            </div>
            <!-- Bouton comparer sur hp-promo-card (overlay) -->
            <?php 
              // Si le lien est un produit (contient /produit/), on peut extraire le lien et essayer de l'associer.
              // Mais ici on n'a pas forcément l'ID produit. On va l'ignorer si non produit.
              // En fait, mieux vaut ne pas mettre comparer sur les bannières promo s'il n'y a pas d'ID clair.
            ?>
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
          <?php foreach ($sc_items as $sci):
            $sci_img = '';
            if (!empty($sci['photo'])) {
              $sci_img = 'media/site/' . $sci['photo'];
            } elseif (!empty($sci['lien_url'])) {
              $sci_img = $sci['lien_url'];
            }
            $sci_lien  = !empty($sci['lien']) ? $sci['lien'] : '#';
            $sci_titre = !empty($sci['titre']) ? $sci['titre'] : '';
          ?>
            <a href="<?php echo htmlspecialchars($sci_lien); ?>" style="min-width:100%; display:block; flex-shrink:0; position:relative;">
              <picture>
                <?php 
                  $photo_m = '';
                  if (!empty($sci['photo_mobile'])) { $photo_m = 'media/site/' . $sci['photo_mobile']; }
                  $photo_t = '';
                  if (!empty($sci['photo_tablet'])) { $photo_t = 'media/site/' . $sci['photo_tablet']; }
                ?>
                <?php if ($photo_m): ?>
                <source srcset="<?php echo htmlspecialchars($photo_m); ?>" media="(max-width: 640px)">
                <?php endif; ?>
                <?php if ($photo_t): ?>
                <source srcset="<?php echo htmlspecialchars($photo_t); ?>" media="(max-width: 1024px)">
                <?php endif; ?>
                <?php if ($sci_img): ?>
                <img src="<?php echo htmlspecialchars($sci_img); ?>" alt="<?php echo htmlspecialchars($sci_titre); ?>" loading="lazy" style="width:100%; max-height:420px; object-fit:cover; border-radius:1.5rem;">
                <?php else: ?>
                <div style="width:100%; height:260px; background:var(--shop-bg-alt); border-radius:1.5rem;"></div>
                <?php endif; ?>
              </picture>
              <?php if($sci_titre): ?>
              <div style="position:absolute; bottom:1.5rem; left:2rem; right:2rem; color:white; text-shadow:0 1px 4px rgba(0,0,0,0.5);">
                <div class="hp-promo-title" style="font-size:clamp(1rem,2vw,1.5rem);"><?php echo htmlspecialchars($sci_titre); ?></div>
              </div>
              <?php endif; ?>
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
                    <?php if (hasVariationPrices($eq['id'])): ?>
                      <span style="font-size:0.7rem; color:var(--shop-text-secondary,#6b7280); font-weight:400; display:block; margin-bottom:-2px;">À partir de</span>
                    <?php endif; ?>
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

<!-- Section Carousel & Reveal Animations JS helper -->
<script>
(function() {
  // Carousel logic
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

  // Scroll Reveal and Mobile Tap Logic for Promo Cards
  document.addEventListener('DOMContentLoaded', function() {
    const revealItems = document.querySelectorAll('.hp-reveal-item');
    
    // 1. Intersection Observer for Scroll Reveal
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('reveal-active');
            observer.unobserve(entry.target); // Animate only once
          }
        });
      }, {
        root: null,
        threshold: 0.15, // Trigger when 15% of the card is visible
        rootMargin: '0px 0px -50px 0px'
      });

      revealItems.forEach(item => {
        observer.observe(item);
      });
    } else {
      revealItems.forEach(item => {
        item.classList.add('reveal-active');
      });
    }

    // 2. Mobile Tap-to-Reveal Logic (prevent immediate navigation)
    revealItems.forEach(card => {
        // We use click to catch standard link following logic
        card.addEventListener('click', function(e) {
            // Check if device supports touch to infer mobile usage
            const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            
            if (isTouch) {
                // If it doesn't have the active class, it's the first tap
                if (!this.classList.contains('hover-active')) {
                    e.preventDefault(); // Stop navigation
                    
                    // Remove hover-active from all other cards to keep only one open
                    document.querySelectorAll('.hp-reveal-item.hover-active').forEach(other => {
                        if (other !== this) other.classList.remove('hover-active');
                    });
                    
                    this.classList.add('hover-active'); // Add active state for CSS reveal
                }
                // If it DOES have hover-active, we let the click pass through, navigating normally.
            }
        });
    });

    // Optional: Clicking outside closes any open mobile card
    document.addEventListener('touchstart', function(e) {
        if (!e.target.closest('.hp-reveal-item')) {
            document.querySelectorAll('.hp-reveal-item.hover-active').forEach(card => {
                card.classList.remove('hover-active');
            });
        }
    }, {passive: true});

  });
})();
</script>
