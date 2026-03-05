<?php
/**
 * debug_network.php — Identifies ALL external resources that would be loaded by a product page.
 * This simulates what the PHP server sends to the browser for a given product link,
 * and extracts every external URL.
 */
include('connec.php');

$link = isset($_GET['link']) ? sanitize($_GET['link']) : 'alphasat-lifetime';

$req = "SELECT p.*, c.titre AS cat_titre FROM produits p JOIN categories_blog c ON p.categorie = c.id WHERE p.link = '$link'";
$res = mysqli_query($connexion, $req);
$d = mysqli_fetch_array($res);

if (!$d) { echo "Product not found: $link"; exit; }

echo "<h2>Product: " . htmlspecialchars($d['titre']) . " (link=$link)</h2>";

// Check all fields for external URLs
$fieldsToCheck = ['caracteristique', 'court_contenu', 'titre'];
$allExternalUrls = [];

foreach ($fieldsToCheck as $field) {
    preg_match_all('/https?:\/\/[^\s"\'<>]+/i', $d[$field] ?? '', $matches);
    foreach ($matches[0] as $url) {
        if (!empty($url)) $allExternalUrls[$field][] = $url;
    }
}

echo "<h3>External URLs in product content:</h3>";
if (empty($allExternalUrls)) {
    echo "<p style='color:green'>✅ No external URLs in product content fields.</p>";
} else {
    foreach ($allExternalUrls as $field => $urls) {
        echo "<b>$field:</b><ul>";
        foreach ($urls as $url) echo "<li>" . htmlspecialchars($url) . "</li>";
        echo "</ul>";
    }
}

// Now check produits_similaires
echo "<h3>Similar products and their images:</h3>";
$req2 = "SELECT ps.*, p.link, p.photo, p.titre FROM produits_similaire ps JOIN produits p ON ps.id_categ = p.categorie WHERE ps.id_produit = '" . $d['id'] . "'";
$res2 = mysqli_query($connexion, $req2);
$cnt = mysqli_num_rows($res2);
echo "Similar products DB rows: " . $cnt . "<br>";

// Check all product images for this product
echo "<h3>Product image(s):</h3>";
echo "Main photo: " . htmlspecialchars($d['photo'] ?? '') . "<br>";
$req3 = "SELECT * FROM images_produit WHERE id_produit = '" . $d['id'] . "'";
$res3 = mysqli_query($connexion, $req3);
echo "Extra images count: " . mysqli_num_rows($res3) . "<br>";

// Check if the product video contains an iframe
echo "<h3>Video field:</h3>";
$video = $d['video'] ?? '';
echo htmlspecialchars($video ?: '(empty)') . "<br>";
if (strpos($video, 'youtube.com') !== false || strpos($video, 'youtu.be') !== false) {
    echo "<span style='color:orange'>⚠️ YouTube iframe embed will be loaded on this page.</span><br>";
}
if (strpos($video, '<iframe') !== false && strpos($video, 'youtube') === false) {
    echo "<span style='color:red'>⚠️ Non-YouTube iframe in video field: " . htmlspecialchars($video) . "</span><br>";
}

// Check the main.js for any AJAX calls that might run per-product
echo "<h3>Summary:</h3>";
echo "Product ID: " . $d['id'] . "<br>";
echo "Category: " . htmlspecialchars($d['cat_titre'] ?? '') . "<br>";
echo "Stock: " . $d['etat_stock'] . "<br>";
?>
