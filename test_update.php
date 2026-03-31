<?php
$id = 4136;
$all_variations = [];

// Simulate POST from JS-rendered table
$_POST['variations'] = [
    '59,13' => ['valeurs_ids' => '59,13', 'label' => 'Ram: 6 GO / Stockage: 128 GO', 'prix_vente' => '799', 'prix_promo' => ''],
    '60,13' => ['valeurs_ids' => '60,13', 'label' => 'Ram: 8 GO / Stockage: 128 GO', 'prix_vente' => '888', 'prix_promo' => ''],
    '60,14' => ['valeurs_ids' => '60,14', 'label' => 'Ram: 8 GO / Stockage: 256 GO', 'prix_vente' => '999', 'prix_promo' => '']
];

foreach ($_POST['variations'] as $key => $var) {
    $vids_raw = isset($var['valeurs_ids']) ? trim($var['valeurs_ids']) : '';
    if ($vids_raw === '') {
        $vids_raw = trim((string)$key);
    }
    if ($vids_raw === '') continue;
    
    $vids_arr = explode(',', $vids_raw);
    $vids_arr = array_map('intval', $vids_arr);
    sort($vids_arr, SORT_NUMERIC);
    $vids = implode(',', $vids_arr);
    
    $pv = isset($var['prix_vente']) && $var['prix_vente'] !== '' ? floatval($var['prix_vente']) : 0;
    $pp = isset($var['prix_promo']) && $var['prix_promo'] !== '' ? floatval($var['prix_promo']) : 0;
    $vlabel = isset($var['label']) ? $var['label'] : '';
    
    if ($pv > 0 || $pp > 0) {
        $all_variations[$vids] = ['pv' => $pv, 'pp' => $pp, 'label' => $vlabel];
    }
}

print_r($all_variations);

foreach ($all_variations as $vids => $var) {
    $vids_esc = addslashes((string)$vids);
    $pv_val = ($var['pv'] > 0) ? "'" . floatval($var['pv']) . "'" : 'NULL';
    $pp_val = ($var['pp'] > 0) ? "'" . floatval($var['pp']) . "'" : 'NULL';
    $vlabel_esc = addslashes($var['label']);
    $q_var = "INSERT INTO `produit_variations` (`idproduit`,`valeurs_ids`,`label`,`prix_vente`,`prix_promo`) VALUES ('$id','$vids_esc','$vlabel_esc',$pv_val,$pp_val)";
    echo $q_var . "\n";
}
?>
