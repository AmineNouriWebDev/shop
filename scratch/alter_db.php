<?php
include('connec.php');
$check = mysqli_query($connexion, "SHOW COLUMNS FROM site_configuration LIKE 'afficher_abonnements'");
if(mysqli_num_rows($check) == 0) {
    mysqli_query($connexion, "ALTER TABLE site_configuration ADD COLUMN afficher_abonnements enum('0','1') NOT NULL DEFAULT '1'");
    echo "Column added.";
} else {
    echo "Column exists.";
}
