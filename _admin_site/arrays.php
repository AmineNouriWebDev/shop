<?php 

include('../include.php');
                                        
// Reading value
$draw = $_POST['draw'];
$rowstr = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
//$searchValue = mysqli_real_escape_string(ouvrirCnx(),$_POST['search']['value']); // Search value 


## Custom Field value
$searchByTitle = mysqli_real_escape_string(ouvrirCnx(),url_rewrite($_POST['searchByTitle']));
$searchByCateg = mysqli_real_escape_string(ouvrirCnx(),url_rewrite($_POST['searchByCateg']));
$searchByMarque = mysqli_real_escape_string(ouvrirCnx(),url_rewrite($_POST['searchByMarque']));

## Search 
$searchQuery = " ";

if($searchByTitle != ''){
   $searchQuery .= " and ( pr.link LIKE '%".nett($searchByTitle)."%' or pr.titre LIKE '%".$searchByTitle."%' ) ";
}
if($searchByCateg != ''){
   $searchQuery .= " and ( ( ctg.titre LIKE '%".$searchByCateg."%'  &&  pr.categorie = ctg.id ) or ( ctg.link LIKE '%".nett($searchByCateg)."%'  && pr.categorie = ctg.id ) OR ( ctg.titre LIKE '%".$searchByCateg."%'  &&  ctg.id = pr.idparent_categ ) OR ( ctg.link LIKE '%".$searchByCateg."%'  &&  ctg.id = pr.idparent_categ ) ) ";
}
if($searchByMarque != ''){
   $searchQuery .= " and ( mr.raison LIKE '%".$searchByMarque."%'  && pr.marque = mr.id ) ";
}

// Total number of records without filtering
$sel = executeRequete("SELECT COUNT(*) AS allcount FROM produits ");
$records = mysqli_fetch_array($sel);
$totalRecords = $records['allcount'];

// Total number of records with filtering

$selwithFilter   = "SELECT COUNT(DISTINCT(pr.id)) AS allcount FROM `produits` pr, `marques` mr , `categories_blog` ctg WHERE 1 ".$searchQuery;
//echo $selwithFilter;
$reswithFilter   = executeRequete($selwithFilter);
$recordwithFilter = mysqli_fetch_array($reswithFilter);
$totalRecordwithFilter = $recordwithFilter['allcount']; 
//echo $totalRecordwithFilter;

$empQuery = "SELECT DISTINCT(pr.id) FROM `produits` pr, `marques` mr , `categories_blog` ctg WHERE 1 ".$searchQuery;

if(!empty($_POST["order"])){
	$empQuery .= ' ORDER BY pr.'.$columnName.' '.$columnSortOrder.' ';
} else {
	$empQuery .= ' ORDER BY pr.id DESC ';
}

	
	if($rowperpage != -1 && $rowperpage != ''){
		$empQuery .= ' LIMIT ' . $rowstr . ', ' . $rowperpage;
	}
	
	//echo $empQuery;
	
$empRecords = executeRequete($empQuery);
$data = array();   
while ($row = mysqli_fetch_array($empRecords)) {
    
    //$idprt = idparentCategBlog(categorieProduits($row['id']));
    
    //$idp = $row['id'];
    
    //$req = executeRequete("UPDATE `produits` SEt idparent_categ = '$idprt' WHERE id = '$idp'  ");
        
    if(prixPromoProduits($row['id']) != '0.000') { $price = prixPromoProduits($row['id']).' DT <span style="text-decoration:line-through">'.prixVenteProduits($row['id']).' DT </span>'; }else{ $price = prixVenteProduits($row['id']).' DT'; } 
    
    if( typeProduits($row['id']) == "E") $type = "Equipement" ; else $type = "Abonnement";

    if(idparentCategBlog(categorieProduits($row['id'])) != 0 ){
        
            $data[] = array( 
            "" => '<input type="checkbox" class="sub_chk" data-id="'.afficheChamp($row['id']).'" style="position:relative;left:0;opacity:1">',
            "produit" => photoProduits($row['id']).' '.titreProduits($row['id']),
            "prix_vente" => $price ,
            "categorie" => titreCategBlog(idparentCategBlog(categorieProduits($row['id']))). '<br/> |--> '.titreCategBlog(categorieProduits($row['id'])),
            "marque" => raisonMarque(marquesProduits($row['id'])),
            "type" => $type,
            "datecreation" => auteur_name(auteurProduits($row['id'])).' <br/> '.datecreationProduits($row['id']),
            "action" => '<a href="index.php?r=mproduits&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse mr-2"></i> </a>
                <a href="index.php?r=addproduitssimilaire&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter produits similaire"> <i class="fa fa-list text-inverse mr-2"></i> </a>
                <a href="index.php?r=addproduit&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter images suplimentaires"> <i class="fa fa-image text-inverse mr-2"></i> </a>
                <a href="index.php?r=fichesTechniques&id='.afficheChamp($row['id']).'&start='.$rowstr.'&action=addFiche" data-toggle="tooltip" data-original-title="Ajouter fiche technique"> <i class="fa fa-file-pdf-o text-inverse mr-2"></i></a>
                <a href="index.php?r=facilitePaiement&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter detail paiement"> <i class="fa fa-dollar text-inverse mr-2"></i></a>
                <a href="index.php?r=produits&id='.afficheChamp($row['id']).'&start='.$rowstr.'&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger mr-2"></i></a>'
            );
        
    }else{
        
            $data[] = array( 
            "" => '<input type="checkbox" class="sub_chk" data-id="'.afficheChamp($row['id']).'" style="position:relative;left:0;opacity:1">',
            "produit" => photoProduits($row['id']).' '.titreProduits($row['id']),
            "prix_vente" => $price,
            "categorie" => titreCategBlog(categorieProduits($row['id'])),
            "marque" => raisonMarque(marquesProduits($row['id'])),
            "type" => $type,
            "datecreation" => auteur_name(auteurProduits($row['id'])).' <br/> '.datecreationProduits($row['id']),
            "action" => '<a href="index.php?r=mproduits&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Modifier"> <i class="fa fa-pencil text-inverse mr-2"></i> </a>
                <a href="index.php?r=addproduitssimilaire&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter produits similaire"> <i class="fa fa-list text-inverse mr-2"></i> </a>
                <a href="index.php?r=addproduit&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter images suplimentaires"> <i class="fa fa-image text-inverse mr-2"></i> </a>
                <a href="index.php?r=fichesTechniques&id='.afficheChamp($row['id']).'&start='.$rowstr.'&action=addFiche" data-toggle="tooltip" data-original-title="Ajouter fiche technique"> <i class="fa fa-file-pdf-o text-inverse mr-2"></i></a>
                <a href="index.php?r=facilitePaiement&id='.afficheChamp($row['id']).'&start='.$rowstr.'" data-toggle="tooltip" data-original-title="Ajouter detail paiement"> <i class="fa fa-dollar text-inverse mr-2"></i></a>
                <a href="index.php?r=produits&id='.afficheChamp($row['id']).'&start='.$rowstr.'&action=supp" data-toggle="tooltip" data-original-title="Supprimer"> <i class="fa fa-close text-danger mr-2"></i></a>'
            );
        
        
    }
}

//print_r($data);


## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "data" => $data,
  "start"=> $rowstr
);

//print_r($response);

echo json_encode($response);

   
  ?>