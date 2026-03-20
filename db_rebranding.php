<?php
include("connec.php");
mysqli_set_charset($connexion, "utf8");

function fixEncodingAndRebrand($text) {
    if (empty($text)) return $text;
    
    // 1. Repair Encoding
    if (strpos($text, 'Ã') !== false || strpos($text, 'ðŸ') !== false || strpos($text, 'â') !== false) {
        $repaired = @mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
        if ($repaired) {
            $text = $repaired;
        }
    }
    
    // 2. Rebranding
    $text = str_replace('technoplus.tn', 'offipro.net', $text);
    $text = str_replace('technoplus.io', 'offipro.net', $text);
    $text = str_replace('TechnoPlus', 'offipro', $text);
    $text = str_replace('Technoplus', 'offipro', $text);
    $text = str_replace('technoplus', 'offipro', $text);
    
    // Edge case if user typed 'T?l?viseurs' manually, this isn't caught by the decoding above.
    if (strpos($text, 'T?l?viseurs') !== false) {
        $text = str_replace('T?l?viseurs', 'Téléviseurs', $text);
    }
    
    return $text;
}

$tables = [
    'produits' => ['titre', 'titre_page', 'description', 'keywords', 'url_video'],
    'categories_blog' => ['titre', 'titre_page', 'description', 'keywords'],
    'bloc_accueil' => ['titre', 'contenu', 'lien'],
    'site_configuration' => ['nom_site', 'description_meta', 'keywords_meta', 'adresse_contact'],
    'site_menu' => ['titre', 'link', 'titre_page', 'description', 'keywords']
];

$updates = 0;

foreach ($tables as $table => $columns) {
    $req = "SELECT id, " . implode(", ", $columns) . " FROM $table";
    $res = mysqli_query($connexion, $req);
    if (!$res) continue;
    
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $setClauses = [];
        
        foreach ($columns as $col) {
            $original = $row[$col];
            $fixed = fixEncodingAndRebrand($original);
            
            if ($fixed !== $original) {
                $setClauses[] = "`$col` = '" . mysqli_real_escape_string($connexion, $fixed) . "'";
            }
        }
        
        if (!empty($setClauses)) {
            $updateReq = "UPDATE $table SET " . implode(", ", $setClauses) . " WHERE id = $id";
            mysqli_query($connexion, $updateReq);
            $updates++;
        }
    }
}

echo "Database successfully processed. $updates rows updated.\n";
?>
