<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/';

ob_start();
include('include.php');
include('includes/meta.php');
$html = ob_get_clean();

echo "--- META TEST ---\n";
if (strpos($html, 'schema.org') !== false) {
    echo "[PASS] JSON-LD Schema.org is present!\n";
} else {
    echo "[FAIL] JSON-LD missing.\n";
}

if (strpos($html, 'sizes="192x192"') !== false && strpos($html, 'apple-touch-icon') !== false) {
    echo "[PASS] Advanced Favicons are configured!\n";
} else {
    echo "[FAIL] Basic Favicons detected.\n";
}

if (strpos($html, 'Website Developer') !== false) {
    echo "[PASS] Developer HTML Comment is successfully rendered!\n";
} else {
    echo "[FAIL] Developer Comment is missing.\n";
}
?>
