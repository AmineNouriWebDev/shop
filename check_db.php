<?php
$_SERVER['SERVER_NAME'] = 'localhost';
require 'connec.php';
$res = mysqli_query($connexion, 'DESCRIBE liste_section_content');
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
