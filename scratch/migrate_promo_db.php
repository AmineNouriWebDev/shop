<?php
include("../include.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Starting DB Migration for Promo Engine...<br>";

// 1. You cannot use IF NOT EXISTS for ADD COLUMN in MariaDB < 10.6, so we suppress errors if it exists.
$sql1 = "ALTER TABLE `produits` ADD COLUMN `promo_end_date` DATETIME NULL DEFAULT NULL AFTER `prix_promo`";
if (@mysqli_query($connexion, $sql1)) {
    echo "Added promo_end_date to produits.<br>";
} else {
    echo "promo_end_date column might already exist (or error): " . mysqli_error($connexion) . "<br>";
}

$sql2 = "ALTER TABLE `produits` ADD COLUMN `is_flash` TINYINT(1) DEFAULT '0' AFTER `promo_end_date`";
if (@mysqli_query($connexion, $sql2)) {
    echo "Added is_flash to produits.<br>";
} else {
    echo "is_flash column might already exist (or error): " . mysqli_error($connexion) . "<br>";
}

echo "DB migration completed.<br>";
?>
