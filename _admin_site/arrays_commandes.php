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
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
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

    $data[] = array(
        "" => '<input type="checkbox" class="sub_chk_cmd" data-id="'.$row['id'].'" style="position:relative;left:0;opacity:1">',
        "id" => $row['id'],
        "num" => "#" . $row['id'] . "<br/>" . timestampTDtodate($row['date']),
        "client" => $client_display,
        "montant" => afficheChamp($row['total']) . " TND",
        "etat" => $status_html,
        "action" => '<div class="action-buttons">
                        <a href="index.php?r=dcommande&id='.$row['id'].($idclient > 0 ? '&idc='.$idclient : '').'" class="action-btn view-btn" data-tippy-content="Consulter les détails">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="javascript:void(0)" onclick="confirmDeleteCmd('.$row['id'].')" class="action-btn delete-btn" data-tippy-content="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </a>
                    </div>'
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
