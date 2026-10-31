<?php
include('../include.php');

// Reading value
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$rowstr = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
$columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';
$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string(ouvrirCnx(), $_POST['search']['value']) : '';

// Map DataTables column index back to DB fields
$columns_map = array(
    0 => 'id',
    1 => 'id', // Order ID (usually hidden but used for sorting)
    2 => 'id', // N° Commande
    3 => 'client_name', // We'll compute this in the query or use a join
    4 => 'total',
    5 => 'etat',
    6 => 'id'
);
$columnName = isset($columns_map[$columnIndex]) ? $columns_map[$columnIndex] : 'id';

// For client-specific listing
$idclient = isset($_POST['idclient']) ? intval($_POST['idclient']) : 0;
$clientFilter = ($idclient > 0) ? " AND c.idclient = $idclient " : "";

// Total records without filtering
$totalSel = executeRequete("SELECT COUNT(*) AS allcount FROM commandes c WHERE 1 $clientFilter");
$totalRecords = mysqli_fetch_assoc($totalSel)['allcount'];

// Search Filter
$searchFilter = "";
if($searchValue != ''){
    $searchFilter = " AND (c.id LIKE '%".$searchValue."%' OR 
                          cl.nom LIKE '%".$searchValue."%' OR 
                          cl.prenom LIKE '%".$searchValue."%' OR 
                          cl.email LIKE '%".$searchValue."%' OR
                          c.total LIKE '%".$searchValue."%') ";
}

// Total records with filtering
$sel = executeRequete("SELECT COUNT(*) AS allcount FROM commandes c LEFT JOIN clients cl ON c.idclient = cl.id WHERE 1 $clientFilter $searchFilter");
$totalRecordwithFilter = mysqli_fetch_assoc($sel)['allcount'];

// Optimized main query
$empQuery = "SELECT c.*, 
                    cl.nom as client_nom, cl.prenom as client_prenom, cl.email as client_email,
                    e.etat as etat_label
             FROM commandes c 
             LEFT JOIN clients cl ON c.idclient = cl.id
             LEFT JOIN etat_commandes e ON c.etat = e.id
             WHERE 1 $clientFilter $searchFilter";

// Sorting
$empQuery .= " ORDER BY c.$columnName $columnSortOrder ";

// Pagination
if($rowperpage != -1){
    $empQuery .= " LIMIT $rowstr, $rowperpage";
}

$empRecords = executeRequete($empQuery);
$rows = array();
$order_ids = array();
while ($r = mysqli_fetch_assoc($empRecords)) {
    $rows[] = $r;
    $order_ids[] = intval($r['id']);
}

// Fetch products for all fetched orders in one single query
$products_by_cmd = array();
if (!empty($order_ids)) {
    $ids_str = implode(',', $order_ids);
    $pQuery = "SELECT lc.idcommande, lc.id_produit, lc.nom_produit, lc.quantite, lc.prix, p.titre, p.photo 
               FROM ligne_commande lc 
               LEFT JOIN produits p ON lc.id_produit = p.id 
               WHERE lc.idcommande IN ($ids_str)
               ORDER BY lc.id ASC";
    $pRes = executeRequete($pQuery);
    if ($pRes) {
        while ($pRow = mysqli_fetch_assoc($pRes)) {
            $products_by_cmd[$pRow['idcommande']][] = $pRow;
        }
    }
}

$data = array();

