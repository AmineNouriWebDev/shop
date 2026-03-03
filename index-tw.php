<?php
/**
 * ============================================================
 * SHOP — Homepage 2026 (Tailwind)
 * ============================================================
 * Nouvelle homepage migrée vers Tailwind CSS.
 * Coexiste avec index.php (Bootstrap) — accessible via :
 *   http://localhost/shop/index-tw.php
 *
 * Une fois validée, remplacera index.php.
 * ============================================================
 */

include("include.php");

if (lienAccueil()) {
    $requete = "SELECT * FROM `site_menu` WHERE `link` = 'accueil'";
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if ($data['id'] != "") {
        $id                = afficheChamp($data['id']);
        $titre             = afficheChamp($data['titre']);
        $contenu           = afficheChamp($data['contenu']);
        $description_page  = afficheChamp($data['description']);
        $title_page        = afficheChamp($data['titre_page']);
        $keywords_page     = afficheChamp($data['keywords']);
    }
}

// SEO
$page_title       = $title_page ?? ($nom_site ?? 'Shop') . ' — Smartphones, PC, Accessoires Tech';
$page_description = $description_page ?? 'Découvrez notre sélection de smartphones, PC gamer, smartwatches et accessoires tech aux meilleurs prix. Livraison rapide, garantie officielle.';
?>
<!DOCTYPE html>
<html lang="fr" id="html-root">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
  <?php if (!empty($keywords_page)): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords_page); ?>">
  <?php endif; ?>
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?php echo lienAccueil(); ?>">

  <!-- Open Graph -->
  <meta property="og:type"        content="website">
  <meta property="og:title"       content="<?php echo htmlspecialchars($page_title); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
  <meta property="og:url"         content="<?php echo lienAccueil(); ?>">

  <!-- ① Anti-FOUC dark mode — FIRST script in <head> -->
  <script src="dist/js/dark-mode.js"></script>

  <!-- ② Design tokens -->
  <link rel="stylesheet" href="dist/css/design-tokens.css">

  <!-- ③ Tailwind compiled output -->
  <link rel="stylesheet" href="dist/css/tailwind.output.css">

  <!-- ④ Inter font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <!-- ⑤ Icons (Font Awesome — kept from legacy) -->
  <link rel="stylesheet" href="dist/fontawesome-free-6.5.1-web/css/all.min.css">

  <!-- ⑥ Favicon -->
  <link rel="icon"         type="image/png" href="media/site/favicon-cooon.png">
  <link rel="shortcut icon" type="image/png" href="media/site/favicon-cooon.png">

  <!-- ⑦ Panier script (AJAX cart, kept from legacy) -->
  <?php include('includes/script_panier.php'); ?>

  <!-- ⑧ jQuery (required by addToCart functions) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>

  <!-- Global homepage styles -->
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--shop-bg-base);
      color: var(--shop-text-primary);
      -webkit-font-smoothing: antialiased;
      transition: background 250ms ease, color 200ms ease;
    }
    html.dark body { background: var(--shop-bg-base); }
    img { max-width: 100%; height: auto; }
    a { color: inherit; }
  </style>

  <?php echo $tagmanager_head ?? ''; ?>
</head>

<body>

  <?php include('includes/feedback.php'); ?>

  <!-- ═══ HEADER (new Tailwind version) ═══ -->
  <?php include('includes/header-tw.php'); ?>

  <!-- ═══ HERO CAROUSEL (futuristic, from sliders DB) ═══ -->
  <?php include('includes/hero-carousel-tw.php'); ?>

  <!-- ═══ HOMEPAGE SECTIONS ═══ -->
  <?php include('includes/contenu-home-tw.php'); ?>

  <!-- ═══ FOOTER (kept from legacy for now) ═══ -->
  <?php include('includes/footer.php'); ?>

  <!-- ═══ FOOTER SCRIPTS ═══ -->
  <?php include('includes/script-footer.php'); ?>

  <?php echo $tagmanager_body ?? ''; ?>

</body>

</html>
