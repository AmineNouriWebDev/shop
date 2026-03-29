<?php
require("include.php");
$res = executeRequete("SELECT * FROM social_network WHERE titre LIKE '%elegram%'");
while($row = mysqli_fetch_assoc($res)) {
    echo "ID: " . $row['id'] . PHP_EOL;
    echo "Titre: " . $row['titre'] . PHP_EOL;
    echo "Etat: " . $row['etat'] . PHP_EOL;
    echo "Type: " . $row['type'] . PHP_EOL;
    echo "Icone: " . $row['icone'] . PHP_EOL;
    echo "Image: " . $row['image'] . PHP_EOL;
    echo "Lien: " . $row['lien'] . PHP_EOL;
}
unlink(__FILE__);