foreach ($rows as $row) {
    $cmd_id = intval($row['id']);

    // Client display
    $client_display = "";
    if (!empty($row['nom']) || !empty($row['prenom'])) {
        $client_display = afficheChamp($row['nom']) . ' ' . afficheChamp($row['prenom']) . '<br/>' . afficheChamp($row['email']);
    } else {
        $client_display = afficheChamp($row['client_nom']) . ' ' . afficheChamp($row['client_prenom']) . '<br/>' . afficheChamp($row['client_email']);
    }

    $whatsapp_num = trim($row['whatsapp'] ?? '');
    if (!empty($whatsapp_num)) {
        $clean_wa = preg_replace('/[^0-9+]/', '', $whatsapp_num);
        if ($clean_wa != '') {
            $client_display .= '<br/><a href="https://wa.me/' . ltrim($clean_wa, '+') . '" target="_blank" style="display:inline-flex; align-items:center; gap:4px; margin-top:4px; padding:2px 6px; background:color-mix(in srgb, #25D366 10%, transparent); border-radius:4px; color:#1ea952; font-weight:600; font-size:0.85rem; text-decoration:none;"><i class="fa fa-whatsapp" style="font-size:1.1em;"></i> ' . htmlspecialchars($whatsapp_num) . '</a>';
        }
    }

    // Status label with badge
    $status_html = "";
    $badge_class = "badge-info";
    switch($row['etat']) {
        case 1: $badge_class = "badge-primary"; break;
        case 2: $badge_class = "badge-success"; break;
        case 3: $badge_class = "badge-info"; break;
        case 4: 
        case 8: $badge_class = "badge-danger"; break;
        case 9: $badge_class = "badge-success"; break;
    }
    $status_html = "<span class='badge $badge_class'>" . ($row['etat_label'] ?? "Inconnu") . "</span>";
    if($row['cmd_express'] != '') {
        $status_html .= " | <span class='badge badge-success' style='background:#28a745!important'>Commande express</span>";
    }

    // Bouton accepter direct dans la colonne État si en attente
    if ($row['etat'] == 1) {
        $status_html .= '<div style="margin-top:6px;">
            <button type="button" onclick="accepterCommande(' . $cmd_id . ')" class="btn-quick-accept" title="Accepter directement la commande (Traitement en cours)">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Accepter
            </button>
        </div>';
    }

    // Products list under order number
    $cmd_products = $products_by_cmd[$cmd_id] ?? array();
    $nb_prods = count($cmd_products);
    
    $prods_drawer_html = '';
    if ($nb_prods > 0) {
        $prods_items_html = '';
        foreach ($cmd_products as $p) {
            $prod_title = !empty($p['nom_produit']) ? $p['nom_produit'] : ($p['titre'] ?? 'Article sans nom');
            $prod_photo = !empty($p['photo']) ? '../media/products/' . htmlspecialchars($p['photo']) : '../media/products/image_non_dispo.jpg';
            $qty = intval($p['quantite'] ?? 1);
            $price = (!empty($p['prix']) && floatval($p['prix']) > 0) ? number_format(floatval($p['prix']), 3, '.', ' ') . ' TND' : '';
            
            $prods_items_html .= '
            <div class="cmd-prod-item">
                <img src="' . $prod_photo . '" alt="" class="cmd-prod-img" onerror="this.src=\'../media/products/image_non_dispo.jpg\'">
                <div class="cmd-prod-info">
                    <div class="cmd-prod-name" title="' . htmlspecialchars(strip_tags($prod_title)) . '">' . htmlspecialchars(strip_tags($prod_title)) . '</div>
                    <div class="cmd-prod-meta">
                        <span class="cmd-prod-qty">Qté : ' . $qty . '</span>
                        ' . ($price ? '<span class="cmd-prod-price">' . $price . '</span>' : '') . '
                    </div>
                </div>
            </div>';
        }
        
        $prods_drawer_html = '
        <div id="cmd-products-' . $cmd_id . '" class="cmd-products-drawer" style="display:none;">
            <div class="cmd-products-list">
                ' . $prods_items_html . '
            </div>
        </div>';
    } else {
        $prods_drawer_html = '
        <div id="cmd-products-' . $cmd_id . '" class="cmd-products-drawer" style="display:none;">
            <div style="font-size:0.75rem; color:#94a3b8; font-style:italic; padding:4px;">Aucun article détaillé</div>
        </div>';
    }

    $num_html = '
    <div class="cmd-num-cell">
        <a href="javascript:void(0)" class="cmd-num-toggle" onclick="toggleCmdProducts(' . $cmd_id . ', this)" title="Cliquer pour afficher / masquer les produits (' . $nb_prods . ' article' . ($nb_prods > 1 ? 's' : '') . ')">
            <span class="cmd-badge">#' . $cmd_id . '</span>
            <span class="cmd-chevron-wrap">
                <svg class="cmd-chevron" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </span>
            ' . ($nb_prods > 0 ? '<span class="cmd-count-badge" title="' . $nb_prods . ' produit' . ($nb_prods > 1 ? 's' : '') . '">' . $nb_prods . '</span>' : '') . '
        </a>
        <div class="cmd-date-text">' . timestampTDtodate($row['date']) . '</div>
        ' . $prods_drawer_html . '
    </div>';

    // Action buttons
    $ship_btn = '';
    if ($row['etat'] != 2) {
        $ship_btn = '<a href="javascript:void(0)" onclick="expedierCommande(' . $cmd_id . ')" class="action-btn ship-btn" data-tippy-content="Marquer comme expédiée" title="Expédier la commande">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </a>';
    }

    $action_html = '<div class="action-buttons">'
        . $ship_btn . '
        <a href="index.php?r=dcommande&id='.$cmd_id.($idclient > 0 ? '&idc='.$idclient : '').'" class="action-btn view-btn" data-tippy-content="Consulter les détails" title="Détails">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </a>
        <a href="javascript:void(0)" onclick="confirmDeleteCmd('.$cmd_id.')" class="action-btn delete-btn" data-tippy-content="Supprimer" title="Supprimer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </a>
    </div>';

    $data[] = array(
        "" => '<input type="checkbox" class="sub_chk_cmd" data-id="'.$cmd_id.'" style="position:relative;left:0;opacity:1">',
        "id" => $cmd_id,
        "num" => $num_html,
        "client" => $client_display,
        "montant" => afficheChamp($row['total']) . " TND",
        "etat" => $status_html,
        "action" => $action_html
    );
}

// Final Response
$response = array(
    "draw" => $draw,
    "iTotalRecords" => intval($totalRecords),
    "iTotalDisplayRecords" => intval($totalRecordwithFilter),
    "data" => $data
);

header('Content-Type: application/json');
echo json_encode($response);
?>
