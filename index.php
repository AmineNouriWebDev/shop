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
        $description_page  = afficheChamp($data['description']);
        $title_page        = afficheChamp($data['titre_page']);
        $keywords_page     = afficheChamp($data['keywords']);
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

    <!-- ═══ FOOTER (legacy — sera migré Phase 6) ═══ -->
    <?php include('includes/footer.php'); ?>

    <?php include('includes/script-footer.php'); ?>

</body>

</html>