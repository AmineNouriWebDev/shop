<?php
require 'connec.php';

echo "Developer comment from DB array: \n";
$req = 'SELECT developer_comment FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$row = mysqli_fetch_assoc($res);
var_dump($row);

echo "\nDeveloper comment parsed by afficher: \n";
var_dump(afficher($row['developer_comment']));

echo "\nDeveloper comment global var: \n";
var_dump($developer_comment);
?>
