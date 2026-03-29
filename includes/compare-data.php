<?php
/**
 * compare-data.php — Endpoint AJAX pour la comparaison de produits
 * Accepte des IDs de produits via POST et retourne les données JSON.
 */
session_start();
include("../include.php");

header('Content-Type: application/json; charset=utf-8');

$ids_raw = $_POST['ids'] ?? '';
if (empty($ids_raw)) {
    echo json_encode(['error' => 'Aucun produit fourni']);
    exit;
}

// Sécuriser : garder uniquement les entiers
$ids = array_filter(array_map('intval', explode(',', $ids_raw)));
$ids = array_slice($ids, 0, 4); // Maximum 4 produits

if (empty($ids)) {
    echo json_encode(['error' => 'IDs invalides']);
    exit;
}

$products = [];
foreach ($ids as $id) {
    $id = intval($id);
    
    // Données de base produit
    $req = executeRequete("SELECT * FROM `produits` WHERE `id`='$id' AND `etat`='1'");
    $prod = mysqli_fetch_assoc($req);
    if (!$prod) continue;

    // Prix effectif
    $prix_affiche = (floatval($prod['prix_promo']) > 0) ? $prod['prix_promo'] : $prod['prix_vente'];

    // Caractéristiques
    $specs = [];
    $req_specs = executeRequete("
        SELECT c.titre as label, COALESCE(v.valeur, cp.valeur) as valeur
        FROM `caracteristique_prod` cp
        JOIN `caracteristiques` c ON c.id = cp.idcarac
        LEFT JOIN `valeur_caracteristique` v ON v.id = cp.valeur
        WHERE cp.idproduit = '$id'
        ORDER BY c.id ASC
    ");
    while ($s = mysqli_fetch_assoc($req_specs)) {
        $specs[$s['label']] = $s['valeur'];
    }

    // Marque
    $brand_logo = '';
    if (!empty($prod['marque']) && $prod['marque'] != '0') {
        $req_brand = executeRequete("SELECT * FROM `marques` WHERE `id`='".$prod['marque']."'");
        $brand_data = mysqli_fetch_assoc($req_brand);
        if ($brand_data && !empty($brand_data['photo'])) {
            $brand_logo = 'media/marques/' . $brand_data['photo'];
        }
    }

    $products[] = [
        'id'           => $id,
        'titre'        => titreProduits($id),
        'lien'         => lienProduits($prod['link']),
        'image'        => photoProduitsSite($id),
        'prix'         => $prix_affiche . ' DT',
        'prix_old'     => (floatval($prod['prix_promo']) > 0) ? ($prod['prix_vente'] . ' DT') : '',
        'stock'        => etatStockProduits($id) == '1' ? 'En Stock' : 'Rupture',
        'in_stock'     => etatStockProduits($id) == '1',
        'brand_logo'   => $brand_logo,
        'specs'        => $specs,
    ];
}

echo json_encode(['products' => $products]);
