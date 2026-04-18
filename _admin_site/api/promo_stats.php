<?php
/**
 * api/promo_stats.php — Endpoint JSON pour les Statistiques des Promotions
 * Retourne KPIs, top/bottom produits, graphiques, codes promo performance.
 */

session_start();
if (!isset($_SESSION['editor_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

// --- CACHE 5 minutes ---
$cache_file = __DIR__ . '/../sessions/cache_promo_stats.json';
$cache_time = 300;

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    echo file_get_contents($cache_file);
    exit;
}

include("../../connec.php");
include("../includes/fonctions/fction_db.php");

// Période dynamique (30j par défaut, ou 90j)
$period = isset($_GET['period']) ? intval($_GET['period']) : 30;
if (!in_array($period, [7, 30, 90])) $period = 30;

$data = [
    'kpis'           => [],
    'top_promos'     => [],
    'no_sale_promos' => [],
    'expiring_soon'  => [],
    'codes_perf'     => [],
    'promo_flash_vs_classic' => [],
    'charts'         => [
        'ca_promo_vs_total' => ['labels' => [], 'promo' => [], 'total' => []],
        'donut_flash'       => ['labels' => [], 'data' => []]
    ],
    'error' => null
];

try {
    // ===== KPIs =====

    // 1. Nb produits en promo actifs
    $res = executeRequete("SELECT COUNT(*) as nb FROM produits WHERE prix_promo > 0 AND (promo_end_date IS NULL OR promo_end_date > NOW())");
    $data['kpis']['promos_actives'] = ($res && $r = mysqli_fetch_assoc($res)) ? (int)$r['nb'] : 0;

    // 2. Nb ventes flash actifs  
    $res = executeRequete("SELECT COUNT(*) as nb FROM produits WHERE is_flash = 1 AND prix_promo > 0 AND (promo_end_date IS NULL OR promo_end_date > NOW())");
    $data['kpis']['flash_actifs'] = ($res && $r = mysqli_fetch_assoc($res)) ? (int)$r['nb'] : 0;

    // 3. CA généré par produits en promo (commandes des $period derniers jours)
    $q_ca_promo = "
        SELECT SUM(lc.quantite * lc.prix) as ca_promo
        FROM ligne_commande lc
        JOIN produits p ON p.id = lc.id_produit
        JOIN commandes c ON c.id = lc.idcommande
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        WHERE p.prix_promo > 0
        AND c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
        AND LOWER(IFNULL(ec.etat,'')) NOT LIKE '%annul%'
    ";
    $res = executeRequete($q_ca_promo);
    $data['kpis']['ca_promo_periode'] = ($res && $r = mysqli_fetch_assoc($res)) ? round((float)($r['ca_promo'] ?? 0), 3) : 0;

    // 4. Économies totales accordées aux clients (sur la période)
    $q_eco = "
        SELECT SUM((p.prix_vente - p.prix_promo) * lc.quantite) as economies
        FROM ligne_commande lc
        JOIN produits p ON p.id = lc.id_produit
        JOIN commandes c ON c.id = lc.idcommande
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        WHERE p.prix_promo > 0
        AND c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
        AND LOWER(IFNULL(ec.etat,'')) NOT LIKE '%annul%'
    ";
    $res = executeRequete($q_eco);
    $data['kpis']['economies_clients'] = ($res && $r = mysqli_fetch_assoc($res)) ? round((float)($r['economies'] ?? 0), 3) : 0;

    // 5. Codes promo actifs
    $chk_cp = executeRequete("SHOW TABLES LIKE 'codes_promo'");
    if ($chk_cp && mysqli_num_rows($chk_cp) > 0) {
        $res = executeRequete("SELECT COUNT(*) as nb FROM codes_promo WHERE etat = 1 AND (date_expiration IS NULL OR date_expiration >= CURDATE())");
        $data['kpis']['codes_promo_actifs'] = ($res && $r = mysqli_fetch_assoc($res)) ? (int)$r['nb'] : 0;
    }


    // 6. Taux CA promo vs CA total période
    $q_ca_total = "
        SELECT SUM(c.total) as ca_total
        FROM commandes c
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        WHERE c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
        AND LOWER(IFNULL(ec.etat,'')) NOT LIKE '%annul%'
    ";
    $res = executeRequete($q_ca_total);
    $ca_total = ($res && $r = mysqli_fetch_assoc($res)) ? (float)($r['ca_total'] ?? 0) : 0;
    $data['kpis']['ca_total_periode'] = round($ca_total, 3);
    $data['kpis']['taux_promo'] = $ca_total > 0 ? round(($data['kpis']['ca_promo_periode'] / $ca_total) * 100, 1) : 0;


    // ===== TOP 10 PRODUITS EN PROMO LES MIEUX VENDUS =====
    $q_top = "
        SELECT 
            p.id, p.titre, p.photo, p.prix_vente, p.prix_promo, p.is_flash,
            p.promo_end_date,
            COALESCE(SUM(lc.quantite), 0) as qte_vendue,
            COALESCE(SUM(lc.quantite * lc.prix), 0) as ca_genere,
            COALESCE(SUM((p.prix_vente - p.prix_promo) * lc.quantite), 0) as economies_donnees
        FROM produits p
        LEFT JOIN ligne_commande lc ON lc.id_produit = p.id
        LEFT JOIN commandes c ON c.id = lc.idcommande AND c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
        WHERE p.prix_promo > 0 
        AND (p.promo_end_date IS NULL OR p.promo_end_date > NOW())
        GROUP BY p.id
        ORDER BY qte_vendue DESC
        LIMIT 10
    ";
    $res = executeRequete($q_top);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $remise_pct = $row['prix_vente'] > 0 ? round((($row['prix_vente'] - $row['prix_promo']) / $row['prix_vente']) * 100) : 0;
            $data['top_promos'][] = [
                'id'               => (int)$row['id'],
                'titre'            => htmlspecialchars($row['titre']),
                'photo'            => htmlspecialchars($row['photo'] ?? ''),
                'prix_vente'       => (float)$row['prix_vente'],
                'prix_promo'       => (float)$row['prix_promo'],
                'remise_pct'       => $remise_pct,
                'is_flash'         => (int)$row['is_flash'],
                'promo_end_date'   => $row['promo_end_date'],
                'qte_vendue'       => (int)$row['qte_vendue'],
                'ca_genere'        => round((float)$row['ca_genere'], 3),
                'economies_donnees'=> round((float)$row['economies_donnees'], 3),
            ];
        }
    }


    // ===== PROMOS SANS VENTE depuis >7j (candidats à retirer) =====
    $q_nosale = "
        SELECT 
            p.id, p.titre, p.photo, p.prix_vente, p.prix_promo, p.is_flash,
            p.promo_end_date,
            DATEDIFF(NOW(), COALESCE(p.promo_end_date, NOW())) as days_left
        FROM produits p
        WHERE p.prix_promo > 0 
        AND (p.promo_end_date IS NULL OR p.promo_end_date > NOW())
        AND p.id NOT IN (
            SELECT DISTINCT lc.id_produit 
            FROM ligne_commande lc
            JOIN commandes c ON c.id = lc.idcommande
            WHERE c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))
        )
        ORDER BY p.id DESC
        LIMIT 5
    ";
    $res = executeRequete($q_nosale);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $remise_pct = $row['prix_vente'] > 0 ? round((($row['prix_vente'] - $row['prix_promo']) / $row['prix_vente']) * 100) : 0;
            $data['no_sale_promos'][] = [
                'id'             => (int)$row['id'],
                'titre'          => htmlspecialchars($row['titre']),
                'photo'          => htmlspecialchars($row['photo'] ?? ''),
                'prix_vente'     => (float)$row['prix_vente'],
                'prix_promo'     => (float)$row['prix_promo'],
                'remise_pct'     => $remise_pct,
                'is_flash'       => (int)$row['is_flash'],
                'promo_end_date' => $row['promo_end_date'],
            ];
        }
    }


    // ===== PROMOS EXPIRANT DANS LES 48H =====
    $q_expiring = "
        SELECT id, titre, photo, prix_promo, promo_end_date, is_flash
        FROM produits
        WHERE prix_promo > 0 
        AND promo_end_date IS NOT NULL 
        AND promo_end_date > NOW()
        AND promo_end_date <= DATE_ADD(NOW(), INTERVAL 48 HOUR)
        ORDER BY promo_end_date ASC
        LIMIT 5
    ";
    $res = executeRequete($q_expiring);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data['expiring_soon'][] = [
                'id'             => (int)$row['id'],
                'titre'          => htmlspecialchars($row['titre']),
                'photo'          => htmlspecialchars($row['photo'] ?? ''),
                'prix_promo'     => (float)$row['prix_promo'],
                'promo_end_date' => $row['promo_end_date'],
                'is_flash'       => (int)$row['is_flash'],
                'end_ts'         => strtotime($row['promo_end_date']),
            ];
        }
    }


    // ===== PERFORMANCE CODES PROMO =====
    $q_codes = "
        SELECT id, code, valeur, type, libelle, utilisations, date_expiration, etat
        FROM codes_promo
        ORDER BY utilisations DESC
        LIMIT 10
    ";
    $res = executeRequete($q_codes);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data['codes_perf'][] = [
                'id'              => (int)$row['id'],
                'code'            => htmlspecialchars($row['code']),
                'valeur'          => (float)$row['valeur'],
                'type'            => $row['type'],
                'libelle'         => htmlspecialchars($row['libelle'] ?? ''),
                'nb_utilisations' => (int)$row['utilisations'],
                'date_expiration' => $row['date_expiration'],
                'etat'            => (int)$row['etat'],
                'expire_ts'       => $row['date_expiration'] ? strtotime($row['date_expiration']) : null,
            ];
        }
    }



    // ===== CHART CA PROMO vs TOTAL (30 derniers jours) =====
    $q_chart = "
        SELECT 
            DATE(FROM_UNIXTIME(c.date)) as jour,
            SUM(c.total) as ca_total,
            SUM(CASE WHEN p.prix_promo > 0 THEN lc.quantite * lc.prix ELSE 0 END) as ca_promo
        FROM commandes c
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        LEFT JOIN ligne_commande lc ON lc.idcommande = c.id
        LEFT JOIN produits p ON p.id = lc.id_produit
        WHERE c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
        AND LOWER(IFNULL(ec.etat,'')) NOT LIKE '%annul%'
        GROUP BY DATE(FROM_UNIXTIME(c.date))
        ORDER BY jour ASC
    ";
    $res = executeRequete($q_chart);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $date_obj = date_create($row['jour']);
            $data['charts']['ca_promo_vs_total']['labels'][] = date_format($date_obj, 'd/m');
            $data['charts']['ca_promo_vs_total']['total'][]  = (float)$row['ca_total'];
            $data['charts']['ca_promo_vs_total']['promo'][]  = (float)$row['ca_promo'];
        }
    }


    // ===== DONUT Flash vs Classique (ventes période) =====
    $q_donut_flash = "
        SELECT SUM(lc.quantite) as qte
        FROM ligne_commande lc
        JOIN produits p ON p.id = lc.id_produit
        JOIN commandes c ON c.id = lc.idcommande
        WHERE p.is_flash = 1 AND p.prix_promo > 0
        AND c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
    ";
    $q_donut_classic = "
        SELECT SUM(lc.quantite) as qte
        FROM ligne_commande lc
        JOIN produits p ON p.id = lc.id_produit
        JOIN commandes c ON c.id = lc.idcommande
        WHERE p.is_flash = 0 AND p.prix_promo > 0
        AND c.date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL {$period} DAY))
    ";
    $res_flash = executeRequete($q_donut_flash);
    $res_classic = executeRequete($q_donut_classic);
    $qte_flash = ($res_flash && $r = mysqli_fetch_assoc($res_flash)) ? (int)$r['qte'] : 0;
    $qte_classic = ($res_classic && $r = mysqli_fetch_assoc($res_classic)) ? (int)$r['qte'] : 0;
    $data['charts']['donut_flash'] = [
        'labels' => ['⚡ Vente Flash', '🏷️ Promo Classique'],
        'data'   => [$qte_flash, $qte_classic]
    ];

} catch (Exception $e) {
    $data['error'] = $e->getMessage();
}

$json_output = json_encode($data, JSON_UNESCAPED_UNICODE);
@file_put_contents($cache_file, $json_output);
echo $json_output;
