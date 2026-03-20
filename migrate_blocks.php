<?php
$_SERVER['SERVER_NAME'] = 'localhost';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "connec.php";
include "_admin_site/includes/fonctions/fction_db.php";

$conn = ouvrirCnx();

// Clean up old multi-blocks for Ticker and Trust
mysqli_query($conn, "DELETE FROM bloc_accueil WHERE type_section IN (8, 9)");
mysqli_query($conn, "DELETE FROM liste_section_content WHERE idbloc NOT IN (SELECT id FROM bloc_accueil)");

// 1. Create one parent block for Ticker
mysqli_query($conn, "INSERT INTO bloc_accueil (titre, type_section, ordre, etat, datecreation) VALUES ('Bandeau Défilant (Ticker)', 8, 1, 1, '" . date('Y-m-d H:i:s') . "')");
$ticker_id = mysqli_insert_id($conn);

// Insert the 6 Ticker items into liste_section_content
$tickers = [
    "🔥 Offres Flash du Jour",
    "📦 Livraison offerte dès 100 DT",
    "🛡️ Garantie constructeur 12 mois",
    "💳 Paiement sécurisé",
    "🔄 Retour sous 30 jours",
    "📞 Support 55 55 55 55"
];
foreach($tickers as $t) {
    mysqli_query($conn, "INSERT INTO liste_section_content (idbloc, titre) VALUES ($ticker_id, '" . mysqli_real_escape_string($conn, $t) . "')");
}

// 2. Create one parent block for Trust
mysqli_query($conn, "INSERT INTO bloc_accueil (titre, type_section, ordre, etat, datecreation) VALUES ('Section de Réassurance (Trust)', 9, 2, 1, '" . date('Y-m-d H:i:s') . "')");
$trust_id = mysqli_insert_id($conn);

// Insert the 4 Trust items into liste_section_content
$trusts = [
    ['Livraison rapide', 'Offerte dès 100 DT', 'fa-solid fa-truck'],
    ['Garantie officielle', '12 mois constructeur', 'fa-solid fa-shield'],
    ['Retour facile', '30 jours sans frais', 'fa-solid fa-rotate'],
    ['Paiement sécurisé', 'SSL 256-bit', 'fa-regular fa-credit-card']
];
foreach($trusts as $tr) {
    mysqli_query($conn, "INSERT INTO liste_section_content (idbloc, titre, contenu, icone) VALUES ($trust_id, '" . mysqli_real_escape_string($conn, $tr[0]) . "', '" . mysqli_real_escape_string($conn, $tr[1]) . "', '" . mysqli_real_escape_string($conn, $tr[2]) . "')");
}

echo "Database migrated successfully: One parent block created for Ticker ($ticker_id) and Trust ($trust_id) and items added to liste_section_content.\n";
?>
