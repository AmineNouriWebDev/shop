<?php
/**
 * includes/stats_commandes.php — Tableau de bord Décisionnel & Statistiques des Commandes
 * Offipro Shop Admin
 */

// Sécurité
if (!isset($_SESSION['editor_id'])) {
    echo '<div class="alert alert-danger">Accès réservé aux administrateurs.</div>';
    exit;
}

// -------------------------------------------------------------
// 1. GESTION DES FILTRES DE PÉRIODE
// -------------------------------------------------------------
$periode = $_GET['periode'] ?? 'tout';
$date_debut_raw = $_GET['date_debut'] ?? '';
$date_fin_raw   = $_GET['date_fin'] ?? '';

$now = time();
$start_ts = 0;
$end_ts = $now + 86400; // inclure fin de journée
$periode_label = "Tout l'historique";

switch ($periode) {
    case 'aujourdhui':
        $start_ts = strtotime('today 00:00:00');
        $end_ts   = strtotime('today 23:59:59');
        $periode_label = "Aujourd'hui (" . date('d/m/Y') . ")";
        break;
    case '7j':
        $start_ts = strtotime('-7 days 00:00:00');
        $end_ts   = $now;
        $periode_label = "7 derniers jours";
        break;
    case '30j':
        $start_ts = strtotime('-30 days 00:00:00');
        $end_ts   = $now;
        $periode_label = "30 derniers jours";
        break;
    case 'ce_mois':
        $start_ts = strtotime('first day of this month 00:00:00');
        $end_ts   = $now;
        $periode_label = "Ce mois-ci (" . strftime('%B %Y') . ")";
        break;
    case 'cette_annee':
        $start_ts = strtotime('first day of january this year 00:00:00');
        $end_ts   = $now;
        $periode_label = "Cette année (" . date('Y') . ")";
        break;
    case 'custom':
        if (!empty($date_debut_raw) && !empty($date_fin_raw)) {
            $start_ts = strtotime($date_debut_raw . ' 00:00:00');
            $end_ts   = strtotime($date_fin_raw . ' 23:59:59');
            $periode_label = "Du " . date('d/m/Y', $start_ts) . " au " . date('d/m/Y', $end_ts);
        } else {
            $periode = 'tout';
            $periode_label = "Tout l'historique";
        }
        break;
    case 'tout':
    default:
        $periode = 'tout';
        $start_ts = 0;
        $end_ts   = $now + 86400;
        $periode_label = "Tout l'historique";
        break;
}

$where_period_cmd = "";
if ($start_ts > 0) {
    $where_period_cmd = " AND cmd.date >= '$start_ts' AND cmd.date <= '$end_ts' ";
}

// -------------------------------------------------------------
// 2. EXTRACTION DES KPIS GLOBAUX
// -------------------------------------------------------------
$kpi_query = "SELECT 
    COUNT(cmd.id) as total_cmd,
    COUNT(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN 1 END) as cmd_valides,
    COUNT(CASE WHEN cmd.etat = 4 THEN 1 END) as cmd_annulees,
    COUNT(CASE WHEN cmd.etat = 8 THEN 1 END) as cmd_retours,
    COUNT(CASE WHEN cmd.etat = 1 THEN 1 END) as cmd_attente,
    COUNT(CASE WHEN cmd.etat = 2 THEN 1 END) as cmd_expediees,
    COUNT(CASE WHEN cmd.etat = 3 THEN 1 END) as cmd_traitement,
    COUNT(CASE WHEN cmd.etat = 9 THEN 1 END) as cmd_payees,
    SUM(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN cmd.total ELSE 0 END) as ca_valide,
    SUM(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN cmd.total ELSE 0 END) as ca_perdu,
    SUM(cmd.total) as ca_brut_total
FROM commandes cmd
WHERE 1=1 $where_period_cmd";

$kpi_res = executeRequete($kpi_query);
$kpis = mysqli_fetch_assoc($kpi_res);

$total_cmd    = intval($kpis['total_cmd'] ?? 0);
$cmd_valides  = intval($kpis['cmd_valides'] ?? 0);
$cmd_annulees = intval($kpis['cmd_annulees'] ?? 0);
$cmd_retours  = intval($kpis['cmd_retours'] ?? 0);
$total_pertes_cmd = $cmd_annulees + $cmd_retours;

$ca_valide    = floatval($kpis['ca_valide'] ?? 0);
$ca_perdu     = floatval($kpis['ca_perdu'] ?? 0);
$ca_brut      = floatval($kpis['ca_brut_total'] ?? 0);

$taux_annulation = ($total_cmd > 0) ? round(($total_pertes_cmd / $total_cmd) * 100, 1) : 0;
$taux_succes     = ($total_cmd > 0) ? round(($cmd_valides / $total_cmd) * 100, 1) : 0;
$panier_moyen    = ($cmd_valides > 0) ? round($ca_valide / $cmd_valides, 3) : 0;

// Total articles vendus
$qty_query = "SELECT SUM(lc.quantite) as total_articles
              FROM ligne_commande lc
              INNER JOIN commandes cmd ON lc.idcommande = cmd.id
              WHERE cmd.etat != 4 AND cmd.etat != 8 $where_period_cmd";
$qty_res = executeRequete($qty_query);
$qty_row = mysqli_fetch_assoc($qty_res);
$total_articles_vendus = intval($qty_row['total_articles'] ?? 0);

// -------------------------------------------------------------
// 3. COURBE CHRONOLOGIQUE (Évolution Ventes & CA vs Annulations)
// -------------------------------------------------------------
$is_daily_view = ($periode === 'aujourdhui' || $periode === '7j' || $periode === '30j' || ($periode === 'custom' && ($end_ts - $start_ts) <= (45 * 86400)));

if ($is_daily_view && $periode === 'aujourdhui') {
    // Par heure
    $sql_timeline = "SELECT 
        HOUR(FROM_UNIXTIME(cmd.date)) as periode_key,
        CONCAT(HOUR(FROM_UNIXTIME(cmd.date)), 'h') as label,
        COUNT(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN 1 END) as nb_valides,
        COUNT(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN 1 END) as nb_annulees,
        SUM(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN cmd.total ELSE 0 END) as ca_total
    FROM commandes cmd
    WHERE 1=1 $where_period_cmd
    GROUP BY periode_key, label
    ORDER BY periode_key ASC";
} elseif ($is_daily_view) {
    // Par jour
    $sql_timeline = "SELECT 
        DATE(FROM_UNIXTIME(cmd.date)) as periode_key,
        DATE_FORMAT(FROM_UNIXTIME(cmd.date), '%d/%m') as label,
        COUNT(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN 1 END) as nb_valides,
        COUNT(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN 1 END) as nb_annulees,
        SUM(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN cmd.total ELSE 0 END) as ca_total
    FROM commandes cmd
    WHERE 1=1 $where_period_cmd
    GROUP BY periode_key, label
    ORDER BY periode_key ASC";
} else {
    // Par mois
    $sql_timeline = "SELECT 
        DATE_FORMAT(FROM_UNIXTIME(cmd.date), '%Y-%m') as periode_key,
        DATE_FORMAT(FROM_UNIXTIME(cmd.date), '%b %Y') as label,
        COUNT(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN 1 END) as nb_valides,
        COUNT(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN 1 END) as nb_annulees,
        SUM(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN cmd.total ELSE 0 END) as ca_total
    FROM commandes cmd
    WHERE 1=1 $where_period_cmd
    GROUP BY periode_key, label
    ORDER BY periode_key ASC";
}

