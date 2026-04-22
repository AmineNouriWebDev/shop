<?php
$_POST['action'] = 'fetch_data';
$_POST['search'] = 'iphone X';

// Start output buffering to capture any errors
ob_start();
include('include.php');
include('includes/fetch_data_test.php');
$out = ob_get_clean();

file_put_contents('test_out.html', $out);
echo "SUCCESS";
