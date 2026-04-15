<?php
/**
 * ajax_validate_promo.php - Validation temps réel du code promo
 */
ob_start();
error_reporting(0);
ini_set('display_errors', 0);
include("../include.php");
include("../_admin_site/includes/fonctions/fction_codes_promo.php");

$code = isset($_POST['code']) ? $_POST['code'] : '';
$total_panier = 0;

if (isset($_SESSION['panier']['idcart'])) {
    for ($i = 0; $i < count($_SESSION['panier']['idcart']); $i++) {
        $total_ligne = number_format($_SESSION['panier']['total'][$i], 3, '.', '');
        $total_panier += $total_ligne;
    }
}

$result = validerCodePromo($code, $total_panier);

$eligible_indexes = [];

if ($result['valid']) {
    $_SESSION['panier']['promo_code'] = $result['promo']['code'];
    $_SESSION['panier']['promo_discount'] = $result['reduction'];
    
    // Identifier les index des articles éligibles pour l'UI
    if (isset($_SESSION['panier']['idcart'])) {
        for ($i = 0; $i < count($_SESSION['panier']['idcart']); $i++) {
            if (isProductEligibleForPromo($_SESSION['panier']['idcart'][$i], $result['promo']['code'])) {
                $eligible_indexes[] = $i;
            }
        }
    }
} else {
    unset($_SESSION['panier']['promo_code']);
    unset($_SESSION['panier']['promo_discount']);
}

$result['eligible_indexes'] = $eligible_indexes;

// Nettoyage buffer et envoi JSON
ob_end_clean();
header('Content-Type: application/json');
echo json_encode($result);
exit;
