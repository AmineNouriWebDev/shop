<?php
include('connec.php');
$links = [
    'alphasat-lifetime',
    'tv-tcl-32-smart-android-s5400af-led-full-hd',
    'orca-pro-plus-max-sans-diwen-1-ans',
    'chemise-bristol-couleurs-vives-paquet-de-10',
    'carte-graphique-asus-gt-730-4gd3-4-go',
];

foreach ($links as $link) {
    $req = "SELECT id, titre, caracteristique, video FROM produits WHERE link = '" . mysqli_real_escape_string($connexion, $link) . "'";
    $res = mysqli_query($connexion, $req);
    $d = mysqli_fetch_array($res);
    if (!$d) { echo "<hr><b>$link</b>: NOT FOUND<br>"; continue; }

    // Find iframes, external scripts, external images
    $content = $d['caracteristique'];
    preg_match_all('/<iframe[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $iframes);
    preg_match_all('/<script[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $scripts);
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $imgs);
    preg_match_all('/http[s]?:\/\/[^\s"\'<>]+/i', $content, $urls);

    echo "<hr>";
    echo "<b>" . htmlspecialchars($link) . "</b> (ID: {$d['id']})<br>";
    echo "Video: " . htmlspecialchars($d['video'] ?? '') . "<br>";
    if (!empty($iframes[1])) {
        echo "<span style='color:red'>⚠️ iframes: " . implode(', ', array_map('htmlspecialchars', $iframes[1])) . "</span><br>";
    }
    if (!empty($scripts[1])) {
        echo "<span style='color:orange'>⚠️ scripts: " . implode(', ', array_map('htmlspecialchars', $scripts[1])) . "</span><br>";
    }
    if (!empty($imgs[1])) {
        echo "Images: " . count($imgs[1]) . " found<br>";
        foreach ($imgs[1] as $img) {
            $isExternal = preg_match('/^https?:\/\//i', $img);
            if ($isExternal) {
                echo "<span style='color:orange'>⚠️ External img: " . htmlspecialchars($img) . "</span><br>";
            }
        }
    }
    $externalUrls = array_filter($urls[0] ?? [], function($u) { return !strstr($u, 'localhost'); });
    if (!empty($externalUrls)) {
        echo "<span style='color:#999'>External URLs in content: " . count($externalUrls) . "</span><br>";
    }
    if (empty($iframes[1]) && empty($scripts[1]) && empty($externalUrls)) {
        echo "<span style='color:green'>✅ No suspicious external resources found in content.</span><br>";
    }
}
?>
