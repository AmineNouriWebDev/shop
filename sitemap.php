<?php
/**
 * sitemap.xml — Sitemap dynamique
 * Généré automatiquement depuis la base de données
 * URL: /sitemap.xml
 * Se met à jour automatiquement quand vous ajoutez des produits, catégories ou pages.
 */

include('connec.php');

header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, max-age=3600');

// Détection URL de base
$is_local = (
    (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'offipro.net') ||
    (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'offipro.net')
) ? false : (
    (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') ||
    (isset($_SERVER['REMOTE_ADDR']) && (
        $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ||
        $_SERVER['REMOTE_ADDR'] == '::1'
    ))
);

$res_cfg = mysqli_query($connexion, "SELECT chemin_absolu FROM site_configuration LIMIT 1");
$cfg     = mysqli_fetch_assoc($res_cfg);

if ($is_local) {
    $base = 'http://localhost/shop/';
} else {
    $base = !empty($cfg['chemin_absolu']) ? rtrim($cfg['chemin_absolu'], '/') . '/' : 'https://offipro.net/';
}

$today = date('Y-m-d');
$urls  = [];

/**
 * Formate une date pour le sitemap (YYYY-MM-DD)
 * @param mixed $raw_date Date brute de la BDD (timestamp ou string)
 * @param string $fallback Date par défaut si invalide
 * @return string
 */
function formatSitemapDate($raw_date, $fallback) {
    if (empty($raw_date) || $raw_date == '0000-00-00' || $raw_date == '0000-00-00 00:00:00' || $raw_date == '0000-00-00 00:00:00.000000') {
        return $fallback;
    }

    // Si c'est un timestamp (plus de 10 chiffres pour être sûr que ce n'est pas juste une année)
    if (is_numeric($raw_date) && strlen($raw_date) >= 10) {
        return date('Y-m-d', (int)$raw_date);
    }

    // Sinon on tente strtotime
    $ts = strtotime($raw_date);
    if ($ts && $ts > 0) {
        // Vérification si l'année est réaliste (ex: pas 1970 par erreur)
        $year = (int)date('Y', $ts);
        if ($year > 2000 && $year < 2100) {
            return date('Y-m-d', $ts);
        }
    }

    return $fallback;
}

// ─── Page d'accueil ───────────────────────────────────────────────────────────
$urls[] = [
    'loc'        => $base,
    'priority'   => '1.0',
    'changefreq' => 'daily',
    'lastmod'    => $today
];

// ─── Pages du site (site_menu) ────────────────────────────────────────────────
$res_pages = mysqli_query($connexion, "SELECT link, datecreation FROM site_menu WHERE etat='1' AND link != '' AND link != 'accueil' ORDER BY ordre ASC");
while ($page = mysqli_fetch_assoc($res_pages)) {
    $urls[]  = [
        'loc'        => $base . htmlspecialchars($page['link'], ENT_XML1) . '/',
        'priority'   => '0.8',
        'changefreq' => 'monthly',
        'lastmod'    => formatSitemapDate($page['datecreation'], $today)
    ];
}

// ─── Catégories de la boutique ────────────────────────────────────────────────
$res_cats = mysqli_query($connexion, "SELECT link FROM categories_blog WHERE etat='1' AND link != '' ORDER BY ordre ASC");
while ($cat = mysqli_fetch_assoc($res_cats)) {
    $urls[] = [
        'loc'        => $base . 'boutique/' . htmlspecialchars($cat['link'], ENT_XML1) . '/',
        'priority'   => '0.7',
        'changefreq' => 'weekly',
        'lastmod'    => $today
    ];
}

// ─── Produits actifs ──────────────────────────────────────────────────────────
$res_prods = mysqli_query($connexion, "SELECT link, datecreation FROM produits WHERE etat='1' AND link != '' ORDER BY datecreation DESC");
while ($prod = mysqli_fetch_assoc($res_prods)) {
    $urls[]  = [
        'loc'        => $base . 'produit/' . htmlspecialchars($prod['link'], ENT_XML1) . '/',
        'priority'   => '0.9',
        'changefreq' => 'weekly',
        'lastmod'    => formatSitemapDate($prod['datecreation'], $today)
    ];
}

// ─── Pages statiques importantes ─────────────────────────────────────────────
$static_pages = ['boutique', 'contact', 'recherche'];
foreach ($static_pages as $slug) {
    $urls[] = [
        'loc'        => $base . $slug . '/',
        'priority'   => '0.6',
        'changefreq' => 'monthly',
        'lastmod'    => $today
    ];
}

// ─── Génération du XML ────────────────────────────────────────────────────────
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

foreach ($urls as $url) {
    echo "  <url>\n";
    echo "    <loc>" . $url['loc'] . "</loc>\n";
    echo "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
    echo "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
    echo "    <priority>" . $url['priority'] . "</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>';
