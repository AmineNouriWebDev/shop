<?php
// ajax_configurateur.php
include("include.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

// ─── GET KITS ────────────────────────────────────────────────────────────────
if ($action == 'get_kits') {
    $kits = [];
    $req  = "SELECT * FROM conf_kits WHERE etat = 1 ORDER BY ordre ASC";
    $res  = executeRequete($req);
    while ($row = mysqli_fetch_assoc($res)) {
        $kits[] = [
            'id'          => $row['id'],
            'titre'       => html_entity_decode(afficheChamp($row['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'description' => html_entity_decode(afficheChamp($row['description']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'photo'       => $row['photo'] ?? ''
        ];
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'kits' => $kits]);
    exit;
}

// ─── GET STEPS ───────────────────────────────────────────────────────────────
if ($action == 'get_steps') {
    $kit_id  = isset($_GET['kit_id']) ? intval($_GET['kit_id']) : 0;
    $response = [];

    $req_kit = "SELECT * FROM conf_kits WHERE id = '$kit_id' AND etat = 1";
    $res_kit = executeRequete($req_kit);
    if (!($kit = mysqli_fetch_assoc($res_kit))) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Kit introuvable']);
        exit;
    }

    $response['kit'] = ['id' => $kit['id'], 'titre' => afficheChamp($kit['titre'])];
    $steps            = [];

    $req_etapes = "SELECT * FROM conf_etapes WHERE id_kit = '$kit_id' ORDER BY ordre ASC";
    $res_etapes = executeRequete($req_etapes);

    while ($etape = mysqli_fetch_assoc($res_etapes)) {
        $step = [
            'id'           => $etape['id'],
            'titre'        => afficheChamp($etape['titre']),
            'type_lien'    => $etape['type_lien'],
            'role'         => $etape['role'] ?? '',
            'obligatoire'  => intval($etape['obligatoire'] ?? 1),
            'montant_fixe' => floatval($etape['montant_fixe'] ?? 0),
            'produits'     => []
        ];

        // Étape spéciale frais d'installation — pas de produits
        if (($etape['role'] ?? '') === 'frais_installation') {
            $steps[] = $step;
            continue;
        }

        // ── Collecter les IDs produits depuis les nouvelles colonnes JSON ──
        $product_ids_to_load = [];

        // 1. Catégories (plusieurs)
        $cats_ids = [];
        if (!empty($etape['categories_ids'])) {
            $cats_ids = json_decode($etape['categories_ids'], true) ?: [];
        } elseif ($etape['type_lien'] == 'categorie' && $etape['id_lien']) {
            $cats_ids = [$etape['id_lien']];
        }
        foreach ($cats_ids as $cat_id) {
            $cat_id = intval($cat_id);
            if ($cat_id <= 0) continue;
            $req_cat_prods = "SELECT id FROM produits WHERE categorie = '$cat_id' AND etat = '1' ORDER BY ordre ASC";
            $res_cat_prods = executeRequete($req_cat_prods);
            while ($cp = mysqli_fetch_assoc($res_cat_prods)) {
                $product_ids_to_load[$cp['id']] = true;
            }
        }

        // 2. Produits spécifiques
        $prods_ids = [];
        if (!empty($etape['produits_ids'])) {
            $prods_ids = json_decode($etape['produits_ids'], true) ?: [];
        } elseif ($etape['type_lien'] == 'produit' && $etape['id_lien']) {
            $prods_ids = [$etape['id_lien']];
        }
        foreach ($prods_ids as $prod_id) {
            $prod_id = intval($prod_id);
            if ($prod_id > 0) $product_ids_to_load[$prod_id] = true;
        }

        // ── Charger les produits ──────────────────────────────────────────
        if (!empty($product_ids_to_load)) {
            $ids_list   = implode(',', array_keys($product_ids_to_load));
            $req_prods  = "SELECT id, titre, link, prix_vente, photo, etat_stock
                           FROM produits
                           WHERE id IN ($ids_list) AND etat = '1'
                           ORDER BY FIELD(id, $ids_list)";
            $res_prods  = executeRequete($req_prods);

            while ($prod = mysqli_fetch_assoc($res_prods)) {
                $prix       = prixVenteProduits($prod['id'], true);
                $prix_promo = prixPromoProduits($prod['id'], true);
                $prix_final = ($prix_promo > 0 && $prix_promo < $prix) ? $prix_promo : $prix;

                $p = [
                    'id'           => $prod['id'],
                    'titre'        => html_entity_decode(afficheChamp($prod['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    'link'         => afficheChamp($prod['link']),
                    'prix'         => floatval($prix_final),
                    'prix_formate' => number_format((float)$prix_final, 3, ',', ' ') . ' TND',
                    'photo'        => photoProduitsSite($prod['id']),
                    'stock'        => intval($prod['etat_stock']),
                    'caracteristiques' => []
                ];

                // ── Caractéristiques ──────────────────────────────────────
                $req_carac = "SELECT cp.idcarac, cp.valeur, c.titre as nom_carac
                              FROM caracteristique_prod cp
                              LEFT JOIN caracteristiques c ON cp.idcarac = c.id
                              WHERE cp.idproduit = '{$prod['id']}'";
                $res_carac = executeRequete($req_carac);
                while ($carac = mysqli_fetch_assoc($res_carac)) {
                    $val_name = $carac['valeur'];
                    if (is_numeric($val_name)) {
                        $req_val = "SELECT valeur FROM valeur_caracteristique WHERE id = '$val_name' LIMIT 1";
                        $res_val = executeRequete($req_val);
                        if ($res_val && $val_row = mysqli_fetch_assoc($res_val)) {
                            $val_name = $val_row['valeur'];
                        }
                    }
                    $p['caracteristiques'][trim(afficheChamp($carac['nom_carac']))] = trim(afficheChamp($val_name));
                }

                $step['produits'][] = $p;
            }
        }

        $steps[] = $step;
    }

    $response['status'] = 'success';
    $response['steps']  = $steps;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
