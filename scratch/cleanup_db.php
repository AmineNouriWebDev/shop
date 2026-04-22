<?php
include '../connec.php';

$columns = ['google_font_link', 'google_font_family'];

foreach ($columns as $col) {
    $res = mysqli_query($connexion, "SHOW COLUMNS FROM `site_configuration` LIKE '$col'");
    if (mysqli_num_rows($res) > 0) {
        $drop = mysqli_query($connexion, "ALTER TABLE `site_configuration` DROP COLUMN `$col` ");
        if ($drop) {
            echo "Colonne $col supprimée avec succès.<br>";
        } else {
            echo "Erreur lors de la suppression de $col : " . mysqli_error($connexion) . "<br>";
        }
    } else {
        echo "La colonne $col n'existe pas.<br>";
    }
}
?>
