<?php
$html = file_get_contents('http://localhost/shop/');
if (strpos($html, 'schema.org') !== false) echo "Schema OK!\n";
if (strpos($html, 'sizes="192x192"') !== false) echo "Favicon OK!\n";
if (strpos($html, 'Website Developer') !== false) {
    echo "Developer Comment OK!\n";
} else {
    echo "Dev Comment missing!\n";
}
?>
