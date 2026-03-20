<?php
/**
 * api/export_ventes_data.php
 * Retourne un JSON avec toutes les données de ventes pour un mois/année donné
 * Input: ?mois=03&annee=2026
 */

include("../includes/session_config.php");
if (!isset($_SESSION['editor_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

include("../../connec.php");
include("../includes/fonctions/fction_db.php");

// ─── Mode : liste des mois disponibles ──────────────────────────
if (isset($_GET['mode']) && $_GET['mode'] === 'mois') {
    $q = "
        SELECT
            YEAR(FROM_UNIXTIME(c.date))  AS annee,
            MONTH(FROM_UNIXTIME(c.date)) AS mois,
            COUNT(c.id)                  AS nb_commandes,
            SUM(c.total)                 AS ca_total
        FROM commandes c
        LEFT JOIN etat_commandes ec ON ec.id = c.etat
        WHERE LOWER(IFNULL(ec.etat,'')) LIKE '%pay%'
        GROUP BY annee, mois
        ORDER BY annee DESC, mois DESC
    ";
    $res = executeRequete($q);
    $mois_fr = ['', 'Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    $liste = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $liste[] = [
            'value'  => $row['annee'] . '-' . str_pad($row['mois'], 2, '0', STR_PAD_LEFT),
            'label'  => $mois_fr[(int)$row['mois']] . ' ' . $row['annee'],
            'mois'   => (int)$row['mois'],
            'annee'  => (int)$row['annee'],
            'nb'     => (int)$row['nb_commandes'],
            'ca'     => (float)$row['ca_total']
        ];
    }
    echo json_encode($liste, JSON_UNESCAPED_UNICODE);
    exit;
}

// ─── Mode : données d'un mois spécifique ────────────────────────
$mois  = isset($_GET['mois'])  ? (int)$_GET['mois']  : (int)date('m');
$annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');

if ($mois < 1 || $mois > 12 || $annee < 2000) {
    echo json_encode(['error' => 'Paramètres invalides']); exit;
}

$mois_fr = ['', 'Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

$data = [
    'mois'        => $mois,
    'annee'       => $annee,
    'label'       => $mois_fr[$mois] . ' ' . $annee,
    'resume'      => [],
    'commandes'   => [],
    'top_produits'=> [],
    'par_jour'    => []
];

// 1. Résumé du mois
$q_resume = "
    SELECT
        COUNT(c.id)                  AS nb_commandes,
        SUM(c.total)                 AS ca_total,
        AVG(c.total)                 AS panier_moyen,
        SUM(c.frais_livraison)       AS total_frais_livraison,
        COUNT(DISTINCT c.idclient)   AS nb_clients_uniques
    FROM commandes c
    LEFT JOIN etat_commandes ec ON ec.id = c.etat
    WHERE MONTH(FROM_UNIXTIME(c.date)) = $mois
      AND YEAR(FROM_UNIXTIME(c.date))  = $annee
      AND LOWER(IFNULL(ec.etat,'')) LIKE '%pay%'
";
$res = executeRequete($q_resume);
if ($res && $row = mysqli_fetch_assoc($res)) {
    $data['resume'] = [
        'Nombre de commandes payées' => (int)$row['nb_commandes'],
        'Chiffre d\'affaires (TND)'  => number_format((float)$row['ca_total'], 3, '.', ''),
        'Panier moyen (TND)'         => number_format((float)$row['panier_moyen'], 3, '.', ''),
        'Frais de livraison (TND)'   => number_format((float)$row['total_frais_livraison'], 3, '.', ''),
        'Clients uniques'            => (int)$row['nb_clients_uniques'],
    ];
}

// 2. Détail commandes payées
$q_cmd = "
    SELECT c.id, c.nom, c.prenom, c.email, c.tel,
           c.total, c.sous_total, c.frais_livraison,
           DATE(FROM_UNIXTIME(c.date)) as date_cmd,
           ec.etat as statut
    FROM commandes c
    LEFT JOIN etat_commandes ec ON ec.id = c.etat
    WHERE MONTH(FROM_UNIXTIME(c.date)) = $mois
      AND YEAR(FROM_UNIXTIME(c.date))  = $annee
      AND LOWER(IFNULL(ec.etat,'')) LIKE '%pay%'
    ORDER BY c.date ASC
";
$res = executeRequete($q_cmd);
while ($row = mysqli_fetch_assoc($res)) {
    $data['commandes'][] = [
        'N° Commande'      => '#' . $row['id'],
        'Date'             => $row['date_cmd'],
        'Client'           => trim($row['nom'] . ' ' . $row['prenom']),
        'Email'            => $row['email'] ?? '',
        'Téléphone'        => $row['tel'] ?? '',
        'Sous-total (TND)' => (float)$row['sous_total'],
        'Livraison (TND)'  => (float)$row['frais_livraison'],
        'Total (TND)'      => (float)$row['total'],
        'Statut'           => $row['statut'],
    ];
}

// 3. Top produits du mois
$q_top = "
    SELECT p.titre, SUM(lc.quantite) as qte_vendue,
           SUM(lc.quantite * p.prix_vente) as revenu
    FROM ligne_commande lc
    JOIN produits p ON p.id = lc.id_produit
    JOIN commandes c ON c.id = lc.idcommande
    LEFT JOIN etat_commandes ec ON ec.id = c.etat
    WHERE MONTH(FROM_UNIXTIME(c.date)) = $mois
      AND YEAR(FROM_UNIXTIME(c.date))  = $annee
      AND LOWER(IFNULL(ec.etat,'')) LIKE '%pay%'
    GROUP BY lc.id_produit
    ORDER BY qte_vendue DESC
    LIMIT 20
";
$res = executeRequete($q_top);
$rank = 1;
while ($row = mysqli_fetch_assoc($res)) {
    $data['top_produits'][] = [
        'Rang'              => $rank++,
        'Produit'           => $row['titre'],
        'Quantité vendue'   => (int)$row['qte_vendue'],
        'Revenu (TND)'      => number_format((float)$row['revenu'], 3, '.', ''),
    ];
}

// 4. CA par jour (pour graph ou colonne)
$q_jour = "
    SELECT DATE(FROM_UNIXTIME(c.date)) as jour, COUNT(c.id) as nb, SUM(c.total) as ca
    FROM commandes c
    LEFT JOIN etat_commandes ec ON ec.id = c.etat
    WHERE MONTH(FROM_UNIXTIME(c.date)) = $mois
      AND YEAR(FROM_UNIXTIME(c.date))  = $annee
      AND LOWER(IFNULL(ec.etat,'')) LIKE '%pay%'
    GROUP BY jour
    ORDER BY jour ASC
";
$res = executeRequete($q_jour);
while ($row = mysqli_fetch_assoc($res)) {
    $data['par_jour'][] = [
        'Date'               => $row['jour'],
        'Nb commandes'       => (int)$row['nb'],
        'CA du jour (TND)'   => (float)$row['ca'],
    ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
