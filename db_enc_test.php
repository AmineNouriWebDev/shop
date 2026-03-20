<?php
include("connec.php");

// Set charset to utf8 explicitly just in case
mysqli_set_charset($connexion, "utf8");

// Try to find a bad string
$req = "SELECT id, titre, description FROM produits WHERE description LIKE '%Ã‰cran%' OR titre LIKE '%T?l?viseurs%' LIMIT 5";
$res = mysqli_query($connexion, $req);
if (mysqli_num_rows($res) === 0) {
    echo "No matching encoding issues found with Ã‰cran... looking for Ã or ðŸ...<br>";
    $req = "SELECT id, titre, description FROM produits WHERE description LIKE '%Ã%' OR description LIKE '%ðŸ%' LIMIT 5";
    $res = mysqli_query($connexion, $req);
}

while ($row = mysqli_fetch_assoc($res)) {
    echo "<h3>ID: " . $row['id'] . "</h3>";
    $desc = $row['description'];
    echo "<b>Original:</b> " . htmlspecialchars(substr($desc, 0, 100)) . "<br>";
    
    // Test 1: utf8_decode
    $test1 = utf8_decode($desc);
    echo "<b>utf8_decode:</b> " . htmlspecialchars(substr($test1, 0, 100)) . "<br>";
    
    // Test 2: mb_convert_encoding(..., 'ISO-8859-1', 'UTF-8')
    $test2 = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');
    echo "<b>mb_convert to ISO:</b> " . htmlspecialchars(substr($test2, 0, 100)) . "<br>";
    
    // Test 3: check if it's CP1252
    $test3 = mb_convert_encoding($desc, 'Windows-1252', 'UTF-8');
    echo "<b>mb_convert to CP1252:</b> " . htmlspecialchars(substr($test3, 0, 100)) . "<br>";
}
echo "<br>Done.";
?>
