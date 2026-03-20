<?php
/**
 * ============================================================
 * SHOP — Design System Showcase Page
 * ============================================================
 * Page de test et documentation visuelle du Design System 2026.
 * Accessible sur : http://localhost/shop/design-system.php
 *
 * ⚠️ À NE PAS DÉPLOYER en production (ou protéger par IP).
 * ============================================================
 */

include("include.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Design System — Shop 2026</title>
  <meta name="robots" content="noindex, nofollow">

  <!-- Anti-FOUC dark mode (FIRST script in head) -->
  <script src="dist/js/dark-mode.js"></script>

  <!-- Design tokens & Tailwind -->
  <link rel="stylesheet" href="dist/css/design-tokens.css">
  <link rel="stylesheet" href="dist/css/tailwind.output.css">

  <!-- Inter font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <style>
    /* Page-specific styles */
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background-color: var(--shop-bg-base);
      color: var(--shop-text-primary);
      transition: background-color 250ms ease, color 200ms ease;
    }
    html.dark body {
      background-color: var(--shop-bg-base);
      color: var(--shop-text-primary);
    }

    /* DS Nav */
    .ds-nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      height: 60px;
      background: color-mix(in srgb, var(--shop-surface) 80%, transparent);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--shop-border);
    }
    .ds-logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 700;
      font-size: 1rem;
      color: var(--shop-primary);
    }
    .ds-logo span { color: var(--shop-text-primary); font-weight: 400; font-size: 0.8125rem; }

    /* DS Sidebar */
    .ds-layout { display: flex; padding-top: 60px; min-height: 100vh; }
    .ds-sidebar {
      position: sticky;
      top: 60px;
      height: calc(100vh - 60px);
      overflow-y: auto;
      width: 220px;
      flex-shrink: 0;
      padding: 1.5rem 1rem;
      border-right: 1px solid var(--shop-border);
    }
    .ds-sidebar-title {
      font-size: 0.6875rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--shop-text-secondary);
      margin-bottom: 0.5rem;
      margin-top: 1rem;
    }
    .ds-sidebar a {
      display: block;
      padding: 0.375rem 0.75rem;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      color: var(--shop-text-secondary);
      text-decoration: none;
      transition: all 150ms ease;
    }
    .ds-sidebar a:hover {
      background-color: color-mix(in srgb, var(--shop-primary) 8%, transparent);
      color: var(--shop-primary);
    }

    /* DS Main content */
    .ds-main { flex: 1; padding: 2rem 3rem; max-width: 1000px; }

    /* Sections */
    .ds-section { margin-bottom: 4rem; }
    .ds-section-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--shop-text-primary);
      margin-bottom: 0.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 1px solid var(--shop-border);
    }
    .ds-section-desc {
      font-size: 0.9375rem;
      color: var(--shop-text-secondary);
      margin-bottom: 1.5rem;
    }

    /* Palette grid */
    .color-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    .color-chip {
      border-radius: 0.75rem;
      overflow: hidden;
      border: 1px solid var(--shop-border);
    }
    .color-chip-swatch { height: 80px; width: 100%; }
    .color-chip-info { padding: 0.625rem 0.75rem; background: var(--shop-surface); }
    .color-chip-name { font-size: 0.75rem; font-weight: 600; color: var(--shop-text-primary); }
    .color-chip-hex { font-size: 0.6875rem; color: var(--shop-text-secondary); font-family: monospace; }

    /* Showcase grid */
    .showcase-row { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; margin-bottom: 1rem; }

    /* Typography scale */
    .typo-row { display: flex; align-items: baseline; gap: 1.5rem; margin-bottom: 1.25rem; border-bottom: 1px dashed var(--shop-border); padding-bottom: 1.25rem; }
    .typo-label { font-size: 0.6875rem; color: var(--shop-text-secondary); font-family: monospace; width: 100px; flex-shrink: 0; }

    /* Token table */
    .token-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
    .token-table th { text-align: left; padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: var(--shop-text-secondary); border-bottom: 1px solid var(--shop-border); }
    .token-table td { padding: 0.625rem 0.75rem; border-bottom: 1px solid var(--shop-border); color: var(--shop-text-primary); }
    .token-table code { font-family: 'JetBrains Mono', monospace; font-size: 0.8125rem; background: color-mix(in srgb, var(--shop-primary) 8%, transparent); color: var(--shop-primary); padding: 0.1rem 0.4rem; border-radius: 0.25rem; }
    .token-table .swatch-sm { display: inline-block; width: 20px; height: 20px; border-radius: 0.25rem; border: 1px solid var(--shop-border); vertical-align: middle; margin-right: 0.5rem; }

    /* Cards demo */
    .cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }

    /* Shadow demo */
    .shadow-demo { padding: 1.5rem; border-radius: 1rem; background: var(--shop-surface); text-align: center; font-size: 0.875rem; font-weight: 500; }
  </style>
