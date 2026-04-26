<?php
$conn = mysqli_connect('localhost', 'root', '', 'shop');
mysqli_query($conn, "ALTER TABLE conf_etapes ADD obligatoire TINYINT(1) DEFAULT 1");
// Update Disque dur and Ecran to be optional to test
mysqli_query($conn, "UPDATE conf_etapes SET obligatoire = 0 WHERE id_lien IN (69, 74)");
echo "Done.";
?>
