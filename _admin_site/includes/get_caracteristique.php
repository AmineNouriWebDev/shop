<?php
include('../../include.php');

if(!empty($_POST['id_carac'])) {
    $carac_ids = is_array($_POST['id_carac']) ? $_POST['id_carac'] : explode(',', $_POST['id_carac']);
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    foreach ($carac_ids as $id_carac) {
        $id_carac = intval($id_carac);
        
        // Fetch characteristic title once
        $char_title = titreCaracteristiques($id_carac);

        // Fetch all values for this characteristic
        $query = "SELECT * FROM `valeur_caracteristique` WHERE `idcarac` = '$id_carac' ORDER BY `id` ASC";
        $results = executeRequete($query);

        while ($data = mysqli_fetch_assoc($results)) {
            $val_id = $data['id'];
            $val_text = $data['valeur'];
            
            $selected = "";
            if ($product_id > 0 && caracteristiques_val_prod($id_carac, $product_id, $val_id)) {
                $selected = "selected";
            }
            
            echo '<option value="' . $val_id . '" ' . $selected . '>' . $char_title . ' : ' . $val_text . '</option>';
        }
    }
}
?>
