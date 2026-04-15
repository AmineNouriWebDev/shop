<?php
include("../include.php");
$r=mysqli_query($connexion, "SELECT id, idparent FROM categories_blog WHERE idparent=0 OR id=0");
while($row=mysqli_fetch_assoc($r)) var_dump($row['id'], $row['idparent']);
