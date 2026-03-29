<?php
require("include.php");
$res = executeRequete("SELECT * FROM social_network");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['titre'] . ' | ' . $row['etat'] . ' | ' . $row['type'] . PHP_EOL;
}
unlink(__FILE__);
