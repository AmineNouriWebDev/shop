<?php
/**
 * api/badges.php — Endpoint JSON pour les badges du layout admin
 * Retourne le nombre de commandes en attente, messages non lus,
 * et les dernières commandes pour le dropdown de notifications.
 */

// Sécurité : admin uniquement
include("../includes/session_config.php");
if (!isset($_SESSION['editor_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

// Chargement de la DB
include("../../connec.php");
include("../includes/fonctions/fction_db.php");

$response = [
    'commandes'         => 0,
    'messages'          => 0,
    'recent_commandes'  => []
];

// ── Commandes en attente (état 1 = en attente)
$res1 = executeRequete("SELECT COUNT(*) as nb FROM `commandes` WHERE `etat` = 1");
if ($res1) {
    $row1 = mysqli_fetch_assoc($res1);
    $response['commandes'] = (int)($row1['nb'] ?? 0);
}

// ── Messages non lus (pas de champ `lu` => on retourne le total)
$res2 = executeRequete("SELECT COUNT(*) as nb FROM `messages`");
if ($res2) {
    $row2 = mysqli_fetch_assoc($res2);
    // On retourne 0 pour éviter le badge si le champ `lu` n'existe pas
    // Changer en $row2['nb'] si vous ajoutez un champ `lu`
    $response['messages'] = 0;
}

// ── 5 dernières commandes pour le dropdown notifications
$res3 = executeRequete("
    SELECT c.id,
           CONCAT(COALESCE(c.prenom,''), ' ', COALESCE(c.nom,'')) as client,
           c.total,
           DATE_FORMAT(FROM_UNIXTIME(c.date), '%d/%m %H:%i') as date,
           ec.etat as libelle_etat
    FROM commandes c
    LEFT JOIN etat_commandes ec ON ec.id = c.etat
    ORDER BY c.date DESC
    LIMIT 5
");

$recent = [];
if ($res3) {
    while ($row = mysqli_fetch_assoc($res3)) {
        $recent[] = [
            'id'     => (int)$row['id'],
            'client' => trim(htmlspecialchars($row['client'])),
            'total'  => number_format((float)$row['total'], 3, '.', ''),
            'date'   => $row['date'],
            'etat'   => htmlspecialchars($row['libelle_etat'] ?? '')
        ];
    }
}
$response['recent_commandes'] = $recent;

echo json_encode($response, JSON_UNESCAPED_UNICODE);
