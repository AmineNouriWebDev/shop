<?php
$c = mysqli_connect('localhost', 'root', '', 'shop');
$q = mysqli_query($c, 'DESCRIBE site_configuration');
while($r = mysqli_fetch_assoc($q)){ echo $r['Field']."\n"; }
?>
