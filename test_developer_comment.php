<?php
require 'connec.php';

echo "\n--- RAW DB QUERY --- \n";
$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$row = mysqli_fetch_assoc($res);

if (array_key_exists('developer_comment', $row)) {
    echo "Column exists in row. Value: \n";
    var_dump($row['developer_comment']);
} else {
    echo "Column DOES NOT exist in row!\n";
}

echo "\n--- GLOBAL SCOPE CHECK ---\n";
var_dump($developer_comment ?? 'NOT GLOBALLY DEFINED');

echo "\n--- GETTING DATA KEYS ---\n";
print_r(array_keys($row));
?>