</head>

<body>

  <!-- NAV -->
  <nav class="ds-nav">
    <div class="ds-logo">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--shop-primary)"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      Design System
      <span>&nbsp;/&nbsp; Shop 2026</span>
    </div>
    <div style="display:flex; align-items:center; gap:0.75rem;">
      <span style="font-size:0.75rem; color:var(--shop-text-secondary);">Tailwind v4.2.1</span>
      <button class="dark-toggle-btn" id="dark-mode-toggle" onclick="window.__toggleTheme()" aria-label="Toggle dark mode">
        <!-- Soleil -->
        <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <!-- Lune -->
        <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
    </div>
  </nav>

  <div class="ds-layout">

    <!-- SIDEBAR -->
    <aside class="ds-sidebar">
      <div class="ds-sidebar-title">Fondations</div>
      <a href="#colors">Couleurs</a>
      <a href="#typography">Typographie</a>
      <a href="#shadows">Shadows</a>
      <a href="#tokens">Tokens CSS</a>
      <div class="ds-sidebar-title">Composants</div>
      <a href="#buttons">Boutons</a>
      <a href="#badges">Badges</a>
      <a href="#inputs">Inputs</a>
      <a href="#cards">Cards</a>
      <a href="#toggle">Dark Mode</a>
      <a href="#glass">Glassmorphism</a>
    </aside>

    <!-- MAIN -->
    <main class="ds-main">

      <div style="margin-bottom:3rem;">
        <h1 style="font-size:2.25rem; font-weight:800; color:var(--shop-text-primary); margin-bottom:0.5rem;">Design System <span style="background:linear-gradient(135deg, var(--shop-primary), var(--shop-secondary)); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">Shop 2026</span></h1>
        <p style="color:var(--shop-text-secondary); font-size:1.0625rem;">Référentiel visuel pour la migration Bootstrap → Tailwind. Palette tech premium autour de <code style="background:color-mix(in srgb, var(--shop-primary) 10%, transparent); color:var(--shop-primary); padding:0.1rem 0.4rem; border-radius:0.25rem; font-family:monospace;">#5A31F4</code>.</p>
      </div>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 1. COULEURS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="colors">
        <div class="ds-section-title">🎨 Couleurs</div>
        <p class="ds-section-desc">Palette complète, optimisée pour le secteur tech et la conversion e-commerce.</p>

        <div class="color-grid">
          <!-- Primary -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#5A31F4;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Primary</div><div class="color-chip-hex">#5A31F4</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#7B5EF8;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Primary Glow</div><div class="color-chip-hex">#7B5EF8</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#4A24E8;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Primary Hover</div><div class="color-chip-hex">#4A24E8</div></div>
          </div>
          <!-- Secondary -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#0EA5E9;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Secondary</div><div class="color-chip-hex">#0EA5E9</div></div>
          </div>
          <!-- Accent -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#F43F5E;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Accent CTA</div><div class="color-chip-hex">#F43F5E</div></div>
          </div>
          <!-- Backgrounds -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#F8F7FF; border: 1px solid #E0DEFF;"></div>
            <div class="color-chip-info"><div class="color-chip-name">BG Base</div><div class="color-chip-hex">#F8F7FF</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#0D0B1A;"></div>
            <div class="color-chip-info"><div class="color-chip-name">BG Dark</div><div class="color-chip-hex">#0D0B1A</div></div>
          </div>
          <!-- States -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#10B981;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Success</div><div class="color-chip-hex">#10B981</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#F59E0B;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Warning</div><div class="color-chip-hex">#F59E0B</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#EF4444;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Error</div><div class="color-chip-hex">#EF4444</div></div>
          </div>
          <!-- Text -->
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#120B2E;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Text Primary</div><div class="color-chip-hex">#120B2E</div></div>
          </div>
          <div class="color-chip">
            <div class="color-chip-swatch" style="background:#6B6589;"></div>
            <div class="color-chip-info"><div class="color-chip-name">Text Secondary</div><div class="color-chip-hex">#6B6589</div></div>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 2. TYPOGRAPHIE -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="typography">
        <div class="ds-section-title">✍️ Typographie — Fluid Scale</div>
        <p class="ds-section-desc">Police principale : <strong>Inter</strong>. Tailles fluides via <code style="font-family:monospace;">clamp()</code>.</p>

        <div class="typo-row">
          <span class="typo-label">Display 4XL</span>
          <span style="font-size:clamp(2.25rem,1rem + 6.25vw,3.75rem); font-weight:800; line-height:1.1; letter-spacing:-0.03em;">iPhone 15 Pro</span>
        </div>
        <div class="typo-row">
          <span class="typo-label">Title 3XL</span>
          <span style="font-size:clamp(1.875rem,1rem + 4.375vw,3rem); font-weight:700; letter-spacing:-0.025em;">Meilleurs deals</span>
        </div>
        <div class="typo-row">
          <span class="typo-label">Heading 2XL</span>
          <span style="font-size:clamp(1.5rem,1rem + 2.5vw,2.25rem); font-weight:700; letter-spacing:-0.02em;">PC Gamer Ultra</span>
        </div>
        <div class="typo-row">
          <span class="typo-label">Sub-heading XL</span>
          <span style="font-size:clamp(1.25rem,1rem + 1.25vw,1.75rem); font-weight:600;">Smartphones reconditionnés</span>
        </div>
        <div class="typo-row">
          <span class="typo-label">Body LG</span>
          <span style="font-size:clamp(1.125rem,1rem + 0.625vw,1.375rem); color:var(--shop-text-secondary);">Livraison offerte dès 100 DT d'achat. Retour sous 30 jours.</span>
        </div>
        <div class="typo-row">
          <span class="typo-label">Body Base</span>
          <span style="font-size:clamp(1rem,0.9rem + 0.5vw,1.125rem); color:var(--shop-text-secondary);">Prix mis à jour quotidiennement. Garantie constructeur incluse.</span>
        </div>
        <div class="typo-row" style="border-bottom:none;">
          <span class="typo-label">Caption SM</span>
          <span style="font-size:0.8125rem; color:var(--shop-text-disabled);">Réf. #IPH15PM256</span>
        </div>

        <!-- Text gradient -->
        <div style="margin-top:1.5rem;">
          <p style="font-size:0.75rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:var(--shop-text-secondary); margin-bottom:0.5rem;">Text Gradient</p>
          <span style="font-size:2rem; font-weight:800; background:linear-gradient(135deg, var(--shop-primary), var(--shop-secondary)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Tech éco-responsable 2026</span>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 3. SHADOWS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="shadows">
        <div class="ds-section-title">💫 Shadows & Glows</div>
        <p class="ds-section-desc">Shadows soft et glow violet pour un rendu premium tech.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:1.5rem;">
          <div class="shadow-demo" style="box-shadow:var(--shop-shadow-card);">shadow-card</div>
          <div class="shadow-demo" style="box-shadow:var(--shop-shadow-soft);">shadow-soft</div>
          <div class="shadow-demo" style="box-shadow:var(--shop-shadow-glow);">shadow-glow</div>
          <div class="shadow-demo" style="box-shadow:0 8px 32px rgba(90,49,244,0.18), 0 2px 8px rgba(18,11,46,0.08);">card-hover</div>
          <div class="shadow-demo" style="box-shadow:0 0 48px rgba(90,49,244,0.45);">glow-lg</div>
          <div class="shadow-demo" style="animation:var(--animate-glow-pulse);">glow-pulse ✨</div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 4. TOKENS CSS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="tokens">
        <div class="ds-section-title">⚙️ CSS Tokens</div>
        <p class="ds-section-desc">Variables CSS <code style="font-family:monospace;">--shop-*</code> disponibles sur toutes les pages (via <code style="font-family:monospace;">design-tokens.css</code>).</p>

        <table class="token-table">
          <thead>
            <tr><th>Token</th><th>Valeur Light</th><th>Valeur Dark</th></tr>
          </thead>
          <tbody>
            <tr><td><code>--shop-primary</code></td><td><span class="swatch-sm" style="background:#5A31F4;"></span>#5A31F4</td><td><span class="swatch-sm" style="background:#7B5EF8;"></span>#7B5EF8</td></tr>
            <tr><td><code>--shop-secondary</code></td><td><span class="swatch-sm" style="background:#0EA5E9;"></span>#0EA5E9</td><td><span class="swatch-sm" style="background:#38BDF8;"></span>#38BDF8</td></tr>
            <tr><td><code>--shop-accent</code></td><td><span class="swatch-sm" style="background:#F43F5E;"></span>#F43F5E</td><td><span class="swatch-sm" style="background:#FB7185;"></span>#FB7185</td></tr>
            <tr><td><code>--shop-bg-base</code></td><td><span class="swatch-sm" style="background:#F8F7FF; border:1px solid #E0DEFF;"></span>#F8F7FF</td><td><span class="swatch-sm" style="background:#0D0B1A;"></span>#0D0B1A</td></tr>
            <tr><td><code>--shop-surface</code></td><td><span class="swatch-sm" style="background:#FFFFFF; border:1px solid #E0DEFF;"></span>#FFFFFF</td><td><span class="swatch-sm" style="background:#1C1930;"></span>#1C1930</td></tr>
            <tr><td><code>--shop-border</code></td><td><span class="swatch-sm" style="background:#E0DEFF;"></span>#E0DEFF</td><td><span class="swatch-sm" style="background:#2E2752;"></span>#2E2752</td></tr>
            <tr><td><code>--shop-success</code></td><td><span class="swatch-sm" style="background:#10B981;"></span>#10B981</td><td><span class="swatch-sm" style="background:#34D399;"></span>#34D399</td></tr>
          </tbody>
        </table>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 5. BOUTONS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="buttons">
        <div class="ds-section-title">🔘 Boutons</div>
        <p class="ds-section-desc">Tous définis dans <code style="font-family:monospace;">@layer components</code> de Tailwind. Hover, active et focus accessibles.</p>

        <div class="showcase-row">
          <button class="btn-primary">Ajouter au panier</button>
          <button class="btn-primary" style="background:var(--shop-secondary);">Commander</button>
          <button class="btn-accent">-20% · Acheter</button>
          <button class="btn-ghost">Voir détails</button>
        </div>

        <div class="showcase-row" style="margin-top:0.5rem;">
          <button class="btn-primary" style="font-size:0.8125rem; padding:0.5rem 1rem;">Small</button>
          <button class="btn-primary">Medium (défaut)</button>
          <button class="btn-primary" style="font-size:1rem; padding:1rem 2rem;">Large</button>
          <button class="btn-primary" disabled>Désactivé</button>
        </div>

        <!-- CTA e-commerce -->
        <div style="margin-top:1.5rem;">
          <p style="font-size:0.75rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:var(--shop-text-secondary); margin-bottom:0.75rem;">CTA E-commerce</p>
          <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
            <button class="btn-accent" style="min-width:200px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
              Ajouter au panier
            </button>
            <button class="btn-primary" style="min-width:180px;">
              Commander maintenant
            </button>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 6. BADGES -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="badges">
        <div class="ds-section-title">🏷️ Badges</div>
        <p class="ds-section-desc">Labels de statut pour produits, promotions, stock.</p>

        <div class="showcase-row">
          <span class="badge badge-primary">Nouveau</span>
          <span class="badge badge-accent">-25%</span>
          <span class="badge badge-success">En stock</span>
          <span class="badge" style="background:color-mix(in srgb, var(--shop-warning) 12%, transparent); color:var(--shop-warning);">Stock faible</span>
          <span class="badge" style="background:color-mix(in srgb, var(--shop-error) 12%, transparent); color:var(--shop-error);">Rupture</span>
          <span class="badge" style="background:color-mix(in srgb, var(--shop-secondary) 12%, transparent); color:var(--shop-secondary);">Promo</span>
        </div>

        <div class="showcase-row" style="margin-top:1rem;">
          <span class="badge badge-accent" style="animation:var(--animate-glow-pulse);">⚡ Offre Flash</span>
          <span class="badge badge-primary">🔥 Best-seller</span>
          <span class="badge badge-success">✓ Livraison offerte</span>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 7. INPUTS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="inputs">
        <div class="ds-section-title">📝 Inputs & Forms</div>
        <p class="ds-section-desc">Champs stylés avec focus ring violet et transition douce.</p>

        <div style="display:flex; flex-direction:column; gap:1rem; max-width:480px;">
          <input type="text" class="input-field" placeholder="Rechercher un produit...">
          <input type="email" class="input-field" placeholder="votre@email.com">
          <input type="password" class="input-field" placeholder="Mot de passe">
          <div style="position:relative;">
            <input type="text" class="input-field" placeholder="Recherche avec icône..." style="padding-left:2.75rem;">
            <svg style="position:absolute; left:0.875rem; top:50%; transform:translateY(-50%); color:var(--shop-text-secondary);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 8. CARDS -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="cards">
        <div class="ds-section-title">📦 Cards Produits</div>
        <p class="ds-section-desc">Composant <code style="font-family:monospace;">.card-product</code> — hover effect, badge, prix, CTA.</p>

        <div class="cards-grid">

          <!-- Card 1 -->
          <article class="card-product" style="cursor:pointer;">
            <span class="badge badge-accent" style="position:absolute; top:0.75rem; right:0.75rem; z-index:1;">-20%</span>
            <div style="overflow:hidden; aspect-ratio:1/1; background:var(--shop-bg-alt);">
              <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem;">📱</div>
            </div>
            <div style="padding:1.25rem;">
              <p style="font-size:0.7rem; font-weight:600; color:var(--shop-secondary); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.25rem;">Apple</p>
              <h3 style="font-size:0.9375rem; font-weight:700; color:var(--shop-text-primary); margin-bottom:0.75rem; line-height:1.4;">iPhone 15 Pro Max 256 Go Titanium</h3>
              <div style="display:flex; align-items:baseline; gap:0.5rem; margin-bottom:1rem;">
                <span class="price-main">4 299 DT</span>
                <span class="price-old">5 199 DT</span>
              </div>
              <button class="btn-accent" style="width:100%; font-size:0.8125rem; padding:0.625rem;">
                Ajouter au panier
              </button>
            </div>
          </article>

          <!-- Card 2 -->
          <article class="card-product" style="cursor:pointer;">
            <span class="badge badge-primary" style="position:absolute; top:0.75rem; right:0.75rem; z-index:1;">Nouveau</span>
            <div style="overflow:hidden; aspect-ratio:1/1; background:var(--shop-bg-alt);">
              <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem;">💻</div>
            </div>
            <div style="padding:1.25rem;">
              <p style="font-size:0.7rem; font-weight:600; color:var(--shop-secondary); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.25rem;">Asus ROG</p>
              <h3 style="font-size:0.9375rem; font-weight:700; color:var(--shop-text-primary); margin-bottom:0.75rem; line-height:1.4;">PC Gamer Ultra — RTX 4090</h3>
              <div style="display:flex; align-items:baseline; gap:0.5rem; margin-bottom:1rem;">
                <span class="price-main">8 990 DT</span>
              </div>
              <button class="btn-primary" style="width:100%; font-size:0.8125rem; padding:0.625rem;">
                Voir le produit
              </button>
            </div>
          </article>

          <!-- Card 3 -->
          <article class="card-product" style="cursor:pointer;">
            <span class="badge badge-success" style="position:absolute; top:0.75rem; left:0.75rem; z-index:1;">✓ Stock</span>
            <div style="overflow:hidden; aspect-ratio:1/1; background:var(--shop-bg-alt);">
              <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:4rem;">⌚</div>
            </div>
            <div style="padding:1.25rem;">
              <p style="font-size:0.7rem; font-weight:600; color:var(--shop-secondary); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.25rem;">Samsung</p>
              <h3 style="font-size:0.9375rem; font-weight:700; color:var(--shop-text-primary); margin-bottom:0.75rem; line-height:1.4;">Galaxy Watch 7 Pro 47mm</h3>
              <div style="display:flex; align-items:baseline; gap:0.5rem; margin-bottom:1rem;">
                <span class="price-main">1 190 DT</span>
                <span class="price-old">1 399 DT</span>
              </div>
              <button class="btn-ghost" style="width:100%; font-size:0.8125rem; padding:0.625rem;">
                Voir détails
              </button>
            </div>
          </article>

        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 9. DARK MODE TOGGLE -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="toggle">
        <div class="ds-section-title">🌙 Dark Mode Toggle</div>
        <p class="ds-section-desc">Composant <code style="font-family:monospace;">.dark-toggle-btn</code> avec rotation des icônes. Testez en cliquant !</p>

        <div style="display:flex; gap:1.5rem; align-items:center;">
          <button class="dark-toggle-btn" onclick="window.__toggleTheme()" aria-label="Toggle dark mode">
            <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg>
            <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
          </button>
          <p style="font-size:0.875rem; color:var(--shop-text-secondary);">Mémorisé dans <code style="font-family:monospace;">localStorage</code> · Basé sur <code style="font-family:monospace;">prefers-color-scheme</code> · Zéro FOUC</p>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════ -->
      <!-- 10. GLASSMORPHISM -->
      <!-- ═══════════════════════════════════════════ -->
      <section class="ds-section" id="glass">
        <div class="ds-section-title">✨ Glassmorphism</div>
        <p class="ds-section-desc">Effet <code style="font-family:monospace;">.glass</code> — backdrop-blur + transparence. Idéal pour hero sections et headers sticky.</p>

        <div style="position:relative; padding:3rem; border-radius:1.5rem; overflow:hidden; background:linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-secondary) 100%);">
          <div style="position:absolute; inset:0; background:radial-gradient(ellipse at 20% 80%, rgba(255,255,255,0.15) 0%, transparent 60%);"></div>
          <div class="glass" style="position:relative; z-index:1; padding:1.5rem; border-radius:1rem; max-width:400px;">
            <p style="font-weight:700; font-size:1.125rem; color:var(--shop-text-primary); margin-bottom:0.25rem;">Offre Premium</p>
            <p style="font-size:0.875rem; color:var(--shop-text-secondary); margin-bottom:1rem;">Glassmorphism + soft blur. Fonctionne en dark mode aussi.</p>
            <button class="btn-primary">Découvrir →</button>
          </div>
        </div>
      </section>

      <!-- Footer DS -->
      <div style="border-top:1px solid var(--shop-border); padding-top:2rem; margin-top:2rem; text-align:center; color:var(--shop-text-secondary); font-size:0.8125rem;">
        Design System — Shop 2026 &nbsp;·&nbsp; Tailwind CSS v4.2.1 &nbsp;·&nbsp; <span style="color:var(--shop-primary); font-weight:600;">#5A31F4</span>
      </div>

    </main>
  </div>

</body>
</html>
