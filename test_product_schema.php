<?php
// Define minimal server variables to avoid errors in include.php/env.php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/produit.php?link=smartphone-infinix-smart-9-3go-64go';

require('include.php');

// Mock variables for product page (overwriting what include.php might have set)
$typeOg = 'Product';
$titre = 'Smartphone Infinix Smart 9 3go 64go';
$photo = '4055-produits-smartphone-infinix-smart-9-3go-64go-vert.jpg';
$id = '4055';
$price = '319.000';
$availability = 'in stock';
$description_page = 'Découvrez les détails du produit Smartphone Infinix Smart 9 3go 64go de la catégorie Smartphone Tunisie et profitez des meilleurs prix.';
$og_url = 'https://technoplus.io/produit/smartphone-infinix-smart-9-3go-64go/';
$og_img = 'https://technoplus.io/media/products/' . $photo;
$favicon = 'favicon.png'; 

ob_start();
include('includes/meta.php');
$output = ob_get_clean();

echo "--- SCHEMA VERIFICATION ---\n";
if (strpos($output, '"@type": "Product"') !== false) {
    echo "[PASS] Product Schema detected!\n";
    if (preg_match('/<script type="application\/ld\+json">.*?Product.*?<\/script>/s', $output, $matches)) {
        echo "Generated JSON-LD:\n";
        echo $matches[0] . "\n";
    }
} else {
    echo "[FAIL] Product Schema missing.\n";
    // Check if typeOg is set correctly
    echo "typeOg: " . $typeOg . "\n";
}

if (strpos($output, '"availability": "https://schema.org/InStock"') !== false) {
    echo "[PASS] Availability URI is correct!\n";
} else {
    echo "[FAIL] Availability URI mismatch.\n";
}
?>
