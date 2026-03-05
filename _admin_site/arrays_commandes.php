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
        "action" => '<a href="index.php?r=dcommande&id='.$row['id'].($idclient > 0 ? '&idc='.$idclient : '').'" data-toggle="tooltip" title="Consulter les détails"> <i class="fa fa-search text-inverse m-r-10"></i> </a>
                     <a href="javascript:void(0)" onclick="confirmDeleteCmd('.$row['id'].')" data-toggle="tooltip" title="Supprimer"> <i class="fa fa-trash text-danger m-r-10"></i> </a>'
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