$timeline_res = executeRequete($sql_timeline);
$chart_labels = [];
$chart_ca_data = [];
$chart_valides_data = [];
$chart_annulees_data = [];

while ($t = mysqli_fetch_assoc($timeline_res)) {
    $chart_labels[] = $t['label'];
    $chart_ca_data[] = floatval($t['ca_total'] ?? 0);
    $chart_valides_data[] = intval($t['nb_valides'] ?? 0);
    $chart_annulees_data[] = intval($t['nb_annulees'] ?? 0);
}

// -------------------------------------------------------------
// 4. RÉPARTITION PAR STATUT (Donut Chart)
// -------------------------------------------------------------
$sql_statuts = "SELECT 
    e.id, 
    e.etat as label, 
    COUNT(cmd.id) as count,
    COALESCE(SUM(cmd.total), 0) as ca
FROM etat_commandes e
LEFT JOIN commandes cmd ON (e.id = cmd.etat $where_period_cmd)
GROUP BY e.id, e.etat
ORDER BY count DESC";

$statuts_res = executeRequete($sql_statuts);
$statuts_labels = [];
$statuts_counts = [];
$statuts_colors = [
    1 => '#3b82f6', // En attente (Bleu)
    2 => '#10b981', // Expédiée (Vert)
    3 => '#06b6d4', // Traitement (Cyan)
    4 => '#ef4444', // Annulée (Rouge)
    8 => '#f97316', // Retour colis (Orange)
    9 => '#8b5cf6'  // Payée (Violet)
];
$statuts_chart_colors = [];
$statuts_list = [];

while ($s = mysqli_fetch_assoc($statuts_res)) {
    $statuts_labels[] = $s['label'];
    $cnt = intval($s['count'] ?? 0);
    $statuts_counts[] = $cnt;
    $statuts_chart_colors[] = $statuts_colors[$s['id']] ?? '#94a3b8';
    $statuts_list[] = [
        'id'    => $s['id'],
        'label' => $s['label'],
        'count' => $cnt,
        'ca'    => floatval($s['ca'] ?? 0),
        'pct'   => ($total_cmd > 0) ? round(($cnt / $total_cmd) * 100, 1) : 0,
        'color' => $statuts_colors[$s['id']] ?? '#94a3b8'
    ];
}

// -------------------------------------------------------------
// 5. COMPORTEMENT : JOURS ET HEURES DE COMMANDE
// -------------------------------------------------------------
$sql_dow = "SELECT 
    DAYOFWEEK(FROM_UNIXTIME(cmd.date)) as dw, 
    COUNT(*) as nb 
FROM commandes cmd 
WHERE cmd.date > 0 $where_period_cmd
GROUP BY dw 
ORDER BY dw ASC";
$dow_res = executeRequete($sql_dow);
$dow_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0]; // 1=Dim, 2=Lun... 7=Sam
while ($dw_row = mysqli_fetch_assoc($dow_res)) {
    $dow_counts[intval($dw_row['dw'])] = intval($dw_row['nb']);
}
$dow_labels = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
$dow_data   = [$dow_counts[1], $dow_counts[2], $dow_counts[3], $dow_counts[4], $dow_counts[5], $dow_counts[6], $dow_counts[7]];

// Heures de pointe
$sql_hours = "SELECT 
    HOUR(FROM_UNIXTIME(cmd.date)) as hr, 
    COUNT(*) as nb 
FROM commandes cmd 
WHERE cmd.date > 0 $where_period_cmd
GROUP BY hr 
ORDER BY hr ASC";
$hours_res = executeRequete($sql_hours);
$hours_data = array_fill(0, 24, 0);
while ($h_row = mysqli_fetch_assoc($hours_res)) {
    $hours_data[intval($h_row['hr'])] = intval($h_row['nb']);
}
$hours_labels = [];
for ($h = 0; $h < 24; $h++) { $hours_labels[] = $h . 'h'; }

// Trouver le jour et l'heure pic
$peak_day_index = array_search(max($dow_data), $dow_data);
$peak_day_name = $dow_labels[$peak_day_index] ?? 'Samedi';
$peak_hour = array_search(max($hours_data), $hours_data);

// -------------------------------------------------------------
// 6. TOP 20 PRODUITS LES PLUS COMMANDÉS
// -------------------------------------------------------------
$sql_top_prods = "SELECT 
    lc.id_produit,
    COALESCE(NULLIF(lc.nom_produit, ''), p.titre, CONCAT('Produit #', lc.id_produit)) as titre,
    p.photo,
    p.prix_vente,
    p.quantite as stock_actuel,
    c.titre as categ_nom,
    SUM(lc.quantite) as total_qty,
    COUNT(DISTINCT lc.idcommande) as total_orders,
    SUM(lc.prix * lc.quantite) as total_ca
FROM ligne_commande lc
INNER JOIN commandes cmd ON lc.idcommande = cmd.id
LEFT JOIN produits p ON lc.id_produit = p.id
LEFT JOIN categories_blog c ON p.categorie = c.id
WHERE cmd.etat != 4 AND cmd.etat != 8 $where_period_cmd
GROUP BY lc.id_produit, titre, p.photo, p.prix_vente, p.quantite, c.titre
ORDER BY total_qty DESC, total_ca DESC
LIMIT 20";

$top_prods_res = executeRequete($sql_top_prods);
$top_prods = [];
while ($tp = mysqli_fetch_assoc($top_prods_res)) {
    $tp['ca_pct'] = ($ca_valide > 0) ? round((floatval($tp['total_ca']) / $ca_valide) * 100, 1) : 0;
    $top_prods[] = $tp;
}

// -------------------------------------------------------------
// 7. PRODUITS LES PLUS ANNULÉS (Alertes, Manque à gagner)
// -------------------------------------------------------------
$sql_cancel_prods = "SELECT 
    lc.id_produit,
    COALESCE(NULLIF(lc.nom_produit, ''), p.titre, CONCAT('Produit #', lc.id_produit)) as titre,
    p.photo,
    c.titre as categ_nom,
    SUM(lc.quantite) as total_demand_qty,
    SUM(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN lc.quantite ELSE 0 END) as annule_qty,
    SUM(CASE WHEN cmd.etat != 4 AND cmd.etat != 8 THEN lc.quantite ELSE 0 END) as valide_qty,
    SUM(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN (lc.prix * lc.quantite) ELSE 0 END) as ca_perdu,
    ROUND((SUM(CASE WHEN cmd.etat = 4 OR cmd.etat = 8 THEN lc.quantite ELSE 0 END) / SUM(lc.quantite)) * 100, 1) as taux_annulation
FROM ligne_commande lc
INNER JOIN commandes cmd ON lc.idcommande = cmd.id
LEFT JOIN produits p ON lc.id_produit = p.id
LEFT JOIN categories_blog c ON p.categorie = c.id
WHERE 1=1 $where_period_cmd
GROUP BY lc.id_produit, titre, p.photo, c.titre
HAVING annule_qty > 0
ORDER BY annule_qty DESC, ca_perdu DESC
LIMIT 20";

$cancel_prods_res = executeRequete($sql_cancel_prods);
$cancel_prods = [];
while ($cp = mysqli_fetch_assoc($cancel_prods_res)) {
    $cancel_prods[] = $cp;
}

// -------------------------------------------------------------
// 8. FAMILLES & CATÉGORIES LES PLUS DEMANDÉES
// -------------------------------------------------------------
$sql_familles = "SELECT 
    COALESCE(parent_cat.id, cat.id, 0) as famille_id,
    COALESCE(parent_cat.titre, cat.titre, 'Non catégorisé') as famille_titre,
    COUNT(DISTINCT cmd.id) as total_orders,
    SUM(lc.quantite) as total_qty,
    SUM(lc.prix * lc.quantite) as total_ca
