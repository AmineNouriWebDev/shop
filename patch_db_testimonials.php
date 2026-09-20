<?php
require_once __DIR__ . '/_admin_site/includes/fonctions/fction_db.php';
$cnx = ouvrirCnx();
mysqli_query($cnx, "INSERT IGNORE INTO `liste_sections` (`id`, `titre`, `etat`) VALUES (11, 'Témoignages', '1')");
echo "Inserted Testimonial section. Rows affected: " . mysqli_affected_rows($cnx);
?>
