<?php
$c = mysqli_connect('localhost', 'root', '', 'technopl_db');

$update = "UPDATE `site_configuration` SET developer_comment='<!-- \n  ========================================\n  DEVELOPER INFORMATION / INFORMATIONS DÉVELOPPEUR\n  ========================================\n  Website Developer / Développeur du site : Mohamed Amine Nouri\n  Company / Société : MaxSolving\n  Contact / Email : contact@maxsolving.com\n  ======================================== \n-->'";
mysqli_query($c, $update);

$update_home = "UPDATE `optimisation_seo` SET title_home='Technoplus | L expert de la téléphonie et High-tech en Tunisie'";
mysqli_query($c, $update_home);

echo "Test data inserted.\n";

$q = mysqli_query($c, "SELECT title_home FROM `optimisation_seo`");
var_dump(mysqli_fetch_assoc($q));

$q2 = mysqli_query($c, "SELECT developer_comment FROM `site_configuration`");
var_dump(mysqli_fetch_assoc($q2));
?>
