<?php
$conn = mysqli_connect('localhost', 'root', '', 'shop');
$res = mysqli_query($conn, 'SELECT id, titre FROM categories_blog');
while($r = mysqli_fetch_assoc($res)) echo $r['id'].' - '.$r['titre']."\n";
?>
