<?php
/**
 * Migration: Combination-based variations pricing
 * Run once: http://localhost/shop/migrate_to_variations.php
 */
include("connec.php");

echo "<h2>Migration: produit_variations</h2><pre>";

// 1. Create the new table
$create = "CREATE TABLE IF NOT EXISTS `produit_variations` (
  `id`          INT(11) NOT NULL AUTO_INCREMENT,
  `idproduit`   INT(11) NOT NULL,
  `valeurs_ids` VARCHAR(500) NOT NULL COMMENT 'sorted comma-separated valeur_caracteristique IDs',
  `label`       VARCHAR(1000) NOT NULL COMMENT 'human-readable e.g. RAM: 8GB / Stockage: 128GB',
  `prix_vente`  DECIMAL(10,3) DEFAULT NULL,
  `prix_promo`  DECIMAL(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_idproduit` (`idproduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

if (mysqli_query($connexion, $create)) {
    echo "✓ Table produit_variations created (or already exists)\n";
} else {
    echo "✗ Error: " . mysqli_error($connexion) . "\n";
    exit;
}

// 2. Migrate existing per-value prices to combination rows
$products = mysqli_query($connexion, "SELECT DISTINCT idproduit FROM caracteristique_prod");
$migrated = 0;

while ($prod = mysqli_fetch_assoc($products)) {
    $idp = (int)$prod['idproduit'];

    // Get all characteristics for this product
    $caracs = mysqli_query($connexion, "
        SELECT DISTINCT cp.idcarac, c.titre 
        FROM caracteristique_prod cp
        JOIN caracteristiques c ON c.id = cp.idcarac
        WHERE cp.idproduit = '$idp'
        ORDER BY cp.idcarac ASC
    ");

    // $groups[ idcarac ] = [ 'titre'=>..., 'values'=>[ ['valeur_id'=>, 'text_val'=>, 'pv'=>, 'pp'=>], ... ] ]
    $groups = [];
    while ($carac = mysqli_fetch_assoc($caracs)) {
        $idc = (int)$carac['idcarac'];
        $vals = mysqli_query($connexion, "
            SELECT cp.valeur, cp.prix_vente, cp.prix_promo, vc.valeur as text_val
            FROM caracteristique_prod cp
            LEFT JOIN valeur_caracteristique vc ON vc.id = cp.valeur
            WHERE cp.idproduit = '$idp' AND cp.idcarac = '$idc'
        ");
        $groups[$idc] = ['titre' => $carac['titre'], 'values' => []];
        while ($v = mysqli_fetch_assoc($vals)) {
            $groups[$idc]['values'][] = [
                'valeur_id' => (int)$v['valeur'],
                'text_val'  => ($v['text_val'] !== null) ? $v['text_val'] : (string)$v['valeur'],
                'pv'        => $v['prix_vente'],
                'pp'        => $v['prix_promo'],
            ];
        }
    }

    if (empty($groups)) continue;

    /**
     * Cartesian product of $groups.
     * Each element of $result is an array of items: [ ['valeur_id'=>, 'text_val'=>, 'titre'=>, 'pv'=>, 'pp'=>], ... ]
     */
    $result = [[]]; // start with one empty combination
    foreach ($groups as $idc => $group) {
        $newResult = [];
        foreach ($result as $existing) {
            foreach ($group['values'] as $val) {
                // Append a new item to the existing combo
                $newResult[] = array_merge($existing, [[
                    'valeur_id' => $val['valeur_id'],
                    'text_val'  => $val['text_val'],
                    'titre'     => $group['titre'],
                    'pv'        => $val['pv'],
                    'pp'        => $val['pp'],
                ]]);
            }
        }
        $result = $newResult;
    }

    foreach ($result as $combo) {
        // Build sorted IDs key
        $ids = array_column($combo, 'valeur_id');
        sort($ids);
        $valeurs_ids = implode(',', $ids);

        // Build label
        $labelParts = [];
        foreach ($combo as $item) {
            $labelParts[] = $item['titre'] . ': ' . $item['text_val'];
        }
        $label = implode(' / ', $labelParts);

        // Use the highest pv/pp in combo as best-effort starting price
        $pv = null;
        $pp = null;
        foreach ($combo as $item) {
            if ($item['pv'] !== null && floatval($item['pv']) > 0) {
                $pv = ($pv === null || floatval($item['pv']) > floatval($pv)) ? $item['pv'] : $pv;
            }
            if ($item['pp'] !== null && floatval($item['pp']) > 0) {
                $pp = ($pp === null || floatval($item['pp']) > floatval($pp)) ? $item['pp'] : $pp;
            }
        }

        $pv_val = ($pv !== null) ? "'" . floatval($pv) . "'" : 'NULL';
        $pp_val = ($pp !== null) ? "'" . floatval($pp) . "'" : 'NULL';

        $valeurs_ids_esc = mysqli_real_escape_string($connexion, $valeurs_ids);
        $label_esc       = mysqli_real_escape_string($connexion, $label);

        // Skip if already exists
        $exists = mysqli_query($connexion, "SELECT id FROM produit_variations WHERE idproduit='$idp' AND valeurs_ids='$valeurs_ids_esc'");
        if (mysqli_num_rows($exists) == 0) {
            mysqli_query($connexion, "INSERT INTO produit_variations (idproduit, valeurs_ids, label, prix_vente, prix_promo) VALUES ('$idp', '$valeurs_ids_esc', '$label_esc', $pv_val, $pp_val)");
            if (mysqli_errno($connexion)) {
                echo "✗ Insert error for product $idp, combo '$valeurs_ids': " . mysqli_error($connexion) . "\n";
            } else {
                $migrated++;
            }
        }
    }
}

echo "✓ Migrated $migrated combination rows to produit_variations\n";
echo "\n<strong>Migration complete. You can delete this file.</strong>";
echo "</pre>";
?>
