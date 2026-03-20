<?php
$_SERVER['SERVER_NAME'] = 'localhost';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "connec.php";

// Define a minimal ouvrirCnx if fction_db is missing or just include it properly
include "_admin_site/includes/fonctions/fction_db.php";

$conn = ouvrirCnx();
$res = mysqli_query($conn, "DESCRIBE liste_section_content");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

// Alter table to add the columns if they don't exist
$columns = [];
mysqli_data_seek($res, 0);
while($row = mysqli_fetch_assoc($res)) {
    $columns[] = $row['Field'];
}

if (!in_array('titre', $columns)) {
    mysqli_query($conn, "ALTER TABLE liste_section_content ADD COLUMN titre VARCHAR(255) DEFAULT ''");
    echo "Added titre column\n";
}
if (!in_array('contenu', $columns)) {
    mysqli_query($conn, "ALTER TABLE liste_section_content ADD COLUMN contenu TEXT");
    echo "Added contenu column\n";
}
if (!in_array('icone', $columns)) {
    mysqli_query($conn, "ALTER TABLE liste_section_content ADD COLUMN icone VARCHAR(100) DEFAULT ''");
    echo "Added icone column\n";
}
?>
