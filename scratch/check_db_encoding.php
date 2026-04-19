<?php
include '../connec.php';
include '../_admin_site/includes/fonctions/fction_db.php';

$res = executeRequete("SHOW FULL COLUMNS FROM site_menu");
echo "<table border='1'>";
echo "<tr><th>Field</th><th>Type</th><th>Collation</th></tr>";
while($row = mysqli_fetch_assoc($res)) {
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Collation']}</td></tr>";
}
echo "</table>";

$res2 = executeRequete("SELECT @@character_set_database, @@collation_database");
$row2 = mysqli_fetch_assoc($res2);
echo "<br>DB Encoding: " . $row2['@@character_set_database'] . " / " . $row2['@@collation_database'];
?>
