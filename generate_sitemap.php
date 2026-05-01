<?php
/**
 * Script de génération du fichier sitemap.xml physique
 */

function isValidDate($date) {
    if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') return false;
    return (strtotime($date) !== false);
}

function generateSitemap($silent = false) {
    global $connexion;
    
    if (!$connexion) {
        include('connec.php');
    }

    // Détection URL de base
    $res_cfg = mysqli_query($connexion, "SELECT chemin_absolu, nom_site FROM site_configuration LIMIT 1");
    $cfg     = mysqli_fetch_assoc($res_cfg);

    // Détection environnement
    $is_local = (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'));
    if ($is_local) {
        $base = 'http://localhost/shop/';
    } else {
        $base = !empty($cfg['chemin_absolu']) ? rtrim($cfg['chemin_absolu'], '/') . '/' : 'https://offipro.net/';
    }

    $today = date('Y-m-d');
    $xml_content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
    $xml_content .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

    // 1. Accueil
    $xml_content .= "  <url>\n";
    $xml_content .= "    <loc>" . $base . "</loc>\n";
    $xml_content .= "    <lastmod>" . $today . "</lastmod>\n";
    $xml_content .= "    <changefreq>daily</changefreq>\n";
    $xml_content .= "    <priority>1.0</priority>\n";
    $xml_content .= "  </url>\n";

    // 2. Pages du site (site_menu)
    $res_pages = mysqli_query($connexion, "SELECT link, datecreation FROM site_menu WHERE etat='1' AND link != '' AND link != 'accueil' ORDER BY ordre ASC");
    while ($page = mysqli_fetch_assoc($res_pages)) {
        $link    = htmlspecialchars($page['link'], ENT_XML1);
        
        // Vérification robuste de la date
        $raw_date = $page['datecreation'];
        if (is_numeric($raw_date) && $raw_date > 0) {
            $lastmod = date('Y-m-d', $raw_date);
        } elseif (isValidDate($raw_date)) {
            $lastmod = date('Y-m-d', strtotime($raw_date));
        } else {
            $lastmod = $today;
        }

        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . $base . $link . "/</loc>\n";
        $xml_content .= "    <lastmod>" . $lastmod . "</lastmod>\n";
        $xml_content .= "    <changefreq>monthly</changefreq>\n";
        $xml_content .= "    <priority>0.8</priority>\n";
        $xml_content .= "  </url>\n";
    }

    // 3. Catégories boutique
    $res_cats = mysqli_query($connexion, "SELECT link FROM categories_blog WHERE etat='1' AND link != '' ORDER BY ordre ASC");
    while ($cat = mysqli_fetch_assoc($res_cats)) {
        $link = htmlspecialchars($cat['link'], ENT_XML1);
        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . $base . "boutique/" . $link . "/</loc>\n";
        $xml_content .= "    <lastmod>" . $today . "</lastmod>\n";
        $xml_content .= "    <changefreq>weekly</changefreq>\n";
        $xml_content .= "    <priority>0.8</priority>\n";
        $xml_content .= "  </url>\n";
    }

    // 4. Produits avec Images
    $res_prods = mysqli_query($connexion, "SELECT titre, link, photo, datecreation FROM produits WHERE etat='1' AND link != '' ORDER BY datecreation DESC");
    while ($prod = mysqli_fetch_assoc($res_prods)) {
        $link    = htmlspecialchars($prod['link'], ENT_XML1);
        $titre   = htmlspecialchars($prod['titre'], ENT_XML1);
        
        // Vérification robuste de la date produit
        $raw_date = $prod['datecreation'];
        if (isValidDate($raw_date)) {
            $lastmod = date('Y-m-d', strtotime($raw_date));
        } else {
            $lastmod = $today;
        }
        
        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . $base . "produit/" . $link . "/</loc>\n";
        $xml_content .= "    <lastmod>" . $lastmod . "</lastmod>\n";
        $xml_content .= "    <changefreq>weekly</changefreq>\n";
        $xml_content .= "    <priority>0.9</priority>\n";
        
        if (!empty($prod['photo'])) {
            $xml_content .= "    <image:image>\n";
            $xml_content .= "      <image:loc>" . $base . "media/products/" . htmlspecialchars($prod['photo'], ENT_XML1) . "</image:loc>\n";
            $xml_content .= "      <image:title>" . $titre . "</image:title>\n";
            $xml_content .= "    </image:image>\n";
        }
        
        $xml_content .= "  </url>\n";
    }

    // 5. Pages statiques
    $static_pages = ['boutique', 'contact', 'recherche', 'applications', 'configurateur-camera'];
    foreach ($static_pages as $slug) {
        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . $base . $slug . "/</loc>\n";
        $xml_content .= "    <lastmod>" . $today . "</lastmod>\n";
        $xml_content .= "    <changefreq>monthly</changefreq>\n";
        $xml_content .= "    <priority>0.6</priority>\n";
        $xml_content .= "  </url>\n";
    }

    $xml_content .= '</urlset>';

    // Écriture du fichier sitemap.xml
    $rootPath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    if (file_put_contents($rootPath . 'sitemap.xml', $xml_content)) {
        if (!$silent) echo "Succès : sitemap.xml généré avec succès.";
        return true;
    } else {
        if (!$silent) echo "Erreur : Impossible d'écrire le fichier sitemap.xml.";
        return false;
    }
}

// Exécution directe si appelé par URL
if (basename($_SERVER['PHP_SELF']) == 'generate_sitemap.php') {
    generateSitemap();
}
