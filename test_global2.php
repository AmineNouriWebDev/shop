<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/';

require('include.php');

echo "Dev comment from global scope in index: \n";
var_dump($developer_comment);
?>
