<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/';

require('include.php'); // which loads connec.php

echo "Dev comment from global scope in include context: \n";
var_dump($developer_comment ?? 'NOT SET');

echo "\nPrinting raw DB value from independent query:\n";
$c = mysqli_connect('localhost', 'root', '', 'technopl_db');
$q = mysqli_query($c, 'SELECT developer_comment FROM site_configuration');
$row = mysqli_fetch_assoc($q);
var_dump($row);
?>
