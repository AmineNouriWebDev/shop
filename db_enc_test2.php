<?php
include("connec.php");
// Try without htmlspecialchars to avoid blanking
$req = "SELECT id, titre, description FROM produits WHERE description LIKE '%Ã%' OR description LIKE '%ðŸ%' LIMIT 2";
$res = mysqli_query($connexion, $req);

while ($row = mysqli_fetch_assoc($res)) {
    echo "<h3>ID: " . $row['id'] . "</h3>\n";
    $desc = $row['description'];
    
    // safe echo
    function se($str) { return htmlspecialchars($str, ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8'); }
    
    echo "<b>Original:</b> " . se(substr($desc, 0, 150)) . "<br>\n";
    $test1 = utf8_decode($desc);
    echo "<b>utf8_decode:</b> " . se(substr($test1, 0, 150)) . "<br>\n";
    $test2 = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');
    echo "<b>mb_convert to ISO:</b> " . se(substr($test2, 0, 150)) . "<br>\n";
    $test3 = mb_convert_encoding($desc, 'Windows-1252', 'UTF-8');
    echo "<b>mb_convert to CP1252:</b> " . se(substr($test3, 0, 150)) . "<br>\n";
}
echo "<br>Done.";
?>
