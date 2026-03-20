<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/shop/';

ob_start();
include('include.php');
include('includes/meta.php');
$html = ob_get_clean();

echo "Dev Comment var value: (" . (isset($developer_comment) ? $developer_comment : 'NOT SET') . ")\n";
?>