FROM ligne_commande lc
INNER JOIN commandes cmd ON lc.idcommande = cmd.id
LEFT JOIN produits p ON lc.id_produit = p.id
LEFT JOIN categories_blog cat ON p.categorie = cat.id
LEFT JOIN categories_blog parent_cat ON (cat.idparent > 0 AND cat.idparent = parent_cat.id)
WHERE cmd.etat != 4 AND cmd.etat != 8 $where_period_cmd
GROUP BY famille_id, famille_titre
ORDER BY total_ca DESC
LIMIT 12";

$familles_res = executeRequete($sql_familles);
$familles_list = [];
$familles_chart_labels = [];
$familles_chart_ca = [];

while ($f = mysqli_fetch_assoc($familles_res)) {
    $f['ca_pct'] = ($ca_valide > 0) ? round((floatval($f['total_ca']) / $ca_valide) * 100, 1) : 0;
    $f['panier_moyen'] = ($f['total_orders'] > 0) ? round(floatval($f['total_ca']) / intval($f['total_orders']), 2) : 0;
    $familles_list[] = $f;
    $familles_chart_labels[] = $f['famille_titre'];
    $familles_chart_ca[] = floatval($f['total_ca']);
}

// Top 5 sous-catégories
$sql_subcategs = "SELECT 
    COALESCE(cat.id, 0) as cat_id,
    COALESCE(cat.titre, 'Non catégorisé') as cat_titre,
    COALESCE(parent_cat.titre, 'Racine') as parent_titre,
    SUM(lc.quantite) as total_qty,
    COUNT(DISTINCT cmd.id) as total_orders,
    SUM(lc.prix * lc.quantite) as total_ca
FROM ligne_commande lc
INNER JOIN commandes cmd ON lc.idcommande = cmd.id
LEFT JOIN produits p ON lc.id_produit = p.id
LEFT JOIN categories_blog cat ON p.categorie = cat.id
LEFT JOIN categories_blog parent_cat ON (cat.idparent > 0 AND cat.idparent = parent_cat.id)
WHERE cmd.etat != 4 AND cmd.etat != 8 $where_period_cmd
GROUP BY cat_id, cat_titre, parent_titre
ORDER BY total_ca DESC
LIMIT 10";
$subcategs_res = executeRequete($sql_subcategs);
$subcategs_list = [];
while ($sc = mysqli_fetch_assoc($subcategs_res)) {
    $sc['ca_pct'] = ($ca_valide > 0) ? round((floatval($sc['total_ca']) / $ca_valide) * 100, 1) : 0;
    $subcategs_list[] = $sc;
}

// -------------------------------------------------------------
// 9. MOYENS DE PAIEMENT
// -------------------------------------------------------------
$sql_paiement = "SELECT 
    cmd.moyen_paiement,
    COALESCE(mp.moyen, 'Non spécifié / Direct') as moyen_titre,
    COUNT(cmd.id) as nb_cmd,
    SUM(cmd.total) as total_ca
FROM commandes cmd
LEFT JOIN moyens_paiement mp ON cmd.moyen_paiement = mp.id
WHERE cmd.etat != 4 AND cmd.etat != 8 $where_period_cmd
GROUP BY cmd.moyen_paiement, moyen_titre
ORDER BY nb_cmd DESC";
$paiement_res = executeRequete($sql_paiement);
$paiement_list = [];
while ($mp = mysqli_fetch_assoc($paiement_res)) {
    $mp['pct'] = ($cmd_valides > 0) ? round((intval($mp['nb_cmd']) / $cmd_valides) * 100, 1) : 0;
    $paiement_list[] = $mp;
}
?>

<!-- Chargement Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ============================================================== */
/* STYLES DESIGN SYSTEM STATISTIQUES COMMANDES                    */
/* ============================================================== */
:root {
    --stat-primary: #5A31F4;
    --stat-primary-rgb: 90, 49, 244;
    --stat-success: #10B981;
    --stat-danger: #EF4444;
    --stat-warning: #F59E0B;
    --stat-info: #06B6D4;
}

