<?php
$_SERVER['SERVER_NAME'] = 'localhost';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "connec.php";
include "_admin_site/includes/fonctions/fction_db.php";

$conn = ouvrirCnx();

// 1. Add 'icone' column to bloc_accueil
mysqli_query($conn, "ALTER TABLE bloc_accueil ADD COLUMN IF NOT EXISTS icone VARCHAR(100) DEFAULT ''");

// 2. Add new section types if they don't exist
$new_sections = [
    'Texte Topbar',
    'Texte Ticker',
    'Icônes Confiance (Trust)'
];

foreach ($new_sections as $title) {
    $title_esc = mysqli_real_escape_string($conn, $title);
    $check = mysqli_query($conn, "SELECT id FROM liste_sections WHERE titre = '$title_esc'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO liste_sections (titre, etat) VALUES ('$title_esc', 1)");
        echo "Inserted: $title\n";
    } else {
        echo "Already exists: $title\n";
    }
}

echo "Database migrations complete.\n";
?>
