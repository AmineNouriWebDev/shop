<?php
/**
 * ============================================================
 * SHOP — Live Search AJAX Endpoint
 * ============================================================
 * Method : GET
 * Params : q   (string) — search query
 *          limit (int)  — optional, default 8, max 12
 * Returns: JSON { results: [], total: int, query: string }
 * ============================================================
 */

// Security headers
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

// Only allow GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Bootstrap the app (one level up from ajax/)
require_once dirname(__DIR__) . '/include.php';

// ── Input validation ────────────────────────────────────────────
$q     = trim(strip_tags($_GET['q'] ?? ''));
$limit = min(12, max(4, intval($_GET['limit'] ?? 8)));

// Require at least 2 characters
if (mb_strlen($q) < 2) {
    echo json_encode(['results' => [], 'total' => 0, 'query' => '']);
    exit;
}

// ── Sanitize ────────────────────────────────────────────────────
$q_safe = sanitize($q);  // sanitize() = mysqli_real_escape_string from connec.php

// ── Query: products ─────────────────────────────────────────────
$req_products = "SELECT DISTINCT p.id, p.titre, p.link, p.prix_vente, p.prix_promo
                 FROM `produits` p
                 WHERE p.etat = '1'
                   AND p.titre LIKE '%{$q_safe}%'
                 ORDER BY
                   CASE WHEN p.titre LIKE '{$q_safe}%' THEN 0 ELSE 1 END,
                   p.titre ASC
                 LIMIT 0, {$limit}";

$res_products  = executeRequete($req_products);
$results       = [];

while ($row = mysqli_fetch_assoc($res_products)) {
    $id         = $row['id'];
    $prix_promo = $row['prix_promo'];
    $prix_vente = $row['prix_vente'];
    $has_promo  = ($prix_promo && $prix_promo !== '0.000' && $prix_promo !== '0');

    $results[] = [
        'id'         => (int)$id,
        'titre'      => htmlspecialchars($row['titre']),
        'url'        => lienProduits($row['link']),
        'photo'      => photoProduitsSite($id),
        'prix'       => $has_promo ? $prix_promo : $prix_vente,
        'prix_barre' => $has_promo ? $prix_vente : null,
        'promo'      => $has_promo,
    ];
}

// ── Count total matches ─────────────────────────────────────────
$req_count = "SELECT COUNT(DISTINCT id) AS total FROM `produits`
              WHERE etat = '1' AND titre LIKE '%{$q_safe}%'";
$res_count = executeRequete($req_count);
$row_count = mysqli_fetch_assoc($res_count);
$total     = (int)($row_count['total'] ?? 0);

// ── Search URL for "see all" link ───────────────────────────────
// Build the search results URL using the existing lienRecherche() helper
$search_url = lienRecherche() . '?action=search&recherche=' . urlencode($q);

echo json_encode([
    'results'    => $results,
    'total'      => $total,
    'query'      => htmlspecialchars($q),
    'search_url' => $search_url,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
