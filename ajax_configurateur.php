<?php
// ajax_configurateur.php
include("include.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_kits') {
    $response = array();
    $kits = array();
    
    $req = "SELECT * FROM conf_kits WHERE etat = 1 ORDER BY ordre ASC";
    $res = executeRequete($req);
    while($row = mysqli_fetch_assoc($res)) {
        $kits[] = array(
            'id' => $row['id'],
            'titre' => afficheChamp($row['titre']),
            'description' => afficheChamp($row['description'])
        );
    }
    
    $response['status'] = 'success';
    $response['kits'] = $kits;
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

if ($action == 'get_steps') {
    $kit_id = isset($_GET['kit_id']) ? intval($_GET['kit_id']) : 0;
    $response = array();
    
    // 1. Récupérer le kit
    $req_kit = "SELECT * FROM conf_kits WHERE id = '$kit_id' AND etat = 1";
    $res_kit = executeRequete($req_kit);
    if($kit = mysqli_fetch_assoc($res_kit)) {
        $response['kit'] = array(
            'id' => $kit['id'],
            'titre' => afficheChamp($kit['titre'])
        );
        
        $steps = array();
        
        // 2. Récupérer les étapes de ce kit
        $req_etapes = "SELECT * FROM conf_etapes WHERE id_kit = '$kit_id' ORDER BY ordre ASC";
        $res_etapes = executeRequete($req_etapes);
        
        while($etape = mysqli_fetch_assoc($res_etapes)) {
            $step = array(
                'id' => $etape['id'],
                'titre' => afficheChamp($etape['titre']),
                'type_lien' => $etape['type_lien'],
                'obligatoire' => intval($etape['obligatoire'] ?? 1),
                'produits' => array()
            );
            
            // 3. Récupérer les produits selon le type de lien
            if($etape['type_lien'] == 'categorie') {
                $req_prods = "SELECT id, titre, link, prix_vente, photo, etat_stock FROM produits WHERE categorie = '".$etape['id_lien']."' AND etat = '1' ORDER BY ordre ASC";
            } else if($etape['type_lien'] == 'produit') {
                $req_prods = "SELECT id, titre, link, prix_vente, photo, etat_stock FROM produits WHERE id = '".$etape['id_lien']."' AND etat = '1'";
            } else {
                continue;
            }
            
            $res_prods = executeRequete($req_prods);
            
            if ($res_prods) {
                while ($prod = mysqli_fetch_assoc($res_prods)) {
                    $prix = prixVenteProduits($prod['id'], true);
                    $prix_promo = prixPromoProduits($prod['id'], true);
                    $prix_final = ($prix_promo > 0 && $prix_promo < $prix) ? $prix_promo : $prix;
                    
                    $p = array(
                        'id' => $prod['id'],
                        'titre' => html_entity_decode(afficheChamp($prod['titre']), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        'link' => afficheChamp($prod['link']),
                        'prix' => floatval($prix_final),
                        'prix_formate' => number_format((float)$prix_final, 3, ',', ' ') . ' TND',
                        'photo' => photoProduitsSite($prod['id']),
                        'stock' => intval($prod['etat_stock']),
                        'caracteristiques' => array()
                    );
                    
                    // 4. Caractéristiques
                    $req_carac = "SELECT cp.idcarac, cp.valeur, c.titre as nom_carac FROM caracteristique_prod cp LEFT JOIN caracteristiques c ON cp.idcarac = c.id WHERE cp.idproduit = '".$prod['id']."'";
                    $res_carac = executeRequete($req_carac);
                    if ($res_carac) {
                        while ($carac = mysqli_fetch_assoc($res_carac)) {
                            $val_name = $carac['valeur'];
                            if (is_numeric($val_name)) {
                                $req_val = "SELECT valeur FROM valeur_caracteristique WHERE id = '".$val_name."' LIMIT 1";
                                $res_val = executeRequete($req_val);
                                if ($res_val && $val_row = mysqli_fetch_assoc($res_val)) {
                                    $val_name = $val_row['valeur'];
                                }
                            }
                            $p['caracteristiques'][trim(afficheChamp($carac['nom_carac']))] = trim(afficheChamp($val_name));
                        }
                    }
                    
                    $step['produits'][] = $p;
                }
            }
            
            $steps[] = $step;
        }
        
        $response['status'] = 'success';
        $response['steps'] = $steps;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Kit introuvable';
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
