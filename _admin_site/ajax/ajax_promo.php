<?php
// ajax_promo.php
include("../../include.php");

if(!isset($_GET['action'])) exit;
$action = $_GET['action'];

if ($action == 'search') {
    $q = mysqli_real_escape_string($connexion, $_GET['q']);
    $req = "SELECT id, titre, photo FROM produits WHERE titre LIKE '%$q%' ORDER BY id DESC LIMIT 10";
    $res = executeRequete($req);
    
    if(mysqli_num_rows($res) == 0) {
        echo '<div class="p-4 text-center text-gray-500 dark:text-gray-400">Aucun produit trouvé.</div>';
    } else {
        while($row = mysqli_fetch_assoc($res)) {
            $img = !empty($row['photo']) ? '../media/products/'.$row['photo'] : '../media/products/image_non_dispo.jpg';
            echo '<div onclick="selectProduitPromo('.$row['id'].')" class="flex items-center p-3 border-b cursor-pointer transition-colors duration-200" style="border-color:rgba(0,0,0,0.1);" onmouseover="this.style.background=\'rgba(0,0,0,0.05)\'" onmouseout="this.style.background=\'transparent\'">';
            echo '<img src="'.$img.'" class="w-12 h-12 object-cover rounded shadow-sm mr-4" alt="img">';
            echo '<span class="font-medium" style="color:inherit;">'.htmlspecialchars($row['titre']).'</span>';
            echo '</div>';
        }
    }
    exit;
}

