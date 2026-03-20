<?php
include("include.php");

if (lienAccueil()) {
    $requete  = "SELECT * FROM `site_menu` WHERE `link` = 'accueil' ";
    $resultat = executeRequete($requete);
    $data = mysqli_fetch_array($resultat);
    if ($data['id'] != "") {
        $id                = afficheChamp($data['id']);
        $titre             = afficheChamp($data['titre']);
        $contenu           = afficheChamp($data['contenu']);
    }

    // Load specific Homepage SEO from optimisation_seo
    $req_seo = "SELECT title_home, description_home, keywords_home FROM `optimisation_seo` LIMIT 1";
    $res_seo = executeRequete($req_seo);
    if ($res_seo && mysqli_num_rows($res_seo) > 0) {
        $seo_row = mysqli_fetch_assoc($res_seo);
        $title_page       = afficheChamp($seo_row['title_home']);
        $description_page = afficheChamp($seo_row['description_home']);
        $keywords_page    = afficheChamp($seo_row['keywords_home']);
    } else {
        // Fallback to menu if SEO table is empty
        $title_page       = afficheChamp($data['titre_page']);
        $description_page = afficheChamp($data['description']);
        $keywords_page    = afficheChamp($data['keywords']);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include('includes/script-header.php'); ?>
    <?php include('includes/script_panier.php'); ?>

    <style>
        /* Homepage body reset for Tailwind */
        *, *::before, *::after { box-sizing: border-box; }
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
    </style>
</head>

<body>
    <?php include('includes/feedback.php'); ?>

    <!-- ═══ HEADER TAILWIND (top bar + nav + mobile drawer) ═══ -->
    <?php include('includes/header-tw.php'); ?>

    <!-- ═══ HERO CAROUSEL FUTURISTE ═══ -->
    <?php include('includes/hero-carousel-tw.php'); ?>

    <!-- ═══ CONTENU HOMEPAGE TAILWIND ═══ -->
    <?php include('includes/contenu-home-tw.php'); ?>

    <!-- ═══ FOOTER TAILWIND ═══ -->
    <?php include('includes/footer-tw.php'); ?>

    <?php include('includes/script-footer.php'); ?>

</body>

</html>