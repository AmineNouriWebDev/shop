<?php 

include('../include.php');

// Reading value
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$rowstr = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
$columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';

// Map DataTables column index to DB field
$columns_map = array(
    0 => 'id',
    1 => 'titre',
    2 => 'prix_vente',
    3 => 'categorie',
    4 => 'marque',
    5 => 'type',
    6 => 'datecreation',
    7 => 'id'
);
$columnName = isset($columns_map[$columnIndex]) ? $columns_map[$columnIndex] : 'id';

## Custom Field value
$searchByTitle = isset($_POST['searchByTitle']) ? mysqli_real_escape_string(ouvrirCnx(), url_rewrite($_POST['searchByTitle'])) : '';
$searchByCateg = isset($_POST['searchByCateg']) ? mysqli_real_escape_string(ouvrirCnx(), url_rewrite($_POST['searchByCateg'])) : '';
$searchByMarque = isset($_POST['searchByMarque']) ? mysqli_real_escape_string(ouvrirCnx(), url_rewrite($_POST['searchByMarque'])) : '';

## Search Query Construction
$searchQuery = "";
if($searchByTitle != ''){
   $searchQuery .= " AND ( pr.link LIKE '%".nett($searchByTitle)."%' OR pr.titre LIKE '%".$searchByTitle."%' ) ";
}
if($searchByCateg != ''){
   $searchQuery .= " AND ( ctg.titre LIKE '%".$searchByCateg."%' OR ctg.link LIKE '%".nett($searchByCateg)."%' ) ";
}
if($searchByMarque != ''){
   $searchQuery .= " AND ( mr.raison LIKE '%".$searchByMarque."%' OR mr.link LIKE '%".nett($searchByMarque)."%' ) ";
}

// Total records without filtering
$totalSel = executeRequete("SELECT COUNT(*) AS allcount FROM produits");
$totalRecords = mysqli_fetch_assoc($totalSel)['allcount'];

// Total records with filtering
$filterQuery = "SELECT COUNT(DISTINCT pr.id) AS allcount 
                FROM produits pr 
                LEFT JOIN marques mr ON pr.marque = mr.id 
                LEFT JOIN categories_blog ctg ON (pr.categorie = ctg.id OR pr.idparent_categ = ctg.id)
                WHERE 1 ".$searchQuery;
$filterRes = executeRequete($filterQuery);
$totalRecordwithFilter = mysqli_fetch_assoc($filterRes)['allcount'];

// Main Data Query
$empQuery = "SELECT pr.*, 
                    mr.raison as marque_nom, 
                    ctg.titre as categ_nom,
                    p_ctg.titre as parent_categ_nom
             FROM produits pr 
             LEFT JOIN marques mr ON pr.marque = mr.id 
             LEFT JOIN categories_blog ctg ON pr.categorie = ctg.id
             LEFT JOIN categories_blog p_ctg ON pr.idparent_categ = p_ctg.id
             WHERE 1 ".$searchQuery;

// Sorting
$empQuery .= " ORDER BY pr.$columnName $columnSortOrder ";

// Pagination
if($rowperpage != -1){
    $empQuery .= " LIMIT $rowstr, $rowperpage";
}

$empRecords = executeRequete($empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    // Price formatting
    $pv = prixVenteProduits($row['id']);
    $pp = prixPromoProduits($row['id']);
    $price_display = "";

    // Check if product has combination-based variable prices
    $varCheck = executeRequete("SELECT COUNT(*) as cnt, MIN(NULLIF(prix_vente,0)) as min_pv FROM produit_variations WHERE idproduit='" . intval($row['id']) . "'");
    $varData = mysqli_fetch_assoc($varCheck);
    $hasVariations = ($varData && intval($varData['cnt']) > 0);
    $variableBadge = $hasVariations
        ? ' <span style="display:inline-block; background:#5a31f4; color:#fff; font-size:0.65rem; font-weight:700; padding:1px 7px; border-radius:99px; vertical-align:middle; letter-spacing:0.02em;" title="Prix variable par caractéristiques"><i class="fa fa-sliders"></i> Variable</span>'
        : '';
    $fromLabel = $hasVariations ? '<span style="font-size:0.7rem; color:#9ca3af; font-weight:400;">À partir de </span>' : '';

    if($pp != '0.000' && $pp != '' && floatval($pv) > floatval($pp)) {
        $price_display = $fromLabel . $pp.' DT <span style="text-decoration:line-through; color:#9ca3af">'.$pv.' DT </span>'.$variableBadge;
    } else {
        $price_display = $fromLabel . $pv.' DT'.$variableBadge;
    }

    // Type label
    $type_label = ($row['type'] == "E") ? "Equipement" : "Abonnement";

    // Category display
    $categ_display = "";
    if($row['parent_categ_nom']) {
        $categ_display = $row['parent_categ_nom'] . '<br/> |--> ' . $row['categ_nom'];
    } else {
        $categ_display = $row['categ_nom'];
    }

    // Photo
    $photo_html = "";
    if($row['photo'] != "") {
        $photo_html = '<img src="../media/products/'.$row['photo'].'" border="0" width="60" class="mr-2" />';
    } else {
        $photo_html = '<img src="../media/products/image_non_dispo.jpg" border="0" width="60" height="60" />';
    }

    $data[] = array(
        "" => '<input type="checkbox" class="sub_chk" data-id="'.$row['id'].'" style="position:relative;left:0;opacity:1">',
        "produit" => $photo_html . ' ' . afficheChamp1($row['titre']),
        "prix_vente" => $price_display,
        "categorie" => $categ_display,
        "marque" => $row['marque_nom'],
        "type" => $type_label,
        "datecreation" => auteur_name($row['auteur']).' <br/> '.timestampTDtodate($row['datecreation']),
        "action" => '
            <div style="display:flex; justify-content:flex-end; gap:0.4rem; flex-wrap:nowrap;">
                <a href="index.php?r=mproduits&id='.$row['id'].'&start='.$rowstr.'" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:var(--shop-primary);" data-tippy-content="Modifier">
                    <i class="fa fa-pencil"></i>
                </a>
                <a href="index.php?r=addproduitssimilaire&id='.$row['id'].'&start='.$rowstr.'" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:var(--shop-primary);" data-tippy-content="Produits similaires">
                    <i class="fa fa-list"></i>
                </a>
                <a href="index.php?r=addproduit&id='.$row['id'].'&start='.$rowstr.'" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:var(--shop-primary);" data-tippy-content="Images">
                    <i class="fa fa-image"></i>
                </a>
                <a href="index.php?r=fichesTechniques&id='.$row['id'].'&start='.$rowstr.'&action=addFiche" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:var(--shop-primary);" data-tippy-content="Fiche technique">
                    <i class="fa fa-file-pdf-o"></i>
                </a>
                <a href="index.php?r=facilitePaiement&id='.$row['id'].'&start='.$rowstr.'" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:var(--shop-primary);" data-tippy-content="Paiement">
                    <i class="fa fa-dollar"></i>
                </a>
                <a href="javascript:void(0);" onclick="confirmGlobalDelete(\'index.php?r=produits&id='.$row['id'].'&start='.$rowstr.'&action=supp\')" class="admin-btn admin-btn-ghost btn-sm" style="padding:0.4rem 0.6rem; color:#EF4444;" data-tippy-content="Supprimer">
                    <i class="fa fa-trash"></i>
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