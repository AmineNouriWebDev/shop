<?php
$conn = mysqli_connect('localhost', 'root', '', 'shop');
mysqli_query($conn, "TRUNCATE TABLE conf_etapes");

// Kit 1: Système Filaire (id=1)
// Step 1: Enregistreur (DVR) -> Cat 86
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (1, 'Enregistreur DVR', 'categorie', 86, 1)");
// Step 2: Disque Dur -> Cat 69
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (1, 'Disque Dur', 'categorie', 69, 2)");
// Step 3: Caméras Coaxiales -> Cat 84
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (1, 'Caméras de surveillance', 'categorie', 84, 3)");
// Step 4: Ecran -> Cat 74
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (1, 'Ecran de supervision', 'categorie', 74, 4)");

// Kit 2: Caméra WiFi (id=2)
// Step 1: Caméra WiFi -> Cat 83
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (2, 'Caméra WiFi', 'categorie', 83, 1)");
// Step 2: Carte Mémoire -> Cat 47
mysqli_query($conn, "INSERT INTO conf_etapes (id_kit, titre, type_lien, id_lien, ordre) VALUES (2, 'Carte Mémoire', 'categorie', 47, 2)");

echo "Data populated.";
?>