if ($action == 'load_config') {
    $id = intval($_GET['id']);
    $req = "SELECT * FROM produits WHERE id='$id'";
    $res = executeRequete($req);
    $prod = mysqli_fetch_assoc($res);
    if(!$prod) exit("Produit introuvable.");

    // Check variations
    $req_var = "SELECT * FROM produit_variations WHERE idproduit='$id'";
    $res_var = executeRequete($req_var);
    $has_var = mysqli_num_rows($res_var) > 0;
    
    // Existing values
    $is_flash = $prod['is_flash'] == '1';
    
    // Reverse engineer duration
    $m = 0; $d = 0; $h = 0;
    if (!empty($prod['promo_end_date'])) {
        $end = new DateTime($prod['promo_end_date']);
        $now = new DateTime();
        if ($end > $now) {
            $diff = $now->diff($end);
            $m = $diff->m + ($diff->y * 12);
            $d = $diff->d;
            $h = $diff->h;
        }
    }
    
    echo '<form onsubmit="submitPromoForm(event, this)" class="pb-10 pt-2 px-2">';
    echo '<input type="hidden" name="id_produit" value="'.$id.'">';
    
    echo '<div class="mb-6">';
    echo '<h5 class="text-xl font-bold" style="color:inherit;">Confguration promo : <span style="color:#3b82f6;">'.htmlspecialchars($prod['titre']).'</span></h5>';
    echo '</div>';
    
    // 1. PRICE CONFIGURATION
    echo '<div class="mb-8">';
    echo '<h6 class="text-md font-bold uppercase tracking-wide pb-2 mb-4" style="color:inherit; border-bottom:1px solid rgba(0,0,0,0.1);">1. Grille Tarifaire</h6>';
    echo '<div class="overflow-x-auto rounded-lg p-1 shadow-inner" style="background:transparent; border:1px solid rgba(0,0,0,0.1);">';
    echo '<table class="w-full text-sm text-left" style="color:inherit;">';
    echo '<thead class="text-xs uppercase" style="background:rgba(0,0,0,0.05);"><tr><th class="px-4 py-3 rounded-tl-lg">Type / Déclinaison</th><th class="px-4 py-3">Prix Actuel</th><th class="px-4 py-3 rounded-tr-lg">Prix Promo</th></tr></thead>';
    echo '<tbody class="divide-y" style="background:transparent; border-color:rgba(0,0,0,0.1);">';
    
    if (!$has_var) {
        $pv = $prod['prix_vente'];
        $pp = $prod['prix_promo'] > 0 ? $prod['prix_promo'] : '';
        echo '<tr class="transition-colors" onmouseover="this.style.background=\'rgba(0,0,0,0.05)\'" onmouseout="this.style.background=\'transparent\'">';
        echo '<td class="px-4 py-3 font-medium leading-tight" style="color:inherit;">Produit principal</td>';
        echo '<td class="px-4 py-3 line-through" style="opacity:0.6;">'.number_format((float)$pv, 3, '.', '').' DT</td>';
        echo '<td class="px-4 py-3">';
        echo '<input type="number" step="0.001" name="global_prix_promo" value="'.$pp.'" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm outline-none" style="background:transparent; color:inherit; border-color:rgba(0,0,0,0.2);" placeholder="Ex: 59.990" required>';
        echo '</td>';
        echo '</tr>';
    } else {
        while($var = mysqli_fetch_assoc($res_var)) {
            $vid = $var['id'];
            $vlabel = $var['label'];
            $v_pv = $var['prix_vente'];
            $v_pp = $var['prix_promo'] > 0 ? $var['prix_promo'] : '';
            
            echo '<tr class="transition-colors" onmouseover="this.style.background=\'rgba(0,0,0,0.05)\'" onmouseout="this.style.background=\'transparent\'">';
            echo '<td class="px-4 py-3 font-medium leading-tight" style="color:inherit;">'.htmlspecialchars($vlabel).'</td>';
            echo '<td class="px-4 py-3 line-through" style="opacity:0.6;">'.number_format((float)$v_pv, 3, '.', '').' DT</td>';
            echo '<td class="px-4 py-3">';
            echo '<input type="number" step="0.001" name="var_promo['.$vid.']" value="'.$v_pp.'" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm outline-none" style="background:transparent; color:inherit; border-color:rgba(0,0,0,0.2);" placeholder="0.000" required>';
            echo '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
    echo '</div></div>';

    // 2. DURATION CONFIGURATION
    echo '<div class="mb-8 p-5 rounded-xl shadow-sm" style="background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.2);">';
    echo '<h6 class="text-md font-bold mb-2" style="color:inherit;">2. Durée de la Promotion</h6>';
    echo '<p class="text-xs mb-4" style="color:#3b82f6;">Le chronomètre démarre au moment de la sauvegarde. Une durée à 0 rendra l\'offre valide indéfiniment.</p>';
    echo '<div class="flex flex-wrap gap-4">';
    
    echo '<div class="flex-1 min-w-[80px]">';
    echo '<label class="block mb-2 text-sm font-medium" style="color:inherit;">Mois</label>';
    echo '<input type="number" min="0" name="d_mois" value="'.$m.'" class="border text-md font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm text-center outline-none" style="background:transparent; color:inherit; border-color:rgba(0,0,0,0.2);">';
    echo '</div>';
    
    echo '<div class="flex-1 min-w-[80px]">';
    echo '<label class="block mb-2 text-sm font-medium" style="color:inherit;">Jours</label>';
    echo '<input type="number" min="0" name="d_jours" value="'.$d.'" class="border text-md font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm text-center outline-none" style="background:transparent; color:inherit; border-color:rgba(0,0,0,0.2);">';
    echo '</div>';
    
    echo '<div class="flex-1 min-w-[80px]">';
    echo '<label class="block mb-2 text-sm font-medium" style="color:inherit;">Heures</label>';
    echo '<input type="number" min="0" name="d_heures" value="'.$h.'" class="border text-md font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm text-center outline-none" style="background:transparent; color:inherit; border-color:rgba(0,0,0,0.2);">';
    echo '</div>';
    
    echo '</div></div>';

    // 3. FLASH TOGGLE
    echo '<div class="mb-8 p-5 rounded-xl border shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4" style="background:rgba(249,115,22,0.1); border-color:rgba(249,115,22,0.2);">';
    echo '<div>';
    echo '<h6 class="text-md font-bold" style="color:#c2410c;">3. Mode Vente Flash 🔥</h6>';
    echo '<p class="text-xs mt-1 max-w-sm" style="color:#c2410c; opacity:0.9;">Si activé, l\'étiquette Flash et le décompteur dynamique s\'afficheront sur la boutique pour stimuler l\'urgence (nécessite Durée > 0).</p>';
    echo '</div>';
    echo '<label class="relative inline-flex items-center cursor-pointer shrink-0">';
    echo '<input type="checkbox" name="is_flash" class="sr-only peer" '.($is_flash?'checked':'').'>';
    echo '<div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-orange-500" style="opacity:0.8;"></div>';
    echo '</label>';
    echo '</div>';

    // 4. BUTTONS
    echo '<div class="flex items-center justify-end pt-5 mt-2 gap-3 pb-8" style="border-top:1px solid rgba(0,0,0,0.1);">';
    echo '<button type="button" class="focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border text-sm font-medium px-5 py-2.5 transition-colors" style="background:rgba(0,0,0,0.05); color:inherit; border-color:rgba(0,0,0,0.1);" onclick="closePromoModal()" onmouseover="this.style.background=\'rgba(0,0,0,0.1)\'" onmouseout="this.style.background=\'rgba(0,0,0,0.05)\'">Annuler</button>';
    echo '<button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 shadow-lg shadow-blue-500/50 transition-all" style="border:none;">Enregistrer la Promotion</button>';
    echo '</div>';
    echo '</form>';
    exit;
}

if ($action == 'save') {
    header('Content-Type: application/json');
    $id = intval($_POST['id_produit']);
    if ($id <= 0) { echo json_encode(['success'=>false, 'error'=>'ID invalide']); exit; }

    $m = max(0, intval($_POST['d_mois'] ?? 0));
    $d = max(0, intval($_POST['d_jours'] ?? 0));
    $h = max(0, intval($_POST['d_heures'] ?? 0));
    
    if ($m == 0 && $d == 0 && $h == 0) {
        $promo_end = "NULL"; 
    } else {
        $date = new DateTime();
        if($m > 0) $date->modify("+$m month");
        if($d > 0) $date->modify("+$d day");
        if($h > 0) $date->modify("+$h hour");
        $promo_end = "'".$date->format('Y-m-d H:i:s')."'";
    }

    $is_flash = isset($_POST['is_flash']) ? 1 : 0;
    if ($promo_end === "NULL") $is_flash = 0; 

    $base_promo_for_main = 0;
    if (isset($_POST['var_promo']) && is_array($_POST['var_promo'])) {
        $first = true;
        foreach($_POST['var_promo'] as $vid => $vpp) {
            $vid = intval($vid);
            $vpp = floatval($vpp);
            if ($first || ($vpp > 0 && ($base_promo_for_main == 0 || $vpp < $base_promo_for_main))) {
                 $base_promo_for_main = $vpp;
            }
            $first = false;
            executeRequete("UPDATE produit_variations SET prix_promo = '".number_format($vpp, 3, '.', '')."' WHERE id = '$vid' AND idproduit = '$id'");
        }
    } else {
        $base_promo_for_main = floatval($_POST['global_prix_promo'] ?? 0);
    }
    
    $query = "UPDATE produits SET 
              promo_end_date = $promo_end, 
              is_flash = '$is_flash', 
              prix_promo = '".number_format($base_promo_for_main, 3, '.', '')."' 
              WHERE id = '$id'";
    executeRequete($query);

    echo json_encode(['success'=>true]);
    exit;
}
?>