.stat-page-wrap {
    padding: 1.5rem 1rem;
    color: var(--color-text-primary, #1e293b);
}

/* ── Filter Bar ── */
.stat-filter-card {
    background: var(--color-bg, #ffffff);
    border: 1px solid var(--color-border, #e2e8f0);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.25rem;
}
html.dark .stat-filter-card {
    background: #1c1930;
    border-color: #3f376f;
}

.stat-period-pills {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    background: rgba(90, 49, 244, 0.05);
    padding: 4px;
    border-radius: 30px;
    border: 1px solid rgba(90, 49, 244, 0.12);
}
html.dark .stat-period-pills {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.1);
}

.stat-pill {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--color-text-muted, #64748b);
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: none;
    background: transparent;
}
.stat-pill:hover {
    color: var(--color-primary, #5A31F4);
    background: rgba(90, 49, 244, 0.08);
}
.stat-pill.active {
    background: var(--color-primary, #5A31F4);
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(90, 49, 244, 0.35);
}

/* ── KPI Cards ── */
.stat-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-kpi-card {
    background: var(--color-bg, #ffffff);
    border: 1px solid var(--color-border, #e2e8f0);
    border-radius: 14px;
    padding: 1.25rem 1.4rem;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.stat-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}
html.dark .stat-kpi-card {
    background: #1c1930;
    border-color: #3f376f;
}

.stat-kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
}
.stat-kpi-card.kpi-purple::before { background: linear-gradient(90deg, #5A31F4, #8b5cf6); }
.stat-kpi-card.kpi-green::before  { background: linear-gradient(90deg, #10B981, #34d399); }
.stat-kpi-card.kpi-red::before    { background: linear-gradient(90deg, #EF4444, #f87171); }
.stat-kpi-card.kpi-blue::before   { background: linear-gradient(90deg, #06B6D4, #38bdf8); }
.stat-kpi-card.kpi-amber::before  { background: linear-gradient(90deg, #F59E0B, #fbbf24); }

.stat-kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}
.stat-kpi-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
}
.stat-kpi-title {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--color-text-muted, #64748b);
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.stat-kpi-val {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1.2;
    color: var(--color-text-primary, #0f172a);
    margin-bottom: 0.25rem;
}
html.dark .stat-kpi-val { color: #f8fafc; }

.stat-kpi-sub {
    font-size: 0.75rem;
    color: var(--color-text-muted, #64748b);
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ── Content Grid Cards ── */
.stat-card {
    background: var(--color-bg, #ffffff);
    border: 1px solid var(--color-border, #e2e8f0);
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
html.dark .stat-card {
    background: #1c1930;
    border-color: #3f376f;
}
.stat-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 0 1.25rem 0;
    color: var(--color-text-primary, #0f172a);
}
html.dark .stat-card-title { color: #f8fafc; }

/* ── Insight Banners ── */
.insight-box {
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    border: 1px solid;
    transition: all 0.2s ease;
}
.insight-box.tip-success {
    background: rgba(16, 185, 129, 0.08);
    border-color: rgba(16, 185, 129, 0.25);
    color: #065f46;
}
html.dark .insight-box.tip-success {
    background: rgba(16, 185, 129, 0.12);
    border-color: rgba(16, 185, 129, 0.3);
    color: #34d399;
}
.insight-box.tip-warning {
    background: rgba(245, 158, 11, 0.08);
    border-color: rgba(245, 158, 11, 0.25);
    color: #92400e;
}
html.dark .insight-box.tip-warning {
    background: rgba(245, 158, 11, 0.12);
    border-color: rgba(245, 158, 11, 0.3);
    color: #fbbf24;
}
.insight-box.tip-danger {
    background: rgba(239, 68, 68, 0.08);
    border-color: rgba(239, 68, 68, 0.25);
    color: #991b1b;
}
html.dark .insight-box.tip-danger {
    background: rgba(239, 68, 68, 0.12);
    border-color: rgba(239, 68, 68, 0.3);
    color: #f87171;
}

/* ── Tables ── */
.stat-table {
    width: 100%;
    border-collapse: collapse;
}
.stat-table th {
    background: rgba(0,0,0,0.02);
    padding: 10px 14px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    color: var(--color-text-muted, #64748b);
    border-bottom: 2px solid var(--color-border, #e2e8f0);
    text-align: left;
}
html.dark .stat-table th {
    background: rgba(255,255,255,0.02);
    border-color: #3f376f;
}
.stat-table td {
    padding: 12px 14px;
    border-bottom: 1px solid var(--color-border, #e2e8f0);
    font-size: 0.85rem;
    vertical-align: middle;
}
html.dark .stat-table td {
    border-color: #3f376f;
}
.stat-table tbody tr:hover {
    background: rgba(90, 49, 244, 0.03);
}
html.dark .stat-table tbody tr:hover {
    background: rgba(255,255,255,0.02);
}

.stat-prod-img {
    width: 42px; height: 42px;
    border-radius: 8px;
    object-fit: cover;
    background: #f1f5f9;
    border: 1px solid rgba(0,0,0,0.08);
}

/* ── Badges ── */
.badge-rate {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
}
.badge-rate.good { background: rgba(16, 185, 129, 0.12); color: #059669; }
.badge-rate.warning { background: rgba(245, 158, 11, 0.15); color: #d97706; }
.badge-rate.danger { background: rgba(239, 68, 68, 0.15); color: #dc2626; }

/* ── Progress bar ── */
.progress-bar-wrap {
    background: rgba(0,0,0,0.06);
    height: 7px;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
    width: 100%;
}
html.dark .progress-bar-wrap { background: rgba(255,255,255,0.1); }
.progress-bar-fill {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg, #5A31F4, #8b5cf6);
}

/* ── Tabs for Tables ── */
.stat-nav-tabs {
    display: flex;
    gap: 4px;
    border-bottom: 2px solid var(--color-border, #e2e8f0);
    margin-bottom: 1.25rem;
}
html.dark .stat-nav-tabs { border-color: #3f376f; }

.stat-tab-btn {
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--color-text-muted, #64748b);
    border: none;
    background: none;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}
.stat-tab-btn:hover {
    color: var(--color-primary, #5A31F4);
}
.stat-tab-btn.active {
    color: var(--color-primary, #5A31F4);
    border-bottom-color: var(--color-primary, #5A31F4);
}

/* Print optimizations */
@media print {
    #main-wrapper .left-sidebar,
    .topbar,
    .stat-filter-card,
    .btn-print-hide { display: none !important; }
    .stat-page-wrap { padding: 0 !important; }
}
</style>

<div class="stat-page-wrap">

    <!-- EN-TÊTE DE LA PAGE -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size: 1.5rem;">📊</span>
                <h1 style="font-size: 1.6rem; font-weight: 800; margin: 0; letter-spacing: -0.02em;">
                    Statistiques & Analyse des Commandes
                </h1>
            </div>
            <p style="margin: 4px 0 0 0; color: var(--color-text-muted, #64748b); font-size: 0.875rem;">
                Tableau de bord décisionnel : produits les plus vendus, motifs d'annulation, familles phares et comportement des visiteurs.
            </p>
        </div>
        
        <div style="display:flex; gap:8px; align-items:center;" class="btn-print-hide">
            <button type="button" onclick="window.print()" class="admin-btn admin-btn-ghost" style="padding:0.5rem 1rem; font-size:0.8125rem; display:inline-flex; align-items:center; gap:6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/></svg>
                Imprimer le rapport
            </button>
            <a href="index.php?r=commandes" class="admin-btn admin-btn-primary" style="padding:0.5rem 1rem; font-size:0.8125rem; display:inline-flex; align-items:center; gap:6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25Z"/></svg>
                Gestion des commandes
            </a>
        </div>
    </div>

    <!-- CARTE DE FILTRE DE PÉRIODE -->
    <div class="stat-filter-card">
        <div>
            <div style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:var(--color-text-muted, #64748b); letter-spacing:0.5px; margin-bottom:6px;">
                Filtrer par Période
            </div>
            <div class="stat-period-pills">
                <a href="index.php?r=stats_commandes&periode=tout" class="stat-pill <?php if($periode=='tout') echo 'active'; ?>">Tout l'historique</a>
                <a href="index.php?r=stats_commandes&periode=cette_annee" class="stat-pill <?php if($periode=='cette_annee') echo 'active'; ?>">Cette année (<?php echo date('Y'); ?>)</a>
                <a href="index.php?r=stats_commandes&periode=ce_mois" class="stat-pill <?php if($periode=='ce_mois') echo 'active'; ?>">Ce mois-ci</a>
                <a href="index.php?r=stats_commandes&periode=30j" class="stat-pill <?php if($periode=='30j') echo 'active'; ?>">30 derniers jours</a>
                <a href="index.php?r=stats_commandes&periode=7j" class="stat-pill <?php if($periode=='7j') echo 'active'; ?>">7 derniers jours</a>
                <a href="index.php?r=stats_commandes&periode=aujourdhui" class="stat-pill <?php if($periode=='aujourdhui') echo 'active'; ?>">Aujourd'hui</a>
            </div>
        </div>

        <!-- Dates manuelles personnalisées -->
        <form method="GET" action="index.php" style="display:flex; align-items:flex-end; gap:8px; flex-wrap:wrap;">
            <input type="hidden" name="r" value="stats_commandes">
            <input type="hidden" name="periode" value="custom">
            <div>
                <label style="display:block; font-size:0.7rem; font-weight:600; color:var(--color-text-muted); margin-bottom:2px;">Du</label>
                <input type="date" name="date_debut" value="<?php echo htmlspecialchars($date_debut_raw); ?>" class="admin-input" style="padding:4px 8px; font-size:0.8rem; width:130px;" required>
            </div>
            <div>
                <label style="display:block; font-size:0.7rem; font-weight:600; color:var(--color-text-muted); margin-bottom:2px;">Au</label>
                <input type="date" name="date_fin" value="<?php echo htmlspecialchars($date_fin_raw); ?>" class="admin-input" style="padding:4px 8px; font-size:0.8rem; width:130px;" required>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="padding:6px 12px; font-size:0.8rem;">Filtrer</button>
        </form>
    </div>

    <!-- BANNER PÉRIODE ACTIVE -->
    <div style="margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(90,49,244,0.08); padding:6px 14px; border-radius:8px; font-size:0.875rem; font-weight:600; color:var(--stat-primary);">
            <span>📅 Période analysée : <strong><?php echo htmlspecialchars($periode_label); ?></strong></span>
            <span style="opacity:0.4;">|</span>
            <span><?php echo number_format($total_cmd, 0, '', ' '); ?> commande(s) enregistrée(s)</span>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- 5 KPI CARDS MAJEURS                                           -->
    <!-- ============================================================== -->
    <div class="stat-kpi-grid">
        
        <!-- KPI 1 : CA Validé -->
        <div class="stat-kpi-card kpi-purple">
            <div class="stat-kpi-header">
                <span class="stat-kpi-title">Chiffre d'Affaires Validé</span>
                <div class="stat-kpi-icon" style="background:rgba(90,49,244,0.1); color:#5A31F4;">💰</div>
            </div>
            <div class="stat-kpi-val">
                <?php echo number_format($ca_valide, 3, '.', ' '); ?> <span style="font-size:0.95rem; font-weight:600; opacity:0.6;">TND</span>
            </div>
            <div class="stat-kpi-sub">
                <span style="color:#10b981; font-weight:700;">✓ <?php echo number_format($cmd_valides); ?> cmd validées</span>
                <span>sur <?php echo number_format($ca_brut, 0, '', ' '); ?> TND brut</span>
            </div>
        </div>

        <!-- KPI 2 : Total Commandes & Conversion -->
        <div class="stat-kpi-card kpi-blue">
            <div class="stat-kpi-header">
                <span class="stat-kpi-title">Total Commandes</span>
                <div class="stat-kpi-icon" style="background:rgba(6,182,212,0.1); color:#06B6D4;">📦</div>
            </div>
            <div class="stat-kpi-val">
                <?php echo number_format($total_cmd, 0, '', ' '); ?>
            </div>
            <div class="stat-kpi-sub">
                <span style="color:#06B6D4; font-weight:700;"><?php echo $taux_succes; ?>% succès</span>
                <span>(<?php echo $cmd_valides; ?> commandes actives/livrées)</span>
            </div>
        </div>

        <!-- KPI 3 : Taux d'Annulation & Pertes -->
        <div class="stat-kpi-card kpi-red">
            <div class="stat-kpi-header">
                <span class="stat-kpi-title">Taux d'Annulation</span>
                <div class="stat-kpi-icon" style="background:rgba(239,68,68,0.1); color:#EF4444;">⚠️</div>
            </div>
            <div class="stat-kpi-val" style="color:#EF4444;">
                <?php echo $taux_annulation; ?> <span style="font-size:1.1rem; font-weight:700;">%</span>
            </div>
            <div class="stat-kpi-sub">
                <span style="color:#ef4444; font-weight:700;">-<?php echo number_format($ca_perdu, 2, '.', ' '); ?> TND</span>
                <span>(<?php echo $total_pertes_cmd; ?> annulées/retours)</span>
            </div>
        </div>

        <!-- KPI 4 : Panier Moyen -->
        <div class="stat-kpi-card kpi-green">
            <div class="stat-kpi-header">
                <span class="stat-kpi-title">Panier Moyen</span>
                <div class="stat-kpi-icon" style="background:rgba(16,185,129,0.1); color:#10B981;">🛒</div>
            </div>
            <div class="stat-kpi-val">
                <?php echo number_format($panier_moyen, 2, '.', ' '); ?> <span style="font-size:0.95rem; font-weight:600; opacity:0.6;">TND</span>
            </div>
            <div class="stat-kpi-sub">
                <span>Moyenne par panier client validé</span>
            </div>
        </div>

        <!-- KPI 5 : Articles Écoulés -->
        <div class="stat-kpi-card kpi-amber">
            <div class="stat-kpi-header">
                <span class="stat-kpi-title">Articles Écoulés</span>
                <div class="stat-kpi-icon" style="background:rgba(245,158,11,0.1); color:#F59E0B;">🏷️</div>
            </div>
            <div class="stat-kpi-val">
                <?php echo number_format($total_articles_vendus, 0, '', ' '); ?>
            </div>
            <div class="stat-kpi-sub">
                <span>Unités physiques et abonnements</span>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- RECOMMANDATIONS STRATÉGIQUES INTELLIGENTES                     -->
    <!-- ============================================================== -->
    <div class="stat-card" style="border-left: 4px solid var(--stat-primary);">
        <h3 class="stat-card-title">
            <span>💡</span> Recommandations Décisionnelles Automatiques — Offipro
        </h3>
        
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1rem;">
            
            <!-- Insight 1: Meilleur Produit / Locomotive -->
            <?php if (!empty($top_prods)): $best = $top_prods[0]; ?>
            <div class="insight-box tip-success">
                <div style="font-size:1.6rem; line-height:1;">🚀</div>
                <div>
                    <strong style="display:block; font-size:0.875rem; margin-bottom:3px;">
                        Votre Star Absolue : « <?php echo htmlspecialchars(strip_tags($best['titre'])); ?> »
                    </strong>
                    <div style="font-size:0.8rem; line-height:1.45;">
                        Ce produit a généré à lui seul <strong><?php echo number_format($best['total_ca'], 2, '.', ' '); ?> TND</strong> (soit <strong><?php echo $best['ca_pct']; ?>%</strong> de votre chiffre d'affaires).
                        <br/>👉 <em>Conseil :</em> Maintenez un stock optimal et placez-le en première position sur vos bannières d'accueil et publicités.
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Insight 2: Alerte Annulation -->
            <?php if (!empty($cancel_prods) && $cancel_prods[0]['annule_qty'] >= 2): $worst = $cancel_prods[0]; ?>
            <div class="insight-box tip-danger">
                <div style="font-size:1.6rem; line-height:1;">⚠️</div>
                <div>
                    <strong style="display:block; font-size:0.875rem; margin-bottom:3px;">
                        Point Critique : « <?php echo htmlspecialchars(strip_tags($worst['titre'])); ?> »
                    </strong>
                    <div style="font-size:0.8rem; line-height:1.45;">
                        Ce produit enregistre <strong><?php echo $worst['annule_qty']; ?> annulations</strong> (taux d'abandon de <strong><?php echo $worst['taux_annulation']; ?>%</strong>), représentant un manque à gagner de <strong><?php echo number_format($worst['ca_perdu'], 2, '.', ' '); ?> TND</strong>.
                        <br/>👉 <em>Action requise :</em> Vérifiez la disponibilité réelle auprès de vos fournisseurs ou appelez les clients dans les 15 minutes pour confirmer.
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="insight-box tip-success">
                <div style="font-size:1.6rem; line-height:1;">✅</div>
                <div>
                    <strong style="display:block; font-size:0.875rem; margin-bottom:3px;">Excellente Maîtrise des Annulations</strong>
                    <div style="font-size:0.8rem; line-height:1.45;">
                        Le taux d'annulation global est exceptionnellement bas (<?php echo $taux_annulation; ?>%). Vos commandes sont confirmées et traitées avec une grande régularité.
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Insight 3: Comportement Visiteurs / Horaires -->
            <div class="insight-box tip-warning">
                <div style="font-size:1.6rem; line-height:1;">⏰</div>
                <div>
                    <strong style="display:block; font-size:0.875rem; margin-bottom:3px;">
                        Pic d'Achat : <?php echo $peak_day_name; ?> autour de <?php echo $peak_hour; ?>h:00
                    </strong>
                    <div style="font-size:0.8rem; line-height:1.45;">
                        Les visiteurs commandent le plus le <strong><?php echo $peak_day_name; ?></strong>, avec un afflux majeur à <strong><?php echo $peak_hour; ?>h</strong>.
                        <br/>👉 <em>Conseil Marketing :</em> Programmez vos campagnes WhatsApp, SMS et posts sur les réseaux sociaux environ 1h avant ce créneau pour maximiser la conversion.
                    </div>
                </div>
            </div>

            <!-- Insight 4: Famille Moteur -->
            <?php if (!empty($familles_list)): $top_f = $familles_list[0]; ?>
            <div class="insight-box tip-success">
                <div style="font-size:1.6rem; line-height:1;">💎</div>
                <div>
                    <strong style="display:block; font-size:0.875rem; margin-bottom:3px;">
                        Rayon Majeur : « <?php echo htmlspecialchars($top_f['famille_titre']); ?> »
                    </strong>
                    <div style="font-size:0.8rem; line-height:1.45;">
                        Cette catégorie draine <strong><?php echo number_format($top_f['total_ca'], 2, '.', ' '); ?> TND</strong> (<?php echo $top_f['ca_pct']; ?>% du CA) avec un panier moyen de <strong><?php echo $top_f['panier_moyen']; ?> TND</strong>.
                        <br/>👉 <em>Conseil :</em> Proposez des ventes croisées (accessoires, extensions de garantie) lors de l'ajout au panier.
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ============================================================== -->
    <!-- GRAPHIQUES : COURBE CHRONOLOGIQUE + RÉPARTITION STATUT         -->
    <!-- ============================================================== -->
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:1.5rem; margin-bottom:2rem;" class="stat-charts-grid">
        
        <!-- Graphique 1 : Courbe Temporelle Évolution Ventes & CA -->
        <div class="stat-card" style="margin-bottom:0;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; flex-wrap:wrap; gap:8px;">
                <h3 class="stat-card-title" style="margin:0;">
                    <span>📈</span> Évolution Temporelle des Ventes & du Chiffre d'Affaires
                </h3>
                <span style="font-size:0.75rem; color:var(--color-text-muted); background:rgba(0,0,0,0.04); padding:3px 8px; border-radius:6px;">
                    <?php echo $is_daily_view ? 'Vue par Jour' : 'Vue par Mois'; ?>
                </span>
            </div>
            <div style="position:relative; height:340px;">
                <canvas id="chartEvolutionCmd"></canvas>
            </div>
        </div>

        <!-- Graphique 2 : Répartition par Statut de Commande -->
        <div class="stat-card" style="margin-bottom:0;">
            <h3 class="stat-card-title">
                <span>🎯</span> Répartition par État de Commande
            </h3>
            <div style="position:relative; height:220px;">
                <canvas id="chartStatutsCmd"></canvas>
            </div>
            
            <!-- Légende détaillée -->
            <div style="margin-top:1.25rem; display:flex; flex-direction:column; gap:6px;">
                <?php foreach($statuts_list as $st): if($st['count'] == 0) continue; ?>
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.8rem;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:<?php echo $st['color']; ?>; display:inline-block;"></span>
                        <span><?php echo htmlspecialchars($st['label']); ?></span>
                    </div>
                    <div style="font-weight:700;">
                        <?php echo $st['count']; ?> <span style="font-size:0.75rem; color:var(--color-text-muted); font-weight:normal;">(<?php echo $st['pct']; ?>%)</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- GRAPHIQUES COMPORTEMENT : JOURS, HEURES & PAIEMENTS            -->
    <!-- ============================================================== -->
    <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:1.5rem; margin-bottom:2rem;" class="stat-behavior-grid">
        
        <!-- Jour de la semaine -->
        <div class="stat-card" style="margin-bottom:0;">
            <h3 class="stat-card-title">
                <span>📅</span> Ventes par Jour de Semaine
            </h3>
            <div style="position:relative; height:200px;">
                <canvas id="chartDowCmd"></canvas>
            </div>
            <p style="font-size:0.75rem; color:var(--color-text-muted); margin:10px 0 0; text-align:center;">
                Jour d'affluence max : <strong><?php echo $peak_day_name; ?></strong>
            </p>
        </div>

        <!-- Heures de la journée -->
        <div class="stat-card" style="margin-bottom:0;">
            <h3 class="stat-card-title">
                <span>⏱️</span> Ventes par Heure de la Journée
            </h3>
            <div style="position:relative; height:200px;">
                <canvas id="chartHoursCmd"></canvas>
            </div>
            <p style="font-size:0.75rem; color:var(--color-text-muted); margin:10px 0 0; text-align:center;">
                Heure de pointe : <strong><?php echo $peak_hour; ?>h:00 - <?php echo ($peak_hour+1); ?>h:00</strong>
            </p>
        </div>

        <!-- Moyens de paiement -->
        <div class="stat-card" style="margin-bottom:0;">
            <h3 class="stat-card-title">
                <span>💳</span> Modes de Paiement Utilisés
            </h3>
            <div style="position:relative; height:200px;">
                <canvas id="chartPaiementCmd"></canvas>
            </div>
            <p style="font-size:0.75rem; color:var(--color-text-muted); margin:10px 0 0; text-align:center;">
                Répartition des méthodes de règlement
            </p>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- TABLEAUX D'ANALYSE DÉTAILLÉE AVEC ONGLETS                      -->
    <!-- ============================================================== -->
    <div class="stat-card">
        
        <!-- Barre d'onglets et recherche instantanée -->
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1rem;">
            <div class="stat-nav-tabs">
                <button type="button" class="stat-tab-btn active" onclick="switchStatTab('tab-top-prods', this)">
                    <span>🏆</span> Produits les Plus Commandés (<?php echo count($top_prods); ?>)
                </button>
                <button type="button" class="stat-tab-btn" onclick="switchStatTab('tab-cancel-prods', this)">
                    <span>⚠️</span> Produits les Plus Annulés (<?php echo count($cancel_prods); ?>)
                </button>
                <button type="button" class="stat-tab-btn" onclick="switchStatTab('tab-familles', this)">
                    <span>🏷️</span> Familles & Catégories (<?php echo count($familles_list); ?>)
                </button>
                <button type="button" class="stat-tab-btn" onclick="switchStatTab('tab-paiement', this)">
                    <span>💳</span> Moyens de Paiement
                </button>
            </div>

            <!-- Filtre de recherche instantanée dans le tableau -->
            <div>
                <input type="text" id="statTableSearch" placeholder="🔍 Rechercher un produit..." class="admin-input" style="padding:6px 12px; font-size:0.8125rem; width:220px;" onkeyup="filterStatTable(this.value)">
            </div>
        </div>

        <!-- ---------------------------------------------------------- -->
        <!-- TAB 1 : PRODUITS LES PLUS COMMANDÉS                        -->
        <!-- ---------------------------------------------------------- -->
        <div id="tab-top-prods" class="stat-tab-content">
            <div style="overflow-x:auto;">
                <table class="stat-table" id="tableTopProds">
                    <thead>
                        <tr>
                            <th style="width:50px;">Rang</th>
                            <th style="width:60px;">Photo</th>
                            <th>Désignation du Produit</th>
                            <th>Rayon / Catégorie</th>
                            <th style="text-align:center;">Quantité Vendue</th>
                            <th style="text-align:center;">Commandes</th>
                            <th style="text-align:right;">Chiffre d'Affaires</th>
                            <th style="text-align:center; width:130px;">Part du CA</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($top_prods)): ?>
                        <tr><td colspan="9" style="text-align:center; padding:2rem; color:var(--color-text-muted);">Aucune vente enregistrée sur cette période.</td></tr>
                        <?php else: ?>
                        <?php foreach($top_prods as $idx => $p): 
                            $photo_url = !empty($p['photo']) ? '../media/products/' . htmlspecialchars($p['photo']) : '../media/products/image_non_dispo.jpg';
                            $rank = $idx + 1;
                            $medal = ($rank == 1) ? '🥇' : (($rank == 2) ? '🥈' : (($rank == 3) ? '🥉' : '#' . $rank));
                        ?>
                        <tr class="searchable-row">
                            <td style="font-weight:800; font-size:1rem; text-align:center;"><?php echo $medal; ?></td>
                            <td>
                                <img src="<?php echo $photo_url; ?>" alt="" class="stat-prod-img" onerror="this.src='../media/products/image_non_dispo.jpg'">
                            </td>
                            <td>
                                <div style="font-weight:700; color:var(--stat-primary); margin-bottom:2px;" class="search-target">
                                    <?php echo htmlspecialchars(strip_tags($p['titre'])); ?>
                                </div>
                                <span style="font-size:0.75rem; color:var(--color-text-muted);">Réf #<?php echo $p['id_produit']; ?></span>
                            </td>
                            <td>
                                <span style="display:inline-block; padding:2px 8px; background:rgba(90,49,244,0.08); border-radius:6px; font-size:0.75rem; font-weight:600; color:var(--stat-primary);">
                                    <?php echo htmlspecialchars($p['categ_nom'] ?: 'Général'); ?>
                                </span>
                            </td>
                            <td style="text-align:center; font-weight:800; font-size:1.05rem;">
                                <?php echo number_format($p['total_qty']); ?>
                            </td>
                            <td style="text-align:center; font-weight:600; color:var(--color-text-muted);">
                                <?php echo number_format($p['total_orders']); ?>
                            </td>
                            <td style="text-align:right; font-weight:800; color:#10B981; font-size:1.05rem;">
                                <?php echo number_format(floatval($p['total_ca']), 2, '.', ' '); ?> TND
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="progress-bar-wrap">
                                        <div class="progress-bar-fill" style="width: <?php echo min(100, $p['ca_pct'] * 3); ?>%;"></div>
                                    </div>
                                    <span style="font-size:0.75rem; font-weight:700; width:35px;"><?php echo $p['ca_pct']; ?>%</span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <a href="index.php?r=mproduits&id=<?php echo $p['id_produit']; ?>" class="admin-btn admin-btn-ghost" style="padding:4px 8px; font-size:0.75rem;" title="Modifier le produit">
                                    Éditer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ---------------------------------------------------------- -->
        <!-- TAB 2 : PRODUITS LES PLUS ANNULÉS (Alertes)                 -->
        <!-- ---------------------------------------------------------- -->
        <div id="tab-cancel-prods" class="stat-tab-content" style="display:none;">
            <div style="background:rgba(239,68,68,0.05); border:1px solid rgba(239,68,68,0.2); border-radius:10px; padding:12px 16px; margin-bottom:1rem; font-size:0.8125rem; color:#991b1b;">
                ℹ️ <strong>Pourquoi analyser les annulations ?</strong> Un taux d'annulation anormal (> 15%) sur un produit signale généralement une rupture de stock non déclarée, un délai de livraison jugé trop long par l'acheteur, ou une inadéquation prix/qualité au moment de la confirmation téléphonique.
            </div>

            <div style="overflow-x:auto;">
                <table class="stat-table" id="tableCancelProds">
                    <thead>
                        <tr>
                            <th style="width:60px;">Photo</th>
                            <th>Produit Concerne</th>
                            <th>Catégorie</th>
                            <th style="text-align:center;">Unités Annulées</th>
                            <th style="text-align:center;">Total Demandé</th>
                            <th style="text-align:center;">Taux d'Annulation</th>
                            <th style="text-align:right;">Manque à Gagner (Perte)</th>
                            <th>Diagnostic / Conseil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cancel_prods)): ?>
                        <tr><td colspan="8" style="text-align:center; padding:2rem; color:var(--color-text-muted);">Aucune annulation de produit sur cette période. Bravo !</td></tr>
                        <?php else: ?>
                        <?php foreach($cancel_prods as $cp): 
                            $photo_url = !empty($cp['photo']) ? '../media/products/' . htmlspecialchars($cp['photo']) : '../media/products/image_non_dispo.jpg';
                            $rate = floatval($cp['taux_annulation']);
                            $rate_class = ($rate >= 25) ? 'danger' : (($rate >= 10) ? 'warning' : 'good');
                        ?>
                        <tr class="searchable-row">
                            <td>
                                <img src="<?php echo $photo_url; ?>" alt="" class="stat-prod-img" onerror="this.src='../media/products/image_non_dispo.jpg'">
                            </td>
                            <td>
                                <div style="font-weight:700; color:var(--color-text-primary);" class="search-target">
                                    <?php echo htmlspecialchars(strip_tags($cp['titre'])); ?>
                                </div>
                                <span style="font-size:0.75rem; color:var(--color-text-muted);">Réf #<?php echo $cp['id_produit']; ?></span>
                            </td>
                            <td>
                                <span style="display:inline-block; padding:2px 8px; background:rgba(0,0,0,0.04); border-radius:6px; font-size:0.75rem;">
                                    <?php echo htmlspecialchars($cp['categ_nom'] ?: 'Général'); ?>
                                </span>
                            </td>
                            <td style="text-align:center; font-weight:800; font-size:1.05rem; color:#EF4444;">
                                <?php echo number_format($cp['annule_qty']); ?>
                            </td>
                            <td style="text-align:center; font-weight:600; color:var(--color-text-muted);">
                                <?php echo number_format($cp['total_demand_qty']); ?>
                            </td>
                            <td style="text-align:center;">
                                <span class="badge-rate <?php echo $rate_class; ?>">
                                    <?php echo $rate; ?> %
                                </span>
                            </td>
                            <td style="text-align:right; font-weight:800; color:#EF4444; font-size:1.05rem;">
                                -<?php echo number_format(floatval($cp['ca_perdu']), 2, '.', ' '); ?> TND
                            </td>
                            <td style="font-size:0.75rem; color:var(--color-text-muted);">
                                <?php if ($rate >= 50): ?>
                                    <span style="color:#dc2626; font-weight:600;">🚨 Vérifier stock d'urgence ou désactiver</span>
                                <?php elseif ($rate >= 20): ?>
                                    <span style="color:#d97706; font-weight:600;">⚠️ Appel confirmation recommandé sous 30min</span>
                                <?php else: ?>
                                    <span style="color:#059669;">Taux acceptable</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ---------------------------------------------------------- -->
        <!-- TAB 3 : FAMILLES & CATÉGORIES                             -->
        <!-- ---------------------------------------------------------- -->
        <div id="tab-familles" class="stat-tab-content" style="display:none;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;" class="stat-fam-grid">
                
                <!-- Familles Principales -->
                <div>
                    <h4 style="font-size:0.95rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:6px;">
                        <span>📂</span> Familles Principales (Rayons)
                    </h4>
                    <div style="overflow-x:auto;">
                        <table class="stat-table">
                            <thead>
                                <tr>
                                    <th>Famille</th>
                                    <th style="text-align:center;">Articles</th>
                                    <th style="text-align:right;">Chiffre d'Affaires</th>
                                    <th style="text-align:center;">Part</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($familles_list as $f): ?>
                                <tr class="searchable-row">
                                    <td>
                                        <strong class="search-target"><?php echo htmlspecialchars($f['famille_titre']); ?></strong>
                                        <div style="font-size:0.75rem; color:var(--color-text-muted);">
                                            Panier moyen : <?php echo $f['panier_moyen']; ?> TND
                                        </div>
                                    </td>
                                    <td style="text-align:center; font-weight:700;"><?php echo number_format($f['total_qty']); ?></td>
                                    <td style="text-align:right; font-weight:800; color:#10B981;">
                                        <?php echo number_format($f['total_ca'], 2, '.', ' '); ?> TND
                                    </td>
                                    <td style="text-align:center; font-weight:700;"><?php echo $f['ca_pct']; ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sous-catégories Phares -->
                <div>
                    <h4 style="font-size:0.95rem; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:6px;">
                        <span>🏷️</span> Sous-Catégories Spécifiques
                    </h4>
                    <div style="overflow-x:auto;">
                        <table class="stat-table">
                            <thead>
                                <tr>
                                    <th>Sous-Catégorie</th>
                                    <th>Rayon Parent</th>
                                    <th style="text-align:center;">Articles</th>
                                    <th style="text-align:right;">CA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($subcategs_list as $sc): ?>
                                <tr class="searchable-row">
                                    <td><strong class="search-target"><?php echo htmlspecialchars($sc['cat_titre']); ?></strong></td>
                                    <td style="font-size:0.75rem; color:var(--color-text-muted);"><?php echo htmlspecialchars($sc['parent_titre']); ?></td>
                                    <td style="text-align:center; font-weight:700;"><?php echo number_format($sc['total_qty']); ?></td>
                                    <td style="text-align:right; font-weight:800; color:#10B981;">
                                        <?php echo number_format($sc['total_ca'], 2, '.', ' '); ?> TND
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- ---------------------------------------------------------- -->
        <!-- TAB 4 : MOYENS DE PAIEMENT                                 -->
        <!-- ---------------------------------------------------------- -->
        <div id="tab-paiement" class="stat-tab-content" style="display:none;">
            <div style="overflow-x:auto;">
                <table class="stat-table">
                    <thead>
                        <tr>
                            <th>Mode de Règlement</th>
                            <th style="text-align:center;">Nombre de Commandes</th>
                            <th style="text-align:center;">Part des Transactions</th>
                            <th style="text-align:right;">Chiffre d'Affaires Encaissé</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paiement_list as $pl): ?>
                        <tr class="searchable-row">
                            <td>
                                <strong class="search-target"><?php echo htmlspecialchars($pl['moyen_titre']); ?></strong>
                            </td>
                            <td style="text-align:center; font-weight:700;">
                                <?php echo number_format($pl['nb_cmd']); ?>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <div class="progress-bar-wrap" style="width:100px;">
                                        <div class="progress-bar-fill" style="width: <?php echo $pl['pct']; ?>%;"></div>
                                    </div>
                                    <span style="font-weight:700; font-size:0.75rem;"><?php echo $pl['pct']; ?>%</span>
                                </div>
                            </td>
                            <td style="text-align:right; font-weight:800; color:#10B981;">
                                <?php echo number_format(floatval($pl['total_ca']), 2, '.', ' '); ?> TND
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- ============================================================== -->
<!-- INITIALISATION DES GRAPHIQUES JAVASCRIPT (CHART.JS)           -->
<!-- ============================================================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // Détecter si dark mode
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.06)' : 'rgba(0, 0, 0, 0.05)';
    const textColor = isDark ? '#94a3b8' : '#64748b';

    // -------------------------------------------------------------
    // CHART 1 : ÉVOLUTION VENTES & CA (Line Chart)
    // -------------------------------------------------------------
    const ctxEvol = document.getElementById('chartEvolutionCmd');
    if (ctxEvol) {
        new Chart(ctxEvol, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [
                    {
                        label: 'Chiffre d\'Affaires (TND)',
                        data: <?php echo json_encode($chart_ca_data); ?>,
                        borderColor: '#5A31F4',
                        backgroundColor: 'rgba(90, 49, 244, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'y',
                        pointRadius: 2,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Commandes Annulées',
                        data: <?php echo json_encode($chart_annulees_data); ?>,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.35,
                        yAxisID: 'y1',
                        pointRadius: 2,
                        pointHoverRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { color: textColor, font: { size: 12, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, maxTicksLimit: 12 }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { color: '#EF4444', precision: 0 }
                    }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 2 : RÉPARTITION DES STATUTS (Doughnut)
    // -------------------------------------------------------------
    const ctxStatuts = document.getElementById('chartStatutsCmd');
    if (ctxStatuts) {
        new Chart(ctxStatuts, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($statuts_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($statuts_counts); ?>,
                    backgroundColor: <?php echo json_encode($statuts_chart_colors); ?>,
                    borderWidth: 2,
                    borderColor: isDark ? '#1c1930' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        callbacks: {
                            label: function(item) {
                                return ' ' + item.label + ' : ' + item.raw + ' commandes';
                            }
                        }
                    }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 3 : PAR JOUR DE SEMAINE (Bar Chart)
    // -------------------------------------------------------------
    const ctxDow = document.getElementById('chartDowCmd');
    if (ctxDow) {
        new Chart(ctxDow, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($dow_labels); ?>,
                datasets: [{
                    label: 'Commandes',
                    data: <?php echo json_encode($dow_data); ?>,
                    backgroundColor: 'rgba(90, 49, 244, 0.75)',
                    hoverBackgroundColor: '#5A31F4',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } },
                    y: { grid: { color: gridColor }, ticks: { color: textColor, precision: 0 } }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 4 : PAR HEURE DE LA JOURNÉE (Area Line Chart)
    // -------------------------------------------------------------
    const ctxHours = document.getElementById('chartHoursCmd');
    if (ctxHours) {
        new Chart(ctxHours, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($hours_labels); ?>,
                datasets: [{
                    label: 'Commandes',
                    data: <?php echo json_encode($hours_data); ?>,
                    borderColor: '#06B6D4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 1,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: textColor, maxTicksLimit: 8, font: { size: 10 } } },
                    y: { grid: { color: gridColor }, ticks: { color: textColor, precision: 0 } }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 5 : MOYENS DE PAIEMENT (Doughnut)
    // -------------------------------------------------------------
    const ctxPaiement = document.getElementById('chartPaiementCmd');
    if (ctxPaiement) {
        const pLabels = <?php echo json_encode(array_column($paiement_list, 'moyen_titre')); ?>;
        const pCounts = <?php echo json_encode(array_column($paiement_list, 'nb_cmd')); ?>;
        new Chart(ctxPaiement, {
            type: 'doughnut',
            data: {
                labels: pLabels,
                datasets: [{
                    data: pCounts,
                    backgroundColor: ['#5A31F4', '#10B981', '#06B6D4', '#F59E0B', '#EC4899', '#8B5CF6'],
                    borderWidth: 2,
                    borderColor: isDark ? '#1c1930' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(i) { return ' ' + i.label + ' : ' + i.raw + ' cmd'; }
                        }
                    }
                }
            }
        });
    }

});

// -------------------------------------------------------------
// NAVIGATION ONGLETS TABLEAUX
// -------------------------------------------------------------
function switchStatTab(tabId, btn) {
    document.querySelectorAll('.stat-tab-content').forEach(function(el) {
        el.style.display = 'none';
    });
    document.querySelectorAll('.stat-tab-btn').forEach(function(el) {
        el.classList.remove('active');
    });
    
    const target = document.getElementById(tabId);
    if (target) target.style.display = 'block';
    if (btn) btn.classList.add('active');
}

// -------------------------------------------------------------
// RECHERCHE EN DIRECT DANS LES TABLEAUX
// -------------------------------------------------------------
function filterStatTable(term) {
    const q = term.toLowerCase().trim();
    document.querySelectorAll('.stat-tab-content:not([style*="display: none"]) .searchable-row').forEach(function(row) {
        const text = row.querySelector('.search-target') ? row.querySelector('.search-target').textContent.toLowerCase() : row.textContent.toLowerCase();
        if (text.includes(q)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
