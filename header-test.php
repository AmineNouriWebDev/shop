<?php
/**
 * ============================================================
 * SHOP — Header Preview Test Page
 * ============================================================
 * Page de test du nouveau header Tailwind.
 * Accès : http://localhost/shop/header-test.php
 * ============================================================
 */

session_start();
include("include.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header Test — Shop 2026</title>
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
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--shop-bg-base);
      color: var(--shop-text-primary);
      transition: background 250ms ease, color 200ms ease;
    }
    html.dark body { background: var(--shop-bg-base); }

    .preview-content {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
    }
    .preview-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.375rem;
      padding: 0.3rem 0.75rem;
      background: color-mix(in srgb, #10B981 12%, transparent);
      color: #10B981;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      margin-bottom: 1rem;
    }
    .preview-card {
      background: var(--shop-surface);
      border: 1px solid var(--shop-border);
      border-radius: 1.5rem;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: var(--shop-shadow-card);
    }
  </style>
</head>
<body>

  <?php include('includes/header-tw.php'); ?>

  <!-- PAGE CONTENT DEMO -->
  <div class="preview-content" style="margin-top: 2rem;">

    <div class="preview-badge">
      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      Phase 3 — Header Preview
    </div>

    <h1 style="font-size: clamp(1.5rem, 1rem + 2.5vw, 2.25rem); font-weight: 800; color: var(--shop-text-primary); margin-bottom: 0.5rem;">
      Nouveau Header — Tailwind v4
    </h1>
    <p style="color: var(--shop-text-secondary); font-size: 1rem; margin-bottom: 2rem;">
      Components : Top bar · Header sticky frosted glass · Search · Cart · Dark mode toggle · Nav dropdowns · Mobile drawer
    </p>

    <!-- Test Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
      <?php for ($i = 1; $i <= 3; $i++): ?>
      <div class="card-product" style="cursor: pointer;">
        <div style="overflow: hidden; aspect-ratio: 1/1; background: var(--shop-bg-alt); display: flex; align-items: center; justify-content: center; font-size: 4rem;">
          <?php echo ['📱', '💻', '⌚'][$i - 1]; ?>
        </div>
        <div style="padding: 1.25rem;">
          <p style="font-size: 0.7rem; font-weight: 600; color: var(--shop-secondary); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Marque Tech <?php echo $i; ?></p>
          <h3 style="font-size: 0.9375rem; font-weight: 700; color: var(--shop-text-primary); margin-bottom: 0.75rem; line-height: 1.4;">Produit Premium <?php echo $i; ?> — Edition 2026</h3>
          <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem;">
            <span class="price-main"><?php echo number_format(999 * $i, 0, ',', ' '); ?> DT</span>
          </div>
          <button class="btn-primary" style="width: 100%; font-size: 0.8125rem; padding: 0.625rem;">Voir le produit</button>
        </div>
      </div>
      <?php endfor; ?>
    </div>

    <!-- Feature checklist -->
    <div class="preview-card">
      <h2 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1rem; color: var(--shop-text-primary);">✅ Features du header</h2>
      <ul style="list-style: none; padding: 0; display: grid; gap: 0.625rem; font-size: 0.9rem; color: var(--shop-text-secondary);">
        <li>✅ Top bar violet avec numéro de téléphone</li>
        <li>✅ Header sticky avec effet frosted glass (backdrop-blur)</li>
        <li>✅ Logo cliquable</li>
        <li>✅ Search bar desktop avec focus ring violet</li>
        <li>✅ Dark mode toggle animé (soleil ↔ lune) — mémorisé dans localStorage</li>
        <li>✅ Bouton connexion / Mon compte selon session PHP</li>
        <li>✅ Bouton panier avec badge rouge dynamique</li>
        <li>✅ Nav bar sticky avec catégories depuis la base de données</li>
        <li>✅ Dropdowns au hover avec animation slide-down</li>
        <li>✅ Design responsive — mobile drawer hamburger</li>
        <li>✅ Drawer mobile avec accordéon sous-catégories</li>
        <li>✅ Overlay mobile avec backdrop-blur</li>
        <li>✅ Highlight lien actif basé sur l'URL courante</li>
      </ul>
    </div>

    <!-- Long content to test sticky -->
    <?php for ($j = 0; $j < 4; $j++): ?>
    <div class="preview-card" style="opacity: <?php echo 1 - $j * 0.15; ?>">
      <p style="color: var(--shop-text-secondary); font-size: 0.9rem; line-height: 1.7;">
        Faites défiler la page pour tester le comportement sticky du header et de la navbar. Le header reste en haut avec l'effet glassmorphism frosted glass. La navbar reste juste en dessous. Testez aussi le dark mode toggle — le changement est immédiat et mémorisé pour votre prochaine visite.
      </p>
    </div>
    <?php endfor; ?>

  </div>

</body>
</html>
