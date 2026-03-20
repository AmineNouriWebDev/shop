<?php
require_once 'include.php';
global $connexion;
executeRequete("ALTER TABLE `site_configuration` ADD COLUMN `cloudflare_site_key` VARCHAR(255) DEFAULT ''");
executeRequete("ALTER TABLE `site_configuration` ADD COLUMN `cloudflare_secret_key` VARCHAR(255) DEFAULT ''");
echo "DONE";
?>
