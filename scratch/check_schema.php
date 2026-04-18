<?php
include("../include.php");
$res = mysqli_query($connexion, "SHOW COLUMNS FROM produits");
echo "TABLE produits:\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}

echo "\nTABLE produit_variations:\n";
$res = @mysqli_query($connexion, "SHOW COLUMNS FROM produit_variations");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "Table does not exist or error.\n";
}
?>
