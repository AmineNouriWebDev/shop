<?php
include('connec.php');
$req = 'SELECT * FROM `site_configuration`';
$res = mysqli_query($connexion, $req);
$data = mysqli_fetch_array($res);
echo "Keys: \n";
print_r(array_keys($data));
?>
