<?php
include 'connec.php';
$res = executeRequete("SELECT id, titre, link, idparent FROM site_menu ORDER BY id");
while($row = mysqli_fetch_assoc($res)) {
    echo "ID: " . $row['id'] . " | Titre: " . $row['titre'] . " | Link: " . $row['link'] . " | Parent: " . $row['idparent'] . "<br>";
}
?>
