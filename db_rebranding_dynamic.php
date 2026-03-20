<?php
ini_set('opcache.enable', 0);
include("connec.php");
mysqli_set_charset($connexion, "utf8");

function fixEncodingAndRebrand($text) {
    if (empty($text) || !is_string($text)) return $text;
    
    // Repair double encoding (Windows-1252 interpreted as UTF-8)
    if (strpos($text, 'Ã') !== false || strpos($text, 'ðŸ') !== false || strpos($text, 'â') !== false) {
        $repaired = @mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
        if ($repaired) {
            $text = $repaired;
        }
    }
    
    // Rebranding replacements
    $text = str_replace('technoplus.tn', 'offipro.net', $text);
    $text = str_replace('technoplus.io', 'offipro.net', $text);
    $text = str_replace('TechnoPlus', 'offipro', $text);
    $text = str_replace('Technoplus', 'offipro', $text);
    $text = str_replace('technoplus', 'offipro', $text);
    $text = str_replace('T?l?viseurs', 'Téléviseurs', $text);
    
    return $text;
}

// These tables should be fully processed for rebranding and encoding
$target_tables = ['produits', 'categories_blog', 'bloc_accueil', 'site_configuration'];

$updates = 0;

foreach ($target_tables as $table) {
    // Dynamically get string columns
    $colRes = mysqli_query($connexion, "SHOW COLUMNS FROM `$table`");
    $columnsToUpdate = [];
    $primaryKey = 'id';
    
    while ($col = mysqli_fetch_assoc($colRes)) {
        if ($col['Key'] == 'PRI') {
            $primaryKey = $col['Field'];
        }
        
        $type = strtolower($col['Type']);
        // Exclude image fields
        $blockedNames = ['photo', 'image', 'fichier', 'pdf', 'logo', 'background'];
        $isBlocked = false;
        foreach ($blockedNames as $b) {
            if (strpos(strtolower($col['Field']), $b) !== false) $isBlocked = true;
        }
        
        if (!$isBlocked && (strpos($type, 'varchar') !== false || strpos($type, 'text') !== false)) {
            $columnsToUpdate[] = $col['Field'];
        }
    }
    
    if (empty($columnsToUpdate)) continue;
    
    // Process the table
    $query = "SELECT `$primaryKey`, " . implode(", ", array_map(function($c) { return "`$c`"; }, $columnsToUpdate)) . " FROM `$table`";
    $res = mysqli_query($connexion, $query);
    if (!$res) continue;
    
    while ($row = mysqli_fetch_assoc($res)) {
        $pkVal = $row[$primaryKey];
        $setClauses = [];
        
        foreach ($columnsToUpdate as $colName) {
            $original = $row[$colName];
            if ($original !== null && $original !== '') {
                $fixed = fixEncodingAndRebrand($original);
                if ($fixed !== $original) {
                    $setClauses[] = "`$colName` = '" . mysqli_real_escape_string($connexion, $fixed) . "'";
                }
            }
        }
        
        if (!empty($setClauses)) {
            $updateReq = "UPDATE `$table` SET " . implode(", ", $setClauses) . " WHERE `$primaryKey` = '" . mysqli_real_escape_string($connexion, $pkVal) . "'";
            mysqli_query($connexion, $updateReq) or die(mysqli_error($connexion));
            $updates++;
        }
    }
}

echo "Database fully scanned and fixed! $updates rows dynamically updated.\n";
?>
