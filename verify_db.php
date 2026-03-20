<?php
include('_admin_site/includes/include.php');
$cnx = ouvrirCnx();
$res = mysqli_query($cnx, "DESCRIBE produits");
echo "<pre>";
while($row = mysqli_fetch_assoc($res)) {
    if(in_array($row['Field'], ['note_avis', 'nb_avis'])) {
        print_r($row);
    }
}
$res2 = mysqli_query($cnx, "SHOW TABLES LIKE 'avis_produits'");
if(mysqli_num_rows($res2) > 0) {
    echo "Table avis_produits exists\n";
    $res3 = mysqli_query($cnx, "DESCRIBE avis_produits");
    while($row = mysqli_fetch_assoc($res3)) {
        print_r($row);
    }
} else {
    echo "Table avis_produits MISSING\n";
}

$res4 = mysqli_query($cnx, "SELECT COUNT(*) as cnt, AVG(note_avis) as avg_note FROM produits WHERE note_avis > 0");
$row4 = mysqli_fetch_assoc($res4);
echo "Seeded products: " . $row4['cnt'] . " (Avg: " . round($row4['avg_note'], 2) . ")\n";
echo "</pre>";
?>
