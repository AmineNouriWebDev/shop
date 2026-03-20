<?php
$c = mysqli_connect('localhost', 'root', '', 'technopl_db');
echo "\n--- RAW DB QUERY --- \n";
$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($c, $req);
$row = mysqli_fetch_assoc($res);

if (array_key_exists('developer_comment', $row)) {
    echo "Column exists in row. Value: \n";
    var_dump($row['developer_comment']);
} else {
    echo "Column DOES NOT exist in row!\n";
}

echo "\n--- GETTING DATA KEYS ---\n";
print_r(array_keys($row));
?>
