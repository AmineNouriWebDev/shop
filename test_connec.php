<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/';

require('connec.php');

echo "Developer Comment Output:\n";
var_dump($developer_comment);
?>
