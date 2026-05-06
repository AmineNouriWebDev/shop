<?php
include("include.php");

echo "Démarrage de la migration de la grille de catégories...\n\n";

// 1. Check if 'Grille Catégories' exists in liste_sections
$req_check_sec = "SELECT id FROM liste_sections WHERE titre = 'Grille Catégories'";
$res_check_sec = mysqli_query($connexion, $req_check_sec);

if (mysqli_num_rows($res_check_sec) > 0) {
    $row_sec = mysqli_fetch_assoc($res_check_sec);
    $section_id = $row_sec['id'];
    echo "Le type de section 'Grille Catégories' existe déjà (ID: $section_id).\n";
} else {
    // Determine an available ID. We'll force 10 if it's free, otherwise auto-increment.
    $req_id_10 = "SELECT id FROM liste_sections WHERE id = 10";
    $res_id_10 = mysqli_query($connexion, $req_id_10);
    if (mysqli_num_rows($res_id_10) == 0) {
        mysqli_query($connexion, "INSERT INTO liste_sections (id, titre, etat) VALUES (10, 'Grille Catégories', 1)");
        $section_id = 10;
    } else {
        mysqli_query($connexion, "INSERT INTO liste_sections (titre, etat) VALUES ('Grille Catégories', 1)");
        $section_id = mysqli_insert_id($connexion);
    }
    echo "Type de section 'Grille Catégories' créé avec l'ID: $section_id.\n";
}

// 2. Check if a block already uses this section
$req_check_bloc = "SELECT id FROM bloc_accueil WHERE type_section = '$section_id'";
$res_check_bloc = mysqli_query($connexion, $req_check_bloc);

if (mysqli_num_rows($res_check_bloc) > 0) {
    echo "Le bloc 'Catégories Rapides' existe déjà dans bloc_accueil. Arrêt de la migration pour ne pas créer de doublons.\n";
    exit;
}

// 3. Create the block in bloc_accueil
$datec = date("d/m/Y H:i:s"); // Assuming timestampTD is just date format or similar, we'll use straight date
mysqli_query($connexion, "INSERT INTO bloc_accueil 
    (titre, affichage_accueil, type_section, ordre, etat, num_rows, num_col, datecreation) 
    VALUES 
    ('Catégories Rapides', 1, '$section_id', 1, 1, 2, 7, '$datec')");

$idbloc = mysqli_insert_id($connexion);
echo "Bloc 'Catégories Rapides' créé dans bloc_accueil avec l'ID: $idbloc.\n";

// Shift order of other blocks if needed (optional, they will just follow ordre=1 naturally)
mysqli_query($connexion, "UPDATE bloc_accueil SET ordre = ordre + 1 WHERE id != '$idbloc' AND ordre >= 1");

// 4. Map and migrate categories
$req_cats = "SELECT * FROM `categories_blog` WHERE `etat` = '1' AND `idparent`='0' ORDER BY `ordre` LIMIT 14";
$res_cats = mysqli_query($connexion, $req_cats);

$faMap = [
    'television' => 'fa-solid fa-tv', 'tv' => 'fa-solid fa-tv', 'téléviseur' => 'fa-solid fa-tv',
    'smartphone' => 'fa-solid fa-mobile-screen-button', 'telephone' => 'fa-solid fa-mobile-screen-button', 'téléphonie' => 'fa-solid fa-mobile-screen-button', 'mobile' => 'fa-solid fa-mobile-screen-button',
    'pc' => 'fa-solid fa-laptop', 'ordinateur' => 'fa-solid fa-laptop', 'laptop' => 'fa-solid fa-laptop', 'informatique' => 'fa-solid fa-computer',
    'tablette' => 'fa-solid fa-tablet-screen-button', 'tablet' => 'fa-solid fa-tablet-screen-button',
    'accessoire' => 'fa-solid fa-headphones', 'audio' => 'fa-solid fa-headphones',
    'montre' => 'fa-solid fa-clock', 'watch' => 'fa-solid fa-clock', 'smartwatch' => 'fa-solid fa-clock',
    'camera' => 'fa-solid fa-camera', 'photo' => 'fa-solid fa-camera',
    'gaming' => 'fa-solid fa-gamepad', 'jeux' => 'fa-solid fa-gamepad', 'gamer' => 'fa-solid fa-gamepad',
    'récepteur' => 'fa-solid fa-satellite-dish', 'parabole' => 'fa-solid fa-satellite-dish', 'sat' => 'fa-solid fa-satellite-dish',
    'abonnement' => 'fa-solid fa-bell', 'iptv' => 'fa-solid fa-play', 'vod' => 'fa-solid fa-film',
    'composant' => 'fa-solid fa-microchip', 'processeur' => 'fa-solid fa-microchip',
    'imprimante' => 'fa-solid fa-print',
    'drone' => 'fa-solid fa-plane-up',
    'default' => 'fa-solid fa-layer-group',
];

function getCategFA($titre, $map) {
    $t = strtolower($titre);
    foreach ($map as $kw => $icon) {
        if ($kw !== 'default' && strpos($t, $kw) !== false) return $icon;
    }
    return $map['default'];
}

$count = 0;
while ($cat = mysqli_fetch_assoc($res_cats)) {
    $titre = mysqli_real_escape_string($connexion, $cat['titre']);
    $lien = mysqli_real_escape_string($connexion, "categorie.php?link=" . $cat['link']);
    $icone = getCategFA($cat['titre'], $faMap);
    
    $req_insert = "INSERT INTO liste_section_content (idbloc, titre, lien, icone) VALUES ('$idbloc', '$titre', '$lien', '$icone')";
    mysqli_query($connexion, $req_insert);
    $count++;
}

echo "$count catégories ont été migrées vers le nouveau bloc avec succès !\n";
echo "Migration terminée.\n";
?>
