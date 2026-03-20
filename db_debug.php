<?php
include 'connec.php';
$res = mysqli_query($connexion, "SHOW COLUMNS FROM site_configuration");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
echo "--- BLOCS ---\n";
$res2 = mysqli_query($connexion, "SELECT * FROM bloc_accueil WHERE type = 'Texte Topbar'");
while($row2 = mysqli_fetch_assoc($res2)) {
    print_r($row2);
}
?>
