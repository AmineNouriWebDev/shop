<?php
require 'connec.php';

echo "connec loop output: \n";
$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$data = mysqli_fetch_array($res);
if ($data) {
    echo "Developer comment value inside loop: \n";
    var_dump($data['developer_comment']);
    
    foreach ($data as $key => $value) {
       if (!is_numeric($key)) {
           if ($key === 'developer_comment') {
               $$key = $value; // Preserve HTML
               echo "Assigned developer_comment statically.\n";
           } else {
               $$key = afficher($value);
           }
       }
    }
}

echo "Did global assignment work? \n";
var_dump($developer_comment);
?>
