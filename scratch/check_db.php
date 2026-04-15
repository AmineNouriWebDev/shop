<?php
include("include.php");
include("_admin_site/includes/fonctions/fction_codes_promo.php");

echo "Checking database structure...\n";
verifierTableCodesPromo();

$res = mysqli_query($connexion, "SHOW TABLES LIKE 'codes_promo_categories'");
if (mysqli_num_rows($res) > 0) {
    echo "Table 'codes_promo_categories' exists.\n";
} else {
    echo "Table 'codes_promo_categories' MISSING!\n";
}

$res = mysqli_query($connexion, "SHOW COLUMNS FROM `codes_promo` LIKE 'montant_min_type'");
if (mysqli_num_rows($res) > 0) {
    echo "Column 'montant_min_type' exists.\n";
} else {
    echo "Column 'montant_min_type' MISSING!\n";
}

echo "Done.\n";
?>
