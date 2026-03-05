<?php
include 'connec.php';
echo "Favicon: " . ($favicon ?? 'NOT SET') . "\n";
echo "Logo: " . ($logo ?? 'NOT SET') . "\n";
echo "Tag Manager Head: " . ($tagmanager_head ?? 'NOT SET') . "\n";
echo "Tag Manager Body: " . ($tagmanager_body ?? 'NOT SET') . "\n";
echo "Site Name: " . ($nom_site ?? 'NOT SET') . "\n";
echo "Chemin Absolu: " . ($chemin_absolu ?? 'NOT SET') . "\n";
?>
