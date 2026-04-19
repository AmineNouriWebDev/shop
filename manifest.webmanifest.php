<?php
/**
 * manifest.webmanifest — PWA Manifest dynamique
 * Généré dynamiquement depuis la base de données (site_configuration)
 * URL: /manifest.webmanifest
 */

include('connec.php');

header('Content-Type: application/manifest+json; charset=utf-8');
header('Cache-Control: public, max-age=3600');

// Récupérer la config du site
$res = mysqli_query($connexion, "SELECT nom_site, favicon, logo, chemin_absolu, theme_color FROM site_configuration LIMIT 1");
$cfg = mysqli_fetch_assoc($res);

$site_name   = htmlspecialchars($cfg['nom_site'] ?? 'Offipro', ENT_QUOTES);
$theme_color = !empty($cfg['theme_color']) ? $cfg['theme_color'] : '#1E3A8A';
$favicon     = !empty($cfg['favicon']) ? $cfg['favicon'] : '';
$logo        = !empty($cfg['logo']) ? $cfg['logo'] : '';

// Détection de l'URL de base
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

if ($is_local) {
    $base_url = "http://localhost/shop/";
} else {
    $base_url = !empty($cfg['chemin_absolu']) ? rtrim($cfg['chemin_absolu'], '/') . '/' : '/';
}

$icon_192_path = __DIR__ . '/media/site/icon-192x192.webp';
$icon_512_path = __DIR__ . '/media/site/icon-512x512.webp';

$icon_192 = file_exists($icon_192_path) ? $base_url . 'media/site/icon-192x192.webp' : $base_url . 'media/site/' . ($favicon ?: $logo);
$icon_512 = file_exists($icon_512_path) ? $base_url . 'media/site/icon-512x512.webp' : $base_url . 'media/site/' . ($favicon ?: $logo);

$type_192 = file_exists($icon_192_path) ? 'image/webp' : 'image/png';
$type_512 = file_exists($icon_512_path) ? 'image/webp' : 'image/png';

$manifest = [
    "name"             => $site_name,
    "short_name"       => mb_substr($site_name, 0, 12),
    "description"      => "Votre boutique en ligne — " . $site_name,
    "start_url"        => $base_url,
    "scope"            => $base_url,
    "display"          => "standalone",
    "orientation"      => "portrait-primary",
    "background_color" => "#ffffff",
    "theme_color"      => $theme_color,
    "lang"             => "fr",
    "categories"       => ["shopping", "technology"],
    "icons"            => [
        [
            "src"     => $icon_192,
            "sizes"   => "192x192",
            "type"    => $type_192,
            "purpose" => "any"
        ],
        [
            "src"     => $icon_512,
            "sizes"   => "512x512",
            "type"    => $type_512,
            "purpose" => "any maskable"
        ]
    ],
    "screenshots"      => [],
    "related_applications" => [],
    "prefer_related_applications" => false
];

echo json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
