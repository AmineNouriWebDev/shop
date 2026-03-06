<?php
/**
 * api/dashboard.php — Endpoint JSON complet pour le Dashboard Admin
 * Retourne les KPIs, dernières commandes, derniers messages, top produits et données pour graphiques.
 */

include("../includes/session_config.php");
if (!isset($_SESSION['editor_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

// --- SYSTÈME DE CACHE (60 secondes) ---
$cache_file = __DIR__ . '/../sessions/cache_dashboard.json';
$cache_time = 60; // durée en secondes

// Si le cache existe et n'est pas expiré, on le renvoie directement
if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    echo file_get_contents($cache_file);
    exit;
}
// --------------------------------------

include("../../connec.php");
include("../includes/fonctions/fction_db.php");

$data = [
    'kpis' => [
        'total_commandes' => 0,
        'commandes_jour'  => 0,
        'ca_mois'         => 0,
        'produits_actifs' => 0,
        'clients_actifs'  => 0,
        'messages_total'  => 0
    ],
    'recent_commandes' => [],
    'recent_messages'  => [],
    'top_produits'     => [],
    'charts' => [
        'ventes_30j' => ['labels' => [], 'data' => []],
        'repartition_statuts' => ['labels' => [], 'data' => []]
    ],
    'error' => null
];

try {
    // 1. KPIs
    $res = executeRequete("SELECT COUNT(*) as nb FROM commandes");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['total_commandes'] = (int)$row['nb'];

    $res = executeRequete("SELECT COUNT(*) as nb FROM commandes WHERE DATE(FROM_UNIXTIME(date)) = CURDATE()");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['commandes_jour'] = (int)$row['nb'];

    $res = executeRequete("SELECT SUM(total) as ca FROM commandes WHERE MONTH(FROM_UNIXTIME(date)) = MONTH(CURDATE()) AND YEAR(FROM_UNIXTIME(date)) = YEAR(CURDATE())");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['ca_mois'] = (float)($row['ca'] ?? 0);

    $res = executeRequete("SELECT COUNT(*) as nb FROM produits WHERE etat = 1");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['produits_actifs'] = (int)$row['nb'];

    $res = executeRequete("SELECT COUNT(*) as nb FROM clients WHERE etat = 1");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['clients_actifs'] = (int)$row['nb'];

    $res = executeRequete("SELECT COUNT(*) as nb FROM messages");
    if($res && $row = mysqli_fetch_assoc($res)) $data['kpis']['messages_total'] = (int)$row['nb'];

    // 2. Dernières Commandes (10)
    $q_cmd = "SELECT c.id, c.nom, c.prenom, c.total, c.date, ec.etat as libelle_etat, c.etat as id_etat
              FROM commandes c
              LEFT JOIN etat_commandes ec ON ec.id = c.etat
              ORDER BY c.date DESC LIMIT 10";
    $res = executeRequete($q_cmd);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data['recent_commandes'][] = [
                'id' => (int)$row['id'],
                'client' => trim(htmlspecialchars($row['prenom'] . ' ' . $row['nom'])),
                'total' => number_format((float)$row['total'], 3, '.', ''),
                'date' => date('d/m/Y H:i', (int)$row['date']),
                'etat' => htmlspecialchars($row['libelle_etat'] ?? 'Inconnu'),
                'id_etat' => (int)$row['id_etat']
            ];
        }
    }

    // 3. Derniers Messages (5)
    $q_msg = "SELECT id, nom, prenom, sujet, date FROM messages ORDER BY date DESC LIMIT 5";
    $res = executeRequete($q_msg);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data['recent_messages'][] = [
                'id' => (int)$row['id'],
                'expediteur' => trim(htmlspecialchars($row['prenom'] . ' ' . $row['nom'])),
                'sujet' => htmlspecialchars($row['sujet'] ?? ''),
                'date' => date('d/m/Y', strtotime($row['date'])) // ou (int)$row['date'] si timestamp
            ];
        }
    }

    // 4. Top Produits Vendus (5)
    $q_top = "SELECT p.id, p.titre, p.photo, SUM(lc.quantite) as qte_vendue, SUM(lc.quantite * p.prix_vente) as revenu
              FROM ligne_commande lc
              JOIN produits p ON p.id = lc.id_produit
              GROUP BY lc.id_produit
              ORDER BY qte_vendue DESC LIMIT 5";
    $res = executeRequete($q_top);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $photo = $row['photo'] ? htmlspecialchars($row['photo']) : 'default.jpg';
            $data['top_produits'][] = [
                'id' => (int)$row['id'],
                'titre' => htmlspecialchars($row['titre']),
                'photo' => $photo,
                'qte_vendue' => (int)$row['qte_vendue'],
                'revenu' => number_format((float)$row['revenu'], 3, '.', '')
            ];
        }
    }

    // 5. Chart : Ventes 30 derniers jours (CA par jour)
    $q_chart_30j = "
        SELECT DATE(FROM_UNIXTIME(date)) as jour, SUM(total) as ca
        FROM commandes
        WHERE date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 DAY))
        GROUP BY jour
        ORDER BY jour ASC
    ";
    $res = executeRequete($q_chart_30j);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Formater date pour l'affichage (jj/mm)
            $date_obj = date_create($row['jour']);
            $data['charts']['ventes_30j']['labels'][] = date_format($date_obj, 'd/m');
            $data['charts']['ventes_30j']['data'][] = (float)$row['ca'];
        }
    }

    // 6. Chart : Répartition par Statut
    $q_chart_statut = "
        SELECT ec.etat as libelle_etat, COUNT(c.id) as nb
        FROM commandes c
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        GROUP BY c.etat
    ";
    $res = executeRequete($q_chart_statut);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $libelle = $row['libelle_etat'] ?? 'Inconnu';
            $data['charts']['repartition_statuts']['labels'][] = htmlspecialchars($libelle);
            $data['charts']['repartition_statuts']['data'][] = (int)$row['nb'];
        }
    }

} catch (Exception $e) {
    $data['error'] = $e->getMessage();
}

$json_output = json_encode($data, JSON_UNESCAPED_UNICODE);

// --- SAUVEGARDE EN CACHE ---
if (!isset($data['error'])) {
    @file_put_contents($cache_file, $json_output);
}
// ---------------------------

echo $json_output;
